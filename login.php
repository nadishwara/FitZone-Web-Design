<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT id, first_name, last_name, password FROM userRegistration WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            
            echo "<script>
                    alert('Login successful! Welcome back " . addslashes($user['first_name']) . "');
                    window.location.href = 'user_profile.php';
                  </script>";
            exit();
        } else {
            // Invalid password
            echo "<script>
                    alert('Invalid email or password');
                    window.history.back();
                  </script>";
        }
    } else {
        // User not found
        echo "<script>
                alert('Invalid email or password');
                window.history.back();
              </script>";
    }

    $conn->close();
} else {
    header("Location: login.html");
    exit();
}
?>