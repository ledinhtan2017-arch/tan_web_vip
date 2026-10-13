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
$categoryID = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
if ($categories && !in_array($categoryID, $categoryIDs, true)) {
    $categoryID = $categoryIDs[0];
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = new Product();
    $product->setCategoryID(isset($_POST['category_id']) ? $_POST['category_id'] : 0);
    $product->setCode(isset($_POST['product_code']) ? $_POST['product_code'] : '');
    $product->setName(isset($_POST['product_name']) ? $_POST['product_name'] : '');
    $product->setPrice(isset($_POST['list_price']) ? $_POST['list_price'] : 0);
    $categoryID = $product->getCategoryID();

    if (!in_array($categoryID, $categoryIDs, true)) {
        $error = 'Please select a valid category.';
    } elseif (!$productDB->addProduct($product)) {
        $error = 'Please enter a product code, product name, and price greater than zero.';
    } else {
        header('Location: index.php?category_id=' . $categoryID);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 350px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 15px; }
        .error { color: #b00020; }
    </style>
</head>
<body>
    <h1>Add Product</h1>
    <?php if ($error !== ''): ?><p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
    <?php if ($categories): ?>
        <form method="post" action="add_product.php">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->getID(); ?>" <?php echo $category->getID() === $categoryID ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="product_code">Product Code</label>
            <input type="text" id="product_code" name="product_code" maxlength="10" required>
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" required>
            <label for="list_price">List Price</label>
            <input type="number" id="list_price" name="list_price" min="0.01" step="0.01" required>
            <input type="submit" value="Add Product">
        </form>
    <?php else: ?>
        <p>Add a category before adding products.</p>
    <?php endif; ?>
    <p><a href="index.php?category_id=<?php echo $categoryID; ?>">List Products</a></p>
</body>
</html>
