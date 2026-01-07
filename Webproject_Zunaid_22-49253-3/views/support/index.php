<!DOCTYPE html>
<html>
<head>
    <title><?php echo $data['title'] ?? 'Contact Support'; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-support">

<div class="box">
    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
        <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h3>Contact Support</h3>

    <form id="supportForm">
        
        <label for="name">Name:</label>
        <input type="text" id="name" placeholder="Enter your name">

        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email">

        <label for="message">Message:</label>
        <textarea id="message" rows="3" placeholder="Write your message"></textarea>

        <div style="margin-top: 15px;">
            <button id="submitBtn" type="button">Submit</button>
            <button id="resetBtn" type="reset" style="background-color: #6c757d;">Reset</button>
        </div>

    </form>

    <div id="msgBox"></div>
</div>

<script src="js/support.js"></script>
</body>
</html>
