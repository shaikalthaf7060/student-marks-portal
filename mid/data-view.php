<?php
require_once "../auth.php";
require_once "db_config.php";

$filterRoll = trim($_GET['rollNumber'] ?? '');
$filterDept = trim($_GET['department'] ?? '');
$filterSem  = trim($_GET['semester'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mid-Marks View - Online Examination Cell</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="shortcut icon" href="../images/favicon.png" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .container {
            max-width: 1000px;
            margin: 90px auto 40px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #cbd5e1;
        }

        th {
            background-color: #f8fafc;
            color: #1e293b;
            font-weight: 600;
        }

        th, td {
            padding: 10px 14px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        form.filter-bar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
            background: #f8fafc;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        form.filter-bar label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #334155;
        }

        form.filter-bar select, form.filter-bar input[type="text"] {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        .submit-btn {
            background-color: #2563eb;
            color: #fff;
            border: none;
            padding: 8px 18px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
        }

        .submit-btn:hover {
            background-color: #1d4ed8;
        }

        .print-btn {
            background-color: #059669;
            color: #fff;
            border: none;
            padding: 8px 18px;
            cursor: pointer;
            border-radius: 6px;
            font-weight: 600;
        }

        .print-btn:hover {
            background-color: #047857;
        }

        .reset-btn {
            background-color: #64748b;
            color: #fff;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
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
            nav, .filter-bar, .print-btn, .reset-btn {
                display: none !important;
            }
            .container {
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
                        <li><a href="../student-info/student-profile.php">Add Student</a></li>
                        <li><a href="../student-info/s.php">View Students</a></li>
                        <li><a href="../student-info/staffedit.php">Manage Students</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks Entry</a>
                    <ul>
                        <li><a href="mid-marks.php">Mid-Marks Entry</a></li>
                        <li><a href="../internal/internal.php">Internal-Marks Entry</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks View</a>
                    <ul>
                        <li><a href="data-view.php">Mid-Marks View</a></li>
                        <li><a href="../internal/internal-view.php">Internal-Marks View</a></li>
                    </ul>
                </li>
                <li><a href="../logout.php" class="active" style="width: auto; border-radius: 5px; cursor: pointer;">Logout</a></li>
            </ul>
        </nav>

        <div class="container" id="printableArea">
            <h2>Mid-Marks Records</h2>
            
            <form method="GET" class="filter-bar">
                <div>
                    <label for="rollNumber">Roll / PIN:</label>
                    <input type="text" name="rollNumber" id="rollNumber" placeholder="Search Roll..." value="<?php echo htmlspecialchars($filterRoll); ?>"/>
                </div>

                <div>
                    <label for="department">Dept:</label>
                    <select name="department" id="department">
                        <option value="">All Departments</option>
                        <?php
                        $depts = ["CSE", "ECE", "EEE", "CIVIL", "MECH"];
                        foreach ($depts as $d) {
                            $sel = ($filterDept === $d) ? 'selected' : '';
                            echo "<option value='$d' $sel>$d</option>";
                        }
                        ?>
                    </select>
                </div>

                <div>
                    <label for="semester">Semester:</label>
                    <select name="semester" id="semester">
                        <option value="">All Semesters</option>
                        <?php
                        $sems = ["first year", "Semester 3", "Semester 4", "Semester 5"];
                        foreach ($sems as $s) {
                            $sel = ($filterSem === $s) ? 'selected' : '';
                            echo "<option value='$s' $sel>$s</option>";
                        }
                        ?>
                    </select>
                </div>

                <input type="submit" class="submit-btn" value="Filter">
                <?php if (!empty($filterRoll) || !empty($filterDept) || !empty($filterSem)): ?>
                    <a href="data-view.php" class="reset-btn">Reset</a>
                <?php endif; ?>
                <button type="button" class="print-btn" onclick="window.print()">Print Report</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Roll / PIN</th>
                        <th>Department</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Mid 1</th>
                        <th>Mid 2</th>
                        <th>Total / Average</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $where = ["1 = 1"];
                $params = [];
                $types = "";

                if (!empty($filterRoll)) {
                    $where[] = "rollNumber = ?";
                    $params[] = $filterRoll;
                    $types .= "s";
                }
                if (!empty($filterDept)) {
                    $where[] = "department = ?";
                    $params[] = $filterDept;
                    $types .= "s";
                }
                if (!empty($filterSem)) {
                    $where[] = "semester = ?";
                    $params[] = $filterSem;
                    $types .= "s";
                }

                $query = "SELECT id, rollNumber, department, semester, subject, mid1, mid2, total FROM marks WHERE " . implode(" AND ", $where) . " ORDER BY id DESC";
                $stmt = $conn->prepare($query);

                if ($stmt) {
                    if (!empty($params)) {
                        $stmt->bind_param($types, ...$params);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td><strong>" . htmlspecialchars($row['rollNumber']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['mid1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['mid2']) . "</td>";
                            echo "<td><strong>" . htmlspecialchars($row['total']) . "</strong></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align: center; color: #64748b; padding: 20px;'>No marks records found.</td></tr>";
                    }
                    $stmt->close();
                } else {
                    echo "<tr><td colspan='8' style='color: red;'>Database query error: " . htmlspecialchars($conn->error) . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>