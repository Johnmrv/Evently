<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Event Booking Page -->
    <!-- Backend: GERO (Book Event backend logic - user provides event details: date, time, event type) -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="browse-events.php">Browse Events</a></li>
                <li><a href="my-bookings.php">My Bookings</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>User</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="browse-events.php" class="btn btn-outline" style="margin-bottom: var(--spacing-sm);">← Back to Venues</a>
            <h1 class="page-title">Book Event</h1>
        </div>

        <div class="grid grid-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Venue Information</h2>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Fetch venue details using $_GET['id'] parameter -->
                    <!-- Backend: GERO - Display venue image -->
                    <img src="../assets/uploads/venues/sample-venue.jpg" alt="Venue Name" class="venue-image-large" onerror="this.src='../assets/placeholder-venue.jpg'">
                    <h3 style="color: var(--primary-green); margin-bottom: var(--spacing-sm);">Venue Name</h3>
                    <div class="event-meta" style="margin-bottom: var(--spacing-md);">
                        <div><strong>Location:</strong> Venue Location</div>
                        <div><strong>Contact Email:</strong> organizer@example.com</div>
                        <div><strong>Contact Phone:</strong> +1234567890</div>
                    </div>
                    <div style="margin-bottom: var(--spacing-md);">
                        <strong>Description:</strong>
                        <p style="margin-top: var(--spacing-xs);">Venue description and amenities go here. This venue has been approved by the admin.</p>
                    </div>
                    <div>
                        <strong>Slots:</strong>
                        <span class="badge badge-success" style="margin-left: var(--spacing-xs);">50 Slots</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Book Your Event</h2>
                </div>
                <div class="card-body">
                    <!-- Backend: GERO - Handle booking form submission, create participant/registration table -->
                    <!-- Backend: GERO - User provides: event date, time, event type, and their details -->
                    <!-- Backend: GERO - Get venue_id from $_GET['id'] and pass to form -->
                    <form action="event-details.php" method="POST">
                        <input type="hidden" name="venue_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
                        
                        <div class="form-group">
                            <label for="event_title" class="form-label">Event Title *</label>
                            <input type="text" id="event_title" name="event_title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="event_type" class="form-label">Event Type *</label>
                            <select id="event_type" name="event_type" class="form-control" required>
                                <option value="">Select Event Type</option>
                                <option value="sports">Sports</option>
                                <option value="music">Music</option>
                                <option value="education">Education</option>
                                <option value="business">Business</option>
                                <option value="arts">Arts & Culture</option>
                                <option value="technology">Technology</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="grid grid-2">
                            <div class="form-group">
                                <label for="event_date" class="form-label">Event Date *</label>
                                <input type="date" id="event_date" name="event_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="event_time" class="form-label">Event Time *</label>
                                <input type="time" id="event_time" name="event_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="event_description" class="form-label">Event Description *</label>
                            <textarea id="event_description" name="event_description" class="form-control" rows="3" required></textarea>
                        </div>

                        <hr style="margin: var(--spacing-md) 0; border: 1px solid var(--bg-green);">

                        <h4 style="color: var(--primary-green); margin-bottom: var(--spacing-sm);">Your Contact Information</h4>

                        <div class="form-group">
                            <label for="fullname" class="form-label">Full Name *</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>

                        <div class="alert alert-info">
                            <strong>Note:</strong> Your booking will be pending until the organizer approves it.
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">Book Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

