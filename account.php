<?php
$page_title = 'My Account';
require 'includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Customer';
$user_email = $_SESSION['user_email'] ?? '';

$stmt = $conn->prepare('SELECT created_at FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
// Simple GET parameter tab handler
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';

require 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
        <p>Manage your account settings and details below.</p>
    </div>
</section>

<section>
    <div class="container">
        <!-- Horizontal Menu bar (Links with GET params) -->
        <div class="account-menu">
            <a href="account.php?tab=profile" class="menu-link <?php echo $tab === 'profile' ? 'active' : ''; ?>">👤 Profile Details</a>
            <a href="account.php?tab=orders" class="menu-link <?php echo $tab === 'orders' ? 'active' : ''; ?>">📦 Order History</a>
            <a href="account.php?tab=wishlist" class="menu-link <?php echo $tab === 'wishlist' ? 'active' : ''; ?>">❤️ Saved Items</a>
            <a href="account.php?tab=security" class="menu-link <?php echo $tab === 'security' ? 'active' : ''; ?>">🔒 Security & Support</a>
            <a href="logout.php" class="menu-link logout-link">🚪 Sign Out</a>
        </div>

        <!-- Dynamic Content Box handled via standard PHP if/else -->
        <div class="account-content">
            <?php if ($tab === 'profile'): ?>
                <div class="profile-section">
                    <h2>Profile Details</h2>
                    <table class="profile-table">
                        <tr>
                            <th>Username</th>
                            <td><?php echo htmlspecialchars($user_name); ?></td>
                        </tr>
                        <tr>
                            <th>Email Address</th>
                            <td><?php echo htmlspecialchars($user_email); ?></td>
                        </tr>
                        <?php if ($member_since): ?>
                        <tr>
                            <th>Member Since</th>
                            <td><?php echo date('F j, Y', strtotime($member_since)); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Account Status</th>
                            <td style="color: #166534; font-weight: bold;">Active</td>
                        </tr>
                    </table>
                </div>

            <?php elseif ($tab === 'orders'): ?>
                <div class="orders-section">
                    <h2>Order History</h2>
                    <p style="margin: 15px 0;">You have not placed any orders yet. Once you make a purchase, your order history will appear here.</p>
                    <a href="products.php" class="btn btn-primary btn-sm">Start Shopping</a>
                </div>

            <?php elseif ($tab === 'wishlist'): ?>
                <div class="wishlist-section">
                    <h2>Saved Items</h2>
                    <p style="margin: 15px 0;">Your wishlist is currently empty. Save items you like while browsing to see them here.</p>
                    <a href="products.php" class="btn btn-primary btn-sm">Browse Products</a>
                </div>

            <?php elseif ($tab === 'security'): ?>
                <div class="security-section">
                    <h2>Security & Support</h2>
                    
                    <h3>Customer Support</h3>
                    <p>Have issues or questions? Our support team is here to assist you.</p>
                    <a href="contact.php" class="btn btn-secondary btn-sm">Contact Support</a>
                    
                    <hr>
                    
                    <h3>Account Controls</h3>
                    <p>Always secure your profile by logging out when using a shared computer.</p>
                    <a href="logout.php" class="btn btn-sm" style="color: #b91c1c; background: #fee2e2; border: 1px solid #fca5a5; text-decoration: none; display: inline-block; padding: 8px 16px; border-radius: 4px;">Sign Out Now</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>