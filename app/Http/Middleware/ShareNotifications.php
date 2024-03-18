<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareNotifications
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $notifications = Auth::user()->unreadNotifications;
            $notificationsCount = Auth::user()->unreadNotifications->count();
            View::share('notifications', $notifications);
            View::share('notificationsCount', $notificationsCount);
        }

        return $next($request);
    }
}
