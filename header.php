<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' – ShopForge' : 'ShopForge'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav>
    <div class="container nav-inner">
        <a href="index.php" class="nav-logo">Shop<span>Forge</span></a>
        <button class="nav-toggle" type="button" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-links">
            <li><a href="index.php" class="<?php echo $current === 'index' ? 'active' : ''; ?>">Home</a></li>
            <li><a href="products.php" class="<?php echo $current === 'products' ? 'active' : ''; ?>">Browse</a></li>
            <li><a href="about.php" class="<?php echo $current === 'about' ? 'active' : ''; ?>">About Us</a></li>
            <li><a href="contact.php" class="<?php echo $current === 'contact' ? 'active' : ''; ?>">Contact</a></li>
            <?php if (isset($_SESSION['user_name'])): ?>
                <li><a href="account.php" class="<?php echo $current === 'account' ? 'active' : ''; ?>">My Account</a></li>
                <li><a href="logout.php" class="nav-cta">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="<?php echo $current === 'login' ? 'active' : ''; ?>">Login</a></li>
                <li><a href="signup.php" class="nav-cta <?php echo $current === 'signup' ? 'active' : ''; ?>">Sign Up</a></li>
            <?php endif; ?>
            <li><a href="admin/index.php" class="nav-cta">Admin ↗</a></li>
        </ul>
    </div>
</nav>
