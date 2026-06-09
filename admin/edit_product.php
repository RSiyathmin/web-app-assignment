<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';

$id = (int) ($_GET['id'] ?? 0);
if (!$id) {
    header('Location: products.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: products.php');
    exit;
}

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
        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, stock=?, image_url=?, featured=? WHERE id=?");
        $stmt->bind_param('ssdsiisi', $name, $description, $price, $category, $stock, $image_url, $featured, $id);
        if ($stmt->execute()) {
            header('Location: products.php?saved=1');
            exit;
        } else {
            $error = 'Database error. Please try again.';
        }
    }

    $product['name']        = $name;
    $product['description'] = $description;
    $product['price']       = $price;
    $product['category']    = $category;
    $product['stock']       = $stock;
    $product['image_url']   = $image_url;
    $product['featured']    = $featured;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product – ShopForge Admin</title>
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
        <h1>Edit Product #<?php echo $id; ?></h1>
        <a href="products.php" class="btn btn-secondary btn-sm">← Back to Products</a>
    </div>
    <div class="admin-content">

        <div class="panel" style="max-width:640px;">
            <div class="panel-header">
                <h2>Editing: <?php echo htmlspecialchars($product['name']); ?></h2>
            </div>
            <div class="panel-body">
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Product Name <span style="color:#d63939;">*</span></label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span style="color:#d63939;">*</span></label>
                        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price (USD) <span style="color:#d63939;">*</span></label>
                            <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock Quantity <span style="color:#d63939;">*</span></label>
                            <input type="number" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span style="color:#d63939;">*</span></label>
                        <select id="category" name="category" required>
                            <option value="">Select a category…</option>
                            <?php foreach (['Electronics','Accessories','Kitchen','Office','Clothing','Other'] as $cat): ?>
                                <option value="<?php echo $cat; ?>" <?php echo $product['category'] === $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image_url">Image URL <span style="color:var(--ink-muted);font-weight:400;">(optional)</span></label>
                        <input type="text" id="image_url" name="image_url" placeholder="https://example.com/image.jpg" value="<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" <?php echo $product['featured'] ? 'checked' : ''; ?>>
                            Mark as Featured Product
                        </label>
                    </div>

                    <div style="display:flex;gap:10px;margin-top:8px;">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="products.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
