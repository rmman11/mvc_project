<?php
function get_customers_page($page, $per_page = 5) {
    global $db;

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $per_page;

    /*$query = "SELECT * FROM  customers
              ORDER BY id
              LIMIT :limit OFFSET :offset";*/




  $query = "
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
    ORDER BY id
     LIMIT :limit OFFSET :offset
";


    $statement = $db->prepare($query);
    $statement->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();

    $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $customers;
}

function get_customers_count() {
    global $db;

    $query = "SELECT COUNT(*) FROM  customers";
    $statement = $db->query($query);

    $count = $statement->fetchColumn();
    $statement->closeCursor();

    return (int) $count;
}


function add_customer($customer_code,$name,$email,$phone,$status) {
    global $db;



    $query = "INSERT INTO customers (
                customer_code,name,email,phone,status
              )
              VALUES (
                :customer_code,
                :name,
                :email,
                :phone,
                :status
              )";

    $statement = $db->prepare($query);

    $statement->execute([
        ':customer_code' => $customer_code,
        ':name'       => $name,
        ':email'              => $email,
        ':phone'              => $phone,
        ':status'             => $status
    ]);

    $statement->closeCursor();

    return true;
}
/**************upate customers-------------------*/
function update_customers(PDO $db, int $id, array $data): bool
{
    $sql = "UPDATE customers SET
                customer_code = :customer_code,
                name = :name,
                email = :email,
                phone = :phone,
                status = :status
            WHERE id = :id";

    $stmt = $db->prepare($sql);

    return $stmt->execute([
        ':customer_code' => $data['customer_code'],
        ':name'          => $data['name'],
        ':email'         => $data['email'],
        ':phone'         => $data['phone'],
        ':status'        => $data['status'],
        ':id'            => $id
    ]);
}




/*------------------function for customer in php-------------------------------*/

function  deleteCustomer($id){

  global $db;

    $query = "DELETE FROM customers WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $deleted = $statement->rowCount() > 0;
    $statement->closeCursor();

    return $deleted;    


}
