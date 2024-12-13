<!-- Aldrich Mira -->
<?php
$servername = "localhost";
$username = "u627256117_scholars";
$password = "!Ic//P]wA6";
$dbname = "u627256117_scholars";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>