<!-- Aldrich Mira -->
<?php
session_start();

$servername = "localhost";
$username = "u627256117_scholars";
$password = "!Ic//P]wA6";
$dbname = "u627256117_scholars";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Validate input
if (!isset($_POST['application_id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

$application_id = intval($_POST['application_id']);
$status = $conn->real_escape_string($_POST['status']);

// Begin transaction for atomicity
$conn->begin_transaction();

try {
    // 1. Update application status
    $update_sql = "UPDATE applications SET status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $application_id);
    $update_stmt->execute();

    // 2. Get user details for the application
    $user_sql = "SELECT user_id, fullName, scholarshipName, email FROM applications WHERE id = ?";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("i", $application_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();

    // 3. Delete ALL previous notifications for this user's scholarship application
    $delete_old_sql = "DELETE FROM notifications WHERE user_id = ? AND application_id = ?";
    $delete_stmt = $conn->prepare($delete_old_sql);
    $delete_stmt->bind_param("ii", $user_data['user_id'], $application_id);
    $delete_stmt->execute();

    // 4. Create new notification for the user
    $notification_message = "Your scholarship application for {$user_data['scholarshipName']} has been {$status}.";
    $icon_type = strtolower($status) == 'approved' ? 'success' : 'reject';

    $notification_sql = "INSERT INTO notifications (user_id, message, icon_type, timestamp, application_id) VALUES (?, ?, ?, NOW(), ?)";
    $notification_stmt = $conn->prepare($notification_sql);
    $notification_stmt->bind_param("issi", $user_data['user_id'], $notification_message, $icon_type, $application_id);
    $notification_stmt->execute();

    // 5. Send email notification (optional, but recommended)
    function sendStatusEmail($email, $fullName, $scholarshipName, $status) {
        $subject = "Scholarship Application Status Update";
        $message = "Dear {$fullName},\n\n";
        $message .= "Your scholarship application for {$scholarshipName} has been {$status}.\n\n";
        $message .= "Best regards,\nBarangay Darasa Scholarship Team";

        $headers = "From: scholarship@barangaydarasa.gov.ph\r\n";
        
        mail($email, $subject, $message, $headers);
    }

    // Send email notification
    sendStatusEmail($user_data['email'], $user_data['fullName'], $user_data['scholarshipName'], $status);

    // Commit transaction
    $conn->commit();

    // Send success response
    echo json_encode([
        'success' => true, 
        'message' => "Application {$status} successfully. Notification updated.",
        'status' => $status
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();

    // Send error response
    echo json_encode([
        'success' => false, 
        'message' => 'Error processing application: ' . $e->getMessage()
    ]);
}

// Close statements and connection
$update_stmt->close();
$user_stmt->close();
$delete_stmt->close();
$notification_stmt->close();
$conn->close();
?>