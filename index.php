<?php
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Examination Cell - Home</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.png" />
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
    <section class="main" style="background-image: url(images/hero-bg.png); min-height: 100vh;">
        <nav>
            <a href="index.php" class="logo">
                <h1 style="color: #210ad0; font-size:24px; font-weight:700; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">ONLINE EXAMINATION CELL</h1>
            </a>
            <label class="menu-icon" for="menu-btn">
                <span class="nav-icon"></span>
            </label>
            <ul class="menu" style="border-radius: 5px;">
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Student Details</a>
                    <ul>
                        <li><a href="student-info/student-profile.php">Add Student</a></li>
                        <li><a href="student-info/s.php">View Students</a></li>
                        <li><a href="student-info/staffedit.php">Manage Students</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks Entry</a>
                    <ul>
                        <li><a href="mid/mid-marks.php">Mid-Marks Entry</a></li>
                        <li><a href="internal/internal.php">Internal-Marks Entry</a></li>
                    </ul>
                </li>
                <li><a href="#">Marks View</a>
                    <ul>
                        <li><a href="mid/data-view.php">Mid-Marks View</a></li>
                        <li><a href="internal/internal-view.php">Internal-Marks View</a></li>
                    </ul>
                </li>
                <li><a href="logout.php" class="active" style="width:auto; border-radius: 5px; cursor: pointer;">Logout (<?php echo htmlspecialchars($_SESSION['user'] ?? 'User'); ?>)</a></li>
            </ul>
        </nav>

        <!--main-content-->
        <div class="home-content">
            <div class="home-text">
                <h2 style="color: white; letter-spacing: 1px;">Welcome to </h2>
                <h1 style="color: aliceblue;">Online Examination Cell</h1>
                <p style="color: lightgray; line-height: 1.6;">
                    A centralized portal for educational institutions to efficiently record, calculate, and manage mid-term and internal examination marks.
                    Easily maintain student profiles, generate dynamic subject lists by department and semester, and inspect examination score summaries in real-time.
                </p>
                <div style="margin-top: 25px; display: flex; gap: 15px;">
                    <a href="student-info/student-profile.php" style="background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">Add Student</a>
                    <a href="mid/mid-marks.php" style="background: #F14D5D; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none;">Enter Marks</a>
                </div>
            </div>
            <div class="home-img" style="width: 500px;">
                <img src="images/hero.png" width="500px" alt="College Examination Cell Illustration" />
                <marquee width="100%" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                    <span style="color: white;">Mid-Term and Internal Evaluation Portal | Keep examination and student records up to date.</span>
                </marquee>
            </div>
        </div>
    </section>
</body>
</html>