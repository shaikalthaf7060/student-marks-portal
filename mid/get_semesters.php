<?php
if (isset($_POST['department'])) {
    $department = $_POST['department'];
    
    // Create an array to store the semesters for each department
    $departmentSemesters = array(
        "CSE" => array("first year", "Semester 3", "Semester 4", "Semester 5"),
        "ECE" => array("first year", "Semester 3", "Semester 4", "Semester 5"),
        "EEE" => array("first year", "Semester 3", "Semester 4", "Semester 5"),
        "CIVIL" => array("first year", "Semester 3", "Semester 4", "Semester 5"),
        "MECH" => array("first year", "Semester 3", "Semester 4", "Semester 5"),
        // Add entries for other departments here
    );

    echo '<option value="">Select Semester</option>';
    
    // Loop through the semesters for the selected department
    foreach ($departmentSemesters[$department] as $semester) {
        echo "<option value=\"$semester\">$semester</option>";
    }
}
?>
