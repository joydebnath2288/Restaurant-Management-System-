<!-- views/auth/login.php -->
<?php 
$page_css = 'auth.css';
$page_js = 'auth.js';
include 'views/layout/header.php'; 
?>

<div class="container">
    <h2>Login</h2>
    <?php if(isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
        <div class="alert success">Registration successful! Please login.</div>
    <?php endif; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form action="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="<?php echo BASE_URL; ?>index.php?page=signup">Sign up here</a></p>
</div>

<?php include 'views/layout/footer.php'; ?>
