
<?php

global $db;



// Search
$search = trim($_GET['search'] ?? '');
$status = $_GET['status'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$allowedStatuses = ['', 'active', 'blocked'];
if (!in_array($status, $allowedStatuses, true)) {
    $status = '';
}

$sortOptions = [
    'newest' => 'c.created_at DESC, c.id DESC',
    'oldest' => 'c.created_at ASC, c.id ASC',
    'spent' => 'total_spent DESC, c.id DESC'
];

$orderBy = $sortOptions[$sort] ?? $sortOptions['newest'];

// Build safe filters
$where = [];
$params = [];

if ($search !== '') {
    $where[] = "(c.name LIKE :name
        OR c.email LIKE :email
        OR c.phone LIKE :phone)";

    $term = '%' . $search . '%';
    $params['name'] = $term;
    $params['email'] = $term;
    $params['phone'] = $term;
}

if ($status !== '') {
    $where[] = 'c.status = :status';
    $params['status'] = $status;
}

$whereSql = $where
    ? 'WHERE ' . implode(' AND ', $where)
    : '';

// Count matching customers for pagination
$countSql = "SELECT COUNT(*)
             FROM customers c $whereSql";

$stmt = $db->prepare($countSql);
$stmt->execute($params);
$totalCustomers = (int) $stmt->fetchColumn();

$perPage = 3;
$totalPages = max(
    1,
    (int) ceil($totalCustomers / $perPage)
);

$page = filter_var(
    $_GET['page'] ?? 1,
    FILTER_VALIDATE_INT
);

$page = max(1, min($totalPages, $page ?: 1));
$offset = ($page - 1) * $perPage;

// Fetch customers and calculate their order statistics
$sql = "
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
    $whereSql
    ORDER BY $orderBy
    LIMIT $perPage OFFSET $offset
";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$customers = $stmt->fetchAll();



function initials(string $name): string {
    $parts = preg_split('/\s+/', trim($name));
    $result = '';

    foreach (array_slice($parts, 0, 2) as $part) {
        $result .= mb_substr($part, 0, 1);
    }

    return mb_strtoupper($result);
}

function customerCode(array $customer): string {
    return $customer['customer_code']
        ?: 'CUST-' . str_pad(
            (string) $customer['id'],
            3,
            '0',
            STR_PAD_LEFT
        );
}


$first = $totalCustomers ? $offset + 1 : 0;
$last = min($offset + $perPage, $totalCustomers);





$current_page = max(1, (int) ($_GET['customer_page'] ?? 1));
$per_page = 5;

$total_customer = get_customers_count();
$total_pages = (int) ceil($total_customer / $per_page);

$current_page = min($current_page, max(1, $total_pages));

$customers = get_customers_page($current_page, $per_page);



// Handle create
if (isset($_POST['add_customer'])) {

$customer_code = trim($_POST['customer_code'] ?? '');   
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$status = $_POST['status'] ?? 'active';

    if (add_customer($customer_code,$name,$email,$phone,$status)) {
        header("Location: index.php?page=customer");
        exit;
    }
}



if (isset($_GET['added']) && $_GET['added'] == 1) {
    echo "✅ customer added successfully!";
}


if (isset($_POST['update_customer'])) {



$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    $_SESSION['error'] = 'Invalid customer ID.';
    header('Location: customer');
    exit;
}

$data = [
    'customer_code' => trim($_POST['customer_code'] ?? ''),
    'name'          => trim($_POST['name'] ?? ''),
    'email'         => trim($_POST['email'] ?? ''),
    'phone'         => trim($_POST['phone'] ?? ''),
    'status'        => $_POST['status'] ?? ''
];

// Validate required fields
if (
    $data['customer_code'] === '' ||
    $data['name'] === '' ||
    !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
    !in_array($data['status'], ['active', 'inactive'], true)
) {
    $_SESSION['error'] = 'Please enter valid customer details.';
    header('Location: customer');
    exit;
}



if (update_customers($db, $id, $data)) {
        $_SESSION['success'] = 'Customer updated successfully.';
    } else {
        $_SESSION['error'] = 'Could not update customer.';
    }

}
?>




<main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Customers</h1>
                        <p class="text-sm text-gray-500">Manage registered users and customer data</p>
                    </div>
                    <div class="flex gap-3">
                       <form action="export.php" method="POST">
    <button type="submit"
        class="border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-file-export"></i>
        Export
    </button>
</form>

<button type="button"
        onclick="openCustomerModal()"
        class="bg-primary hover:bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
    <i class="fa-solid fa-plus"></i>
    Add Customer
</button>
                    </div>
                </div>

<form method="GET"
      action="customer"
      class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">

    <div class="flex flex-col md:flex-row gap-4">

        <input
            type="text"
            name="search"
            value="<?= e($search) ?>"
            placeholder="Name, Email or Phone..."
            class="w-full md:w-64 px-4 py-2 border rounded-lg text-sm"
        >

        <select name="status"  onchange="this.form.submit()"
                class="border px-3 py-2 rounded-lg text-sm bg-white">
            <option value="">All Status</option>
            <option value="active"
                <?= $status === 'active' ? 'selected' : '' ?>>
                Active
            </option>
            <option value="blocked"
                <?= $status === 'blocked' ? 'selected' : '' ?>>
                Blocked
            </option>
        </select>

        <select name="sort"
                class="border px-3 py-2 rounded-lg text-sm bg-white">
            <option value="newest"
                <?= $sort === 'newest' ? 'selected' : '' ?>>
                Newest First
            </option>
            <option value="oldest"
                <?= $sort === 'oldest' ? 'selected' : '' ?>>
                Oldest First
            </option>
            <option value="spent"
                <?= $sort === 'spent' ? 'selected' : '' ?>>
                Highest Spent
            </option>
        </select>

        <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg">
            Search
        </button>

        <a href="customers.php"
           class="border px-5 py-2 rounded-lg text-center">
            Reset
        </a>
    </div>
</form>


<?php
if (isset($_SESSION['success'])):
?>
    <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-700">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-4 rounded-lg bg-red-100 p-3 text-red-700">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>



 <table>
     
<tbody class="divide-y divide-gray-100">
<?php if (!$customers): ?>
    <tr>
        <td colspan="8"
            class="px-6 py-10 text-center text-gray-500">
            No customers found.
        </td>
    </tr>
<?php endif; ?>

<?php foreach ($customers as $customer): ?>
    <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4">
            <input type="checkbox"
                   name="selected[]"
                   value="<?= (int) $customer['id'] ?>"
                   class="rounded border-gray-300">
        </td>

        <td class="px-6 py-4">
            <div class="flex items-center gap-3">
                <?php if (!empty($customer['avatar'])): ?>
                    <img
                        src="<?= e($customer['avatar']) ?>"
                        alt="Customer"
                        class="w-10 h-10 rounded-full object-cover"
                    >
                <?php else: ?>
                    <div class="w-10 h-10 rounded-full
                                bg-blue-100 text-blue-600
                                flex items-center justify-center font-bold">
                        <?= e(initials($customer['name'])) ?>
                    </div>
                <?php endif; ?>

                <div>
                    <p class="font-semibold text-gray-800 text-sm">
                        <?= e($customer['name']) ?>
                    </p>
                    <p class="text-xs text-gray-500">
                        ID: #<?= e(customerCode($customer)) ?>
                    </p>
                </div>
            </div>
        </td>

        <td class="px-6 py-4">
            <p class="text-sm text-gray-700">
                <?= e($customer['email']) ?>
            </p>
            <p class="text-xs text-gray-500">
                <?= e($customer['phone']) ?>
            </p>
        </td>

        <td class="px-6 py-4 text-sm text-gray-600">
            <?= (int) $customer['order_count'] ?> Orders
        </td>

        <td class="px-6 py-4 text-sm font-bold text-gray-800">
            $<?= number_format(
                (float) $customer['total_spent'],
                2
            ) ?>
        </td>

        <td class="px-6 py-4">
            <?php if ($customer['status'] === 'active'): ?>
                <span class="bg-green-100 text-green-700
                             px-2.5 py-1 rounded-full text-xs font-semibold">
                    Active
                </span>
            <?php else: ?>
                <span class="bg-red-100 text-red-700
                             px-2.5 py-1 rounded-full text-xs font-semibold">
                    Blocked
                </span>
            <?php endif; ?>
        </td>

        <td class="px-6 py-4 text-sm text-gray-600">
            <?= e(date(
                'M d, Y',
                strtotime($customer['created_at'])
            )) ?>
        </td>

        <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
       

 <button
            type="button"
            onclick='openEditModal(<?= json_encode(
                $customer,
                JSON_HEX_TAG | JSON_HEX_APOS |
                JSON_HEX_QUOT | JSON_HEX_AMP
            ) ?>)'
            class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit
        </button>



         <a href="index.php?page=deleteCustomer&id=<?= $customer['id'] ?>" onclick="return confirm('Delete?')">🗑️ Delete</a>
            </div>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>


<div class="px-6 py-4 border-t border-gray-100
            flex flex-col sm:flex-row items-center
            justify-between gap-4">

    <span class="text-sm text-gray-500">
        Showing
        <strong class="text-gray-700">
            <?= $first ?>-<?= $last ?>
        </strong>
        of
        <strong class="text-gray-700">
            <?= $totalCustomers ?>
        </strong>
        customers
    </span>


<div class="pagination">
    <?php if ($current_page > 1) : ?>
        <a href="index.php?page=customer&customer_page=<?= $current_page - 1 ?>">
            Previous
        </a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
        <a
            href="index.php?page=customer&customer_page=<?= $i ?>"
            <?= $i === $current_page ? 'style="font-weight:bold;"' : '' ?>
        >
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a href="index.php?page=customer&customer_page=<?= $current_page + 1 ?>">
            Next
        </a>
    <?php endif; ?>
</div>
</div>
</div>
</div>


<!-- Add Customer Modal -->
<div id="addCustomerModal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">

        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b px-6 py-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Add Customer
                </h2>
                <p class="text-sm text-gray-500">
                    Enter the customer's information
                </p>
            </div>

            <button type="button"
                    onclick="closeCustomerModal()"
                    class="rounded-lg p-2 text-gray-500 hover:bg-gray-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="addCustomerForm" method="POST" enctype="multipart/form-data"  action="" class="form-control">

            <div class="space-y-4 p-6">


           <div>
                    <label class="block text-sm font-medium mb-1">
                        Customer Code
                    </label>
                    <input type="text" name="customer_code"
                         required
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Customer Name
                    </label>
                    <input type="text"
                           name="name"
                           required
                           maxlength="150"
                           placeholder="Enter full name"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <input type="email"
                           name="email"
                           required
                           maxlength="190"
                           placeholder="customer@example.com"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>
                    <input type="text"
                           name="phone"
                           maxlength="30"
                           placeholder="Enter phone number"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Status
                    </label>
                    <select name="status"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 focus:border-blue-500 focus:outline-none">
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                    </select>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4">
                <button type="button"
                        onclick="closeCustomerModal()"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700" name="add_customer">
                    <i class="fa-solid fa-plus mr-1"></i>
                    Save Customer
                </button>
            </div>

        </form>
    </div>
</div>





<div id="editCustomerModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">

    <div class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6">

        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl font-semibold text-gray-800">
                Edit Customer
            </h2>

            <button type="button"
                    onclick="closeEditModal()"
                    class="text-gray-500 hover:text-gray-800 text-2xl">
                &times;
            </button>
        </div>

        <form action="" method="POST">

            <input type="hidden" name="id" id="edit_id">

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Customer Code
                    </label>
                    <input type="text" name="customer_code"
                           id="edit_customer_code" required
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Full Name
                    </label>
                    <input type="text" name="name"
                           id="edit_name" required
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Email
                    </label>
                    <input type="email" name="email"
                           id="edit_email" required
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Phone
                    </label>
                    <input type="text" name="phone"
                           id="edit_phone"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Status
                    </label>
                    <select name="status" id="edit_status"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 border rounded-lg">
                    Cancel
                </button>

                <button type="submit" name="update_customer"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Customer
                </button>
            </div>

        </form>
    </div>
</div>



</main>
<script>
	const customerModal = document.getElementById('addCustomerModal');

function openCustomerModal() {
    customerModal.classList.remove('hidden');
    customerModal.classList.add('flex');
}

function closeCustomerModal() {
    customerModal.classList.add('hidden');
    customerModal.classList.remove('flex');
}

// Close when clicking the dark background
customerModal.addEventListener('click', function (event) {
    if (event.target === customerModal) {
        closeCustomerModal();
    }
});

// Close with the Escape key
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeCustomerModal();
    }
});


function openEditModal(customer) {
    document.getElementById('edit_id').value =
        customer.id ?? '';

    document.getElementById('edit_customer_code').value =
        customer.customer_code ?? '';

    document.getElementById('edit_name').value =
        customer.name ?? '';

    document.getElementById('edit_email').value =
        customer.email ?? '';

    document.getElementById('edit_phone').value =
        customer.phone ?? '';

    document.getElementById('edit_status').value =
        customer.status ?? 'active';

    const modal = document.getElementById('editCustomerModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editCustomerModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>