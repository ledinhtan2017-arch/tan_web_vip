CREATE DATABASE IF NOT EXISTS my_guitar_shop1;
USE my_guitar_shop1;

CREATE TABLE IF NOT EXISTS categories (
    categoryID INT NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID)
);

CREATE TABLE IF NOT EXISTS products (
    productID INT NOT NULL AUTO_INCREMENT,
    categoryID INT NOT NULL,
    productCode VARCHAR(10) NOT NULL,
    productName VARCHAR(255) NOT NULL,
    listPrice DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (productID),
    FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
);

INSERT INTO categories (categoryName)
SELECT 'Guitars' WHERE NOT EXISTS (
    SELECT 1 FROM categories WHERE categoryName = 'Guitars'
);
INSERT INTO categories (categoryName)
SELECT 'Basses' WHERE NOT EXISTS (
    SELECT 1 FROM categories WHERE categoryName = 'Basses'
);
INSERT INTO categories (categoryName)
SELECT 'Drums' WHERE NOT EXISTS (
    SELECT 1 FROM categories WHERE categoryName = 'Drums'
);

INSERT INTO products (categoryID, productCode, productName, listPrice)
SELECT categoryID, 'strat', 'Fender Stratocaster', 699.00
FROM categories
WHERE categoryName = 'Guitars'
  AND NOT EXISTS (SELECT 1 FROM products WHERE productCode = 'strat');
INSERT INTO products (categoryID, productCode, productName, listPrice)
SELECT categoryID, 'les_paul', 'Gibson Les Paul', 1199.00
FROM categories
WHERE categoryName = 'Guitars'
  AND NOT EXISTS (SELECT 1 FROM products WHERE productCode = 'les_paul');
INSERT INTO products (categoryID, productCode, productName, listPrice)
SELECT categoryID, 'precision', 'Fender Precision', 799.00
FROM categories
WHERE categoryName = 'Basses'
  AND NOT EXISTS (SELECT 1 FROM products WHERE productCode = 'precision');
INSERT INTO products (categoryID, productCode, productName, listPrice)
SELECT categoryID, 'dw', 'DW Drum Set', 1499.00
FROM categories
WHERE categoryName = 'Drums'
  AND NOT EXISTS (SELECT 1 FROM products WHERE productCode = 'dw');
