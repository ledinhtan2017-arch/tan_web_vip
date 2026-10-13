<?php
require_once __DIR__ . '/../db_setup.php';
require_once __DIR__ . '/../model/category_db.php';

$categoryDB = new CategoryDB();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = new Category();
    $category->setName(isset($_POST['category_name']) ? $_POST['category_name'] : '');
    if ($category->getName() === '') {
        $error = 'Enter a category name.';
    } elseif (!$categoryDB->addCategory($category)) {
        $error = 'The category could not be added.';
    } else {
        header('Location: category_list.php');
        exit;
    }
}
$categories = $categoryDB->getCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Category List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 500px; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .error { color: #b00020; }
    </style>
</head>
<body>
    <h1>Product Manager</h1>
    <h2>Category List</h2>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
    <table>
        <tr><th>Name</th><th>Delete</th></tr>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><a href="delete_category.php?category_id=<?php echo $category->getID(); ?>" onclick="return confirm('Delete this category and its products?');">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h3>Add Category</h3>
    <form method="post" action="category_list.php">
        <label for="category_name">Name:</label>
        <input type="text" id="category_name" name="category_name" required>
        <input type="submit" value="Add">
    </form>
    <p><a href="index.php">List Products</a> | <a href="../index.php">Main Menu</a></p>
</body>
</html>
