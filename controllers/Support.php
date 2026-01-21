<?php
session_start();

if (isset($_GET['delete'])) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
         header("Location: ../views/support_admin.php?error=Unauthorized");
         exit;
    }

    require_once "../models/SupportMessage.php";
    if (supportDelete($_GET['delete'])) {
        header("Location: ../views/support_admin.php?success=Deleted");
    } else {
        header("Location: ../views/support_admin.php?error=DeleteFailed");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
         header("Location: ../views/support.php?error=EmptyFields");
         exit;
    }

    require_once "../models/SupportMessage.php";
    if (supportInsert($name, $email, $message)) {
        header("Location: ../views/support.php?success=Sent");
    } else {
        header("Location: ../views/support.php?error=SendFailed");
    }
    exit;
}
?>
