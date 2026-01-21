<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $username = trim($data["username"] ?? '');
        $email = trim($data["email"] ?? '');
        $password = trim($data["password"] ?? '');
        $role = trim($data["role"] ?? 'customer');

        if (empty($username)) {
            echo json_encode(["status" => "error", "field" => "username", "message" => "Username is required"]);
            exit;
        }
        if (empty($email)) {
            echo json_encode(["status" => "error", "field" => "email", "message" => "Email is required"]);
            exit;
        }
        if (empty($password)) {
            echo json_encode(["status" => "error", "field" => "password", "message" => "Password is required"]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(["status" => "error", "field" => "email", "message" => "Enter a valid email address"]);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode(["status" => "error", "field" => "password", "message" => "Password must be at least 6 characters"]);
            exit;
        }

        if ($role !== 'admin' && $role !== 'customer') {
            $role = 'customer';
        }

        require_once "../models/User.php";

        if (signupUser($username, $email, $password, $role)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Username exists or fail"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Data"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>
