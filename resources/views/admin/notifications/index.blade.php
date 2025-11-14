@extends('layouts.admin')

@section('title', 'Notifications')
@section('page_title', 'Notifications')
@section('body_class', 'admin-theme')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text">Notifications</h1>
            <p class="text-sm text-slate-300/90 mt-1">Manage and view all your notifications</p>
        </div>
        <div class="flex items-center gap-3">
            @if($unreadCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors text-sm font-medium">
                        Mark all as read
                    </button>
                </form>
            @endif
            <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-sm font-medium">
                {{ $unreadCount }} unread
            </span>
        </div>
    </header>

    {{-- Notifications List --}}
    <div class="card p-6 rounded-lg border border-slate-700/50">
        @if($notifications->count() > 0)
            <div class="space-y-3" x-data="notificationHandler()" x-init="init()">
                @foreach($notifications as $notification)
                    @php
                        $data = $notification->data ?? [];
                        $routeUrl = $data['route_url'] ?? '#';
                        $isRead = !is_null($notification->read_at);
                    @endphp
                    <div 
                        class="p-4 rounded-lg border transition-all cursor-pointer hover:shadow-lg {{ $isRead ? 'bg-slate-800/30 border-slate-700/50' : 'bg-indigo-500/10 border-indigo-500/30' }}"
                        @click="handleNotificationClick('{{ $notification->id }}', '{{ $routeUrl }}')"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    @if(!$isRead)
                                        <span class="w-2 h-2 bg-indigo-500 rounded-full flex-shrink-0"></span>
                                    @endif
                                    <span class="text-xs font-semibold uppercase text-slate-400">
                                        {{ ucfirst(str_replace('_', ' ', $data['type'] ?? 'notification')) }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-slate-200 leading-relaxed">
                                    {{ $data['message'] ?? 'New notification' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <form action="{{ route('notifications.destroy', $notification->id) }}" 
                                      method="POST" 
                                      @click.stop
                                      onsubmit="return confirm('Are you sure you want to delete this notification?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-slate-400 hover:text-red-400 transition-colors rounded-lg hover:bg-red-500/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-12 text-center rounded-2xl border border-dashed border-slate-700/60 bg-slate-900/30">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <p class="text-slate-300/90 text-sm tracking-wide">No notifications yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
function notificationHandler() {
    return {
        init() {
            // Poll for new notifications every 30 seconds
            setInterval(() => {
                this.checkNewNotifications();
            }, 30000);
        },

        async handleNotificationClick(notificationId, routeUrl) {
            // Mark as read
            try {
                await fetch(`{{ route('notifications.read', ':id') }}`.replace(':id', notificationId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }

            // Redirect to the notification's detail page
            if (routeUrl && routeUrl !== '#') {
                window.location.href = routeUrl;
            }
        },

        async checkNewNotifications() {
            try {
                const response = await fetch('{{ route("notifications.count") }}');
                const data = await response.json();
                // Update unread count badge if needed
                if (data.count > {{ $unreadCount }}) {
                    location.reload(); // Reload to show new notifications
                }
            } catch (error) {
                console.error('Error checking notifications:', error);
            }
        }
    }
}
</script>
@endsection

