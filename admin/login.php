<?php
require_once 'auth.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = 'Please enter your username and password.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – ShopForge</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --ink: #1a1a1a; --accent: #c8531a; --accent-dark: #a04210; --white: #fff; --cream: #faf8f5; --border: #e5e0d9; --radius: 4px; }
        body { font-family: 'DM Sans', sans-serif; background: var(--ink); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; position: relative; overflow: hidden; }
        body::before { content: ''; position: absolute; top: -120px; right: -120px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(200,83,26,0.15) 0%, transparent 65%); }
        body::after { content: ''; position: absolute; bottom: -100px; left: -100px; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(200,83,26,0.08) 0%, transparent 65%); }
        .wrap { width: 100%; max-width: 420px; position: relative; z-index: 1; }
        .back { display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: rgba(255,255,255,0.35); text-decoration: none; margin-bottom: 28px; transition: color 0.2s; }
        .back:hover { color: rgba(255,255,255,0.7); }
        .card { background: var(--white); border-radius: 12px; overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,0.4); }
        .card-top { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 32px 36px 28px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .logo { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--white); margin-bottom: 14px; }
        .logo span { color: var(--accent); }
        .badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(200,83,26,0.18); border: 1px solid rgba(200,83,26,0.3); color: var(--accent); font-size: 0.7rem; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; padding: 4px 10px; border-radius: 2px; margin-bottom: 14px; }
        .dot { width: 5px; height: 5px; border-radius: 50%; background: var(--accent); animation: pulse 1.8s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .card-top h1 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--white); margin-bottom: 4px; }
        .card-top p { font-size: 0.82rem; color: rgba(255,255,255,0.35); }
        .card-body { padding: 32px 36px; }
        .alert { padding: 11px 14px; border-radius: var(--radius); font-size: 0.84rem; font-weight: 500; margin-bottom: 18px; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .security-note { display: flex; align-items: center; gap: 8px; background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--radius); padding: 10px 12px; font-size: 0.78rem; color: #92400e; margin-bottom: 22px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 6px; }
        .form-group input { width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: var(--radius); font-family: 'DM Sans', sans-serif; font-size: 0.9rem; background: var(--cream); outline: none; transition: border-color 0.2s; }
        .form-group input:focus { border-color: var(--accent); background: var(--white); }
        .btn { width: 100%; padding: 13px; background: var(--ink); color: var(--white); border: none; border-radius: var(--radius); font-family: 'DM Sans', sans-serif; font-size: 0.95rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn:hover { background: #2d2d2d; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,26,26,0.25); }
        .card-foot { padding: 16px 36px 24px; text-align: center; }
        .card-foot a { font-size: 0.82rem; color: #8a8a8a; text-decoration: none; }
        .card-foot a:hover { color: var(--accent); }
    </style>
</head>
<body>
<div class="wrap">
    <a href="../index.php" class="back">← Back to storefront</a>
    <div class="card">
        <div class="card-top">
            <div class="logo">Shop<span>Forge</span></div>
            <div class="badge"><span class="dot"></span> Admin Access</div>
            <h1>Admin Login</h1>
            <p>Restricted area. Authorised personnel only.</p>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="security-note">
                <span>🔒</span>
                <span>This page is for store administrators only. All access attempts are logged.</span>
            </div>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="admin" autocomplete="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter admin password" autocomplete="current-password">
                </div>
                <button type="submit" class="btn">Access Dashboard →</button>
            </form>
        </div>
        <div class="card-foot">
            <a href="../contact.php">Need help? Contact support</a>
        </div>
    </div>
</div>
</body>
</html>
