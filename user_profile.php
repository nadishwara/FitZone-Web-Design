<?php
session_start();
include("connection.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user data
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM userRegistration WHERE id = $userId";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: login.php");
    exit();
}

$user = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['first_name']) ?>'s Profile | FitZone</title>
    <style>
        :root {
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #212529;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin: 30px 0;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary);
        }
        .profile-header h1 {
            color: var(--primary);
            margin-bottom: 10px;
        }
        .profile-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }
        .profile-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .profile-section h2 {
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-group {
            margin-bottom: 15px;
            display: flex;
        }
        .info-label {
            font-weight: 600;
            color: var(--secondary);
            width: 150px;
        }
        .info-value {
            flex: 1;
            padding: 8px;
            background: var(--light);
            border-radius: 4px;
        }
        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            margin: 0 10px;
        }
        .btn-primary {
            background: var(--primary);
            color: white;
            border: 2px solid var(--primary);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .profile-content {
                grid-template-columns: 1fr;
            }
            .info-group {
                flex-direction: column;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>!</h1>
            <p>Your FitZone Membership Profile</p>
        </div>

        <div class="profile-content">
            <!-- Personal Information Section -->
            <div class="profile-section">
                <h2>Personal Information</h2>
                
                <div class="info-group">
                    <span class="info-label">Full Name:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Email:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['email']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Gender:</span>
                    <div class="info-value">
                        <?php echo ucfirst(htmlspecialchars($user['gender'])) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Date of Birth:</span>
                    <div class="info-value">
                        <?php echo date('F j, Y', strtotime($user['dob'])) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Contact Preference:</span>
                    <div class="info-value">
                        <?php echo ucfirst(htmlspecialchars($user['contact_method'])) ?>
                    </div>
                </div>
            </div>
            
            <!-- Address Information Section -->
            <div class="profile-section">
                <h2>Address Information</h2>
                
                <div class="info-group">
                    <span class="info-label">Address:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['address']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">City:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['city']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">State:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['state']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Postal Code:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['post_code']) ?>
                    </div>
                </div>
            </div>
            
            <!-- Emergency Contact Section -->
            <div class="profile-section">
                <h2>Emergency Contact</h2>
                
                <div class="info-group">
                    <span class="info-label">Name:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['emergency_first_name'] . ' ' . $user['emergency_last_name']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Phone:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['emergency_contact']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Relationship:</span>
                    <div class="info-value">
                        <?php echo htmlspecialchars($user['emergency_relationship']) ?>
                    </div>
                </div>
            </div>
            
            <!-- Membership Information Section -->
            <div class="profile-section">
                <h2>Membership Details</h2>
                
                <div class="info-group">
                    <span class="info-label">Member Since:</span>
                    <div class="info-value">
                        <?php echo date('F j, Y', strtotime($user['registration_date'])) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Membership Status:</span>
                    <div class="info-value">
                        Active
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
            <a href="change_password.php" class="btn btn-outline">Change Password</a>
            <a href="logout.php" class="btn btn-outline">Logout</a>
        </div>
    </div>
</body>
</html>