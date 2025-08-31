<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM userRegistration WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>
<body>
    <h2>Update Profile</h2>
    <?php if (isset($_GET['success'])) echo "<p style='color: green;'>Profile updated successfully!</p>"; ?>
    <?php if (isset($_GET['error'])) echo "<p style='color: red;'>{$_GET['error']}</p>"; ?>
    
    <form action="process_update_profile.php" method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br>
        
        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>
        
        <label>City:</label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required><br>
        
        <label>State:</label>
        <input type="text" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required><br>
        
        <label>Postal Code:</label>
        <input type="text" name="post_code" value="<?php echo htmlspecialchars($user['post_code']); ?>" required><br>

        <button type="submit">Update Profile</button>
    </form>
    <br>
    <a href="user_profile.php">Back to Profile</a>
</body>
</html>
