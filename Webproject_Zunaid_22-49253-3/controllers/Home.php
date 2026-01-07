<?php
namespace Controllers;

class Home {

    public function index() {
        if (!isset($_SESSION['status'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        header("Location: index.php?controller=dashboard&action=index");
        exit;
    }
}
