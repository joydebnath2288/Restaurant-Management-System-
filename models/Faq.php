<?php
function faqInsert($question, $answer) {
    require '../config/Database.php';

    $sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    } else {
        return false;
    }
}

function faqGetAll() {
    require '../config/Database.php';

    $sql = "SELECT * FROM faq";
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

function faqDelete($id) {
    require '../config/Database.php';
    $sql = "DELETE FROM faq WHERE id = '$id'";
    return mysqli_query($con, $sql);
}
?>
