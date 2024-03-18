function fetchNotifications() {
  $.ajax({
      url: '/admin/notifications', // URL to the index route of NotificationController
      type: 'GET',
      dataType: 'json', // Specify the expected data type
      success: function(response) {
          console.log(response);
      },
      error: function(xhr, status, error) {
          console.error(xhr.responseText);
      }
  });
}

// Function to fetch notifications initially and set interval to fetch every 30 seconds
$(document).ready(function() {
  fetchNotifications(); // Fetch notifications initially

  // Set interval to fetch notifications every 30 seconds
  setInterval(function() {
      fetchNotifications();
  }, 30000); // 30 seconds = 30,000 milliseconds
});
