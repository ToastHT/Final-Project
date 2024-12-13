<!-- Aldrich Mira -->
<?php
// For admin_dashboard.php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN-DASHBOARD</title>
    <style>
        /* Basic CSS Reset and Styling */
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

/* Sidebar Styling */
.sidebar {
    width: 250px;
    background-color: rgba(255, 255, 255,);
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

/* Content Area */
.content-area {
    padding: 30px;
    color: white;
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

.content-area {
    padding: 30px;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    min-height: calc(100vh - 120px); /* Account for header and page header */
}

/* Enhanced Announcement Section */
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

/* Enhanced Typography */
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
}

.Application-section, 
.requirements-section {
    margin-top: 30px;
    text-align: center;
}

.announcement-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}
.application-period {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
}

.application-period,
.requirements-list {
    margin-top: 15px;
    text-align: left;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}
.requirements-section {
    margin-top: 30px;
}

.requirements-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #91a3b0;
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
    color: #4CAF50;
    font-size: 20px;
    color: white;
}

/* Enhanced Button Styling */
.announcement-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
}
.requirements-list {
    list-style: none;
    padding: 0;
}
        .announcement-actions {
    margin-top: 20px;
}

.announcement-actions button {
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 500;
    font-size: 15px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

.edit-btn {
    background-color: #536878;
    color: white;
}

.edit-btn:hover {
    background-color: #5f9ea0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
}

.delete-btn {
    background-color: #ab4b52;
    color: white;
}

.delete-btn:hover {
    background-color: #af002a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
}

.update-btn {
    background-color: #4682b4;
    color: white;
}

.update-btn:hover {
    background-color: #1976D2;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

/* Enhanced Modal Styling */
.modal {
    background-color: rgba(0, 0, 0, 0.7);
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.9);
    padding-top: 50px;
}

.modal-content {
    background-color: rgba(255, 255, 255, 0.1);;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    color: #a9a9a9;
}
.modal-content input,
.modal-content textarea {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #f0ffff;
    border-radius: 8px;
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
}

.modal-content input:focus,
.modal-content textarea:focus {
    outline: none;
    border-color: rgba(255, 255, 255, 0.4);
    background: rgba(255, 255, 255, 0.15);
}

.modal-content label {
    color: #91a3b0;
    margin-bottom: 8px;
    display: block;
    
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.Application-title{
    font-size: 22px;
}
.save-btn {
        padding: 10px 20px;
        background-color: #536878;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border: none;
        border-radius: 25px;
    }

    .save-btn:hover {
        background-color: #5f9ea0;
    }
    </style>
</head>
<body>
    <!-- Sidebar -->
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

        <!-- Admin Controls -->
        <div class="announcement-actions">
    <button class="edit-btn" onclick="editAnnouncement()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>
        Edit Announcement
    </button>
    <button class="delete-btn" onclick="deleteAnnouncement()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 6h18"></path>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        </svg>
        Delete Announcement
    </button>
    <button class="update-btn" onclick="createNewAnnouncement()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14"></path>
            <path d="M5 12h14"></path>
        </svg>
        Create New Announcement
    </button>
</div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Announcement</h2>
            <form id="announcementForm">
                <div style="margin-bottom: 15px;">
                    <label for="newTitle">Title:</label><br>
                    <input type="text" id="newTitle" style="width: 100%; padding: 8px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="newText">Content:</label><br>
                    <textarea id="newText" style="width: 100%; height: 100px; padding: 8px;"></textarea>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="newPeriod">Application Period:</label><br>
                    <input type="text" id="newPeriod" style="width: 100%; padding: 8px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="newRequirement1">Requirement 1:</label><br>
                    <input type="text" id="newRequirement1" style="width: 100%; padding: 8px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="newRequirement2">Requirement 2:</label><br>
                    <input type="text" id="newRequirement2" style="width: 100%; padding: 8px;">
                </div>
                <button type="button" onclick="saveAnnouncement()" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Delete Announcement</h2>
            <p>Are you sure you want to delete this announcement?</p>
            <button onclick="confirmDelete()" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; margin-right: 10px;">Yes, Delete</button>
            <button onclick="closeDeleteModal()" style="padding: 10px 20px; background-color: #808080; color: white; border: none; cursor: pointer;">Cancel</button>
        </div>
    </div>
</div>


    <script>
        let currentAnnouncementId = null;
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle("active");
        }
        // Function to edit the announcement
function editAnnouncement() {
    // Open the modal to edit the announcement
    document.getElementById('editModal').style.display = 'block';
}

// Function to apply changes after editing
function applyChanges() {
    const newTitle = document.getElementById('newTitle').value;
    const newText = document.getElementById('newText').value;
    const newPeriod = document.getElementById('newPeriod').value;
    const newRequirement1 = document.getElementById('newRequirement1').value;
    const newRequirement2 = document.getElementById('newRequirement2').value;

    // Update the content of the announcement with the new values
    document.getElementById('announcementTitle').innerText = newTitle;
    document.getElementById('announcementText').innerText = newText;
    document.getElementById('applicationPeriod').innerText = 'Application Period: ' + newPeriod;
    document.getElementById('requirement1').innerText = newRequirement1;
    document.getElementById('requirement2').innerText = newRequirement2;

    // Close the modal
    closeModal();
}

// Function to close the edit modal
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Function to show the delete confirmation modal
function deleteAnnouncement() {
    document.getElementById('deleteModal').style.display = 'block';
}

// Function to close the delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Function to confirm deletion of the announcement
function confirmDelete() {
    // Clear the content (in a real-world case, you'd also delete from the server here)
    document.getElementById('announcementTitle').innerText = '';
    document.getElementById('announcementText').innerText = '';
    document.getElementById('applicationPeriod').innerText = '';
    document.getElementById('requirement1').innerText = '';
    document.getElementById('requirement2').innerText = '';

    // Close the delete modal
    closeDeleteModal();
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
            currentAnnouncementId = data.id;
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

function editAnnouncement() {
    document.getElementById('editModal').style.display = 'block';
    document.getElementById('newTitle').value = document.getElementById('announcementTitle').innerText;
    document.getElementById('newText').value = document.getElementById('announcementText').innerText;
    document.getElementById('newPeriod').value = document.getElementById('applicationPeriod').innerText;
    document.getElementById('newRequirement1').value = document.getElementById('requirement1').innerText;
    document.getElementById('newRequirement2').value = document.getElementById('requirement2').innerText;
}

function createNewAnnouncement() {
    currentAnnouncementId = null;
    document.getElementById('editModal').style.display = 'block';
    document.getElementById('newTitle').value = '';
    document.getElementById('newText').value = '';
    document.getElementById('newPeriod').value = '';
    document.getElementById('newRequirement1').value = '';
    document.getElementById('newRequirement2').value = '';
}

function saveAnnouncement() {
    // Get form data
    const formData = new FormData();
    formData.append('action', 'update');
    if (currentAnnouncementId) {
        formData.append('id', currentAnnouncementId);
    }
    formData.append('title', document.getElementById('newTitle').value);
    formData.append('content', document.getElementById('newText').value);
    formData.append('period', document.getElementById('newPeriod').value);
    formData.append('requirement1', document.getElementById('newRequirement1').value);
    formData.append('requirement2', document.getElementById('newRequirement2').value);

    // Show loading state
    const saveButton = document.querySelector('#announcementForm button');
    saveButton.disabled = true;
    saveButton.textContent = 'Saving...';

    fetch('announcement_handlers.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Announcement saved successfully!');
            loadLatestAnnouncement();
            closeModal();
        } else {
            throw new Error(data.message || 'Failed to save announcement');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        saveButton.disabled = false;
        saveButton.textContent = 'Save Changes';
    });
}

function loadLatestAnnouncement() {
    const formData = new FormData();
    formData.append('action', 'get');

    fetch('announcement_handlers.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            currentAnnouncementId = data.id;
            document.getElementById('announcementTitle').innerText = data.title;
            document.getElementById('announcementText').innerText = data.content;
            document.getElementById('applicationPeriod').innerText = data.application_period;
            document.getElementById('requirement1').innerText = data.requirement1;
            document.getElementById('requirement2').innerText = data.requirement2;
        } else {
            document.getElementById('announcementTitle').innerText = 'No Announcement';
            document.getElementById('announcementText').innerText = 'No announcement available.';
            document.getElementById('applicationPeriod').innerText = '';
            document.getElementById('requirement1').innerText = '';
            document.getElementById('requirement2').innerText = '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading announcement: ' + error.message);
    });
}
function deleteAnnouncement() {
    if (!currentAnnouncementId) {
        alert('No announcement to delete');
        return;
    }
    document.getElementById('deleteModal').style.display = 'block';
}

// Function to close the delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Function to confirm and execute deletion of the announcement
function confirmDelete() {
    if (!currentAnnouncementId) {
        alert('No announcement to delete');
        closeDeleteModal();
        return;
    }

    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', currentAnnouncementId);

    // Show loading state
    const deleteButton = document.querySelector('#deleteModal button');
    deleteButton.disabled = true;
    deleteButton.textContent = 'Deleting...';

    fetch('announcement_handlers.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Announcement deleted successfully!');
            // Clear the current announcement display
            document.getElementById('announcementTitle').innerText = 'No Announcement';
            document.getElementById('announcementText').innerText = 'No announcement available.';
            document.getElementById('applicationPeriod').innerText = '';
            document.getElementById('requirement1').innerText = '';
            document.getElementById('requirement2').innerText = '';
            currentAnnouncementId = null;
            closeDeleteModal();
        } else {
            throw new Error(data.message || 'Failed to delete announcement');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    })
    .finally(() => {
        // Reset button state
        deleteButton.disabled = false;
        deleteButton.textContent = 'Yes, Delete';
    });
}
    </script>
</body>
</html>
