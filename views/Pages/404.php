<?php include 'views/layout/header.php'; ?>

<div class="container" style="padding: 50px 0; text-align: center;">
    <h1 style="font-size: 3em; color: var(--primary-color);">404</h1>
    <h2>Page Not Found</h2>
    <p>The page you are looking for does not exist or has been moved.</p>
    <a href="<?php echo BASE_URL; ?>index.php?controller=page&action=home" class="button">Go Home</a>
</div>

<?php include 'views/layout/footer.php'; ?>
