<?php
/**
 * Authentication Middleware
 * Checks if the user is authenticated; if not, redirects to login page.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    // Determine path relative to root
    $loginPath = file_exists("login.php") ? "login.php" : "../login.php";
    header("Location: " . $loginPath);
    exit;
}
?>
