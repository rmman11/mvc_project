<?php

function get_users($user_id){

	  global $db;

	  $query = "SELECT * FROM users
	            WHERE id = '$user_id'";

	   $product = $db->query($query);
	   $product = product->fetch();
	   return $product;

}


function get_users_page($page, $per_page = 5) {
    global $db;

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $per_page;

    $query = "SELECT * FROM users
              ORDER BY id
              LIMIT :limit OFFSET :offset";

    $statement = $db->prepare($query);
    $statement->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();

    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $products;
}


function get_users_count() {
    global $db;

    $query = "SELECT COUNT(*) FROM users";
    $statement = $db->query($query);

    $count = $statement->fetchColumn();
    $statement->closeCursor();

    return (int) $count;
}

function deleteUsers($id) {
    global $db;

    $query = "DELETE FROM users WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $deleted = $statement->rowCount() > 0;
    $statement->closeCursor();

    return $deleted;
}