    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-lg p-8 rounded-2xl shadow-xl border
                bg-white/70 dark:bg-gray-800/50 backdrop-blur-xl
                transition-all">

        <h2 class="text-3xl font-bold text-center mb-6 
                   bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Create New Account
        </h2>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Name --}}
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full"
                    type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full"
                    type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Phone --}}
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full"
                    type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            {{-- LinkedIn --}}
            <div class="mt-4">
                <x-input-label for="linkedin_url" :value="__('LinkedIn URL')" />
                <x-text-input id="linkedin_url" class="block mt-1 w-full"
                    type="url" name="linkedin_url" :value="old('linkedin_url')" />
                <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
            </div>

            {{-- Role --}}
            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" 
                    class="block mt-1 w-full rounded-lg bg-gray-100 dark:bg-gray-700
                           border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                    <option value="employer">Employer</option>
                    <option value="candidate">Candidate</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            {{-- Avatar --}}
            <div class="mt-4">
                <x-input-label for="avatar_path" :value="__('Profile Image')" />
                <input id="avatar_path" name="avatar_path" type="file"
                       class="block w-full mt-1 text-sm text-gray-300
                              file:bg-blue-600 file:text-white file:px-4 file:py-2
                              file:rounded-full cursor-pointer" />
                <x-input-error :messages="$errors->get('avatar_path')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-between mt-8">
                <a class="text-blue-600 dark:text-blue-400 underline text-sm"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="px-6 py-2 rounded-full bg-blue-700 hover:bg-blue-800">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </form>
    </div>
</div>
