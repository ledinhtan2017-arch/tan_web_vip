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

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'empty_cart') {
        $_SESSION['cart'] = [];
    }

    if ($_GET['action'] === 'end_session') {
        $_SESSION = [];
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        setcookie('cart_session_id', '', time() - 3600, '/');
        header('Location: cart.php');
        exit;
    }
}

$cartItems = $_SESSION['cart'];
$cartTotal = 0;
foreach ($cartItems as $item) {
    $cartTotal += $item['price'] * $item['quantity'];
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
        .container { max-width: 800px; margin: 0 auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; margin-right: 10px; text-decoration: none; padding: 10px 14px; border-radius: 6px; }
        .primary { background: #1e88e5; color: white; }
        .danger { background: #e53935; color: white; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .summary { margin-top: 20px; padding: 16px; background: white; border-radius: 8px; }
        .session-box { margin: 20px 0; padding: 12px; background: #e3f2fd; border: 1px solid #bbdefb; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>Your Cart</h1>
            <a class="btn primary" href="index.php">Continue Shopping</a>
        </div>

        <div class="session-box">
            <strong>Session ID:</strong> <?php echo htmlspecialchars(session_id()); ?>
        </div>

        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $id => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo (int)$item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="summary">
            <strong>Total:</strong> $<?php echo number_format($cartTotal, 2); ?>
        </div>

        <p>
            <a class="btn danger" href="cart.php?action=empty_cart">Empty Cart</a>
            <a class="btn danger" href="cart.php?action=end_session">End Session and Delete Cookie</a>
        </p>
    </div>
</body>
</html>
