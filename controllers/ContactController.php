<?php
// controllers/ContactController.php
require_once 'models/Message.php';

class ContactController {
    private $db;
    private $message;

    public function __construct() {
        $this->message = new Message();
    }

    public function index() {
        // Enforce Role Separation
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            // Admin View: List Messages
            $stmt = $this->message->getAll();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            include 'views/layout/header.php';
            echo '<div class="container">';
            include 'views/layout/sidebar.php';
            echo '<div class="main-content">';
            include 'views/admin/messages.php';
            echo '</div></div>';
            include 'views/layout/footer.php';
        } else {
            // Customer View: Show Form
            // (Assuming guests can also contact, or check for user_id if strict login needed)
            include 'views/customer/contact.php';
        }
    }

    public function send() {
        // Strict: Admins cannot send messages via this form
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
             header("Location: " . BASE_URL . "index.php?controller=contact&action=index&error=admin_cannot_send");
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $msg = $_POST['message'];
            
            if($this->message->create($name, $email, $msg)) {
                $status = "success";
            } else {
                $status = "error";
            }
            // Redirect back to customer contact page
             header("Location: " . BASE_URL . "index.php?controller=contact&action=index&status=" . $status);
             exit;
        }
    }
}
?>
