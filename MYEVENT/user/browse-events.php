<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Browse Events Page -->
    <!-- Backend: GERO (View ONLY Admin-approved events) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="browse-events.php" class="active">Browse Events</a></li>
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
            <h1 class="page-title">Browse Venues</h1>
            <p class="page-subtitle">Discover available venues and book your event</p>
        </div>

        <!-- Backend: GERO - Filter options (optional simple) -->
        <div class="card" style="margin-bottom: var(--spacing-md);">
            <div class="d-flex justify-between align-center" style="flex-wrap: wrap; gap: var(--spacing-sm);">
                <div>
                    <input type="text" class="form-control" placeholder="Search events..." style="width: 300px;">
                </div>
                <div>
                    <select class="form-control" style="width: 200px;">
                        <option>All Categories</option>
                        <option>Sports</option>
                        <option>Music</option>
                        <option>Education</option>
                        <option>Business</option>
                        <option>Arts & Culture</option>
                        <option>Technology</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Backend: GERO - Fetch and display ONLY admin-approved venues -->
        <div class="grid grid-2">
            <!-- Backend: GERO - Loop through approved venues -->
            <div class="event-card">
                <!-- Backend: GERO - Display venue image -->
                <img src="../assets/uploads/venues/sample-venue.jpg" alt="Venue Name" class="venue-image" onerror="this.src='../assets/placeholder-venue.jpg'">
                <h3 class="event-title">Venue Name</h3>
                <div class="event-meta">
                    <span>📍 Venue Location</span>
                    <span>📞 Contact: organizer@example.com</span>
                </div>
                <p class="event-description">Venue description and amenities go here. This venue has been approved by the admin.</p>
                <div class="event-footer">
                    <div>
                        <span class="badge badge-info">👥 50 Slots</span>
                    </div>
                    <div>
                        <a href="event-details.php?id=1" class="btn btn-primary btn-sm">Book This Venue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

