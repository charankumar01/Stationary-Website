<?php
include_once '../include/user.php';

header('Content-Type: application/json');

if (!$user_logged_in) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid cart ID"]);
    exit;
}

$cart_id = intval($_GET['id']);
$user_id = $user['id'];

$query = "DELETE FROM cart WHERE id = ? AND customer_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $cart_id, $user_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["success" => true, "message" => "Item removed"]);
} else {
    echo json_encode(["success" => false, "message" => "Item not found or does not belong to user"]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
