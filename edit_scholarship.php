<!-- Aldrich Mira -->
<?php
session_start();
require_once 'db.php';

// Fetch scholarship details if ID is provided
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM scholarshipsss WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $scholarship = $stmt->get_result()->fetch_assoc();
    
    if (!$scholarship) {
        header("Location: admin_scholarship_program.php");
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $eligibility = $_POST['eligibility'];
    $academic_year = $_POST['academic_year'];
    $criteria = $_POST['criteria'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $deadline = $_POST['deadline'];
    
    $stmt = $conn->prepare("UPDATE scholarshipsss SET 
        name = ?, 
        type = ?, 
        eligibility = ?, 
        academic_year = ?, 
        criteria = ?, 
        description = ?, 
        requirements = ?, 
        deadline = ? 
        WHERE id = ?");
    
    $stmt->bind_param("ssssssssi", 
        $name, 
        $type, 
        $eligibility, 
        $academic_year, 
        $criteria, 
        $description, 
        $requirements, 
        $deadline, 
        $id
    );
    
    if ($stmt->execute()) {
        header("Location: admin_scholarship_program.php?success=1");
        exit();
    } else {
        $error = "Error updating scholarship: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scholarship</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
                /* Basic CSS Reset and Styling */
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
/* Add these styles to your existing CSS */

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

.form-container::-webkit-scrollbar-track {
    background: transparent;
}

.form-container::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}
.main-content {
    margin-left: 250px;
    flex-grow: 1;
    background: transparent; /* Remove background */
    position: relative;
}

.hero-section {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px; 
    background: transparent; /* Remove background */
}

.form-container {
    width: 100%;
    max-width: 800px;
    padding: 2.5rem;
    backdrop-filter: blur(8px); /* Optional blur effect */
    background-color: rgba(255, 255, 255, 0.0); /* Semi-transparent background */
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
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

/* Navigation Menu */
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

/* Page Header */
.page-header {
    background-color: rgba(255, 255, 255, 0.0);
    backdrop-filter: blur(8px);
    padding: 15px 30px;
    font-size: 14px;
    color: #dcdcdc;
}
/* Profile Section */
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

/* Responsive Design */
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
        .form-group textarea {
            width: 100%;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #f0f8ff;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-container {
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

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .submit-btn,
        .cancel-btn {
            padding: 12px 24px;
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

        .cancel-btn {
            background-color: transparent;
            color: #fff;
            border: 2px solid #5f9ea0;
        }

        .cancel-btn:hover {
            background-color: #778899;
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(128, 128, 128, 0.4);
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
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
            Dashboard / Overview
        </div>
    <section class="hero-section">
        <div class="form-container animate__animated animate__fadeIn">
            <h2>Edit Scholarship Program</h2>

            <form method="POST" action="edit_scholarship.php">
                <input type="hidden" name="id" value="<?php echo $scholarship['id']; ?>">
                
                <div class="form-group">
                    <label for="name">Name of Scholarship</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($scholarship['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="type">Scholarship Type</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($scholarship['type']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="eligibility">Student Eligibility</label>
                    <input type="text" id="eligibility" name="eligibility" value="<?php echo htmlspecialchars($scholarship['eligibility']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <input type="text" id="academic_year" name="academic_year" value="<?php echo htmlspecialchars($scholarship['academic_year']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="criteria">Eligibility Criteria</label>
                    <textarea id="criteria" name="criteria" required><?php echo htmlspecialchars($scholarship['criteria']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="description">Scholarship Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($scholarship['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="requirements">Document Requirements</label>
                    <textarea id="requirements" name="requirements" required><?php echo htmlspecialchars($scholarship['requirements']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($scholarship['deadline']); ?>" required>
                </div>

                <div class="button-group">
                    <button type="button" class="cancel-btn" onclick="window.location.href='admin_scholarship_program.php'">Cancel</button>
                    <button type="submit" class="submit-btn">Update Scholarship</button>
                </div>
            </form>
        </div>
    </section>
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