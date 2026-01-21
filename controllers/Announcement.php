<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/announcement.php?error=Unauthorized");
    exit;
}

require_once "../models/Announcement.php";

if (isset($_GET['delete'])) {
    if (announcementDelete($_GET['delete'])) {
        header("Location: ../views/announcement.php?success=Deleted");
    } else {
        header("Location: ../views/announcement.php?error=DeleteFailed");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($title) || empty($type) || empty($message)) {
         header("Location: ../views/announcement.php?error=EmptyFields");
         exit;
    }

    if (announcementInsert($title, $type, $message)) {
        header("Location: ../views/announcement.php?success=Added");
    } else {
        header("Location: ../views/announcement.php?error=InsertFailed");
    }
    exit;
}
?>
