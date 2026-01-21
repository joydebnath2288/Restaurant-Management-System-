<?php
function supportInsert($name, $email, $message) {
    require '../config/Database.php';

    $sql = "INSERT INTO support_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function supportGetAll() {
    require '../config/Database.php';

    $sql = "SELECT * FROM support_messages";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        return [];
    }

    $rows = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function supportDelete($id) {
    require '../config/Database.php';
    $sql = "DELETE FROM support_messages WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>
