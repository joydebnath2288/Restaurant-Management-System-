<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/about.php?error=Unauthorized");
    exit;
}

$file = "../config/about_data.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? '');
    $desc = trim($_POST["desc"] ?? '');

    if (empty($name) || empty($desc)) {
        header("Location: ../views/about.php?error=EmptyFields");
        exit;
    }

    $storeData = ["name" => $name, "desc" => $desc];
    file_put_contents($file, json_encode($storeData));
    
    header("Location: ../views/about.php?success=Updated");
    exit;
}
?>
