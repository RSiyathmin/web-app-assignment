<?php
$page_title = 'Browse Products';
require 'includes/db.php';
require 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');

$where = [];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(name LIKE ? OR description LIKE ?)";
    $like = '%' . $search . '%';
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}
if ($category !== '' && $category !== 'all') {
    $where[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}

$sql = "SELECT * FROM products";
if ($where) $sql .= " WHERE " . implode(" AND ", $where);
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$products = $stmt->get_result();

$categories = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
$emojis = ['Electronics' => '💻', 'Accessories' => '👜', 'Kitchen' => '☕', 'Office' => '🖊️', 'Clothing' => '👕', 'Other' => '📦'];
?>

<div class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Browse</span>
        </div>
        <h1>Browse All Products</h1>
        <p>Find exactly what you're looking for from our full catalogue.</p>
    </div>
</div>

<section>
    <div class="container">
        <form method="GET" action="products.php">
            <div class="filter-bar">
                <input type="text" name="search" class="search-input" placeholder="Search products…" value="<?php echo htmlspecialchars($search); ?>">
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    <?php
                    $categories->data_seek(0);
                    while ($cat = $categories->fetch_assoc()):
                    ?>
                    <option value="<?php echo htmlspecialchars($cat['category']); ?>" <?php echo $category === $cat['category'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['category']); ?>
                    </option>
                    <?php endwhile; ?>
                </select>
                <select name="sort" class="sort-select">
                    <option value="default">Sort by</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap;">Search</button>
                <?php if ($search || ($category && $category !== 'all')): ?>
                <a href="products.php" class="btn btn-secondary btn-sm">Clear</a>
                <?php endif; ?>
                <span class="product-count" style="font-size:0.82rem;color:var(--ink-muted);white-space:nowrap;"><?php echo $products->num_rows; ?> product<?php echo $products->num_rows !== 1 ? 's' : ''; ?></span>
            </div>
        </form>

        <div class="products-grid">
            <?php if ($products->num_rows > 0):
                while ($p = $products->fetch_assoc()):
                    $emoji = $emojis[$p['category']] ?? '📦';
                    $stock_class = $p['stock'] == 0 ? 'out' : ($p['stock'] < 10 ? 'low' : '');
                    $stock_label = $p['stock'] == 0 ? 'Out of stock' : ($p['stock'] < 10 ? 'Only ' . $p['stock'] . ' left' : $p['stock'] . ' in stock');
            ?>
            <div class="product-card">
                <div class="product-img">
                    <?php if ($p['image_url']): ?>
                        <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <span><?php echo $emoji; ?></span>
                    <?php endif; ?>
                    <?php if ($p['featured']): ?>
                        <span class="product-badge">Featured</span>
                    <?php endif; ?>
                </div>
                <div class="product-body">
                    <div class="product-category"><?php echo htmlspecialchars($p['category']); ?></div>
                    <div class="product-name"><?php echo htmlspecialchars($p['name']); ?></div>
                    <div class="product-desc"><?php echo htmlspecialchars($p['description']); ?></div>
                    <div class="product-footer">
                        <span class="product-price">$<?php echo number_format($p['price'], 2); ?></span>
                        <span class="product-stock <?php echo $stock_class; ?>"><?php echo $stock_label; ?></span>
                    </div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div class="empty-state">
                <div class="icon">🔍</div>
                <h3>No products found</h3>
                <p>Try adjusting your search or category filter.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
