<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="centered-container">
        <div class="dashboard-container">
            <h2>Restaurant Management System – Dashboard</h2>
            
            <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
                <a href="index.php?controller=support&action=admin" class="btn-support">Contact Support (View Messages)</a>
                <a href="index.php?controller=gallery&action=index" class="btn-gallery">Gallery Management</a>
                <a href="index.php?controller=faq&action=index" class="btn-faq">FAQ Management</a>
                <a href="index.php?controller=announcement&action=index" class="btn-announce">Announcement Management</a>
                <a href="index.php?controller=about&action=index" class="btn-about">About Page</a>
                <a href="index.php?controller=auth&action=logout" class="btn-logout">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
