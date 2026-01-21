<?php
function teamGetAll() {
    require '../config/Database.php';
    $sql = "SELECT * FROM team_members";
    $result = mysqli_query($con, $sql);
    
    if (!$result) return [];
    
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function teamInsert($name, $role, $email, $phone, $image) {
    require '../config/Database.php';
    $sql = "INSERT INTO team_members (name, role, email, phone, image) VALUES ('$name', '$role', '$email', '$phone', '$image')";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    }
    return false;
}

function teamUpdate($id, $name, $role, $email, $phone, $image = null) {
    require '../config/Database.php';
    if ($image) {
        $sql = "UPDATE team_members SET name='$name', role='$role', email='$email', phone='$phone', image='$image' WHERE id='$id'";
    } else {
        $sql = "UPDATE team_members SET name='$name', role='$role', email='$email', phone='$phone' WHERE id='$id'";
    }
    return mysqli_query($con, $sql);
}

function teamDelete($id) {
    require '../config/Database.php';
    $sql = "DELETE FROM team_members WHERE id='$id'";
    return mysqli_query($con, $sql);
}
?>
