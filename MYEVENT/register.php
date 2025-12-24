<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Evently</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Registration Page -->
    <!-- Backend: TRISTAN (Authentication & User Roles) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="active">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div style="max-width: 500px; margin: var(--spacing-xl) auto;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Create an Account</h2>
                </div>
                <div class="card-body">
                    <!-- Backend: TRISTAN - Handle registration form submission, create user table, implement user registration backend -->
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required minlength="6">
                            <small style="color: var(--gray); font-size: var(--font-size-sm);">Minimum 6 characters</small>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">I want to register as:</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="user">User (Browse and book events)</option>
                                <option value="organizer">Organizer (Create and manage events)</option>
                            </select>
                            <small style="color: var(--gray); font-size: var(--font-size-sm);">Admin accounts are created separately</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Register</button>
                        </div>
                    </form>

                    <div class="text-center" style="margin-top: var(--spacing-md);">
                        <p style="color: var(--gray);">Already have an account? <a href="login.php" style="color: var(--primary-green);">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>

