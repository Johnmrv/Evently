<?php
// Organizer Manage Bookings - Approve/Decline user registration requests
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['organizer']);

$organizerId = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $bookingId = $_POST['booking_id'] ?? 0;
    $action = $_POST['action'] ?? '';
    
    // Verify booking belongs to organizer's event
    $verifyQuery = "SELECT b.id FROM bookings b 
                    JOIN events e ON b.event_id = e.id 
                    WHERE b.id = ? AND e.organizer_id = ?";
    $verifyResult = $conn->prepare($verifyQuery);
    $verifyResult->bind_param("ii", $bookingId, $organizerId);
    $verifyResult->execute();
    
    if ($verifyResult->get_result()->num_rows > 0) {
        if ($action == 'approve') {
            $updateQuery = "UPDATE bookings SET status = 'approved', organizer_approved_by = ?, organizer_approved_at = NOW() WHERE id = ?";
            $updateResult = $conn->prepare($updateQuery);
            $updateResult->bind_param("ii", $organizerId, $bookingId);
            if ($updateResult->execute()) {
                $message = '<div class="alert alert-success">Booking approved successfully</div>';
            }
        } elseif ($action == 'decline') {
            $updateQuery = "UPDATE bookings SET status = 'declined', organizer_approved_by = ?, organizer_approved_at = NOW() WHERE id = ?";
            $updateResult = $conn->prepare($updateQuery);
            $updateResult->bind_param("ii", $organizerId, $bookingId);
            if ($updateResult->execute()) {
                $message = '<div class="alert alert-success">Booking declined</div>';
            }
        }
    }
}

// Get all bookings for organizer's events
$bookingsQuery = "SELECT b.*, e.title as event_title, e.venue_name, u.full_name as user_name, u.email as user_email 
                  FROM bookings b 
                  JOIN events e ON b.event_id = e.id 
                  JOIN users u ON b.user_id = u.id 
                  WHERE e.organizer_id = ? 
                  ORDER BY b.created_at DESC";
$bookingsResult = $conn->prepare($bookingsQuery);
$bookingsResult->bind_param("i", $organizerId);
$bookingsResult->execute();
$bookings = $bookingsResult->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Manage Bookings</h1>
        
        <?php echo $message; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Bookings</h2>
            </div>
            <?php if ($bookings->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Venue</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Attendees</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['event_title']); ?></td>
                                <td><?php echo htmlspecialchars($booking['venue_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['user_name']); ?><br><small><?php echo htmlspecialchars($booking['user_email']); ?></small></td>
                                <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['event_time'])); ?></td>
                                <td><?php echo $booking['number_of_attendees']; ?></td>
                                <td>
                                    <?php if (!empty($booking['note'])): ?>
                                        <div style="max-width: 200px; word-wrap: break-word;">
                                            <?php echo nl2br(htmlspecialchars($booking['note'])); ?>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: var(--text-light);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $booking['status']; ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Approve</button>
                                        </form>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <input type="hidden" name="action" value="decline">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Decline</button>
                                        </form>
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
                    <p>No bookings found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

