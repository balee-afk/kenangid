<div id="notificationModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Tambah Notifikasi</h2>
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="title" id="title" class="w-full mt-1 p-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea name="message" id="message" rows="4" class="w-full mt-1 p-2 border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Penerima</label>
                <select name="user_id" id="user_id" class="w-full mt-1 p-2 border rounded-md">
                    <option value="">Semua Pengguna</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="toggleModal('notificationModal')" class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<button class="px-4 py-2 bg-blue-600 text-white rounded-md" onclick="toggleModal('notificationModal')">Tambah Notifikasi</button>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
