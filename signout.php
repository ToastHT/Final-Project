<!-- Aldrich Mira -->
<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php"); // Change 'login.php' to your login page
    exit();
}
?>
