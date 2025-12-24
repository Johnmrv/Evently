<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Evently</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Login Page -->
    <!-- Backend: TRISTAN (Authentication & User Roles) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php" class="active">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div style="max-width: 400px; margin: var(--spacing-xl) auto;">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Login to Evently</h2>
                </div>
                <div class="card-body">
                    <!-- Backend: TRISTAN - Handle login form submission -->
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Login</button>
                        </div>
                    </form>

                    <div class="text-center" style="margin-top: var(--spacing-md);">
                        <p style="color: var(--gray);">Don't have an account? <a href="register.php" style="color: var(--primary-green);">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>

