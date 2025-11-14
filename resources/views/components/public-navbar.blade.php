<!-- ===================================== Navbar Start ======================================= -->
<nav class="backdrop-blur-md bg-white/50 dark:bg-gray-900/50 border-b border-white/10 dark:border-gray-800/50 sticky top-0 z-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Left: Logo -->
      <a href="{{ route('jobs.index') }}" class="text-2xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">
        Strive
      </a>

      <!-- Center: Links -->
      <div class="hidden md:flex space-x-6">
        <a href="{{ route('jobs.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Jobs</a>
        <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Employers</a>
        <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
        <a href="#" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
      </div>

      <!-- Right: Actions -->
      <div class="flex items-center space-x-3">
        <!-- Theme toggle -->
          <button id="theme-toggle" class="text-lg p-2 rounded-md bg-white/10 text-gray-700 dark:text-white/70 transition hover:bg-white/20">
            <i id="theme-icon" class="bi bi-moon-fill"></i>
          </button>

          @auth
          <!-- Notifications -->
          <x-notification-dropdown />

          <!-- If user is logged in -->
          <div class="relative group">
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2">
              <img src="{{ Auth::user()->avatar_url }}"
                  alt="Profile"
                  class="w-9 h-9 rounded-full object-cover border border-white/20 shadow">
              <span class="hidden sm:inline text-sm font-medium text-gray-800 dark:text-gray-200">
                {{ Auth::user()->name }}
              </span>
            </a>
            <!-- Dropdown -->
            <div class="absolute right-0 mt-2 w-40 hidden group-hover:block bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">
              <a href="{{ route('profile.edit') }}"
                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="bi bi-person-circle mr-1"></i> Profile
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-gray-700">
                  <i class="bi bi-box-arrow-right mr-1"></i> Logout
                </button>
              </form>
            </div>
          </div>

          @else
            <!-- If user is not logged in -->
            <a href="{{ route('login') }}"
              class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
              Login
            </a>
            <a href="{{ route('register') }}"
              class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-indigo-500 transition">
              Sign up
            </a>
          @endauth


        <!-- Auth / CTA -->
        @auth
          <a href="#" class="hidden sm:inline-block bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-indigo-500 transition">
            Post a Job
          </a>
        @endauth

        <!-- Mobile menu button -->
        <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-200/40 dark:hover:bg-gray-800/40">
          <i class="bi bi-list text-2xl"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden md:hidden px-4 pb-3 space-y-2 bg-white/70 dark:bg-gray-900/70 backdrop-blur-md border-t border-white/20 dark:border-gray-800/50">
    <a href="{{ route('jobs.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Jobs</a>
    <a href="#" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Employers</a>
    <a href="#" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
    <a href="#" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
  </div>


</nav>

<!-- ===================================== Navbar End ======================================= -->
