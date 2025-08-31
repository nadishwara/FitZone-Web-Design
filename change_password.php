<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
    <h2>Change Password</h2>
    <?php if (isset($_GET['error'])) echo "<p style='color: red;'>{$_GET['error']}</p>"; ?>
    <?php if (isset($_GET['success'])) echo "<p style='color: green;'>Password changed successfully!</p>"; ?>
    
    <form action="process_change_password.php" method="POST">
        <label>Current Password:</label>
        <input type="password" name="current_password" required><br>
        
        <label>New Password:</label>
        <input type="password" name="new_password" required><br>
        
        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br>
        
        <button type="submit">Change Password</button>
    </form>
    <br>
    <a href="user_profile.php">Back to Profile</a>
</body>
</html>
