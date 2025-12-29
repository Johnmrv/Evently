<?php
// Admin Manage Users - View users, ban/delete users
// Backend: TRISTAN
require_once '../config.php';
require_once '../includes/session.php';
checkRole(['admin']);

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $userId = $_POST['user_id'] ?? 0;
    $action = $_POST['action'] ?? '';
    
    if ($action == 'ban') {
        $updateQuery = "UPDATE users SET status = 'banned' WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("i", $userId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">User banned successfully</div>';
        }
    } elseif ($action == 'unban') {
        $updateQuery = "UPDATE users SET status = 'active' WHERE id = ?";
        $updateResult = $conn->prepare($updateQuery);
        $updateResult->bind_param("i", $userId);
        if ($updateResult->execute()) {
            $message = '<div class="alert alert-success">User unbanned successfully</div>';
        }
    } elseif ($action == 'delete') {
        $deleteQuery = "DELETE FROM users WHERE id = ? AND role != 'admin'";
        $deleteResult = $conn->prepare($deleteQuery);
        $deleteResult->bind_param("i", $userId);
        if ($deleteResult->execute()) {
            $message = '<div class="alert alert-success">User deleted successfully</div>';
        }
    }
}

// Get all users
$usersQuery = "SELECT id, username, email, full_name, role, status, created_at FROM users ORDER BY created_at DESC";
$users = $conn->query($usersQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Evently</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="container">
        <h1 style="margin-bottom: 2rem;">Manage Users</h1>
        
        <?php echo $message; ?>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Users</h2>
            </div>
            <?php if ($users->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Full Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo ucfirst($user['role']); ?></td>
                                <td>
                                    <span class="badge <?php echo $user['status'] == 'active' ? 'badge-approved' : 'badge-rejected'; ?>">
                                        <?php echo ucfirst($user['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <?php if ($user['role'] != 'admin'): ?>
                                        <?php if ($user['status'] == 'active'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="ban">
                                                <button type="submit" class="btn btn-warning" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ban</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="unban">
                                                <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Unban</button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <p>No users found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

