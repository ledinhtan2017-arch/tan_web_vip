<?php
require_once('database.php');

function get_products_by_category($category_name) {
    $db = get_db();
    $query = 'SELECT p.productID, p.categoryID, p.productCode, p.productName, p.listPrice
              FROM products p
              JOIN categories c ON p.categoryID = c.categoryID
              WHERE c.categoryName = :category_name
              ORDER BY p.productName';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category_name);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $products;
}

function add_product($category_id, $product_code, $product_name, $list_price) {
    $db = get_db();
    $query = 'INSERT INTO products (categoryID, productCode, productName, listPrice)
              VALUES (:category_id, :product_code, :product_name, :list_price)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':product_code', $product_code);
    $statement->bindValue(':product_name', $product_name);
    $statement->bindValue(':list_price', $list_price);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function delete_product($product_id) {
    $db = get_db();
    $query = 'DELETE FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

function get_product_by_name($product_name) {
    $db = get_db();
    $query = 'SELECT productID, categoryID, productCode, productName, listPrice
              FROM products
              WHERE productName = :product_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_name', $product_name);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $product;
}

function get_category_id($category_name) {
    $db = get_db();
    $query = 'SELECT categoryID FROM categories WHERE categoryName = :category_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category_name);
    $statement->execute();
    $category = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    if ($category) {
        return $category['categoryID'];
    }
    return false;
}
?>

