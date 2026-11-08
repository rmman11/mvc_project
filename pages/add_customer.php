
<?php
global $db;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $status = $_POST['status'] ?? 'active';

    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !in_array($status, ['active', 'blocked'], true)
    ) {
        $error = 'Enter a valid name, email and status.';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO customers
                    (name, email, phone, status)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $name,
                $email,
                $phone ?: null,
                $status
            ]);

            $id = (int) $pdo->lastInsertId();
            $code = 'CUST-' . str_pad(
                (string) $id,
                3,
                '0',
                STR_PAD_LEFT
            );

            $update = $pdo->prepare(
                "UPDATE customers
                 SET customer_code = ?
                 WHERE id = ?"
            );
            $update->execute([$code, $id]);

            header('Location: customers.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $error = 'This email address already exists.';
            } else {
                error_log($e->getMessage());
                $error = 'Could not save the customer.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm p-6">
    <h1 class="text-2xl font-bold mb-6">Add Customer</h1>

    <?php if ($error): ?>
        <p class="text-red-600 mb-4">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block mb-1">Customer Name</label>
            <input name="name" required maxlength="150"
                   value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   class="w-full border rounded-lg p-3">
        </div>

        <div>
            <label class="block mb-1">Email</label>
            <input type="email" name="email" required maxlength="190"
                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   class="w-full border rounded-lg p-3">
        </div>

        <div>
            <label class="block mb-1">Phone</label>
            <input name="phone" maxlength="30"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   class="w-full border rounded-lg p-3">
        </div>

        <div>
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border rounded-lg p-3">
                <option value="active">Active</option>
                <option value="blocked">Blocked</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white rounded-lg px-5 py-3">
                Save Customer
            </button>

            <a href="customers.php"
               class="border rounded-lg px-5 py-3">
                Cancel
            </a>
        </div>
    </form>
</div>

</body>
</html>
