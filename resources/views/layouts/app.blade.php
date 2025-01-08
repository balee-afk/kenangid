<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kenangid') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f7f7f7]">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div
            class="hidden lg:block w-1/4 p-6 bg-white rounded-2xl shadow-lg sticky top-0 h-screen overflow-y-auto space-y-6">
            <!-- User Info -->
            <div class="mt-auto">
                <img class="w-full" src="{{ asset('logo-sidebar.png') }}" alt="Logo">
            </div>

            <div class="flex items-center space-x-4">
                <img class="w-12 h-12 rounded-full" src="{{ asset('logo-people.png') }}" alt="User Avatar" />
                <div>
                    <p class="text-black font-bold text-lg">{{ Auth::user()->name }}</p>
                </div>
            </div>

            <!-- Sidebar Content Based on User Type -->
            <nav class="space-y-2">
                @if (Auth::user()->usertype === 'superadmin')
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="grid"></i>
                        <span>Dashboard Admin</span>
                    </a>
                    <a href="{{ route('superadmin.manageAdmins') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('superadmin.manageAdmins') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i data-feather="credit-card"></i>
                    <span>Kelola Admin</span>
                </a>
                    <a href="{{ route('superadmin.manageUsers') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('superadmin.manageUsers') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="users"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                    <a href="{{ route('superadmin.transactions') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('superadmin.transactions') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="credit-card"></i>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('superadmin.notifications') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('admin.notifications') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i data-feather="bell"></i>
                    <span>Notifikasi</span>
                </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="user"></i>
                        <span>Profil</span>
                    </a>
                @elseif (Auth::user()->usertype === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="grid"></i>
                        <span>Dashboard Admin</span>
                    </a>
                    <a href="{{ route('admin.manageUsers') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('admin.manageUsers') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="users"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                    
                    <a href="{{ route('admin.transactions') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('admin.transactions') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="credit-card"></i>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('admin.notifications') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('admin.notifications') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="bell"></i>
                        <span>Notifikasi</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="user"></i>
                        <span>Profil</span>
                    </a>
                @elseif (Auth::user()->usertype === 'user')
                @php
                    // Ambil ID pengguna yang sedang login
                    $userId = auth()->id();

                    // Ambil total current_size yang aktif (belum expired)
                    $totalStorage = \App\Models\StorageSize::where('user_id', $userId)
                        ->where('expiry_date', '>=', now()) // Pastikan expiry_date belum lewat
                        ->sum('current_size'); // Menjumlahkan current_size dari semua storage yang aktif

                    // Konversi totalStorage (GB) ke MB (1 GB = 1024 MB)
                    $maxAllowed = $totalStorage * 1024; // totalStorage dalam MB (asumsi current_size dalam GB)

                    // Hitung total ukuran media yang sudah diposting oleh user
                    $totalUsed = \App\Models\KenangId::where('user_id', $userId)
                        ->whereNotNull('media') // Pastikan media tidak null
                        ->sum('media_size'); // Total ukuran media yang sudah diposting dalam byte

                    // Konversi totalUsed (bytes) ke MB (1 MB = 1024 * 1024 bytes)
                    $totalUsedMB = $totalUsed / 1024; // Konversi byte ke MB

                    // Hitung sisa storage yang tersedia
                    $remaining = max(0, $maxAllowed - $totalUsedMB); // Sisa storage yang tersedia
                    $usedPercentage = min(100, ($totalUsedMB / $maxAllowed) * 100); // Persentase penggunaan storage

                    // Membulatkan ke GB
                    $maxAllowedGB = round($maxAllowed / 1024, 2); // Membulatkan maxAllowed ke GB
                    $totalUsedGB = round($totalUsedMB / 1024, 2); // Membulatkan totalUsed ke GB
                    $remainingGB = round($remaining / 1024, 2); // Membulatkan remaining ke GB
                @endphp
     <div class="mt-4">
        @php
            // Hitung persentase penggunaan
            $percentageUsed = $remainingGB > 0 ? ($totalUsedGB / $remainingGB) * 100 : 0;
        @endphp
        <p class="text-xs text-gray-500 mb-1">
            {{ number_format($totalUsedGB, 2) }} MB dari {{ number_format($remainingGB, 2) }} MB sudah
            digunakan
        </p>
        <div class="w-full bg-gray-200 h-2 rounded-full">
            <div class="bg-blue-600 h-2 rounded-full"
                style="width: {{ $percentageUsed > 100 ? '100%' : $percentageUsed . '%' }};">
            </div>
        </div>
    </div>

    <!-- Button -->

    <!-- Button to Buy More Storage -->
    <button class="px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl w-full"
        data-modal-toggle="buy-storage-modal">
        Beli Penyimpanan
    </button>
                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="search"></i>
                        <span>Jelajah</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="user"></i>
                        <span>Profil</span>
                    </a>
               
                    <!-- Modal for Buying Storage -->
                    <div id="buy-storage-modal"
                        class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
                        <!-- Modal memilih penyimpanan -->
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96 ">
                            <h3 class="text-lg font-semibold text-center mb-4">Beli Penyimpanan</h3>
                            <p class="text-sm text-gray-700 mb-4">Tambah kapasitas penyimpanan Anda untuk lebih banyak file.
                                Pilih jumlah penyimpanan yang ingin dibeli.</p>
    
                            <!-- Options for Buying Storage -->
                            <div class="space-y-4">
                                <button class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg" data-size="1"
                                    data-price="10000">
                                    10 GB - Rp 10,000 - 3 Bulan
                                </button>
                                <button class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg" data-size="5"
                                    data-price="40000">
                                    40 GB - Rp 40,000 - 3 Bulan
                                </button>
                                <button class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg" data-size="10"
                                    data-price="70000">
                                    70 GB - Rp 70,000 - 3 Bulan
                                </button>
                            </div>
    
                            <!-- Close Modal Button -->
                            <button id="close-modal"
                                class="mt-4 w-full py-2.5 bg-gray-600 text-white font-semibold rounded-lg">
                                Tutup
                            </button>
                        </div>
                    </div>
    
                    <div id="payment-modal"
                        class="hidden fixed inset-0 bg-gray-800 bg-opacity-50  justify-center items-center ">
                        <!-- Modal QR dan Form Bukti Pembayaran -->
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                            <h3 class="text-lg font-semibold text-center mb-4">Pembayaran Penyimpanan</h3>
                            <div class="text-center mb-4">
                                <p class="text-gray-700">Pilih jumlah penyimpanan yang akan dibeli: <span
                                        id="storage-size"></span></p>
                                <img id="qr-code" src="" alt="QR Code" class="mx-auto mb-4" />
                                <p class="text-sm text-gray-500 mb-4">Scan QR untuk melakukan pembayaran.</p>
                            </div>
    
                            <!-- Form Bukti Pembayaran -->
                            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="amount" id="amount">
                                <input type="hidden" name="transaction_type" value="storage_purchase">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    
                                <div class="mb-4">
                                    <label for="proof" class="block text-sm font-semibold text-gray-700">Bukti
                                        Pembayaran</label>
                                    <input type="file" name="proof" id="proof" accept="image/*"
                                        class="w-full p-2 border rounded-md mt-1" required>
                                </div>
    
                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                        class="py-2.5 px-6 bg-green-600 text-white font-semibold rounded-lg">Kirim
                                        Bukti</button>
                                    <button type="button" id="back-to-choose"
                                        class="py-2.5 px-6 bg-gray-600 text-white font-semibold rounded-lg">Kembali</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('transactions') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('transactions') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i data-feather="credit-card"></i>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('user.notifications') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('user.notifications') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i data-feather="bell"></i>
                    <span>Notifikasi</span>
                    @if ($userUnreadCount > 0)
                        <span class="ml-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">{{ $userUnreadCount }}</span>
                    @endif
                </a>
                
                @endif
            </nav>
            <script>
                // Mengatur modal dan QR
                document.querySelectorAll('#buy-storage-modal button').forEach(button => {
                    button.addEventListener('click', function() {
                        const size = this.getAttribute('data-size');
                        const price = this.getAttribute('data-price');
                        const qrUrl =
                        `/payment/qr?amount=${price}`; // Ganti URL dengan rute yang sesuai untuk menghasilkan QR

                        // Menampilkan modal QR dan form bukti pembayaran
                        document.getElementById('buy-storage-modal').classList.add('hidden');
                        document.getElementById('payment-modal').classList.remove('hidden');

                        // Set storage size dan harga di QR
                        document.getElementById('storage-size').textContent = `${size} GB - Rp ${price}`;
                        document.getElementById('amount').value = price;

                        // Generate QR Code
                        document.getElementById('qr-code').src = qrUrl; // Pastikan URL ini menghasilkan QR code
                    });
                });

                // Menutup modal atau kembali ke pilihan penyimpanan
                document.getElementById('close-modal').addEventListener('click', function() {
                    document.getElementById('buy-storage-modal').classList.add('hidden');
                });

                document.getElementById('back-to-choose').addEventListener('click', function() {
                    document.getElementById('payment-modal').classList.add('hidden');
                    document.getElementById('buy-storage-modal').classList.remove('hidden');
                });
            </script>
            <!-- Script to toggle modal visibility -->
            <script>
                const modal = document.getElementById('buy-storage-modal');
                const closeModalBtn = document.getElementById('close-modal');

                // Open Modal
                document.querySelector('[data-modal-toggle="buy-storage-modal"]').addEventListener('click', () => {
                    modal.classList.remove('hidden');
                });

                // Close Modal
                closeModalBtn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            </script>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button class="flex items-center space-x-2 text-red-600 px-4 py-2 rounded-lg hover:bg-gray-100 w-full">
                    <i data-feather="log-out"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="w-full p-9">
            {{ $slot }}
        </div>
    </div>

    <!-- Initialize Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- SweetAlert for Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ $errors->first() }}',
                    confirmButtonColor: '#d33',
                });
            @endif
        });
    </script>
</body>

</html>
