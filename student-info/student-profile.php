<?php
require_once "../auth.php";
require_once "db_config.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pin_number = trim($_POST["pin_number"] ?? "");
    $student_name = trim($_POST["student_name"] ?? "");
    $date_of_birth = trim($_POST["date_of_birth"] ?? "");
    $gender = trim($_POST["gender"] ?? "");
    $mobile_number = trim($_POST["mobile_number"] ?? "");
    $father_name = trim($_POST["father_name"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $department = trim($_POST["department"] ?? "");
    $batch = trim($_POST["batch"] ?? "");

    if (empty($pin_number) || empty($student_name)) {
        $message = "PIN Number and Student Name are required.";
        $messageType = "danger";
    } else {
        // Check if student with this PIN already exists
        $check_stmt = $conn->prepare("SELECT id FROM student_data WHERE pin_number = ?");
        $check_stmt->bind_param("s", $pin_number);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "Student with PIN $pin_number already exists!";
            $messageType = "danger";
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO student_data (pin_number, student_name, date_of_birth, gender, mobile_number, father_name, address, department, batch) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("sssssssss", $pin_number, $student_name, $date_of_birth, $gender, $mobile_number, $father_name, $address, $department, $batch);
            
            if ($insert_stmt->execute()) {
                $message = "Student profile saved successfully!";
                $messageType = "success";
            } else {
                $message = "Error saving student profile: " . $insert_stmt->error;
                $messageType = "danger";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data Entry - Online Examination Cell</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="register.css">
    <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
        /* Sub-menu styles */
        .menu ul {
            display: none;
            position: absolute;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 180px;
        }

        .menu li:hover ul {
            display: block;
        }

        .menu ul li {
            display: block;
        }

        .menu ul li a {
            padding: 10px 15px;
            color: #111;
            text-decoration: none;
            display: block;
            font-size: 0.85rem;
        }

        .menu ul li a:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }
    </style>
</head>

<body>
    <section class="main">
        <nav>
            <a href="../index.php" class="logo">
                <h1 style="color: #210ad0; font-size: 24px; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">ONLINE EXAMINATION CELL</h1>
            </a>
            <label class="menu-icon" for="menu-btn">
                <span class="nav-icon"></span>
            </label>
            <ul class="menu" style="border-radius: 5px;">
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Student Details</a>
                    <ul>
                        <li><a href="student-profile.php">Add Student</a></li>
                        <li><a href="s.php">View Students</a></li>
                        <li><a href="staffedit.php">Manage Students</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks Entry</a>
                    <ul>
                        <li><a href="../mid/mid-marks.php">Mid-Marks Entry</a></li>
                        <li><a href="../internal/internal.php">Internal-Marks Entry</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks View</a>
                    <ul>
                        <li><a href="../mid/data-view.php">Mid-Marks View</a></li>
                        <li><a href="../internal/internal-view.php">Internal-Marks View</a></li>
                    </ul>
                </li>
                <li><a href="../logout.php" class="active" style="width: auto; border-radius: 5px; cursor: pointer;">Logout</a></li>
            </ul>
        </nav>

        <div class="profile-container">
            <header>New Student Registration</header>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show mt-3" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="student-profile.php" method="POST">
                <span class="title">Personal Information</span>
                <div class="fields">
                    <div class="input-field">
                        <label>PIN / Roll Number *</label>
                        <input type="text" placeholder="e.g. 21A91A0501" required name="pin_number">
                    </div>

                    <div class="input-field">
                        <label>Student Full Name *</label>
                        <input type="text" placeholder="Enter student name" required name="student_name">
                    </div>

                    <div class="input-field">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth">
                    </div>

                    <div class="input-field">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label>Mobile Number</label>
                        <input type="tel" placeholder="Enter 10-digit mobile number" name="mobile_number">
                    </div>

                    <div class="input-field">
                        <label>Father's Name</label>
                        <input type="text" placeholder="Enter father's name" name="father_name">
                    </div>
                </div>

                <span class="title">Academic & Contact Information</span>
                <div class="fields">
                    <div class="input-field">
                        <label>Department *</label>
                        <select required name="department">
                            <option value="">Select Department</option>
                            <option value="CSE">CSE</option>
                            <option value="ECE">ECE</option>
                            <option value="EEE">EEE</option>
                            <option value="CIVIL">CIVIL</option>
                            <option value="MECH">MECH</option>
                        </select>
                    </div>

                    <div class="input-field">
                        <label>Batch / Academic Year</label>
                        <input type="text" placeholder="e.g. 2021-2025" name="batch">
                    </div>

                    <div class="input-field" style="grid-column: 1 / -1;">
                        <label>Residential Address</label>
                        <input type="text" placeholder="Enter full address" name="address">
                    </div>
                </div>

                <div class="submit-btn-row">
                    <button type="submit" class="sumbit-btn" name="save_student">
                        Submit Student Profile
                    </button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>