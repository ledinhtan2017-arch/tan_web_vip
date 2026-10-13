<?php
require_once __DIR__ . '/../model/category_db.php';

$categoryDB = new CategoryDB();
$categoryID = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
if ($categoryID > 0) {
    $categoryDB->deleteCategory($categoryID);
}

header('Location: category_list.php');
exit;
?>
