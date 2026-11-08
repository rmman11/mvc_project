<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = array_sum($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison Store | Premium Shopping</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">MAISON<span>.</span></a>

    <nav class="nav" id="navigation">
        <a href="index.php">Home</a>
        <a href="products.php">Shop</a>
        <a href="products.php?category=1">Electronics</a>
        <a href="products.php?category=2">Fashion</a>
    </nav>

    <div class="header-actions">
        <a href="cart.php" class="cart-link">
            Bag <span class="cart-count"><?= $cartCount ?></span>
        </a>

        <button class="menu-toggle" id="menuToggle"
            aria-label="Toggle navigation">☰</button>
    </div>
</header>