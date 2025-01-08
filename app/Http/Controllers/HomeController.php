<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KenangId;
use App\Models\StorageSize;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\NotificationModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;

            if ($usertype === 'user') {
                // Menampilkan post dengan tipe 'public' atau milik user yang sedang login (private milik user)
                $posts = KenangId::where(function ($query) {
                    $query
                        ->where('type', 'public') // Post dengan tipe public
                        ->orWhere(function ($query) {
                            $query
                                ->where('type', 'private') // Post private
                                ->where('user_id', Auth::id()); // Post private milik user yang login
                        });
                })
                    ->latest()
                    ->paginate(5); // 5 posts per page

                return view('dashboard', compact('posts'));
            } elseif ($usertype === 'admin') {
                // Admin melihat semua post tanpa filter
                $posts = KenangId::latest()->paginate(5);

                return view('admin.adminhome', compact('posts'));
            }
        }

        return redirect()->route('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3,pdf,doc,docx,txt|max:20480',
            'caption' => 'nullable|string|max:1000',
            'type' => 'required|in:public,private', // Validasi tipe
        ]);

        // Simpan file media dan dapatkan path-nya
        $mediaPath = $request->file('media') ? $request->file('media')->store('kenangid_media', 'public') : null;

        // Jika media ada, hitung ukuran file dalam bytes
        $mediaSize = $mediaPath ? filesize(storage_path('app/public/' . $mediaPath)) : 0;

        // Simpan data ke tabel KenangId
        KenangId::create([
            'id' => \Str::uuid(), // Generate UUID
            'user_id' => auth()->id(), // ID user yang sedang login
            'media' => $mediaPath, // Path media (jika ada)
            'media_size' => $mediaSize, // Ukuran media dalam bytes
            'caption' => $request->caption, // Caption yang diisi di form
            'type' => $request->type, // Menyimpan nilai type dari form
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function generateQr($id)
{
    // Ambil data postingan berdasarkan ID
    $post = KenangId::where(function ($query) {
        $query->where('user_id', Auth::id())->orWhere('type', 'public');
    })->findOrFail($id);

    // Buat URL untuk postingan
    $url = route('post.view', ['id' => $post->id]);

    // Generate QR code menggunakan URL
    $qrCode = QrCode::size(200)->generate($url);

    // Tampilkan view dengan QR code
    return view('post.qr', compact('qrCode', 'post'));
}


    public function Payment($id)
    {
        $post = KenangId::where(function ($query) {
            $query->where('user_id', Auth::id())->orWhere('type', 'public');
        })->findOrFail($id);

        $url = route('post.view', ['id' => $id]);

        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($url);

        return view('post.qr', compact('qrCode', 'post'));
    }

    public function view($id)
    {
        $post = KenangId::where(function ($query) {
            $query->where('user_id', Auth::id())->orWhere('type', 'public');
        })->findOrFail($id);

        return view('post.view', compact('post'));
    }

    public function post()
    {
        return view('post.create');
    }

    public function destroy($id)
    {
        $post = KenangId::where('user_id', Auth::id())->orWhere('usertype', 'admin')->findOrFail($id);

        // Hapus file media dari storage jika ada
        if ($post->media) {
            Storage::delete('public/' . $post->media);
        }

        // Hapus post
        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }

    public function generateQrPayment(Request $request)
    {
        $amount = $request->input('amount');
        $qrCode = QrCode::size(200)->generate("https://your-payment-gateway.com/pay?amount={$amount}");

        return response()->json(['qr_code' => $qrCode]);
    }

    // Simpan transaksi dan bukti pembayaran
    public function storeTransactions(Request $request)
    {
        $request->validate([
            'proof' => 'required|image|max:2048',
            'amount' => 'required|numeric',
            'transaction_type' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        // Simpan bukti pembayaran
        $proofPath = $request->file('proof')->store('payment_proofs', 'public');

        // Simpan transaksi
        Transaction::create([
            'user_id' => $request->user_id,
            'transaction_type' => $request->transaction_type,
            'amount' => $request->amount,
            'proof' => $proofPath,
            'transaction_date' => now(),
        ]);

        return redirect()->route('home')->with('success', 'Pembayaran berhasil!');
    }

    public function transactions()
    {
        // Get transactions for the authenticated user
        $transactions = Transaction::where('user_id', Auth::id())->latest()->paginate(5); // Paginate for better performance
    
        // Return view to show transactions
        return view('transactions', compact('transactions'));
    }
    

// Menampilkan notifikasi untuk user
public function userNotifications()
{
    $notifications = Notification::whereHas('users', function ($query) {
        $query->where('user_id', Auth::id());
    })
    ->with(['users' => function ($query) {
        $query->where('user_id', Auth::id());
    }])
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return view('notifications', compact('notifications'));
}


// Menandai notifikasi sebagai sudah dibaca
public function markAsRead($id)
{
    $notification = Notification::findOrFail($id);

    if ($notification->users()->where('user_id', auth()->id())->exists()) {
        // Update kolom `is_read` di tabel pivot
        $notification->users()->updateExistingPivot(auth()->id(), ['is_read' => true]);
    } else {
        // Jika entri belum ada, tambahkan (seharusnya tidak terjadi untuk notifikasi yang valid)
        $notification->users()->attach(auth()->id(), ['is_read' => true]);
    }

    return response()->json(['success' => true, 'message' => 'Notifikasi telah dibaca.']);
}

public function getUnreadCount()
{
    $userUnreadCount = \DB::table('notification_user')
        ->where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return response()->json(['userUnreadCount' => $userUnreadCount]);
}



public function getSidebarData()
{
    $userUnreadCount = Notification::whereHas('users', function ($query) {
        $query->where('user_id', auth()->id())->where('is_read', false);
    })
    ->orWhere(function ($query) {
        $query
            ->whereNull('user_id') // Broadcast
            ->whereHas('users', function ($subQuery) {
                $subQuery->where('user_id', auth()->id())->where('is_read', false);
            });
    })
    ->count();

    return response()->json(['userUnreadCount' => $userUnreadCount]);
}




}
