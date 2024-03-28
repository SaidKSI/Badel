<li class="nav-item dropdown" wire:poll.10s>
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" id="notification-Count">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">{{$notificationsCount}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="notification-menu"
        style="font-size: 15px; max-height: 300px; overflow-y: auto;">
        <li class="dropdown-header">
            You have {{$notificationsCount}} new notifications
            @if($notificationsCount > 3)
            <a href="#" wire:click.prevent="MarkAllAsRead"><span class="badge rounded-pill bg-primary p-2 ms-2">Read
                    all</span></a>
            @endif
        </li>
        @foreach ($notifications as $notification)
        <li class="notification-item p-3" data-notification-id="{{$notification->id}}"
            id="notification-{{ $notification->id }}">
            <i class="bi bi-check-circle text-success"></i>
            <a href="#" style="color: inherit" wire:click.prevent="MarkAsRead('{{ $notification->id }}')">
                <div>
                    <div>{{ $notification->data['phone_number'] ?? $notification->data['transaction_id'] }}</div>
                    <p>{{ $notification->data['message'] }}</p>
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    
</li>