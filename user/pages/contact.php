<?php
/**
 * Contact Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = SecurityHelper::sanitize($_POST['name']);
    $email = SecurityHelper::sanitize($_POST['email']);
    $phone = SecurityHelper::sanitize($_POST['phone']);
    $message = SecurityHelper::sanitize($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields';
    } elseif (!SecurityHelper::validateEmail($email)) {
        $error = 'Invalid email format';
    } else {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO contactus (name, email, phone, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        
        if ($stmt->execute()) {
            $success = 'Thank you! Your message has been sent successfully.';
            // Clear form
            $_POST = [];
        } else {
            $error = 'Failed to send message. Please try again.';
        }
    }
}

$pageTitle = 'Contact Us';
$currentPage = 'contact';
$customCSS = ['pages.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Contact Hero — same style as About page -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner3.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">Contact Us</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">We'd love to hear from you!</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-container">

            <!-- Contact Information -->
            <div class="contact-info" data-aos="fade-right">
                <h3>Get in Touch</h3>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-details">
                        <h4>Our Address</h4>
                        <p>123 Coffee Street<br>Colombo 00300<br>Sri Lanka</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <div class="contact-details">
                        <h4>Phone</h4>
                        <p>+94 11 234 5678<br>+94 77 123 4567</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div class="contact-details">
                        <h4>Email</h4>
                        <p>info@caffeinebrew.com<br>support@caffeinebrew.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div class="contact-details">
                        <h4>Business Hours</h4>
                        <p>Monday – Friday: 7:00 AM – 10:00 PM<br>Saturday – Sunday: 8:00 AM – 11:00 PM</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="mt-4">
                    <h4 style="color: white; margin-bottom: 15px;">Follow Us</h4>
                    <div class="d-flex gap-3">
                        <a href="#" class="contact-social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="contact-social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="contact-social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="contact-social-btn"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper" data-aos="fade-left" data-aos-delay="100">
                <h3>Send a Message</h3>

                <?php if ($error): ?>
                    <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success mb-4"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="post" action="" class="contact-form">
                    <div class="form-group">
                        <label>Your Name *</label>
                        <input type="text" name="name" required
                               value="<?php echo isset($_POST['name']) ? SecurityHelper::escape($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? SecurityHelper::escape($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone"
                               value="<?php echo isset($_POST['phone']) ? SecurityHelper::escape($_POST['phone']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Message *</label>
                        <textarea name="message" rows="5" required><?php echo isset($_POST['message']) ? SecurityHelper::escape($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" name="submit_contact" class="btn contact-submit-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
