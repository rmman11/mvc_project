
<?php


$categories = get_categories();
// Handle create
if (isset($_POST['add_category'])) {
    $category_name = trim($_POST['categoryName'] ?? '');

    if ($category_name !== '') {
        add_category($category_name);

        header("Location: index.php?page=category&added=1");
        exit;
    } else {
        $error = "Please enter a category name.";
    }
}


if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    echo "✅ Record deleted successfully!";
}


?>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div class="flex gap-3">
<button id="openModal"  class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">+ Add Category</button>


</div>
</div>

 <!-- Modal -->
  <div id="categoryModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>

  <form method="POST">
    <input type="text" name="categoryName" placeholder="name" required>
   
    <button type="submit" name="add_category">
        Add Category
    </button>
  </form>


      </div>
  </div>


<table id="example" class="hover">
    <thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
    </thead>
     <tbody>
  </tr>
 
      <?php foreach ($categories as $cat): ?>
        <tr>
          <td><?=  htmlspecialchars($cat['categoryID']) ?></td>
          <td><?=  htmlspecialchars($cat['categoryName']) ?></td>
             <td> <a href="index.php?page=deleteCategory&categoryID=<?= $cat['categoryID'] ?>" onclick="return confirm('Delete?')">🗑️ Delete</a></td>
        </tr>
      <?php endforeach; ?>
      <tr><td colspan="3">No categories found</td></tr>
  
   </tbody>


</table>



    <script>
// Modal JS
var modal = document.getElementById("categoryModal");
var btn   = document.getElementById("openModal");
var span  = document.getElementsByClassName("close")[0];

btn.onclick = function() { modal.style.display = "block"; }
span.onclick = function() { modal.style.display = "none"; }
window.onclick = function(event) {
  if (event.target == modal) modal.style.display = "none";
}

new DataTable('#example');
</script>