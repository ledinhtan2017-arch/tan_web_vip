<?php
class Product {
    private $productID;
    private $categoryID;
    private $productCode;
    private $productName;
    private $listPrice;

    public function __construct() {
        $this->productID = 0;
        $this->categoryID = 0;
        $this->productCode = '';
        $this->productName = '';
        $this->listPrice = 0.0;
    }

    public function setID($productID) {
        $this->productID = (int)$productID;
    }

    public function getID() {
        return $this->productID;
    }

    public function setCategoryID($categoryID) {
        $this->categoryID = (int)$categoryID;
    }

    public function getCategoryID() {
        return $this->categoryID;
    }

    public function setCode($productCode) {
        $this->productCode = trim($productCode);
    }

    public function getCode() {
        return $this->productCode;
    }

    public function setName($productName) {
        $this->productName = trim($productName);
    }

    public function getName() {
        return $this->productName;
    }

    public function setPrice($listPrice) {
        $this->listPrice = (float)$listPrice;
    }

    public function getPrice() {
        return $this->listPrice;
    }
}
?>
