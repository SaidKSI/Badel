<div>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="notification-menu" style="font-size: 15px; height: 300px; overflow-y: auto;">
        @foreach ($notifications as $notification)
            <li>
                <hr class="dropdown-divider">
            </li>
            <li class="notification-item p-3" data-notification-id="{{ $notification->id }}" data-notification-type="{{ $notification->type }}">
                <i class="bi bi-check-circle text-success"></i>
                <a href="#" style="color: inherit">
                    <div>
                        <div>{{ $notification->data['phone_number'] ?? $notification->data['transaction_id'] }}</div>
                        <p>{{ $notification->data['message'] }}</p>
                        <span>{{ $notification->created_at }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
