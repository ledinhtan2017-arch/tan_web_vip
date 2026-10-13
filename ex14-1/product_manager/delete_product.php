<?php
require_once __DIR__ . '/../model/product_db.php';

$productDB = new ProductDB();
$productID = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$categoryID = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
if ($productID > 0) {
    $productDB->deleteProduct($productID);
}

header('Location: index.php?category_id=' . $categoryID);
exit;
?>
