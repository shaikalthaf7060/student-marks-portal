<?php
require_once "../auth.php";
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['rollNumber'], $_POST['department'], $_POST['semester'], $_POST['subjects'], $_POST['total'])) {
        $rollNumber = trim($_POST['rollNumber']);
        $department = trim($_POST['department']);
        $semester = trim($_POST['semester']);
        $subjects = $_POST['subjects'];
        $totals = $_POST['total'];

        if (empty($subjects) || !is_array($subjects)) {
            echo "<script>alert('No subjects provided!'); window.history.back();</script>";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO internal (rollNumber, department, semester, subject, total) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssssd", $rollNumber, $department, $semester, $subjectName, $mark);

            $insertedCount = 0;
            for ($i = 0; $i < count($subjects); $i++) {
                $subjectName = trim($subjects[$i]);
                $mark = isset($totals[$i]) ? floatval($totals[$i]) : 0;

                if ($stmt->execute()) {
                    $insertedCount++;
                } else {
                    echo "Error saving internal mark for $subjectName: " . $stmt->error;
                }
            }

            $stmt->close();
            $conn->close();

            echo "<script>alert('Internal marks saved successfully for {$insertedCount} subjects!'); window.location.href='internal.php';</script>";
            exit;
        } else {
            echo "Prepare statement failed: " . $conn->error;
        }
    } else {
        echo "<script>alert('Missing required fields.'); window.history.back();</script>";
    }
} else {
    header("Location: internal.php");
    exit;
}
?>
