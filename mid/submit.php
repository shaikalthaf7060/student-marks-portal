<?php
require_once "../auth.php";
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['department'], $_POST['semester'], $_POST['rollNumber'], $_POST['subjects'])) {
        $department = trim($_POST['department']);
        $semester = trim($_POST['semester']);
        $rollNumber = trim($_POST['rollNumber']);
        $subjects = $_POST['subjects'];
        $mid1List = isset($_POST['mid1']) ? $_POST['mid1'] : [];
        $mid2List = isset($_POST['mid2']) ? $_POST['mid2'] : [];
        $totalList = isset($_POST['total']) ? $_POST['total'] : [];

        if (empty($subjects) || !is_array($subjects)) {
            echo "<script>alert('No subjects provided!'); window.history.back();</script>";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO marks (rollNumber, department, semester, subject, mid1, mid2, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssssdds", $rollNumber, $department, $semester, $subjectName, $m1, $m2, $tot);

            $insertedCount = 0;
            for ($i = 0; $i < count($subjects); $i++) {
                $subjectName = trim($subjects[$i]);
                $m1 = (isset($mid1List[$i]) && $mid1List[$i] !== '') ? floatval($mid1List[$i]) : 0;
                $m2 = (isset($mid2List[$i]) && $mid2List[$i] !== '') ? floatval($mid2List[$i]) : 0;
                $tot = (isset($totalList[$i]) && $totalList[$i] !== '') ? $totalList[$i] : strval(($m1 + $m2) / 2);

                if ($stmt->execute()) {
                    $insertedCount++;
                } else {
                    echo "Error saving marks for $subjectName: " . $stmt->error;
                }
            }

            $stmt->close();
            $conn->close();

            echo "<script>alert('Successfully saved mid-term marks for {$insertedCount} subjects!'); window.location.href='mid-marks.php';</script>";
            exit;
        } else {
            echo "Prepare statement failed: " . $conn->error;
        }
    } else {
        echo "<script>alert('Missing required fields.'); window.history.back();</script>";
    }
} else {
    header("Location: mid-marks.php");
    exit;
}
?>
