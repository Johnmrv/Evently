<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <!-- Create Venue Page -->
    <!-- Backend: STEFFI (Create Venue backend logic, venues table, validation) -->
    <!-- Note: Organizers only post venue location and capacity. Users will provide event details. -->
    
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Evently</a>
            <ul class="nav-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create-event.php" class="active">Create Venue</a></li>
                <li><a href="my-events.php">My Venues</a></li>
                <li><a href="manage-bookings.php">Manage Bookings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            <div class="nav-user">
                <span>Organizer</span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Post New Venue</h1>
            <p class="page-subtitle">Post a venue for admin approval. Users will book events at your venue.</p>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Backend: STEFFI - Handle form submission, create venues table, build "Create Venue" backend logic -->
                <!-- Backend: STEFFI - Add validation for venue fields, restrict to Organizer/Admin roles -->
                <!-- Backend: STEFFI - Handle image upload, save to assets/uploads/venues/ directory -->
                <!-- Note: Venue status should be set to "Pending" until admin approves -->
                <!-- Note: Users will provide event details (date, time, event type) when booking -->
                <form action="create-event.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="venue_name" class="form-label">Venue Name *</label>
                        <input type="text" id="venue_name" name="venue_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="venue_image" class="form-label">Venue Image *</label>
                        <input type="file" id="venue_image" name="venue_image" class="form-control" accept="image/*" required>
                        <small style="color: var(--gray); font-size: var(--font-size-sm);">Upload an image of your venue (JPG, PNG, GIF - Max 5MB)</small>
                    </div>

                    <div class="form-group">
                        <label for="venue_description" class="form-label">Venue Description *</label>
                        <textarea id="venue_description" name="venue_description" class="form-control" required placeholder="Describe your venue, amenities, facilities, etc."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="venue_location" class="form-label">Venue Location *</label>
                        <input type="text" id="venue_location" name="venue_location" class="form-control" required placeholder="Full address of the venue">
                    </div>

                    <div class="form-group">
                        <label for="max_capacity" class="form-label">Maximum Capacity (Slots) *</label>
                        <input type="number" id="max_capacity" name="max_capacity" class="form-control" min="1" required>
                        <small style="color: var(--gray); font-size: var(--font-size-sm);">Maximum number of people your venue can accommodate</small>
                    </div>

                    <div class="form-group">
                        <label for="contact_email" class="form-label">Contact Email *</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_phone" class="form-label">Contact Phone *</label>
                        <input type="tel" id="contact_phone" name="contact_phone" class="form-control" required>
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> Users will provide their own event details (date, time, event type) when booking your venue. You only need to provide the venue information above.
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg">Submit for Approval</button>
                        <a href="dashboard.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>

