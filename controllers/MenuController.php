<?php
// controllers/MenuController.php
require_once 'models/Menu.php';

class MenuController {
    private $db;
    private $menu;

    public function __construct() {
        $this->menu = new Menu();
    }

    // Action: index (Display all menu items)
    public function index() {
        $stmt = $this->menu->getAll();
        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Load the view and pass data
        include 'views/customer/menu.php';
    }

    // Action: manage (Admin View)
    public function manage() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: " . BASE_URL);
            exit;
        }
        $stmt = $this->menu->getAdminAll();
        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Layout inclusions
        include 'views/layout/header.php';
        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';
        
        include 'views/admin/menu_list.php';
        
        echo '</div></div>';
        include 'views/layout/footer.php';
    }

    public function create() {
        // Admin check
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') header("Location: " . BASE_URL);
        include 'views/admin/add_menu.php';
    }

    public function store() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle File Upload
            $image = "default.jpg"; // simplified
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                 // upload logic
            }
            
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category' => $_POST['category'],
                'image' => $image
            ];

            if($this->menu->create($data)) {
                header("Location: " . BASE_URL . "index.php?controller=menu&action=index&success=true");
            }
        }
    }

    // Since we don't have edit view yet, just stub
    public function delete() {
         if(isset($_GET['id'])) {
             $this->menu->delete($_GET['id']);
             header("Location: " . BASE_URL . "index.php?controller=menu&action=index");
         }
    }
}
?>
