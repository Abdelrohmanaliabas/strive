@php

    $navLinks = [
        [
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'href' =>Route::has('employer.dashboard')
                ? route('employer.dashboard')
                : '#',
            'active' => request()->routeIs('employer.dashboard'),
        ],
        [
            'label' => 'My Jobs',
            'icon' => 'briefcase',
            'href' =>Route::has('employer.jobs.index')
                ? route('employer.jobs.index')
                : (Route::has('jobs.index') ? route('jobs.index') : '#'),
            'active' => request()->routeIs('employer.jobs.*') || request()->routeIs('jobs.*'),
        ],
        [
            'label' => 'Applications',
            'icon' => 'users',
            'href' =>Route::has('employer.applications.index')
                ? route('employer.applications.index')
                : (Route::has('applications.index') ? route('applications.index') : '#'),
            'active' => request()->routeIs('employer.applications.*') || request()->routeIs('applications.*'),
        ],
        [
            'label' => 'Comments',
            'icon' => 'chat',
            'href' =>Route::has('employer.comments.index')
                ? route('employer.comments.index')
                : (Route::has('comments.index') ? route('comments.index') : '#'),
            'active' => request()->routeIs('employer.comments.*') || request()->routeIs('comments.*'),
        ],
        [
            'label' => 'Profile Settings',
            'icon' => 'settings',
            'href' => Route::has('employer.profile.edit')
                ? route('employer.profile.edit')
                : (Route::has('profile.edit') ? route('profile.edit') : '#'),
            'active' => request()->routeIs('employer.profile.*') || request()->routeIs('profile.*'),
        ],
    ];

    $iconPaths = [
        'dashboard' => 'M3 12a1 1 0 0 1 1-1h6V4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1zM5 13v6h6v-6zm8-8v14h6V5z',
        'briefcase' => 'M4 7a2 2 0 0 1 2-2h2V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2h2a2 2 0 0 1 2 2v3H4zm8-4h-4v2h4zm8 7v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9h6v2h4v-2z',
        'users' => 'M4 18a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H4zm4-6a3 3 0 1 1 0-6 3 3 0 0 1 0 6m7-1a3 3 0 1 1 0-6 3 3 0 0 1 0 6m1 7v-1a5 5 0 0 0-2.7-4.47 5.97 5.97 0 0 1 4.7 5.47v0z',
        'plus' => 'M11 5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5z',
        'chat' => 'M4 5a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H9l-4 4v-4H7a3 3 0 0 1-3-3z',
        'settings' => 'M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m8-3.5a1 1 0 0 1-.76.97l-1.5.33a6.06 6.06 0 0 1-.54 1.3l.9 1.24a1 1 0 0 1-1.16 1.5l-1.44-.6a6.03 6.03 0 0 1-1.14.66l-.22 1.55A1 1 0 0 1 11 4h2a1 1 0 0 1 .99.85l.22 1.55a6.03 6.03 0 0 1 1.14.66l1.44-.6a1 1 0 1 1 1.16 1.5l-.9 1.24c.24.42.43.86.54 1.3l1.5.33a1 1 0 0 1 .76.97',
    ];
@endphp

@once
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    >
@endonce

@once
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        defer
    ></script>
@endonce

@once
    <style>

        .employer-shell {
            background: radial-gradient(circle at top, rgba(13, 202, 240, 0.18), transparent 55%), radial-gradient(circle at right, rgba(32, 201, 151, 0.22), transparent 62%), #0f172a;

            position:fixed;

        }

        .employer-shell::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at 15% 20%, rgba(13, 110, 253, 0.18), transparent 55%), radial-gradient(circle at 80% 0%, rgba(32, 201, 151, 0.12), transparent 60%);
            filter: blur(40px);
            opacity: 0.7;
            pointer-events: none;
        }

        .employer-shell__sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            backdrop-filter: blur(20px);
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.95), rgba(15, 23, 42, 0.75));
            border-right: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: 10px 0 35px rgba(15, 23, 42, 0.55);
        ;
        }

        .employer-shell__sidebar .nav-link {
            border-radius: 1rem;
            font-weight: 600;
            padding: 0.85rem 1.15rem;
            border: 1px solid transparent;
            transition: all 0.25s ease;
            color: rgba(226, 232, 240, 0.68);
            margin-bottom: 0.5rem;
        }

        .employer-shell__sidebar .nav-link.active {
            background: linear-gradient(140deg, rgba(13, 202, 240, 0.22), rgba(32, 201, 151, 0.22));
            color: #e2e8f0;
            border-color: rgba(13, 202, 240, 0.45);
            box-shadow: 0 22px 36px -26px rgba(13, 202, 240, 0.85);
        }

        .employer-shell__sidebar .nav-link:hover:not(.active) {
            color: #f8fafc;
            border-color: rgba(13, 202, 240, 0.28);
            background: rgba(15, 23, 42, 0.65);
        }

        .employer-shell__sidebar .nav-link svg {
            transition: color 0.25s ease;
        }

        .employer-shell__sidebar .nav-link:hover svg,
        .employer-shell__sidebar .nav-link.active svg {
            color: #0dcaf0;
        }

        .offcanvas-employer {
            backdrop-filter: blur(18px);
            background: linear-gradient(150deg, rgba(15, 23, 42, 0.98), rgba(8, 47, 73, 0.9));
        }

        .offcanvas-employer .nav-link {
            border-radius: 0.9rem;
            font-weight: 600;
            padding: 0.9rem 1rem;
            color: rgba(226, 232, 240, 0.7);
            border: 1px solid transparent;
        }

        .offcanvas-employer .nav-link.active {
            background: rgba(13, 202, 240, 0.2);
            color: #e2e8f0;
            border-color: rgba(13, 202, 240, 0.35);
        }

        .offcanvas-employer .nav-link:hover:not(.active) {
            color: #f8fafc;
            border-color: rgba(13, 202, 240, 0.25);
            background: rgba(15, 23, 42, 0.6);
        }

        .theme-dark {
            color-scheme: dark;
        }

        .theme-light {
            color-scheme: light;
        }

        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 999px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .theme-toggle svg {
            width: 16px;
            height: 16px;
        }

        .theme-light .theme-toggle {
            color: #0f172a;
        }

        .theme-light .employer-shell {
            background: radial-gradient(circle at 15% 20%, rgba(14, 165, 233, 0.12), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(16, 185, 129, 0.12), transparent 60%),
                linear-gradient(180deg, #f8fafc, #eef2ff);
            color: #0f172a;
        }

        .theme-light .employer-shell::before {
            background: radial-gradient(circle at 5% 5%, rgba(125, 211, 252, 0.35), transparent 55%),
                radial-gradient(circle at 75% 0%, rgba(187, 247, 208, 0.25), transparent 65%);
            opacity: 0.35;
        }

        .theme-light .employer-shell__sidebar {
            background: rgba(255, 255, 255, 0.95);
            border-right: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: 12px 0 35px rgba(15, 23, 42, 0.08);
        }

        .theme-light .employer-shell__sidebar .nav-link {
            color: #475569;
            border-color: transparent;
            background: transparent;
        }

        .theme-light .employer-shell__sidebar .nav-link.active {
            background: linear-gradient(140deg, rgba(14, 165, 233, 0.18), rgba(16, 185, 129, 0.22));
            color: #0f172a;
            border-color: rgba(14, 165, 233, 0.45);
            box-shadow: 0 18px 30px rgba(14, 165, 233, 0.25);
        }

        .theme-light .employer-shell__sidebar .nav-link:hover:not(.active) {
            color: #0f172a;
            border-color: rgba(14, 165, 233, 0.3);
            background: rgba(14, 165, 233, 0.08);
        }

        .theme-light .employer-shell__sidebar .nav-link svg {
            color: inherit;
        }

        .theme-light .offcanvas-employer {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.98);
            color: #0f172a;
            border-right: 1px solid rgba(148, 163, 184, 0.4);
        }

        .theme-light .offcanvas-employer .nav-link {
            color: #475569;
        }

        .theme-light .offcanvas-employer .nav-link.active {
            background: linear-gradient(140deg, rgba(14, 165, 233, 0.18), rgba(16, 185, 129, 0.22));
            color: #0f172a;
            border-color: rgba(14, 165, 233, 0.45);
        }

        .theme-light .offcanvas-employer .nav-link:hover:not(.active) {
            color: #0f172a;
            border-color: rgba(14, 165, 233, 0.3);
            background: rgba(14, 165, 233, 0.08);
        }

        .theme-light .offcanvas-employer .btn-close {
            filter: none;
        }

        .theme-light .employer-shell .text-white,
        .theme-light .employer-shell .text-slate-100,
        .theme-light .employer-shell .text-slate-200 {
            color: #0f172a !important;
        }

        .theme-light .employer-shell .text-secondary,
        .theme-light .employer-shell .text-slate-300,
        .theme-light .employer-shell .text-slate-400 {
            color: #475569 !important;
        }

        .theme-light .employer-shell .text-slate-500,
        .theme-light .employer-shell .text-slate-600 {
            color: #64748b !important;
        }

        .theme-light .employer-shell .border-secondary-subtle {
            border-color: rgba(148, 163, 184, 0.6) !important;
        }

        .theme-light .employer-shell [class*="border-white\/"] {
            border-color: rgba(203, 213, 225, 0.8) !important;
        }

        .theme-light .employer-shell [class*="bg-white\/"] {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .theme-light .employer-shell [class*="bg-slate-950"] {
            background-color: #ffffff !important;
        }

        .theme-light .employer-shell [class*="bg-slate-900"] {
            background-color: #f1f5f9 !important;
        }

        .theme-light .employer-shell .shadow-2xl,
        .theme-light .employer-shell .shadow-[0_20px_45px_-30px_rgba(45,212,191,0.8)] {
            box-shadow: 0 25px 65px -30px rgba(15, 23, 42, 0.25) !important;
        }

        .theme-light .employer-shell [class*="text-white/"] {
            color: rgba(15, 23, 42, 0.9) !important;
        }

        .theme-light .employer-shell .text-cyan-200,
        .theme-light .employer-shell .text-cyan-300,
        .theme-light .employer-shell .text-cyan-400 {
            color: #0891b2 !important;
        }

        .theme-light .employer-shell .text-cyan-200\/80 {
            color: rgba(8, 145, 178, 0.8) !important;
        }

        .theme-light .employer-shell .text-emerald-200,
        .theme-light .employer-shell .text-emerald-300,
        .theme-light .employer-shell .text-emerald-400 {
            color: #059669 !important;
        }

        .theme-light .employer-shell [class*="from-slate-900/90"] {
            --tw-gradient-from: rgba(15, 23, 42, 0.05) !important;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(15, 23, 42, 0));
        }

        .theme-light .employer-shell [class*="via-slate-900/70"] {
            --tw-gradient-stops: var(--tw-gradient-from), rgba(14, 165, 233, 0.15), var(--tw-gradient-to, rgba(14, 165, 233, 0));
        }

        .theme-light .employer-shell [class*="to-slate-900/50"] {
            --tw-gradient-to: rgba(255, 255, 255, 0.9) !important;
        }

        .theme-light .employer-shell .text-cyan-300\/80 {
            color: rgba(8, 145, 178, 0.8) !important;
        }

        .theme-light .employer-shell .text-slate-300\/80 {
            color: rgba(148, 163, 184, 0.8) !important;
        }    </style>
@endonce

<x-app-layout hide-navigation="true">
    <div class="employer-shell position-relative text-white">
        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex d-lg-none border-bottom border-secondary-subtle px-3 py-3 align-items-center justify-content-between">
                <div>
                    <p class="text-uppercase text-secondary mb-1 small fw-semibold">Employer</p>
                    <h2 class="h6 mb-0 text-white">StriveHub</h2>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button
                        class="btn btn-outline-light btn-sm"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#employerSidebarMobile"
                        aria-controls="employerSidebarMobile"
                    >
                        Menu
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-light btn-sm theme-toggle"
                        data-theme-toggle
                        aria-label="Activate light mode"
                    >
                        <span data-theme-icon="sun">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0 4a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm0-18a1 1 0 0 1-1-1V2a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm8 7h-1a1 1 0 1 1 0-2h1a1 1 0 1 1 0 2ZM5 12a1 1 0 0 1-1 1H3a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1Zm12.36 6.36a1 1 0 0 1-1.41 0l-.71-.7a1 1 0 0 1 1.41-1.42l.71.71a1 1 0 0 1 0 1.41Zm-9.9-9.9a1 1 0 0 1-1.41 0l-.71-.7A1 1 0 0 1 5.76 6.34l.71.7a1 1 0 0 1 0 1.42Zm9.9-4.24a1 1 0 0 1 0 1.41l-.71.71a1 1 0 0 1-1.41-1.41l.71-.71a1 1 0 0 1 1.41 0Zm-9.9 9.9a1 1 0 0 1 0 1.41l-.71.71a1 1 0 0 1-1.41-1.41l.71-.71a1 1 0 0 1 1.41 0Z" />
                            </svg>
                        </span>
                        <span class="d-none" data-theme-icon="moon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79Z" />
                            </svg>
                        </span>
                        <span data-theme-label>Light mode</span>
                    </button>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row flex-nowrap min-vh-100">
                    <aside class="employer-shell__sidebar d-none d-lg-flex flex-column col-lg-3 col-xl-2 px-0 ">
                        <div class="px-4 pt-4 pb-3 border-bottom border-secondary-subtle">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div>
                                    <p class="text-uppercase text-secondary mb-1 small fw-semibold">Employer</p>
                                    <h2 class="h4 text-white mb-1">StriveHub</h2>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button
                                        type="button"
                                        class="btn btn-outline-light btn-sm theme-toggle"
                                        data-theme-toggle
                                        aria-label="Activate light mode"
                                    >
                                    <span data-theme-icon="sun">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0 4a1 1 0 0 1-1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm0-18a1 1 0 0 1-1-1V2a1 1 0 1 1 2 0v1a1 1 0 0 1-1 1Zm8 7h-1a1 1 0 1 1 0-2h1a1 1 0 1 1 0 2ZM5 12a1 1 0 0 1-1 1H3a1 1 0 1 1 0-2h1a1 1 0 0 1 1 1Zm12.36 6.36a1 1 0 0 1-1.41 0l-.71-.7a1 1 0 0 1 1.41-1.42l.71.71a1 1 0 0 1 0 1.41Zm-9.9-9.9a1 1 0 0 1-1.41 0l-.71-.7A1 1 0 0 1 5.76 6.34l.71.7a1 1 0 0 1 0 1.42Zm9.9-4.24a1 1 0 0 1 0 1.41l-.71.71a1 1 0 0 1-1.41-1.41l.71-.71a1 1 0 0 1 1.41 0Zm-9.9 9.9a1 1 0 0 1 0 1.41l-.71.71a1 1 0 0 1-1.41-1.41l.71-.71a1 1 0 0 1 1.41 0Z" />
                                        </svg>
                                    </span>
                                    <span class="d-none" data-theme-icon="moon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M21 12.79A9 9 0 0 1 11.21 3 7 7 0 1 0 21 12.79Z" />
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <nav class="nav nav-pills flex-column gap-2 py-4 flex-grow-1 d-flex justify-content-between">
                            <div>
                            @foreach ($navLinks as $link)
                                @php
                                    $isActive = $link['active'];
                                    $iconKey = $link['icon'];
                                @endphp
                                <a
                                    class="nav-link d-flex align-items-center gap-3 {{ $isActive ? 'active' : '' }}"
                                    href="{{ $link['href'] }}"
                                >
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle border border-secondary-subtle p-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            width="18"
                                            height="18"
                                            fill="currentColor"
                                            class="{{ $isActive ? 'text-white' : 'text-secondary' }}"
                                        >
                                            <path d="{{ $iconPaths[$iconKey] ?? $iconPaths['dashboard'] }}" />
                                        </svg>
                                    </span>
                                    <span>{{ $link['label'] }}</span>
                                </a>
                            @endforeach
                            </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button
                                type="submit"
                                class="group flex w-full items-center justify-center gap-3 rounded-2xl  py-3 text-sm font-semibold uppercase tracking-[0.3em] text-white transition hover:translate-x-0.5  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-200/70 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900"
                            >
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-lg text-white transition group-hover:bg-white/20">
                                    <i class="bi bi-box-arrow-right"></i>
                                </span>
                                <span class="tracking-[0.45em] text-xs">Logout</span>
                            </button>
                        </form>

                        </nav>

                    </aside>

                    <div class="col px-0">
                        <div class="offcanvas offcanvas-start offcanvas-employer text-bg-dark" tabindex="-1" id="employerSidebarMobile" aria-labelledby="employerSidebarMobileLabel">
                            <div class="offcanvas-header border-bottom border-secondary-subtle">
                                <div>
                                    <p class="text-uppercase text-secondary mb-1 small fw-semibold">Employer</p>
                                    <h2 class="h5 text-white mb-0" id="employerSidebarMobileLabel">StriveHub</h2>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body d-flex flex-column gap-4">
                                <nav class="nav nav-pills flex-column gap-2">
                                    @foreach ($navLinks as $link)
                                        @php
                                            $isActive = $link['active'];
                                            $iconKey = $link['icon'];
                                        @endphp
                                        <a
                                            class="nav-link d-flex align-items-center gap-3 {{ $isActive ? 'active' : '' }}"
                                            href="{{ $link['href'] }}"
                                        >
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle border border-secondary-subtle p-2">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    width="18"
                                                    height="18"
                                                    fill="currentColor"
                                                    class="{{ $isActive ? 'text-white' : 'text-secondary' }}"
                                                >
                                                    <path d="{{ $iconPaths[$iconKey] ?? $iconPaths['dashboard'] }}" />
                                                </svg>
                                            </span>
                                            <span>{{ $link['label'] }}</span>
                                        </a>
                                    @endforeach
                                </nav>

                            </div>
                        </div>

                        <main >
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@once
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const root = document.documentElement;
            const toggles = document.querySelectorAll('[data-theme-toggle]');
            if (!toggles.length) {
                return;
            }

            const mediaQuery = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;
            const storedPreference = localStorage.getItem('employer-theme');
            let hasStoredPreference = typeof storedPreference === 'string';
            let currentTheme = storedPreference ?? (mediaQuery && mediaQuery.matches ? 'dark' : 'light');

            const capitalize = (value) => value.charAt(0).toUpperCase() + value.slice(1);

            const applyTheme = (theme) => {
                currentTheme = theme === 'light' ? 'light' : 'dark';
                root.classList.remove('theme-light', 'theme-dark');
                root.classList.add(`theme-${currentTheme}`);
                localStorage.setItem('employer-theme', currentTheme);

                const nextTheme = currentTheme === 'light' ? 'dark' : 'light';

                toggles.forEach((btn) => {
                    btn.setAttribute('aria-label', `Activate ${nextTheme} mode`);
                    btn.setAttribute('aria-pressed', currentTheme === 'light' ? 'true' : 'false');
                    btn.classList.toggle('btn-outline-dark', currentTheme === 'light');
                    btn.classList.toggle('btn-outline-light', currentTheme === 'dark');

                    btn.querySelectorAll('[data-theme-icon]').forEach((icon) => {
                        const target = icon.getAttribute('data-theme-icon');
                        const shouldShow = (currentTheme === 'light' && target === 'moon') || (currentTheme === 'dark' && target === 'sun');
                        icon.classList.toggle('d-none', !shouldShow);
                    });

                    const label = btn.querySelector('[data-theme-label]');
                    if (label) {
                        label.textContent = `${capitalize(nextTheme)} mode`;
                    }
                });
            };

            toggles.forEach((btn) => {
                btn.addEventListener('click', () => {
                    hasStoredPreference = true;
                    applyTheme(currentTheme === 'light' ? 'dark' : 'light');
                });
            });

            root.classList.add('theme-dark');
            applyTheme(currentTheme);

            if (mediaQuery && typeof mediaQuery.addEventListener === 'function') {
                mediaQuery.addEventListener('change', (event) => {
                    if (!hasStoredPreference) {
                        applyTheme(event.matches ? 'dark' : 'light');
                    }
                });
            }
        });
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
@endonce
