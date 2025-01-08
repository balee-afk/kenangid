<div id="addModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Tambah Pengguna</h2>
        <form action="{{ route('admin.storeUser') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" id="name" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('addModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
