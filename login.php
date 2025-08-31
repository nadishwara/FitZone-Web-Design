<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $requested_role = $conn->real_escape_string($_POST['role']);

    // selected needed Query from database3 
    $sql = "SELECT id, first_name, last_name, password, role FROM userRegistration WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // cheacking psw
        if (password_verify($password, $user['password'])) {
            // Verify role 
            if ($requested_role === 'Admin' && $user['role'] !== 'admin') {
                die("<script>alert('Admin access denied'); window.history.back();</script>");
            }

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['last_login'] = time();
            
            // Record admin login
            if ($user['role'] === 'admin') {
                $conn->query("UPDATE adminPanel SET last_login = NOW() WHERE user_id = " . $user['id']);
            }

            //  role handling
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user_profile.php");
            }
            exit();
        } else { //error alert messages
            echo "<script>alert('Invalid credentials'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials'); window.history.back();</script>";
    }
} else {
    header("Location: login.html");
    exit();
}
?>