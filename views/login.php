<?php
session_start(); 

if (!isset($_SESSION['role']) && isset($_COOKIE['user_role'])) {
    $_SESSION['role'] = $_COOKIE['user_role'];
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: customer_dashboard.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="login-page">
    <div class="centered-container" style="flex-direction: column;">
        <form id="loginForm" class="login-form" method="POST" action="../controllers/Auth.php">
            <h2>Login</h2>

            <?php if (isset($_GET['error'])): ?>
                <p id="errorMsg" class="error" style="color: red;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </p>
            <?php endif; ?>

            <label>Username</label>
            <input type="text" id="username" name="username" required>

            <label>Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>

            <div style="text-align: center; margin-top: 10px;">
                <a href="signup.php" style="text-decoration: none; color: #555;">
                    Don't have an account? Sign Up
                </a>
            </div>
        </form>
    </div>
</body>
</html>
