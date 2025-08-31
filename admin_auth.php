<?php
session_start();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.html?error=admin_required");
    exit();
}

// Session timeout (30 minutes)
if (isset($_SESSION['last_login']) && (time() - $_SESSION['last_login'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: ../login.html?error=session_expired");
    exit();
}

// Update last activity time
$_SESSION['last_login'] = time();
?>