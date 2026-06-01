<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: manage.php');
    exit();
}

require_once 'settings.php';
$dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = mysqli_prepare($dbconn, "SELECT username, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $userRow = mysqli_fetch_assoc($result);

        if ($userRow && $password === $userRow['password']) {
            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
            $_SESSION['username']  = $userRow['username'];
            header('Location: manage.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

mysqli_close($dbconn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuffDev Medical - Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .login-box {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            border: 1px solid #b2d8d8;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            font-size: 1.5rem;
            color: #264653;
            margin-bottom: 0.3rem;
        }
        .login-box p {
            color: #6c757d;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #264653;
            margin-bottom: 0.4rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            box-sizing: border-box;
            outline: none;
        }
        .form-group input:focus {
            border-color: #2A9D8F;
        }
        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background: #2A9D8F;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-btn:hover {
            background: #1f7a6e;
        }
        .error-msg {
            background: #fde8e8;
            color: #c0392b;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 1.2rem;
        }
        .logo-area {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-area img {
            height: 50px;
        }
        .logo-area p {
            font-weight: 600;
            color: #2A9D8F;
            margin: 0.3rem 0 0;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="logo-area">
        <img src="images/cat.png" alt="TuffDev Medical Logo">
        <p>TuffDev Medical</p>
    </div>
    <h1>HR Manager Login</h1>
    <p>Enter your credentials to access the management panel.</p>

    <?php if ($error): ?>
        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
    </form>
</div>

</body>
</html>