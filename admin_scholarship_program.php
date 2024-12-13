<!-- Aldrich Mira -->
<?php
session_start();
require_once 'db.php';

// Fetch all scholarships
$sql = "SELECT * FROM scholarshipsss ORDER BY published_date DESC";
$result = $conn->query($sql);
$scholarshipsss = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $scholarshipsss[] = $row;
    }
}

// Get specific scholarship details for view
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM scholarshipsss WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $scholarship_details = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN-SCHOLARSHIP Program</title>
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

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .view-btn, .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            color: white;
            transition: all 0.3s ease;
        }

        .view-btn {
            background: #536878;
        }

        .edit-btn {
            background-color: #4682b4;
        }

        .delete-btn {
            background: #dc3545;
        }

        .view-btn:hover {
            background: #5f9ea0;
        }

        .edit-btn:hover {
            background: #1976D2;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .add-scholarship-btn {
            background: #536878;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 20px;
            transition: all 0.3s ease;
        }

        .add-scholarship-btn:hover {
            background: #5f9ea0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
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
        .back-btn{
            background: #536878;
            color: white;
            padding: 10px 60px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 2px;
            transition: all 0.3s ease;
        }
        .back-btn:hover{
            background: #5f9ea0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
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
            Scholarship Program
        </div>

        <div class="scholarship-table" id="tableView">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>SCHOLARSHIP NAME</th>
                    <th>SCHOLARSHIP TYPE</th>
                    <th>STUDENT ELIGIBILITY</th>
                    <th>DEADLINE</th>
                    <th>PUBLISHED DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($scholarshipsss as $index => $scholarship): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($scholarship['name']); ?></td>
                    <td><?php echo htmlspecialchars($scholarship['type']); ?></td>
                    <td><?php echo htmlspecialchars($scholarship['eligibility']); ?></td>
                    <td><?php echo date('m-d-y', strtotime($scholarship['deadline'])); ?></td>
                    <td><?php echo date('m-d-y', strtotime($scholarship['published_date'])); ?></td>
                    <td class="action-buttons">
                        <button class="view-btn" onclick="showDetails(<?php echo $scholarship['id']; ?>)">View</button>
                        <button class="edit-btn" onclick="editScholarship(<?php echo $scholarship['id']; ?>)">Edit</button>
                        <button class="delete-btn" onclick="deleteScholarship(<?php echo $scholarship['id']; ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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
            <button class="back-btn" onclick="hideDetails()">Back</button>
        </div>
    </div>

        <button class="add-scholarship-btn" onclick="window.location.href='add_scholarship.php'">
    <i class="fas fa-plus"></i>
    Add Scholarship
</button>
    </div>

    <script>
        function showDetails(id) {
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

        function editScholarship(id) {
            window.location.href = `edit_scholarship.php?id=${id}`;
        }

        function deleteScholarship(id) {
            if (confirm('Are you sure you want to delete this scholarship?')) {
                fetch(`delete_scholarship.php?id=${id}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Scholarship deleted successfully');
                        location.reload();
                    } else {
                        alert('Error deleting scholarship');
                    }
                });
            }
        }
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