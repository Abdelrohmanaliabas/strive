<aside id="sidebar"
       class="fixed top-0 left-0 h-screen w-60 bg-indigo-700 text-white flex flex-col justify-between transition-all shadow-lg z-50">

    {{-- ====== Header ====== --}}
    <div>
        <div class="flex items-center justify-center h-16 border-b border-indigo-500">
            <i class="bi bi-speedometer2 text-2xl"></i>
            <span class="ml-2 font-semibold text-lg sidebar-text">Admin Panel</span>
        </div>

        {{-- ====== Navigation ====== --}}
        <nav class="flex flex-col mt-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">
                <i class="bi bi-house-door text-xl"></i>
                <span class="ml-3 sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.show') ? 'bg-indigo-600' : '' }}">
                <i class="bi bi-people text-xl"></i>
                <span class="ml-3 sidebar-text">Users</span>
            </a>

            <a href="{{ route('admin.analytics.index') }}"
               class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.analytics.index') ? 'bg-indigo-600' : '' }}">
                <i class="bi bi-bar-chart-line text-xl"></i>
                <span class="ml-3 sidebar-text">Analytics</span>
            </a>

            <a href="{{ route('admin.comments.index') }}"
               class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.comments.index') ? 'bg-indigo-600' : '' }}">
                <i class="bi bi-chat-dots text-xl"></i>
                <span class="ml-3 sidebar-text">Comments</span>
            </a>
            <a href="{{ route('admin.jobpost.index') }}" class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.jobpost.index') ? 'bg-indigo-600' : '' }}">
                <i class="bi bi-briefcase text-xl"></i> <span class="ml-3 sidebar-text">Job Post</span>
                </a>    
        </nav>
    </div>

    {{-- ====== Bottom Section ====== --}}
    <div class="flex flex-col space-y-1 mb-4">
        <a href="{{ route('admin.analytics.index') }}"
           class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('admin.analytics.index') ? 'bg-indigo-600' : '' }}">
            <i class="bi bi-gear text-xl"></i>
            <span class="ml-3 sidebar-text">Settings</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-5 py-3 hover:bg-indigo-600 rounded-md transition-all {{ request()->routeIs('profile.edit') ? 'bg-indigo-600' : '' }}">
            <i class="bi bi-person text-xl"></i>
            <span class="ml-3 sidebar-text">Profile</span>
        </a>
    </div>

    {{-- ====== Collapse Style ====== --}}
    <style>
        .sidebar-collapsed .sidebar-text { display: none; }
        .sidebar-collapsed { width: 4.5rem !important; }
        .sidebar-collapsed .ml-3 { margin-left: 0 !important; }
    </style>
</aside>
