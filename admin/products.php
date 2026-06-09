<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $conn->prepare("DELETE FROM products WHERE id = ?")->bind_param('i', $id) && true;
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
        header('Location: products.php?deleted=1');
    $like = '%' . $search . '%';
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $products = $stmt->get_result();
} else {
    $products = $conn->query("SELECT * FROM products ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products – ShopForge Admin</title>
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
        <a href="index.php">📊 Overview</a>
        <span class="nav-label">Catalogue</span>
        <a href="products.php" class="active">📦 Products</a>
        <a href="add_product.php">➕ Add Product</a>
        <span class="nav-label">Customers</span>
        <a href="contacts.php">✉️ Messages</a>
    </nav>
    <div class="sidebar-footer">
        <a href="../index.php" target="_blank">🔗 View Live Site</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h1>Products</h1>
        <a href="add_product.php" class="btn btn-primary">+ Add Product</a>
    </div>
    <div class="admin-content">

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">Product deleted successfully.</div>
        <?php endif; ?>
        <?php if (isset($_GET['saved'])): ?>
            <div class="alert alert-success">Product saved successfully.</div>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-header">
                <h2>All Products (<?php echo $products->num_rows; ?>)</h2>
                <form method="GET" action="" style="display:flex;gap:8px;">
                    <input type="text" name="search" class="table-search" placeholder="Search products…" value="<?php echo htmlspecialchars($search); ?>" style="padding:8px 12px;border:1.5px solid var(--border);border-radius:var(--radius);font-family:var(--font-body);font-size:0.85rem;background:var(--cream);outline:none;min-width:200px;">
                    <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                    <?php if ($search): ?>
                        <a href="products.php" class="btn btn-secondary btn-sm">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="overflow-x">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Featured</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($products->num_rows > 0):
                            while ($p = $products->fetch_assoc()): ?>
                        <tr>
                            <td style="color:var(--ink-muted);">#<?php echo $p['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($p['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['category']); ?></td>
                            <td>$<?php echo number_format($p['price'], 2); ?></td>
                            <td><?php echo $p['stock']; ?></td>
                            <td><span class="badge <?php echo $p['featured'] ? 'badge-yes' : 'badge-no'; ?>"><?php echo $p['featured'] ? 'Yes' : 'No'; ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm">Edit</a>
                                    <form method="POST" action="" onsubmit="return confirm('Delete \'<?php echo htmlspecialchars(addslashes($p['name'])); ?>\'? This cannot be undone.');" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $p['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="7" style="text-align:center;color:var(--ink-muted);padding:40px;">No products found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
