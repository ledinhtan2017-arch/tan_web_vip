<?php
require_once __DIR__ . '/../database.php';

function get_categories() {
    $conn = get_db_connection();
    $result = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
    return $categories;
}

function add_category($categoryName) {
    $categoryName = trim($categoryName);
    if ($categoryName === '') {
        return false;
    }

    $conn = get_db_connection();
    $stmt = mysqli_prepare($conn, 'INSERT INTO categories (categoryName) VALUES (?)');
    mysqli_stmt_bind_param($stmt, 's', $categoryName);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

function delete_category($categoryId) {
    $categoryId = (int)$categoryId;
    if ($categoryId <= 0) {
        return false;
    }

    $conn = get_db_connection();

    $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE categoryID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, 'DELETE FROM categories WHERE categoryID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}
?>
