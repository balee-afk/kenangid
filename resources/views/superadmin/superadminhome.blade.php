<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Statistik Dashboard</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Jumlah Pengguna -->
                        <div class="p-4 bg-blue-100 rounded-lg shadow">
                            <h2 class="text-lg font-bold text-blue-800">Jumlah Pengguna</h2>
                            <p class="text-2xl text-blue-600">{{ $totalUsers }}</p>
                            <p class="text-sm text-blue-500">Admin: {{ $totalAdmins }}, Superadmin: {{ $totalSuperadmins }}</p>
                        </div>

                        <!-- Jumlah Transaksi -->
                        <div class="p-4 bg-green-100 rounded-lg shadow">
                            <h2 class="text-lg font-bold text-green-800">Total Transaksi</h2>
                            <p class="text-2xl text-green-600">{{ $totalTransactions }}</p>
                            <p class="text-sm text-green-500">Total Nilai: Rp {{ number_format($totalTransactionAmount, 0, ',', '.') }}</p>
                        </div>

                        <!-- Statistik Penyimpanan -->
                        <div class="p-4 bg-purple-100 rounded-lg shadow">
                            <h2 class="text-lg font-bold text-purple-800">Penyimpanan</h2>
                            <p class="text-2xl text-purple-600">{{ number_format($totalStorageUsed / 1024, 2) }} GB</p>
                            <p class="text-sm text-purple-500">Rata-rata: {{ number_format($averageStorageUsed / 1024, 2) }} GB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
