<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/faq.php?error=Unauthorized");
    exit;
}

require_once "../models/Faq.php";

if (isset($_GET['delete'])) {
    if (faqDelete($_GET['delete'])) {
        header("Location: ../views/faq.php?success=Deleted");
    } else {
        header("Location: ../views/faq.php?error=DeleteFailed");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if (empty($question) || empty($answer)) {
         header("Location: ../views/faq.php?error=EmptyFields");
         exit;
    }

    if (faqInsert($question, $answer)) {
        header("Location: ../views/faq.php?success=Added");
    } else {
        header("Location: ../views/faq.php?error=InsertFailed");
    }
    exit;
}
?>
