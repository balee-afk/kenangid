<div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-40 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Hapus Pengguna</h2>
        <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="closeModal('deleteModal')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</button>
            <form action="#" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg">Hapus</button>
            </form>
        </div>
    </div>
</div>
