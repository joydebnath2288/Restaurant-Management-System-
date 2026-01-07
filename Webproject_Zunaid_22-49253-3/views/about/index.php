<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-about">

<div class="box">
    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
        <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h2>About Us</h2>

    <div id="aboutSection" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f9f9f9; border-radius: 4px;">
        <h3 id="restaurantName">Restaurant Name</h3>
        <p id="restaurantDesc">Short description</p>
    </div>

    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
    <form id="aboutForm">
        <h3>Update Details</h3>

        <label for="resName">Restaurant Name</label>
        <input type="text" id="resName" placeholder="Enter restaurant name">

        <label for="shortDesc">Short Description</label>
        <textarea id="shortDesc" rows="3" placeholder="Write a short description"></textarea>

        <button id="updateBtn" type="button">Update</button>
    </form>
    <?php endif; ?>
</div>

<div class="box" style="margin-top: 20px; max-width: 800px;">
    <h3>Our Team</h3>

    <div class="team-row">

        <div class="team-box">
            <img src="images/oweb.png" class="team-img" alt="Owner">
            <h4>Owner</h4>
            <p>Name: Md Ismail</p>
            <p>Email: ismail332@gmail.com</p>
            <p>Contact no: 01765674567</p>
        </div>

        <div class="team-box">
            <img src="images/manager.jpg" class="team-img" alt="Manager">
            <h4>Manager</h4>
            <p>Name: Md Khan</p>
            <p>Email: kkhan445@gmail.com</p>
            <p>Contact no: 01876767898</p>
        </div>

        <div class="team-box">
            <img src="images/webc.jpg" class="team-img" alt="Chef">
            <h4>Chef</h4>
            <p>Name: Md Iqbal</p>
            <p>Email: hiqbal67@gmail.com</p>
            <p>Contact no: 01987654323</p>
        </div>

    </div>
</div>

<script src="js/about.js"></script>
</body>
</html>
