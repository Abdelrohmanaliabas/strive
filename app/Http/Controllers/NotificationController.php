<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $notifications = Auth::user()->notifications()
            ->when($request->has('unread_only'), fn($q) => $q->whereNull('read_at'))
            ->latest()
            ->take($request->get('limit', 20))
            ->get();

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                $data = $notification->data ?? [];
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'data' => $data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'created_at_raw' => $notification->created_at->toDateTimeString(),
                    'route_url' => $data['route_url'] ?? '#',
                ];
            }),
            'unread_count' => Auth::user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Get unread notification count.
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(string $id): JsonResponse
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Not found'], 404);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(string $id): JsonResponse
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
