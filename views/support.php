<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Support</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-support">

<div class="box">
    <?php if (isset($_SESSION['role'])): ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="dashboard.php" class="nav-back">← Back to Dashboard</a>
        <?php else: ?>
            <a href="customer_dashboard.php" class="nav-back">← Back to Dashboard</a>
        <?php endif; ?>
    <?php else: ?>
        <a href="login.php" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h3>Contact Support</h3>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo "Message Sent Successfully"; ?></p>
    <?php endif; ?>

    <form action="../controllers/Support.php" method="POST">
        
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder="Enter your name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label for="message">Message:</label>
        <textarea name="message" rows="3" placeholder="Write your message" required></textarea>

        <div style="margin-top: 15px;">
            <button type="submit">Submit</button>
            <button type="reset" style="background-color: #6c757d;">Reset</button>
        </div>

    </form>
</div>

</body>
</html>
