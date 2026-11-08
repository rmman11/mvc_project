  <?php
 
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        if (deleteCustomer($id)) {
            header("Location: index.php?page=customer");
            exit;
        } else {
            echo "❌ No customer found or nothing was deleted.";
        }
    } else {
        echo "❌ Invalid customer ID.";
    }
}



?>    