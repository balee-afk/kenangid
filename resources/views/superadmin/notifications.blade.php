<x-app-layout>
    <h2 class="font-semibold text-xl mb-4">Kelola Notifikasi</h2>

    <!-- Tombol Tambah Notifikasi -->
    <button class="mb-4 px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded hover:bg-blue-700 focus:outline-none"
        onclick="openNotificationModal()">
        Tambah Notifikasi
    </button>

    <!-- Modal Tambah/Edit Notifikasi -->
    <div id="notificationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Notifikasi</h3>

            <!-- Form Tambah/Edit Notifikasi -->
            <form id="notificationForm" method="POST">
                @csrf
                <input type="hidden" id="notificationId" name="id">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" class="w-full p-2 border rounded-md mt-1"
                        required>
                </div>

                <div class="mb-4">
                    <label for="message" class="block text-sm font-semibold text-gray-700">Pesan</label>
                    <textarea name="message" id="message" class="w-full p-2 border rounded-md mt-1" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-semibold text-gray-700">Penerima</label>
                    <select name="user_id" id="user_id" class="w-full p-2 border rounded-md mt-1">
                        <option value="">Semua Pengguna</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeNotificationModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Notifikasi -->
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Judul</th>
                <th class="border border-gray-300 px-4 py-2">Pesan</th>
                <th class="border border-gray-300 px-4 py-2">Penerima</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $index => $notification)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $notification->title }}</td>
                    <td class="border border-gray-300 px-4 py-2 truncate max-w-xs">{{ $notification->message }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $notification->user->name ?? 'Semua Pengguna' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 flex space-x-2">
                        <button onclick="openNotificationModal({{ json_encode($notification) }})"
                            class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit</button>
                        <form action="{{ route('admin.notifications.delete', $notification->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

    <!-- Script Modal -->
    <script>
        function openNotificationModal(notification = null) {
            const modalTitle = document.getElementById('modalTitle');
            const notificationForm = document.getElementById('notificationForm');
            const notificationId = document.getElementById('notificationId');
            const userSelect = document.getElementById('user_id');

            // Reset form
            notificationForm.reset();
            notificationId.value = '';

            if (notification) {
                modalTitle.textContent = 'Edit Notifikasi';
                notificationForm.action = `/admin/notifications/${notification.id}/update`;

                document.getElementById('title').value = notification.title;
                document.getElementById('message').value = notification.message;

                fetch('/admin/notifications/create')
                    .then(response => response.json())
                    .then(data => {
                        userSelect.innerHTML = '<option value="">Semua Pengguna</option>';
                        data.users.forEach(user => {
                            const selected = user.id === notification.user_id ? 'selected' : '';
                            userSelect.innerHTML += `<option value="${user.id}" ${selected}>${user.name}</option>`;
                        });
                    });
            } else {
                modalTitle.textContent = 'Tambah Notifikasi';
                notificationForm.action = '{{ route('admin.notifications.store') }}';

                fetch('/admin/notifications/create')
                    .then(response => response.json())
                    .then(data => {
                        userSelect.innerHTML = '<option value="">Semua Pengguna</option>';
                        data.users.forEach(user => {
                            userSelect.innerHTML += `<option value="${user.id}">${user.name}</option>`;
                        });
                    });
            }

            document.getElementById('notificationModal').classList.remove('hidden');
        }

        function closeNotificationModal() {
            document.getElementById('notificationModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
