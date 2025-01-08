<x-guest-layout>
    <div class="w-full h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-4">Reset Password</h2>
            <p class="text-center text-sm text-gray-600 mb-8">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center mt-6">
                    <x-primary-button class="w-full py-3 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition duration-300">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="mt-6 text-center text-gray-600">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 transition duration-200">{{ __('Back to Login') }}</a>
            </div>
        </div>
    </div>
</x-guest-layout>
