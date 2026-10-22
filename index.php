<?php
require 'config/db.php';
$pageTitle = 'LAVENDA BEAUTY - الرئيسية';
include 'includes/header.php';

// جلب المنتجات المميزة
$products = $conn->query("SELECT * FROM products LIMIT 3");
?>

<section class="hero">
    <div class="hero-text">
        <h1>جمالك يبدأ من هنا 💗</h1>
        <p>اكتشفي عالم الجمال والعناية ببشرتك. اختاري منتجاتك المفضلة وتألقي كل يوم.</p>
        <a href="products.php" class="btn">اكتشفي منتجاتنا ✨</a>
    </div>
    <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600" 
         alt="منتجات تجميل" loading="lazy">
</section>

<h2 class="title">لمسة جمالك الخاصة</h2>

<section class="products-grid">
    <?php while ($p = $products->fetch_assoc()): ?>
    <div class="card">
        <img src="<?= sanitize($p['image']) ?>" alt="<?= sanitize($p['name']) ?>" loading="lazy">
        <h3><?= sanitize($p['name']) ?></h3>
        <p class="price"><?= number_format($p['price']) ?> جنيه</p>
        <a href="products.php" class="btn">اطلبي الآن</a>
    </div>
    <?php endwhile; ?>
</section>

<?php include 'includes/footer.php'; ?>