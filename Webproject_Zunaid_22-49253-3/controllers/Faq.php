<?php
namespace Controllers;

class Faq {

    public function index() {
        require_once "../models/Faq.php";
        $model = new \Models\Faq();
        $faqs = $model->getAll();

        require_once "../views/faq/index.php";
    }

    public function save() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (!isset($_SESSION['status'])) {
                if (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true') {
                    $_SESSION['status'] = 'true';
                } else {
                    header("Location: index.php?controller=auth&action=login");
                    exit;
                }
            }

            $question = $_POST['question'];
            $answer = $_POST['answer'];

            if (!empty($question) && !empty($answer)) {
                require_once "../models/Faq.php";
                $model = new \Models\Faq();
                $model->insert($question, $answer);
            }

            header("Location: index.php?controller=faq&action=index");
        }
    }
}
