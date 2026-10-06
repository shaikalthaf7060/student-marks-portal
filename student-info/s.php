<?php
require_once "../auth.php";
require_once "db_config.php";

$search = trim($_GET['search'] ?? '');
$deptFilter = trim($_GET['department'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records - Online Examination Cell</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .container-box {
            max-width: 1100px;
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

        @media print {
            nav, .filter-bar, .action-col, .btn {
                display: none !important;
            }
            .container-box {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
                padding: 0;
            }
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

        <div class="container-box">
            <h2>Registered Students Directory</h2>

            <form method="GET" class="filter-bar row g-2 mb-4 align-items-center">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Search by PIN or Student Name..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="department">
                        <option value="">All Departments</option>
                        <?php
                        $depts = ["CSE", "ECE", "EEE", "CIVIL", "MECH"];
                        foreach ($depts as $d) {
                            $sel = ($deptFilter === $d) ? 'selected' : '';
                            echo "<option value='$d' $sel>$d</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <?php if (!empty($search) || !empty($deptFilter)): ?>
                        <a href="s.php" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                    <button type="button" class="btn btn-success" onclick="window.print()">Print</button>
                    <a href="student-profile.php" class="btn btn-outline-primary ms-auto">+ Add New</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>PIN Number</th>
                            <th>Student Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Father's Name</th>
                            <th>Department</th>
                            <th>Batch</th>
                            <th class="action-col text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = ["1 = 1"];
                        $params = [];
                        $types = "";

                        if (!empty($search)) {
                            $where[] = "(pin_number LIKE ? OR student_name LIKE ?)";
                            $searchWildcard = "%" . $search . "%";
                            $params[] = $searchWildcard;
                            $params[] = $searchWildcard;
                            $types .= "ss";
                        }
                        if (!empty($deptFilter)) {
                            $where[] = "department = ?";
                            $params[] = $deptFilter;
                            $types .= "s";
                        }

                        $query = "SELECT * FROM student_data WHERE " . implode(" AND ", $where) . " ORDER BY id DESC";
                        $stmt = $conn->prepare($query);

                        if ($stmt) {
                            if (!empty($params)) {
                                $stmt->bind_param($types, ...$params);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>" . htmlspecialchars($row['pin_number']) . "</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['date_of_birth'] ?? '-') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['gender'] ?? '-') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['mobile_number'] ?? '-') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['father_name'] ?? '-') . "</td>";
                                    echo "<td><span class='badge bg-secondary'>" . htmlspecialchars($row['department']) . "</span></td>";
                                    echo "<td>" . htmlspecialchars($row['batch'] ?? '-') . "</td>";
                                    echo "<td class='action-col text-center'>";
                                    echo "<a href='staffedit.php?id=" . urlencode($row['pin_number']) . "' class='btn btn-sm btn-outline-primary me-1'>Edit</a>";
                                    echo "<a href='delete-student.php?id=" . urlencode($row['pin_number']) . "' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this student?\");'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center py-4 text-muted'>No student records found.</td></tr>";
                            }
                            $stmt->close();
                        } else {
                            echo "<tr><td colspan='9' class='text-danger'>Query failed: " . htmlspecialchars($conn->error) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
