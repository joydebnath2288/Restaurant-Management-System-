<?php
// controllers/GalleryController.php
require_once 'models/Gallery.php';

class GalleryController {
    private $db;
    private $gallery;

    public function __construct() {
        $this->gallery = new Gallery();
    }

    public function index() {
        $stmt = $this->gallery->getAll();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            include 'views/layout/header.php';
            echo '<div class="container">';
            include 'views/layout/sidebar.php';
            echo '<div class="main-content">';
            include 'views/admin/gallery.php';
            echo '</div></div>';
            include 'views/layout/footer.php';
        } else {
            include 'views/customer/gallery.php';
        }
    }

    public function add() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
             header("Location: ". BASE_URL);
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $description = $_POST['description'];
            
            $file = $_FILES['image'];
            $fileName = time() . '_' . basename($file['name']);
            $targetDir = "public/uploads/gallery/";
            $targetPath = $targetDir . $fileName;

            // Simple validation
            $check = getimagesize($file["tmp_name"]);
            if($check !== false) {
                 if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                     // Save to DB
                     if($this->gallery->addImage($fileName, $description)) {
                         header("Location: " . BASE_URL . "index.php?controller=gallery&action=index&success=uploaded");
                         exit;
                     }
                 }
            }
            header("Location: " . BASE_URL . "index.php?controller=gallery&action=index&error=upload_failed");
            exit;
        }
    }
}
?>
