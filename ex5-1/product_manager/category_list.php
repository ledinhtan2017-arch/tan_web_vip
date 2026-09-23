<?php
require_once '../database.php';

$conn = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $name = trim($_POST['category_name']);
    if ($name !== '') {
        $stmt = mysqli_prepare($conn, 'INSERT INTO categories (categoryName) VALUES (?)');
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header('Location: category_list.php');
    exit;
}

$result = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        .add-form { margin-top: 20px; }
        input[type="text"] { padding: 5px; }
        input[type="submit"] { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1>Product Manager</h1>

    <h2>Category List</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
                <td>
                    <a href="delete_category.php?category_id=<?php echo (int)$category['categoryID']; ?>"
                       onclick="return confirm('Delete this category?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="add-form">
        <h3>Add Category</h3>
        <form method="post" action="category_list.php">
            <label for="category_name">Name:</label>
            <input type="text" id="category_name" name="category_name" />
            <input type="submit" value="Add" />
        </form>
    </div>

    <p><a href="index.php">List Products</a></p>
</body>
</html>
<?php mysqli_close($conn); ?>
