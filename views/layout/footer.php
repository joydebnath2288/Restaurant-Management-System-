    <footer>
        <p>Smart Restaurant System &copy; 2026</p>
    </footer>
    <script src="<?php echo BASE_URL; ?>public/js/script.js"></script>
    <script>
        const CSRF_TOKEN = "<?php echo $_SESSION['csrf_token']; ?>";
    </script>
    <script src="<?php echo BASE_URL; ?>public/js/main.js"></script>
    <?php if(isset($page_js)): ?>
        <?php foreach((array)$page_js as $js): ?>
            <script src="<?php echo BASE_URL; ?>public/js/<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
