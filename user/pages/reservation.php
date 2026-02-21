<?php
/**
 * Reservation Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation'])) {
    $name    = SecurityHelper::sanitize($_POST['name']);
    $email   = SecurityHelper::sanitize($_POST['email']);
    $phone   = SecurityHelper::sanitize($_POST['phone']);
    $date    = SecurityHelper::sanitize($_POST['date']);
    $time    = SecurityHelper::sanitize($_POST['time']);
    $guests  = (int) $_POST['guests'];
    $message = SecurityHelper::sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || $guests < 1) {
        $error = 'Please fill in all required fields.';
    } elseif (!SecurityHelper::validateEmail($email)) {
        $error = 'Invalid email format.';
    } elseif (strtotime($date) < strtotime('today')) {
        $error = 'Please choose a future date.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("INSERT INTO reservation (name, email, phone, date, time, guests, message, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssss", $name, $email, $phone, $date, $time, $guests, $message);

        if ($stmt->execute()) {
            $success = 'Thank you! Your reservation has been submitted. We will confirm shortly.';
            $_POST   = [];
        } else {
            $error = 'Failed to submit reservation. Please try again.';
        }
    }
}

$pageTitle  = 'Make a Reservation';
$currentPage = 'reservation';
$customCSS  = ['pages.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Hero — same style as About / Contact pages -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">Make a Reservation</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">Reserve your table at Caffeine Brew</p>
    </div>
</section>

<!-- Reservation Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-container">

            <!-- Info Panel -->
            <div class="contact-info" data-aos="fade-right">
                <h3>Reservation Info</h3>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="contact-details">
                        <h4>Our Location</h4>
                        <p>123 Coffee Street<br>Colombo 00300<br>Sri Lanka</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <div class="contact-details">
                        <h4>Opening Hours</h4>
                        <p>Monday – Friday: 7:00 AM – 10:00 PM<br>Saturday – Sunday: 8:00 AM – 11:00 PM</p>
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
                    <div class="contact-icon"><i class="fas fa-info-circle"></i></div>
                    <div class="contact-details">
                        <h4>Good to Know</h4>
                        <p>Reservations are confirmed via email. Walk-ins are also welcome subject to availability.</p>
                    </div>
                </div>
            </div>

            <!-- Reservation Form -->
            <div class="contact-form-wrapper" data-aos="fade-left" data-aos-delay="100">
                <h3>Book Your Table</h3>

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
                        <label>Phone Number *</label>
                        <input type="tel" name="phone" required
                               value="<?php echo isset($_POST['phone']) ? SecurityHelper::escape($_POST['phone']) : ''; ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date *</label>
                                <input type="date" name="date" required
                                       min="<?php echo date('Y-m-d'); ?>"
                                       value="<?php echo isset($_POST['date']) ? SecurityHelper::escape($_POST['date']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Time *</label>
                                <select name="time" required>
                                    <option value="">Select a time</option>
                                    <?php
                                    $selectedTime = $_POST['time'] ?? '';
                                    $slots = ['07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30',
                                              '11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30',
                                              '15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30',
                                              '19:00','19:30','20:00','20:30','21:00','21:30'];
                                    foreach ($slots as $slot):
                                        $sel = $selectedTime === $slot ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $slot; ?>" <?php echo $sel; ?>>
                                            <?php echo date('g:i A', strtotime($slot)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Number of Guests *</label>
                        <input type="number" name="guests" min="1" max="20" required
                               value="<?php echo isset($_POST['guests']) ? (int)$_POST['guests'] : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Special Requests</label>
                        <textarea name="message" rows="4"><?php echo isset($_POST['message']) ? SecurityHelper::escape($_POST['message']) : ''; ?></textarea>
                    </div>

                    <button type="submit" name="submit_reservation" class="btn contact-submit-btn">
                        <i class="fas fa-calendar-check"></i> Confirm Reservation
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
