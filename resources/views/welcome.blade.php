<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenangid</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigasi -->
    <header class="w-full fixed top-0 z-50 bg-white/80 backdrop-blur-lg shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="h-10 rounded-full">
                <nav class="hidden md:flex space-x-6">
                    <a href="#" class="text-blue-900 font-medium hover:underline">Beranda</a>
                    <a href="#" class="text-blue-900 font-medium hover:underline">Harga</a>
                    <a href="#" class="text-blue-900 font-medium hover:underline">Tentang Kami</a>
                </nav>
            </div>
            <div class="flex space-x-4">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->isSuperAdmin())
                            <!-- Menu Superadmin -->
                            <a href="{{ route('superadmin.dashboard') }}" class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg border border-blue-700 hover:bg-blue-200">
                                Dashboard Superadmin
                            </a>
                        @elseif (auth()->user()->isAdmin())
                            <!-- Menu Admin -->
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg border border-blue-700 hover:bg-blue-200">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.manageUsers') }}" class="px-4 py-2 bg-blue-700 text-white font-bold rounded-lg hover:bg-blue-800">
                                Kelola Pengguna
                            </a>
                        @elseif (auth()->user()->isUser())
                            <!-- Menu User -->
                            <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg border border-blue-700 hover:bg-blue-200">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <!-- Menu untuk pengunjung -->
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg border border-blue-700 hover:bg-blue-200">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-700 text-white font-bold rounded-lg hover:bg-blue-800">
                                Buat Akun
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
            
            
        </div>
    </header>

    <!-- Page 1 -->
    <section class="relative w-full h-screen bg-gradient-to-b from-blue-900 to-blue-800 text-white flex flex-col justify-center items-center text-center">
        <h1 class="text-4xl md:text-6xl font-bold leading-snug mt-24">
            Tidak ada kehidupan yang seharusnya dilupakan
        </h1>
        <p class="mt-8 max-w-xl text-lg md:text-2xl font-medium leading-relaxed">
            Transformasikan setiap momen menjadi cerita abadi. Sekarang, tidak ada kehidupan yang akan pernah terlupakan.
        </p>
        <div class="relative flex justify-center mt-16 space-x-4">
            <img class="object-cover w-64 h-80 rounded-3xl shadow-lg" src="https://studio.mrngroup.co/storage/app/media/Prambors/Editorial%202/NCT%20Dream%20Fadil-20230309111726.webp?tr=w-600" alt="Gambar Kiri">
            <img class="object-cover w-80 h-80 rounded-3xl shadow-lg" src="https://via.placeholder.com/400x400" alt="Gambar Tengah">
            <img class="object-cover w-64 h-80 rounded-3xl shadow-lg" src="https://studio.mrngroup.co/storage/app/media/Prambors/Editorial%202/NCT%20Dream%20Fadil-20230309111726.webp?tr=w-600" alt="Gambar Kanan">
        </div>
    </section>

    <!-- Page 2 -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-blue-900">Jadikan setiap momen penting tetap dekat</h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Transformasikan setiap kenangan Anda menjadi cerita yang abadi dalam platform digital kami yang aman dan mudah digunakan.
            </p>
            <div class="flex justify-center mt-12 space-x-6">
                <img class="object-cover w-80 rounded-lg shadow-lg border-4 border-white" src="https://via.placeholder.com/336x224" alt="Image 1">
                <img class="object-cover w-96 rounded-lg shadow-lg border-4 border-white" src="https://via.placeholder.com/480x324" alt="Image 2">
                <img class="object-cover w-80 rounded-lg shadow-lg border-4 border-white" src="https://via.placeholder.com/336x224" alt="Image 3">
            </div>
        </div>
    </section>

    <!-- Page 3 - Fitur -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto">
            <div class="text-center">
                <h3 class="text-xl font-bold text-blue-500 uppercase">Fitur</h3>
                <h2 class="text-4xl font-extrabold text-blue-900 mt-4">Jelajahi Fitur yang Kami Tawarkan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h4 class="text-2xl font-bold text-blue-900">User Friendly</h4>
                    <p class="mt-4 text-gray-600">Desain yang mudah digunakan oleh siapa saja.</p>
                    <img class="object-cover mt-6 w-full rounded-lg" src="https://media.suara.com/pictures/653x366/2023/06/01/54597-potret-rafathar-salim-ke-jaehyun-nct-youtuberans-entertainment.jpg" alt="User Friendly">
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h4 class="text-2xl font-bold text-blue-900">Fleksibilitas</h4>
                    <p class="mt-4 text-gray-600">Sesuaikan kenangan Anda dengan fleksibilitas penuh.</p>
                    <img class="object-cover mt-6 w-full rounded-lg" src="https://media.suara.com/pictures/653x366/2023/06/01/54597-potret-rafathar-salim-ke-jaehyun-nct-youtuberans-entertainment.jpg" alt="Flexibility">
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h4 class="text-2xl font-bold text-blue-900">Keamanan & Privasi</h4>
                    <p class="mt-4 text-gray-600">Simpan kenangan Anda dengan aman tanpa rasa khawatir.</p>
                    <img class="object-cover mt-6 w-full rounded-lg" src="https://media.suara.com/pictures/653x366/2023/06/01/54597-potret-rafathar-salim-ke-jaehyun-nct-youtuberans-entertainment.jpg" alt="Security">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-8">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="font-bold text-lg">Pricing</h5>
                    <ul class="mt-4 space-y-2">
                        <li class="text-gray-300">Lorem Ipsum</li>
                        <li class="text-gray-300">Lorem Ipsum</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-lg">Tentang Kami</h5>
                    <ul class="mt-4 space-y-2">
                        <li class="text-gray-300">Lorem Ipsum</li>
                        <li class="text-gray-300">Lorem Ipsum</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-lg">Subscribe</h5>
                    <p class="mt-4 text-gray-300">Dapatkan informasi terbaru dari kami.</p>
                    <div class="mt-4 flex items-center space-x-2">
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 bg-white text-black rounded-lg">
                        <button class="bg-blue-700 px-4 py-2 rounded-lg text-white hover:bg-blue-800">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-4 text-center text-gray-400">
            &copy; 2024 Kenangid. All Rights Reserved.
        </div>
    </footer>
</body>
</html>
