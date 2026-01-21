<?php
session_start();
require_once "../models/Gallery.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/gallery.php?error=Unauthorized");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (galleryDelete($id)) {
        header("Location: ../views/gallery.php?success=Deleted");
    } else {
        header("Location: ../views/gallery.php?error=DeleteFailed");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    
    if (empty($title) || empty($description)) {
        header("Location: ../views/gallery.php?error=EmptyFields");
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowed)) {
             header("Location: ../views/gallery.php?error=InvalidFileType");
             exit;
        }

        if ($fileSize > 5000000) {
             header("Location: ../views/gallery.php?error=FileTooLarge");
             exit;
        }

        $newName = time() . "_" . basename($fileName);
        $target = "../public/uploads/gallery/" . $newName;

        if (!file_exists("../public/uploads/gallery/")) {
            mkdir("../public/uploads/gallery/", 0777, true);
        }

        if (move_uploaded_file($fileTmp, $target)) {
            if (galleryInsert($title, $description, $newName)) {
                header("Location: ../views/gallery.php?success=Uploaded");
            } else {
                header("Location: ../views/gallery.php?error=DBError");
            }
        } else {
            header("Location: ../views/gallery.php?error=UploadFailed");
        }
    } else {
        header("Location: ../views/gallery.php?error=NoFile");
    }
    exit;
}
?>
