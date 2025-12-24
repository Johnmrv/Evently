<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evently - Your Event Management Platform</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Landing Page -->
    <!-- UI/Design: JANRO -->
    <!-- Backend: JANRO (Home page logic) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="page-header text-center">
            <h1 class="page-title" style="font-size: 3rem; margin-bottom: var(--spacing-sm);">Welcome to Evently</h1>
            <p class="page-subtitle" style="font-size: 1.25rem;">Book venues and create your own events</p>
        </div>

        <div class="grid grid-3" style="margin-top: var(--spacing-xl);">
            <div class="card text-center">
                <div style="font-size: 3rem; color: var(--primary-green); margin-bottom: var(--spacing-sm);">👤</div>
                <h3 class="card-title">For Users</h3>
                <p class="card-body">Browse approved venues and book them for your events. You provide the event details!</p>
                <a href="register.php" class="btn btn-primary">Get Started</a>
            </div>

            <div class="card text-center">
                <div style="font-size: 3rem; color: var(--primary-green); margin-bottom: var(--spacing-sm);">🎯</div>
                <h3 class="card-title">For Organizers</h3>
                <p class="card-body">Post your venues with location and capacity. Users will book them for their events.</p>
                <a href="register.php" class="btn btn-primary">Become an Organizer</a>
            </div>

            <div class="card text-center">
                <div style="font-size: 3rem; color: var(--primary-green); margin-bottom: var(--spacing-sm);">⚙️</div>
                <h3 class="card-title">For Admins</h3>
                <p class="card-body">Manage the platform, approve venues, and oversee all activities.</p>
                <a href="login.php" class="btn btn-primary">Admin Login</a>
            </div>
        </div>

        <div class="card" style="margin-top: var(--spacing-xl);">
            <h2 class="card-title text-center">How It Works</h2>
            <div class="grid grid-4" style="margin-top: var(--spacing-md);">
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--primary-green); margin-bottom: var(--spacing-xs);">1️⃣</div>
                    <h4 style="color: var(--primary-green); margin-bottom: var(--spacing-xs);">Post Venue</h4>
                    <p style="font-size: var(--font-size-sm);">Organizers post venues with location and capacity</p>
                </div>
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--primary-green); margin-bottom: var(--spacing-xs);">2️⃣</div>
                    <h4 style="color: var(--primary-green); margin-bottom: var(--spacing-xs);">Admin Approval</h4>
                    <p style="font-size: var(--font-size-sm);">Admins review and approve venues</p>
                </div>
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--primary-green); margin-bottom: var(--spacing-xs);">3️⃣</div>
                    <h4 style="color: var(--primary-green); margin-bottom: var(--spacing-xs);">Book & Create</h4>
                    <p style="font-size: var(--font-size-sm);">Users book venues and provide their event details</p>
                </div>
                <div class="text-center">
                    <div style="font-size: 2rem; color: var(--primary-green); margin-bottom: var(--spacing-xs);">4️⃣</div>
                    <h4 style="color: var(--primary-green); margin-bottom: var(--spacing-xs);">Organizer Approval</h4>
                    <p style="font-size: var(--font-size-sm);">Organizers approve user bookings</p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>

