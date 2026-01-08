<?php
// controllers/NotificationController.php
require_once 'models/Notification.php';

class NotificationController {
    private $db;
    private $notification;

    public function __construct() {
        $this->notification = new Notification();
    }

    public function index() {
        if(!isset($_SESSION['user_id'])) {
             header("Location: " . BASE_URL . "index.php?page=login");
             exit;
        }

        $stmt = $this->notification->getByUserId($_SESSION['user_id']);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/customer/notifications.php';
    }
}
?>
