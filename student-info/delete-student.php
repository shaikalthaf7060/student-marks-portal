<?php
require_once "../auth.php";
require_once "db_config.php";

if (isset($_GET['id'])) {
    $pin = trim($_GET['id']);
    if (!empty($pin)) {
        $stmt = $conn->prepare("DELETE FROM student_data WHERE pin_number = ?");
        if ($stmt) {
            $stmt->bind_param("s", $pin);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Redirect back to referring page or student list
$referrer = $_SERVER['HTTP_REFERER'] ?? 's.php';
header("Location: " . $referrer);
exit;
?>
