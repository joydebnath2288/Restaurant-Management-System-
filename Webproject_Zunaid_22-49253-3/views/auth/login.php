<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="centered-container" style="flex-direction: column;">
        <form method="post" action="index.php?controller=auth&action=authenticate" class="login-form">
            <h2>Login</h2>
            <?php if (isset($_GET['error'])): ?>
                <p class="error">Invalid username or password</p>
            <?php endif; ?>
            
            <label>Username</label>
            <input type="text" name="username" required>
            
            <label>Password</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        
        <div style="margin-top: 30px; text-align: center;">
            <p><strong>Public Access</strong></p>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <a href="index.php?controller=about&action=index" class="btn-about">About Us</a>
                <a href="index.php?controller=announcement&action=index" class="btn-announce">Announcements</a>
                <a href="index.php?controller=faq&action=index" class="btn-faq">FAQ</a>
                <a href="index.php?controller=gallery&action=index" class="btn-gallery">Gallery</a>
                <a href="index.php?controller=support&action=index" class="btn-support">Contact Support</a>
            </div>
        </div>
    </div>
</body>
</html>
