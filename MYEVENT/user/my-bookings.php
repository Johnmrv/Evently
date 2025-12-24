<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- My Bookings Page -->
    <!-- Backend: GERO (Display my booked events, show slots, cancel event registration) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="browse-events.php">Browse Events</a></li>
                <li><a href="my-bookings.php" class="active">My Bookings</a></li>
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
            <h1 class="page-title">My Bookings</h1>
            <p class="page-subtitle">Check status of your event registrations</p>
        </div>

        <!-- Backend: GERO - Fetch user's bookings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Event Registrations</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Event Date</th>
                                <th>Location</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: GERO - Loop through user's bookings -->
                            <tr>
                                <td>Sample Event Title</td>
                                <td>December 25, 2024</td>
                                <td>Event Location</td>
                                <td>December 01, 2024</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Cancel</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Another Event</td>
                                <td>January 15, 2025</td>
                                <td>Another Location</td>
                                <td>November 20, 2024</td>
                                <td><span class="badge badge-success">Approved</span></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">Cancel</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: var(--spacing-lg);">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pending Approvals</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Display pending bookings count -->
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Pending Bookings</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Approved Bookings</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Display approved bookings count -->
                    <div class="stat-card">
                        <div class="stat-number">0</div>
                        <div class="stat-label">Approved Bookings</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

