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
VALUES ('Guitars'), ('Basses'), ('Drums')
ON DUPLICATE KEY UPDATE categoryName = VALUES(categoryName);

INSERT INTO products (categoryID, productCode, productName, listPrice)
VALUES
    (1, 'strat', 'Fender Stratocaster', 699.00),
    (1, 'les_paul', 'Gibson Les Paul', 1199.00),
    (2, 'precision', 'Fender Precision', 799.00),
    (3, 'dw', 'DW Drum Set', 1499.00)
ON DUPLICATE KEY UPDATE
    productName = VALUES(productName),
    listPrice = VALUES(listPrice);
