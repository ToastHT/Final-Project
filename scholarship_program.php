<!-- Aldrich Mira -->
<?php
session_start();
require_once 'db.php';

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
// Fetch all scholarships from database
$sql = "SELECT * FROM scholarshipsss ORDER BY published_date DESC";
$result = $conn->query($sql);
$scholarships = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $scholarships[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER-SCHOLARSHIP PROGRAM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .scholarship-table {
            margin: 20px;
            background: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border-bottom: 3px solid rgba(255, 255, 255, 0.1);  
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .scholarship-table table {
            width: 100%;
            border-collapse: collapse;
            color: #dcdcdc;
        }

        .scholarship-table th,
        .scholarship-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .scholarship-table th {
            color: #91a3b0;
        }

        .view-btn {
            background: #536878;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .view-btn:hover {
            background: #5f9ea0;
        }

        .details-view {
            display: none;
            margin: 20px;
            background: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border: 5px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 50px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: #dcdcdc;
        }

        .details-header {
            border-bottom: 3px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .details-row {
            margin-bottom: 15px;
        }

        .details-row label {
            color: #91a3b0;
            margin-bottom: 5px;
            display: block;
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

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .back-btn {
            background: #536878;
            color: white;
            padding: 10px 60px;
            border: #5f9ea0;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 2px;
            transition: all 0.6s ease;
            background: rgba(255, 255, 255, 0.0);
            border: 2px solid #536878;
        }

        .back-btn:hover {
            background-color: #778899;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .apply-btn {
            background-color: #555555; 
            color: white;
            padding: 10px 60px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 2px;
            transition: all 0.6s ease;
        }

        .apply-btn:hover {
            background-color: #91a3b0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
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

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .scholarship-table {
                margin: 10px;
                overflow-x: auto;
            }
            
            .scholarship-table table {
                min-width: 800px;
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
            Home / Scholarship Program
        </div>
        
        <div class="scholarship-table" id="tableView">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Scholarship Name</th>
                        <th>Scholarship Type</th>
                        <th>Student Eligibility</th>
                        <th>Deadline</th>
                        <th>Published Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($scholarships as $index => $scholarship): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($scholarship['name']); ?></td>
                        <td><?php echo htmlspecialchars($scholarship['type']); ?></td>
                        <td><?php echo htmlspecialchars($scholarship['eligibility']); ?></td>
                        <td><?php echo date('m-d-y', strtotime($scholarship['deadline'])); ?></td>
                        <td><?php echo date('m-d-y', strtotime($scholarship['published_date'])); ?></td>
                        <td><button class="view-btn" onclick="showDetails(<?php echo $scholarship['id']; ?>)">VIEW</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <!-- Scholarship Details View -->
    <div class="details-view" id="detailsView">
    <div class="details-header">
        <h2>View Scholarship Program Details</h2>
    </div>
    
    <div class="details-row">
        <label>Name of Scholarship</label>
        <div id="scholarshipName"></div>
    </div>

    <div class="details-row">
        <label>Scholarship Type</label>
        <div id="scholarshipType"></div>
    </div>

    <div class="details-row">
        <label>Student Eligibility</label>
        <div id="eligibility"></div>
    </div>

    <div class="details-row">
        <label>Academic Year</label>
        <div id="academicYear"></div>
    </div>

    <div class="details-row">
        <label>Eligibility Criteria</label>
        <div id="criteria"></div>
    </div>

    <div class="details-row">
        <label>Scholarship Description</label>
        <div id="description"></div>
    </div>

    <div class="details-row">
        <label>Document Requirements</label>
        <div id="requirements"></div>
    </div>

    <div class="details-row">
        <label>Deadline</label>
        <div id="deadline"></div>
    </div>

    <div class="button-container">
    <button type="button" class="back-btn" onclick="window.location.href='scholarship_program.php'">Back</button>
    <button class="apply-btn" onclick="showApplicationPage()">Apply</button>
</div>
</div>
    

    <script>
        function showDetails(id) {
        // Fetch scholarship details using AJAX
        fetch(`get_scholarship_details.php?id=${id}`)
            .then(response => response.json())
            .then(scholarship => {
                document.getElementById('scholarshipName').innerText = scholarship.name;
                document.getElementById('scholarshipType').innerText = scholarship.type;
                document.getElementById('eligibility').innerText = scholarship.eligibility;
                document.getElementById('academicYear').innerText = scholarship.academic_year;
                document.getElementById('criteria').innerText = scholarship.criteria;
                document.getElementById('description').innerText = scholarship.description;
                document.getElementById('requirements').innerText = scholarship.requirements;
                document.getElementById('deadline').innerText = 
                    new Date(scholarship.deadline).toLocaleDateString();

                document.getElementById('tableView').style.display = 'none';
                document.getElementById('detailsView').style.display = 'block';
            });
    }


        function hideDetails() {
            document.getElementById('detailsView').style.display = 'none';
            document.getElementById('tableView').style.display = 'block';
        }
        function showApplicationPage() {
        // Redirect to the application page
        window.location.href = 'scholarship_application.php'; // Change 'application_page.php' to your actual PHP file
    }

    function hideDetails() {
        // Implement your hide logic here
    }
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
    </script>
</body>
</html>