  <?php
 
if (isset($_GET['categoryID'])) {
    $id = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        if (deleteCategory($id)) {
            header("Location: index.php?page=category");
            exit;
        } else {
            echo "❌ No product found or nothing was deleted.";
        }
    } else {
        echo "❌ Invalid product ID.";
    }
}



?>    