<?php
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/PasswordReset.php';

class AuthController {
    
    public function showSignupForm() {
        require 'views/auth/signup.php';
    }

    public function signup() {
        global $conn;

        $response = array("status" => "error", "message" => "Something went wrong.");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role = isset($_POST['role']) ? $_POST['role'] : 'customer';

            if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
                 $response["message"] = "All fields are required.";
                 echo json_encode($response);
                 return;
            }

            if ($password !== $confirm_password) {
                $response["message"] = "Passwords do not match.";
                echo json_encode($response);
                return;
            }

            if (strlen($password) < 8) {
                $response["message"] = "Password must be at least 8 characters.";
                echo json_encode($response);
                return;
            }

            $user = new User($conn);
            
            if ($user->emailExists($email)) {
                $response["message"] = "Email already exists.";
                echo json_encode($response);
                return;
            }

            if ($user->create($full_name, $email, $password, $role)) {
                $response["status"] = "success";
                $response["message"] = "Registration successful.";
            } else {
                $response["message"] = "Unable to register user.";
            }

            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function showLoginForm() {
        require 'views/auth/login.php'; 
    }

    public function login() {
        global $conn;
        session_start();

        $response = array("status" => "error", "message" => "Invalid credentials.");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                 $response["message"] = "All fields are required.";
                 echo json_encode($response);
                 return;
            }

            $user = new User($conn);
            $loggedInUser = $user->login($email, $password);

            if ($loggedInUser) {
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['full_name'] = $loggedInUser['full_name'];
                $_SESSION['role'] = $loggedInUser['role'];

                $response["status"] = "success";
                $response["message"] = "Login successful.";
            } else {
                $response["message"] = "Invalid email or password.";
            }

            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function showForgotPasswordForm() {
        require 'views/auth/forgot_password.php';
    }

    public function sendResetLink() {
        global $conn;
        
        $response = array("status" => "error", "message" => "Something went wrong.");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            
            if (empty($email)) {
                $response["message"] = "Email is required.";
                echo json_encode($response);
                return;
            }

            $user = new User($conn);
            if (!$user->emailExists($email)) {
                 $response["message"] = "Email not found.";
                 echo json_encode($response);
                 return;
            }

            $passwordReset = new PasswordReset($conn);
            $token = $passwordReset->createToken($email);

            if ($token) {
                 $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/WT_RMS/reset-password?email=" . urlencode($email) . "&token=" . $token;
                 $emailContent = "To: $email\nSubject: Password Reset\nLink: $resetLink\n\n";
                 file_put_contents("email_log.txt", $emailContent, FILE_APPEND);

                 $response["status"] = "success";
                 $response["message"] = "Reset link sent to your email (Check email_log.txt).";
            } else {
                 $response["message"] = "Unable to generate token.";
            }

            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function showResetPasswordForm() {
        global $conn;
        if (isset($_GET['email']) && isset($_GET['token'])) {
            $email = $_GET['email'];
            $token = $_GET['token'];
            
            $passwordReset = new PasswordReset($conn);
            if ($passwordReset->verifyToken($email, $token)) {
                 require 'views/auth/reset_password.php';
            } else {
                 echo "Invalid or expired token.";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function resetPassword() {
        global $conn;
        $response = array("status" => "error", "message" => "Something went wrong.");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $token = $_POST['token'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

             if (empty($password) || empty($confirm_password)) {
                 $response["message"] = "All fields are required.";
                 echo json_encode($response);
                 return;
            }

            if ($password !== $confirm_password) {
                $response["message"] = "Passwords do not match.";
                echo json_encode($response);
                return;
            }

             if (strlen($password) < 8) {
                $response["message"] = "Password must be at least 8 characters.";
                echo json_encode($response);
                return;
            }

            $passwordReset = new PasswordReset($conn);
            if ($passwordReset->verifyToken($email, $token)) {
                $user = new User($conn);
                if ($user->updatePassword($email, $password)) {
                    $passwordReset->deleteToken($email);
                    $response["status"] = "success";
                    $response["message"] = "Password updated successfully.";
                } else {
                    $response["message"] = "Failed to update password.";
                }
            } else {
                $response["message"] = "Invalid or expired token.";
            }

            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}
