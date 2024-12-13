<!-- Aldrich Mira -->
<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM scholarshipsss WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($scholarship = $result->fetch_assoc()) {
        // Return scholarship details as JSON
        header('Content-Type: application/json');
        echo json_encode($scholarship);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Scholarship not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No scholarship ID provided']);
}