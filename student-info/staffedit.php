<?php
require_once "../auth.php";
require_once "db_config.php";

$update = false;
$id = '';
$student_name = '';
$date_of_birth = '';
$gender = '';
$mobile_number = '';
$father_name = '';
$address = '';
$department = '';
$batch = '';
$msg = '';
$msgType = '';

// Handle student selection for edit
if (isset($_GET['id'])) {
    $id = trim($_GET['id']);
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM student_data WHERE pin_number = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $student_name = $row['student_name'];
        $date_of_birth = $row['date_of_birth'];
        $gender = $row['gender'];
        $mobile_number = $row['mobile_number'];
        $father_name = $row['father_name'];
        $address = $row['address'];
        $department = $row['department'];
        $batch = $row['batch'];
    }
    $stmt->close();
}

// Handle Update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = trim($_POST['pin_number'] ?? '');
    $student_name = trim($_POST['student_name'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $mobile_number = trim($_POST['mobile_number'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $batch = trim($_POST['batch'] ?? '');

    if (!empty($id)) {
        $stmt = $conn->prepare("UPDATE student_data SET student_name=?, date_of_birth=?, gender=?, mobile_number=?, father_name=?, address=?, department=?, batch=? WHERE pin_number=?");
        $stmt->bind_param("sssssssss", $student_name, $date_of_birth, $gender, $mobile_number, $father_name, $address, $department, $batch, $id);
        if ($stmt->execute()) {
            $msg = "Student record updated successfully!";
            $msgType = "success";
            $update = false;
        } else {
            $msg = "Error updating record: " . $stmt->error;
            $msgType = "danger";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Online Examination Cell</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" />
    <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .manage-box {
            max-width: 1200px;
            margin: 90px auto 40px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            background-color: #1e293b;
            color: #fff;
            text-align: center;
            padding: 14px;
            margin: 0 0 25px 0;
            border-radius: 6px;
            font-size: 1.3rem;
        }

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

        <div class="manage-box">
            <h2>Manage & Edit Student Information</h2>

            <?php if (!empty($msg)): ?>
                <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($msg); ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Form Column -->
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 bg-light p-3">
                        <h5 class="card-title mb-3 text-primary">
                            <?php echo $update ? 'Edit Student: ' . htmlspecialchars($id) : 'Select a student below to edit'; ?>
                        </h5>
                        <form method="POST">
                            <input type="hidden" name="pin_number" value="<?php echo htmlspecialchars($id); ?>">

                            <div class="mb-2">
                                <label class="form-label small fw-bold">Student Name</label>
                                <input placeholder="Enter name" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" type="text" class="form-control form-control-sm" required <?php if(!$update) echo 'disabled'; ?>>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Date of Birth</label>
                                <input name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" type="date" class="form-control form-control-sm" <?php if(!$update) echo 'disabled'; ?>>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Gender</label>
                                <select name="gender" class="form-select form-select-sm" <?php if(!$update) echo 'disabled'; ?>>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if($gender==='Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if($gender==='Female') echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if($gender==='Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Mobile Number</label>
                                <input placeholder="Enter mobile" value="<?php echo htmlspecialchars($mobile_number); ?>" name="mobile_number" type="tel" class="form-control form-control-sm" <?php if(!$update) echo 'disabled'; ?>>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Father's Name</label>
                                <input placeholder="Enter father name" value="<?php echo htmlspecialchars($father_name); ?>" name="father_name" type="text" class="form-control form-control-sm" <?php if(!$update) echo 'disabled'; ?>>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Address</label>
                                <input placeholder="Enter address" value="<?php echo htmlspecialchars($address); ?>" name="address" type="text" class="form-control form-control-sm" <?php if(!$update) echo 'disabled'; ?>>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Department</label>
                                <select name="department" class="form-select form-select-sm" <?php if(!$update) echo 'disabled'; ?>>
                                    <option value="">Select Dept</option>
                                    <?php
                                    foreach (["CSE", "ECE", "EEE", "CIVIL", "MECH"] as $dept) {
                                        $sel = ($department === $dept) ? 'selected' : '';
                                        echo "<option value='$dept' $sel>$dept</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Batch</label>
                                <input placeholder="e.g. 2021-2025" value="<?php echo htmlspecialchars($batch); ?>" name="batch" type="text" class="form-control form-control-sm" <?php if(!$update) echo 'disabled'; ?>>
                            </div>

                            <?php if ($update): ?>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary w-100" type="submit" name="update">Save Changes</button>
                                    <a href="staffedit.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            <?php else: ?>
                                <p class="text-muted small mb-0">Click the "Edit" button next to any student in the table to modify their details.</p>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <!-- Table Column -->
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>PIN Number</th>
                                    <th>Student Name</th>
                                    <th>Dept</th>
                                    <th class="text-center" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM student_data ORDER BY id DESC";
                                $result_tasks = mysqli_query($conn, $query);
                                $cnt = 1;
                                if ($result_tasks && mysqli_num_rows($result_tasks) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_tasks)) {
                                        $isEditing = ($id === $row['pin_number']);
                                        echo "<tr class='" . ($isEditing ? 'table-warning' : '') . "'>";
                                        echo "<td>" . $cnt++ . "</td>";
                                        echo "<td><strong>" . htmlspecialchars($row['pin_number']) . "</strong></td>";
                                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                        echo "<td><span class='badge bg-secondary'>" . htmlspecialchars($row['department']) . "</span></td>";
                                        echo "<td class='text-center'>";
                                        echo "<a href='staffedit.php?id=" . urlencode($row['pin_number']) . "' class='btn btn-sm btn-primary me-1'>Edit</a>";
                                        echo "<a href='delete-student.php?id=" . urlencode($row['pin_number']) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this student record?\");'>Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No students registered yet.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>