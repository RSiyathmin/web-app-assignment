<?php
require_once 'auth.php';
require_login();
require_once '../includes/db.php';

$contacts = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages – ShopForge Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .msg-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 22px 24px; margin-bottom: 16px; }
        .msg-card:hover { border-color: var(--accent); }
        .msg-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; flex-wrap: wrap; gap: 8px; }
        .msg-meta strong { font-size: 0.95rem; display: block; margin-bottom: 2px; }
        .msg-meta span { font-size: 0.8rem; color: var(--ink-muted); }
        .msg-subject { font-size: 0.82rem; font-weight: 600; color: var(--accent); background: var(--accent-light); padding: 3px 8px; border-radius: 2px; white-space: nowrap; }
        .msg-date { font-size: 0.78rem; color: var(--ink-muted); }
        .msg-body { font-size: 0.88rem; color: var(--ink-light); line-height: 1.65; border-top: 1px solid var(--border); padding-top: 12px; }
    </style>
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
        <a href="add_product.php">➕ Add Product</a>
        <span class="nav-label">Customers</span>
        <a href="contacts.php" class="active">✉️ Messages</a>
    </nav>
    <div class="sidebar-footer">
        <a href="../index.php" target="_blank">🔗 View Live Site</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h1>Contact Messages</h1>
    </div>
    <div class="admin-content">

        <?php if ($contacts->num_rows === 0): ?>
            <div style="text-align:center;padding:80px 20px;color:var(--ink-muted);">
                <div style="font-size:3rem;margin-bottom:16px;">📭</div>
                <h3 style="font-family:var(--font-display);font-size:1.3rem;color:var(--ink);margin-bottom:8px;">No messages yet</h3>
                <p>When customers fill in the contact form, their messages will appear here.</p>
            </div>
        <?php else: ?>
            <p style="font-size:0.85rem;color:var(--ink-muted);margin-bottom:20px;"><?php echo $contacts->num_rows; ?> message<?php echo $contacts->num_rows !== 1 ? 's' : ''; ?> received</p>
            <?php while ($c = $contacts->fetch_assoc()): ?>
            <div class="msg-card">
                <div class="msg-header">
                    <div class="msg-meta">
                        <strong><?php echo htmlspecialchars($c['name']); ?></strong>
                        <span><?php echo htmlspecialchars($c['email']); ?></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <span class="msg-subject"><?php echo htmlspecialchars($c['subject']); ?></span>
                        <span class="msg-date"><?php echo date('M j, Y · g:ia', strtotime($c['submitted_at'])); ?></span>
                    </div>
                </div>
                <div class="msg-body"><?php echo nl2br(htmlspecialchars($c['message'])); ?></div>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
