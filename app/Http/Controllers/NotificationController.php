<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function dashboard()
  {
    // send notifications and notifications count of the admin who islloged in to the dashbored layout 
    $notifications = Auth::user()->notifications; 
    $notificationsCount = Auth::user()->unreadNotifications->count();
    return view('dashbored', ['notifications' => $notifications, 'notificationsCount' => $notificationsCount]);
  }
}
