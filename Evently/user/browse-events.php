<?php
// User Browse Events - View ONLY Admin-approved events
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user']);

// Search and filter
$search = $_GET['search'] ?? '';
$capacityFilter = $_GET['capacity'] ?? '';
$userId = $_SESSION['user_id'];

$whereConditions = ["e.status = 'approved'"];
$params = [];
$types = '';

// Exclude events where user has approved bookings
$whereConditions[] = "e.id NOT IN (SELECT event_id FROM bookings WHERE user_id = ? AND status = 'approved')";
$params[] = $userId;
$types .= 'i';

if (!empty($search)) {
    $whereConditions[] = "(e.venue_name LIKE ? OR e.venue_address LIKE ? OR e.title LIKE ?)";
    $searchParam = "%$search%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

if (!empty($capacityFilter)) {
    $whereConditions[] = "e.max_capacity >= ?";
    $params[] = $capacityFilter;
    $types .= 'i';
}

$whereClause = implode(' AND ', $whereConditions);

$eventsQuery = "SELECT e.*, u.full_name as organizer_name 
                FROM events e 
                JOIN users u ON e.organizer_id = u.id 
                WHERE $whereClause 
                ORDER BY e.created_at DESC";

// Function to get first event image
function getFirstEventImage($conn, $eventId) {
    $imageQuery = "SELECT image_path FROM event_images WHERE event_id = ? ORDER BY created_at ASC LIMIT 1";
    $imageResult = $conn->prepare($imageQuery);
    $imageResult->bind_param("i", $eventId);
    $imageResult->execute();
    $image = $imageResult->get_result()->fetch_assoc();
    return $image ? $image['image_path'] : null;
}

if (!empty($params)) {
    $eventsResult = $conn->prepare($eventsQuery);
    $eventsResult->bind_param($types, ...$params);
    $eventsResult->execute();
    $events = $eventsResult->get_result();
} else {
    $events = $conn->query($eventsQuery);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Browse Events</h1>
        
        <div class="search-filter-bar">
            <form method="GET" style="display: flex; gap: 1rem; width: 100%;">
                <input type="text" name="search" class="form-control" placeholder="Search venue name, address, or event title..." value="<?php echo htmlspecialchars($search); ?>">
                <input type="number" name="capacity" class="form-control" placeholder="Min capacity" value="<?php echo htmlspecialchars($capacityFilter); ?>" style="max-width: 150px;">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="browse-events.php" class="btn btn-secondary">Clear</a>
            </form>
        </div>
        
        <div class="events-grid">
            <?php if ($events->num_rows > 0): ?>
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
                            <p class="event-info"><strong>Slots:</strong> <?php echo $event['max_capacity']; ?></p>
                            <p class="event-info"><strong>Organizer:</strong> <?php echo htmlspecialchars($event['organizer_name']); ?></p>
                            <?php if ($event['description']): ?>
                                <p class="event-info" style="margin-top: 0.5rem;"><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                            <?php endif; ?>
                            <a href="book-event.php?id=<?php echo $event['id']; ?>" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Book Event</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <p>No events found. Try adjusting your search criteria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

