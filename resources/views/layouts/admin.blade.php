<!DOCTYPE html>
<html lang="en" class="{{ session('theme', '') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Tailwind --}}
    @vite('resources/css/app.css')
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .transition-all { transition: all 0.3s ease-in-out; }
        .sidebar-collapsed { width: 4.5rem !important; }
        .ml-sidebar { margin-left: 15rem; }
        .ml-sidebar-collapsed { margin-left: 4.5rem; }
        .dark-mode { background-color: #1e1e2f; color: #ddd; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-all">

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    {{-- Main Content --}}
    <div id="main-content" class="transition-all ml-sidebar">
        @include('admin.partials.navbar')

        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleBtn = document.getElementById('toggleSidebar');
        const themeBtn = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Sidebar toggle
        toggleBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
            mainContent.classList.toggle('ml-sidebar');
            mainContent.classList.toggle('ml-sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('sidebar-collapsed'));
        });

        // Dark/light mode toggle
        themeBtn?.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeBtn.innerHTML = isDark ? '<i class="bi bi-sun text-lg"></i>' : '<i class="bi bi-moon text-lg"></i>';
        });

        // Load from LocalStorage
        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
            themeBtn.innerHTML = '<i class="bi bi-sun text-lg"></i>';
        }
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('sidebar-collapsed');
            mainContent.classList.add('ml-sidebar-collapsed');
            mainContent.classList.remove('ml-sidebar');
        }
    </script>
</body>
</html>
