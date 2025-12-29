<?php
// Navigation Menu Bar Component
// UI/Design: JANRO
$currentUser = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <a href="../index.php" class="navbar-brand">Evently</a>
    <ul class="navbar-menu">
        <?php if ($currentUser): ?>
            <?php if ($currentUser['role'] == 'admin'): ?>
                <li><a href="dashboard.php" class="<?php echo $currentPage == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="event-approvals.php" class="<?php echo $currentPage == 'event-approvals.php' ? 'active' : ''; ?>">Event Approvals</a></li>
                <li><a href="manage-users.php" class="<?php echo $currentPage == 'manage-users.php' ? 'active' : ''; ?>">Manage Users</a></li>
            <?php elseif ($currentUser['role'] == 'organizer'): ?>
                <li><a href="dashboard.php" class="<?php echo $currentPage == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="create-event.php" class="<?php echo $currentPage == 'create-event.php' ? 'active' : ''; ?>">Create Event</a></li>
                <li><a href="my-events.php" class="<?php echo $currentPage == 'my-events.php' ? 'active' : ''; ?>">My Events</a></li>
                <li><a href="manage-bookings.php" class="<?php echo $currentPage == 'manage-bookings.php' ? 'active' : ''; ?>">Manage Bookings</a></li>
            <?php else: ?>
                <li><a href="dashboard.php" class="<?php echo $currentPage == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="browse-events.php" class="<?php echo $currentPage == 'browse-events.php' ? 'active' : ''; ?>">Browse Events</a></li>
                <li><a href="my-bookings.php" class="<?php echo $currentPage == 'my-bookings.php' ? 'active' : ''; ?>">My Bookings</a></li>
                <li><a href="profile.php" class="<?php echo $currentPage == 'profile.php' ? 'active' : ''; ?>">Profile</a></li>
            <?php endif; ?>
            <li><a href="../logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="../login.php">Login</a></li>
            <li><a href="../register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

