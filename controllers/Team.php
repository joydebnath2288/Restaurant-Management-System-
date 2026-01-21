<?php
session_start();
require_once "../models/Team.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/about.php?error=Unauthorized");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (teamDelete($id)) {
         header("Location: ../views/about.php?success=Deleted");
    } else {
         header("Location: ../views/about.php?error=DeleteFailed");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($name) || empty($role) || empty($email) || empty($phone)) {
        header("Location: ../views/about.php?error=EmptyFields");
        exit;
    }

    $imageName = $_POST['current_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowed)) {
             header("Location: ../views/about.php?error=InvalidFileType");
             exit;
        }

        if ($fileSize > 5000000) {
             header("Location: ../views/about.php?error=FileTooLarge");
             exit;
        }

        $newName = time() . "_" . basename($fileName);
        $target = "../public/images/" . $newName;

        if (move_uploaded_file($fileTmp, $target)) {
            $imageName = $newName;
        } else {
            header("Location: ../views/about.php?error=UploadFailed");
            exit;
        }
    }

    if ($id) {
        if (teamUpdate($id, $name, $role, $email, $phone, $imageName)) {
            header("Location: ../views/about.php?success=Updated");
        } else {
            header("Location: ../views/about.php?error=UpdateFailed");
        }
    } else {
        if (empty($imageName)) {
             header("Location: ../views/about.php?error=ImageRequired");
             exit;
        }
        if (teamInsert($name, $role, $email, $phone, $imageName)) {
             header("Location: ../views/about.php?success=Added");
        } else {
             header("Location: ../views/about.php?error=InsertFailed");
        }
    }
    exit;
}
?>
