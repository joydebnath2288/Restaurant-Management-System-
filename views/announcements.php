<!-- views/pages/announcements.php -->
<!-- Access via page=announcements -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>Announcements</h2>
    <?php if(isset($announcements) && !empty($announcements)): ?>
        <?php foreach($announcements as $announce): ?>
            <div class="card" style="border:1px solid #ccc; padding:15px; margin-bottom:10px;">
                <h3><?php echo $announce['title']; ?></h3>
                <p><?php echo $announce['message']; ?></p>
                <small>Posted on: <?php echo $announce['created_at']; ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No recent announcements.</p>
    <?php endif; ?>
</div>
<?php include 'views/layout/footer.php'; ?>
