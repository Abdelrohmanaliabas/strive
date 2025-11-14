
<aside id="sidebar"
       class="fixed top-0 left-0 h-screen w-60  flex flex-col justify-between transition-all shadow-lg z-50">

    {{-- ====== Header ====== --}}
    <div>
        <div class="flex items-center justify-center h-16 border-b ">
            <i class="bi bi-speedometer2 text-2xl"></i>
            <span class="ml-2 font-semibold text-lg sidebar-text">strive</span>
        </div>

        {{-- ====== Navigation ====== --}}
        <nav class="flex flex-col mt-4 space-y-1 ">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-5 py-1 mx-5 rounded-full transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-900/30' : '' }}">
                <i class="bi bi-house-door text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.notifications') }}"
               class="flex items-center px-5 py-1 mx-5 rounded-full transition-all {{ request()->routeIs('admin.notifications') ? 'bg-blue-900/30' : '' }} relative">
                <i class="bi bi-bell text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Notifications</span>
                @auth
                    @php
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-2 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full sidebar-text">{{ $unreadCount }}</span>
                    @endif
                @endauth
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center px-5 py-1 mx-5 rounded-full transition-all {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.show') ? 'bg-blue-900/30' : '' }}">
                <i class="bi bi-people text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Users</span>
            </a>

            <a href="{{ route('admin.analytics.index') }}"
               class="flex items-center px-5 py-1 mx-5 rounded-full transition-all  {{ request()->routeIs('admin.analytics.index') || request()->routeIs('admin.analytics.show') ? 'bg-blue-900/30' : '' }}">
                <i class="bi bi-bar-chart-line text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Analytics</span>
            </a>

            <a href="{{ route('admin.comments.index') }}"
               class="flex items-center px-5 py-1 mx-5 rounded-full transition-all  {{ request()->routeIs('admin.comments.index') || request()->routeIs('admin.comments.show') ? 'bg-blue-900/30' : '' }}">
                <i class="bi bi-chat-dots text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Comments</span>
            </a>
            <a href="{{ route('admin.jobpost.index') }}"
            class="flex items-center px-5 py-1 mx-5 rounded-full transition-all {{ request()->routeIs('admin.jobpost.index') || request()->routeIs('admin.jobpost.show') ? 'bg-blue-900/30' : '' }}">
                <i class="bi bi-briefcase text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Job Post</span>
                </a>
        </nav>
    </div>

    {{-- ====== Bottom Section ====== --}}
    <div class="flex flex-col space-y-1 mb-4">
        <a href="{{ route('admin.settings.index') }}"
           class="flex items-center px-5 py-1 rounded-full mx-5 transition-all {{ request()->routeIs('admin.settings.index') ? 'bg-blue-900/30' : '' }}">
            <i class="bi bi-gear text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
            <span class="ml-3 sidebar-text">Settings</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-5 py-1 rounded-full mx-5 transition-all {{ request()->routeIs('admin.profile.edit') ? 'bg-blue-900/30' : '' }}">
            <i class="bi bi-person text-xl border-2 w-10 h-10 text-center" style="border-radius: 50%;"></i>
            <span class="ml-3 sidebar-text">Profile</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center px-5 py-1 hover:bg-red-700 rounded-full w-48 mx-5 transition-all text-red-700 hover:text-white">
                <i class="bi bi-box-arrow-right text-xl border-2 w-10 h-10 text-center border-red-700" style="border-radius: 50%;"></i>
                <span class="ml-3 sidebar-text">Logout</span>
            </button>
        </form>
    </div>

    {{-- ====== Collapse Style ====== --}}
    <style>
        .sidebar-collapsed .sidebar-text { display: none; }
        .sidebar-collapsed { width: 4.5rem !important; }
        .sidebar-collapsed { margin: 0 !important; }

        i{
            justify-content: center;
            align-items: center;
            display: flex;
            
        }
    </style>
</aside>
