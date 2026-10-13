<?php
require_once __DIR__ . '/../model/product_db.php';

$productID = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$product = (new ProductDB())->getProduct($productID);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Product View</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .box { max-width: 500px; border: 1px solid #ccc; padding: 20px; background: #fafafa; }
        a { color: #1d4f91; }
    </style>
</head>
<body>
    <div class="box">
        <?php if ($product): ?>
            <h1><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></h1>
            <p><strong>Code:</strong> <?php echo htmlspecialchars($product->getCode(), ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product->getPrice(), 2); ?></p>
            <p><a href="product_list.php?category_id=<?php echo $product->getCategoryID(); ?>">Back to product list</a></p>
        <?php else: ?>
            <p>Product not found.</p>
            <p><a href="product_list.php">Back to catalog</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
