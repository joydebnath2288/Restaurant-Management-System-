<?php
class DashboardController {

    public function index() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth");
            exit;
        }

        require_once BASE_PATH . '/views/dashboard.php';
    }
}
?>
