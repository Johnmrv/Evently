<?php
// Organizer Dashboard - Organizer stats (My events, Pending bookings)
// Backend: STEFFI
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['organizer']);

$organizerId = $_SESSION['user_id'];

// Get statistics
$myEventsQuery = "SELECT COUNT(*) as count FROM events WHERE organizer_id = ?";
$myEventsResult = $conn->prepare($myEventsQuery);
$myEventsResult->bind_param("i", $organizerId);
$myEventsResult->execute();
$myEvents = $myEventsResult->get_result()->fetch_assoc()['count'];

$pendingBookingsQuery = "SELECT COUNT(*) as count FROM bookings b 
                         JOIN events e ON b.event_id = e.id 
                         WHERE e.organizer_id = ? AND b.status = 'pending'";
$pendingBookingsResult = $conn->prepare($pendingBookingsQuery);
$pendingBookingsResult->bind_param("i", $organizerId);
$pendingBookingsResult->execute();
$pendingBookings = $pendingBookingsResult->get_result()->fetch_assoc()['count'];

$approvedBookingsQuery = "SELECT COUNT(*) as count FROM bookings b 
                           JOIN events e ON b.event_id = e.id 
                           WHERE e.organizer_id = ? AND b.status = 'approved'";
$approvedBookingsResult = $conn->prepare($approvedBookingsQuery);
$approvedBookingsResult->bind_param("i", $organizerId);
$approvedBookingsResult->execute();
$approvedBookings = $approvedBookingsResult->get_result()->fetch_assoc()['count'];

// Get recent events
$recentEventsQuery = "SELECT * FROM events WHERE organizer_id = ? ORDER BY created_at DESC LIMIT 5";
$recentEventsResult = $conn->prepare($recentEventsQuery);
$recentEventsResult->bind_param("i", $organizerId);
$recentEventsResult->execute();
$recentEvents = $recentEventsResult->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Organizer Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $myEvents; ?></div>
                <div class="stat-label">My Events</div>
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
                <h2 class="card-title">My Recent Events</h2>
            </div>
            <?php if ($recentEvents->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Venue</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($event = $recentEvents->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo htmlspecialchars($event['venue_name']); ?></td>
                                <td><?php echo $event['max_capacity']; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $event['status']; ?>">
                                        <?php echo ucfirst($event['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="my-events.php?id=<?php echo $event['id']; ?>" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No events yet. <a href="create-event.php">Create your first event</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

