<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashbored') }}" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Badel Portal</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" id="notification-Count">
                    <i class="bi bi-bell"></i>

                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="notification-menu"
                    style="font-size: 15px; height: 300px; overflow-y: auto;">

                </ul>
            </li>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person bi-lg" alt="Profile" class="rounded-circle" style="font-size: 20px"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2"> @auth {{ auth()->user()->username }}
                        @endauth</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

{{-- <script src="{{asset('assets/js/jquery.js')}}"></script> --}}

<script>
    function fetchNotifications() {
    $.ajax({
        url: '/admin/notifications', // URL to the index route of NotificationController
        type: 'GET',
        dataType: 'json', // Specify the expected data type
        success: function(response) {
            console.log(response);
            updateNotifications(response); // Update notifications in the UI
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function updateNotifications(response) {
    // Get the notifications container
    const notificationsContainer = $('#notification-menu');
    const notificationCountContainer = $('#notification-Count');

    // Clear previous notifications
    notificationsContainer.empty();

    // Append the header for notifications count <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
    const headerHtml = `
        <li class="dropdown-header">
            You have ${response.notificationsCount} new notifications
            
        </li>
        <li>
              <hr class="dropdown-divider">
            </li>
    `;
    notificationsContainer.append(headerHtml);

    // Append new notifications
    response.notifications.forEach(notification => {
        // Create the notification item HTML
        let notificationHtml = `
        <li>
              <hr class="dropdown-divider">
            </li>
            <li class="notification-item p-3" data-notification-id="${notification.id}" data-notification-type="${notification.data.type}">
                <i class="bi bi-check-circle text-success"></i>
                <a href="#" style="color: inherit">
                    <div>
                        <div>${notification.data.phone_number || notification.data.transaction_id}</div>
                        <p>${notification.data.message}</p>
                        <span>${notification.created_at}</span>
                    </div>
                </a>
            </li>
            
        `;

        // Append the notification item to the container
        notificationsContainer.append(notificationHtml);
    });

    // Update the notifications count badge
    const count = response.notificationsCount;
    const badgeHtml = `<span class="badge bg-primary badge-number">${count}</span>`;
    notificationCountContainer.append(badgeHtml);
}


// Attach event listener to mark notification as read when clicked
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
            notification_id: notificationId,
            notification_type: notificationType
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to mark notification as read');
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); // Log success message
        // Remove the notification item from the UI
        $(this).remove();
    })
    .catch(error => {
        console.error(error.message); // Log error message
    });
});


// Fetch notifications initially and set interval to fetch every 30 seconds
$(document).ready(function() {
    fetchNotifications(); // Fetch notifications initially

    // Set interval to fetch notifications every 30 seconds
    setInterval(function() {
        fetchNotifications();
    }, 30000); // 30 seconds = 30,000 milliseconds
});
</script>