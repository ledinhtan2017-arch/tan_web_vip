<?php
require_once __DIR__ . '/../database.php';

function get_products_by_category($categoryId) {
    $categoryId = (int)$categoryId;
    $conn = get_db_connection();
    $stmt = mysqli_prepare($conn, 'SELECT productID, categoryID, productCode, productName, listPrice FROM products WHERE categoryID = ? ORDER BY productName');
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $products;
}

function add_product($categoryId, $productCode, $productName, $listPrice) {
    $categoryId = (int)$categoryId;
    $productCode = trim($productCode);
    $productName = trim($productName);
    $listPrice = (float)$listPrice;

    if ($categoryId <= 0 || $productCode === '' || $productName === '' || $listPrice <= 0) {
        return false;
    }

    $conn = get_db_connection();
    $stmt = mysqli_prepare($conn, 'INSERT INTO products (categoryID, productCode, productName, listPrice) VALUES (?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'issd', $categoryId, $productCode, $productName, $listPrice);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

function delete_product($productId) {
    $productId = (int)$productId;
    if ($productId <= 0) {
        return false;
    }

    $conn = get_db_connection();
    $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE productID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

function get_product_by_id($productId) {
    $productId = (int)$productId;
    if ($productId <= 0) {
        return null;
    }

    $conn = get_db_connection();
    $stmt = mysqli_prepare($conn, 'SELECT productID, categoryID, productCode, productName, listPrice FROM products WHERE productID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $product ?: null;
}
?>
