<?php
require 'config/db.php';

if (!isLoggedIn()) redirect('login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)($_POST['product_id'] ?? 0);
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    // جلب سعر المنتج
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        $total = $product['price'] * $quantity;
        $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $user_id, $product_id, $quantity, $total);
        $stmt->execute();
    }
}

redirect('cart.php');
?>