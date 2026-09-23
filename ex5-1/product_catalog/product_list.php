<?php
require_once '../db_setup.php';
require_once '../database.php';

$conn = get_db_connection();

$categoriesResult = mysqli_query($conn, 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName');
$categories = mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);

$selectedCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;
if (!$categories) {
    $selectedCategoryId = 0;
    $products = [];
} else {
    $categoryIds = array_map(function ($category) { return (int)$category['categoryID']; }, $categories);
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
    <title>Product Catalog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 900px;
            margin: 0 auto;
            border: 1px solid #d9d9d9;
            background: #f5f5f5;
            padding: 20px;
        }
        h1 {
            margin-top: 0;
            border-bottom: 2px solid #999;
            padding-bottom: 8px;
        }
        .nav {
            margin: 20px 0;
        }
        .nav a {
            text-decoration: none;
            color: #2a4d8f;
            margin-right: 10px;
        }
        .catalog {
            display: flex;
            gap: 20px;
        }
        .sidebar {
            width: 220px;
            border: 1px solid #ccc;
            background: #fff;
            padding: 10px;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        .sidebar li {
            margin: 5px 0;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
        }
        .content {
            flex: 1;
            background: #fff;
            border: 1px solid #ccc;
            padding: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Guitar Shop</h1>

        <div class="nav">
            <a href="../index.php">Main Menu</a>
        </div>

        <div class="catalog">
            <div class="sidebar">
                <h2>Categories</h2>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="product_list.php?category_id=<?php echo (int)$category['categoryID']; ?>">
                                <?php echo htmlspecialchars($category['categoryName']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="content">
                <h2>Products</h2>
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                    </tr>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="2">No products found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <a href="product_view.php?product_id=<?php echo (int)$product['productID']; ?>">
                                        <?php echo htmlspecialchars($product['productName']); ?>
                                    </a>
                                </td>
                                <td>$<?php echo number_format((float)$product['listPrice'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
