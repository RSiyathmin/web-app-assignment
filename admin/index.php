<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';

$total_products = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$total_stock    = $conn->query("SELECT SUM(stock) as s FROM products")->fetch_assoc()['s'] ?? 0;
$total_contacts = $conn->query("SELECT COUNT(*) as c FROM contacts")->fetch_assoc()['c'];
$total_cats     = $conn->query("SELECT COUNT(DISTINCT category) as c FROM products")->fetch_assoc()['c'];
$recent         = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – ShopForge Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="../index.php">Shop<span>Forge</span></a>
        <span class="admin-tag">Admin Panel</span>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-label">Dashboard</span>
        <a href="index.php" class="active">📊 Overview</a>
        <span class="nav-label">Catalogue</span>
        <a href="products.php">📦 Products</a>
        <a href="add_product.php">➕ Add Product</a>
        <span class="nav-label">Customers</span>
        <a href="contacts.php">✉️ Messages</a>
    </nav>
    <div class="sidebar-footer">
        <a href="../index.php" target="_blank">🔗 View Live Site</a>
        <a href="logout.php">🚪 Logout (<?php echo htmlspecialchars($_SESSION['admin_username']); ?>)</a>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h1>Overview</h1>
    </div>
    <div class="admin-content">

        <div class="stats-row">
            <div class="stat-card">
                <span class="s-icon">📦</span>
                <div class="s-label">Total Products</div>
                <div class="s-val"><?php echo $total_products; ?></div>
            </div>
            <div class="stat-card">
                <span class="s-icon">🏷️</span>
                <div class="s-label">Categories</div>
                <div class="s-val"><?php echo $total_cats; ?></div>
            </div>
            <div class="stat-card">
                <span class="s-icon">📬</span>
                <div class="s-label">Stock Units</div>
                <div class="s-val"><?php echo number_format($total_stock); ?></div>
            </div>
            <div class="stat-card">
                <span class="s-icon">✉️</span>
                <div class="s-label">Messages</div>
                <div class="s-val"><?php echo $total_contacts; ?></div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Recent Products</h2>
                <a href="products.php" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <div class="overflow-x">
                <table>
                    <thead>
                        <tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Featured</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($p = $recent->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['category']); ?></td>
                            <td>$<?php echo number_format($p['price'], 2); ?></td>
                            <td><?php echo $p['stock']; ?></td>
                            <td><span class="badge <?php echo $p['featured'] ? 'badge-yes' : 'badge-no'; ?>"><?php echo $p['featured'] ? 'Yes' : 'No'; ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
