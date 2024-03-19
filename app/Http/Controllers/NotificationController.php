<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class NotificationController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      $notifications = Auth::user()->unreadNotifications->map(function ($notification) {
        return [
          'id' => $notification->id,
          'type' => $notification->type,
          'notifiable_type' => $notification->notifiable_type,
          'notifiable_id' => $notification->notifiable_id,
          'data' => $notification->data,
          'read_at' => $notification->read_at,
          'created_at' => $notification->created_at->diffForHumans(), // Format created_at with diffForHumans()
          'updated_at' => $notification->updated_at,
        ];
      });

      $notificationsCount = $notifications->count();

      return [
        'notifications' => $notifications,
        'notificationsCount' => $notificationsCount,
      ];
    }
  }

  public function mark_notification_as_read(Request $request)
  {
    try {
      // Validate the incoming request
      $request->validate([
        'notification_id' => 'required|exists:notifications,id',
        'notification_type' => 'required|in:transaction,phone',
      ]);

      // Find the notification
      $notification = Auth::user()->notifications->find($request->notification_id);

      if (!$notification) {
        return response()->json(['message' => 'Notification not found.'], 404);
      }

      // Mark the notification as read
      $notification->markAsRead();

      return response()->json(['message' => 'Notification marked as read.']);
    } catch (\Exception $e) {
      return response()->json(['message' => $e->getMessage()], 500);
    }
  }
}