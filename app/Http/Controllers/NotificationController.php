<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  public function dashboard()
  {
    // $notificationsCount = Auth::guard('admin')->user()->notifications()->whereNull('read_at')->count();
    $notificationsCount = 10;
    return view('dashboard', ['notificationsCount' => $notificationsCount]);
  }
}
