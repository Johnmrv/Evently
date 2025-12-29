<?php
// Update Event Status
// Backend: STEFFI
require_once '../config.php';
require_once '../includes/session.php';
header('Content-Type: application/json');

checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventId = $_POST['event_id'] ?? 0;
    $status = $_POST['status'] ?? '';
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    
    // Verify user has permission
    if ($role == 'organizer') {
        $verifyQuery = "SELECT id FROM events WHERE id = ? AND organizer_id = ?";
        $verifyResult = $conn->prepare($verifyQuery);
        $verifyResult->bind_param("ii", $eventId, $userId);
        $verifyResult->execute();
        
        if ($verifyResult->get_result()->num_rows == 0) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }
    } elseif ($role != 'admin') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }
    
    $updateQuery = "UPDATE events SET status = ? WHERE id = ?";
    $updateResult = $conn->prepare($updateQuery);
    $updateResult->bind_param("si", $status, $eventId);
    
    if ($updateResult->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

