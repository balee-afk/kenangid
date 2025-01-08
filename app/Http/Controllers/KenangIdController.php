<?php

namespace App\Http\Controllers;

use App\Models\KenangId;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KenangIdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = KenangId::where('user_id', Auth::id())->latest()->get();
        return view('kenangid.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kenangid.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp3,mp4|max:20480',
            'caption' => 'nullable|string|max:1000',
            'type' => 'required|in:privacy,public',
        ]);

        $mediaPath = $request->file('media') ? $request->file('media')->store('kenangid_media', 'public') : null;

        KenangId::create([
            'id' => Str::uuid(),
            'user_id' => Auth::id(),
            'media' => $mediaPath,
            'caption' => $request->caption,
            'type' => $request->type,
        ]);

        return redirect()->route('kenangid.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KenangId $kenangId)
    {
        return view('kenangid.show', compact('kenangId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KenangId $kenangId)
    {
        return view('kenangid.edit', compact('kenangId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KenangId $kenangId)
    {
        $this->authorize('update', $kenangId);

        $request->validate([
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp3,mp4|max:20480',
            'caption' => 'nullable|string|max:1000',
            'type' => 'required|in:privacy,public',
        ]);

        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('kenangid_media', 'public');
            $kenangId->update(['media' => $mediaPath]);
        }

        $kenangId->update($request->only('caption', 'type'));

        return redirect()->route('kenangid.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KenangId $kenangId)
    {
        $this->authorize('delete', $kenangId);
        $kenangId->delete();

        return redirect()->route('kenangid.index')->with('success', 'Post deleted successfully!');
    }
}
