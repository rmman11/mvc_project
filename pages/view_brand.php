<?php
if (isset($_GET['page'], $_GET['slug'])
    && $_GET['page'] === 'view_brand') {
    global $db;   
    $slug = $_GET['slug'];

    $stmt = $db->prepare(
        "SELECT * FROM brands WHERE slug = :slug LIMIT 1"
    );

    $stmt->execute(['slug' => $slug]);
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($brand) {
        ?>
       <h2><?= htmlspecialchars($brand['name']) ?></h2>
     <img src="<?= htmlspecialchars($brand['image'], ENT_QUOTES, 'UTF-8') ?>"
                        <?php
    } else {
        echo 'Brand not found.';
    }
}
?>