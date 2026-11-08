<?php




function get_brand_page($page, $per_page = 5) {
    global $db;

    $page = max(1, (int) $page);
    $offset = ($page - 1) * $per_page;

    $query = "SELECT * FROM brands
              ORDER BY id
              LIMIT :limit OFFSET :offset";

    $statement = $db->prepare($query);
    $statement->bindValue(':limit', $per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();

    $brands = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $brands;
}

function view_brand($db)
{
    $select_brand = $db->prepare(
        "SELECT * FROM brands ORDER BY id DESC"
    );

    $select_brand->execute();

    while ($row = $select_brand->fetch(PDO::FETCH_ASSOC)) {
        $brand_id = (int) $row['id'];
        $brand_name = htmlspecialchars($row['name']);
        $brand_logo = htmlspecialchars($row['image'] ?? '');

        echo "<tr>";
        echo "<td>$brand_id</td>";
        echo "<td>$brand_name</td>";

        if (!empty($brand_logo)) {
            echo "<td><img src='$brand_logo'
                  width='60' alt='Brand logo'></td>";
        } else {
            echo "<td>No logo</td>";
        }

        echo "</tr>";
    }
}




/***************************************here is a function to add in new brand-----------------------------------*/
function add_brand($name,$slug,$image) {
    global $db;

    // Check whether the slug already exists
    $query = 'SELECT COUNT(*) FROM brands WHERE slug = :slug';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':slug', $slug);
    $stmt->execute();

      if ($stmt->fetchColumn() > 0) {
        return false; // Slug already exists
    }


    $query = "INSERT INTO brands (
               name,slug,image,created_at  
              )
              VALUES (
                :name,
                :slug,
                :image,
                :created_at  
              
              )";

    $stmt = $db->prepare($query);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':slug', $slug);
    $stmt->bindValue(':image', $image);
    $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
    $stmt->execute();

    return true;
}


/* function to delete in category **/


function  deleteBrand($id){

  global $db;

    $query = "DELETE FROM brands WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $deleted = $statement->rowCount() > 0;
    $statement->closeCursor();

    return $deleted;    


}
