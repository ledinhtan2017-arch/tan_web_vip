<?php
require_once('product_db.php');

// Sample data for inserting a product
$category_name = 'Guitars';
$product_code = 'tele';
$product_name = 'Fender Telecaster';
$list_price = 849.00;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exercise 19-1 - Product Database</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        h1 { color: #333; }
        h2 { color: #555; margin-top: 30px; }
        table { border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #e0e0e0; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
    </style>
</head>
<body>

<h1>Exercise 19-1 - Product Database</h1>

<?php
// 1. Display products in the Guitars category
$products = get_products_by_category('Guitars');
?>

<h2>Products in Guitars Category</h2>
<?php if (count($products) > 0) : ?>
<table>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Price</th>
    </tr>
    <?php foreach ($products as $product) : ?>
    <tr>
        <td><?php echo htmlspecialchars($product['productCode']); ?></td>
        <td><?php echo htmlspecialchars($product['productName']); ?></td>
        <td>$<?php echo number_format($product['listPrice'], 2); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else : ?>
    <p class="message info">No products found in the Guitars category.</p>
<?php endif; ?>

<?php
// 2. Delete the product named "Fender Telecaster"
$product_to_delete = get_product_by_name('Fender Telecaster');
if ($product_to_delete) {
    $delete_success = delete_product($product_to_delete['productID']);
    if ($delete_success) {
        echo '<p class="message success">The product "Fender Telecaster" (ID: ' 
            . $product_to_delete['productID'] . ') was deleted successfully.</p>';
    } else {
        echo '<p class="message error">Error: Unable to delete the product "Fender Telecaster".</p>';
    }
} else {
    echo '<p class="message info">The product "Fender Telecaster" was not found. No deletion needed.</p>';
}
?>

<?php
// 3. Add a product
$category_id = get_category_id($category_name);
if ($category_id) {
    try {
        $insert_success = add_product($category_id, $product_code, $product_name, $list_price);
        if ($insert_success) {
            echo '<p class="message success">The product "' . htmlspecialchars($product_name) 
                . '" (Code: ' . htmlspecialchars($product_code) . ') was inserted successfully.</p>';
        } else {
            echo '<p class="message error">Error: Unable to insert the product "' 
                . htmlspecialchars($product_name) . '".</p>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo '<p class="message error">Error: The product code "' . htmlspecialchars($product_code) 
                . '" already exists. Each product must have a unique product code.</p>';
        } else {
            echo '<p class="message error">Database error: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
    }
} else {
    echo '<p class="message error">Error: Category "' . htmlspecialchars($category_name) . '" not found.</p>';
}
?>

<?php
// 4. Display products again after changes
$products_after = get_products_by_category('Guitars');
?>

<h2>Products in Guitars Category (After Changes)</h2>
<?php if (count($products_after) > 0) : ?>
<table>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Price</th>
    </tr>
    <?php foreach ($products_after as $product) : ?>
    <tr>
        <td><?php echo htmlspecialchars($product['productCode']); ?></td>
        <td><?php echo htmlspecialchars($product['productName']); ?></td>
        <td>$<?php echo number_format($product['listPrice'], 2); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else : ?>
    <p class="message info">No products found in the Guitars category.</p>
<?php endif; ?>

</body>
</html>

