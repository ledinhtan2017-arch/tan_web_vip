<?php
$categories = $categories ?? [];
?>
<div class="sidebar">
    <h2>Categories</h2>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="product_list.php?category_id=<?php echo (int)$category['categoryID']; ?>"><?php echo htmlspecialchars($category['categoryName']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
