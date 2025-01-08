<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
            <!-- Seksi Transaksi -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">
                    <h3 class="text-xl font-semibold mb-4">Transaksi Anda</h3>
                    <!-- Daftar Transaksi -->
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">#</th> <!-- Kolom nomor urut -->
                                <th class="px-4 py-2 text-left">Jumlah</th>
                                <th class="px-4 py-2 text-left">Tipe Transaksi</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $index => $transaction) <!-- Menggunakan $index untuk penomoran urut -->
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $transactions->firstItem() + $index }}</td> <!-- Menampilkan nomor urut -->
                                <td class="px-4 py-2">Rp {{ number_format($transaction->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ ucfirst($transaction->transaction_type) }}</td>
                                <td class="border px-4 py-2">{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td class="border px-4 py-2">
                                    @if ($transaction->proof)
                                        <img src="{{ asset('storage/' . $transaction->proof) }}" alt="Bukti"
                                            width="100">
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginasi -->
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
