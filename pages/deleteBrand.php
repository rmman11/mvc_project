  <?php
 
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        if (deleteBrand($id)) {
            header("Location: index.php?page=brand");
            exit;
        } else {
            echo "❌ No product found or nothing was deleted.";
        }
    } else {
        echo "❌ Invalid product ID.";
    }
}



?>   