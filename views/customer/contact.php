<!-- views/customer/contact.php -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>Contact Support</h2>
    <!-- Success/Error Feedback -->
    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] == 'success'): ?>
            <div style="background:#d4edda; color:#155724; padding:10px; margin-bottom:10px;">Message sent successfully!</div>
        <?php else: ?>
             <div style="background:#f8d7da; color:#721c24; padding:10px; margin-bottom:10px;">Failed to send message.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card">
        <form action="<?php echo BASE_URL; ?>index.php?controller=contact&action=send" method="POST">
            <label>Name:</label>
            <input type="text" name="name" required value="<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>"><br>
            
            <label>Email:</label>
            <input type="email" name="email" required value="<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>"><br>
            
            <label>Message:</label>
            <textarea name="message" required style="width:100%; height:100px;"></textarea><br>
            
            <button type="submit">Send Message</button>
        </form>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
