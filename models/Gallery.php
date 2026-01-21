<?php
function galleryInsert($title, $description, $imageName) {
    require '../config/Database.php';

    $sql = "INSERT INTO gallery (title, description, image) VALUES ('$title', '$description', '$imageName')";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function galleryGetAll() {
    require '../config/Database.php';

    $sql = "SELECT * FROM gallery";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        return [];
    }

    $images = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }
    }
    return $images;
}

function galleryDelete($id) {
    require '../config/Database.php';
    $sql = "DELETE FROM gallery WHERE id = '$id'";
    return mysqli_query($con, $sql);
}
?>
