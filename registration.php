<?php
// registration.php

if (isset($_POST['submit'])) {
    include("connection.php");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect and sanitize input data
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $postCode = $conn->real_escape_string($_POST['postCode']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contactMethod = $conn->real_escape_string($_POST['contact']);
    $emergencyFirstName = $conn->real_escape_string($_POST['emergencyFirstName']);
    $emergencyLastName = $conn->real_escape_string($_POST['emergencyLastName']);
    $emergencyContact = $conn->real_escape_string($_POST['emergencyContact']);
    $emergencyRelationship = $conn->real_escape_string($_POST['relationship']);

    // Check if passwords match
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        die("<script>alert('Passwords do not match!'); window.history.back();</script>");
    }

    // Check if email already exists
    $checkEmail = $conn->query("SELECT email FROM userRegistration WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        die("<script>alert('Email already registered!'); window.history.back();</script>");
    }

    // Insert data into database
    $sql = "INSERT INTO userRegistration (
        first_name, last_name, address, city, state, post_code, gender, 
        dob, email, password, contact_method, emergency_first_name, 
        emergency_last_name, emergency_contact, emergency_relationship
    ) VALUES (
        '$firstName', '$lastName', '$address', '$city', '$state', '$postCode', 
        '$gender', '$dob', '$email', '$password', '$contactMethod', 
        '$emergencyFirstName', '$emergencyLastName', '$emergencyContact', '$emergencyRelationship'
    )";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "<script>
                alert('$firstName, your registration at FitZone was successful!');
                window.location.href = 'user_profile.php?email=$email';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.history.back();
              </script>";
    }

    $conn->close();
} else {
    // If form wasn't submitted properly
    header("Location: registration_form.html");
    exit();
}
?>