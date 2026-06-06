<?php
$page_title = 'Contact Us';
require 'includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$subject || !$message) {
        $error = 'Please fill in all fields before submitting.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $success = 'Thank you! Your message has been sent. We will be in touch soon.';
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}

require 'includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Contact</span>
        </div>
        <h1>Get In Touch</h1>
        <p>We're here to help. Our team will respond within 24 hours.</p>
    </div>
</div>

<section>
    <div class="container">
        <div class="contact-layout">
            <div class="contact-info">
                <h2>We'd Love to Hear From You</h2>
                <p>Have a question about a product, a shipping update, or just want to say hello? Fill in the form and we'll get back to you as soon as possible.</p>
                <div class="contact-detail">
                    <div class="contact-detail-icon">📍</div>
                    <div class="contact-detail-text">
                        <strong>Address</strong>
                        <span>142 Commerce Street, Suite 300<br>New York, NY 10012</span>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-detail-icon">📞</div>
                    <div class="contact-detail-text">
                        <strong>Phone</strong>
                        <span>+1 (800) 743-6281</span>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-detail-icon">✉️</div>
                    <div class="contact-detail-text">
                        <strong>Email</strong>
                        <span>support@shopforge.com</span>
                    </div>
                </div>
                <div class="contact-detail">
                    <div class="contact-detail-icon">🕐</div>
                    <div class="contact-detail-text">
                        <strong>Business Hours</strong>
                        <span>Monday – Friday: 9am – 6pm EST</span>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Jane Doe" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="jane@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What's this about?" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Tell us how we can help…" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Send Message →</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'includes/footer.php'; ?>
