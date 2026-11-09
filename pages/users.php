
<?php


$message = "";

$username = $password = "";
$username_err = $password_err = "";



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


// Handle create
if (isset($_POST['register'])) {
    if (register($_POST['username'],$_POST['name'],$_POST['email'],$_POST['password'])) {
        $message = "register";
          header("Location: index.php?page=register");
    }
}

if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    echo "✅ Record deleted successfully!";
}

?>

<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div class="flex gap-3">


    <button type="button"  class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm"
        data-bs-toggle="modal" data-bs-target="#add_user">
         <i class="fa-solid fa-plus"></i>
    Add User
</button>


</div>
</div>

    <div class="table-container">
    
 <table>
     <thead>

            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
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
    </main>




     <!-- Modal -->
<div class="modal fade" id="add_user" tabindex="-1"
     aria-labelledby="addUserLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

      <span class="close"  data-bs-dismiss="modal">&times;</span>

  <form method="POST" enctype="multipart/form-data"  action="" class="form-control" >

<div class="container mx-auto px-4">
  
    <p>Please fill this form to create an account.</p>
    <form action="" method="post"  enctype="multipart/form-data">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" value="" autofocus="autofocus" autocomplete="username">
       
        </div> 
        
           <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" value="" autofocus="autofocus" autocomplete="name">
       
        </div> 
           <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" value="" autofocus="autofocus" autocomplete="email">
       
        </div> 

           <div class="form-group">
            <label>Poza</label>

     <input type="file" id="file-upload" name="photo" accept="image/*">
      <div class="preview" id="preview"></div>
</div>
               
       




        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"  autofocus="autofocus" autocomplete="password">
            <span class="help-block"></span>
        </div>
     

    

          <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

    <button type="submit"   class="btn btn-primary" name="register">Add User</button>
  </form>

</div>
      </div>
  </div>



 <script>
    const fileInput = document.getElementById('file-upload');
    const preview = document.getElementById('preview');

    fileInput.addEventListener('change', function() {
      preview.innerHTML = ''; // clear previous preview
      const file = this.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          preview.appendChild(img);
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
