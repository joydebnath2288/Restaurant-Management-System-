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
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="dashboard-page">

    <div class="centered-container" style="flex-direction: column;">
        <div class="box">
            <h2>Welcome Customer</h2>
            <div class="dashboard-menu">
                <a href="about.php" class="dashboard-card">About Us</a>
                <a href="announcement.php" class="dashboard-card">Announcements</a>
                <a href="faq.php" class="dashboard-card">FAQ</a>
                <a href="gallery.php" class="dashboard-card">Gallery</a>
                <a href="support.php" class="dashboard-card">Contact Support</a>
            </div>
            
            <br>
            <a href="../controllers/logout.php" class="dashboard-card logout-mode">Logout</a>
        </div>
    </div>
</body>
</html>
