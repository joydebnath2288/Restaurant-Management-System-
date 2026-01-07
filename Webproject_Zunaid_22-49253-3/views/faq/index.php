<!DOCTYPE html>
<html>
<head>
    <title>FAQ Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="feature-faq">

<div class="box">
    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
        <a href="index.php?controller=dashboard&action=index" class="nav-back">← Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php?controller=auth&action=login" class="nav-back">← Back to Login</a>
    <?php endif; ?>

    <h2>FAQ</h2>

    <?php if (isset($_SESSION['status']) || isset($_COOKIE['status'])): ?>
    <form method="post" action="index.php?controller=faq&action=save">
        <label>Question</label>
        <input type="text" name="question" required>

        <label>Answer</label>
        <textarea name="answer" required></textarea>

        <input type="submit" value="Add FAQ">
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
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No FAQs found.</p>
    <?php } ?>
</div>

</body>
</html>
