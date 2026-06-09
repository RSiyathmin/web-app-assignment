<<<<<<< Updated upstream
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
$member_since = $user['created_at'] ?? null;

require 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>My Account</span>
        </div>
        <h1>My Account</h1>
        <p>Manage your profile details and review your ShopForge account information.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="account-card">
            <h2>Welcome back, <?php echo htmlspecialchars($user_name); ?>.</h2>
            <p>Here are your account details. If you want, you can sign out and use the same account later.</p>

            <dl class="account-details">
                <div>
                    <dt>Username</dt>
                    <dd><?php echo htmlspecialchars($user_name); ?></dd>
                </div>
                <div>
                    <dt>Email</dt>
                    <dd><?php echo htmlspecialchars($user_email); ?></dd>
                </div>
                <?php if ($member_since): ?>
                <div>
                    <dt>Member since</dt>
                    <dd><?php echo date('F j, Y', strtotime($member_since)); ?></dd>
                </div>
                <?php endif; ?>
            </dl>

            <div class="account-actions">
                <a href="logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
                <a href="products.php" class="btn btn-primary btn-sm">Continue Shopping</a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Order History</h3>
                    <span class="badge">0 orders</span>
                </div>
                <p>You haven’t placed any orders yet. Once you buy something, your order history will appear here.</p>
                <a href="products.php" class="btn btn-secondary btn-sm">Browse products</a>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Saved Items</h3>
                    <span class="badge">No saved items</span>
                </div>
                <p>Save products while browsing and they will appear here for easy checkout later.</p>
                <a href="products.php" class="btn btn-secondary btn-sm">Save items now</a>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Account Activity</h3>
                    <span class="badge">Secure</span>
                </div>
                <p>Your account is protected and ready. Keep your profile updated and enjoy faster checkout.</p>
                <a href="contact.php" class="btn btn-secondary btn-sm">Contact support</a>
            </div>
        </div>
    </div>
</section>

=======
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
$member_since = $user['created_at'] ?? null;

require 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>My Account</span>
        </div>
        <h1>My Account</h1>
        <p>Manage your profile details and review your ShopForge account information.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="account-card">
            <h2>Welcome back, <?php echo htmlspecialchars($user_name); ?>.</h2>
            <p>Here are your account details. If you want, you can sign out and use the same account later.</p>

            <dl class="account-details">
                <div>
                    <dt>Username</dt>
                    <dd><?php echo htmlspecialchars($user_name); ?></dd>
                </div>
                <div>
                    <dt>Email</dt>
                    <dd><?php echo htmlspecialchars($user_email); ?></dd>
                </div>
                <?php if ($member_since): ?>
                <div>
                    <dt>Member since</dt>
                    <dd><?php echo date('F j, Y', strtotime($member_since)); ?></dd>
                </div>
                <?php endif; ?>
            </dl>

            <div class="account-actions">
                <a href="logout.php" class="btn btn-secondary btn-sm">Sign Out</a>
                <a href="products.php" class="btn btn-primary btn-sm">Continue Shopping</a>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Order History</h3>
                    <span class="badge">0 orders</span>
                </div>
                <p>You haven’t placed any orders yet. Once you buy something, your order history will appear here.</p>
                <a href="products.php" class="btn btn-secondary btn-sm">Browse products</a>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Saved Items</h3>
                    <span class="badge">No saved items</span>
                </div>
                <p>Save products while browsing and they will appear here for easy checkout later.</p>
                <a href="products.php" class="btn btn-secondary btn-sm">Save items now</a>
            </div>

            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h3>Account Activity</h3>
                    <span class="badge">Secure</span>
                </div>
                <p>Your account is protected and ready. Keep your profile updated and enjoy faster checkout.</p>
                <a href="contact.php" class="btn btn-secondary btn-sm">Contact support</a>
            </div>
        </div>
    </div>
</section>

>>>>>>> Stashed changes
<?php require 'includes/footer.php'; ?>