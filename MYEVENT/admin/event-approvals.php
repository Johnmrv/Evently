<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Approvals - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Venue Approvals Page -->
    <!-- KEY FEATURE: Admin approves/rejects venues posted by Organizers -->
    <!-- Backend: TRISTAN (Venue approval logic) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="event-approvals.php" class="active">Event Approvals</a></li>
                <li><a href="verify-organizers.php">Verify Organizers</a></li>
                <li><a href="manage-users.php">Manage Users</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>Admin</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Venue Approvals</h1>
            <p class="page-subtitle">Review and approve venues posted by organizers</p>
        </div>

        <!-- Backend: TRISTAN - Fetch events with status "Pending" from organizers -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pending Venue Approvals</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Venue Name</th>
                                <th>Organizer</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: TRISTAN - Loop through pending venues -->
                            <tr>
                                <td>
                                    <!-- Backend: TRISTAN - Display venue image thumbnail -->
                                    <img src="../assets/uploads/venues/sample-venue.jpg" alt="Venue" class="venue-image-thumb" onerror="this.src='../assets/placeholder-venue.jpg'">
                                </td>
                                <td>Sample Venue Name</td>
                                <td>Organizer Name</td>
                                <td>Venue Location</td>
                                <td>50 Slots</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                    <a href="#" class="btn btn-success btn-sm">Approve</a>
                                    <a href="#" class="btn btn-danger btn-sm">Reject</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-lg);">
            <div class="card-header">
                <h3 class="card-title">Approved Venues</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Venue Name</th>
                                <th>Organizer</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: TRISTAN - Loop through approved venues -->
                            <tr>
                                <td colspan="7" class="text-center" style="padding: var(--spacing-lg);">
                                    <div class="empty-state">
                                        <p>No approved venues yet</p>
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

