    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-xl p-8 rounded-2xl shadow-xl border
                bg-white/70 dark:bg-gray-800/40 backdrop-blur-xl
                transition-all">

        {{-- Title --}}
        <h2 class="text-3xl font-bold text-center mb-4
                   bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Reset Your Password
        </h2>

        {{-- Description --}}
        <p class="text-gray-700 dark:text-gray-300 text-sm text-center leading-6 mb-4">
            Enter your new password below to restore access to your account.
        </p>

        {{-- Reset Form --}}
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            {{-- Reset Token --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="rounded-full px-6 py-2">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>

        </form>
    </div>

</div>