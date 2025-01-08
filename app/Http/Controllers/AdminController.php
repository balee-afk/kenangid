<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\StorageSize;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        // Statistik Jumlah Pengguna
        $totalUsers = User::count();
        $totalAdmins = User::where('usertype', 'admin')->count();
        $totalSuperadmins = User::where('usertype', 'superadmin')->count();
    
        // Statistik Transaksi
        $totalTransactions = Transaction::count();
        $totalTransactionAmount = Transaction::sum('amount');
    
        // Statistik Penyimpanan
        $totalStorageUsed = StorageSize::sum('current_size'); // Total penyimpanan (GB)
        $averageStorageUsed = $totalUsers > 0 ? StorageSize::avg('current_size') : 0; // Rata-rata penyimpanan (GB)
    
        // Data untuk Grafik Transaksi Bulanan
        $transactionLabels = [];
        $transactionData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(null, $i)->format('F');
            $transactionLabels[] = $month;
            $transactionData[] = Transaction::whereMonth('created_at', $i)->count();
        }
    
        // Notifikasi Terbaru
        $recentNotifications = Notification::latest()->take(5)->get();
    
        return view('admin.adminhome', compact(
            'totalUsers',
            'totalAdmins',
            'totalSuperadmins',
            'totalTransactions',
            'totalTransactionAmount',
            'totalStorageUsed',
            'averageStorageUsed',
            'transactionLabels',
            'transactionData',
            'recentNotifications'
        ));
    }
    
    

    // Kelola Pengguna
    public function manageUsers()
    {
        $users = User::where('usertype', 'user')->paginate(10);
        return view('admin.manage-users', compact('users'));
    }

    public function addUser()
    {
        return view('admin.add-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'user',
        ]);

        StorageSize::create([
            'user_id' => $user->id,
            'current_size' => 1024, // Default 1GB
            'purchase_date' => now(),
            'expiry_date' => now()->addYear(),
        ]);

        // Kirim notifikasi ke pengguna baru
        Notification::create([
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'title' => 'Selamat Datang!',
            'message' => 'Akun Anda telah berhasil dibuat.',
            'is_read' => false,
        ]);

        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function viewUser($id)
    {
        $user = User::findOrFail($id);

        return view('admin.view-user', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Perbarui data pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->usertype !== 'user') {
            return redirect()->route('admin.manageUsers')->with('error', 'Anda hanya dapat menghapus pengguna dengan tipe "user".');
        }

        // Delete associated storage size
        StorageSize::where('user_id', $user->id)->delete();

        $user->delete();
        return redirect()->route('admin.manageUsers')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function transactions(Request $request)
    {
        $reportType = $request->get('type', 'monthly'); // Default: monthly
        $transactions = [];

        switch ($reportType) {
            case 'weekly':
                $transactions = Transaction::where('created_at', '>=', Carbon::now()->subWeek())->get();
                break;
            case 'monthly':
                $transactions = Transaction::where('created_at', '>=', Carbon::now()->subMonth())->get();
                break;
            case 'yearly':
                $transactions = Transaction::where('created_at', '>=', Carbon::now()->subYear())->get();
                break;
        }

        // Generate PDF
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('admin.transactions_pdf', compact('transactions', 'reportType'));
            return $pdf->download('laporan_transaksi_' . $reportType . '.pdf');
        }

        return view('admin.transactions', compact('transactions', 'reportType'));
    }

    public function acceptTransaction($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->status === 'accepted') {
            return redirect()->route('admin.transactions')->with('error', 'Transaksi ini sudah diterima.');
        }

        $user = $transaction->user;
        $newStorageSize = $transaction->amount;

        StorageSize::create([
            'user_id' => $user->id,
            'current_size' => $newStorageSize,
            'purchase_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addMonths(3),
        ]);

        $transaction->status = 'accepted';
        $transaction->save();

        // Kirim notifikasi ke pengguna terkait transaksi
        Notification::create([
            'admin_id' => auth()->id(),
            'user_id' => $user->id,
            'title' => 'Transaksi Diterima',
            'message' => 'Transaksi Anda telah diterima dan penyimpanan Anda diperbarui.',
            'is_read' => false,
        ]);

        return redirect()->route('admin.transactions')->with('success', 'Transaksi diterima dan storage diperpanjang.');
    }

    // Menampilkan semua notifikasi
    public function notifications()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(10);
        $users = User::where('usertype', 'user')->get(); // Ambil semua pengguna tipe user
        return view('admin.notifications', compact('notifications', 'users'));
    }
    
    // Form untuk membuat notifikasi baru
    public function createNotification()
    {
        $users = User::where('usertype', 'user')->get(); // Ambil semua pengguna dengan tipe 'user'
        return response()->json(['users' => $users]);
    }
    

    // Menyimpan notifikasi baru
    public function storeNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id', // NULL berarti broadcast
        ]);
    
        // Pastikan admin_id menggunakan ID admin yang sedang login atau null
        $adminId = auth()->check() ? auth()->id() : null;
    
        $notification = Notification::create([
            'admin_id' => $adminId, // Isi admin_id dengan ID admin yang sedang login
            'title' => $request->title,
            'message' => $request->message,
        ]);
    
        if ($request->user_id) {
            // Notifikasi untuk pengguna spesifik
            $notification->users()->attach($request->user_id, ['is_read' => false]);
        } else {
            // Broadcast: Tambahkan untuk semua pengguna
            $users = User::all();
            foreach ($users as $user) {
                $notification->users()->attach($user->id, ['is_read' => false]);
            }
        }
    
        return redirect()->route('admin.notifications')->with('success', 'Notifikasi berhasil dikirim.');
    }
    

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications')->with('success', 'Notifikasi berhasil dihapus.');
    }

    // Memperbarui notifikasi
    public function updateNotification(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ]);
    
        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
        ]);
    
        return redirect()->route('admin.notifications')->with('success', 'Notifikasi berhasil diperbarui.');
    }
    

    public function editNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $users = User::where('usertype', 'user')->get(); // Ambil semua pengguna
        return response()->json(['notification' => $notification, 'users' => $users]);
    }
    
    

}
