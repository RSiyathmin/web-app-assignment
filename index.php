<?php
$page_title = 'Home';
require 'includes/db.php';
require 'includes/header.php';

$featured = $conn->query("SELECT * FROM products WHERE featured = 1 LIMIT 4");
$categories = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>

<section class="hero">
    <div class="container">
        <div class="hero-label">New Arrivals — Summer 2025</div>
        <h1>Crafted for the <em>Modern</em> Life.</h1>
        <p>Discover a curated selection of premium goods — from everyday essentials to standout pieces that define your style.</p>
        <div class="hero-actions">
            <a href="products.php" class="btn btn-primary">Browse Collection →</a>
            <a href="about.php" class="btn btn-outline">Our Story</a>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Editor's Pick</span>
            <h2>Featured Products</h2>
            <p>Hand-selected items our team loves this season.</p>
        </div>
        <div class="products-grid">
            <?php
            $emojis = ['Electronics' => '💻', 'Accessories' => '👜', 'Kitchen' => '☕', 'Office' => '🖊️', 'Clothing' => '👕', 'Other' => '📦'];
            if ($featured->num_rows > 0):
                while ($p = $featured->fetch_assoc()):
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
                    <span class="product-badge">Featured</span>
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
                <div class="icon">📦</div>
                <h3>No featured products yet</h3>
            </div>
            <?php endif; ?>
        </div>
        <div style="text-align:center; margin-top:40px;">
            <a href="products.php" class="btn btn-dark">View All Products →</a>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">🚚</div>
                <h3>Free Shipping</h3>
                <p>Complimentary delivery on all orders over $75. Fast, reliable, tracked.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔄</div>
                <h3>30-Day Returns</h3>
                <p>Not satisfied? Return any unused item within 30 days, no questions asked.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <h3>Secure Payments</h3>
                <p>256-bit SSL encryption. Your payment information is always protected.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">💬</div>
                <h3>Expert Support</h3>
                <p>Dedicated customer care team available Mon–Fri, 9am–6pm EST.</p>
            </div>
        </div>
    </div>
</section>

<section style="background:var(--white); border-top:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Shop by Category</span>
            <h2>What Are You Looking For?</h2>
        </div>
        <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
            <?php while ($cat = $categories->fetch_assoc()):
                $emoji = $emojis[$cat['category']] ?? '📦';
            ?>
            <a href="products.php?category=<?php echo urlencode($cat['category']); ?>" style="display:inline-flex;align-items:center;gap:8px;padding:12px 22px;background:var(--white);border:1.5px solid var(--border);border-radius:var(--radius-lg);font-weight:500;font-size:0.9rem;color:var(--ink);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--accent)';this.style.color='var(--accent)';" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--ink)';">
                <span><?php echo $emoji; ?></span> <?php echo htmlspecialchars($cat['category']); ?>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
