<?php
class AuthModel {

    public function getUserByUsername($username) {
        global $con;
        
        $safe_username = mysqli_real_escape_string($con, $username);
        $query = "SELECT * FROM employees WHERE login_id = '$safe_username' AND status = 'Active' LIMIT 1";
        
        $result = mysqli_query($con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}
?>
