<?php
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header("Location: ../views/login.php?error=Username and Password required");
        exit;
    }

    require_once "../models/User.php";
    $user = loginUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        setcookie("user_role", $user['role'], time() + 1800, "/");

        if ($user['role'] === 'admin') {
            header("Location: ../views/dashboard.php");
        } else {
            header("Location: ../views/customer_dashboard.php");
        }
        exit;
    } else {
        header("Location: ../views/login.php?error=Invalid username or password");
        exit;
    }
}
?>
