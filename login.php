<<<<<<< Updated upstream
<?php
$page_title = 'Login';
require 'includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$identifier || !$password) {
        $error = 'Please enter your username or email and password.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: index.php');
            exit;
        }

        $error = 'Invalid login details. Please try again.';
    }
}

require 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Login</span>
        </div>
        <h1>Welcome Back</h1>
        <p>Log in to access your account and track your orders.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="auth-panel">
            <div class="form-card">
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="identifier">Email or Username</label>
                        <input id="identifier" name="identifier" type="text" value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
                <p class="auth-note">New to ShopForge? <a href="signup.php">Create an account</a>.</p>
            </div>
        </div>
    </div>
</section>

=======
<?php
$page_title = 'Login';
require 'includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$identifier || !$password) {
        $error = 'Please enter your username or email and password.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            header('Location: index.php');
            exit;
        }

        $error = 'Invalid login details. Please try again.';
    }
}

require 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Login</span>
        </div>
        <h1>Welcome Back</h1>
        <p>Log in to access your account and track your orders.</p>
    </div>
</section>

<section>
    <div class="container">
        <div class="auth-panel">
            <div class="form-card">
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="identifier">Email or Username</label>
                        <input id="identifier" name="identifier" type="text" value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </form>
                <p class="auth-note">New to ShopForge? <a href="signup.php">Create an account</a>.</p>
            </div>
        </div>
    </div>
</section>

>>>>>>> Stashed changes
<?php require 'includes/footer.php'; ?>