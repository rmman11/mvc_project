<?php
include("config/config.php");

global $db;

// Your customer query
$stmt = $db->query("
    SELECT
        c.id,
        c.customer_code,
        c.name,
        c.email,
        c.phone,
        c.avatar,
        c.status,
        c.created_at,
        COALESCE(o.order_count, 0) AS order_count,
        COALESCE(o.total_spent, 0) AS total_spent
    FROM customers c
    LEFT JOIN (
        SELECT
            customer_id,
            COUNT(*) AS order_count,
            SUM(total) AS total_spent
        FROM orders
        WHERE status = 'completed'
        GROUP BY customer_id
    ) o ON o.customer_id = c.id
    ORDER BY c.id
");

// Set download headers
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="customers_export.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// Open output stream
$output = fopen('php://output', 'w');

// UTF-8 BOM for correct Excel encoding
fwrite($output, "\xEF\xBB\xBF");

// CSV column headings
fputcsv($output, [
    'ID',
    'Customer Code',
    'Name',
    'Email',
    'Phone',
    'Avatar',
    'Status',
    'Created At',
    'Order Count',
    'Total Spent'
]);

// Export all database rows
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['id'],
        $row['customer_code'],
        $row['name'],
        $row['email'],
        $row['phone'],
        $row['avatar'],
        $row['status'],
        $row['created_at'],
        $row['order_count'],
        $row['total_spent']
    ]);
}

fclose($output);
exit;
?>
