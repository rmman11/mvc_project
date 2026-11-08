
<?php


if (($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}




$current_page = max(1, (int) ($_GET['email_page'] ?? 1));
$per_page = 5;

$total_products = get_email_count();
$total_pages = (int) ceil($total_products / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$messages = get_email_page($current_page, $per_page);


?>


<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">

<div>
                        <h1 class="text-2xl font-bold text-gray-800">List email contacts</h1>
                        <p class="text-sm text-gray-500">Manage email data</p>
                    </div>
                    </div>

<table border="0" cellpadding="0">

    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
    </tr>

    <?php foreach ($messages as $msg): ?>
<tbody class="divide-y divide-gray-100">
    <tr>
        <td><?= htmlspecialchars($msg['name']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['subject']) ?></td>
        <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
        <td><?= htmlspecialchars($msg['created_at']) ?></td>
    </tr>

    <?php endforeach; ?>
    </tbody>
</table>


<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="index.php?page=email&email_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a
            href="index.php?page=email&email_page=<?= $i ?>"
            <?= $i === $current_page ? 'style="font-weight:bold;"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=email&email_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>
    </main>


