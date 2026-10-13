<?php
$mysqli = new mysqli('localhost', 'root', '', 'mysql');
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$mysqli->query('CREATE DATABASE IF NOT EXISTS my_guitar_shop1');
$mysqli->select_db('my_guitar_shop1');
$mysqli->query("
    CREATE TABLE IF NOT EXISTS categories (
        categoryID INT NOT NULL AUTO_INCREMENT,
        categoryName VARCHAR(255) NOT NULL,
        PRIMARY KEY (categoryID)
    )
");
$mysqli->query("
    CREATE TABLE IF NOT EXISTS products (
        productID INT NOT NULL AUTO_INCREMENT,
        categoryID INT NOT NULL,
        productCode VARCHAR(10) NOT NULL,
        productName VARCHAR(255) NOT NULL,
        listPrice DECIMAL(10,2) NOT NULL,
        PRIMARY KEY (productID),
        FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
    )
");

$categoryCount = (int)$mysqli->query('SELECT COUNT(*) AS count FROM categories')->fetch_assoc()['count'];
if ($categoryCount === 0) {
    $mysqli->query("INSERT INTO categories (categoryName) VALUES ('Guitars'), ('Basses'), ('Drums')");
}

$productCount = (int)$mysqli->query('SELECT COUNT(*) AS count FROM products')->fetch_assoc()['count'];
if ($productCount === 0) {
    $mysqli->query("
        INSERT INTO products (categoryID, productCode, productName, listPrice)
        SELECT categoryID, 'strat', 'Fender Stratocaster', 699.00
        FROM categories WHERE categoryName = 'Guitars' LIMIT 1
    ");
    $mysqli->query("
        INSERT INTO products (categoryID, productCode, productName, listPrice)
        SELECT categoryID, 'les_paul', 'Gibson Les Paul', 1199.00
        FROM categories WHERE categoryName = 'Guitars' LIMIT 1
    ");
    $mysqli->query("
        INSERT INTO products (categoryID, productCode, productName, listPrice)
        SELECT categoryID, 'precision', 'Fender Precision', 799.00
        FROM categories WHERE categoryName = 'Basses' LIMIT 1
    ");
    $mysqli->query("
        INSERT INTO products (categoryID, productCode, productName, listPrice)
        SELECT categoryID, 'dw', 'DW Drum Set', 1499.00
        FROM categories WHERE categoryName = 'Drums' LIMIT 1
    ");
}

$mysqli->close();
?>
