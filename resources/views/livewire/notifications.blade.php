<li class="nav-item dropdown" wire:poll.30s>
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" id="notification-Count">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">{{$notificationsCount}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="notification-menu"
        style="font-size: 15px; max-height: 300px; overflow-y: auto;">
        <li class="dropdown-header">
            You have {{$notificationsCount}} new notifications
        </li>
        @foreach ($notifications as $notification)
        <li class="notification-item p-3" data-notification-id="{{$notification->id}}"
            id="notification-{{ $notification->id }}" >
            <i class="bi bi-check-circle text-success"></i>
            <a href="#" style="color: inherit">
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
<script>
    $(document).on('click', '.notification-item', function() {
    const notificationId = $(this).data('notification-id');
    const notificationType = $(this).data('notification-type');

    // Make AJAX request to mark notification as read
    fetch('/admin/mark_notification_as_read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            notification_id: notificationId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to mark notification as read');
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message);// Log success message
        
        // Remove the notification item from the UI
        $(this).remove();
    })
    .catch(error => {
        console.error(error.message); // Log error message
    });
});
</script>