<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Smart Restaurant</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <!-- Core CSS (Absolute Path) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/main.css">
    
    <!-- Page Specific CSS (Absolute Path) -->
    <?php if(isset($page_css)): ?>
        <?php foreach((array)$page_css as $css): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <header>
        <div class="container">
            <div id="branding">
                <h1><span class="highlight">Smart</span> Restaurant</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=page&action=home">Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=menu&action=index">Menu</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=gallery&action=index">Gallery</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=faq&action=index">FAQ</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=announcement&action=index">Announcements</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=page&action=about">About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>index.php?controller=contact&action=index">Contact</a></li>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                         <li><a href="<?php echo BASE_URL; ?>index.php?controller=dashboard&action=index">Dashboard</a></li>
                         <li><a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout">Logout (<?php echo $_SESSION['user_name']; ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login">Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=signup">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
