  <?php
 
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null && $id > 0) {
        if (deleteUsers($id)) {
            header("Location: index.php?page=users");
            exit;
        } else {
            echo "❌ No customer found or nothing was deleted.";
        }
    } else {
        echo "❌ Invalid customer ID.";
    }
}



?>    