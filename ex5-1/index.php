<?php
require_once 'db_setup.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Guitar Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        h1 {
            margin-bottom: 25px;
        }
        .menu {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .menu a {
            display: inline-block;
            padding: 12px 20px;
            background: #ffffff;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>My Guitar Shop</h1>
    <div class="menu">
        <a href="product_manager/index.php">Product Manager</a>
        <a href="product_catalog/product_list.php">Product Catalog</a>
    </div>
</body>
</html>
