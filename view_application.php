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

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the application details from the database
    $sql = "SELECT * FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the application exists
    if ($result->num_rows > 0) {
        $application = $result->fetch_assoc();
    } else {
        echo "Application not found.";
        exit;
    }
} else {
    echo "No application ID specified.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application Details</title>
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
    overflow: hidden; /* Prevent body scroll */
}

.main-content {
    margin-left: 250px;
    flex-grow: 1;
    background: transparent;
    height: 100vh;
    overflow: hidden; /* Prevent main content scroll */
}

.container {
    max-width: 950px;
    margin: 20px auto;
    background-color: rgba(255, 255, 255, 0.0);
    backdrop-filter: blur(8px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow-y: auto;
    height: calc(100vh - 120px);
    padding: 20px;
    scrollbar-width: none; /* For Firefox */
    -ms-overflow-style: none; /* For Internet Explorer and Edge */
}

/* For Webkit browsers (Chrome, Safari, etc.) */
.container::-webkit-scrollbar {
    display: none;
}

/* Ensure the sidebar stays fixed */
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
    overflow: hidden; /* Prevent sidebar scroll */
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
    z-index: 1001;
}

.icon-container:hover {
    background-color: #536878;
}

.dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    background-color: rgba(255, 255, 255, 0.0);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    overflow: hidden;
    z-index: 1002;
    width: 200px;
    transition: all 0.3s ease;
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
        .container h1 {
            text-align: center;
            font-size: 1.8rem;
            color: #fff;
            padding: 2rem;
            color: #91a3b0;
            margin-bottom: 0;
        }

        .info-section {
            padding: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-section h2 {
            font-size: 1.4rem;
            color: #91a3b0;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .info-item strong {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .info-item p {
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            background-color: #efcc00;
            color: black;
        }

        .back-button {
            display: inline-block;
            padding: 15px 70px;
            background-color: #5f9ea0;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            margin: 2rem;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            margin-left: 720px;
            margin-top: 60px;
        }

        .back-button:hover {
            background-color: #91a3b0;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .container {
                margin: 1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
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
                <img src="./img/Profile.png" alt="Profile">
            </div>
            <div class="profile-name">Admin</div>
        </div>

        <nav class="nav-menu">
            <a href="admin_dashboard.php" class="nav-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="admin_scholarship_program.php" class="nav-item">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                </svg>
                Scholarship Program
            </a>
            <a href="admin_application_history.php" class="nav-item">
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

    <!-- Main Content -->
    <div class="main-content">
        <header class="header">
            
        </header>

    <div class="page-header">
        Application Details
    </div>

        <div class="container animate__animated animate__fadeIn">
            <h1>Applicant Information</h1>
            <div class="info-section">
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Full Name</strong>
                        <p><?php echo htmlspecialchars($application['fullName']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Date of Birth</strong>
                        <p><?php echo htmlspecialchars($application['dob']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Email</strong>
                        <p><?php echo htmlspecialchars($application['email']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Phone Number</strong>
                        <p><?php echo htmlspecialchars($application['phone']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Student ID</strong>
                        <p><?php echo htmlspecialchars($application['studentId']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Address</strong>
                        <p><?php echo htmlspecialchars($application['address']); ?></p>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h2>Educational Background</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Current School/University</strong>
                        <p><?php echo htmlspecialchars($application['school']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Course/Program</strong>
                        <p><?php echo htmlspecialchars($application['course']); ?></p>
                    </div>
                    <div class="info-item">
                        <strong>Year Level</strong>
                        <p><?php echo htmlspecialchars($application['yearLevel']); ?></p>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h2>Application Status</h2>
                <div class="status-badge">
                    <?php echo htmlspecialchars($application['status']); ?>
                </div>
            </div>

            <a href="admin_application_history.php" class="back-button">Back</a>
        </div>
    </div>
    <script>
        function toggleDropdown(id) {
            const notificationDropdown = document.getElementById('notificationDropdown');
            const profileDropdown = document.getElementById('profileDropdown');

            document.getElementById(id).classList.toggle('active');

            if (id === 'notificationDropdown') {
                profileDropdown.classList.remove('active');
            } else if (id === 'profileDropdown') {
                notificationDropdown.classList.remove('active');
            }
        }
    </script>
</body>
</html>