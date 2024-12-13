<!-- Aldrich Mira -->
<?php
session_start();


$servername = "localhost";
$username = "u627256117_scholars";
$password = "!Ic//P]wA6";
$dbname = "u627256117_scholars";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_SESSION['username'];

// Query to get user data including the profile image
$sql = "SELECT full_name, profile_image FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if user exists and fetch data
if ($row = mysqli_fetch_assoc($result)) {
    $full_name = $row['full_name'];
    $profileImagePath = $row['profile_image']; // Path to the profile image
} else {
    // If no user found, set default values
    $full_name = "Unknown User";
    $profileImagePath = "images/default_profile.jpg"; // Default image path
}

// Get user's notifications
$user_id = $_SESSION['user_id']; // Make sure you have the user_id in session
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY timestamp DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS NOTIFICATIONS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        body {
            display: flex;
            min-height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('BG.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0);
            backdrop-filter: blur(8px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }
        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .logo-text {
            font-size: 14px;
            line-height: 1.2;
            color: #dcdcdc;
        }
        .profile-section {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .nav-menu {
            margin-top: 20px;
            flex-grow: 1;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            color: white;
            text-decoration: none;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            background: transparent;
            position: relative;
            height: 100vh;
            overflow: hidden;
        }
        .header {
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 38px 30px;
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            color: white;
            position: relative;
            z-index: 1000;
        }
        .page-header {
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            padding: 15px 30px;
            font-size: 14px;
            color: #dcdcdc;
        }
        .hero-section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px 0;
        }
        .notifications-container {
            width: 100%;
            max-width: 600px; /* Responsive max-width */
            padding: 2.5rem;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-height: 80vh; /* Limit height for scrolling */
            overflow-y: auto;
        }
        .notifications-container h2 {
            color: #91a3b0;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }
        .notification {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .notification:hover {
            transform: translateY(-3px);
            background-color: rgba(255, 255, 255, 0.2);
        }
        .notification-icon {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }
        .notification-content {
            flex-grow: 1;
        }
        .notification-message {
            color: #fff;
            margin-bottom: 5px;
        }
        .notification-timestamp {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .notifications-container {
                width: 95%;
                padding: 1.5rem;
                margin: 0 auto;
            }
            .notification {
                flex-direction: column;
                text-align: center;
            }
            .notification-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .notifications-container h2 {
                font-size: 1.5rem;
            }
            .notification-message {
                font-size: 0.9rem;
            }
            .notification-timestamp {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-section">
            <img src="./img/logo.png" alt="Logo" class="logo">
            <div class="logo-text">
                Barangay Darasa Scholarship Application System
            </div>
        </div>

        <div class="profile-section">
    <div class="profile-image">
        <img src="<?php echo $profileImagePath; ?>" alt="Profile" />
    </div>
    <div class="profile-name">
        <?php echo htmlspecialchars($full_name); ?>
    </div>
    </div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="scholarship_program.php" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
                Scholarship Program
            </a>
            <a href="user_application_history.php" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                Application History
            </a>
        </nav>

        <div class="sign-out">
            <a href="logout.php" class="nav-item" onclick="return confirm('Are you sure you want to sign out?');">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Sign Out
            </a>
        </div>
    </div>
    <div class="main-content">
        <header class="header">
        </header>
        
        <div class="page-header">
            Dashboard / Notifications
        </div>
        <section class="hero-section">
            <div class="notifications-container animate__animated animate__fadeIn">
                <h2>Notifications</h2>
                <?php 
                if ($result->num_rows > 0) {
                    while($notification = $result->fetch_assoc()) {
                        // Determine icon based on icon_type
                        $icon = '';
                        switch($notification['icon_type']) {
                            case 'success':
                                $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5cb85c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>';
                                break;
                            case 'reject':
                                $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                </svg>';
                                break;
                            case 'info':
                                $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5bc0de" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="16" x2="12" y2="12"/>
                                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                                </svg>';
                                break;
                            default:
                                $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="16" x2="12" y2="12"/>
                                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                                </svg>';
                        }
                        ?>
                        <div class="notification">
                            <div class="notification-icon">
                                <?php echo $icon; ?>
                            </div>
                            <div class="notification-content">
                                <div class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></div>
                                <div class="notification-timestamp"><?php echo date('Y-m-d H:i:s', strtotime($notification['timestamp'])); ?></div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="notification">
                            <div class="notification-content">
                                <div class="notification-message">No notifications yet.</div>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>
<?php
$conn->close();
?>