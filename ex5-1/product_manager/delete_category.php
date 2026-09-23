<?php
require_once '../database.php';

$conn = get_db_connection();

$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

if ($categoryId > 0) {
    $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE categoryID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, 'DELETE FROM categories WHERE categoryID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header('Location: category_list.php');
exit;
