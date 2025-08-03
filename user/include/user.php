<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once '../config.php';

$user = [
    'id' => $_SESSION['user_id'] ?? null,
    'name' => $_SESSION['user_name'] ?? null,
    'email' => $_SESSION['user_email'] ?? null
];

$user_logged_in = (bool) ($_SESSION['user_id'] ?? false);

/**
 * Update user's session data.
 * @param string $key - The key to update (e.g., 'name', 'email')
 * @param string $value - The new value
 */
function updateUserSession($key, $value) {
    if (isset($_SESSION["user_$key"])) {
        $_SESSION["user_$key"] = $value;
        global $user;
        $user[$key] = $value;
    }
}

/**
 * Logout the user by destroying the session.
 */
function logoutUser() {
    session_unset();
    session_destroy();
    header("Location: /user/pages/login.php");
    exit();
}
?>
