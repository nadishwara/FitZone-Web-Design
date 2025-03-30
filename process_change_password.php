
<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get form data
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

// Validate new passwords
if ($newPassword !== $confirmPassword) {
    header("Location: change_password.php?error=New passwords do not match!");
    exit();
}

// Get current password from database
$sql = "SELECT password FROM userRegistration WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($currentPassword, $user['password'])) {
    header("Location: change_password.php?error=Incorrect current password!");
    exit();
}

// Update new password (hash it for security)
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateSql = "UPDATE userRegistration SET password = ? WHERE id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("si", $hashedPassword, $userId);

if ($updateStmt->execute()) {
    header("Location: change_password.php?success=1");
} else {
    header("Location: change_password.php?error=Error updating password!");
}

$conn->close();
?>
