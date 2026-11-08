  <?php
 
if (isset($_GET['productID'])) {
    $id = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        if (delete_product($id)) {
            header("Location: index.php?page=product");
            exit;
        } else {
            echo "❌ No product found or nothing was deleted.";
        }
    } else {
        echo "❌ Invalid product ID.";
    }
}



?>    