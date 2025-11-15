    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-xl p-8 rounded-2xl shadow-xl border
                bg-white/70 dark:bg-gray-800/40 backdrop-blur-xl
                transition-all">

        {{-- Title --}}
        <h2 class="text-3xl font-bold text-center mb-4
                   bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Verify Your Email
        </h2>

        {{-- Description --}}
        <p class="text-gray-700 dark:text-gray-300 text-sm text-center leading-6">
            Thanks for signing up! Before getting started, please verify your email by clicking
            on the link we sent to your inbox.  
            <br>
            Didn’t receive an email? We can send you another one.
        </p>

        {{-- Success Message --}}
        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200 text-sm text-center">
                A new verification link has been sent to the email address you provided.
            </div>
        @endif

        {{-- Actions --}}
        <div class="mt-6 flex items-center justify-between">

            {{-- Resend Link --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="rounded-full px-5 py-2">
                    {{ __('Resend Email') }}
                </x-primary-button>
            </form>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm underline text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>

    </div>

</div>

