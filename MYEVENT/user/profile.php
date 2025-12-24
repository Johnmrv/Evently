<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- User Profile Page -->
    <!-- Backend: JANRO (User profile backend, updating user profile, profile picture upload) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="browse-events.php">Browse Events</a></li>
                <li><a href="my-bookings.php">My Bookings</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>User</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Profile</h1>
            <p class="page-subtitle">Manage your profile information</p>
        </div>

        <!-- Backend: JANRO - Fetch user information -->
        <div class="profile-header">
            <div class="profile-avatar">
                👤
            </div>
            <div class="profile-name">User Name</div>
            <div class="profile-role">Regular User</div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profile Information</h3>
            </div>
            <div class="card-body">
                <!-- Backend: JANRO - Handle profile update form submission -->
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*">
                        <small style="color: var(--gray); font-size: var(--font-size-sm);">Optional: Upload a profile picture</small>
                    </div>

                    <div class="form-group">
                        <label for="fullname" class="form-label">Full Name *</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" value="User Name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" value="user@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="+1234567890">
                    </div>

                    <div class="form-group">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="4">User bio goes here...</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                        <a href="dashboard.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-lg);">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <div class="card-body">
                <!-- Backend: JANRO - Handle password change -->
                <form action="profile.php" method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password *</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6">
                    </div>

                    <div class="form-group">
                        <label for="confirm_new_password" class="form-label">Confirm New Password *</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

