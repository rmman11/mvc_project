<?php
$servername = "localhost";
$username = "root";
$password = ""; //here you can set a password for database
$dbname = "learnphp";
try {
  $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function test_input($data) {
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



function register($username,$name, $email, $password)
{
    global $db;

    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = :email";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':email' => $email
    ]);

    if ($stmt->fetch()) {
        return "Email already exists!";
    }

    // Upload directory
    $targetDir = "uploads/users/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Check uploaded photo
    if (!isset($_FILES["photo"]) ||
        $_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        return "Error uploading photo.";
    }

    // Validate image
    $imageInfo = getimagesize($_FILES["photo"]["tmp_name"]);

    if ($imageInfo === false) {
        return "Invalid image file.";
    }

    $allowed = ["image/jpeg", "image/png", "image/gif"];

    if (!in_array($imageInfo["mime"], $allowed, true)) {
        return "Only JPG, PNG and GIF files allowed.";
    }

    // Generate unique filename
    $extension = image_type_to_extension($imageInfo[2], false);
    $photoName = bin2hex(random_bytes(16)) . "." . $extension;

    $targetFile = $targetDir . $photoName;

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        return "Error saving photo.";
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "INSERT INTO users (username,name, email, photo, password)
            VALUES (:username, :name,:email, :photo, :password)";

    try {
        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            ':username' => $username,
            ':name'     =>$name,
            ':email' => $email,
            ':photo' => $targetFile,
            ':password' => $hashedPassword
        ]);

        if ($result) {
            return true;
        }

    } catch (PDOException $e) {
        // Remove uploaded file if database insert fails
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        return "Database error.";
    }

    return false;
}

 

 /*** functinea de logare in aplicatie facand legatura cu baza de date***/


function login($username, $password) {

    global $db;

    // Search user by email
    $sql = "SELECT * FROM users WHERE username = :username";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        ':username' => $username
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        return true;
    }

    return false;
}



function requireAdmin()
{
    if (!isset($_SESSION['user_id']) ||
        $_SESSION['role'] !== 'admin') {

        header("Location: index.php?page=login");
        exit();
    }
}




function requireUser()
{
    if (!isset($_SESSION['user_id']) ||
        $_SESSION['role'] !== 'user') {

        header("Location: index.php?page=login");
        exit();
    }
}


/**
 * Function to get Users  to display all from table users
 */
function getUsers($db) {
    $sql = "SELECT id,name,username,email,photo,created_at FROM users";
    $result = $db->query($sql);

    $categories = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    return $categories;
}


function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
