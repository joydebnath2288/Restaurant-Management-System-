<?php
namespace Controllers;

class Gallery {

    public function index() {
        require_once "../models/Gallery.php";
        $model = new \Models\Gallery();
        $images = $model->getAll();

        require_once "../views/gallery/index.php";
    }

    public function save() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($_SESSION['status'])) {
                if (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true') {
                    $_SESSION['status'] = 'true';
                } else {
                    header("Location: index.php?controller=auth&action=login");
                    exit;
                }
            }

            if (empty($_POST['title']) || empty($_POST['description'])) {
                echo "error_empty";
                exit;
            }

            if ($_FILES['image']['name'] == "") {
                echo "error_no_file";
                exit;
            }

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($fileExt, $allowedTypes)) {
                echo "error_invalid_type";
                exit;
            }

            if ($_FILES['image']['size'] > 5000000) {
                echo "error_large_file";
                exit;
            }

            $title = $_POST['title'];
            $description = $_POST['description'];

            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $target = "uploads/gallery/" . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                require_once "../models/Gallery.php";
                $model = new \Models\Gallery();
                $model->insert($title, $description, $imageName);

                header("Location: index.php?controller=gallery&action=index");
            } else {
                echo "error_upload_failed";
            }
        }
    }
}
