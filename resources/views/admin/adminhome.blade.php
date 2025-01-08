<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistik Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-500">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Transaksi</h3>
                    <p class="text-3xl font-bold text-green-500">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-700">Total Penyimpanan</h3>
                    <p class="text-3xl font-bold text-purple-500">{{ $totalStorageUsed/1024 }} GB</p>
                </div>
            </div>

            <!-- Grafik Dinamis -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Transaksi Bulanan</h3>
                <canvas id="transactionsChart"></canvas>
            </div>

            <!-- Notifikasi Terbaru -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Notifikasi Terbaru</h3>
                <ul class="space-y-4">
                    @foreach ($recentNotifications as $notification)
                        <li class="p-4 bg-gray-100 rounded-lg shadow">
                            <h4 class="font-bold text-gray-700">{{ $notification->title }}</h4>
                            <p class="text-gray-600">{{ $notification->message }}</p>
                            <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionsChart').getContext('2d');
        const transactionsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($transactionLabels) !!}, // Bulan
                datasets: [{
                    label: 'Total Transaksi',
                    data: {!! json_encode($transactionData) !!}, // Data jumlah transaksi
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Transaksi'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
