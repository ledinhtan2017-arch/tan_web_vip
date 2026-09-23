<?php
require_once '../db_setup.php';
require_once '../database.php';

$conn = get_db_connection();

$selectedCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;

$categoriesResult = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');

if (!$categoriesResult || mysqli_num_rows($categoriesResult) === 0) {
    $selectedCategoryId = 0;
    $products = [];
} else {
    $categoryIds = [];
    while ($category = mysqli_fetch_assoc($categoriesResult)) {
        $categoryIds[] = (int)$category['categoryID'];
    }

    if (!in_array($selectedCategoryId, $categoryIds, true)) {
        $selectedCategoryId = $categoryIds[0];
    }

    $stmt = mysqli_prepare($conn, 'SELECT productID, productName, listPrice FROM products WHERE categoryID = ? ORDER BY productName');
    mysqli_stmt_bind_param($stmt, 'i', $selectedCategoryId);
    mysqli_stmt_execute($stmt);
    $productsResult = mysqli_stmt_get_result($stmt);
    $products = mysqli_fetch_all($productsResult, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 500px; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .actions a, .actions button { margin-right: 5px; }
        .nav { margin-top: 20px; }
        select { padding: 5px; }
    </style>
</head>
<body>
    <h1>Product Manager</h1>

    <form method="get" action="index.php">
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" onchange="this.form.submit()">
            <?php
            if ($categoriesResult) {
                mysqli_data_seek($categoriesResult, 0);
                while ($category = mysqli_fetch_assoc($categoriesResult)) {
                    $selected = ($category['categoryID'] == $selectedCategoryId) ? 'selected' : '';
                    echo '<option value="' . (int)$category['categoryID'] . '" ' . $selected . '>' . htmlspecialchars($category['categoryName']) . '</option>';
                }
            }
            ?>
        </select>
    </form>

    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Delete</th>
        </tr>

        <?php if (empty($products)): ?>
            <tr>
                <td colspan="3">No products found for this category.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['productName']); ?></td>
                    <td>$<?php echo number_format((float)$product['listPrice'], 2); ?></td>
                    <td class="actions">
                        <a href="delete_product.php?product_id=<?php echo (int)$product['productID']; ?>&category_id=<?php echo $selectedCategoryId; ?>"
                           onclick="return confirm('Delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <div class="nav">
        <a href="add_product.php?category_id=<?php echo $selectedCategoryId; ?>">Add Product</a> |
        <a href="category_list.php">List Categories</a> |
        <a href="../index.php">Main Menu</a>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
