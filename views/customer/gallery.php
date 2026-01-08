<!-- views/customer/gallery.php -->
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <h2>Photo Gallery</h2>
    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
        <?php if(!empty($images)): ?>
            <?php foreach($images as $img): ?>
                <div class="gallery-item" style="border:1px solid #ddd; padding:10px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                    <?php $imgSrc = isset($img['image']) ? $img['image'] : 'default.jpg'; ?>
                    <img src="<?php echo BASE_URL; ?>public/uploads/gallery/<?php echo $imgSrc; ?>" alt="Gallery Image" style="width:100%; height:200px; object-fit:cover; border-radius:5px;">
                    <p style="margin-top:10px; font-weight:bold;"><?php echo isset($img['description']) ? htmlspecialchars($img['description']) : ''; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No photos available yet.</p>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
