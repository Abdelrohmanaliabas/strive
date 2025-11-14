@php
    $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
@endphp

<div class="relative notification-bell-container" x-data="notificationDropdown()" x-init="init()">
    <!-- Notification Bell Button -->
    <button 
        @click="toggleDropdown()"
        class="notification-bell-button relative inline-flex items-center justify-center rounded-full border border-amber-400/40 bg-amber-400/10 px-4 py-2.5 text-sm font-semibold tracking-wide text-amber-200 transition-all hover:-translate-y-0.5 hover:bg-amber-400/20 hover:border-amber-400/60 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:ring-offset-2 focus:ring-offset-slate-950"
        aria-label="Notifications"
    >
        <svg class="w-5 h-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        <!-- Badge -->
        <span 
            x-show="unreadCount > 0"
            x-text="unreadCount"
            class="notification-badge absolute -top-1 -right-1 flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-slate-950 shadow-lg animate-pulse"
        ></span>
        
        <!-- Unread indicator pulse -->
        <span 
            x-show="unreadCount > 0"
            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center"
        >
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
        </span>
    </button>

    <!-- Backdrop for mobile -->
    <div 
        x-show="isOpen"
        @click="closeDropdown()"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-40 md:hidden"
        style="display: none;"
    ></div>

    <!-- Dropdown - Mobile: Bottom Sheet, Desktop: Dropdown -->
    <div 
        x-show="isOpen"
        @click.away="closeDropdown()"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="md:transform md:opacity-0 md:scale-95 transform translate-y-full md:translate-y-0"
        x-transition:enter-end="md:transform md:opacity-100 md:scale-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="md:transform md:opacity-100 md:scale-100 transform translate-y-0"
        x-transition:leave-end="md:transform md:opacity-0 md:scale-95 transform translate-y-full md:translate-y-0"
        class="notification-dropdown fixed bottom-0 left-0 right-0 md:absolute md:bottom-auto md:right-0 md:left-auto md:top-full md:mt-2 w-full md:w-80 lg:w-96 bg-slate-900 md:rounded-lg rounded-t-2xl shadow-2xl border border-slate-700/50 z-50 flex flex-col backdrop-blur-xl"
        :style="getDropdownStyle()"
        style="display: none;"
    >
        <!-- Mobile: Drag Handle -->
        <div class="md:hidden flex justify-center pt-3 pb-2">
            <div class="w-12 h-1 bg-slate-600 rounded-full"></div>
        </div>

        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-slate-700/50 flex-shrink-0">
            <h3 class="text-lg font-semibold text-slate-200">Notifications</h3>
            <div class="flex items-center gap-2">
                <button 
                    @click="markAllAsRead()"
                    x-show="unreadCount > 0"
                    class="text-xs text-indigo-400 hover:text-indigo-300 px-2 py-1 rounded hover:bg-indigo-500/10 transition-colors"
                    style="display: none;"
                >
                    Mark all as read
                </button>
                <button 
                    @click="closeDropdown()"
                    class="text-slate-400 hover:text-slate-300 p-1 rounded-lg hover:bg-slate-800/50 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Notifications List - Scrollable -->
        <div class="overflow-y-auto flex-1 min-h-0 overscroll-contain" style="-webkit-overflow-scrolling: touch;">
            <template x-if="loading">
                <div class="p-4 text-center text-slate-400">
                    <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-slate-400">Loading notifications...</p>
                </div>
            </template>

            <template x-if="!loading && notifications.length === 0">
                <div class="p-12 text-center rounded-2xl border border-dashed border-slate-700/60 bg-slate-900/30 m-2">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-slate-300/90 text-sm tracking-wide">No notifications yet.</p>
                </div>
            </template>

            <template x-if="!loading && notifications.length > 0">
                <div class="space-y-3 p-2">
                    <template x-for="notification in notifications" :key="notification.id">
                        <div 
                            @click="handleNotificationClick(notification.id, notification.route_url || '#', notification.data)"
                            :class="notification.read_at ? 'bg-slate-800/30 border-slate-700/50' : 'bg-indigo-500/10 border-indigo-500/30'"
                            class="p-4 rounded-lg border transition-all cursor-pointer hover:shadow-lg touch-manipulation"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span 
                                            x-show="!notification.read_at"
                                            class="w-2 h-2 bg-indigo-500 rounded-full flex-shrink-0"
                                            style="display: none;"
                                        ></span>
                                        <span class="text-xs font-semibold uppercase text-slate-400" x-text="getNotificationType(notification)"></span>
                                        <span class="text-xs text-slate-500" x-text="notification.created_at"></span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-200 leading-relaxed" x-text="getNotificationMessage(notification)"></p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <button 
                                        @click.stop="deleteNotification(notification.id)"
                                        class="p-2 text-slate-400 hover:text-red-400 transition-colors rounded-lg hover:bg-red-500/10"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="p-3 border-t border-slate-700/50 text-center flex-shrink-0">
            <a 
                href="{{ route('admin.notifications') ?? route('notifications.page') ?? '#' }}"
                @click="closeDropdown()"
                class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition-colors"
            >
                View all notifications
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
            this.fetchNotifications();
            this.fetchCount();
            
            // Poll for new notifications every 30 seconds
            setInterval(() => {
                if (!this.isOpen) {
                    this.fetchCount();
                }
            }, 30000);
            
            // Prevent body scroll on mobile when dropdown is open
            this.$watch('isOpen', (value) => {
                if (value && window.innerWidth < 768) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            });
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.fetchNotifications();
            }
        },

        closeDropdown() {
            this.isOpen = false;
            // Restore body scroll
            document.body.style.overflow = '';
        },

        async fetchNotifications() {
            this.loading = true;
            try {
                const response = await fetch('{{ route("notifications.index") }}');
                const data = await response.json();
                this.notifications = data.notifications || [];
                this.unreadCount = data.unread_count || 0;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchCount() {
            try {
                const response = await fetch('{{ route("notifications.count") }}');
                const data = await response.json();
                this.unreadCount = data.count || 0;
            } catch (error) {
                console.error('Error fetching notification count:', error);
            }
        },

        async markAsRead(id) {
            try {
                const response = await fetch(`{{ route("notifications.read", ":id") }}`.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    const notification = this.notifications.find(n => n.id === id);
                    if (notification) {
                        notification.read_at = new Date().toISOString();
                    }
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        },

        async handleNotificationClick(id, routeUrl, notificationData) {
            // Mark as read first
            await this.markAsRead(id);
            
            // Close dropdown immediately for better UX
            this.closeDropdown();
            
            // Get notification data for deep linking
            const notification = this.notifications.find(n => n.id === id);
            const data = notification?.data || notificationData || {};
            const type = data.type || '';
            
            // Build the correct route based on notification type with deep linking
            let finalUrl = routeUrl;
            
            if (routeUrl && routeUrl !== '#') {
                // Add hash/anchor for specific items based on notification type
                switch(type) {
                    case 'comment_added':
                        // For comments, go to job detail page and scroll to comment
                        if (data.commentable_id && data.comment_id) {
                            finalUrl = routeUrl + '#comment-' + data.comment_id;
                            // After navigation, scroll to the comment
                            setTimeout(() => {
                                const commentEl = document.getElementById('comment-' + data.comment_id);
                                if (commentEl) {
                                    commentEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    commentEl.classList.add('highlight-comment');
                                    setTimeout(() => commentEl.classList.remove('highlight-comment'), 2000);
                                }
                            }, 100);
                        }
                        break;
                        
                    case 'job_applied':
                        // For job applications, go to application detail page
                        if (data.application_id) {
                            finalUrl = routeUrl;
                            // After navigation, highlight the application
                            setTimeout(() => {
                                const appEl = document.getElementById('application-' + data.application_id) 
                                    || document.querySelector('[data-application-id="' + data.application_id + '"]');
                                if (appEl) {
                                    appEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    appEl.classList.add('highlight-application');
                                    setTimeout(() => appEl.classList.remove('highlight-application'), 2000);
                                }
                            }, 100);
                        }
                        break;
                        
                    case 'application_status':
                        // For application status, go to job detail page
                        if (data.job_post_id) {
                            finalUrl = routeUrl + '#application-status';
                            setTimeout(() => {
                                const statusEl = document.getElementById('application-status');
                                if (statusEl) {
                                    statusEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }, 100);
                        }
                        break;
                        
                    case 'job_posted':
                    case 'job_approved':
                    case 'job_rejected':
                    case 'contact_us':
                        // These already have correct routes, just navigate
                        finalUrl = routeUrl;
                        break;
                        
                    default:
                        // Default: use the route_url as is
                        finalUrl = routeUrl;
                }
                
                // Navigate to the detail page
                window.location.href = finalUrl;
            }
        },

        async markAllAsRead() {
            try {
                const response = await fetch('{{ route("notifications.read-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    this.notifications.forEach(n => {
                        n.read_at = new Date().toISOString();
                    });
                    this.unreadCount = 0;
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        },

        async deleteNotification(id) {
            try {
                const response = await fetch(`{{ route("notifications.destroy", ":id") }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                    if (!this.notifications.find(n => n.id === id)?.read_at) {
                        this.unreadCount = Math.max(0, this.unreadCount - 1);
                    }
                }
            } catch (error) {
                console.error('Error deleting notification:', error);
            }
        },

        getNotificationMessage(notification) {
            const data = notification.data || {};
            return data.message || 'New notification';
        },

        getNotificationType(notification) {
            const data = notification.data || {};
            const type = data.type || 'notification';
            // Convert snake_case to Title Case
            return type.split('_').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1)
            ).join(' ');
        },

        getDropdownStyle() {
            // Calculate max height based on viewport
            const isMobile = window.innerWidth < 768;
            const viewportHeight = window.innerHeight;
            
            if (isMobile) {
                // Mobile: bottom sheet with max 85% of viewport height, minimum 300px
                const maxHeight = Math.max(300, viewportHeight * 0.85);
                return `max-height: ${maxHeight}px;`;
            } else {
                // Desktop: dropdown with max height that fits viewport (leave space for navbar)
                const maxHeight = Math.max(400, viewportHeight - 120);
                return `max-height: ${maxHeight}px;`;
            }
        }
    }
}
</script>

<style>
/* Highlight animations for deep-linked items */
.highlight-comment {
    animation: highlightPulse 2s ease-in-out;
    background-color: rgba(99, 102, 241, 0.1) !important;
    border-left: 3px solid rgb(99, 102, 241) !important;
    padding-left: 1rem;
    transition: all 0.3s ease;
}

.highlight-application {
    animation: highlightPulse 2s ease-in-out;
    background-color: rgba(34, 197, 94, 0.1) !important;
    border-left: 3px solid rgb(34, 197, 94) !important;
    padding-left: 1rem;
    transition: all 0.3s ease;
}

@keyframes highlightPulse {
    0%, 100% {
        background-color: rgba(99, 102, 241, 0.1);
    }
    50% {
        background-color: rgba(99, 102, 241, 0.2);
    }
}

/* Prevent body scroll when dropdown is open on mobile */
body:has([x-data*="notificationDropdown"] [x-show="isOpen"]) {
    overflow: hidden;
}

@media (min-width: 768px) {
    body:has([x-data*="notificationDropdown"] [x-show="isOpen"]) {
        overflow: auto;
    }
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Better touch targets on mobile */
@media (max-width: 767px) {
    [x-data*="notificationDropdown"] [x-show="isOpen"] button,
    [x-data*="notificationDropdown"] [x-show="isOpen"] a {
        min-height: 44px;
        min-width: 44px;
    }
}

/* Enhanced notification bell button styling for dashboard */
.notification-bell-container {
    z-index: 10;
}

.notification-bell-button {
    position: relative;
    min-width: 44px;
    min-height: 44px;
}

.notification-bell-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(251, 191, 36, 0.3);
}

.notification-badge {
    animation: badgeBounce 0.5s ease-in-out;
    z-index: 1;
}

@keyframes badgeBounce {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
}

/* Responsive adjustments for bell button */
@media (max-width: 640px) {
    .notification-bell-button {
        padding: 0.5rem;
        min-width: 40px;
        min-height: 40px;
    }
    
    .notification-bell-button svg {
        width: 1.25rem;
        height: 1.25rem;
    }
}

/* Ensure dropdown appears correctly from new position */
.notification-dropdown {
    /* Mobile: fixed positioning for bottom sheet */
    /* Desktop: absolute positioning relative to bell button */
    background: rgb(15 23 42) !important; /* slate-900 solid background */
}

@media (min-width: 768px) {
    .notification-bell-container {
        position: relative;
    }
    
    .notification-dropdown {
        position: absolute !important;
        right: 0;
        left: auto;
        top: calc(100% + 0.5rem);
        bottom: auto;
        width: 20rem;
        max-width: 90vw;
    }
}

@media (max-width: 767px) {
    .notification-dropdown {
        position: fixed !important;
        bottom: 0;
        left: 0;
        right: 0;
        top: auto;
        width: 100%;
        max-width: 100%;
        border-radius: 1.5rem 1.5rem 0 0;
    }
}

/* Match Admin Dashboard notification card styles exactly - ensure solid backgrounds */
.notification-dropdown [class*="bg-slate-800"] {
    background-color: rgba(30, 41, 59, 0.3) !important;
    border-color: rgba(51, 65, 85, 0.5) !important;
}

.notification-dropdown [class*="bg-indigo-500"] {
    background-color: rgba(99, 102, 241, 0.1) !important;
    border-color: rgba(99, 102, 241, 0.3) !important;
}

/* Ensure text colors match Admin Dashboard exactly */
.notification-dropdown [class*="text-slate-200"] {
    color: rgb(226, 232, 240) !important;
}

.notification-dropdown [class*="text-slate-400"] {
    color: rgb(148, 163, 184) !important;
}

.notification-dropdown [class*="text-slate-500"] {
    color: rgb(100, 116, 139) !important;
}

/* Ensure borders are visible and match Admin style */
.notification-dropdown .rounded-lg.border {
    border-width: 1px !important;
}
</style>

