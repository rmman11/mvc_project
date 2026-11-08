<?php


     $currentPage = $_GET['page'] ?? 'home';

     $role = $_SESSION['role'] ?? 'guest';
     ?>



      <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="frontEnd/index.php">My  Project</a>
                </div>
            </div>
          <ul class="sidebar-nav">

        <?php if ($role === 'admin'): ?>


            <li class="sidebar-item <?= ($currentPage == 'users') ? 'active' : '' ?>"><a class="sidebar-link" href="users">Manage Users</a></li>
            <li class="sidebar-item <?= ($currentPage == 'email') ? 'active' : '' ?>"><a class="sidebar-link" href="email">Manage Email</a></li>
            <li class="sidebar-item  <?= ($currentPage == 'product') ? 'active' : '' ?>"> <a class="sidebar-link" href="product">Product</a></li>
            <li class="sidebar-item  <?= ($currentPage == 'category') ? 'active' : '' ?>"> <a class="sidebar-link" href="category">Category</a></li>
            <li class="sidebar-item <?= ($currentPage == 'brand') ? 'active' : '' ?>"> <a class="sidebar-link" href="brand">Brand</a></li>
            <li class="sidebar-item  <?= ($currentPage == 'customer') ? 'active' : '' ?>"> <a class="sidebar-link" href="customer">Customer</a></li>

            <li>
                <a class="sidebar-link"  href="index.php?page=logout">Logout</a>
            </li>


        <?php elseif ($role === 'user'): ?>
            <li class="sidebar-item <?= ($currentPage == 'home') ? 'active' : '' ?>"><a class="sidebar-link" href="home">Home</a></li>
  
            <li class="sidebar-item  <?= ($currentPage == 'weather') ? 'active' : '' ?>"> <a class="sidebar-link" href="weather">Weather</a></li>
            <li class="sidebar-item  <?= ($currentPage == 'profile') ? 'active' : '' ?>"><a class="sidebar-link" href="profile">My Profile</a></li>
             <li class="sidebar-item  <?= ($currentPage == 'contact') ? 'active' : '' ?>"><a class="sidebar-link" href="contact">Contact</a></li>
            <li> <a class="sidebar-link"  href="index.php?page=logout">Logout</a></li>


        <?php else: ?>
            <li class="sidebar-item <?= ($currentPage == 'login') ? 'active' : '' ?>"> <a class="sidebar-link" href="login">Login</a></li>
            <li class="sidebar-item <?= ($currentPage == 'register') ? 'active' : '' ?>"> <a class="sidebar-link" href="register">Register</a></li>
             <li class="sidebar-item <?= ($currentPage == 'data') ? 'active' : '' ?>"> <a class="sidebar-link" href="data">Install Database</a></li>
        <?php endif; ?>
    </ul>
</aside>

 
