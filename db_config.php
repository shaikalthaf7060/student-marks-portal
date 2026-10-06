<?php
/**
 * Database Configuration
 * Online Examination Cell & Student Management Portal
 */

$dbhost = getenv('DB_HOST') ?: "localhost";
$dbuser = getenv('DB_USER') ?: "root";
$dbpass = getenv('DB_PASS') ?: "";
$db     = getenv('DB_NAME') ?: "mid-marks";

// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set character set to UTF-8
mysqli_set_charset($conn, "utf8mb4");
?>
