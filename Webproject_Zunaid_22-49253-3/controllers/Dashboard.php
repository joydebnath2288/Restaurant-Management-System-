<?php
namespace Controllers;

class Dashboard {

    public function index() {
        if (!isset($_SESSION['status'])) {
            if (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true') {
                $_SESSION['status'] = 'true';
            } else {
                header("Location: index.php?controller=auth&action=login");
                exit;
            }
        }
        require_once "../views/dashboard/index.php";
    }
}
