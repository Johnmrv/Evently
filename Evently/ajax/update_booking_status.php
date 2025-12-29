<?php
// Update Booking Status
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
header('Content-Type: application/json');

checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['booking_id'] ?? 0;
    $status = $_POST['status'] ?? '';
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    
    // Verify user has permission (organizer or admin)
    if ($role == 'organizer') {
        $verifyQuery = "SELECT b.id FROM bookings b 
                        JOIN events e ON b.event_id = e.id 
                        WHERE b.id = ? AND e.organizer_id = ?";
        $verifyResult = $conn->prepare($verifyQuery);
        $verifyResult->bind_param("ii", $bookingId, $userId);
        $verifyResult->execute();
        
        if ($verifyResult->get_result()->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }
    } elseif ($role != 'admin') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }
    
    $updateQuery = "UPDATE bookings SET status = ?, organizer_approved_by = ?, organizer_approved_at = NOW() WHERE id = ?";
    $updateResult = $conn->prepare($updateQuery);
    $updateResult->bind_param("sii", $status, $userId, $bookingId);
    
    if ($updateResult->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

