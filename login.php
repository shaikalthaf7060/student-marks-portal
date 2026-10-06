<?php
session_start();

// If already logged in, redirect to index
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        $error = "Please enter both username/email and password.";
    } else {
        $authenticated = false;
        $username = "";

        // Check against database users table if available
        if (file_exists("db_config.php")) {
            include "db_config.php";
            if (isset($conn) && !$conn->connect_error) {
                $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
                if ($stmt) {
                    $stmt->bind_param("ss", $email, $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        if (password_verify($password, $row['password']) || $password === $row['password']) {
                            $authenticated = true;
                            $username = $row['username'];
                        }
                    }
                    $stmt->close();
                }
            }
        }

        // Support default demo accounts (admin/admin123 or bunny/bunny123)
        if (!$authenticated) {
            if (($email === 'bunny' && $password === 'bunny123') ||
                ($email === 'admin' && $password === 'admin123')) {
                $authenticated = true;
                $username = $email;
            }
        }

        if ($authenticated) {
            $_SESSION["user"] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username/email or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Examination Cell</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            background-image: url('images/background.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;  
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            position: relative;
            transform: none;
            top: auto;
            left: auto;
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            border-radius: 12px;
            color: #fff;
        }
        .login-box h3 {
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
            letter-spacing: 0.5px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 12px 14px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.18);
            border-color: #3b82f6;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        .form-control::placeholder {
            color: #cbd5e1;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: transform 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }
        .demo-credentials {
            font-size: 0.82rem;
            color: #94a3b8;
            margin-top: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h3>Online Examination Cell</h3>
        <h5 class="text-center text-muted mb-4" style="color: #94a3b8 !important;">Sign In</h5>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label small text-uppercase">Username or Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter username or email" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label small text-uppercase">Password</label>
                <input type="password" placeholder="Enter password" name="password" class="form-control" id="myinput" required>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="showPass" onclick="togglePassword()">
                    <label class="form-check-label small" for="showPass">Show Password</label>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary mt-2">Login</button>
        </form>

        <div class="demo-credentials text-center">
            Demo Logins: <strong>admin</strong> / <strong>admin123</strong> or <strong>bunny</strong> / <strong>bunny123</strong>
        </div>
    </div>

    <script>
        function togglePassword() {
            var x = document.getElementById("myinput");
            x.type = (x.type === "password") ? "text" : "password";
        }
    </script>
</body>
</html>