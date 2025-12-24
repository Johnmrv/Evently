<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Organizers - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Verify Organizers Page -->
    <!-- Backend: TRISTAN (Verify organizer accounts) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="event-approvals.php">Venue Approvals</a></li>
                <li><a href="verify-organizers.php" class="active">Verify Organizers</a></li>
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
            <h1 class="page-title">Verify Organizers</h1>
            <p class="page-subtitle">Approve new organizer accounts</p>
        </div>

        <!-- Backend: TRISTAN - Fetch organizer accounts pending verification -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pending Organizer Verifications</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: TRISTAN - Loop through pending organizers -->
                            <tr>
                                <td>Organizer Name</td>
                                <td>organizer@example.com</td>
                                <td>2024-12-01</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Approve</a>
                                    <a href="#" class="btn btn-danger btn-sm">Reject</a>
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

