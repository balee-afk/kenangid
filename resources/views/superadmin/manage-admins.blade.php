<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Daftar Admin</h1>
                    <!-- Tambah Admin -->
                    <button onclick="openModal('addModal')" class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Admin
                    </button>

                    <!-- Tabel Admin -->
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp <!-- Variabel nomor urut -->
                            @foreach ($admins as $admin)
                                <tr>
                                    <td class="border px-4 py-2">{{ $no++ }}</td> <!-- Menampilkan nomor urut -->
                                    <td class="border px-4 py-2">{{ $admin->name }}</td>
                                    <td class="border px-4 py-2">{{ $admin->email }}</td>
                                    <td class="border px-4 py-2 flex space-x-2">
                                        <!-- Detail -->
                                        <button onclick="openModal('detailModal', {{ $admin }})" class="text-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12h4M15 16h2M15 8h1M4 8h5l2 3m5-5h2" />
                                            </svg>
                                        </button>
                                        <!-- Edit -->
                                        <button onclick="openModal('editModal', {{ $admin }})" class="text-yellow-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17.53V20h2v-2.47m5.7-5.7L20 13m-8-3.6L8.3 15H3v2h6.4l4-7.8m5.6 1.3l2.3-2.3c.2-.2.3-.5.3-.8v0c0-.3-.1-.6-.3-.8L16.2 3c-.2-.2-.5-.3-.8-.3h0c-.3 0-.6.1-.8.3l-2.3 2.3m6.2 6.2z" />
                                            </svg>
                                        </button>
                                        <!-- Hapus -->
                                        <button onclick="openModal('deleteModal', {{ $admin->id }})" class="text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6M6 6l12 12m0-12L6 18" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Templates -->
    <x-modal.add />
    <x-modal.edit />
    <x-modal.detail />
    <x-modal.delete />

    <script>
        function openModal(modalId, data = null) {
            if (data) {
                populateModalData(modalId, data);
            }
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function populateModalData(modalId, data) {
            const modal = document.getElementById(modalId);
            Object.keys(data).forEach(key => {
                const field = modal.querySelector(`[name="${key}"]`);
                if (field) field.value = data[key];
            });
        }
    </script>
</x-app-layout>
