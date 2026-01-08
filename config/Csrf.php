<?php
// helpers/Csrf.php

class Csrf {
    
    // Generate a token and store in session
    public static function generate() {
        if(empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Verify the token from POST request
    public static function verify($token) {
        if(isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }
}
?>
