<!-- Aldrich Mira -->
<?php
session_start();

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

// Fetch all applications
$sql = "SELECT * FROM applications ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN APPLICATION HISTORY</title>
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

        .applications-table {
            margin: 20px;
            background: rgba(255, 255, 255, 0.0);
            backdrop-filter: blur(8px);
            border-bottom: 3px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .applications-table table {
            width: 100%;
            border-collapse: collapse;
            color: #dcdcdc;
        }

        .applications-table th,
        .applications-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .applications-table th {
            color: #91a3b0;
            font-size: 14px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #ffd700;
            color: #000;
        }

        .status-approved {
            background-color: #4caf50;
            color: white;
        }

        .status-rejected {
            background-color: #dc3545;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-view {
            background: #536878;
            text-decoration-color: #536878
        }

        .btn-approve {
            background-color: #2e8b57;
        }

        .btn-reject {
            background-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
            transform: translateY(-2px);
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
                width: 60px;
                padding: 10px;
            }

            .sidebar .logo-text,
            .profile-name {
                display: none;
            }

            .main-content {
                margin-left: 60px;
            }

            .applications-table {
                margin: 10px;
                overflow-x: auto;
            }

            .applications-table table {
                min-width: 800px;
            }
        }

        @media screen and (max-width: 480px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }
        @media screen and (max-width: 1024px) {
    body {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        flex-direction: row;
        align-items: center;
        padding: 10px;
    }

    .logo-section {
        flex-grow: 1;
    }

    .profile-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-image {
        width: 50px;
        height: 50px;
    }

    .nav-menu {
        display: flex;
        flex-grow: 1;
        gap: 10px;
        margin-top: 0;
    }

    .nav-item {
        flex-direction: column;
        align-items: center;
        font-size: 12px;
        padding: 5px;
    }

    .nav-item svg {
        margin-bottom: 3px;
    }

    .main-content {
        margin-left: 0;
    }
}

/* Mobile Specific Adjustments */
@media screen and (max-width: 768px) {
    .sidebar {
        flex-wrap: wrap;
    }
    .nav-menu {
        flex-direction: column;
        width: 100%;
    }

    .applications-table table {
        font-size: 12px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        margin: 5px 0;
        padding: 8px;
    }

    .status-badge {
        font-size: 10px;
        padding: 3px 8px;
    }
}

@media screen and (max-width: 480px) {
    .header {
        flex-direction: column;
        align-items: center;
    }

    .page-header {
        text-align: center;
    }

    .applications-table {
        padding: 10px;
        margin: 10px 5px;
    }

    .applications-table table {
        font-size: 11px;
    }
}

/* Flexible Typography */
html {
    font-size: 16px;
}

@media screen and (max-width: 1024px) {
    html {
        font-size: 14px;
    }
}

@media screen and (max-width: 768px) {
    html {
        font-size: 12px;
    }
}

/* Flexbox Improvements */
.sidebar, .main-content {
    display: flex;
    flex-direction: column;
}

/* Responsive Images */
img {
    max-width: 100%;
    height: auto;
}

/* Responsive Tables */
.applications-table {
    overflow-x: auto;
}

.applications-table table {
    width: 100%;
    min-width: 300px;
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

    <div class="main-content">
        <header class="header">
           
        </header>

        <div class="page-header">
            Application History
        </div>

        <div class="applications-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Scholarship</th>
                        <th>School</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $status = isset($row['status']) ? $row['status'] : 'Pending';
                            $statusClass = 'status-' . strtolower($status);
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['fullName']}</td>
                                    <td>{$row['scholarshipName']}</td>
                                    <td>{$row['school']}</td>
                                    <td>{$row['course']}</td>
                                    <td>{$row['yearLevel']}</td>
                                    <td><span class='status-badge {$statusClass}'>{$status}</span></td>
                                    <td class='action-buttons'>
                                        <a href='view_application.php?id={$row['id']}' class='btn btn-view'>View</a>
                                        <button class='btn btn-approve' onclick='updateStatus({$row['id']}, \"Approved\")'>Approve</button>
                                        <button class='btn btn-reject' onclick='updateStatus({$row['id']}, \"Rejected\")'>Reject</button>
                                    </td>
                                </tr>";
                        }
                    }else {
                        echo "<tr><td colspan='8' style='text-align: center;'>No applications found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function viewApplication(applicationId) {
    // Validate the application ID
    if (!applicationId || isNaN(applicationId)) {
        console.error('Invalid application ID');
        alert('Error: Invalid application ID');
        return;
    }

    try {
        // Redirect to the view application details page with the ID
        window.location.href = `view_application.php?id=${applicationId}`;
    } catch (error) {
        console.error('Error navigating to application details:', error);
        alert('Error: Unable to view application details. Please try again.');
    }
}

// Add event listener for the back button in the details view
document.addEventListener('DOMContentLoaded', function() {
    // If we're on the details page and there's a back button
    const backButton = document.querySelector('.back-button');
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            // Navigate back to the application history page
            window.location.href = 'admin_application_history.php';
        });
    }
});

// Add error handling for failed application loads
window.addEventListener('error', function(e) {
    if (e.target.tagName === 'IMG') {
        // Handle failed image loads
        e.target.src = 'placeholder.png';
    }
});
        // Close modal
        function closeModal() {
            document.getElementById('applicationDetailsModal').style.display = 'none';
        }

        // Update application status (Approve/Reject)
        function updateStatus(application_id, status) {
            if (confirm('Are you sure you want to ' + status.toLowerCase() + ' this application?')) {
                const button = event.target;
                const originalText = button.textContent;
                button.disabled = true;
                button.textContent = 'Processing...';

                fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'application_id=' + application_id + '&status=' + status
                })
                .then(response => response.text())
                .then(data => {
                    alert('Status updated successfully');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating status');
                    button.disabled = false;
                    button.textContent = originalText;
                });
            }
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