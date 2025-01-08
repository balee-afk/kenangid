<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Laporan Transaksi ({{ ucfirst($reportType) }})</h1>

                    <!-- Pilihan Laporan -->
                    <div class="mb-4">
                        <a href="{{ route('admin.transactions', ['type' => 'weekly']) }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg">Mingguan</a>
                        <a href="{{ route('admin.transactions', ['type' => 'monthly']) }}"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg">Bulanan</a>
                        <a href="{{ route('admin.transactions', ['type' => 'yearly']) }}"
                            class="px-4 py-2 bg-purple-500 text-white rounded-lg">Tahunan</a>
                    </div>

                    <!-- Tombol untuk Mengunduh Laporan sebagai PDF -->
                    <div class="mb-4">
                        <a href="{{ route('admin.transactions', ['type' => $reportType, 'download_pdf' => true]) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                            Unduh Laporan PDF
                        </a>
                    </div>

                    <!-- Tabel Laporan -->
                    <table class="table-auto w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nomor</th>
                                <th class="px-4 py-2">Jumlah</th>
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Bukti Pembayaran</th>
                                <th class="px-4 py-2">Status</th> <!-- Tambahkan kolom Status -->
                                <th class="px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="border px-4 py-2">{{ $transaction->id }}</td>
                                    <td class="border px-4 py-2">Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">{{ $transaction->created_at->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2">
                                        @if ($transaction->proof)
                                            <img src="{{ asset('storage/' . $transaction->proof) }}" alt="Bukti"
                                                width="100">
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ ucfirst($transaction->status) }} <!-- Tampilkan status transaksi -->
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if ($transaction->status === 'pending')
                                            <form action="{{ route('admin.transactions.accept', $transaction->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-green-500 text-white rounded-lg">Acc</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Acced</span>
                                            <!-- Jika sudah diterima, tidak perlu tombol -->
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    @if ($transactions->isEmpty())
                        <p class="mt-4 text-red-500">Tidak ada transaksi pada periode ini.</p>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 text-white p-4 mb-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
