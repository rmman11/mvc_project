<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../config/config.php");
include("../model/product_db.php");

$current_page = max(1, (int) ($_GET['product_page'] ?? 1));
$per_page = 12;

$total_products = get_product_count();
$total_pages = (int) ceil($total_products / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$products = get_products_page($current_page, $per_page);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Products</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
     <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
              <!-- Fonts -->
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>

<header>
    <h2>MyShop</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>
    </nav>
</header>

<main>
    <h1>All Products</h1>

    <div class="product-grid">

        <?php foreach ($products as $product): ?>

            <div class="product-card">

                <img
                    src="../<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['productName']) ?>"
                >

                <h3>
                    <?= htmlspecialchars($product['productName']) ?>
                </h3>

                <p class="price">
                    $<?= number_format($product['listPrice'], 2) ?>
                </p>

                <a href="product-details.php?id=<?= (int)$product['productID'] ?>">
                    View Product
                </a>

            </div>

        <?php endforeach; ?>




    </div>
    <div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a  class="active" href="index.php?page=product&product_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a 
           href="index.php?page=product&product_page=<?= $i ?>"
            <?= $i === $current_page ? 'class="active"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=product&product_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>

    </div>
</div>

</main>

</body>
</html>