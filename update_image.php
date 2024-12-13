<!-- Aldrich Mira -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle the image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    // Get the file data
    $file = $_FILES['profile_image'];
    $upload_dir = "uploads/";  // Directory to save the images
    $upload_file = $upload_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (getimagesize($file["tmp_name"]) !== false) {
        // Check file size (5MB max)
        if ($file["size"] <= 5000000) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                // Try to upload the file
                if (move_uploaded_file($file["tmp_name"], $upload_file)) {
                    // Successfully uploaded
                    // Update the user's profile image in the XML and database
                    $xml = simplexml_load_file("users.xml") or die("Error: Cannot create object");
                    foreach ($xml->user as $user) {
                        if ((string)$user->id == $user_id) {
                            $user->profile_image = $upload_file; // Update profile image path
                            break;
                        }
                    }

                    // Save updated XML back to file
                    $xml->asXML("users.xml");

                    // Optionally, update the database as well
                    // Connect to the database
                    $servername = "localhost";
$username = "u627256117_scholars";
$password = "!Ic//P]wA6";
$dbname = "u627256117_scholars";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
                    $stmt->bind_param("si", $upload_file, $user_id);
                    $stmt->execute();
                    $stmt->close();
                    $conn->close();

                    // Redirect back to the manage account page
                    header("Location: manage-account.php");
                    exit();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>
