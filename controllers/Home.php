<?php
session_start();

if (!isset($_SESSION['role'])) {
    if (isset($_COOKIE['user_role'])) {
        $_SESSION['role'] = $_COOKIE['user_role'];
    }
}

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] === 'admin') {
    header("Location: dashboard.php");
    exit;
}

header("Location: customer_dashboard.php");
exit;
