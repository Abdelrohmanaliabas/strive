@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
                <button 
                    onclick="markAllAsRead()"
                    class="px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300"
                >
                    Mark all as read
                </button>
            </div>
        </div>

        <div id="notifications-container" class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Notifications will be loaded here -->
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <svg class="animate-spin h-8 w-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p>Loading notifications...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();

    function loadNotifications() {
        fetch('{{ route("notifications.index") }}')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('notifications-container');
                
                if (data.notifications && data.notifications.length > 0) {
                    container.innerHTML = data.notifications.map(notification => `
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors ${notification.read_at ? '' : 'bg-indigo-50 dark:bg-indigo-900/20'}" data-id="${notification.id}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">${notification.data?.message || 'New notification'}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${notification.created_at}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    ${!notification.read_at ? '<span class="w-2 h-2 bg-indigo-500 rounded-full"></span>' : ''}
                                    <button 
                                        onclick="markAsRead('${notification.id}')"
                                        class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300"
                                    >
                                        ${notification.read_at ? 'Read' : 'Mark as read'}
                                    </button>
                                    <button 
                                        onclick="deleteNotification('${notification.id}')"
                                        class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 ml-2"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = `
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p>No notifications</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notifications-container').innerHTML = `
                    <div class="p-8 text-center text-red-500">
                        <p>Error loading notifications. Please refresh the page.</p>
                    </div>
                `;
            });
    }

    window.markAsRead = function(id) {
        fetch(`{{ route("notifications.read", ":id") }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const element = document.querySelector(`[data-id="${id}"]`);
                if (element) {
                    element.classList.remove('bg-indigo-50', 'dark:bg-indigo-900/20');
                    element.querySelector('.w-2').remove();
                }
                loadNotifications();
            }
        });
    };

    window.markAllAsRead = function() {
        fetch('{{ route("notifications.read-all") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        });
    };

    window.deleteNotification = function(id) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`{{ route("notifications.destroy", ":id") }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            });
        }
    };
});
</script>
@endsection

