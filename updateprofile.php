<!-- Aldrich Mira -->
<?php
$conn = mysqli_connect("localhost", "u627256117_scholars", "!Ic//P]wA6", "u627256117_scholars");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$program = $_POST['program'];

// If password is changed
$passwordUpdate = "";
if (!empty($_POST['password'])) {
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $passwordUpdate = ", password = '$hashedPassword'";
}

// Update user profile
$userId = $_SESSION['user_id']; // Assuming you have user's ID in session
$sql = "UPDATE usersss SET 
        full_name = '$fullName',
        email = '$email',
        phone = '$phone',
        date_of_birth = '$dob',
        address = '$address',
        program = '$program'
        $passwordUpdate
        WHERE id = $userId";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>