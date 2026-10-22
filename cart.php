<?php
require 'config/db.php';
$pageTitle = 'طلباتي';

if (!isLoggedIn()) redirect('login.php');

include 'includes/header.php';

$stmt = $conn->prepare("
    SELECT o.*, p.name, p.image 
    FROM orders o 
    JOIN products p ON o.product_id = p.id 
    WHERE o.user_id = ? 
    ORDER BY o.created_at DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$orders = $stmt->get_result();
?>

<h2 class="title">طلباتي 🛒</h2>

<section class="products-grid">
    <?php if ($orders->num_rows === 0): ?>
        <p class="empty">لا توجد طلبات بعد. <a href="products.php">تصفحي المنتجات</a></p>
    <?php else: ?>
        <?php while ($o = $orders->fetch_assoc()): ?>
        <div class="card">
            <img src="<?= sanitize($o['image']) ?>" alt="<?= sanitize($o['name']) ?>">
            <h3><?= sanitize($o['name']) ?></h3>
            <p>الكمية: <?= $o['quantity'] ?></p>
            <p class="price">الإجمالي: <?= number_format($o['total_price']) ?> جنيه</p>
            <p class="status status-<?= $o['status'] ?>">
                <?= $o['status'] === 'pending' ? '⏳ قيد المراجعة' : ($o['status'] === 'confirmed' ? '✅ مؤكد' : '❌ ملغي') ?>
            </p>
            <small><?= date('Y-m-d H:i', strtotime($o['created_at'])) ?></small>
        </div>
        <?php endwhile; ?>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>