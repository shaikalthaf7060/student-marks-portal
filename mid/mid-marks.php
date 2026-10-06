<?php
require_once "../auth.php";
require_once "db_config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mid-Marks Entry - Online Examination Cell</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            max-width: 900px;
            margin: 90px auto 40px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 200px;
            font-weight: 600;
            color: #334155;
        }

        select, input[type="text"] {
            flex: 1;
            padding: 10px 14px;
            margin: 0;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .submit-btn {
            background-color: #2563eb;
            color: white;
            padding: 10px 22px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .submit-btn:hover {
            background-color: #1d4ed8;
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

        <div class="container">
            <h2>Mid-Marks Entry</h2>
            <form action="submit.php" method="POST" id="midMarksForm">
                <div class="form-group">
                    <label for="rollNumber">Student Roll / PIN:</label>
                    <input type="text" id="rollNumber" name="rollNumber" placeholder="e.g. 21A91A0501" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <?php
                        $departments = array("CSE", "ECE", "EEE", "CIVIL", "MECH");
                        foreach ($departments as $dept) {
                            echo "<option value=\"$dept\">$dept</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester:</label>
                    <select id="semester" name="semester" required>
                        <option value="">Select Semester</option>
                    </select>
                </div>

                <div style="text-align: right; margin-top: 15px;">
                    <button type="button" class="submit-btn" id="load-subjects-btn">Load Subjects</button>
                </div>

                <div id="marksForm" class="subject-form" style="display: none;">
                    <div id="subject-fields" class="subject">
                        <!-- Dynamically populated subjects table -->
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="mid.js"></script>
</body>
</html>
