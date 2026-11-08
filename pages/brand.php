<?php


$slug = $_GET['slug'] ?? '';
$current_page = max(1, (int) ($_GET['brand_page'] ?? 1));
$per_page = 3;

$total_products = get_product_count();
$total_pages = (int) ceil($total_products / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$brands = get_brand_page($current_page, $per_page);




if (isset($_POST['create'])) {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $image = trim($_POST['image'] ?? '');



$uploadDir = 'uploads/';

// Create directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$filename = bin2hex(random_bytes(16)) . '.jpg';

$destination = $uploadDir . $filename;

if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    $image = 'uploads/' . $filename;

    // Save $image to your database
    add_brand($name, $slug, $image);

} else {
    die('Image upload failed. Check the upload directory and permissions.');
}


    if ($name !== '') {
        add_brand($name,$slug,$image);

        header("Location: index.php?page=brand");
        exit;
    } else {
        $error = "Please enter a brand name.";
    }
}



if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    echo "✅ Record deleted successfully!";
}






?>






<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
  <div class="flex gap-3">

<h1>Our Brands</h1>

    <button type="button"  class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm"
        data-bs-toggle="modal" data-bs-target="#add_brand">
         <i class="fa-solid fa-plus"></i>
    Add Brand
</button>
</div>
</div>

 <!-- Modal -->
<div class="modal fade" id="add_brand" tabindex="-1"
     aria-labelledby="addProductLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

      <span class="close"  data-bs-dismiss="modal">&times;</span>

  <form method="POST" enctype="multipart/form-data"  action="" class="form-control" >




             <div class="form-group">
            <label>Name</label>
            <input type="text" name="name"  value=""  class="form-control">

            </div> 

           <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug"  value=""  class="form-control">

            </div> 
      
  <div class="form-group">
                <label for="image">Brand Image</label>
                <input type="file"
                       id="image"
                       name="image"
                       accept="image/jpeg,image/png,image/webp"
                       required>

                <img id="imagePreview" alt="Selected brand image preview">
            </div>


          <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

    <button type="submit"   class="btn btn-primary" name="create">Add Brand</button>
  </form>

</div>
      </div>
  </div>
    <div class="brands">
        <?php foreach ($brands as $brand): ?>
            <div class="brand-card">
                <?php if (!empty($brand['image'])): ?>
                    <img
                        src="<?= htmlspecialchars($brand['image'], ENT_QUOTES, 'UTF-8') ?>"
                        alt="<?= htmlspecialchars($brand['name'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                <?php endif; ?>

                <h2>
                    <?= htmlspecialchars($brand['name'], ENT_QUOTES, 'UTF-8') ?>
                </h2>

                <p>
                    Slug:
                    <?= htmlspecialchars($brand['slug'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <a href="index.php?page=view_brand&slug=<?= urlencode($brand['slug']) ?>">
                    View Brand
                </a>

         <a href="index.php?page=deleteBrand&id=<?= $brand['id'] ?>" onclick="return confirm('Delete?')">🗑️ Delete</a>
                </td>  
            </div>
        <?php endforeach; ?>

        <?php if (empty($brands)): ?>
            <p>No brands found. Add your first brand.</p>
        <?php endif; ?>
    </div>



<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="index.php?page=brand&brand_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a
            href="index.php?page=brand&brand_page=<?= $i ?>"
            <?= $i === $current_page ? 'style="font-weight:bold;"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=brand&brand_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>

</main>


<script>
const modal = document.getElementById('brandModal');

document.getElementById('openModal').addEventListener('click', () => {
    modal.classList.add('show');
});

document.getElementById('closeModal').addEventListener('click', () => {
    modal.classList.remove('show');
});

modal.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.classList.remove('show');
    }
});

// Automatically generate slug from brand name
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');

nameInput.addEventListener('input', () => {
    slugInput.value = nameInput.value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
});

// Preview selected image
document.getElementById('image').addEventListener('change', (event) => {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');

    if (!file) {
        preview.removeAttribute('src');
        preview.style.display = 'none';
        return;
    }

    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)
        || file.size > 2 * 1024 * 1024) {
        alert('Choose a JPG, PNG, or WebP image up to 2 MB.');
        event.target.value = '';
        preview.removeAttribute('src');
        preview.style.display = 'none';
        return;
    }

    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
});
</script>