<?php
// controllers/AuthController.php
require_once 'models/User.php';

class AuthController extends Controller {
    private $user;

    public function __construct() {
        $this->user = $this->model('User');
    }

    public function showLoginForm() {
        $this->view('auth/login');
    }

    public function showSignupForm() {
        $this->view('auth/signup');
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // **Basic Web Security**: CSRF Check
            if(!Csrf::verify($_POST['csrf_token'])) {
                die("CSRF Validation Failed. Refresh the page.");
            }

            // **PHP Validation**: Sanitize & Validate Inputs
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            
            // Optional fields
            $phone = isset($_POST['phone']) ? htmlspecialchars(strip_tags($_POST['phone'])) : '';
            $address = isset($_POST['address']) ? htmlspecialchars(strip_tags($_POST['address'])) : '';

            if(!$email) {
                $error = "Invalid Email Format";
                include 'views/auth/signup.php';
                return;
            }

            // Set user properties
            $this->user->name = $name;
            $this->user->email = $email;

            // Check if email already exists
            if($this->user->emailExists()) {
                $error = "Email already exists!";
                include 'views/auth/signup.php';
                return;
            } 

            $this->user->password = password_hash($password, PASSWORD_DEFAULT);
            $this->user->role = 'customer'; 
            $this->user->phone = $phone;
            $this->user->address = $address;

            if ($this->user->create()) {
                 header("Location: " . BASE_URL . "index.php?controller=auth&action=login&success=registered");
            } else {
                 $error = "Email already exists!";
                 include 'views/auth/signup.php';
            }
        } else {
            include 'views/auth/signup.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // **Basic Web Security**: CSRF Check
             if(!Csrf::verify($_POST['csrf_token'])) {
                die("CSRF Validation Failed");
            }

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            
            // Set email to check existence
            $this->user->email = $email;

            // Use the emailExists method which populates properties
            if($this->user->emailExists() && password_verify($password, $this->user->password)) {
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['user_name'] = $this->user->name;
                $_SESSION['role'] = $this->user->role; // IMPORTANT: Changed from user_role to role to match sidebar

                // Redirect based on role
                if($this->user->role == 'admin') {
                    header("Location: " . BASE_URL . "index.php?controller=dashboard&action=index");
                } elseif ($this->user->role == 'staff') {
                     header("Location: " . BASE_URL . "index.php?controller=dashboard&action=index");
                } else {
                     header("Location: " . BASE_URL . "index.php?controller=dashboard&action=index");
                }
            } else {
                $error = "Invalid email or password.";
                 include 'views/auth/login.php';
            }
        } else {
            // Ensure GET request shows form
             include 'views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
    }
}
?>
