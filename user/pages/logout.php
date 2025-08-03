<?php
    session_start();
    session_destroy();
    // echo json_encode(["status" => "success", "message" => "Logged out successfully!"]);
    header('Location: '. ($_SERVER['HTTP_REFERER'] ?? '/user/pages/index.php'));
?>
