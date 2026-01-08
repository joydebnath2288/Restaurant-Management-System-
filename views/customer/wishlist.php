<!-- views/customer/wishlist.php -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>My Wishlist</h2>
    <?php if (!empty($wishlist_items)): ?>
        <ul class="wishlist-grid">
            <?php foreach ($wishlist_items as $item): ?>
                <li>
                    <strong><?php echo $item['name']; ?></strong> - $<?php echo $item['price']; ?>
                    <form action="<?php echo BASE_URL; ?>index.php?controller=order&action=addToCart" method="POST" style="display:inline;">
                        <input type="hidden" name="menu_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit">Order Now</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Your wishlist is empty.</p>
    <?php endif; ?>
</div>
<?php include 'views/layout/footer.php'; ?>
