<?php
session_start();
session_destroy();
setcookie("user_role", "", time() - 1800, "/");
header("Location: ../views/login.php");
exit;
?>
