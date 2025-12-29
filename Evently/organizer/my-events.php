<?php
// Organizer My Events - Edit/Delete my events
// Backend: STEFFI
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['organizer']);

$organizerId = $_SESSION['user_id'];
$message = '';
$error = '';

// Handle delete
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $checkQuery = "SELECT id FROM events WHERE id = ? AND organizer_id = ?";
    $checkResult = $conn->prepare($checkQuery);
    $checkResult->bind_param("ii", $eventId, $organizerId);
    $checkResult->execute();
    
    if ($checkResult->get_result()->num_rows > 0) {
        $deleteQuery = "DELETE FROM events WHERE id = ?";
        $deleteResult = $conn->prepare($deleteQuery);
        $deleteResult->bind_param("i", $eventId);
        if ($deleteResult->execute()) {
            $message = '<div class="alert alert-success">Event deleted successfully</div>';
        }
    }
}

// Handle status update (Available/Unavailable)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $eventId = $_POST['event_id'] ?? 0;
    $status = $_POST['status'] ?? '';
    
    $checkQuery = "SELECT id FROM events WHERE id = ? AND organizer_id = ?";
    $checkResult = $conn->prepare($checkQuery);
    $checkResult->bind_param("ii", $eventId, $organizerId);
    $checkResult->execute();
    
    if ($checkResult->get_result()->num_rows > 0) {
        $updateQuery = "UPDATE events SET status = ? WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("si", $status, $eventId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">Event status updated successfully</div>';
        }
    }
}

// Function to get first event image
function getFirstEventImage($conn, $eventId) {
    $imageQuery = "SELECT image_path FROM event_images WHERE event_id = ? ORDER BY created_at ASC LIMIT 1";
    $imageResult = $conn->prepare($imageQuery);
    $imageResult->bind_param("i", $eventId);
    $imageResult->execute();
    $image = $imageResult->get_result()->fetch_assoc();
    return $image ? $image['image_path'] : null;
}

// Get all events by this organizer
$eventsQuery = "SELECT * FROM events WHERE organizer_id = ? ORDER BY created_at DESC";
$eventsResult = $conn->prepare($eventsQuery);
$eventsResult->bind_param("i", $organizerId);
$eventsResult->execute();
$events = $eventsResult->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">My Events</h1>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All My Events</h2>
            </div>
            <?php if ($events->num_rows > 0): ?>
                <div class="events-grid">
                    <?php while ($event = $events->fetch_assoc()): 
                        $firstImage = getFirstEventImage($conn, $event['id']);
                        $displayImage = $firstImage ?: $event['venue_image'];
                    ?>
                        <div class="event-card">
                            <?php if ($displayImage): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($displayImage); ?>" alt="Venue" class="event-image">
                            <?php else: ?>
                                <div class="event-image"></div>
                            <?php endif; ?>
                            <div class="event-body">
                                <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <p class="event-info"><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue_name']); ?></p>
                                <p class="event-info"><strong>Address:</strong> <?php echo htmlspecialchars($event['venue_address']); ?></p>
                                <p class="event-info"><strong>Capacity:</strong> <?php echo $event['max_capacity']; ?> slots</p>
                                <p class="event-info">
                                    <strong>Status:</strong> 
                                    <span class="badge badge-<?php echo $event['status']; ?>">
                                        <?php echo ucfirst($event['status']); ?>
                                    </span>
                                </p>
                                
                                <?php if ($event['status'] == 'approved' || $event['status'] == 'unavailable'): ?>
                                    <form method="POST" style="margin-top: 1rem;">
                                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                        <input type="hidden" name="update_status" value="1">
                                        <?php if ($event['status'] == 'approved'): ?>
                                            <input type="hidden" name="status" value="unavailable">
                                            <button type="submit" class="btn btn-warning" style="width: 100%; margin-bottom: 0.5rem;">Set Unavailable</button>
                                        <?php else: ?>
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-success" style="width: 100%; margin-bottom: 0.5rem;">Set Available</button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                                
                                <a href="create-event.php?edit=<?php echo $event['id']; ?>" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">Edit</a>
                                <a href="?delete=1&id=<?php echo $event['id']; ?>" class="btn btn-danger" style="width: 100%;" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No events found. <a href="create-event.php">Create your first event</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

