<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$message = "";

$username = $password = "";
$username_err = $password_err = "";



// Handle create
if (isset($_POST['register'])) {
    if (register($_POST['username'],$_POST['name'],$_POST['email'],$_POST['password'])) {
        $message = "register";
          header("Location: index.php?page=register");
    }
}


  
?>


  <section class="py-16">
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
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="register" value="Submit">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</section>

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