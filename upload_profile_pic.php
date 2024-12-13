<!-- Aldrich Mira -->
<?php
session_start();
$conn = mysqli_connect("localhost", "u627256117_scholars", "!Ic//P]wA6", "u627256117_scholars");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_SESSION['user_id'];
$uploadDir = 'uploads/profile_pictures/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['profilePic'])) {
    $file = $_FILES['profilePic'];
    $fileName = time() . '_' . $file['name'];
    $filePath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $sql = "UPDATE usersss SET profile_picture = '$filePath' WHERE id = $userId";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['success' => true, 'filepath' => $filePath]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to upload file']);
    }
}

mysqli_close($conn);
?>