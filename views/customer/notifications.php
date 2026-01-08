<!-- views/customer/notifications.php -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>My Notifications</h2>
    <ul>
        <?php if(isset($notifications) && !empty($notifications)): ?>
            <?php foreach($notifications as $notif): ?>
                <li style="<?php echo ($notif['is_read'] == 0) ? 'font-weight:bold;' : ''; ?>">
                    <?php echo $notif['message']; ?> <small>(<?php echo $notif['created_at']; ?>)</small>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No new notifications.</li>
        <?php endif; ?>
    </ul>
</div>
<?php include 'views/layout/footer.php'; ?>
