<div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Pengguna</h2>
        <form action="#" method="POST">
            @csrf
            @method('POST')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Nama</label>
                <input type="text" name="name" id="name" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-1 rounded-lg border-gray-300">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('editModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div>
</div>
