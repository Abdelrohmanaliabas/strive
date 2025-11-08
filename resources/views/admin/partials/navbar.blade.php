<nav class="flex justify-between items-center bg-white dark:bg-gray-800 px-6 py-3 shadow-md sticky top-0 z-40 transition-all">
    {{-- Left section --}}
    <div class="flex items-center gap-3">
        {{-- Sidebar toggle button --}}
        <button id="toggleSidebar"
                class="p-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-md transition">
            <i class="bi bi-list text-lg"></i>
        </button>
        <h2 class="text-lg font-semibold">@yield('title', 'Dashboard')</h2>
    </div>

    {{-- Right section --}}
    <div class="flex items-center space-x-4">
        {{-- Dark / light mode --}}
        <button id="themeToggle" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <i class="bi bi-moon text-lg"></i>
        </button>

        {{-- Profile dropdown --}}
        <div class="relative group">
            @auth
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="{{ Auth::user()->avatar_url }}"
                     class="w-9 h-9 rounded-full object-cover border border-gray-300 dark:border-gray-600">
                <span class="font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                <i class="bi bi-caret-down-fill text-sm"></i>
            </button>
            @endauth

            <div class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-md shadow-lg hidden group-hover:block">
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                <hr class="border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
