<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/product.php';

class ProductDB {
    public function getProductsByCategory($categoryID) {
        $categoryID = (int)$categoryID;
        $conn = get_db_connection();
        $stmt = mysqli_prepare($conn, 'SELECT productID, categoryID, productCode, productName, listPrice FROM products WHERE categoryID = ? ORDER BY productName');
        mysqli_stmt_bind_param($stmt, 'i', $categoryID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $product = new Product();
            $product->setID($row['productID']);
            $product->setCategoryID($row['categoryID']);
            $product->setCode($row['productCode']);
            $product->setName($row['productName']);
            $product->setPrice($row['listPrice']);
            $products[] = $product;
        }
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $products;
    }

    public function addProduct(Product $product) {
        if ($product->getCategoryID() <= 0 || $product->getCode() === ''
            || $product->getName() === '' || $product->getPrice() <= 0) {
            return false;
        }

        $conn = get_db_connection();
        $stmt = mysqli_prepare($conn, 'INSERT INTO products (categoryID, productCode, productName, listPrice) VALUES (?, ?, ?, ?)');
        $categoryID = $product->getCategoryID();
        $productCode = $product->getCode();
        $productName = $product->getName();
        $listPrice = $product->getPrice();
        mysqli_stmt_bind_param($stmt, 'issd', $categoryID, $productCode, $productName, $listPrice);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    public function deleteProduct($productID) {
        $productID = (int)$productID;
        if ($productID <= 0) {
            return false;
        }

        $conn = get_db_connection();
        $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE productID = ?');
        mysqli_stmt_bind_param($stmt, 'i', $productID);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    public function getProduct($productID) {
        $productID = (int)$productID;
        if ($productID <= 0) {
            return null;
        }

        $conn = get_db_connection();
        $stmt = mysqli_prepare($conn, 'SELECT productID, categoryID, productCode, productName, listPrice FROM products WHERE productID = ?');
        mysqli_stmt_bind_param($stmt, 'i', $productID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if (!$row) {
            return null;
        }

        $product = new Product();
        $product->setID($row['productID']);
        $product->setCategoryID($row['categoryID']);
        $product->setCode($row['productCode']);
        $product->setName($row['productName']);
        $product->setPrice($row['listPrice']);
        return $product;
    }
}
?>
