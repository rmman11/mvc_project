
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learnphp";

try {

    // Database connection
    $db = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo "Database connected successfully!<br><br>";

    // SQL tables
    $tables = [

        // BRANDS
        "CREATE TABLE IF NOT EXISTS brands (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) NOT NULL,
            image VARCHAR(100) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        // CATEGORIES
        "CREATE TABLE IF NOT EXISTS categories (
            categoryID INT(11) AUTO_INCREMENT PRIMARY KEY,
            categoryName VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        // CONTACTS
        "CREATE TABLE IF NOT EXISTS contacts (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) DEFAULT NULL,
            email VARCHAR(100) DEFAULT NULL,
            subject VARCHAR(20) DEFAULT NULL,
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        // CUSTOMERS
        "CREATE TABLE IF NOT EXISTS customers (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            customer_code VARCHAR(20) DEFAULT NULL,
            name VARCHAR(150) NOT NULL,
            email VARCHAR(190) NOT NULL,
            phone VARCHAR(30) DEFAULT NULL,
            avatar VARCHAR(255) DEFAULT NULL,
            status ENUM('active','blocked') NOT NULL DEFAULT 'active',
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        // PRODUCTS
        "CREATE TABLE IF NOT EXISTS products (
            productID INT(14) NOT NULL AUTO_INCREMENT,
            productCode VARCHAR(100) NOT NULL,
            categoryID INT(11) NOT NULL,
            productName VARCHAR(100) NOT NULL,
            listPrice VARCHAR(100) NOT NULL,
            information VARCHAR(250) NOT NULL,
            short_description VARCHAR(50) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'Activ',
            quantity INT(11) NOT NULL,
            stock_status VARCHAR(50) NOT NULL DEFAULT 'in_stock',
            image VARCHAR(255) DEFAULT NULL,
            old_price DECIMAL(10,2) DEFAULT NULL,
            PRIMARY KEY (productID)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

        // ORDERS
        "CREATE TABLE IF NOT EXISTS orders (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            customer_id INT(10) UNSIGNED NOT NULL,
            total DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            status VARCHAR(30) NOT NULL DEFAULT 'completed',
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX (customer_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

        // USERS
        "CREATE TABLE IF NOT EXISTS users (
            id INT(11) NOT NULL AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            photo VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            role ENUM('admin','user') NOT NULL DEFAULT 'user',
            two_factor_secret VARCHAR(255) DEFAULT NULL,
            two_factor_pending_secret VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY username (username),
            UNIQUE KEY email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"

    ];

    // Generate all tables
    foreach ($tables as $sql) {

        $db->exec($sql);

    }

    echo "<h3 style='color:green;'>All database tables created successfully!</h3>";


} catch (PDOException $e) {

    echo "<h3 style='color:red;'>Database error:</h3>";
    echo $e->getMessage();

}

// Close PDO connection
$db = null;

?>
    <button onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER'] ?? 'index.php'; ?>'">
    Go Back
</button>