// Evently - Main JavaScript
// AJAX Functions using jQuery

// Image Preview on Upload
// UI: JANRO
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + previewId).attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Check Date Availability
// Backend: GERO
function checkDateAvailability(eventId, selectedDate) {
    $.ajax({
        url: 'ajax/check_date.php',
        method: 'POST',
        data: {
            event_id: eventId,
            date: selectedDate
        },
        success: function(response) {
            if (response.available === false) {
                alert('This date is already booked. Please select another date.');
                $('#event_date').val('');
            }
        }
    });
}

// Update Event Status
// Backend: STEFFI
function updateEventStatus(eventId, status) {
    if (!confirm('Are you sure you want to change the status?')) {
        return;
    }
    
    $.ajax({
        url: 'ajax/update_event_status.php',
        method: 'POST',
        data: {
            event_id: eventId,
            status: status
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        }
    });
}

// Update Booking Status
// Backend: GERO
function updateBookingStatus(bookingId, status) {
    if (!confirm('Are you sure you want to ' + status + ' this booking?')) {
        return;
    }
    
    $.ajax({
        url: 'ajax/update_booking_status.php',
        method: 'POST',
        data: {
            booking_id: bookingId,
            status: status
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        }
    });
}

// Cancel Booking
// Backend: GERO
function cancelBooking(bookingId) {
    if (!confirm('Are you sure you want to cancel this booking?')) {
        return;
    }
    
    $.ajax({
        url: 'ajax/cancel_booking.php',
        method: 'POST',
        data: {
            booking_id: bookingId
        },
        success: function(response) {
            if (response.success) {
                alert('Booking cancelled successfully');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        }
    });
}

