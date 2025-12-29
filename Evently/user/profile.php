<?php
// User Profile & Settings
// Backend: JANRO
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['user', 'organizer', 'admin']);

$userId = $_SESSION['user_id'];
$message = '';
$error = '';

// Get user details
$userQuery = "SELECT * FROM users WHERE id = ?";
$userResult = $conn->prepare($userQuery);
$userResult->bind_param("i", $userId);
$userResult->execute();
$user = $userResult->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($full_name) || empty($email)) {
        $error = 'Please fill in all required fields';
    } else {
        // Check if email is already taken by another user
        $emailCheckQuery = "SELECT id FROM users WHERE email = ? AND id != ?";
        $emailCheckResult = $conn->prepare($emailCheckQuery);
        $emailCheckResult->bind_param("si", $email, $userId);
        $emailCheckResult->execute();
        
        if ($emailCheckResult->get_result()->num_rows > 0) {
            $error = 'Email already taken by another user';
        } else {
            $updateQuery = "UPDATE users SET full_name = ?, email = ?";
            $params = [$full_name, $email];
            $types = 'ss';
            
            // Update password if provided
            if (!empty($new_password)) {
                if (empty($current_password)) {
                    $error = 'Please enter current password to change password';
                } elseif (!password_verify($current_password, $user['password'])) {
                    $error = 'Current password is incorrect';
                } elseif (strlen($new_password) < 6) {
                    $error = 'New password must be at least 6 characters long';
                } elseif ($new_password !== $confirm_password) {
                    $error = 'New passwords do not match';
                } else {
                    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                    $updateQuery .= ", password = ?";
                    $params[] = $hashedPassword;
                    $types .= 's';
                }
            }
            
            if (empty($error)) {
                $updateQuery .= " WHERE id = ?";
                $params[] = $userId;
                $types .= 'i';
                
                $updateResult = $conn->prepare($updateQuery);
                $updateResult->bind_param($types, ...$params);
                
                if ($updateResult->execute()) {
                    $_SESSION['full_name'] = $full_name;
                    $message = '<div class="alert alert-success">Profile updated successfully</div>';
                    // Refresh user data
                    $userResult->execute();
                    $user = $userResult->get_result()->fetch_assoc();
                } else {
                    $error = 'Failed to update profile. Please try again.';
                }
            }
        }
    }
}

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    if ($_FILES['profile_picture']['error'] == 0) {
        $uploadDir = '../uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExtension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            $fileName = uniqid() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
                // Delete old profile picture if exists
                if ($user['profile_picture']) {
                    $oldPath = $uploadDir . $user['profile_picture'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                $updatePicQuery = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $updatePicResult = $conn->prepare($updatePicQuery);
                $updatePicResult->bind_param("si", $fileName, $userId);
                if ($updatePicResult->execute()) {
                    $message = '<div class="alert alert-success">Profile picture updated successfully</div>';
                    $user['profile_picture'] = $fileName;
                }
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
    <title>My Profile - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/main.js"></script>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">My Profile</h1>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Profile Information</h2>
            </div>
            
            <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <?php if ($user['profile_picture']): ?>
                        <img src="../uploads/profiles/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile" class="image-preview" style="width: 150px; height: 150px;">
                    <?php else: ?>
                        <div class="image-preview" style="width: 150px; height: 150px; background-color: var(--light-green); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white;"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data" style="margin-top: 1rem;">
                        <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(this, 'profilePreview'); this.form.submit();" style="display: none;" id="profileUpload">
                        <label for="profileUpload" class="btn btn-secondary" style="width: 100%; cursor: pointer; text-align: center;">Change Picture</label>
                    </form>
                    <img id="profilePreview" class="image-preview" style="display: none; width: 150px; height: 150px; margin-top: 1rem;">
                </div>
                <div style="flex: 1;">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>
                    <p><strong>Member Since:</strong> <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                </div>
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($user['full_name']); ?>">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                
                <h3 style="margin-top: 2rem; margin-bottom: 1rem;">Change Password (Optional)</h3>
                
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" minlength="6">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" minlength="6">
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>

