<?php
// Check Date Availability
// Backend: GERO
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['event_id'] ?? 0;
    $date = $_POST['date'] ?? '';
    
    if ($eventId && $date) {
        // Only check future dates - past dates are automatically available
        $checkQuery = "SELECT id FROM bookings WHERE event_id = ? AND event_date = ? AND status = 'approved' AND event_date >= CURDATE()";
        $checkResult = $conn->prepare($checkQuery);
        $checkResult->bind_param("is", $eventId, $date);
        $checkResult->execute();
        
        $available = $checkResult->get_result()->num_rows == 0;
        echo json_encode(['available' => $available]);
    } else {
        echo json_encode(['available' => false, 'error' => 'Invalid parameters']);
    }
} else {
    echo json_encode(['available' => false, 'error' => 'Invalid request']);
}
?>

