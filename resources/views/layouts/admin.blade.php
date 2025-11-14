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

    <script>
        (function () {
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {
                console.warn('Theme check failed', e);
            }
        })();
    </script>

    <style>
        .transition-all { transition: all 0.3s ease-in-out; }
        .sidebar-collapsed { width: 4.5rem !important; }
        .ml-sidebar { margin-left: 15rem; }
        .ml-sidebar-collapsed { margin-left: 4.5rem; }
        .dark-mode { background-color: #1e1e2f; color: #ddd; }
        body.admin-theme {
            --admin-bg: radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.14), transparent 45%),
                        radial-gradient(circle at 80% 0%, rgba(236, 72, 153, 0.18), transparent 40%),
                        linear-gradient(140deg, #f8fafc 0%, #e0f2fe 45%, #fdf2ff 100%);
            --admin-shell-highlight: radial-gradient(circle at 25% 15%, rgba(59, 130, 246, 0.35), transparent 55%),
                        radial-gradient(circle at 85% 10%, rgba(236, 72, 153, 0.3), transparent 45%),
                        radial-gradient(circle at 50% 100%, rgba(14, 165, 233, 0.25), transparent 55%);
            --admin-grid-color: rgba(148, 163, 184, 0.25);
            --admin-text-primary: #0f172a;
            --admin-text-secondary: #475569;
            --admin-panel-bg: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.85));
            --admin-panel-border: rgba(15, 23, 42, 0.08);
            --admin-panel-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
            --admin-card-bg: rgba(255, 255, 255, 0.9);
            --admin-card-border: rgba(15, 23, 42, 0.08);
            --admin-card-shadow: 0 25px 50px rgba(15, 23, 42, 0.12);
            --admin-card-outline: rgba(255, 255, 255, 0.65);
            --admin-metric-overlay: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(14, 165, 233, 0.04));
            --admin-metric-hover-border: rgba(37, 99, 235, 0.45);
            --admin-chip-label: rgba(71, 85, 105, 0.85);
            --admin-metric-value: #0f172a;
            --admin-icon-ring: rgba(148, 163, 184, 0.35);
            --admin-icon-ring-outline: rgba(15, 23, 42, 0.08);
            --admin-trend-positive: #059669;
            --admin-trend-warning: #d97706;
            --admin-chart-bg: linear-gradient(160deg, rgba(59, 130, 246, 0.12), rgba(14, 165, 233, 0.05));
            --admin-chart-shadow: drop-shadow(0 15px 35px rgba(15, 23, 42, 0.12));
            --admin-chart-title: #0f172a;
            --admin-chart-muted: rgba(71, 85, 105, 0.85);
            --admin-chip-text: #1e3a8a;
            --admin-chip-border: rgba(37, 99, 235, 0.35);
            --admin-chip-bg: rgba(59, 130, 246, 0.12);
            --admin-chip-purple-text: #6b21a8;
            --admin-chip-purple-border: rgba(147, 51, 234, 0.35);
            --admin-chip-purple-bg: rgba(168, 85, 247, 0.12);
            --admin-activity-bg: rgba(255, 255, 255, 0.92);
            --admin-activity-border: rgba(15, 23, 42, 0.08);
            --admin-activity-row-bg: rgba(255, 255, 255, 0.87);
            --admin-activity-row-border: rgba(15, 23, 42, 0.08);
            --admin-activity-hover-border: rgba(37, 99, 235, 0.45);
            --admin-activity-empty-bg: rgba(248, 250, 252, 0.92);
            --admin-activity-empty-text: #475569;
            --admin-subtle-link-text: #0e7490;
            --admin-subtle-link-bg: rgba(8, 145, 178, 0.12);
            --admin-subtle-link-hover-bg: rgba(8, 145, 178, 0.2);
            --admin-subtle-link-border: rgba(14, 165, 233, 0.35);
            --admin-heading-gradient: linear-gradient(125deg, #0f172a, #2563eb, #7c3aed);
            --admin-eyebrow-color: rgba(71, 85, 105, 0.75);
            --admin-pulse-color: #059669;
            --admin-pulse-shadow: rgba(16, 185, 129, 0.5);
            min-height: 100vh;
            background: var(--admin-bg);
            color: var(--admin-text-primary);
            position: relative;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }
        body.admin-theme::before {
            content: '';
            position: fixed;
            inset: 0;
            background: var(--admin-shell-highlight);
            opacity: 0.35;
            z-index: 0;
            pointer-events: none;
            filter: blur(20px);
        }
        body.admin-theme #main-content,
        body.admin-theme main {
            position: relative;
            z-index: 1;
        }
        html.dark body.admin-theme {
            --admin-bg: radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.22), transparent 45%),
                        radial-gradient(circle at 80% 0%, rgba(168, 85, 247, 0.2), transparent 40%),
                        linear-gradient(140deg, #020617 0%, #0f172a 45%, #020617 100%);
            --admin-shell-highlight: radial-gradient(circle at 25% 15%, rgba(59, 130, 246, 0.18), transparent 55%),
                        radial-gradient(circle at 85% 10%, rgba(236, 72, 153, 0.15), transparent 45%),
                        radial-gradient(circle at 50% 100%, rgba(14, 165, 233, 0.15), transparent 55%);
            --admin-grid-color: rgba(15, 23, 42, 0.6);
            --admin-text-primary: #e2e8f0;
            --admin-text-secondary: #cbd5f5;
            --admin-panel-bg: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.55));
            --admin-panel-border: rgba(148, 163, 184, 0.25);
            --admin-panel-shadow: 0 25px 45px rgba(2, 6, 23, 0.45);
            --admin-card-bg: rgba(15, 23, 42, 0.78);
            --admin-card-border: rgba(148, 163, 184, 0.2);
            --admin-card-shadow: 0 25px 60px rgba(2, 6, 23, 0.55);
            --admin-card-outline: rgba(255, 255, 255, 0.03);
            --admin-metric-overlay: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(14, 165, 233, 0.02));
            --admin-metric-hover-border: rgba(59, 130, 246, 0.35);
            --admin-chip-label: rgba(148, 163, 184, 0.85);
            --admin-metric-value: #f8fafc;
            --admin-icon-ring: rgba(148, 163, 184, 0.25);
            --admin-icon-ring-outline: rgba(255, 255, 255, 0.08);
            --admin-trend-positive: #34d399;
            --admin-trend-warning: #fb923c;
            --admin-chart-bg: linear-gradient(160deg, rgba(30, 64, 175, 0.22), rgba(15, 23, 42, 0.65));
            --admin-chart-shadow: drop-shadow(0 15px 35px rgba(15, 23, 42, 0.55));
            --admin-chart-title: #f8fafc;
            --admin-chart-muted: rgba(148, 163, 184, 0.75);
            --admin-chip-text: #dbeafe;
            --admin-chip-border: rgba(59, 130, 246, 0.45);
            --admin-chip-bg: rgba(59, 130, 246, 0.16);
            --admin-chip-purple-text: #f5e1ff;
            --admin-chip-purple-border: rgba(168, 85, 247, 0.45);
            --admin-chip-purple-bg: rgba(168, 85, 247, 0.18);
            --admin-activity-bg: rgba(15, 23, 42, 0.55);
            --admin-activity-border: rgba(148, 163, 184, 0.3);
            --admin-activity-row-bg: rgba(15, 23, 42, 0.65);
            --admin-activity-row-border: rgba(148, 163, 184, 0.2);
            --admin-activity-hover-border: rgba(59, 130, 246, 0.45);
            --admin-activity-empty-bg: rgba(2, 6, 23, 0.45);
            --admin-activity-empty-text: #cbd5f5;
            --admin-subtle-link-text: #67e8f9;
            --admin-subtle-link-bg: rgba(6, 182, 212, 0.08);
            --admin-subtle-link-hover-bg: rgba(6, 182, 212, 0.14);
            --admin-subtle-link-border: rgba(103, 232, 249, 0.45);
            --admin-heading-gradient: linear-gradient(125deg, #f8fafc, #93c5fd, #c084fc);
            --admin-eyebrow-color: rgba(148, 163, 184, 0.85);
            --admin-pulse-color: #34d399;
            --admin-pulse-shadow: rgba(52, 211, 153, 0.75);
        }
        .admin-theme .dashboard-shell {
            position: relative;
            z-index: 1;
            padding-bottom: 2rem;
        }
        .admin-theme .dashboard-shell::before {
            content: '';
            position: absolute;
            inset: 0 -2rem -2rem;
            border-radius: 2.5rem;
            background: var(--admin-shell-highlight);
            opacity: 0.55;
            filter: blur(45px);
            z-index: -1;
            pointer-events: none;
        }
        .admin-theme .header-panel {
            padding: 1.75rem;
            border-radius: 1.5rem;
            border: 1px solid var(--admin-panel-border);
            background: var(--admin-panel-bg);
            box-shadow: var(--admin-panel-shadow);
            backdrop-filter: blur(30px);
            color: var(--admin-text-primary);
        }
        .admin-theme .header-panel p {
            color: var(--admin-text-secondary);
        }
        .admin-theme .card {
            width: 100%;
            border-radius: 1.65rem;
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-card-border);
            box-shadow: var(--admin-card-shadow);
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
            color: var(--admin-text-primary);
        }
        .admin-theme .card::after {
            content: '';
            position: absolute;
            inset: 1px;
            border-radius: inherit;
            border: 1px solid var(--admin-card-outline);
            pointer-events: none;
        }
        .admin-theme .metric-card {
            transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
            background: var(--admin-metric-overlay), var(--admin-card-bg);
        }
        .admin-theme .metric-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 35px 70px rgba(2, 6, 23, 0.25);
            border-color: var(--admin-metric-hover-border);
        }
        .admin-theme .chip-label {
            letter-spacing: 0.08em;
            color: var(--admin-chip-label);
        }
        .admin-theme .metric-value {
            color: var(--admin-metric-value);
            letter-spacing: -0.02em;
        }
        .admin-theme .icon-ring {
            position: relative;
            box-shadow: inset 0 0 0 1px var(--admin-icon-ring);
        }
        .admin-theme .icon-ring::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 1rem;
            /* border: 1px solid var(--admin-icon-ring-outline); */
            opacity: 0.65;
            pointer-events: none;
        }
        .admin-theme .trend-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .admin-theme .trend-indicator::before {
            content: '\2197';
            font-size: 0.85rem;
        }
        .admin-theme .trend-indicator.positive {
            color: var(--admin-trend-positive);
        }
        .admin-theme .trend-indicator.caution {
            color: var(--admin-trend-warning);
        }
        .admin-theme .trend-indicator.caution::before {
            content: '\23F3';
        }
        .admin-theme .chart-card {
            min-height: 360px;
            /* background: transparent; */
        }
        .admin-theme .chart-card canvas {
            filter: var(--admin-chart-shadow);
        }
        .admin-theme .chart-card h3 {
            color: var(--admin-chart-title);
        }
        .admin-theme .chart-card p {
            color: var(--admin-chart-muted);
        }
        .admin-theme .stat-chip {
            border: 1px solid var(--admin-chip-border);
            background: var(--admin-chip-bg);
            color: var(--admin-chip-text);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .admin-theme .stat-chip.purple {
            border-color: var(--admin-chip-purple-border);
            background: var(--admin-chip-purple-bg);
            color: var(--admin-chip-purple-text);
        }
        .admin-theme .activity-card {
            border-style: dashed;
            background: var(--admin-activity-bg);
            border-color: var(--admin-activity-border);
        }
        .admin-theme .activity-item {
            border: 1px solid var(--admin-activity-row-border);
            background: var(--admin-activity-row-bg);
            transition: border-color 0.3s ease, transform 0.3s ease, background-color 0.3s ease;
        }
        .admin-theme .activity-item:hover {
            border-color: var(--admin-activity-hover-border);
            transform: translateX(4px);
        }
        .admin-theme .activity-card p.text-sm {
            color: var(--admin-text-primary);
        }
        .admin-theme .activity-card p.text-xs {
            color: var(--admin-text-secondary);
        }
        .admin-theme .activity-card .p-8 {
            background: var(--admin-activity-empty-bg);
            border-color: var(--admin-activity-border);
        }
        .admin-theme .activity-card .p-8 p {
            color: var(--admin-activity-empty-text);
        }
        .admin-theme .pulse-dot {
            position: relative;
            padding-left: 1.5rem;
            color: var(--admin-pulse-color);
        }
        .admin-theme .pulse-dot::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0.55rem;
            height: 0.55rem;
            border-radius: 9999px;
            background: var(--admin-pulse-color);
            box-shadow: 0 0 12px var(--admin-pulse-shadow);
            animation: pulse 1.8s infinite;
        }
        .admin-theme .subtle-link {
            border: 1px solid var(--admin-subtle-link-border);
            padding: 0.45rem 1.35rem;
            border-radius: 9999px;
            background: var(--admin-subtle-link-bg);
            color: var(--admin-subtle-link-text);
            transition: border-color 0.3s ease, background 0.3s ease, color 0.3s ease;
        }
        .admin-theme .subtle-link:hover {
            background: var(--admin-subtle-link-hover-bg);
        }
        .admin-theme .gradient-text {
            background: var(--admin-heading-gradient);
            -webkit-background-clip: text;
            color: transparent;
            position: relative;
            padding-top: 1rem;
        }
        .admin-theme .gradient-text::before {
            content: attr(data-eyebrow);
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: var(--admin-eyebrow-color);
            margin-bottom: 0.35rem;
        }
        .admin-theme .module-subtext {
            color: var(--admin-text-secondary);
        }
        @keyframes pulse {
            0% { opacity: 0.8; transform: scale(0.9); }
            50% { opacity: 0.2; transform: scale(1.25); }
            100% { opacity: 0.8; transform: scale(0.9); }
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-all admin-theme @yield('body_class')">

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
            if (themeBtn) {
                themeBtn.innerHTML = '<i class="bi bi-sun text-lg"></i>';
            }
        }
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('sidebar-collapsed');
            mainContent.classList.add('ml-sidebar-collapsed');
            mainContent.classList.remove('ml-sidebar');
        }
    </script>
</body>
</html>
