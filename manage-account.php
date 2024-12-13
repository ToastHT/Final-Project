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


// Load the users XML file
$xml = simplexml_load_file("users.xml") or die("Error: Cannot create object");

// Ensure the user is logged in and has a valid session ID
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_found = false;
$current_user = null;

// Search for the user in the XML file by user ID
foreach ($xml->user as $user) {
    if ((string)$user->id == $user_id) {
        $user_found = true;
        $current_user = $user;
        break;
    }
}

// If user not found in XML, display error
if (!$user_found) {
    echo "User not found in XML.";
    exit();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Update full name and username in the XML file
    $current_user->full_name = $name;
    $current_user->username = $username;

    // If a password is provided, hash it and update it
    if (!empty($password)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $current_user->password = $hashed_password;
    }

    // Save the updated XML file
    if ($xml->asXML("users.xml")) {
        echo "<script>alert('Account updated successfully!');</script>";
    } else {
        echo "<script>alert('Error saving account details to XML.');</script>";
    }

    // Now, update the user in the MySQL database
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, username = ?, password = ? WHERE id = ?");
    if (!empty($password)) {
        $stmt->bind_param("sssi", $name, $username, $hashed_password, $user_id);
    } else {
        $stmt->bind_param("sssi", $name, $username, $current_user->password, $user_id);
    }

    // Execute the query to update the MySQL database
    if ($stmt->execute()) {
        echo "<script>alert('Account updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating account details in the database.');</script>";
    }
    $stmt->close();
}

// Close MySQL connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Account - Barangay Darasa Scholarship Application System</title>
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
        .sidebar {
            width: 250px;
            background-color: rgba(255, 255, 255, 0.0);
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
        .page-header {
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            padding: 15px 30px;
            font-size: 14px;
            color: #dcdcdc;
        }

        .content-area {
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
        }

        .account-form {
            width: 100%;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            font-size: 24px;
            color: #91a3b0;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #91a3b0;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
        }

        .password-hint {
            font-size: 12px;
            color: #dcdcdc;
            margin-top: 5px;
            font-style: italic;
        }

        .button-group {
            display: flex;
            margin-left: 327px;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-save {
            background-color: #536878;
            color: white;
        }

        .btn-save:hover {
            background-color: #5f9ea0;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background-color: #ab4b52;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #af002a;
            transform: translateY(-2px);
        }
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background-color: rgba(255, 255, 255, .1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .modal-content {
            text-align: center;
        }

        .modal-content h2 {
            margin-bottom: 20px;
        }

        .modal-content input {
            width: 100%;
            margin-bottom: 20px;
        }

        .modal-content button {
            background-color: #1976D2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            border-radius: 25px;
        }

        .modal-content button:hover {
            background-color: #5f9ea0;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            font-size: 24px;
            color: #536878;
        }
        button {
    background-color: #536878; /* Updated background color */
    color: #ffffff;
    font-size: 16px;
    border-radius: 25px;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

button:hover {
    background-color: #415265; /* Slightly darker shade on hover */
    transform: translateY(-3px);
}

button:active {
    transform: translateY(0);
}
    </style>
</head>
<body>
<div class="sidebar">
        <div class="logo-section">
            <img src="./img/logo.png" alt="Logo" class="logo">
            <div class="logo-text">Barangay Darasa Scholarship Application System</div>
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
        </header>

        <div class="page-header">Manage Account</div>

<div class="content-area">
    <div class="account-form">
        <h2 class="form-title">Manage Account</h2>

        <!-- Profile Picture Section -->
        <div class="profile-section">
            <div class="profile-image">
                <img src="<?php echo $current_user->profile_image ?: './img/default-profile.png'; ?>" alt="Profile Picture">
            </div>
            <button onclick="document.getElementById('editImageModal').style.display='block'">
                Edit Profile Picture
            </button>
        </div>

        <!-- Modal for Profile Picture Editing -->
        <div id="editImageModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('editImageModal').style.display='none'">&times;</span>
                <form action="update_image.php" method="POST" enctype="multipart/form-data">
                    <label for="profile_image"></label>
                    <input type="file" name="profile_image" id="profile_image" required>
                    <button type="submit">Upload Image</button>
                </form>
            </div>
        </div>

        <!-- Account Details Form -->
        <form method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($current_user->full_name); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($current_user->username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <div class="password-hint">Leave this blank if you don't want to change the password.</div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-save">Save</button>
                <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>

    <script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('active');
    }

    window.onclick = function(event) {
        if (!event.target.matches('.icon-container, .icon-container *')) {
            document.getElementById('notificationDropdown').classList.remove('active');
        }
    };

    function validateForm() {
        var name = document.getElementById('name').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        if (name.trim() === '') {
            alert('Please enter your name');
            return false;
        }

        if (username.trim() === '') {
            alert('Please enter your username');
            return false;
        }

        if (password !== '') {
            if (password.length < 6) {
                alert('Password must be at least 6 characters long');
                return false;
            }
        }

        return true;
    }
    </script>
</body>
</html>