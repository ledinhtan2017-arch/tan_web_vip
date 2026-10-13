<?php
class Category {
    private $categoryID;
    private $categoryName;

    public function __construct() {
        $this->categoryID = 0;
        $this->categoryName = '';
    }

    public function setID($categoryID) {
        $this->categoryID = (int)$categoryID;
    }

    public function getID() {
        return $this->categoryID;
    }

    public function setName($categoryName) {
        $this->categoryName = trim($categoryName);
    }

    public function getName() {
        return $this->categoryName;
    }
}
?>
