<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('QR Code for Post') }}
        </h2>
    </x-slot>

    <div class="p-0">
        <div class="">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('home') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7M5 12h14" />
                        </svg>
                        Back
                    </a>
                    <div class="flex justify-center">
                        {!! $qrCode !!}
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">Scan QR Code untuk mengakses post ini</p>
                        <p class="text-sm text-gray-500">Post ID: {{ $post->id }}</p>
                    </div>
                    <!-- Back Button -->
                    <div class="mt-4 text-center">
                        <h3 class="text-lg font-bold mb-4">{{ $post->caption }}</h3>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
