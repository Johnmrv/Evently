<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- My Venues Page -->
    <!-- Backend: STEFFI (Edit Venue, Delete Venue backend logic) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create-event.php">Create Venue</a></li>
                <li><a href="my-events.php" class="active">My Venues</a></li>
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
            <h1 class="page-title">My Venues</h1>
            <p class="page-subtitle">Edit or delete your venues</p>
        </div>

        <!-- Backend: STEFFI - Fetch events created by this organizer -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All My Venues</h3>
                <a href="create-event.php" class="btn btn-primary">Create New Venue</a>
            </div>
            <div class="card-body">
                <div class="grid grid-2">
                    <!-- Backend: STEFFI - Loop through organizer's venues -->
                    <div class="event-card">
                        <!-- Backend: STEFFI - Display venue image -->
                        <img src="../assets/uploads/venues/sample-venue.jpg" alt="Venue Name" class="venue-image" onerror="this.src='../assets/placeholder-venue.jpg'">
                        <h3 class="event-title">Venue Name</h3>
                        <div class="event-meta">
                            <span>📍 Venue Location</span>
                            <span>👥 50 Slots</span>
                        </div>
                        <p class="event-description">Venue description goes here...</p>
                        <div class="event-footer">
                            <span class="badge badge-warning">Pending Approval</span>
                            <div>
                                <a href="#" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

