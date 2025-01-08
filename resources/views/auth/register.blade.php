<x-guest-layout>
    <div class="w-full h-screen bg-gray-50 flex">
        <!-- Left Section -->
   
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-start px-8 lg:px-24">
            <!-- Back to Home -->
            <a href="/" class="flex items-center text-gray-600 mb-8">
                <div class="text-lg font-bold">Kembali ke Beranda</div>
            </a>

            <!-- Title -->
            <div class="mb-8">
                <h1 class="text-4xl font-semibold text-[#142f37] mb-4">Buat Akun Anda untuk Menyimpan Kenangan Digital</h1>
            </div>

            <!-- Already Registered -->
            <div class="w-full bg-[#f0f5ff] p-4 rounded-lg border border-[#bdd4ff] flex justify-between items-center mb-8">
                <span class="text-gray-600">Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" class="text-[#1146ab] font-bold underline">Masuk Sekarang</a>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="w-full">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-base font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-base font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg @error('password') border-red-500 @enderror" />
                    <p class="text-sm text-gray-500 mt-2">Minimal 8 karakter, termasuk 1 huruf kapital dan 1 angka.</p>
                    @error('password')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-base font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg @error('password_confirmation') border-red-500 @enderror" />
                    @error('password_confirmation')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Register Button -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#1146ab] text-white px-6 py-3 rounded-lg font-bold">Buat Akun</button>
                </div>
            </form>
        </div>
        <!-- Right Section -->
        <div class="hidden lg:block w-1/2 relative rounded-2xl overflow-hidden">
            <!-- Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#0003be] to-[#000153]"></div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- Decorative Images -->
            <img class="absolute w-[280px] h-[280px] top-[-32px] right-[180px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 1" />
            <img class="absolute w-[280px] h-[280px] top-[264px] right-[180px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 2" />
            <img class="absolute w-[280px] h-[280px] top-[218px] right-[-116px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 3" />
            <img class="absolute w-[280px] h-[280px] top-[514px] right-[-116px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 4" />
            <img class="absolute w-[280px] h-[280px] top-[810px] right-[-116px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 5" />
            <img class="absolute w-[280px] h-[280px] top-[124px] right-[476px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 6" />
            <img class="absolute w-[280px] h-[280px] top-[-172px] right-[476px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 7" />
            <img class="absolute w-[280px] h-[280px] top-[420px] right-[476px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 8" />
            <img class="absolute w-[280px] h-[280px] top-[716px] right-[476px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 9" />
            <img class="absolute w-[280px] h-[280px] top-[560px] right-[180px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 10" />
            <img class="absolute w-[280px] h-[280px] top-[856px] right-[180px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 11" />
            <img class="absolute w-[280px] h-[280px] top-[-78px] right-[-116px] rounded-2xl" src="https://via.placeholder.com/280x280" alt="Image 12" />
        </div>

    </div>
</x-guest-layout>
