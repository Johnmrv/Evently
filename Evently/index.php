<?php
// Landing Page (Home)
// UI/Design: JANRO
require_once 'config.php';
session_start();

// Get featured approved events
$featuredEventsQuery = "SELECT e.*, u.full_name as organizer_name 
                        FROM events e 
                        JOIN users u ON e.organizer_id = u.id 
                        WHERE e.status = 'approved' 
                        ORDER BY e.created_at DESC 
                        LIMIT 6";
$featuredEvents = $conn->query($featuredEventsQuery);

$currentUser = null;
if (isset($_SESSION['user_id'])) {
    $currentUser = [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'full_name' => $_SESSION['full_name'],
        'role' => $_SESSION['role']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evently - Event Management System</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="navbar-brand">Evently</a>
        <ul class="navbar-menu">
            <?php if ($currentUser): ?>
                <?php if ($currentUser['role'] == 'admin'): ?>
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                <?php elseif ($currentUser['role'] == 'organizer'): ?>
                    <li><a href="organizer/dashboard.php">Dashboard</a></li>
                <?php else: ?>
                    <li><a href="user/dashboard.php">Dashboard</a></li>
                    <li><a href="user/browse-events.php">Browse Events</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%); color: white; padding: 4rem 2rem; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3rem; margin-bottom: 1rem;">Welcome to Evently</h1>
            <p style="font-size: 1.25rem; margin-bottom: 2rem;">Your one-stop platform for event management and booking</p>
            <?php if (!$currentUser): ?>
                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="register.php" class="btn btn-primary" style="background: white; color: var(--primary-green);">Get Started</a>
                    <a href="login.php" class="btn" style="background: transparent; border: 2px solid white; color: white;">Login</a>
                </div>
            <?php else: ?>
                <?php if ($currentUser['role'] == 'user'): ?>
                    <a href="user/browse-events.php" class="btn" style="background: white; color: var(--primary-green);">Browse Events</a>
                <?php elseif ($currentUser['role'] == 'organizer'): ?>
                    <a href="organizer/create-event.php" class="btn" style="background: white; color: var(--primary-green);">Create Event</a>
                <?php else: ?>
                    <a href="admin/dashboard.php" class="btn" style="background: white; color: var(--primary-green);">Admin Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="container" style="margin-top: 4rem;">
        <h2 style="text-align: center; margin-bottom: 3rem;">Featured Events</h2>
        
        <?php if ($featuredEvents->num_rows > 0): ?>
            <div class="events-grid">
                <?php while ($event = $featuredEvents->fetch_assoc()): ?>
                    <div class="event-card">
                        <?php if ($event['venue_image']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($event['venue_image']); ?>" alt="Venue" class="event-image">
                        <?php else: ?>
                            <div class="event-image"></div>
                        <?php endif; ?>
                        <div class="event-body">
                            <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="event-info"><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue_name']); ?></p>
                            <p class="event-info"><strong>Address:</strong> <?php echo htmlspecialchars($event['venue_address']); ?></p>
                            <p class="event-info"><strong>Slots:</strong> <?php echo $event['max_capacity']; ?></p>
                            <p class="event-info"><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer_name']); ?></p>
                            <?php if ($currentUser && $currentUser['role'] == 'user'): ?>
                                <a href="user/book-event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Book Event</a>
                            <?php elseif (!$currentUser): ?>
                                <a href="login.php" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login to Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No events available at the moment. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <footer style="background-color: var(--text-dark); color: white; padding: 2rem; text-align: center; margin-top: 4rem;">
        <div class="container">
            <p>&copy; 2024 Evently. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

