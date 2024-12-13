<!-- Aldrich Mira -->
<?php
?>
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']);
    $criteria = mysqli_real_escape_string($conn, $_POST['criteria']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $requirements = mysqli_real_escape_string($conn, $_POST['requirements']);
    $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
    $published_date = date('Y-m-d');

    $query = "INSERT INTO scholarshipsss (name, type, eligibility, academic_year, criteria, description, requirements, deadline, published_date) 
              VALUES ('$name', '$type', '$eligibility', '$academic_year', '$criteria', '$description', '$requirements', '$deadline', '$published_date')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Scholarship added successfully!";
        header("Location: admin_scholarship_program.php");
    } else {
        $_SESSION['error'] = "Error adding scholarship: " . mysqli_error($conn);
        header("Location: admin_scholarship_program.php");
    }
}
?>