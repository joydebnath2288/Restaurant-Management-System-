<?php
require_once BASE_PATH . '/models/AuthModel.php';

class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function index() {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=dashboard"); 
            exit;
        }
        require_once BASE_PATH . '/views/login.php';
    }

    public function login() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = isset($data['username']) ? trim($data['username']) : '';
            $password = isset($data['password']) ? trim($data['password']) : '';

            if (empty($username) || empty($password)) {
                http_response_code(400);
                echo json_encode(['error' => 'Username and Password required']);
                return;
            }

            $user = $this->authModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                setcookie("is_logged_in", "true", time() + 86400, "/");

                echo json_encode(['message' => 'Login successful', 'redirect' => 'index.php?controller=dashboard']);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Invalid credentials']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        
        setcookie("is_logged_in", "", time() - 3600, "/");
        
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Logged out', 'redirect' => 'index.php?controller=auth']);
    }
    
    public function check_session() {
         header('Content-Type: application/json');
         if (isset($_SESSION['user_id'])) {
            echo json_encode([
                'authenticated' => true,
                'user' => [
                    'id' => $_SESSION['user_id'],
                    'name' => $_SESSION['user_name'],
                    'role' => $_SESSION['user_role']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['authenticated' => false]);
        }
    }
}
?>
