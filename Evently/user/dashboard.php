<?php
// User Dashboard - Stats: Events Joined, Pending
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user']);

$userId = $_SESSION['user_id'];

// Get statistics
$myBookingsQuery = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ?";
$myBookingsResult = $conn->prepare($myBookingsQuery);
$myBookingsResult->bind_param("i", $userId);
$myBookingsResult->execute();
$myBookings = $myBookingsResult->get_result()->fetch_assoc()['count'];

$pendingBookingsQuery = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ? AND status = 'pending'";
$pendingBookingsResult = $conn->prepare($pendingBookingsQuery);
$pendingBookingsResult->bind_param("i", $userId);
$pendingBookingsResult->execute();
$pendingBookings = $pendingBookingsResult->get_result()->fetch_assoc()['count'];

$approvedBookingsQuery = "SELECT COUNT(*) as count FROM bookings WHERE user_id = ? AND status = 'approved'";
$approvedBookingsResult = $conn->prepare($approvedBookingsQuery);
$approvedBookingsResult->bind_param("i", $userId);
$approvedBookingsResult->execute();
$approvedBookings = $approvedBookingsResult->get_result()->fetch_assoc()['count'];

// Get upcoming bookings (exclude cancelled)
$upcomingBookingsQuery = "SELECT b.*, e.title as event_title, e.venue_name, e.venue_address, e.description, e.max_capacity, u.full_name as organizer_name 
                          FROM bookings b 
                          JOIN events e ON b.event_id = e.id 
                          JOIN users u ON e.organizer_id = u.id 
                          WHERE b.user_id = ? AND b.status = 'approved' AND b.event_date >= CURDATE() 
                          ORDER BY b.event_date ASC 
                          LIMIT 5";
$upcomingBookingsResult = $conn->prepare($upcomingBookingsQuery);
$upcomingBookingsResult->bind_param("i", $userId);
$upcomingBookingsResult->execute();
$upcomingBookings = $upcomingBookingsResult->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">My Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $myBookings; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $pendingBookings; ?></div>
                <div class="stat-label">Pending Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $approvedBookings; ?></div>
                <div class="stat-label">Approved Bookings</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Upcoming Events</h2>
            </div>
            <?php if ($upcomingBookings->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $upcomingBookings->fetch_assoc()): ?>
                            <tr style="cursor: pointer;" onclick="window.location.href='view-booking.php?id=<?php echo $booking['id']; ?>'">
                                <td><?php echo htmlspecialchars($booking['event_title']); ?></td>
                                <td><?php echo htmlspecialchars($booking['venue_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($booking['event_date'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($booking['event_time'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No upcoming events. <a href="browse-events.php">Browse events</a> to book one!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

