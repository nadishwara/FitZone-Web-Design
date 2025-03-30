<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Get form data
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$postCode = $_POST['post_code'];

// Update database
$sql = "UPDATE userRegistration SET first_name=?, last_name=?, email=?, gender=?, address=?, city=?, state=?, post_code=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $firstName, $lastName, $email, $gender, $address, $city, $state, $postCode, $userId);

if ($stmt->execute()) {
    header("Location: update_profile.php?success=1");
} else {
    header("Location: update_profile.php?error=Error updating profile!");
}

$stmt->close();
$conn->close();
?>
