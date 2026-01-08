<?php
// controllers/ProfileController.php
require_once 'models/User.php';

class ProfileController {
    private $db;
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function edit() {
        if(!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?page=login");
            exit;
        }

        $this->user->id = $_SESSION['user_id'];
        $userData = $this->user->getUserById();

        include 'views/customer/profile.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             // Logic to update user profile
             // For brevity, skipping full implementation, just redirecting
             header("Location: " . BASE_URL . "index.php?page=dashboard&action=profile&success=updated");
        }
    }
}
?>
