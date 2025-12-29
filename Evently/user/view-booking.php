<?php
// User View Booking Details - View full details of approved booking
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user']);

$userId = $_SESSION['user_id'];
$bookingId = $_GET['id'] ?? 0;

// Get booking details
$bookingQuery = "SELECT b.*, e.title as event_title, e.description as event_description, e.venue_name, e.venue_address, e.venue_image, e.max_capacity, u.full_name as organizer_name, u.email as organizer_email 
                 FROM bookings b 
                 JOIN events e ON b.event_id = e.id 
                 JOIN users u ON e.organizer_id = u.id 
                 WHERE b.id = ? AND b.user_id = ? AND b.status = 'approved'";
$bookingResult = $conn->prepare($bookingQuery);
$bookingResult->bind_param("ii", $bookingId, $userId);
$bookingResult->execute();
$booking = $bookingResult->get_result()->fetch_assoc();

if (!$booking) {
    header('Location: dashboard.php');
    exit();
}

// Get event images
$imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
$imagesResult = $conn->prepare($imagesQuery);
$imagesResult->bind_param("i", $booking['event_id']);
$imagesResult->execute();
$eventImages = $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);

// Get first event image for display
function getFirstEventImage($conn, $eventId) {
    $imageQuery = "SELECT image_path FROM event_images WHERE event_id = ? ORDER BY created_at ASC LIMIT 1";
    $imageResult = $conn->prepare($imageQuery);
    $imageResult->bind_param("i", $eventId);
    $imageResult->execute();
    $image = $imageResult->get_result()->fetch_assoc();
    return $image ? $image['image_path'] : null;
}

$firstImage = getFirstEventImage($conn, $booking['event_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Booking Details</h1>
        
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h2 class="card-title"><?php echo htmlspecialchars($booking['event_title']); ?></h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <?php if ($firstImage || $booking['venue_image']): ?>
                        <div style="margin-bottom: 1rem;">
                            <?php if ($firstImage): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($firstImage); ?>" alt="Venue" class="event-image" style="width: 100%; height: auto; margin-bottom: 1rem;">
                            <?php elseif ($booking['venue_image']): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($booking['venue_image']); ?>" alt="Venue" class="event-image" style="width: 100%; height: auto; margin-bottom: 1rem;">
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
                    <h3>Event Information</h3>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($booking['venue_name']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($booking['venue_address']); ?></p>
                    <p><strong>Slots:</strong> <?php echo $booking['max_capacity']; ?></p>
                    <p><strong>Organizer:</strong> <?php echo htmlspecialchars($booking['organizer_name']); ?></p>
                    <p><strong>Organizer Email:</strong> <?php echo htmlspecialchars($booking['organizer_email']); ?></p>
                    <?php if ($booking['event_description']): ?>
                        <p style="margin-top: 1rem;"><strong>Description:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($booking['event_description'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Booking Information</h2>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <p><strong>Booking Date:</strong> <?php echo date('M d, Y', strtotime($booking['event_date'])); ?></p>
                    <p><strong>Event Time:</strong> <?php echo date('h:i A', strtotime($booking['event_time'])); ?></p>
                    <p><strong>Number of Attendees:</strong> <?php echo $booking['number_of_attendees']; ?> / <?php echo $booking['max_capacity']; ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge badge-approved"><?php echo ucfirst($booking['status']); ?></span>
                    </p>
                </div>
                <div>
                    <?php if (!empty($booking['note'])): ?>
                        <p><strong>Your Note:</strong></p>
                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 4px solid var(--primary-green);">
                            <?php echo nl2br(htmlspecialchars($booking['note'])); ?>
                        </div>
                    <?php endif; ?>
                    <p style="margin-top: 1rem;"><strong>Booked On:</strong> <?php echo date('M d, Y h:i A', strtotime($booking['created_at'])); ?></p>
                    <?php if ($booking['organizer_approved_at']): ?>
                        <p><strong>Approved On:</strong> <?php echo date('M d, Y h:i A', strtotime($booking['organizer_approved_at'])); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 2rem;">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            <a href="my-bookings.php" class="btn btn-primary">View All Bookings</a>
        </div>
    </div>
</body>
</html>

