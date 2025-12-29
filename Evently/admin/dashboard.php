<?php
// Admin Dashboard - System Overview & Stats
// Backend: TRISTAN
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['admin']);

// Get statistics
$userCountQuery = "SELECT COUNT(*) as count FROM users WHERE role = 'user'";
$userCount = $conn->query($userCountQuery)->fetch_assoc()['count'];

$organizerCountQuery = "SELECT COUNT(*) as count FROM users WHERE role = 'organizer'";
$organizerCount = $conn->query($organizerCountQuery)->fetch_assoc()['count'];

$eventCountQuery = "SELECT COUNT(*) as count FROM events";
$eventCount = $conn->query($eventCountQuery)->fetch_assoc()['count'];

$pendingEventsQuery = "SELECT COUNT(*) as count FROM events WHERE status = 'pending'";
$pendingEvents = $conn->query($pendingEventsQuery)->fetch_assoc()['count'];

$approvedEventsQuery = "SELECT COUNT(*) as count FROM events WHERE status = 'approved'";
$approvedEvents = $conn->query($approvedEventsQuery)->fetch_assoc()['count'];

$bookingCountQuery = "SELECT COUNT(*) as count FROM bookings";
$bookingCount = $conn->query($bookingCountQuery)->fetch_assoc()['count'];

// Get upcoming events
$upcomingEventsQuery = "SELECT e.*, u.full_name as organizer_name 
                        FROM events e 
                        JOIN users u ON e.organizer_id = u.id 
                        WHERE e.status = 'approved' 
                        ORDER BY e.created_at DESC 
                        LIMIT 5";
$upcomingEvents = $conn->query($upcomingEventsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Admin Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $userCount; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $organizerCount; ?></div>
                <div class="stat-label">Total Organizers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $eventCount; ?></div>
                <div class="stat-label">Total Events</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $pendingEvents; ?></div>
                <div class="stat-label">Pending Approvals</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $approvedEvents; ?></div>
                <div class="stat-label">Approved Events</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $bookingCount; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Approved Events</h2>
            </div>
            <?php if ($upcomingEvents->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Venue</th>
                            <th>Organizer</th>
                            <th>Capacity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($event = $upcomingEvents->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo htmlspecialchars($event['venue_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['organizer_name']); ?></td>
                                <td><?php echo $event['max_capacity']; ?></td>
                                <td><span class="badge badge-approved"><?php echo ucfirst($event['status']); ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No events found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

