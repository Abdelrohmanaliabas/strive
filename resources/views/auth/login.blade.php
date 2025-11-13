    @vite('resources/css/app.css')
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-lg p-8 rounded-2xl shadow-xl border
                bg-white/70 dark:bg-gray-800/40 backdrop-blur-xl
                transition-all">

        {{-- Title --}}
        <h2 class="text-3xl font-bold text-center mb-6 
                   bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Welcome Back
        </h2>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Login with LinkedIn --}}
        <button onclick="window.location='{{ route('auth.linkedin.redirect') }}'"
            class="w-full flex items-center justify-center gap-2 py-3 mb-6
                   bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold
                   rounded-full transition-all shadow-md hover:shadow-lg">

            <i class="bi bi-linkedin text-xl"></i>
            Login with LinkedIn
        </button>

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
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

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember me --}}
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me"
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm
                               focus:ring-indigo-500"
                        name="remember">

                    <span class="ms-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ __('Remember me') }}
                    </span>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-between mt-6">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm underline text-blue-600 dark:text-blue-400 hover:text-blue-800">
                        {{ __('Forgot password?') }}
                    </a>
                @endif

                <x-primary-button class="px-6 py-2 rounded-full">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            {{-- Register link --}}
            <div class="text-center mt-6">
                <a href="{{ route('register') }}"
                    class="underline text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    {{ __('Create a new account') }}
                </a>
            </div>

        </form>

    </div>

</div>
