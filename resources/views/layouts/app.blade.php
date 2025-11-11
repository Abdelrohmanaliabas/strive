<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
          {{-- @include('layouts.navigation') --}}

<!-- ===================================== Navbar Start ======================================= -->
{{-- <nav class="backdrop-blur-md bg-white/50 dark:bg-gray-900/50 border-b border-white/10 dark:border-gray-800/50 sticky top-0 z-50 shadow-sm">
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


</nav> --}}


<!-- ===================================== Navbar End ======================================= -->
            <!-- Page Heading -->
            @isset($header)
                <header class=" shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>



            @if (!empty($slot))
              {{ $slot }}
            @else
              @yield('content')
            @endif
            </main>
        </div>

        <script>
          const html = document.documentElement;
          const toggle = document.getElementById('theme-toggle');
          const icon = document.getElementById('theme-icon');

          // Load saved preference
          if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            icon.classList.replace('bi-moon-fill', 'bi-sun-fill');
          }

          toggle?.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            icon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
          });

          // Mobile menu toggle
          const menuBtn = document.getElementById('mobile-menu-btn');
          const menu = document.getElementById('mobile-menu');
          menuBtn?.addEventListener('click', () => {
            menu.classList.toggle('hidden');
          });

          setTimeout(() => {
              const alert = document.querySelector('.alert');
              if (alert) {
                  const bsAlert = new bootstrap.Alert(alert);
                  bsAlert.close();
              }
          }, 4000);
        </script>


                {{-- @stack('scripts') --}}
    </body>
</html>
