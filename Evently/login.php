<?php
// Login Page
// Backend: TRISTAN
require_once 'config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $query = "SELECT id, username, password, full_name, role, status FROM users WHERE username = ? OR email = ?";
        $result = $conn->prepare($query);
        $result->bind_param("ss", $username, $username);
        $result->execute();
        $user = $result->get_result()->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] == 'banned') {
                $error = 'Your account has been banned';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] == 'admin') {
                    header('Location: admin/dashboard.php');
                } elseif ($user['role'] == 'organizer') {
                    header('Location: organizer/dashboard.php');
                } else {
                    header('Location: user/dashboard.php');
                }
                exit();
            }
        } else {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Evently</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 5rem;">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Login</h2>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Username or Email</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>

