<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Strive') }}</title>


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --public-bg: radial-gradient(circle at 10% 20%, rgba(255, 214, 255, 0.55), transparent 60%),
                    radial-gradient(circle at 80% 0%, rgba(170, 238, 255, 0.35), transparent 55%),
                    linear-gradient(135deg, #fefefe 0%, #eef5ff 45%, #f8f0ff 100%);
                --public-dark-bg: radial-gradient(circle at 15% 20%, rgba(83, 63, 186, 0.65), transparent 55%),
                    radial-gradient(circle at 80% -10%, rgba(16, 220, 218, 0.25), transparent 60%),
                    linear-gradient(135deg, #07030d 0%, #050916 50%, #090214 100%);
                --public-card: rgba(255, 255, 255, 0.78);
                --public-card-dark: rgba(13, 16, 32, 0.82);
                --public-border: rgba(255, 255, 255, 0.65);
                --public-dark-border: rgba(255, 255, 255, 0.1);
            }

            .public-body {
                background-image: var(--public-bg);
                background-attachment: fixed;
                min-height: 100vh;
                position: relative;
                color: #1d1d1f;
            }

            .dark .public-body {
                background-image: var(--public-dark-bg);
                color: #f5f5ff;
            }

            .public-body::before,
            .public-body::after {
                content: "";
                position: fixed;
                width: 45vmax;
                height: 45vmax;
                pointer-events: none;
                border-radius: 999px;
                filter: blur(60px);
                opacity: 0.5;
                z-index: 0;
                animation: public-float 18s ease-in-out infinite;
            }

            .public-body::before {
                top: -10vmax;
                left: -15vmax;
                background: rgba(255, 184, 255, 0.5);
            }

            .public-body::after {
                bottom: -12vmax;
                right: -14vmax;
                background: rgba(181, 210, 255, 0.45);
                animation-delay: 6s;
            }

            main.public-main {
                position: relative;
                z-index: 1;
                /* padding: clamp(2rem, 4vw, 4rem) 0 clamp(3rem, 6vw, 6rem); */
            }

            main.public-main > section,
            main.public-main > div,
            main.public-main > article {
                animation: public-fade 600ms ease;
            }

            .public-nav {
                box-shadow: 0 10px 45px rgba(86, 76, 140, 0.08);
                border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            }

            .dark .public-nav {
                border-bottom-color: rgba(255, 255, 255, 0.08);
                box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5);
            }

            .public-nav a {
                transition: color 200ms ease, transform 200ms ease;
            }

            .public-nav a:hover {
                transform: translateY(-1px);
            }

            .public-card {
                background: var(--public-card);
                border: 1px solid var(--public-border);
                box-shadow: 0 25px 60px rgba(110, 80, 140, 0.15);
                backdrop-filter: blur(18px);
            }

            .dark .public-card {
                background: var(--public-card-dark);
                border-color: var(--public-dark-border);
                box-shadow: 0 25px 50px rgba(1, 3, 22, 0.7);
            }

            .public-pill {
                border-radius: 999px;
                padding: 0.45rem 1.4rem;
                border: 1px solid rgba(255, 255, 255, 0.4);
                background: rgba(255, 255, 255, 0.85);
                color: #59427c;
                box-shadow: 0 14px 35px rgba(99, 66, 136, 0.2);
            }

            .dark .public-pill {
                background: rgba(12, 12, 24, 0.8);
                border-color: rgba(255, 255, 255, 0.08);
                color: #f3eaff;
            }

            @keyframes public-float {
                0% {
                    transform: translate3d(0, 0, 0);
                }

                50% {
                    transform: translate3d(0, -25px, 0);
                }

                100% {
                    transform: translate3d(0, 0, 0);
                }
            }

            @keyframes public-fade {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

    </head>
    <body class="font-sans antialiased public-body">
        <div class="min-h-screen">


<!-- ===================================== Navbar Start ======================================= -->
<nav class="public-nav backdrop-blur-md bg-white/60 dark:bg-gray-900/60 border-b border-white/10 dark:border-gray-800/50 sticky top-0 z-50 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Left: Logo -->
      <a href="{{ route('jobs.index') }}" class="text-2xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">
        Strive
      </a>

      <!-- Center: Links -->
      <div class="hidden md:flex space-x-6">
        <a href="{{ route('jobs.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Jobs</a>
        <a href="{{ route('public_employers.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Employers</a>
        <a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
        <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
      </div>

      <!-- Right: Actions -->
      <div class="flex items-center space-x-3">
        <!-- Theme toggle -->
          <button id="theme-toggle" class="text-lg p-2 rounded-md bg-white/10 text-gray-700 dark:text-white/70 transition hover:bg-white/20">
            <i id="theme-icon" class="bi bi-moon-fill"></i>
          </button>

          @auth
          @php
            $user = Auth::user();
            $dashboardRoute = $user?->role === 'admin'
              ? route('admin.dashboard')
              : ($user?->role === 'employer' ? route('employer.dashboard') : null);
          @endphp
          <!-- Notifications -->
          <x-notification-dropdown />

          <!-- If user is logged in -->
          <div class="relative">
            <button
              type="button"
              data-profile-toggle
              class="flex items-center space-x-2 px-2 py-1 rounded-full hover:bg-white/40 dark:hover:bg-gray-800/40 transition"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img src="{{ Auth::user()->avatar_url }}"
                  alt="Profile"
                  class="w-9 h-9 rounded-full object-cover border border-white/20 shadow">
              <span class="hidden sm:inline text-sm font-medium text-gray-800 dark:text-gray-200">
                {{ Auth::user()->name }}
              </span>
              <i class="bi bi-chevron-down text-xs text-gray-500 dark:text-gray-400"></i>
            </button>
            <!-- Dropdown -->
            <div id="profile-menu" class="absolute right-0 mt-2 w-40 hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-100 dark:border-gray-700">
              @if($dashboardRoute)
                <a href="{{ $dashboardRoute }}"
                  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <i class="bi bi-speedometer2 mr-1"></i> Dashboard
                </a>
              @else
                <a href="{{ route('profile.edit') }}"
                  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <i class="bi bi-person-circle mr-1"></i> Profile
                </a>
              @endif
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
        {{-- @auth --}}
          <!-- <a href="#" class="hidden sm:inline-block bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-indigo-500 transition">
            Post a Job
          </a> -->
        {{-- @endauth --}}

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
    <a href="{{ route('public_employers.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Employers</a>
    <a href="{{ route('about') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
    <a href="{{ route('contact') }}" class="block text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
  </div>


</nav>

<!-- ===================================== Navbar End ======================================= -->
<!-- Page Heading -->
@hasSection('header')
    <header class="shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield('header')
        </div>
    </header>
@endif

            <!-- Page Content -->
            <main class="public-main">



            @if (!empty($slot))
              {{ $slot }}
            @else
              @yield('content')
            @endif
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

          // Profile dropdown toggle
          const profileToggle = document.querySelector('[data-profile-toggle]');
          const profileMenu = document.getElementById('profile-menu');
          if (profileToggle && profileMenu) {
            const closeProfileMenu = (event) => {
              if (!profileMenu.contains(event.target) && !profileToggle.contains(event.target)) {
                profileMenu.classList.add('hidden');
                profileToggle.setAttribute('aria-expanded', 'false');
                document.removeEventListener('click', closeProfileMenu);
              }
            };

            profileToggle.addEventListener('click', (event) => {
              event.stopPropagation();
              const expanded = profileToggle.getAttribute('aria-expanded') === 'true';
              profileToggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
              profileMenu.classList.toggle('hidden', expanded);
              if (!expanded) {
                document.addEventListener('click', closeProfileMenu);
              }
            });
          }

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
        <script src="//unpkg.com/alpinejs" defer></script>

                {{-- @stack('scripts') --}}
    </body>
</html>
