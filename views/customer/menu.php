<!-- views/customer/menu.php -->
<?php 
$page_css = 'menu.css';
$page_js = 'menu.js';
include 'views/layout/header.php'; 
?>

<div class="container">
    <h2>Our Menu</h2>
    <div class="menu-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        <?php if(count($menu_items) > 0): ?>
            <?php foreach($menu_items as $item): ?>
                <div class="menu-item" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                    <h3><?php echo $item['name']; ?></h3>
                    <p class="price">$<?php echo $item['price']; ?></p>
                    <p><?php echo $item['description']; ?></p>
                    <form action="<?php echo BASE_URL; ?>index.php?controller=order&action=place" method="POST">
                        <input type="hidden" name="menu_id" value="<?php echo $item['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                        <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                        <button type="submit">Place Order</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No menu items available.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>
