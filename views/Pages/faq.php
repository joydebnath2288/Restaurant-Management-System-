<!-- views/pages/faq.php -->
<?php 
$page_css = 'faq.css';
include 'views/layout/header.php'; 
?>
<div class="container">
    <h2>Frequently Asked Questions</h2>
    <?php if(!empty($faqs)): ?>
        <?php foreach($faqs as $f): ?>
            <div class="faq-item" style="margin-bottom:20px; border-bottom:1px solid #eee; padding-bottom:10px;">
                <h3 style="color:#007bff;">Q: <?php echo $f['question']; ?></h3>
                <p><strong>A:</strong> <?php echo $f['answer']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No questions available.</p>
    <?php endif; ?>
</div>
<?php include 'views/layout/footer.php'; ?>
