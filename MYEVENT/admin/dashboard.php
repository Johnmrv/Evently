<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Admin Dashboard -->
    <!-- Backend: TRISTAN (Dashboard counts for users, events) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="event-approvals.php">Venue Approvals</a></li>
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
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">System Overview & Statistics</p>
        </div>

        <!-- Backend: TRISTAN - Fetch and display dashboard counts (users, events, pending approvals, etc.) -->
        <div class="grid grid-4">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Venues</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Pending Approvals</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Active Organizers</div>
            </div>
        </div>

        <div class="grid grid-2" style="margin-top: var(--spacing-lg);">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Activity</h3>
                </div>
                <div class="card-body">
                    <!-- Backend: TRISTAN - Display recent system activities -->
                    <div class="empty-state">
                        <p>No recent activity</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                        <a href="event-approvals.php" class="btn btn-primary">Review Pending Venues</a>
                        <a href="verify-organizers.php" class="btn btn-secondary">Verify Organizer Accounts</a>
                        <a href="manage-users.php" class="btn btn-outline">Manage Users</a>
                        <a href="reports.php" class="btn btn-outline">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

