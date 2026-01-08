<!-- views/pages/home.php -->
<?php include 'views/layout/header.php'; ?>

<div class="hero">
    <div class="hero-content">
        <p class="subtitle">Experience the Difference</p>
        <h1>Taste the <span>Extraordinary</span></h1>
        <div class="hero-actions">
            <a href="<?php echo BASE_URL; ?>index.php?controller=menu&action=index" class="button primary">View Menu</a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=page&action=about" class="button secondary">Our Story</a>
        </div>
    </div>
</div>

<div class="container section">
    <div class="section-header">
        <h2>Featured Delights</h2>
        <p>Curated just for you</p>
    </div>
    
    <div class="menu-grid">
        <?php if(isset($featured_items) && count($featured_items) > 0): ?>
            <?php foreach($featured_items as $item): ?>
                <div class="menu-card">
                    <div class="card-image">
                       <img src="<?php echo BASE_URL; ?>public/img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" onerror="this.src='https://placehold.co/600x400/2b3947/ed563b?text=Food';">
                    </div>
                    <div class="card-content">
                        <h3><?php echo $item['name']; ?></h3>
                        <p class="description"><?php echo $item['description']; ?></p>
                        <div class="card-footer">
                            <span class="price">$<?php echo $item['price']; ?></span>
                            <form action="<?php echo BASE_URL; ?>index.php?controller=order&action=addToCart" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <input type="hidden" name="menu_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-items">No featured items available at the moment.</p>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
