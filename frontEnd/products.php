
<?php



$servername = "localhost";
$username = "root";
$password = "man123";
$dbname = "learnphp";
try {
  $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}



require 'header.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$search = trim($_GET['search'] ?? '');
$category = (int)($_GET['category'] ?? 0);
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 12;
$offset = ($page - 1) * $limit;

$where = [];
$params = [];

if ($search !== '') {
    $where[] = "p.name LIKE ?";
    $params[] = "%$search%";
}

if ($category > 0) {
    $where[] = "p.category_id = ?";
    $params[] = $category;
}

if ($minPrice !== '' && is_numeric($minPrice) && $minPrice >= 0) {
    $where[] = "p.price >= ?";
    $params[] = (float)$minPrice;
}

if ($maxPrice !== '' && is_numeric($maxPrice) && $maxPrice >= 0) {
    $where[] = "p.price <= ?";
    $params[] = (float)$maxPrice;
}

$whereSQL = $where
    ? 'WHERE ' . implode(' AND ', $where)
    : '';

$sortOptions = [
    'newest' => 'p.created_at DESC',
    'price_low' => 'p.price ASC',
    'price_high' => 'p.price DESC',
    'name' => 'p.name ASC'
];

$orderBy = $sortOptions[$sort] ?? $sortOptions['newest'];

$countStmt = $pdo->prepare(
    "SELECT COUNT(*) FROM products p $whereSQL"
);
$countStmt->execute($params);

$totalProducts = (int)$countStmt->fetchColumn();
$totalPages = max(1, (int)ceil($totalProducts / $limit));

$page = min($page, $totalPages);
$offset = ($page - 1) * $limit;

$sql = "
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    $whereSQL
    ORDER BY $orderBy
    LIMIT $limit OFFSET $offset
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$categories = $db->query(
    "SELECT * FROM categories ORDER BY categoryName"
)->fetchAll();

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function pageUrl($page) {
    $query = $_GET;
    $query['page'] = $page;
    return '?' . http_build_query($query);
}
?>

<main class="shop-container">

    <section class="shop-heading">
        <div>
            <span class="eyebrow">DISCOVER OUR COLLECTION</span>
            <h1>Find your next favorite.</h1>
            <p>Thoughtfully selected products for everyday living.</p>
        </div>

        <div class="product-total">
            <?= $totalProducts ?> products
        </div>
    </section>

    <form method="GET" action="products.php" class="search-bar">
        <input
            type="text"
            name="search"
            placeholder="Search products..."
            value="<?= e($search) ?>"
        >

        <?php if ($category): ?>
            <input type="hidden" name="category"
                value="<?= $category ?>">
        <?php endif; ?>

        <button type="submit">Search</button>
    </form>

    <div class="shop-layout">

        <aside class="sidebar">

            <form method="GET" action="products.php">

                <h3>Categories</h3>

                <a href="products.php"
                   class="category-link <?= !$category ? 'active' : '' ?>">
                    All Products
                </a>

                <?php foreach ($categories as $cat): ?>
                    <a
                        href="?category=<?= (int)$cat['id'] ?>"
                        class="category-link <?= $category == $cat['id'] ? 'active' : '' ?>"
                    >
                        <?= e($cat['name']) ?>
                    </a>
                <?php endforeach; ?>

                <div class="filter-divider"></div>

                <h3>Price Range</h3>

                <input
                    type="number"
                    name="min_price"
                    placeholder="Minimum price"
                    min="0"
                    step="0.01"
                    value="<?= e($minPrice) ?>"
                >

                <input
                    type="number"
                    name="max_price"
                    placeholder="Maximum price"
                    min="0"
                    step="0.01"
                    value="<?= e($maxPrice) ?>"
                >

                <input type="hidden" name="search"
                    value="<?= e($search) ?>">

                <button type="submit" class="filter-button">
                    Apply Filters
                </button>

                <a href="products.php" class="reset-link">
                    Reset filters
                </a>

            </form>

        </aside>

        <section class="products-section">

            <div class="products-toolbar">
                <span>Showing <?= count($products) ?> products</span>

                <form method="GET" action="products.php">
                    <input type="hidden" name="search"
                        value="<?= e($search) ?>">
                    <input type="hidden" name="category"
                        value="<?= $category ?>">
                    <input type="hidden" name="min_price"
                        value="<?= e($minPrice) ?>">
                    <input type="hidden" name="max_price"
                        value="<?= e($maxPrice) ?>">

                    <select name="sort" onchange="this.form.submit()">
                        <option value="newest"
                            <?= $sort === 'newest' ? 'selected' : '' ?>>
                            Newest
                        </option>

                        <option value="price_low"
                            <?= $sort === 'price_low' ? 'selected' : '' ?>>
                            Price: Low to High
                        </option>

                        <option value="price_high"
                            <?= $sort === 'price_high' ? 'selected' : '' ?>>
                            Price: High to Low
                        </option>

                        <option value="name"
                            <?= $sort === 'name' ? 'selected' : '' ?>>
                            Name A-Z
                        </option>
                    </select>
                </form>
            </div>

            <div class="product-grid">

                <?php if ($products): ?>

                    <?php foreach ($products as $product): ?>

                        <article class="product-card">

                            <div class="product-image">
                                <img
                                    src="<?= e($product['image']) ?>"
                                    alt="<?= e($product['name']) ?>"
                                    loading="lazy"
                                >

                                <?php if ($product['old_price'] &&
                                    $product['old_price'] > $product['price']): ?>

                                    <span class="discount">
                                        SALE
                                    </span>

                                <?php endif; ?>
                            </div>

                            <div class="product-info">

                                <span class="product-category">
                                    <?= e($product['category_name'] ?? 'General') ?>
                                </span>

                                <h3><?= e($product['name']) ?></h3>

                                <p class="product-description">
                                    <?= e($product['description']) ?>
                                </p>

                                <div class="product-price">
                                    <strong>
                                        $<?= number_format($product['price'], 2) ?>
                                    </strong>

                                    <?php if ($product['old_price'] &&
                                        $product['old_price'] > $product['price']): ?>

                                        <del>
                                            $<?= number_format($product['old_price'], 2) ?>
                                        </del>

                                    <?php endif; ?>
                                </div>

                                <form method="POST" action="add-to-cart.php">
                                    <input type="hidden" name="csrf_token"
                                        value="<?= e($_SESSION['csrf_token']) ?>">

                                    <input type="hidden" name="product_id"
                                        value="<?= (int)$product['id'] ?>">

                                    <input type="hidden" name="quantity"
                                        value="1">

                                    <button
                                        class="add-cart-button"
                                        type="submit"
                                        <?= $product['stock'] <= 0 ? 'disabled' : '' ?>
                                    >
                                        <?= $product['stock'] > 0
                                            ? 'Add to Bag +'
                                            : 'Out of Stock' ?>
                                    </button>
                                </form>

                            </div>
                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-products">
                        <h2>No products found</h2>
                        <p>Try changing your search or filters.</p>
                        <a href="products.php">View all products</a>
                    </div>

                <?php endif; ?>

            </div>

            <?php if ($totalPages > 1): ?>

                <div class="pagination">

                    <?php if ($page > 1): ?>
                        <a href="<?= e(pageUrl($page - 1)) ?>">
                            &laquo; Previous
                        </a>
                    <?php endif; ?>

                    <?php for (
                        $i = max(1, $page - 2);
                        $i <= min($totalPages, $page + 2);
                        $i++
                    ): ?>

                        <a
                            href="<?= e(pageUrl($i)) ?>"
                            class="<?= $page === $i ? 'current' : '' ?>"
                        >
                            <?= $i ?>
                        </a>

                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="<?= e(pageUrl($page + 1)) ?>">
                            Next &raquo;
                        </a>
                    <?php endif; ?>

                </div>

            <?php endif; ?>

        </section>
    </div>
</main>

