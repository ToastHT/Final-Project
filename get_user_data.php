<!-- Aldrich Mira -->
<?php
session_start();
$conn = mysqli_connect("localhost", "u627256117_scholars", "!Ic//P]wA6", "u627256117_scholars");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_SESSION['user_id']; // Assuming you have user's ID in session
$sql = "SELECT * FROM usersss WHERE id = $userId";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>