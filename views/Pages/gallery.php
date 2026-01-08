<!-- views/pages/gallery.php -->
<?php 
$page_css = 'gallery.css';
include 'views/layout/header.php'; 
?>
<div class="container">
    <h2>Photo Gallery</h2>
    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
        <?php if(!empty($images)): ?>
            <?php foreach($images as $img): ?>
                <div class="gallery-item" style="border:1px solid #ccc; padding:10px;">
                    <img src="<?php echo BASE_URL; ?>public/img/<?php echo $img['image_path']; ?>" alt="<?php echo $img['caption']; ?>" style="width:100%; height:150px; object-fit:cover;">
                    <p style="text-align:center; font-style:italic;"><?php echo $img['caption']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No photos added yet.</p>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
