<?php
// controllers/DashboardController.php

class DashboardController {
    
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit;
        }
    }

    public function index() {
        $role = $_SESSION['user_role'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'home';

        // Load Header
        include 'views/layout/header.php';

        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';

        // Route internal dashboard actions
        if($role == 'admin') {
            switch($action) {
                case 'menu':
                    include 'views/admin/menu_list.php'; // We will create this
                    break;
                case 'orders':
                     include 'views/admin/order_list.php'; // We will create this
                     break;
                // Add cases for employees, etc.
                case 'home':
                default:
                    include 'views/admin/dashboard.php';
                    break;
            }
        } elseif ($role == 'staff') {
             switch($action) {
                case 'orders':
                    // include 'views/staff/order_list.php'; 
                    echo "<h3>Staff Order View (Coming Soon)</h3>";
                    break;
                default:
                    include 'views/staff/dashboard.php';
                    break;
             }
        } else {
            // Customer
            switch($action) {
                case 'profile':
                    include 'views/customer/profile.php'; // We will create this
                    break;
                case 'history':
                     // include 'views/customer/history.php';
                     break;
                default:
                    include 'views/customer/dashboard.php';
                    break;
            }
        }

        echo '</div>'; // End main-content
        echo '</div>'; // End container

        // Load Footer
        include 'views/layout/footer.php';
    }
}
?>
