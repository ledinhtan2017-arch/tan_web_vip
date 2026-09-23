<?php
require_once '../database.php';

$conn = get_db_connection();

$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$product = null;

if ($productId > 0) {
    $stmt = mysqli_prepare($conn, 'SELECT productID, categoryID, productCode, productName, listPrice FROM products WHERE productID = ?');
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product View</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box {
            width: 500px;
            border: 1px solid #ccc;
            padding: 20px;
            background: #fafafa;
        }
        a { color: #1d4f91; }
    </style>
</head>
<body>
    <div class="box">
        <?php if ($product): ?>
            <h1><?php echo htmlspecialchars($product['productName']); ?></h1>
            <p><strong>Code:</strong> <?php echo htmlspecialchars($product['productCode']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format((float)$product['listPrice'], 2); ?></p>
            <p><a href="product_list.php?category_id=<?php echo (int)$product['categoryID']; ?>">Back to product list</a></p>
        <?php else: ?>
            <p>Product not found.</p>
            <p><a href="product_list.php">Back to catalog</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>
