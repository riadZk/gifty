<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /** GET /notifications — list latest 20 notifications for auth user */
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn ($n) => [
                "id"         => $n->id,
                "data"       => $n->data,
                "read"       => ! is_null($n->read_at),
                "created_at" => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            "items"  => $notifications,
            "unread" => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /** GET /notifications/all — paginated list with filters */
    public function all(Request $request): View
    {
        $query = $request->user()->notifications()->latest();

        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->whereNotNull('read_at');
            } elseif ($request->status === 'unread') {
                $query->whereNull('read_at');
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $notifications = $query->paginate(20)->withQueryString();
        $unreadCount   = $request->user()->unreadNotifications()->count();

        return view('content.notifications.index', compact('notifications', 'unreadCount'));
    }

    /** POST /notifications/mark-read — mark all notifications as read */
    public function markRead(Request $request): JsonResponse|RedirectResponse
    {
        $request->user()->unreadNotifications()->update(["read_at" => now()]);

        if ($request->expectsJson()) {
            return response()->json(["unread" => 0]);
        }

        return redirect()->back();
    }

    /** POST /notifications/{id}/read — mark a single notification as read */
    public function markSingle(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(["unread" => $request->user()->unreadNotifications()->count()]);
        }

        return redirect()->back();
    }
}
