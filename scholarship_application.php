<!-- Aldrich Mira -->
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    $fullName = $_POST['fullName'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $studentId = $_POST['studentId'];
    $school = $_POST['school'];
    $course = $_POST['course'];
    $yearLevel = $_POST['yearLevel'];
    $scholarshipName = $_POST['scholarshipName'];
    
    // Add user_id and status to the INSERT query
    $stmt = $conn->prepare("INSERT INTO applications (user_id, fullName, dob, address, email, phone, studentId, school, course, yearLevel, scholarshipName, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
    
    $stmt->bind_param("issssssssss", 
        $user_id, 
        $fullName, 
        $dob, 
        $address, 
        $email, 
        $phone, 
        $studentId, 
        $school, 
        $course, 
        $yearLevel, 
        $scholarshipName
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Application submitted successfully!');
            window.location.href = 'user_application_history.php';
        </script>";
        exit();
    } else {
        echo "<script>alert('Error submitting application. Please try again.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Darasa Scholarship Application System - Application Form</title>
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

        /* Hide scrollbar for Chrome, Safari and Opera */
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
.main-content {
    margin-left: 250px;
    flex-grow: 1;
    background: transparent;
    position: relative; /* Add relative positioning */
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
    position: relative; /* Ensure relative positioning */
    z-index: 1000; /* Increase z-index */
}
/* Notification Icon Container */
.icon-container {
    position: relative;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: background-color 0.3s ease;
    z-index: 1001; /* Higher than header */
}

.icon-container:hover {
    background-color: #536878;
}

/* Dropdown Styling */
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
    z-index: 1002; /* Highest z-index to stay on top */
    width: 200px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dropdown.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

/* Dropdown Items */
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

.dropdown-item:last-child {
    border-bottom: none;
}

/* Animation */
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

        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255,0);
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
        .page-header {
    background-color: rgba(255, 255, 255, 0.0);
    backdrop-filter: blur(8px);
    padding: 15px 30px;
    font-size: 14px;
    color: #dcdcdc;
}
 body::-webkit-scrollbar {
            display: none;
        }
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            background: transparent;
        }

        .form-container {
            width: 100%;
            max-width: 800px;
            padding: 2.5rem;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.0);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-height: calc(100vh - 200px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

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

        .form-container h2 {
            color: #91a3b0;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 600;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #f0f8ff;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .instructions {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .instructions ol {
            margin-left: 20px;
        }

        .instructions li {
            margin-bottom: 10px;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .submit-btn,
        .back-btn {
            padding: 10px 24px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
        }

        .submit-btn {
            background-color: #5f9ea0;
            color: #fff;
            border: none;
        }

        .submit-btn:hover {
            background-color: #91a3b0;
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(128, 128, 128, 0.4);
        }

        .back-btn {
            background-color: transparent;
            color: #fff;
            border: 2px solid #5f9ea0;
        }

        .back-btn:hover {
            background-color: #778899;
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(128, 128, 128, 0.4);
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

            .hero-section {
                padding: 20px;
            }

            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }
        }
    #dob::-webkit-calendar-picker-indicator {
      filter: invert(1); /* Inverts the color to white */
    }
    #scholarshipName option {
        background-color: #fff; /* White background for dropdown items */
        color: #000; /* Black text color for dropdown items */
    }

    #scholarshipName option:hover {
        background-color: rgba(0, 0, 0, 0.1); /* Slight transparency on hover */
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
            <a href="#" class="nav-item">
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

        <section class="hero-section">
            <div class="form-container animate__animated animate__fadeIn">
                <h2>Scholarship Application Form</h2>
                
                <form class="application-form" method="POST">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="scholarshipName">Scholarship Name:</label>
                            <select id="scholarshipName" name="scholarshipName" required>
                                <option value="">Select a scholarship</option>
                                <option value="City Government Academic Scholarship">City Government Academic Scholarship</option>
                                <option value="S&T Undergraduate Scholarship">S&T Undergraduate Scholarship</option>
                                <option value="SK Scholarship">SK Scholarship</option>
                                <option value="Tunong Dunong Program">Tunong Dunong Program</option>
                                <option value="SYDP Scholarship">SYDP Scholarship</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fullName">Full Name:</label>
                            <input type="text" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="studentId">Student ID:</label>
                            <input type="text" id="studentId" name="studentId" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="school">Current School/University:</label>
                            <input type="text" id="school" name="school" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course/Program Enrolled In:</label>
                            <input type="text" id="course" name="course" required>
                        </div>
                        <div class="form-group">
                            <label for="yearLevel">Year Level:</label>
                            <input type="text" id="yearLevel" name="yearLevel" required>
                        </div>
                    </div>

                    <div class="instructions">
                        <h3>Submission Instructions:</h3>
                        <ol>
                            <li>After review, you will be notified via email regarding the in-person document submission.</li>
                            <li>Ensure the email provided is active to avoid missing the submission schedule.</li>
                            <li>Incomplete or late submissions after notification will not be processed.</li>
                        </ol>
                        </div>
            <button type="button" class="back-btn" onclick="window.location.href='scholarship_program.php'">Cancel</button>
            <button type="submit" class="submit-btn">Apply</button>
    </form>
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
