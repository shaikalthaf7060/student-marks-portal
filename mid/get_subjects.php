<?php
if (isset($_POST['semester']) && isset($_POST['department'])) {
    $semester = $_POST['semester'];
    $department = $_POST['department'];
    
    // Create an array to store subjects for each department and semester
    $departmentSubjects = array(
        "CSE" => array(
            "first year" => array("English","Mathematics-1","Physics","Chemistry","Basics of computer engineering","Programming in C"),
            "Semester 3" => array("Mathematics-2","Digital Electronics","Operating System","Data Structures Through C","DBMS"),
            "Semester 4" => array("Mathematics-3", "Web Technologies", "CO", "OOPS through C++","Computer Networks"),
            "Semester 5" => array("IME", "Java Programming", "Software Engineering","Internet Of Things","Python Programming")
        ),
        "ECE" => array(
            "first year" => array("English","Mathematics-1","Physics","Chemistry","Electronic components and Power Supplies","Electronic of Electrical Engineering"),
            "Semester 3" => array("Mathematics-2","Electronic Circuits-1","Digital Electronics","Analog and Digital Communication Systems","Network Analysis","Electronic Measurements & consumer gadgets"),
            "Semester 4" => array("Mathematics-3", "Electronic Circuits-2", "Microprocessors", "Microwave & Satellite Communication System","Programming in c & MATLAB"),
            "Semester 5" => array("IMST", "Microcontrollers and Applications", "Optical & Mobile Communications","Industrial Electronics","Computer Hardware & Networking")
        ),
        "EEE" => array(
            "first year" => array("English","Mathematics-1","Physics","Chemistry","Electrical Engineering Materials","Basic Electrical Engineering"),
            "Semester 3" => array("Mathematics-2","Electrical Machines-1(DC Machines)","Power System-1(Generation)","Electrical & Electronic Measuring Instruments","Electrical circuits","Programming in C"),
            "Semester 4" => array("Mathematics-3", "Electrical Machines-2(Transformers & Alternators)", "Power Systems-2(Transmission & Distribution)", "Electrical Installation and Estimation","Electronics Engineering","General Mechanical Engineering"),
            "Semester 5" => array("IMST", "Electronic Machines-3(A.C MoTORS AND Drives)", "Power Systems-3(Switch Gear & Protection)","Power Electronics,PLC & SCADA","Digital Electronics & Micro Controllers","Electrical Utilization and Traction")
        ),
        "CIVIL" => array(
            "first year" => array("English","Mathematics-1","Physics","Chemistry","Engineering Mechanics","Surveying-1"),
            "Semester 3" => array("Mathematics-2","Mechanics of Solids & Theory of Structures","Hydraulics","Surveying-2","Construction Materials","Construction Pratice"),
            "Semester 4" => array("Mathematics-3", "Design and Detailing of R.C Structures", "Quantity Surveying-1", "Transportation Engineering","Irrigation engineering"),
            "Semester 5" => array("Steel Structures", "Environmental Engineering", "Quantity surveying-2","Construction Failures, Repairs and maintenance","Quality Control and Safety in Construction","Construction Management and entrepreneurship")
        ),
        "MECH" => array(
            "first year" => array("English","Mathematics-1","Physics","Chemistry","Engineering Mechanics","Workshop Technology"),
            "Semester 3" => array("Mathematics-2","Engineering Materials","Basic Electrical & Electronics engineering","Basic Thermodynamics","strength of Materials","Production Technology-1"),
            "Semester 4" => array("Mathematics-3", "Design of Machine Members", "Hydraulics and Fluid Power Systems", "Heat Power Engineering-1","Engineering Sources and Power Plant Engineering","Production Technology-2"),
            "Semester 5" => array("IMST", "Industrial Engineering and Estimation & Costing", "Theory of Machines","Heat Power Engineering-2","Refrigeration and Air Conditioning","Computer Aided Manufacturing SystemS")
        )
    );

    if (isset($departmentSubjects[$department][$semester])) {
        $subjects = $departmentSubjects[$department][$semester];
        
        echo '<div style="margin-top: 25px;">';
        echo '<h3 style="font-size: 1.15rem; margin-bottom: 12px; color: #1e293b;">Subject Marks (' . htmlspecialchars($department) . ' - ' . htmlspecialchars($semester) . ')</h3>';
        echo '<div style="overflow-x: auto;">';
        echo '<table class="marks-table" style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">';
        echo '<thead>';
        echo '<tr style="background: #f1f5f9; text-align: left;">';
        echo '<th style="padding: 10px; border: 1px solid #cbd5e1;">#</th>';
        echo '<th style="padding: 10px; border: 1px solid #cbd5e1;">Subject Name</th>';
        echo '<th style="padding: 10px; border: 1px solid #cbd5e1; width: 140px;">Mid 1</th>';
        echo '<th style="padding: 10px; border: 1px solid #cbd5e1; width: 140px;">Mid 2</th>';
        echo '<th style="padding: 10px; border: 1px solid #cbd5e1; width: 150px;">Average / Total</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $idx = 1;
        foreach ($subjects as $subject) {
            echo '<tr class="subject-row">';
            echo '<td style="padding: 8px; border: 1px solid #cbd5e1; text-align: center;">' . $idx++ . '</td>';
            echo '<td style="padding: 8px; border: 1px solid #cbd5e1;">';
            echo '<input type="text" name="subjects[]" value="' . htmlspecialchars($subject) . '" readonly style="width: 100%; background: #f8fafc; font-weight: 500; border: none; outline: none; margin: 0; padding: 6px;">';
            echo '</td>';
            echo '<td style="padding: 8px; border: 1px solid #cbd5e1;">';
            echo '<input type="number" step="0.01" min="0" max="100" class="mid1-input" name="mid1[]" placeholder="Mid 1" oninput="calculateRowTotal(this)" style="width: 100%; margin: 0; padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px;">';
            echo '</td>';
            echo '<td style="padding: 8px; border: 1px solid #cbd5e1;">';
            echo '<input type="number" step="0.01" min="0" max="100" class="mid2-input" name="mid2[]" placeholder="Mid 2" oninput="calculateRowTotal(this)" style="width: 100%; margin: 0; padding: 6px; border: 1px solid #cbd5e1; border-radius: 4px;">';
            echo '</td>';
            echo '<td style="padding: 8px; border: 1px solid #cbd5e1;">';
            echo '<input type="text" class="total-input" name="total[]" placeholder="Total" readonly style="width: 100%; margin: 0; padding: 6px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px;">';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '<button type="submit" class="submit-btn" style="background: #2563eb; color: #fff; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Save Marks to Database</button>';
        echo '</div>';
    } else {
        echo '<p style="color: #64748b; padding: 15px;">No subjects defined for the selected department and semester.</p>';
    }
}
?>
