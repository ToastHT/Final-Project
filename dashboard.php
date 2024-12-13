<!-- Aldrich Mira -->
<?php
session_start();
include 'db.php'; // Include your DB connection

// Retrieve the username from session
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS-DASHBOARD</title>
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
        body::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
body {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

/* Adjust main content to prevent overflow */
.main-content {
    margin-left: 250px;
    flex-grow: 1;
    background: transparent;
    position: relative;
    height: 100vh;
    overflow: hidden;
}

/* Allow scrolling in the form container only */
.form-container {
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    padding-right: 20px; /* Add some padding to account for scroll space */
}

/* Style the form container scrollbar */
.form-container::-webkit-scrollbar {
    width: 6px;
}

.form-container::-webkit-scrollbar-track {
    background: transparent;
}

.form-container::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}


        /* Sidebar Styling */
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

        .profile-name {
            color: #dcdcdc;
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

        /* Main Content Area */
        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            background: transparent;
        }

        .header {
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 16px 30px;
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            color: white;
            position: relative;
            z-index: 1000;
        }

        .icon-container {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .icon-container:hover {
            background-color: #536878;
        }

        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 10;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .dropdown-item {
            padding: 12px 16px;
            font-size: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .dropdown-item:hover {
            background-color: #536878;
            transform: translateX(5px);
        }

        .page-header {
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            padding: 15px 30px;
            font-size: 14px;
            color: #dcdcdc;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: calc(100vh - 120px);
        }

        .announcement-section {
            width: 100%;
            max-width: 800px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .announcement-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .announcement-title {
            font-size: 32px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
            color: #91a3b0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .announcement-text {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: white;
        }

        .Application-title {
            font-size: 24px;
            font-weight: 600;
            margin: 30px 0 15px;
            color: #91a3b0;
            text-align: center;
        }

        .application-period {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .requirements-section {
            margin-top: 30px;
            text-align: center;
        }

        .requirements-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #91a3b0;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin-top: 15px;
            text-align: left;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .requirements-list li {
            margin: 15px 0;
            padding-left: 30px;
            position: relative;
            color: white;
        }

        .requirements-list li:before {
            content: '•';
            position: absolute;
            left: 0;
            font-size: 20px;
            color: #bebebe;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                padding: 16px 20px;
            }

            .content-area {
                padding: 20px;
            }

            .announcement-section {
                padding: 20px;
            }

            .announcement-title {
                font-size: 24px;
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
            <div class="icon-container" onclick="toggleDropdown('notificationDropdown')">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <div id="notificationDropdown" class="dropdown">
                    <a href="notification.php" class="dropdown-item">Notifications</a>
                </div>
            </div>

            <div class="icon-container" onclick="toggleDropdown('profileDropdown')">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <div id="profileDropdown" class="dropdown">
                    <a href="manage-account.php" class="dropdown-item">View Profile</a>
                    <a href="logout.php" class="dropdown-item" onclick="return confirm('Are you sure you want to log out?');">Log Out</a>
                </div>
            </div>
        </header>

        <div class="page-header">
            Dashboard / Overview
        </div>

        <div class="content-area">
    <div class="announcement-section">
        <h1 class="announcement-title" id="announcementTitle">Announcement</h1>
        
        <p class="announcement-text" id="announcementText">Loading...</p>

        <div class="Application-section">
        <div class="Application-title"><b>Application Period:</b></div>
        <div class="application-period">
            <div id="applicationPeriod">Loading...</div>
        </div>

        <div class="requirements-section">
            <div class="requirements-title">Eligibility Requirements:</div>
            <ul class="requirements-list">
                <li id="requirement1">Loading...</li>
                <li id="requirement2">Loading...</li>
            </ul>
        </div>
    </div>
</div>

    <script>
        function toggleDropdown(id) {
    // Get both dropdowns
    const notificationDropdown = document.getElementById('notificationDropdown');
    const profileDropdown = document.getElementById('profileDropdown');

    // Toggle the clicked dropdown
    document.getElementById(id).classList.toggle('active');

    // Hide the other dropdown
    if (id === 'notificationDropdown') {
        profileDropdown.classList.remove('active');
    } else if (id === 'profileDropdown') {
        notificationDropdown.classList.remove('active');
    }
}
document.addEventListener('DOMContentLoaded', loadLatestAnnouncement);

function loadLatestAnnouncement() {
    fetch('announcement_handlers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get'
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            document.getElementById('announcementTitle').innerText = data.title;
            document.getElementById('announcementText').innerText = data.content;
            document.getElementById('applicationPeriod').innerText = data.application_period;
            document.getElementById('requirement1').innerText = data.requirement1;
            document.getElementById('requirement2').innerText = data.requirement2;
        } else {
            // No announcement exists
            document.getElementById('announcementText').innerText = 'No announcement available.';
            document.getElementById('applicationPeriod').innerText = '';
            document.getElementById('requirement1').innerText = '';
            document.getElementById('requirement2').innerText = '';
        }
    })
    .catch(error => console.error('Error:', error));

}
window.onclick = function(event) {
            if (event.target == document.getElementById('profilePicModal')) {
                document.getElementById('profilePicModal').style.display = "none";
            }
        }
        window.onclick = function(event) {
            if (event.target == document.getElementById('editImageModal')) {
                document.getElementById('editImageModal').style.display = "none";
            }
        }
    </script>
</body>
</html>