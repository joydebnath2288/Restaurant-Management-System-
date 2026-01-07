<?php
namespace Controllers;

class Support {

    public function index() {
        require_once "../views/support/index.php";
    }

    public function submit() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if ($data) {
                $name = trim($data["name"]);
                $email = trim($data["email"]);
                $message = trim($data["message"]);

                if (empty($name) || empty($email) || empty($message)) {
                    echo json_encode(["status" => "error", "message" => "Empty fields"]);
                    exit;
                }

                require_once "../models/SupportMessage.php";
                $model = new \Models\SupportMessage();

                if ($model->insert($name, $email, $message)) {
                    echo json_encode(["status" => "success"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Insert failed"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
            }
        }
    }

    public function admin() {
        if (!isset($_SESSION['status'])) {
            if (isset($_COOKIE['status']) && $_COOKIE['status'] === 'true') {
                $_SESSION['status'] = 'true';
            } else {
                header("Location: index.php?controller=auth&action=login");
                exit;
            }
        }

        require_once "../models/SupportMessage.php";
        $model = new \Models\SupportMessage();
        $messages = $model->getAll();

        require_once "../views/support/admin.php";
    }
}
