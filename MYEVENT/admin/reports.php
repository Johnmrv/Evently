<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Reports Page -->
    <!-- Backend: TRISTAN (Activity logs) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="event-approvals.php">Venue Approvals</a></li>
                <li><a href="verify-organizers.php">Verify Organizers</a></li>
                <li><a href="manage-users.php">Manage Users</a></li>
                <li><a href="reports.php" class="active">Reports</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>Admin</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Activity Reports</h1>
            <p class="page-subtitle">View system activity logs</p>
        </div>

        <!-- Backend: TRISTAN - Fetch activity logs from database -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">System Activity Logs</h3>
                <div>
                    <select class="form-control" style="width: 200px; display: inline-block;">
                        <option>All Activities</option>
                        <option>Event Approvals</option>
                        <option>User Registrations</option>
                        <option>Organizer Verifications</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Activity</th>
                                <th>User</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: TRISTAN - Loop through activity logs -->
                            <tr>
                                <td>2024-12-01 10:30 AM</td>
                                <td>Event Approved</td>
                                <td>Admin</td>
                                <td>Approved event "Sample Event"</td>
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

