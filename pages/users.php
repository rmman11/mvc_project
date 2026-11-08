
<?php






$current_page = max(1, (int) ($_GET['users_page'] ?? 1));
$per_page = 3;

$total_users = get_users_count();
$total_pages = (int) ceil($total_users / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$users = get_users_page($current_page, $per_page);




/*
// Handle update
if (isset($_POST['update'])) {
    if (updateProduct($_POST['product_id'], $_POST['name'],$_POST['description'], $_POST['price'], $_POST['quantity_in_stock'])) {
        $message = "✅ Customer updated.";
    }
}*/


if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    echo "✅ Record deleted successfully!";
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>





<div class="main">




    <div class="table-container">
     



 <table>
     <thead>

            <th>ID</th>
            <th>Name</th>
            <th>Username</th>>
            <th>Picture</th>
            <th>Role</th>
            <th>Action</th>
        
         </thead>
           <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= test_input($user["id"]) ?></td>
            <td><?= test_input($user["name"]) ?></td>
          <td><?= test_input($user["username"]) ?></td>
          <td><img
                        src="<?= htmlspecialchars($user['photo'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" width=100 height=100>
                    </td>
            <td><?= test_input($user["role"]) ?></td>
            <td>

               
         <a href="index.php?page=deleteUsers&id=<?= $user['id'] ?>" onclick="return confirm('Delete?')">🗑️ Delete</a>
                </td>
         
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="index.php?page=users&users_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a
            href="index.php?page=users&users_page=<?= $i ?>"
            <?= $i === $current_page ? 'style="font-weight:bold;"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=users&users_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>

    </div>
</div>






    <script>
// Modal JS




</script>