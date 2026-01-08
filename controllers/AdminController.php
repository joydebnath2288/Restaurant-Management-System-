<?php

class AdminController extends Controller {
    
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
             header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
             exit;
        }
    }

    public function overview() {
        // Load Header
        include 'views/layout/header.php';

        echo '<div class="container">';
        
        // Load Sidebar
        include 'views/layout/sidebar.php';
        
        // Load Content
        echo '<div class="main-content">';
        $this->view('admin/overview');
        echo '</div>'; // End main-content
        
        echo '</div>'; // End container

        // Load Footer
        include 'views/layout/footer.php';
    }
}
?>
