<?php

namespace App\Livewire;

use Livewire\Component;


class Notifications extends Component
{
    public $notifications;
    public $notificationsCount;
    public function MarkAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }
    
    public function MarkAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
    
    public function render()
    {
        $this->notifications = auth()->user()->unreadNotifications;
        $this->notificationsCount = auth()->user()->unreadNotifications->count();
        // dd($this->notifications);
        return view(
            'livewire.notifications',
            [
                'notifications' => $this->notifications,
                'notificationsCount' => $this->notificationsCount
            ]
        );
    }
}