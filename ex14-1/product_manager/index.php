<?php
require_once __DIR__ . '/../db_setup.php';
require_once __DIR__ . '/../model/category_db.php';
require_once __DIR__ . '/../model/product_db.php';

$categoryDB = new CategoryDB();
$productDB = new ProductDB();
$categories = $categoryDB->getCategories();
$categoryIDs = array_map(function ($category) {
    return $category->getID();
}, $categories);
$selectedCategoryID = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
if ($categories && !in_array($selectedCategoryID, $categoryIDs, true)) {
    $selectedCategoryID = $categoryIDs[0];
}
$products = $selectedCategoryID > 0 ? $productDB->getProductsByCategory($selectedCategoryID) : [];
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
        .nav { margin-top: 20px; }
        select { padding: 5px; }
    </style>
</head>
<body>
    <h1>Product Manager</h1>
    <form method="get" action="index.php">
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" onchange="this.form.submit()">
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category->getID(); ?>" <?php echo $category->getID() === $selectedCategoryID ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <table>
        <tr><th>Product Name</th><th>Price</th><th>Delete</th></tr>
        <?php if (!$products): ?>
            <tr><td colspan="3">No products found for this category.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>$<?php echo number_format($product->getPrice(), 2); ?></td>
                    <td><a href="delete_product.php?product_id=<?php echo $product->getID(); ?>&amp;category_id=<?php echo $selectedCategoryID; ?>" onclick="return confirm('Delete this product?');">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <div class="nav">
        <?php if ($selectedCategoryID > 0): ?>
            <a href="add_product.php?category_id=<?php echo $selectedCategoryID; ?>">Add Product</a> |
        <?php endif; ?>
        <a href="category_list.php">List Categories</a> |
        <a href="../index.php">Main Menu</a>
    </div>
</body>
</html>
