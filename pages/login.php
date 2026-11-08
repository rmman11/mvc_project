<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


   $username = $password = "";
$username_err = $password_err = $login_err = "";

/*

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];



 if ($_SESSION['role'] === 'admin') {

        header("Location: index.php?page=admin");
        exit();

    } elseif ($_SESSION['role'] === 'user') {

        header("Location: index.php?page=home");
        exit();

    }




    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
 }



    */


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $username = trim($_POST['username']);
    $password = $_POST['password'];




 if (login($username, $password)) {

    if ($_SESSION['role'] === 'admin') {

        header("Location: index.php?page=dashboard_admin");
        exit();

    } elseif ($_SESSION['role'] === 'user') {

        header("Location: index.php?page=home");
        exit();

    }

} else {

    echo "Incorrect username or password!";
}



}

?>


  <section class="py-16">
    <div class="container mx-auto px-4">

        <form action="" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" value="<?php echo $username; ?>"   autofocus="autofocus" autocomplete="username">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>    
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"  autofocus="autofocus" autocomplete="password">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login" name="login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</section>

