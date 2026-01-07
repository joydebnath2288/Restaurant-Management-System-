<?php
namespace Controllers;

class Auth {

    public function login() {
        require_once "../views/auth/login.php";
    }

    public function authenticate() {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        if ($username == null || $password == null) {
            echo "missing credentials";
            return;
        }

        if ($username === "zihan" && $password === "zihan123") {
            $_SESSION['status'] = "true";
            setcookie('status', 'true', time() + 3600, '/');
            header("Location: index.php?controller=dashboard&action=index");
        } else {
            header("Location: index.php?controller=auth&action=login&error=invalid_credentials");
        }
    }

    public function logout() {
        session_destroy();
        setcookie('status', 'true', time() - 3600, '/');
        header("Location: index.php?controller=auth&action=login");
    }
}
