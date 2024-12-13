<!-- Aldrich Mira -->
<?php
// announcement_handlers.php
include 'db.php';

function getLatestAnnouncement($conn) {
    $stmt = $conn->prepare("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
        return [
            'id' => $announcement['id'],
            'title' => $announcement['title'],
            'content' => $announcement['content'],
            'application_period' => $announcement['application_period'],
            'requirement1' => $announcement['requirement1'],
            'requirement2' => $announcement['requirement2'],
            'success' => true
        ];
    }
    
    return [
        'success' => false,
        'message' => 'No announcement found'
    ];
}

// Handle all announcement-related requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'get':
            // This endpoint is accessible to both users and admins
            echo json_encode(getLatestAnnouncement($conn));
            break;
            
        case 'update':
            // Only admins can update - verify admin session
            session_start();
            if (!isset($_SESSION['loggedin']) || $_SESSION['is_admin'] !== true) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }
            
            // Process update logic here
            $stmt = $conn->prepare("INSERT INTO announcements (title, content, application_period, requirement1, requirement2) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", 
                $_POST['title'],
                $_POST['content'], 
                $_POST['period'],
                $_POST['requirement1'],
                $_POST['requirement2']
            );
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save announcement']);
            }
            break;
            
        case 'delete':
            // Only admins can delete - verify admin session
            session_start();
            if (!isset($_SESSION['loggedin']) || $_SESSION['is_admin'] !== true) {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit;
            }
            
            $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete announcement']);
            }
            break;
    }
}
?>