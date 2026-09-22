<?php
require_once 'database.php';

$conn = get_db_connection();

$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;

if ($productId > 0) {
    $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE productID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header('Location: index.php?category_id=' . $categoryId);
exit;
