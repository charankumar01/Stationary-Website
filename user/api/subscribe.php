<?php
// Include your database configuration file for connection (config.php)
include('../config.php');

// Set response header to JSON
header('Content-Type: application/json');

// Function to send response
function sendResponse($status, $message) {
    echo json_encode(array('status' => $status, 'message' => $message));
    exit();
}

// Validate and sanitize email
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure email is set and sanitized
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';

    // Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse('error', 'Invalid email address.');
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT id FROM newsletter WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        sendResponse('error', 'This email is already subscribed.');
    }

    // Insert email into the database
    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        sendResponse('success', 'You have successfully subscribed to the newsletter.');
    } else {
        sendResponse('error', 'Failed to subscribe. Please try again later.');
    }

    $stmt->close();
} else {
    sendResponse('error', 'Invalid request method.');
}
?>
