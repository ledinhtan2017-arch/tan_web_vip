<?php
require_once '../database.php';

$conn = get_db_connection();

$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : $categoryId;
    $productCode = trim($_POST['product_code']);
    $productName = trim($_POST['product_name']);
    $listPrice = trim($_POST['list_price']);

    if ($productCode !== '' && $productName !== '' && $listPrice !== '') {
        $stmt = mysqli_prepare($conn, 'INSERT INTO products (categoryID, productCode, productName, listPrice) VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'issd', $categoryId, $productCode, $productName, $listPrice);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    header('Location: index.php?category_id=' . $categoryId);
    exit;
}

$categoriesResult = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
$categories = mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 350px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Add Product</h1>
    <form method="post" action="add_product.php">
        <label for="category_id">Category</label>
        <select id="category_id" name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo (int)$category['categoryID']; ?>" <?php echo ((int)$category['categoryID'] === $categoryId) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['categoryName']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="product_code">Product Code</label>
        <input type="text" id="product_code" name="product_code" required />

        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name" required />

        <label for="list_price">List Price</label>
        <input type="number" step="0.01" id="list_price" name="list_price" required />

        <input type="submit" value="Add Product" />
    </form>
    <p><a href="index.php?category_id=<?php echo $categoryId; ?>">List Products</a></p>
</body>
</html>
<?php mysqli_close($conn); ?>
