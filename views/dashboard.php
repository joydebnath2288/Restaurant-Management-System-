<?php
session_start();
if (!isset($_SESSION['role'])) {
    if (isset($_COOKIE['user_role'])) {
        $_SESSION['role'] = $_COOKIE['user_role'];
    }
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="dashboard-page">

<div class="box">
    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin!</p>

    <div class="dashboard-menu">
        <a href="about.php" class="dashboard-card">Manage About Us & Team</a>
        <a href="announcement.php" class="dashboard-card">Manage Announcements</a>
        <a href="faq.php" class="dashboard-card">Manage FAQs</a>
        <a href="gallery.php" class="dashboard-card">Manage Gallery</a>
        <a href="support_admin.php" class="dashboard-card">Manage Support Messages</a>
        
        <a href="../controllers/logout.php" class="dashboard-card logout-mode">Logout</a>
    </div>
</div>

</body>
</html>
