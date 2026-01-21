<?php
function signupUser($username, $email, $password, $role) {
    require '../config/Database.php';

    $check = "SELECT * FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($con, $check);
    if (mysqli_num_rows($checkResult) > 0) {
        return false;
    }

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

function loginUser($username, $password) {
    require '../config/Database.php';

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}
?>
