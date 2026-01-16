<?php
class DashboardController {
    
    public function index() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /WT_RMS/login");
            exit;
        }

        $role = $_SESSION['role'];

        switch ($role) {
            case 'admin':
                require 'views/dashboard/admin.php';
                break;
            case 'staff':
                require 'views/dashboard/staff.php';
                break;
            case 'customer':
                require 'views/dashboard/customer.php';
                break;
            default:
                echo "Unknown role.";
                break;
        }
    }
}
?>
