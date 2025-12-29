<?php
// Session Management
// Backend: TRISTAN
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit();
    }
}

function checkRole($allowedRoles) {
    checkLogin();
    if (!in_array($_SESSION['role'], $allowedRoles)) {
        header('Location: ../index.php');
        exit();
    }
}

function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'full_name' => $_SESSION['full_name'],
            'role' => $_SESSION['role']
        ];
    }
    return null;
}
?>

