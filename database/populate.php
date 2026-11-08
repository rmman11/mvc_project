
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../vendor/autoload.php'; // Make sure Faker is installed via Composer

use Faker\Factory;

// Faker generator
$faker = Factory::create('en_US');

// Database connection
$host = "localhost";
$dbname = "learnphp";
$username = "root";
$password = "";

try {

    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    $db->beginTransaction();

    // =====================================
    // 1. BRANDS - Generate 10 brands
    // =====================================

    $brandNames = [];

    for ($i = 0; $i < 10; $i++) {

        $name = ucfirst($faker->unique()->words(2, true));

        $slug = strtolower(str_replace(' ', '-', $name));

        $stmt = $db->prepare("
            INSERT INTO brands (name, slug, image)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $slug,
            'uploads/default.jpg'
        ]);

        $brandNames[] = $name;
    }


    // =====================================
    // 2. CATEGORIES - Generate 10 categories
    // =====================================

    $categoryIds = [];

    for ($i = 0; $i < 10; $i++) {

        $categoryName = ucfirst($faker->unique()->words(2, true));

        $stmt = $db->prepare("
            INSERT INTO categories (categoryName)
            VALUES (?)
        ");

        $stmt->execute([$categoryName]);

        $categoryIds[] = $db->lastInsertId();
    }


    // =====================================
    // 3. CUSTOMERS - Generate 30 customers
    // =====================================

    $customerIds = [];

    for ($i = 0; $i < 30; $i++) {

        $stmt = $db->prepare("
            INSERT INTO customers
            (customer_code, name, email, phone, avatar, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            'CUS-' . strtoupper($faker->unique()->bothify('????####')),
            $faker->name(),
            $faker->unique()->safeEmail(),
            $faker->phoneNumber(),
            'uploads/default.jpg',
            $faker->randomElement(['active', 'blocked'])
        ]);

        $customerIds[] = $db->lastInsertId();
    }


    // =====================================
    // 4. USERS - Generate 20 users
    // =====================================

    for ($i = 0; $i < 20; $i++) {

        $stmt = $db->prepare("
            INSERT INTO users
            (username, name, email, photo, password, role)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $faker->unique()->userName(),
            $faker->name(),
            $faker->unique()->safeEmail(),
            'uploads/users/default.jpg',
            password_hash('Password123!', PASSWORD_DEFAULT),
            ($i === 0 ? 'admin' : 'user')
        ]);
    }


    // =====================================
    // 5. PRODUCTS - Generate 50 products
    // =====================================

    for ($i = 0; $i < 50; $i++) {

        $price = $faker->randomFloat(2, 10, 1000);

        $oldPrice = $price + $faker->randomFloat(2, 10, 200);

        $stmt = $db->prepare("
            INSERT INTO products
            (
                productCode,
                categoryID,
                productName,
                listPrice,
                information,
                short_description,
                status,
                quantity,
                stock_status,
                image,
                old_price
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $quantity = $faker->numberBetween(0, 100);

        $stmt->execute([
            'PRD-' . strtoupper($faker->unique()->bothify('????####')),
            $faker->randomElement($categoryIds),
            $faker->words(3, true),
            number_format($price, 2, '.', ''),
            $faker->text(200),
            $faker->text(45),
            'Activ',
            $quantity,
            ($quantity > 0 ? 'in_stock' : 'out_of_stock'),
            'uploads/products/default.jpg',
            number_format($oldPrice, 2, '.', '')
        ]);
    }


    // =====================================
    // 6. ORDERS - Generate 50 orders
    // =====================================

    for ($i = 0; $i < 50; $i++) {

        $stmt = $db->prepare("
            INSERT INTO orders
            (customer_id, total, status)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $faker->randomElement($customerIds),
            $faker->randomFloat(2, 20, 5000),
            $faker->randomElement([
                'completed',
                'pending',
                'processing',
                'cancelled'
            ])
        ]);
    }


    // =====================================
    // 7. CONTACTS - Generate 20 messages
    // =====================================

    for ($i = 0; $i < 20; $i++) {

        $stmt = $db->prepare("
            INSERT INTO contacts
            (name, email, subject, message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $faker->name(),
            $faker->safeEmail(),
            $faker->randomElement([
                'Support',
                'Question',
                'Order',
                'Information'
            ]),
            $faker->paragraph()
        ]);
    }


    // Commit all inserts
    $db->commit();

    echo "<h2 style='color:green'>Database populated successfully!</h2>";

    echo "<p>10 Brands created</p>";
    echo "<p>10 Categories created</p>";
    echo "<p>30 Customers created</p>";
    echo "<p>20 Users created</p>";
    echo "<p>50 Products created</p>";
    echo "<p>50 Orders created</p>";
    echo "<p>20 Contacts created</p>";

    echo "<h3>Total: 190 records created!</h3>";

} catch (PDOException $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }

    die("Database error: " . $e->getMessage());
}

$db = null;

?>
    <button onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER'] ?? 'index.php'; ?>'">
    Go Back
</button>