    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-xl p-8 rounded-2xl shadow-xl border
                bg-white/70 dark:bg-gray-800/40 backdrop-blur-xl
                transition-all">

        {{-- Title --}}
        <h2 class="text-3xl font-bold text-center mb-4
                   bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Forgot Password?
        </h2>

        {{-- Description --}}
        <p class="text-gray-700 dark:text-gray-300 text-sm text-center leading-6 mb-4">
            No problem! Just enter your email address below and we’ll send you a password reset link.
        </p>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Button --}}
            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="rounded-full px-5 py-2">
                    {{ __('Send Reset Link') }}
                </x-primary-button>
            </div>
        </form>

    </div>

</div>