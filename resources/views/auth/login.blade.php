<x-guest-layout>
    <div class="w-full h-screen flex">
        <!-- Left Section -->
        
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-start px-8  lg:px-24">
            <!-- Back to Home -->
            <a href="/" class="flex items-center text-gray-600 mb-8">
                <div class="text-lg font-bold">Kembali ke Beranda</div>
            </a>

            <!-- Welcome Text -->
            <div class="mb-8">
                <h1 class="text-4xl font-semibold text-[#142f37] mb-4">Selamat datang kembali 👋</h1>
                <p class="text-lg text-gray-500">Silakan masuk untuk melanjutkan.</p>
            </div>

            <!-- Registration Link -->
            <div class="w-full bg-[#f0f5ff] p-4 rounded-lg border border-[#bdd4ff] flex justify-between items-center mb-8">
                <span class="text-gray-600">Belum memiliki akun?</span>
                <a href="{{ route('register') }}" class="text-[#1146ab] font-bold underline">Daftar Akun</a>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="w-full">
                @csrf
            
                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-base font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg" />
                    @error('email')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-base font-medium text-gray-700 mb-2">Password</label>
                    <div class="flex items-center justify-between">
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#1146ab] font-bold underline ml-4">Lupa Password</a>
                        @endif
                    </div>
                    @error('password')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
            
                <!-- Login Button -->
                <div class="flex justify-start">
                    <button type="submit" class="bg-[#1146ab] text-white px-6 py-2 rounded-lg font-bold">Masuk</button>
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
