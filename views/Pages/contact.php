<!-- views/pages/contact.php -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>Contact Support</h2>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <p style="color:green;">Message sent successfully!</p>
    <?php endif; ?>
    
    <form action="<?php echo BASE_URL; ?>index.php?controller=contact&action=submit" method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" required><br>
        
        <label>Message:</label>
        <textarea name="message" required></textarea><br>
        
        <button type="submit">Send Message</button>
    </form>
</div>
<?php include 'views/layout/footer.php'; ?>
