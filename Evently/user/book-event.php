<?php
// User Book Event - Register for event by providing details
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user']);

$userId = $_SESSION['user_id'];
$eventId = $_GET['id'] ?? 0;
$message = '';
$error = '';

// Get event details
$eventQuery = "SELECT e.*, u.full_name as organizer_name 
               FROM events e 
               JOIN users u ON e.organizer_id = u.id 
               WHERE e.id = ? AND e.status = 'approved'";
$eventResult = $conn->prepare($eventQuery);
$eventResult->bind_param("i", $eventId);
$eventResult->execute();
$event = $eventResult->get_result()->fetch_assoc();

if (!$event) {
    header('Location: browse-events.php');
    exit();
}

// Get all event images
$imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
$imagesResult = $conn->prepare($imagesQuery);
$imagesResult->bind_param("i", $eventId);
$imagesResult->execute();
$eventImages = $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);

// Get booked dates for this event (only approved bookings with future dates disable dates)
// Past booking dates automatically become available again
$bookedDatesQuery = "SELECT DISTINCT event_date FROM bookings WHERE event_id = ? AND status = 'approved' AND event_date >= CURDATE()";
$bookedDatesResult = $conn->prepare($bookedDatesQuery);
$bookedDatesResult->bind_param("i", $eventId);
$bookedDatesResult->execute();
$bookedDates = $bookedDatesResult->get_result();
$disabledDates = [];
while ($row = $bookedDates->fetch_assoc()) {
    $disabledDates[] = $row['event_date'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_date = $_POST['event_date'] ?? '';
    $event_time = $_POST['event_time'] ?? '';
    $number_of_attendees = $_POST['number_of_attendees'] ?? 1;
    $note = $_POST['note'] ?? '';
    
    if (empty($event_date) || empty($event_time)) {
        $error = 'Please fill in all required fields';
    } elseif ($number_of_attendees > $event['max_capacity']) {
        $error = 'Number of attendees cannot exceed maximum capacity';
    } elseif (in_array($event_date, $disabledDates)) {
        $error = 'This date is already booked. Please select another date.';
    } else {
        // Check for duplicate booking
        $duplicateQuery = "SELECT id FROM bookings WHERE event_id = ? AND user_id = ? AND event_date = ? AND event_time = ?";
        $duplicateResult = $conn->prepare($duplicateQuery);
        $duplicateResult->bind_param("iiss", $eventId, $userId, $event_date, $event_time);
        $duplicateResult->execute();
        
        if ($duplicateResult->get_result()->num_rows > 0) {
            $error = 'You have already booked this event for this date and time';
        } else {
            $insertQuery = "INSERT INTO bookings (event_id, user_id, event_date, event_time, number_of_attendees, note, status) 
                            VALUES (?, ?, ?, ?, ?, ?, 'pending')";
            $insertResult = $conn->prepare($insertQuery);
            $insertResult->bind_param("iissis", $eventId, $userId, $event_date, $event_time, $number_of_attendees, $note);
            
            if ($insertResult->execute()) {
                $message = '<div class="alert alert-success">Booking request submitted successfully! Waiting for organizer approval.</div>';
                $_POST = array();
            } else {
                $error = 'Failed to submit booking. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Book Event</h1>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h2 class="card-title">Event Details</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <?php if ($event['venue_image'] || !empty($eventImages)): ?>
                        <div style="margin-bottom: 1rem;">
                            <?php if ($event['venue_image']): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($event['venue_image']); ?>" alt="Venue" class="event-image" style="width: 100%; height: auto; margin-bottom: 1rem;">
                            <?php endif; ?>
                            <?php if (!empty($eventImages)): ?>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 0.5rem;">
                                    <?php foreach ($eventImages as $img): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="Event Image" style="width: 100%; height: 100px; object-fit: cover; border-radius: 6px; border: 2px solid var(--border-color);">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="event-image" style="width: 100%; height: 300px;"></div>
                    <?php endif; ?>
                </div>
                <div>
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue_name']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($event['venue_address']); ?></p>
                    <p><strong>Slots:</strong> <?php echo $event['max_capacity']; ?></p>
                    <p><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer_name']); ?></p>
                    <?php if ($event['description']): ?>
                        <p style="margin-top: 1rem;"><strong>Description:</strong></p>
                        <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Booking Information</h2>
            </div>
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Event Date *</label>
                    <input type="date" name="event_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($_POST['event_date'] ?? ''); ?>">
                    <small style="color: var(--text-light);">Note: Already booked dates are disabled</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Event Time *</label>
                    <input type="time" name="event_time" class="form-control" required value="<?php echo htmlspecialchars($_POST['event_time'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Number of Attendees *</label>
                    <input type="number" name="number_of_attendees" class="form-control" required min="1" max="<?php echo $event['max_capacity']; ?>" value="<?php echo htmlspecialchars($_POST['number_of_attendees'] ?? '1'); ?>">
                    <small style="color: var(--text-light);">Maximum: <?php echo $event['max_capacity']; ?> slots</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Leave a Note (Optional)</label>
                    <textarea name="note" class="form-control" rows="4" placeholder="Add any special requests or notes for the organizer..."><?php echo htmlspecialchars($_POST['note'] ?? ''); ?></textarea>
                    <small style="color: var(--text-light);">This note will be visible to the organizer when reviewing your booking request</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Booking Request</button>
                <a href="browse-events.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    
    <script>
        // Disable booked dates
        var disabledDates = <?php echo json_encode($disabledDates); ?>;
        var dateInput = document.querySelector('input[name="event_date"]');
        
        dateInput.addEventListener('change', function() {
            var selectedDate = this.value;
            if (disabledDates.includes(selectedDate)) {
                alert('This date is already booked. Please select another date.');
                this.value = '';
            }
        });
    </script>
</body>
</html>

