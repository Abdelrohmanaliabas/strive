@php
    $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
@endphp

<div class="relative inline-block" x-data="notificationDropdown()" x-init="init()">
    <!-- Bell Button -->
    <button @click="toggleDropdown()"
        class="relative p-3 rounded-full hover:bg-white/10 transition-all duration-200 group">
        <svg class="w-6 h-6 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        <!-- Badge -->
        <span x-show="unreadCount > 0" x-text="unreadCount"
            class="absolute -top-1 -right-1 min-w-5 h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-slate-900 flex items-center justify-center animate-pulse shadow-lg">
        </span>
    </button>

    <!-- Dropdown (الأهم: z-50 + top-full + right-0) -->
    <div x-show="isOpen"
            @click.away="isOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 top-full mt-3 w-96 bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl overflow-hidden z-[9999] origin-top-right"
            style="display: none;">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-slate-700 bg-slate-800/50">
            <h3 class="text-lg font-bold text-white">Notifications</h3>
            <div class="flex items-center gap-3">
                <button @click="markAllAsRead()" x-show="unreadCount > 0"
                    class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">
                    Mark all as read
                </button>
                <button @click="isOpen = false" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="max-h-96 overflow-y-auto">
            <!-- Loading -->
            <template x-if="loading">
                <div class="p-8 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-indigo-500 border-t-transparent"></div>
                    <p class="mt-3 text-slate-400 text-sm">Loading...</p>
                </div>
            </template>

            <!-- Empty -->
            <template x-if="!loading && notifications.length === 0">
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-slate-400">No notifications yet.</p>
                </div>
            </template>

            <!-- Notifications -->
            <template x-if="!loading && notifications.length > 0">
                <div class="divide-y divide-slate-700">
                    <template x-for="n in notifications" :key="n.id">
                        <div @click="handleNotificationClick(n.id, n.route_url)"
                                class="p-4 hover:bg-slate-800/70 transition cursor-pointer"
                                :class="n.read_at ? 'bg-slate-800/30' : 'bg-indigo-500/10'">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                                        <span x-show="!n.read_at" class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                        <span x-text="n.type.split('\\').pop().replace('Notification','').replace(/_/g,' ').replace(/\w\S*/g, w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())"></span>
                                        <span class="text-slate-500" x-text="n.created_at"></span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-200 line-clamp-2"
                                        x-text="n.data.message || 'New notification'"></p>
                                </div>
                                <button @click.stop="deleteNotification(n.id)"
                                    class="text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-3 border-t border-slate-700 text-center bg-slate-800/50">
            <a href="{{ route('notifications.page') ?? '#' }}"
                @click="isOpen = false"
                class="text-sm font-medium text-indigo-400 hover:text-indigo-300">
                View all notifications →
            </a>
        </div>
    </div>
</div>

<script>
function notificationDropdown() {
    return {
        isOpen: false,
        notifications: [],
        unreadCount: {{ $unreadCount }},
        loading: false,

        init() {
            this.fetchCount();
            setInterval(() => !this.isOpen && this.fetchCount(), 30000);
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) this.fetchNotifications();
        },

        async fetchNotifications() {
            this.loading = true;
            try {
                const res = await fetch('{{ route("notifications.index") }}');
                const data = await res.json();

                this.notifications = (data.notifications || []).map(n => {
                    let parsed = {};
                    try { parsed = typeof n.data === 'string' ? JSON.parse(n.data) : (n.data || {}); }
                    catch(e) { parsed = {}; }

                    return {
                        id: n.id,
                        type: n.type,
                        data: parsed,
                        read_at: n.read_at,
                        created_at: n.created_at || 'Just now',
                        route_url: parsed.route_url || '#'
                    };
                });

                this.unreadCount = data.unread_count || 0;
            } catch (e) { console.error(e); }
            finally { this.loading = false; }
        },

        async fetchCount() {
            try {
                const res = await fetch('{{ route("notifications.count") }}');
                const data = await res.json();
                this.unreadCount = data.count || 0;
            } catch (e) {}
        },

        async markAsRead(id) {
            await fetch(`{{ route("notifications.read", ":id") }}`.replace(':id', id), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const n = this.notifications.find(x => x.id === id);
            if (n) n.read_at = new Date().toISOString();
            this.unreadCount = Math.max(0, this.unreadCount - 1);
        },

        async markAllAsRead() {
            await fetch('{{ route("notifications.read-all") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            this.notifications.forEach(n => n.read_at = new Date().toISOString());
            this.unreadCount = 0;
        },

        async deleteNotification(id) {
            await fetch(`{{ route("notifications.destroy", ":id") }}`.replace(':id', id), {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            this.notifications = this.notifications.filter(n => n.id !== id);
        },

        async handleNotificationClick(id, url) {
        try {
            await this.markAsRead(id);
            this.isOpen = false;
            if (url && url !== '#') {
                window.location.href = url;
            }
        } catch (error) {
            console.error("Error marking notification as read:", error);
            alert("An error occurred while processing the notification. Please try again.");
        }
        }
    }
}
</script>
