<?php
session_set_cookie_params(0, '/');

if (isset($_COOKIE['cart_session_id'])) {
    session_id($_COOKIE['cart_session_id']);
}

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_COOKIE['cart_session_id'])) {
    setcookie('cart_session_id', session_id(), time() + 3 * 365 * 24 * 60 * 60, '/');
}

$products = [
    '1' => ['name' => 'Bamboo Flask', 'price' => 18.95],
    '2' => ['name' => 'Travel Mug', 'price' => 14.50],
    '3' => ['name' => 'Notebook', 'price' => 9.99],
    '4' => ['name' => 'Phone Stand', 'price' => 21.00],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $productId = $_POST['product_id'];
    if (isset($products[$productId])) {
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = [
                'name' => $products[$productId]['name'],
                'price' => $products[$productId]['price'],
                'quantity' => 0,
            ];
        }
        $_SESSION['cart'][$productId]['quantity']++;
    }
    header('Location: index.php');
    exit;
}

$cartCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f6f7fb; }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { margin-bottom: 20px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .cart-link { background: #1e88e5; color: white; padding: 10px 14px; text-decoration: none; border-radius: 6px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .product { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .product h2 { font-size: 20px; margin-top: 0; }
        .price { font-size: 18px; color: #333; margin-bottom: 12px; }
        form { margin: 0; }
        button { background: #43a047; color: white; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
        .session-box { margin-top: 20px; padding: 12px; background: #fff1c1; border: 1px solid #e8d79d; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>Shopping Cart</h1>
            <a class="cart-link" href="cart.php">Cart (<?php echo $cartCount; ?>)</a>
        </div>

        <div class="product-grid">
            <?php foreach ($products as $id => $product): ?>
                <div class="product">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <div class="price">$<?php echo number_format($product['price'], 2); ?></div>
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="session-box">
            <strong>Session ID:</strong> <?php echo htmlspecialchars(session_id()); ?>
        </div>
    </div>
</body>
</html>
