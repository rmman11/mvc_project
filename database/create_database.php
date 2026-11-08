
<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $host = trim($_POST['host'] ?? 'localhost');
    $dbname = trim($_POST['dbname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {

        // Connect to MySQL server (without selecting a database)
        $pdo = new PDO(
            "mysql:host=$host;charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );

        // Validate database name
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $dbname)) {
            throw new Exception("Invalid database name!");
        }

        // Create database
        $pdo->exec(
            "CREATE DATABASE IF NOT EXISTS `$dbname`
             CHARACTER SET utf8mb4
             COLLATE utf8mb4_unicode_ci"
        );

        $message = "Database '$dbname' created successfully!";

    } catch (Throwable $e) {

        $message = "Error: " . $e->getMessage();

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create MySQL Database</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 450px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #198754;
            color: white;
            border: none;
            cursor: pointer;
        }

        .message {
            padding: 12px;
            background: #e5f5e9;
            margin-bottom: 15px;
        }
        .back-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.back-btn:hover {
    background-color: #0056b3;
}
    </style>
</head>

<body>

<div class="container">

    <h2>Create MySQL Database</h2>

    <?php if ($message): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Database Host</label>
        <input type="text" name="host"
               value="localhost" required>

        <label>Database Name</label>
        <input type="text" name="dbname"
               placeholder="learnphp" required>

        <label>MySQL Username</label>
        <input type="text" name="username"
               value="root" required>

        <label>MySQL Password</label>
        <input type="password" name="password">

        <button type="submit">
            Create Database
        </button>

    </form>
<button onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER'] ?? 'index.php'; ?>'">
    Go Back
</button>
</div>

</body>
</html>
