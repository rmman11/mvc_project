<?php

function get_email($id){

	  global $db;

	  $query = "SELECT * FROM contacts
	            WHERE id = '$id'";

	   $product = $db->query($query);
	   $product = product->fetch();
	   return $product;

}


function get_email_page($page, $per_page = 5) {
    global $db;

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $per_page;

$query = "SELECT *
          FROM  contacts
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


function get_email_count() {
    global $db;

    $query = "SELECT COUNT(*) FROM contacts";
    $statement = $db->query($query);

    $count = $statement->fetchColumn();
    $statement->closeCursor();

    return (int) $count;
}
