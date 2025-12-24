<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Manage Bookings Page -->
    <!-- KEY FEATURE: Organizer approves/declines user registration requests -->
    <!-- Backend: GERO (Participant list backend logic, approve/decline registration) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create-event.php">Create Event</a></li>
                <li><a href="my-events.php">My Events</a></li>
                <li><a href="manage-bookings.php" class="active">Manage Bookings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>Organizer</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Manage Bookings</h1>
            <p class="page-subtitle">Approve or decline user registration requests</p>
        </div>

        <!-- Backend: GERO - Fetch bookings for events created by this organizer -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pending Bookings</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Participant Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: GERO - Loop through pending bookings -->
                            <tr>
                                <td>Sample Event Title</td>
                                <td>User Name</td>
                                <td>user@example.com</td>
                                <td>2024-12-01</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Approve</a>
                                    <a href="#" class="btn btn-danger btn-sm">Decline</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-lg);">
            <div class="card-header">
                <h3 class="card-title">Approved Bookings</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Participant Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: GERO - Loop through approved bookings -->
                            <tr>
                                <td colspan="5" class="text-center" style="padding: var(--spacing-lg);">
                                    <div class="empty-state">
                                        <p>No approved bookings yet</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

