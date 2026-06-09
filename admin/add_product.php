<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $category    = trim($_POST['category'] ?? '');
    $stock       = trim($_POST['stock'] ?? '');
    $image_url   = trim($_POST['image_url'] ?? '');
    $featured    = isset($_POST['featured']) ? 1 : 0;

    if (!$name || !$description || !$price || !$category || $stock === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!is_numeric($price) || $price < 0) {
        $error = 'Please enter a valid price.';
    } elseif (!is_numeric($stock) || $stock < 0) {
        $error = 'Please enter a valid stock quantity.';
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, stock, image_url, featured) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdsiis', $name, $description, $price, $category, $stock, $image_url, $featured);
        if ($stmt->execute()) {
            header('Location: products.php?saved=1');
            exit;
        } else {
            $error = 'Database error. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product – ShopForge Admin</title>
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
        <a href="products.php">📦 Products</a>
        <a href="add_product.php" class="active">➕ Add Product</a>
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
        <h1>Add New Product</h1>
        <a href="products.php" class="btn btn-secondary btn-sm">← Back to Products</a>
    </div>
    <div class="admin-content">

        <div class="panel" style="max-width:640px;">
            <div class="panel-header">
                <h2>Product Details</h2>
            </div>
            <div class="panel-body">
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Product Name <span style="color:#d63939;">*</span></label>
                        <input type="text" id="name" name="name" placeholder="e.g. Wireless Headphones" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span style="color:#d63939;">*</span></label>
                        <textarea id="description" name="description" placeholder="Brief product description…" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price (USD) <span style="color:#d63939;">*</span></label>
                            <input type="number" id="price" name="price" min="0" step="0.01" placeholder="0.00" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock Quantity <span style="color:#d63939;">*</span></label>
                            <input type="number" id="stock" name="stock" min="0" placeholder="0" value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span style="color:#d63939;">*</span></label>
                        <select id="category" name="category" required>
                            <option value="">Select a category…</option>
                            <?php foreach (['Electronics','Accessories','Kitchen','Office','Clothing','Other'] as $cat): ?>
                                <option value="<?php echo $cat; ?>" <?php echo (isset($_POST['category']) && $_POST['category'] === $cat) ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image_url">Image URL <span style="color:var(--ink-muted);font-weight:400;">(optional)</span></label>
                        <input type="text" id="image_url" name="image_url" placeholder="https://example.com/image.jpg" value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" <?php echo isset($_POST['featured']) ? 'checked' : ''; ?>>
                            Mark as Featured Product
                        </label>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <a href="products.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
