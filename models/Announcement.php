<?php
function announcementInsert($title, $type, $message) {
    require '../config/Database.php';
    
    $sql = "INSERT INTO announcement (title, type, message) VALUES ('$title', '$type', '$message')";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function announcementGetAll() {
    require '../config/Database.php';
    
    $sql = "SELECT * FROM announcement ORDER BY created_at DESC";
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

function announcementDelete($id) {
    require '../config/Database.php';
    $sql = "DELETE FROM announcement WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}
?>
