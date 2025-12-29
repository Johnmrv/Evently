<?php
// Cancel Booking
// Backend: GERO
require_once '../config.php';
require_once '../includes/session.php';
header('Content-Type: application/json');

checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bookingId = $_POST['booking_id'] ?? 0;
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    
    // Verify user owns the booking
    if ($role == 'user') {
        $verifyQuery = "SELECT id FROM bookings WHERE id = ? AND user_id = ?";
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
    
    $updateQuery = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
    $updateResult = $conn->prepare($updateQuery);
    $updateResult->bind_param("i", $bookingId);
    
    if ($updateResult->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cancellation failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

