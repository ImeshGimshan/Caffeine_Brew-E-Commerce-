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

<!-- Contact Hero -->
<section class="contact-hero text-center py-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?php echo IMG_URL; ?>/banner3.jpg'); background-size: cover;">
    <div class="container text-white">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">We'd love to hear from you!</p>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <!-- Contact Form -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-envelope"></i> Send us a Message</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" name="name" class="form-control" required
                                   value="<?php echo isset($_POST['name']) ? SecurityHelper::escape($_POST['name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control" required
                                   value="<?php echo isset($_POST['email']) ? SecurityHelper::escape($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" class="form-control"
                                   value="<?php echo isset($_POST['phone']) ? SecurityHelper::escape($_POST['phone']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea name="message" class="form-control" rows="5" required><?php echo isset($_POST['message']) ? SecurityHelper::escape($_POST['message']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" name="submit_contact" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-info-circle"></i> Contact Information</h4>
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-map-marker-alt text-danger"></i> Address</h5>
                    <p>123 Coffee Street<br>Colombo 00300<br>Sri Lanka</p>
                    
                    <h5><i class="fas fa-phone text-primary"></i> Phone</h5>
                    <p>+94 11 234 5678<br>+94 77 123 4567</p>
                    
                    <h5><i class="fas fa-envelope text-warning"></i> Email</h5>
                    <p>info@caffeinebrew.com<br>support@caffeinebrew.com</p>
                    
                    <h5><i class="fas fa-clock text-info"></i> Business Hours</h5>
                    <p>
                        Monday - Friday: 7:00 AM - 10:00 PM<br>
                        Saturday - Sunday: 8:00 AM - 11:00 PM
                    </p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4><i class="fas fa-share-alt"></i> Follow Us</h4>
                </div>
                <div class="card-body text-center">
                    <a href="#" class="btn btn-primary btn-lg mr-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-info btn-lg mr-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-danger btn-lg mr-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-dark btn-lg"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
