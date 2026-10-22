<?php
require 'config/db.php';
$pageTitle = 'المنتجات - LAVENDA';
include 'includes/header.php';

$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<h2 class="title">اكتشفي مجموعتنا ✨</h2>

<section class="products-grid">
    <?php while ($p = $products->fetch_assoc()): ?>
    <div class="card">
        <img src="<?= sanitize($p['image']) ?>" alt="<?= sanitize($p['name']) ?>" loading="lazy">
        <h3><?= sanitize($p['name']) ?></h3>
        <p class="desc"><?= sanitize($p['description']) ?></p>
        <p class="price"><?= number_format($p['price']) ?> جنيه</p>
        
        <?php if (isLoggedIn()): ?>
            <form method="POST" action="order.php" class="order-form">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="number" name="quantity" value="1" min="1" max="10">
                <button class="btn" type="submit">اطلبي الآن 🛒</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="btn">سجلي الدخول للطلب</a>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>
</section>

<?php include 'includes/footer.php'; ?>