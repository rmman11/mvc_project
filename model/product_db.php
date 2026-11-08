<?php

function get_products_by_category($category_id){

	global $db;

	$query = "SELECT *FROM products 
	          WHERE products.categoryID ='$category_id' 
	          ORDER BY productID";
	 $products = $db->query($query);
	 return $products;         
}
function get_product($product_id){

	  global $db;

	  $query = "SELECT * FROM products
	            WHERE productID = '$product_id'";

	   $product = $db->query($query);
	   $product = product->fetch();
	   return $product;

}


function get_products_page($page, $per_page = 5) {
    global $db;

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $per_page;

$query = "SELECT *
          FROM products
          LEFT JOIN categories
              ON products.categoryID = categories.categoryID
          ORDER BY products.productID, categories.categoryID
          LIMIT :limit OFFSET :offset";

    $statement = $db->prepare($query);
    $statement->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();

    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $products;
}


function get_product_count() {
    global $db;

    $query = "SELECT COUNT(*) FROM products";
    $statement = $db->query($query);

    $count = $statement->fetchColumn();
    $statement->closeCursor();

    return (int) $count;
}


function add_product(
    $category_id,
    $code,
    $name,
    $price,
    $information,
    $short_description,
    $status,
    $quantity,
    $stock_status,
     $image = null,
    $old_price = null

) {
    global $db;






    $query = "INSERT INTO products (
                categoryID,
                productCode,
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
              VALUES (
                :category_id,
                :code,
                :name,
                :price,
                :information,
                :short_description,
                :status,
                :quantity,
                :stock_status,
                :image,
                :old_price
              )";

    $statement = $db->prepare($query);

    $statement->execute([
        ':category_id'       => $category_id,
        ':code'              => $code,
        ':name'              => $name,
        ':price'             => $price,
        ':information'       => $information,
        ':short_description' => $short_description,
        ':status'            => $status,
        ':quantity'          => $quantity,
         ':stock_status'      => $stock_status,
         ':image' => $image,
        ':old_price' => $old_price
    ]);

    $statement->closeCursor();

    return true;
}



function getProduct($product_id) {
    global $db;
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function updateProduct(
    $categoryID,
    $productCode,
    $productName,
    $listPrice,
    $information,
    $short_description,
    $status,
    $quantity,
    $stock_status
) {


    global $db;
    $sql = "UPDATE products SET
                categoryID = :categoryID,
                productName = :productName,
                listPrice = :listPrice,
                information = :information,
                short_description = :short_description,
                status = :status,
                quantity = :quantity,
                stock_status = :stock_status
            WHERE productCode = :productCode";

    $stmt = $db->prepare($sql);

    return $stmt->execute([
        ':categoryID'        => $categoryID,
        ':productCode'       => $productCode,
        ':productName'       => $productName,
        ':listPrice'         => $listPrice,
        ':information'       => $information,
        ':short_description' => $short_description,
        ':status'            => $status,
        ':quantity'          => $quantity,
        ':stock_status'      => $stock_status
    ]);
}



function delete_product($productID) {
    global $db;

    $query = "DELETE FROM products WHERE productID = :productID";
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID, PDO::PARAM_INT);

    $statement->execute();

    $deleted = $statement->rowCount() > 0;
    $statement->closeCursor();

    return $deleted;
}

/*function updateProduct($product_id,$name,$description,$price,$quantity_in_stock){

     global $db;
    $stmt = $db->prepare("UPDATE products SET name =?,description =?,price = ?,quantity_in_stock=? WHERE product_id =?");
    $stmt->bind_param("ssssi", $name,$description, $price, $quantity_in_stock,$product_id);
   if ($stmt->execute()) {
        return true;  // Insert successful
    } else {
        return false; // Insert failed
    }

}*/
