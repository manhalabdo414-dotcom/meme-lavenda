<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LAVENDA BEAUTY - متجرك المفضل لمنتجات التجميل والعناية بالبشرة">
    <title><?= $pageTitle ?? 'LAVENDA BEAUTY' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💄</text></svg>">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php">LAVENDA<span>.</span></a>
    </div>

    <button class="menu-toggle" onclick="toggleMenu()" aria-label="القائمة">
        <span></span><span></span><span></span>
    </button>

    <nav id="mainNav">
        <a href="index.php" class="<?= $current==='index.php'?'active':'' ?>">الرئيسية</a>
        <a href="products.php" class="<?= $current==='products.php'?'active':'' ?>">المنتجات</a>
        <a href="contact.php" class="<?= $current==='contact.php'?'active':'' ?>">تواصل معنا</a>

        <?php if (isLoggedIn()): ?>
            <a href="cart.php" class="<?= $current==='cart.php'?'active':'' ?>">
                🛒 طلباتي
            </a>
            <a href="logout.php" class="nav-btn">خروج</a>
        <?php else: ?>
            <a href="login.php" class="nav-btn <?= $current==='login.php'?'active':'' ?>">دخول</a>
        <?php endif; ?>
    </nav>
</header>

<main>