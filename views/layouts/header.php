<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link rel="stylesheet" href="/WT_RMS/assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<header>
    <h1>RMS</h1>
    <nav>
        <a href="/WT_RMS/">Home</a>
        <?php 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['user_id'])): ?>
            <a href="/WT_RMS/dashboard">Dashboard</a>
            <a href="/WT_RMS/logout">Logout</a>
        <?php else: ?>
            <a href="/WT_RMS/login">Login</a>
            <a href="/WT_RMS/signup">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
