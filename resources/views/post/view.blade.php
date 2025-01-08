<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <!-- Caption -->
                    <h3 class="text-lg font-bold">{{ $post->caption }}</h3>

                    <!-- Media -->
                    @if($post->media)
                        @php
                            $extension = pathinfo($post->media, PATHINFO_EXTENSION);
                        @endphp
                        <div class="mt-4">
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                <!-- Gambar -->
                                <img src="{{ asset('storage/' . $post->media) }}" alt="Post Media" class="w-full h-auto rounded-md object-cover">
                            @elseif(strtolower($extension) === 'mp4')
                                <!-- Video -->
                                <video controls class="w-full rounded-md">
                                    <source src="{{ asset('storage/' . $post->media) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <!-- File Tidak Didukung -->
                                <p class="text-sm text-gray-500 mt-2">Unsupported media type.</p>
                            @endif
                        </div>
                    @else
                        <!-- Jika Tidak Ada Media -->
                        <p class="text-sm text-gray-500 mt-2">No media available for this post.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
