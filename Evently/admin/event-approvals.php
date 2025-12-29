<?php
// Admin Event Approvals - Approve/Reject events posted by Organizers
// Backend: TRISTAN
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['admin']);

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $eventId = $_POST['event_id'] ?? 0;
    $action = $_POST['action'] ?? '';
    $userId = $_SESSION['user_id'];
    
    if ($action == 'approve') {
        $updateQuery = "UPDATE events SET status = 'approved', admin_approved_by = ?, admin_approved_at = NOW() WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("ii", $userId, $eventId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">Event approved successfully</div>';
        }
    } elseif ($action == 'reject') {
        $updateQuery = "UPDATE events SET status = 'rejected', admin_approved_by = ?, admin_approved_at = NOW() WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("ii", $userId, $eventId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">Event rejected</div>';
        }
    }
}

// Get pending events
$pendingEventsQuery = "SELECT e.*, u.full_name as organizer_name, u.email as organizer_email 
                       FROM events e 
                       JOIN users u ON e.organizer_id = u.id 
                       WHERE e.status = 'pending' 
                       ORDER BY e.created_at DESC";
$pendingEvents = $conn->query($pendingEventsQuery);

// Function to get all images for an event
function getEventImages($conn, $eventId) {
    $imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
    $imagesResult = $conn->prepare($imagesQuery);
    $imagesResult->bind_param("i", $eventId);
    $imagesResult->execute();
    return $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Approvals - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .image-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            overflow: auto;
        }
        .image-modal-content {
            background-color: white;
            margin: 2% auto;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 1200px;
        }
        .image-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--primary-green);
            padding-bottom: 1rem;
        }
        .close-modal {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
        }
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .gallery-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            cursor: pointer;
        }
        .gallery-image:hover {
            border-color: var(--primary-green);
        }
        .clickable-image {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Event Approvals</h1>
        
        <?php echo $message; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Pending Events for Approval</h2>
            </div>
            <?php if ($pendingEvents->num_rows > 0): ?>
                <div class="events-grid">
                    <?php while ($event = $pendingEvents->fetch_assoc()): 
                        $eventImages = getEventImages($conn, $event['id']);
                        $hasImages = !empty($eventImages) || !empty($event['venue_image']);
                    ?>
                        <div class="event-card">
                            <?php if ($hasImages): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($event['venue_image'] ?: $eventImages[0]['image_path']); ?>" 
                                     alt="Venue" 
                                     class="event-image clickable-image" 
                                     onclick="openImageModal(<?php echo $event['id']; ?>)"
                                     title="Click to view all images">
                            <?php else: ?>
                                <div class="event-image"></div>
                            <?php endif; ?>
                            <div class="event-body">
                                <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <p class="event-info"><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue_name']); ?></p>
                                <p class="event-info"><strong>Address:</strong> <?php echo htmlspecialchars($event['venue_address']); ?></p>
                                <p class="event-info"><strong>Capacity:</strong> <?php echo $event['max_capacity']; ?> slots</p>
                                <p class="event-info"><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer_name']); ?></p>
                                <p class="event-info"><strong>Description:</strong> <?php echo htmlspecialchars(substr($event['description'] ?? '', 0, 100)); ?>...</p>
                                <?php if ($hasImages): ?>
                                    <p class="event-info" style="color: var(--primary-green); cursor: pointer;" onclick="openImageModal(<?php echo $event['id']; ?>)">
                                        <strong>📷 Click to view all images (<?php echo count($eventImages) + (!empty($event['venue_image']) ? 1 : 0); ?>)</strong>
                                    </p>
                                <?php endif; ?>
                                <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
                                    <form method="POST" style="flex: 1;">
                                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-success" style="width: 100%;">Approve</button>
                                    </form>
                                    <form method="POST" style="flex: 1;">
                                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-danger" style="width: 100%;">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Image Modal for this event -->
                        <div id="modal-<?php echo $event['id']; ?>" class="image-modal">
                            <div class="image-modal-content">
                                <div class="image-modal-header">
                                    <h2><?php echo htmlspecialchars($event['title']); ?> - Venue Images</h2>
                                    <button class="close-modal" onclick="closeImageModal(<?php echo $event['id']; ?>)">&times;</button>
                                </div>
                                <div class="image-gallery">
                                    <?php if (!empty($event['venue_image'])): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($event['venue_image']); ?>" 
                                             alt="Venue Image" 
                                             class="gallery-image"
                                             onclick="window.open(this.src, '_blank')">
                                    <?php endif; ?>
                                    <?php foreach ($eventImages as $img): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($img['image_path']); ?>" 
                                             alt="Event Image" 
                                             class="gallery-image"
                                             onclick="window.open(this.src, '_blank')">
                                    <?php endforeach; ?>
                                </div>
                                <?php if (empty($event['venue_image']) && empty($eventImages)): ?>
                                    <div class="empty-state">
                                        <p>No images available for this event</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <p>No pending events for approval</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        function openImageModal(eventId) {
            document.getElementById('modal-' + eventId).style.display = 'block';
        }
        
        function closeImageModal(eventId) {
            document.getElementById('modal-' + eventId).style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('image-modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>

