<?php
// Registration Page
// Backend: TRISTAN
require_once 'config.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Please fill in all required fields';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ?";
        $checkResult = $conn->prepare($checkQuery);
        $checkResult->bind_param("ss", $username, $email);
        $checkResult->execute();
        
        if ($checkResult->get_result()->num_rows > 0) {
            $error = 'Username or email already exists';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)";
            $insertResult = $conn->prepare($insertQuery);
            $insertResult->bind_param("sssss", $username, $email, $hashedPassword, $full_name, $role);
            
            if ($insertResult->execute()) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
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
    <title>Register - Evently</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin-top: 3rem;">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Register</h2>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password (min 6 characters)</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Register as</label>
                    <select name="role" class="form-control">
                        <option value="user">User</option>
                        <option value="organizer">Organizer</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>

