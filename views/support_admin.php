<?php
session_start();
require_once "../models/SupportMessage.php";

if (!isset($_SESSION['role'])) {
    if (isset($_COOKIE['user_role'])) {
        $_SESSION['role'] = $_COOKIE['user_role'];
    }
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$messages = supportGetAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Support Messages (Admin)</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-support-admin">

<div class="box">
    <a href="dashboard.php" class="nav-back">← Back to Dashboard</a>
    <h2>Support Messages</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <?php if (!empty($messages)) { ?>
        <?php foreach ($messages as $msg) { ?>
            <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($msg['name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                <p><strong>Message:</strong> <?php echo htmlspecialchars($msg['message']); ?></p>
                <p><small>Time: <?php echo $msg['created_at']; ?></small></p>
                 <div style='margin-top:10px;'>
                     <a href="../controllers/Support.php?delete=<?php echo $msg['id']; ?>" class="delete-btn" style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px;">Delete</a>
                 </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No messages found.</p>
    <?php } ?>
</div>

</body>
</html>
