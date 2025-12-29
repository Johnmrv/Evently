<?php
// User My Bookings - Check status of bookings (Pending/Approved)
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user']);

$userId = $_SESSION['user_id'];
$message = '';

// Handle cancel booking
if (isset($_GET['cancel']) && isset($_GET['id'])) {
    $bookingId = $_GET['id'];
    $checkQuery = "SELECT id FROM bookings WHERE id = ? AND user_id = ? AND status = 'pending'";
    $checkResult = $conn->prepare($checkQuery);
    $checkResult->bind_param("ii", $bookingId, $userId);
    $checkResult->execute();
    
    if ($checkResult->get_result()->num_rows > 0) {
        $updateQuery = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("i", $bookingId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">Booking cancelled successfully</div>';
        }
    }
}

// Get all bookings by user (exclude cancelled)
$bookingsQuery = "SELECT b.*, e.title as event_title, e.venue_name, e.venue_address, e.max_capacity, u.full_name as organizer_name 
                  FROM bookings b 
                  JOIN events e ON b.event_id = e.id 
                  JOIN users u ON e.organizer_id = u.id 
                  WHERE b.user_id = ? AND b.status != 'cancelled'
                  ORDER BY b.created_at DESC";
$bookingsResult = $conn->prepare($bookingsQuery);
$bookingsResult->bind_param("i", $userId);
$bookingsResult->execute();
$bookings = $bookingsResult->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">My Bookings</h1>
        
        <?php echo $message; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All My Bookings</h2>
            </div>
            <?php if ($bookings->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Attendees</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['event_title']); ?></td>
                                <td><?php echo htmlspecialchars($booking['venue_name']); ?><br><small><?php echo htmlspecialchars($booking['venue_address']); ?></small></td>
                                <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['event_time'])); ?></td>
                                <td><?php echo $booking['number_of_attendees']; ?> / <?php echo $booking['max_capacity']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <a href="?cancel=1&id=<?php echo $booking['id']; ?>" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;" onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a>
                                    <?php else: ?>
                                        <span style="color: var(--text-light);">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No bookings found. <a href="browse-events.php">Browse events</a> to make a booking!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

