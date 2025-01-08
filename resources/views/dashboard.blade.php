<x-app-layout>
    <!-- Main Content -->
    <div class="space-y-6">
        <!-- Post Box -->
        <div class="bg-white rounded-2xl shadow-lg">
            <!-- Post Form -->
            <div class="p-6 bg-white rounded-xl shadow-md">
                @php
                    // Ambil ID pengguna yang sedang login
                    $userId = auth()->id();

                    // Ambil total current_size yang aktif (belum expired)
                    $totalStorage = \App\Models\StorageSize::where('user_id', $userId)
                        ->where('expiry_date', '>=', now()) // Pastikan expiry_date belum lewat
                        ->sum('current_size'); // Menjumlahkan current_size dari semua storage yang aktif

                    // Konversi totalStorage (GB) ke MB (1 GB = 1024 MB)
                    $maxAllowed = $totalStorage * 1024; // totalStorage dalam MB (asumsi current_size dalam GB)

                    // Hitung total ukuran media yang sudah diposting oleh user
                    $totalUsed = \App\Models\KenangId::where('user_id', $userId)
                        ->whereNotNull('media') // Pastikan media tidak null
                        ->sum('media_size'); // Total ukuran media yang sudah diposting dalam byte

                    // Konversi totalUsed (bytes) ke MB (1 MB = 1024 * 1024 bytes)
                    $totalUsedMB = $totalUsed / 1024; // Konversi byte ke MB

                    // Hitung sisa storage yang tersedia
                    $remaining = max(0, $maxAllowed - $totalUsedMB); // Sisa storage yang tersedia
                @endphp



                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                    @if ($remaining <= 0) style="pointer-events: none; opacity: 0.6;" @endif>
                    @csrf

                    <!-- User Avatar & Caption -->
                    <div class="flex items-start space-x-4">
                        <img class="w-12 h-12 rounded-full object-cover" src="{{ asset('logo-people.png') }}"
                            alt="User Avatar" />
                        <div class="flex-1">
                                @csrf
                                <textarea name="caption" rows="3" placeholder="Apa yang sedang Anda pikirkan?"
                                    class="w-full bg-gray-100 rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </div>
                    </div>


                    <!-- Garis Pembatas -->
                    <hr class="border-t border-gray-200" />

                    <!-- Pilihan Public atau Private -->
                    <div class="flex space-x-4 items-center">
                        <label class="flex items-center space-x-2 text-gray-700 text-sm">
                            <input type="radio" name="type" value="public" checked
                                class="form-radio focus:ring-blue-400">
                            <span>Public</span>
                        </label>
                        <label class="flex items-center space-x-2 text-gray-700 text-sm">
                            <input type="radio" name="type" value="private" class="form-radio focus:ring-blue-400">
                            <span>Private</span>
                        </label>
                    </div>

                    <!-- Garis Pembatas -->
                    <hr class="border-t border-gray-200" />

                    <!-- Preview Media (only show when media is selected) -->
                    <div id="media-preview" class="rounded-lg overflow-hidden" style="display: none;"></div>

                    <!-- Pilih Media & Tombol Posting -->
                    <div class="flex items-center justify-between">
                        <label for="media-upload"
                            class="flex items-center space-x-2 cursor-pointer text-blue-500 hover:text-blue-700 font-medium text-sm">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-5l4 2.5-4 2.5z"
                                    fill="currentColor" />
                            </svg>
                            <span>Pilih Media</span>
                            <input id="media-upload" type="file" name="media"
                                accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.txt" class="hidden"
                                onchange="showPreview(event)" @if ($remaining <= 0) disabled @endif />
                        </label>

                        <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white font-semibold text-sm rounded-lg shadow hover:bg-blue-600"
                            @if ($remaining <= 0) disabled @endif>
                            Posting
                        </button>
                    </div>
                </form>

            </div>

            <!-- Script untuk Preview Media -->
            <script>
                // Function to show the media preview dynamically
                function showPreview(event) {
                    const mediaPreview = document.getElementById('media-preview');
                    const file = event.target.files[0];

                    // Clear previous preview
                    mediaPreview.innerHTML = '';

                    // Check if the file is selected and show the appropriate preview
                    if (file) {
                        mediaPreview.style.display = 'block'; // Show the preview section

                        const fileType = file.type.split('/')[0];
                        const fileURL = URL.createObjectURL(file);

                        if (fileType === 'image') {
                            mediaPreview.innerHTML =
                                `<img src="${fileURL}" alt="Preview" class="w-full h-64 object-cover rounded-lg">`;
                        } else if (fileType === 'video') {
                            mediaPreview.innerHTML =
                                `<video controls class="w-full h-64 rounded-lg"><source src="${fileURL}" type="${file.type}"></video>`;
                        } else if (fileType === 'audio') {
                            mediaPreview.innerHTML =
                                `<audio controls class="w-full mt-2"><source src="${fileURL}" type="${file.type}"></audio>`;
                        } else {
                            mediaPreview.innerHTML = `<p class="text-gray-500 text-sm">Preview tidak tersedia untuk file ini.</p>`;
                        }
                    } else {
                        mediaPreview.style.display = 'none'; // Hide preview if no file is selected
                    }
                }
            </script>





        </div>

        <!-- Posts -->
        <div class="space-y-4">
            @foreach ($posts as $post)
                <div class="p-4 bg-white rounded-2xl shadow flex items-start space-x-4">
                    <!-- User Avatar -->
                    <img class="w-16 h-16 rounded-full" src="{{ asset('logo-people.png') }}" alt="User Avatar" />

                    <!-- Post Content -->
                    <div class="flex-1 flex flex-col">
                        <!-- Post Header -->
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <p class="text-lg font-bold text-black">
                                    {{ $post->user ? $post->user->name : 'User not found' }}</p>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex items-center space-x-2">
                                @if ($post->type == 'public')
                                    <!-- Share Button (only for public posts) -->
                                    <a href="{{ route('post.qr', $post->id) }}"
                                        class="text-[#1146ab] text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-blue-600 cursor-pointer" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 12v7a2 2 0 002 2h12a2 2 0 002-2v-7M16 5l-4-4m0 0L8 5m4-4v16" />
                                        </svg>
                                    </a>
                                @else
                                    <!-- Share Disabled for Private Posts -->
                                    <span class="text-gray-500 text-sm">Private</span>
                                @endif

                                <!-- Delete Button (only for the post owner or admin) -->
                                @if (Auth::id() === $post->user_id || Auth::user()->usertype === 'admin')
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-sm font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-red-500 cursor-pointer" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Post Caption -->
                        <p class="text-gray-700 mb-4 line-clamp-3">{{ $post->caption }}</p>

                        <!-- Post Media -->
                        @if ($post->media)
                            @php
                                $extension = pathinfo($post->media, PATHINFO_EXTENSION);
                            @endphp
                            <div class="mt-2 group">
                                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Single Image -->
                                    <img src="{{ asset('storage/' . $post->media) }}"
                                        class="w-full h-[600px] object-cover rounded-lg cursor-pointer"
                                        alt="Post Media" />
                                    <a href="{{ asset('storage/' . $post->media) }}" download
                                        class="mt-2 text-blue-600 text-sm font-medium">Download</a>
                                @elseif (strtolower($extension) === 'mp4')
                                    <!-- Video -->
                                    <video controls class="w-full h-[600px] rounded-lg cursor-pointer"
                                        onclick="openFullScreen('video', '{{ asset('storage/' . $post->media) }}')">
                                        <source src="{{ asset('storage/' . $post->media) }}" type="video/mp4">
                                    </video>
                                    <a href="{{ asset('storage/' . $post->media) }}" download
                                        class="mt-2 text-blue-600 text-sm font-medium">Download Video</a>
                                @elseif (strtolower($extension) === 'mp3')
                                    <!-- Audio -->
                                    <audio controls class="w-full mt-2">
                                        <source src="{{ asset('storage/' . $post->media) }}" type="audio/mp3">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <a href="{{ asset('storage/' . $post->media) }}" download
                                        class="mt-2 text-blue-600 text-sm font-medium">Download Audio</a>
                                @elseif (in_array(strtolower($extension), ['pdf', 'doc', 'docx', 'txt']))
                                    <!-- Document -->
                                    <div class="p-4 bg-gray-100 rounded-lg">
                                        <p class="text-gray-800 font-medium">Dokumen: {{ basename($post->media) }}</p>
                                        <a href="{{ asset('storage/' . $post->media) }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            Lihat Dokumen
                                        </a>
                                    </div>
                                    <a href="{{ asset('storage/' . $post->media) }}" download
                                        class="mt-2 text-blue-600 text-sm font-medium">Download Document</a>
                                @else
                                    <!-- Unknown Format -->
                                    <p class="text-red-500">Format file tidak didukung.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>



        <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
