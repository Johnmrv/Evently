<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Organizer Dashboard -->
    <!-- Backend: STEFFI (Organizer stats: My events, Pending bookings) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="create-event.php">Create Event</a></li>
                <li><a href="my-events.php">My Events</a></li>
                <li><a href="manage-bookings.php">Manage Bookings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>Organizer</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Organizer Dashboard</h1>
            <p class="page-subtitle">Manage your venues and bookings</p>
        </div>

        <!-- Backend: STEFFI - Fetch organizer statistics -->
        <div class="grid grid-4">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">My Venues</div>
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
                <div class="stat-label">Total Participants</div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: var(--spacing-lg);">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Events</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: STEFFI - Display recent venues created by this organizer -->
                    <div class="empty-state">
                        <p>No venues created yet</p>
                        <a href="create-event.php" class="btn btn-primary" style="margin-top: var(--spacing-sm);">Create Your First Venue</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Bookings</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Display pending bookings that need organizer approval -->
                    <div class="empty-state">
                        <p>No pending bookings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

