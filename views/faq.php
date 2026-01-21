<?php
session_start();
    require_once "../models/Faq.php";
    $faqs = faqGetAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>FAQ Management</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="feature-faq">

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

    <h2>FAQ</h2>

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; text-align: center;"><?php echo "FAQ Added Successfully"; ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <form action="../controllers/Faq.php" method="POST">
        <label>Question</label>
        <input type="text" name="question" required>

        <label>Answer</label>
        <textarea name="answer" required></textarea>

        <button type="submit">Add FAQ</button>
    </form>
    <?php endif; ?>
</div>

<div class="box" style="margin-top: 20px;">
    <h3>Common Questions</h3>

    <?php if (!empty($faqs)) { ?>
        <?php foreach ($faqs as $row) { ?>
            <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                <p><strong>Q:</strong> <?php echo $row['question']; ?></p>
                <p><strong>A:</strong> <?php echo $row['answer']; ?></p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                     <div style='margin-top:10px;'>
                         <a href="../controllers/Faq.php?delete=<?php echo $row['id']; ?>" class="delete-btn" style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px;'>Delete</a>
                     </div>
                <?php endif; ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No FAQs found.</p>
    <?php } ?>
</div>

</body>
</html>
