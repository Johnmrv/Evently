<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Manage Users Page -->
    <!-- Backend: TRISTAN (View users, ban/delete users) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="event-approvals.php">Venue Approvals</a></li>
                <li><a href="verify-organizers.php">Verify Organizers</a></li>
                <li><a href="manage-users.php" class="active">Manage Users</a></li>
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
            <h1 class="page-title">Manage Users</h1>
            <p class="page-subtitle">View, ban, or delete user accounts</p>
        </div>

        <!-- Backend: TRISTAN - Fetch all users from database -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Users</h3>
                <div>
                    <input type="text" class="form-control" placeholder="Search users..." style="width: 250px; display: inline-block;">
                </div>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Backend: TRISTAN - Loop through all users -->
                            <tr>
                                <td>1</td>
                                <td>User Name</td>
                                <td>user@example.com</td>
                                <td><span class="badge badge-info">User</span></td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Ban</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
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

