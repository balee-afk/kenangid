<x-app-layout>
    <h2 class="font-semibold text-xl mb-6">Notifikasi Anda</h2>

    <div class="space-y-4">
        @foreach ($notifications as $notification)
            @php
                $pivot = $notification->users->first()?->pivot;
            @endphp

            <div class="relative p-4 bg-white shadow-md rounded-lg cursor-pointer transition duration-200 {{ $pivot?->is_read ? 'bg-gray-100' : 'bg-blue-50' }}"
                onclick="markAsRead(this, {{ $notification->id }})">
                @if ($pivot && !$pivot->is_read)
                    <span class="absolute top-4 right-4 w-3 h-3 bg-red-600 rounded-full"></span>
                @endif

                <h4 class="font-bold text-lg {{ $pivot?->is_read ? 'text-gray-500' : 'text-black' }}">
                    {{ $notification->title }}
                </h4>
                <p class="text-sm {{ $pivot?->is_read ? 'text-gray-500' : 'text-gray-800' }}">
                    {{ $notification->message }}
                </p>
                <small class="block text-xs text-gray-400 mt-2">
                    {{ $notification->created_at->diffForHumans() }}
                </small>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>

    <script>
        function markAsRead(cardElement, notificationId) {
            fetch(`{{ url('/notifications') }}/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hapus red dot
                    cardElement.querySelector('.absolute.top-4.right-4.w-3.h-3.bg-red-600.rounded-full')?.remove();
                    cardElement.classList.replace('bg-blue-50', 'bg-gray-100');
                }
            }).catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
