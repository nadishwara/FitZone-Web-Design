<?php
// registration.php

if (isset($_POST['submit'])) {
    include("connection.php");
    
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $role = $conn->real_escape_string($_POST['role']);
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

    //Error handeling password
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        die("<script>alert('Passwords do not match!'); window.history.back();</script>");
    }

    //Error handeling already valid email
    $checkEmail = $conn->query("SELECT email FROM userRegistration WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        die("<script>alert('Email already registered!'); window.history.back();</script>");
    }

    $valid_role = 'member'; 
    $needs_approval = false;
    
    if ($role === 'admin') {
        // SECURE admin details
        if (isset($_POST['admin_code']) && $_POST['admin_code'] === 'YOUR_SECURE_ADMIN_CODE') {
            $valid_role = 'admin';
        } else {
            $needs_approval = true;
            // You might store this in a separate admin approval queue
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO userRegistration (
        first_name, last_name, address, city, state, post_code, gender, 
        dob, email, password, contact_method, emergency_first_name, 
        emergency_last_name, emergency_contact, emergency_relationship, role
    ) VALUES (
        '$firstName', '$lastName', '$address', '$city', '$state', '$postCode', 
        '$gender', '$dob', '$email', '$password', '$contactMethod', 
        '$emergencyFirstName', '$emergencyLastName', '$emergencyContact', 
        '$emergencyRelationship', '$valid_role'
    )";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        
        // If this was an admin registration attempt needing approval
        if ($needs_approval) {
            $conn->query("INSERT INTO admin_approvals (user_id, requested_at) 
                         VALUES ($user_id, NOW())");
            
            echo "<script>
                    alert('$firstName, your member registration was successful! Admin access requires approval.');
                    window.location.href = 'login.html';
                  </script>";
        }
        // If successfully registered as admin
        elseif ($valid_role === 'admin') {
            // Add to admin panel table
            $conn->query("INSERT INTO adminPanel (user_id, access_level) 
                         VALUES ($user_id, 'limited')");
            
            echo "<script>
                    alert('$firstName, your admin registration was successful!');
                    window.location.href = 'admin/dashboard.php';
                  </script>";
        }
        // Regular member registration
        else {
            echo "<script>
                    alert('$firstName, your registration at FitZone was successful!');
                    window.location.href = 'user_profile.php?email=$email';
                  </script>";
        }
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