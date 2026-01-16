<?php
session_start();
session_destroy();
header("Location: /WT_RMS/login");
exit;
?>
