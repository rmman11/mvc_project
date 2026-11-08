<?php

function  get_categories(){
	
	global $db;
	$query ='SELECT categoryID, categoryName FROM categories ORDER BY categoryName';
	$result = $db->query($query);
	return $result;
}

function get_category_name($categoryID) {
    global $db;

    $query = 'SELECT categoryID,categoryName
              FROM categories
              WHERE categoryID = :categoryID';

    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();

    $category = $statement->fetch();
    $statement->closeCursor();

    return $category['categoryName'];
}


function add_category($category_name) {
    global $db;

    $query = "INSERT INTO categories (categoryName, created_at)
              VALUES (:category_name, NOW())";

    $statement = $db->prepare($query);
    $statement->execute([
        ':category_name' => $category_name
    ]);

    $statement->closeCursor();
}




/* function to delete in category **/


function  deleteCategory($categoryID){

  global $db;

    $query = "DELETE FROM categories WHERE categoryID = :categoryID";
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);

    $statement->execute();

    $deleted = $statement->rowCount() > 0;
    $statement->closeCursor();

    return $deleted;    


}
