
<?php


$categoryID = (int)($_GET['categoryID'] ?? 1);

if ($categoryID < 1) {
    $categoryID = 1;
}


$category_name = get_category_name($categoryID);
$categories = get_categories();
//$products = get_products_by_category($category_id);


// Handle create
if (isset($_POST['create'])) {
    $code = $_POST['productCode'];
    $name = $_POST['productName'];
    $image =$_POST['image'];
    $old_price =$_POST['old_price'];
    $price = $_POST['listPrice'];
    $information = $_POST['information'];
    $short_description = $_POST['short_description'];
    $status= $_POST['status'];
    $stock_status = $_POST['stock_status'];
    $quantity = (int)$_POST['quantity'];



    $image = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    $upload_dir = 'uploads/products/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($extension, $allowed)) {

        $image_name = uniqid('product_', true) . '.' . $extension;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
            $image = $upload_dir . $image_name;
        }
    }
}


    if (add_product($categoryID, $code, $name, $price,$information,$short_description,$status,$quantity,$stock_status, $image,
         $old_price)) {
        header("Location: index.php?page=product");
        exit;
    }
}



if (isset($_GET['added']) && $_GET['added'] == 1) {
    echo "✅ Product added successfully!";
}


if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    echo "✅ Record deleted successfully!";
}



$current_page = max(1, (int) ($_GET['product_page'] ?? 1));
$per_page = 5;

$total_products = get_product_count();
$total_pages = (int) ceil($total_products / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$products = get_products_page($current_page, $per_page);




if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['updateProduct'])) {

    $productID = filter_input(
        INPUT_POST,
        'productID',
        FILTER_VALIDATE_INT
    );

    if (!$productID || $productID < 1) {
        exit('Invalid product ID.');
    }







    $categoryID = (int)($_POST['categoryID'] ?? 0);
    $code = trim($_POST['productCode'] ?? '');
    $name = trim($_POST['productName'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $price = (float)($_POST['listPrice'] ?? 0);
     $old_price = (float)($_POST['old_price'] ?? 0);
    $information = trim($_POST['information'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $status = $_POST['status'] ?? '';
    $quantity = (int)($_POST['quantity'] ?? 0);
    $stock_status = $_POST['stock_status'] ?? '';

    if (updateProduct(
        $productID,
        $categoryID,
        $code,
        $name,
        $price,
        $information,
        $short_description,
        $status,
        $quantity,
        $stock_status,
         $image,
         $old_price
    )) {
        header('Location: index.php?page=product&updated=1');
        exit;
    }
}

/*
// Handle update
if (isset($_POST['update'])) {
    if (updateProduct($_POST['product_id'], $_POST['name'],$_POST['description'], $_POST['price'], $_POST['quantity_in_stock'])) {
        $message = "✅ Customer updated.";
    }
}*/

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div class="flex gap-3">
<button type="button" class="btn btn-primary"
        data-bs-toggle="modal" data-bs-target="#add_product">
     <i class="fa-solid fa-plus"></i>Add Product
</button>

</div>
</div>

 <!-- Modal -->
<div class="modal fade" id="add_product" tabindex="-1"
     aria-labelledby="addProductLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

      <span class="close"  data-bs-dismiss="modal">&times;</span>

  <form method="POST" enctype="multipart/form-data"  action="" class="form-control" >


     <div class="col-12 mb-3">

          <label>Category:</label>
  <select name="categoryID" required class="form-control">
    <option value="">-- Select Category --</option>
    <?php foreach($categories as $category): ?>
      <option value="<?= $category['categoryID'] ?>"><?= htmlspecialchars($category['categoryName']) ?></option>
    <?php endforeach; ?>
  </select>

   </div>

     <div class="col-12 mb-3">
  <label>Code:</labe>
   <input type="text" name="productCode" value=""  class="form-control">
   </div>

     <div class="col-12 mb-3">
            <label>Name</label>
            <input type="text" name="productName"  value=""  class="form-control">

            </div> 


                        <!-- Short Description -->
                        <div class="col-12 mb-3">
                            <label for="short_description"
                                   class="form-label">
                                Short Description
                            </label>
                            <textarea name="short_description"
                                      id="short_description"
                                      class="form-control"
                                      rows="2"></textarea>
                        </div>

                        <!-- Information -->
                        <div class="col-12 mb-3">
                            <label for="information" class="form-label">
                                Information
                            </label>
                            <textarea name="information" id="information"
                                      class="form-control" rows="4"
                                      required></textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                Status
                            </label>
                            <select name="status" id="status"
                                    class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Stock Status -->
                        <div class="col-md-6 mb-3">
                            <label for="stock_status" class="form-label">
                                Stock Status
                            </label>
                            <select name="stock_status" id="stock_status"
                                    class="form-select" required>
                                <option value="in_stock">In Stock</option>
                                <option value="out_of_stock">
                                    Out of Stock
                                </option>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">
                                Quantity
                            </label>
                            <input type="number" name="quantity"
                                   id="quantity" class="form-control"
                                   min="0" value="0" required>
                        </div>

                 <div class="col-md-6 mb-3">

                    <label>Product Image</label>
                    <input type="file" name="image" accept="image/*">

                </div>

                 <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">
                                Price
                            </label>
                            <input type="number" name="listPrice" id="price"
                                   class="form-control" min="0"
                                   step="0.01" required>
                        </div>
                             <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">
                                old Price
                            </label>
                            <input type="number" name="old_price" id="price"
                                   class="form-control" min="0"
                                   step="0.01" required>
                        </div>



          <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

    <button type="submit"   class="btn btn-primary" name="create">Add Product</button>
  </form>

</div>
      </div>
  </div>






<div class="main">




    <div class="table-container">
     

  <!-- Success/Error Message -->
  <?php if (!empty($message)): ?>
      <div class="alert"><?php echo $message; ?></div>
  <?php endif; ?>  <!-- Success/Error Message -->
 <table>
     <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Categorie</th>
            <th>Photo</th>
             <th>Photo</th>
            <th>Action</th>
        </tr>
         </thead>
           <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= test_input($product["productID"]) ?></td>
            <td><?= test_input($product["productName"]) ?></td>
          <td><?= test_input($product["categoryName"]) ?></td>
          <td><?= test_input($product["listPrice"]) ?></td>
            <td> <img
                        src="<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>" width=100 height=100>
            <td>
<button
    type="button"
    class="btn btn-primary btn-sm"
    data-bs-toggle="modal"
    data-bs-target="#editProductModal"
    data-id="<?= (int)$product['productID'] ?>"
    data-category="<?= (int)$product['categoryID'] ?>"
    data-code="<?= htmlspecialchars($product['productCode'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-name="<?= htmlspecialchars($product['productName'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-price="<?= htmlspecialchars((string)$product['listPrice'], ENT_QUOTES, 'UTF-8') ?>"
    data-information="<?= htmlspecialchars($product['information'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-description="<?= htmlspecialchars($product['short_description'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    data-status="<?= (int)$product['status'] ?>"
    data-quantity="<?= (int)$product['quantity'] ?>"
    data-stock="<?= htmlspecialchars($product['stock_status'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
>
    ✏️ Edit
</button> |

               
         <a href="index.php?page=deleteProduct&productID=<?= $product['productID'] ?>" onclick="return confirm('Delete?')">🗑️ Delete</a>
                </td>
         
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="index.php?page=product&product_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a
            href="index.php?page=product&product_page=<?= $i ?>"
            <?= $i === $current_page ? 'style="font-weight:bold;"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=product&product_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>

    </div>
</div>


<!-- Edit modal in procedual programing in php -->

<div class="modal fade" id="editProductModal" tabindex="-1"
     aria-labelledby="editProductModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="POST" action="index.php?page=products">
             <input type="hidden" name="productID" id="edit-productID">

                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">
                        Edit Product
                    </h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="productID" id="edit-productID">

                    <div class="mb-3">
                        <label class="form-label">Category ID</label>
<select name="categoryID" id="edit-categoryID"
        required class="form-select">

    <option value="">-- Select Category --</option>

    <?php 
$categories = get_categories();
    foreach ($categories as $category): ?>
        <option value="<?= (int)$category['categoryID'] ?>">
            <?= htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8') ?>
        </option>
    <?php endforeach; ?>

</select>



                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Code</label>
                        <input type="text" name="productCode"
                               id="edit-productCode" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                <input type="text" name="productName"
       id="edit-productName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">List Price</label>
                        <input type="number" step="0.01" min="0"
                               name="listPrice" id="edit-listPrice"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Information</label>
                        <textarea name="information" id="edit-information"
                                  class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description"
                                  id="edit-short_description"
                                  class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit-status"
                                class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" min="0" name="quantity"
                               id="edit-quantity" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock Status</label>
                        <select name="stock_status" id="edit-stock_status"
                                class="form-select">
                            <option value="In Stock">In Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                            <option value="Preorder">Preorder</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" name="updateProduct"
                            class="btn btn-primary">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



    <script>
// Modal JS



const editProductModal = document.getElementById('editProductModal');

editProductModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    document.getElementById('edit-productID').value =
        button.getAttribute('data-id') || '';

    document.getElementById('edit-categoryID').value =
        button.getAttribute('data-category') || '';

    document.getElementById('edit-productCode').value =
        button.getAttribute('data-code') || '';

    document.getElementById('edit-productName').value =
        button.getAttribute('data-name') || '';

    document.getElementById('edit-listPrice').value =
        button.getAttribute('data-price') || '';

    document.getElementById('edit-information').value =
        button.getAttribute('data-information') || '';

    document.getElementById('edit-short_description').value =
        button.getAttribute('data-description') || '';

    // Set current status
    document.getElementById('edit-status').value =
        button.getAttribute('data-status') || '0';

    document.getElementById('edit-quantity').value =
        button.getAttribute('data-quantity') || '0';

    // Set current stock status
    document.getElementById('edit-stock_status').value =
        button.getAttribute('data-stock') || 'In Stock';

        console.log('Category ID:', button.getAttribute('data-category'));
console.log(
    'Available options:',
    [...document.getElementById('edit-categoryID').options]
        .map(option => option.value)
);
});

</script>