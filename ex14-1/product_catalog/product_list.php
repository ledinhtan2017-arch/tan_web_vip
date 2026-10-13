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
    <title>Product Catalog</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 900px; margin: 0 auto; border: 1px solid #d9d9d9; background: #f5f5f5; padding: 20px; }
        h1 { margin-top: 0; border-bottom: 2px solid #999; padding-bottom: 8px; }
        .nav { margin: 20px 0; }
        .nav a { text-decoration: none; color: #2a4d8f; margin-right: 10px; }
        .catalog { display: flex; gap: 20px; }
        .sidebar { width: 220px; border: 1px solid #ccc; background: #fff; padding: 10px; }
        .sidebar h2 { margin-top: 0; }
        .sidebar ul { list-style: none; padding-left: 0; margin: 0; }
        .sidebar li { margin: 5px 0; }
        .sidebar a { text-decoration: none; color: #333; }
        .content { flex: 1; background: #fff; border: 1px solid #ccc; padding: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Guitar Shop</h1>
        <div class="nav"><a href="../index.php">Main Menu</a></div>
        <div class="catalog">
            <aside class="sidebar">
                <h2>Categories</h2>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><a href="product_list.php?category_id=<?php echo $category->getID(); ?>"><?php echo htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8'); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </aside>
            <main class="content">
                <h2>Products</h2>
                <table>
                    <tr><th>Product Name</th><th>Price</th></tr>
                    <?php if (!$products): ?>
                        <tr><td colspan="2">No products found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><a href="product_view.php?product_id=<?php echo $product->getID(); ?>"><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></a></td>
                                <td>$<?php echo number_format($product->getPrice(), 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </main>
        </div>
    </div>
</body>
</html>
