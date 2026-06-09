<?php
$page_title = 'About Us';
require 'includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>About</span>
        </div>
        <h1>About ShopForge</h1>
        <p>A business built on quality, honesty, and a love for great products.</p>
    </div>
</div>

<section>
    <div class="container">
        <div class="about-intro">
            <div class="about-intro-text">
                <span class="section-tag">Our Story</span>
                <h2>We Believe Quality Shouldn't Be a Compromise.</h2>
                <p>ShopForge was founded in 2019 with a simple idea: find and sell products that are genuinely worth buying. No filler, no fast-fashion mentality — just carefully sourced goods that stand the test of time.</p>
                <p>We started as a small team of three in a Brooklyn apartment, driven by a shared frustration with the endless scroll of mediocre marketplace listings. Today, we work with over 40 vetted suppliers globally and serve thousands of happy customers.</p>
                <p>Every item in our catalogue has been personally tested by our team. If we wouldn't use it ourselves, it doesn't make the cut.</p>
                <a href="products.php" class="btn btn-dark" style="margin-top:16px;">Explore the Collection →</a>
            </div>
            <div class="about-visual">
                <div class="stat-item">
                    <span class="stat-num">40+</span>
                    <span class="stat-label">Global Suppliers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">12k+</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">98%</span>
                    <span class="stat-label">Satisfaction Rate</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">6yr</span>
                    <span class="stat-label">In Business</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="background:var(--white);border-top:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">What We Stand For</span>
            <h2>Our Values</h2>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="icon">🎯</div>
                <h3>Curated Quality</h3>
                <p>We hand-pick every product. Our team reviews, tests, and only approves items that meet our strict quality threshold.</p>
            </div>
            <div class="value-card">
                <div class="icon">🌿</div>
                <h3>Sustainability</h3>
                <p>We actively seek suppliers with responsible manufacturing practices and eco-friendly materials wherever possible.</p>
            </div>
            <div class="value-card">
                <div class="icon">🤝</div>
                <h3>Fair Pricing</h3>
                <p>Premium doesn't have to mean overpriced. We cut out unnecessary middlemen and pass those savings to you.</p>
            </div>
            <div class="value-card">
                <div class="icon">💬</div>
                <h3>Real Support</h3>
                <p>When you reach out, you talk to a real human. Our support team knows our products inside out and genuinely wants to help.</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="section-header">
            <span class="section-tag">The Team</span>
            <h2>The People Behind ShopForge</h2>
            <p>Small team, big heart. We're product obsessives with a shared mission.</p>
        </div>
        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">👩‍💼</div>
                <h4>Mara Chen</h4>
                <p>Co-Founder & CEO</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👨‍💻</div>
                <h4>James Park</h4>
                <p>Co-Founder & CTO</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👩‍🎨</div>
                <h4>Sona Briggs</h4>
                <p>Head of Design</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">👨‍🔬</div>
                <h4>Leo Walsh</h4>
                <p>Product Curator</p>
            </div>
        </div>
    </div>
</section>

<section style="background:var(--ink);text-align:center;padding:80px 0;">
    <div class="container">
        <span class="section-tag" style="background:rgba(200,83,26,0.2);color:var(--accent);">Join Us</span>
        <h2 style="font-family:var(--font-display);font-size:2rem;color:var(--white);margin:12px 0;">Ready to Discover Something New?</h2>
        <p style="color:rgba(255,255,255,0.5);margin-bottom:32px;">Browse our full catalogue and find items you'll actually love.</p>
        <a href="products.php" class="btn btn-primary">Shop Now →</a>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
