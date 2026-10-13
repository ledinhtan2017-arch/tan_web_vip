<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/category.php';

class CategoryDB {
    public function getCategories() {
        $conn = get_db_connection();
        $result = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $category = new Category();
            $category->setID($row['categoryID']);
            $category->setName($row['categoryName']);
            $categories[] = $category;
        }
        mysqli_free_result($result);
        mysqli_close($conn);
        return $categories;
    }

    public function addCategory(Category $category) {
        if ($category->getName() === '') {
            return false;
        }

        $conn = get_db_connection();
        $stmt = mysqli_prepare($conn, 'INSERT INTO categories (categoryName) VALUES (?)');
        $name = $category->getName();
        mysqli_stmt_bind_param($stmt, 's', $name);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    public function deleteCategory($categoryID) {
        $categoryID = (int)$categoryID;
        if ($categoryID <= 0) {
            return false;
        }

        $conn = get_db_connection();
        mysqli_begin_transaction($conn);
        try {
            $stmt = mysqli_prepare($conn, 'DELETE FROM products WHERE categoryID = ?');
            mysqli_stmt_bind_param($stmt, 'i', $categoryID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($conn, 'DELETE FROM categories WHERE categoryID = ?');
            mysqli_stmt_bind_param($stmt, 'i', $categoryID);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_commit($conn);
        } catch (mysqli_sql_exception $exception) {
            mysqli_rollback($conn);
            mysqli_close($conn);
            throw $exception;
        }
        mysqli_close($conn);
        return $success;
    }
}
?>
