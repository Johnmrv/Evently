<?php
// Organizer Create/Edit Event - Post a new event or edit existing event
// Backend: STEFFI
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['organizer']);

$organizerId = $_SESSION['user_id'];
$message = '';
$error = '';
$editMode = false;
$eventId = 0;
$eventData = null;
$existingImages = [];

// Check if editing
if (isset($_GET['edit'])) {
    $eventId = intval($_GET['edit']);
    $editQuery = "SELECT * FROM events WHERE id = ? AND organizer_id = ?";
    $editResult = $conn->prepare($editQuery);
    $editResult->bind_param("ii", $eventId, $organizerId);
    $editResult->execute();
    $eventData = $editResult->get_result()->fetch_assoc();
    
    if ($eventData) {
        $editMode = true;
        // Get existing images
        $imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
        $imagesResult = $conn->prepare($imagesQuery);
        $imagesResult->bind_param("i", $eventId);
        $imagesResult->execute();
        $existingImages = $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        header('Location: my-events.php');
        exit();
    }
}

// Handle delete image
if (isset($_GET['delete_image']) && isset($_GET['image_id'])) {
    $imageId = intval($_GET['image_id']);
    $checkImageQuery = "SELECT ei.* FROM event_images ei 
                        JOIN events e ON ei.event_id = e.id 
                        WHERE ei.id = ? AND e.organizer_id = ?";
    $checkImageResult = $conn->prepare($checkImageQuery);
    $checkImageResult->bind_param("ii", $imageId, $organizerId);
    $checkImageResult->execute();
    $imageData = $checkImageResult->get_result()->fetch_assoc();
    
    if ($imageData) {
        // Delete file
        $filePath = '../uploads/' . $imageData['image_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Delete from database
        $deleteImageQuery = "DELETE FROM event_images WHERE id = ?";
        $deleteImageResult = $conn->prepare($deleteImageQuery);
        $deleteImageResult->bind_param("i", $imageId);
        if ($deleteImageResult->execute()) {
            $message = '<div class="alert alert-success">Image deleted successfully</div>';
            // Refresh page data
            if ($editMode && $eventId > 0) {
                $imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
                $imagesResult = $conn->prepare($imagesQuery);
                $imagesResult->bind_param("i", $eventId);
                $imagesResult->execute();
                $existingImages = $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $venue_name = $_POST['venue_name'] ?? '';
    $venue_address = $_POST['venue_address'] ?? '';
    $max_capacity = $_POST['max_capacity'] ?? 0;
    $eventId = intval($_POST['event_id'] ?? 0);
    
    if (empty($title) || empty($venue_name) || empty($venue_address) || $max_capacity <= 0) {
        $error = 'Please fill in all required fields';
    } else {
        // Verify ownership if editing
        if ($eventId > 0) {
            $verifyQuery = "SELECT id FROM events WHERE id = ? AND organizer_id = ?";
            $verifyResult = $conn->prepare($verifyQuery);
            $verifyResult->bind_param("ii", $eventId, $organizerId);
            $verifyResult->execute();
            if ($verifyResult->get_result()->num_rows == 0) {
                $error = 'Unauthorized access';
            }
        }
        
        if (empty($error)) {
            if ($eventId > 0) {
                // Update existing event
                $updateQuery = "UPDATE events SET title = ?, description = ?, venue_name = ?, venue_address = ?, max_capacity = ? WHERE id = ?";
                $updateResult = $conn->prepare($updateQuery);
                $updateResult->bind_param("ssssii", $title, $description, $venue_name, $venue_address, $max_capacity, $eventId);
                
                if ($updateResult->execute()) {
                    $message = '<div class="alert alert-success">Event updated successfully!</div>';
                    // Refresh event data
                    $editQuery = "SELECT * FROM events WHERE id = ? AND organizer_id = ?";
                    $editResult = $conn->prepare($editQuery);
                    $editResult->bind_param("ii", $eventId, $organizerId);
                    $editResult->execute();
                    $eventData = $editResult->get_result()->fetch_assoc();
                } else {
                    $error = 'Failed to update event. Please try again.';
                }
            } else {
                // Create new event
                $insertQuery = "INSERT INTO events (organizer_id, title, description, venue_name, venue_address, max_capacity, status) 
                                VALUES (?, ?, ?, ?, ?, ?, 'pending')";
                $insertResult = $conn->prepare($insertQuery);
                $insertResult->bind_param("issssi", $organizerId, $title, $description, $venue_name, $venue_address, $max_capacity);
                
                if ($insertResult->execute()) {
                    $eventId = $conn->insert_id;
                    $message = '<div class="alert alert-success">Event created successfully! Waiting for admin approval.</div>';
                    $_POST = array();
                } else {
                    $error = 'Failed to create event. Please try again.';
                }
            }
            
            // Handle multiple image uploads
            if ($eventId > 0 && isset($_FILES['venue_images']) && !empty($_FILES['venue_images']['name'][0])) {
                $uploadDir = '../uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $uploadedCount = 0;
                
                foreach ($_FILES['venue_images']['name'] as $key => $fileName) {
                    if ($_FILES['venue_images']['error'][$key] == 0) {
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        
                        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                            $newFileName = uniqid() . '.' . $fileExtension;
                            $targetPath = $uploadDir . $newFileName;
                            
                            if (move_uploaded_file($_FILES['venue_images']['tmp_name'][$key], $targetPath)) {
                                $insertImageQuery = "INSERT INTO event_images (event_id, image_path) VALUES (?, ?)";
                                $insertImageResult = $conn->prepare($insertImageQuery);
                                $insertImageResult->bind_param("is", $eventId, $newFileName);
                                if ($insertImageResult->execute()) {
                                    $uploadedCount++;
                                }
                            }
                        }
                    }
                }
                
                if ($uploadedCount > 0) {
                    $message .= '<div class="alert alert-success">' . $uploadedCount . ' image(s) uploaded successfully!</div>';
                }
            }
            
            // Refresh images after any operation
            if ($eventId > 0) {
                $imagesQuery = "SELECT * FROM event_images WHERE event_id = ? ORDER BY created_at ASC";
                $imagesResult = $conn->prepare($imagesQuery);
                $imagesResult->bind_param("i", $eventId);
                $imagesResult->execute();
                $existingImages = $imagesResult->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;"><?php echo $editMode ? 'Edit Event' : 'Create New Event'; ?></h1>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Event Information</h2>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editMode): ?>
                    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label">Event Title *</label>
                    <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($eventData['title'] ?? $_POST['title'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($eventData['description'] ?? $_POST['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Venue Name *</label>
                    <input type="text" name="venue_name" class="form-control" required value="<?php echo htmlspecialchars($eventData['venue_name'] ?? $_POST['venue_name'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Venue Address/Location *</label>
                    <textarea name="venue_address" class="form-control" rows="3" required><?php echo htmlspecialchars($eventData['venue_address'] ?? $_POST['venue_address'] ?? ''); ?></textarea>
                    <small style="color: var(--text-light);">Enter the full address or location of the venue</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Maximum Capacity (Slots) *</label>
                    <input type="number" name="max_capacity" class="form-control" required min="1" value="<?php echo htmlspecialchars($eventData['max_capacity'] ?? $_POST['max_capacity'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Venue Images (Multiple - Optional)</label>
                    <input type="file" name="venue_images[]" class="form-control" accept="image/*" multiple>
                    <small style="color: var(--text-light);">You can select multiple images at once</small>
                </div>
                
                <?php if ($editMode && !empty($existingImages)): ?>
                    <div class="form-group">
                        <label class="form-label">Current Images</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
                            <?php foreach ($existingImages as $img): ?>
                                <div style="position: relative;">
                                    <img src="../uploads/<?php echo htmlspecialchars($img['image_path']); ?>" alt="Event Image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid var(--border-color);">
                                    <a href="?edit=<?php echo $eventId; ?>&delete_image=1&image_id=<?php echo $img['id']; ?>" 
                                       class="btn btn-danger" 
                                       style="position: absolute; top: 5px; right: 5px; padding: 0.25rem 0.5rem; font-size: 0.75rem;"
                                       onclick="return confirm('Are you sure you want to delete this image?');">Delete</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary"><?php echo $editMode ? 'Update Event' : 'Create Event'; ?></button>
                <a href="my-events.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>

