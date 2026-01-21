<?php

if (!isset($_SESSION['role'])) {
    header("Location: ../views/login.php");
    exit;
}
require_once "../views/dashboard.php";
