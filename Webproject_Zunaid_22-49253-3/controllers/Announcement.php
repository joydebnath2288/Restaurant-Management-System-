<?php
namespace Controllers;

class Announcement {

    public function index() {
        require_once "../models/Announcement.php";
        $model = new \Models\Announcement();
        $announcements = $model->getAll();

        require_once "../views/announcement/index.php";
    }

    public function add() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (!isset($_SESSION['status'])) {
                if (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true') {
                    $_SESSION['status'] = 'true';
                } else {
                    echo "error"; 
                    exit;
                }
            }

            $title = $_POST['title'];
            $type = $_POST['type'];
            $message = $_POST['message'];

            if (empty($title) || empty($type) || empty($message)) {
                echo "error";
                exit;
            }

            require_once "../models/Announcement.php";
            $model = new \Models\Announcement();

            if ($model->insert($title, $type, $message)) {
                echo "success";
            } else {
                echo "error";
            }
        }
    }
}
