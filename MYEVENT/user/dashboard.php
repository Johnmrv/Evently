<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- User Dashboard -->
    <!-- Backend: GERO (User Dashboard stats: Events Joined, Pending) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="browse-events.php">Browse Events</a></li>
                <li><a href="my-bookings.php">My Bookings</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>User</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">User Dashboard</h1>
            <p class="page-subtitle">Your event activity overview</p>
        </div>

        <!-- Backend: GERO - Fetch user statistics -->
        <div class="grid grid-4">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Events Joined</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Pending Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Approved Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Upcoming Events</div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: var(--spacing-lg);">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Upcoming Events</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Display upcoming events user has registered for -->
                    <div class="empty-state">
                        <p>No upcoming events</p>
                        <a href="browse-events.php" class="btn btn-primary" style="margin-top: var(--spacing-sm);">Browse Events</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Display recent booking activity -->
                    <div class="empty-state">
                        <p>No recent activity</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

