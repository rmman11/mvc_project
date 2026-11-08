
<?php

include("templates/header.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$currentPage = $_GET['page'] ?? 'home';


/*--------------here applay an database for our application and  model-------------------------*/
include("config/config.php");
include("model/users_db.php");
include("model/category_db.php");
include("model/product_db.php");
include("model/brand_db.php");
include("model/customer_db.php");
include("model/email_db.php");

$adminPages = ['users', 'product', 'category', 'brand', 'customer','email'];


?>
  <div class="wrapper">
 <?php 

include('templates/navbar.php');

  ?>

   <strong><h2><?= $title ?></h2></strong>
    <?php
      // Get page name from URL
      $page = isset($_GET['page']) ? $_GET['page'] : 'home';

     // Load the appropriate file if it exists

if($page=='data' && file_exists('pages/data_base.php')){

include('pages/data_base.php');

      }


      elseif ($page == 'product' && file_exists('pages/product.php')) {
        include('pages/product.php');

        }elseif ($page == 'register' && file_exists('pages/register.php')) {
        include('pages/register.php');


  
 }elseif ($page == 'login' && file_exists('pages/login.php')) {
        include('pages/login.php');

}elseif ($page == 'logout' && file_exists('pages/logout.php')) {
        include('pages/logout.php');

  
 }

elseif ($page == 'users' && file_exists('pages/users.php')) {
        include('pages/users.php');

}

elseif ($page == 'profile' && file_exists('pages/profile.php')) {
        include('pages/profile.php');

}


elseif ($page == 'contact' && file_exists('pages/contact.php')) {
        include('pages/contact.php');

}


elseif ($page == 'email' && file_exists('pages/email_list.php')) {
        include('pages/email_list.php');

}


 elseif ($page == 'category' && file_exists('pages/category.php')) {
        include('pages/category.php');

}elseif ($page == 'deleteUsers' && file_exists('pages/deleteUsers.php')) {
        include('pages/deleteUsers.php');
}
elseif ($page == 'deleteCategory' && file_exists('pages/deleteCategory.php')) {
        include('pages/deleteCategory.php');  
  
 }elseif ($page == 'deleteProduct' && file_exists('pages/deleteProduct.php')) {
        include('pages/deleteProduct.php');

        }
        elseif ($page == 'deleteCustomer' && file_exists('pages/deleteCustomer.php')) {
        include('pages/deleteCustomer.php');


        }elseif ($page == 'deleteBrand' && file_exists('pages/deleteBrand.php')){
            include('pages/deleteBrand.php');

        } elseif ($page == 'brand' && file_exists('pages/brand.php')) {
        include('pages/brand.php');
    } 
    elseif ($page == 'view_brand' && file_exists('pages/view_brand.php')) {
        include('pages/view_brand.php'); 

 }elseif ($page == 'weather' && file_exists('pages/weather.php')) {
        include('pages/weather.php');
          

 } elseif($page == 'home' && file_exists('pages/home.php')){
       include('pages/home.php');



      }elseif($page == 'customer' && file_exists('pages/customer.php')){
       include('pages/customer.php');
      }elseif($page == 'dashboard_admin' && file_exists('pages/dashboard_admin.php')){
       include('pages/dashboard_admin.php');
   }

      
      
    ?>
      <?php 
include('templates/footer.php');
?>
  </div>


</body>
</html>
