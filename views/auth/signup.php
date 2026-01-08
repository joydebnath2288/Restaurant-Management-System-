<!-- views/auth/signup.php -->
<?php 
$page_css = 'auth.css';
$page_js = 'auth.js';
include 'views/layout/header.php'; 
?>

<div class="container">
    <h2>Sign Up</h2>
    <?php if(isset($error)): ?>
        <div class="alert"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>index.php?controller=auth&action=signup" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="<?php echo BASE_URL; ?>index.php?page=login">Login here</a></p>
</div>

<?php include 'views/layout/footer.php'; ?>
