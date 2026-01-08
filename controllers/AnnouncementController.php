<?php
// controllers/AnnouncementController.php
require_once 'models/Announcement.php';

class AnnouncementController {
    private $db;
    private $announcement;

    public function __construct() {
        $this->announcement = new Announcement();
    }

    public function index() {
        // Public View
        $stmt = $this->announcement->getAll();
        $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/pages/announcements.php';
    }
}
?>
