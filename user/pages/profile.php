<?php
/**
 * User Profile Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/User.php';
require_once SRC_PATH . '/models/Order.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();

if (!SessionHelper::isLoggedIn()) {
    SecurityHelper::redirect(BASE_URL . '/user/auth/login.php');
}

$userId    = SessionHelper::getUserId();
$userModel = new User();
$user      = $userModel->findById($userId);

if (!$user) {
    SecurityHelper::redirect(BASE_URL . '/user/auth/logout.php');
}

$orderModel  = new Order();
$orders      = $orderModel->getByUser($userId);
$orderCount  = count($orders);

$error   = '';
$success = '';

// --- Handle profile update ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newName  = SecurityHelper::sanitize($_POST['username']);
    $newEmail = SecurityHelper::sanitize($_POST['email']);

    if (empty($newName) || empty($newEmail)) {
        $error = 'Name and email cannot be empty.';
    } elseif (!SecurityHelper::validateEmail($newEmail)) {
        $error = 'Invalid email address.';
    } else {
        $userModel->update($userId, ['name' => $newName, 'email' => $newEmail]);
        // Refresh session username
        $_SESSION['username'] = $newName;
        $user = $userModel->findById($userId);
        $success = 'Profile updated successfully!';
    }
}

// --- Handle password change ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPw  = $_POST['current_password'];
    $newPw      = $_POST['new_password'];
    $confirmPw  = $_POST['confirm_password'];

    $authCheck = (new User())->authenticate($user['name'], $currentPw);

    if (!$authCheck) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($newPw) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($newPw !== $confirmPw) {
        $error = 'New passwords do not match.';
    } else {
        $userModel->updatePassword($userId, $newPw);
        $success = 'Password changed successfully!';
    }
}

$pageTitle   = 'My Profile';
$currentPage = 'profile';
$customCSS   = ['pages.css', 'login.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- Hero -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color:#fff;text-shadow:2px 4px 10px rgba(0,0,0,0.5);font-weight:700;" data-aos="fade-down">My Profile</h1>
        <p class="lead" style="color:#FFE4C4;text-shadow:1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">
            Welcome back, <?php echo SecurityHelper::escape($user['name']); ?>
        </p>
    </div>
</section>

<div class="container my-5">

    <?php if ($error): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
            <i class="fas fa-exclamation-circle fs-5"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="fas fa-check-circle fs-5"></i> <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Left: Stats + Account Info -->
        <div class="col-md-4" data-aos="fade-right">

            <!-- Avatar Card -->
            <div class="card border-0 shadow-sm text-center mb-4" style="border-radius:20px;overflow:hidden;">
                <div class="py-4 px-3" style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                         style="width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,0.2);border:3px solid var(--gold-accent);">
                        <i class="fas fa-user" style="font-size:2.2rem;color:#fff;"></i>
                    </div>
                    <h4 class="mb-0" style="color:#fff;font-family:var(--font-heading);">
                        <?php echo SecurityHelper::escape($user['name']); ?>
                    </h4>
                    <p style="color:#FFE4C4;font-size:0.9rem;margin:4px 0 0;">
                        <?php echo SecurityHelper::escape($user['email'] ?? 'No email set'); ?>
                    </p>
                </div>
                <div class="card-body py-3" style="background:var(--cream);">
                    <p class="mb-0 text-muted" style="font-size:0.85rem;">
                        <i class="fas fa-calendar-alt me-1" style="color:var(--primary-brown);"></i>
                        Member since <?php echo date('M Y', strtotime($user['created_at'])); ?>
                    </p>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body py-4">
                    <h6 class="fw-bold mb-3" style="color:var(--dark-brown);text-transform:uppercase;letter-spacing:1px;font-size:0.8rem;">Account Stats</h6>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span style="color:var(--dark-brown);"><i class="fas fa-shopping-bag me-2" style="color:var(--primary-brown);"></i>Total Orders</span>
                        <span class="fw-bold" style="color:var(--primary-brown);font-size:1.2rem;"><?php echo $orderCount; ?></span>
                    </div>
                    <?php
                    $delivered  = count(array_filter($orders, fn($o) => $o['status'] === 'delivered'));
                    $pending    = count(array_filter($orders, fn($o) => $o['status'] === 'pending'));
                    $totalSpent = array_sum(array_column($orders, 'total_amount'));
                    ?>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span style="color:var(--dark-brown);"><i class="fas fa-check-double me-2" style="color:#28a745;"></i>Delivered</span>
                        <span class="fw-bold"><?php echo $delivered; ?></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span style="color:var(--dark-brown);"><i class="fas fa-clock me-2" style="color:#ffc107;"></i>Pending</span>
                        <span class="fw-bold"><?php echo $pending; ?></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2">
                        <span style="color:var(--dark-brown);"><i class="fas fa-coins me-2" style="color:var(--gold-accent);"></i>Total Spent</span>
                        <span class="fw-bold" style="color:var(--primary-brown);">Rs. <?php echo number_format($totalSpent, 2); ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Edit Forms -->
        <div class="col-md-8" data-aos="fade-left">

            <!-- Edit Profile -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;overflow:hidden;">
                <div class="card-header py-3 fw-bold"
                     style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));color:white;font-size:1rem;">
                    <i class="fas fa-user-edit me-2"></i> Edit Profile
                </div>
                <div class="card-body p-4">
                    <form method="post" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color:var(--dark-brown);">Username</label>
                                <div style="position:relative;">
                                    <span class="input-icon"><i class="fas fa-user"></i></span>
                                    <input type="text" name="username" class="form-control"
                                           style="border-radius:12px;border:2px solid var(--cream);padding:15px 20px 15px 50px;"
                                           value="<?php echo SecurityHelper::escape($user['name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color:var(--dark-brown);">Email Address</label>
                                <div style="position:relative;">
                                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                           style="border-radius:12px;border:2px solid var(--cream);padding:15px 20px 15px 50px;"
                                           value="<?php echo SecurityHelper::escape($user['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="update_profile" class="btn-submit" style="width:auto;padding:12px 32px;font-size:0.95rem;">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius:20px;overflow:hidden;">
                <div class="card-header py-3 fw-bold"
                     style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));color:white;font-size:1rem;">
                    <i class="fas fa-lock me-2"></i> Change Password
                </div>
                <div class="card-body p-4">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:var(--dark-brown);">Current Password</label>
                            <div style="position:relative;display:flex;align-items:center;">
                                <span class="input-icon" style="z-index:2;"><i class="fas fa-lock"></i></span>
                                <input type="password" name="current_password" id="cur_pw"
                                       class="form-control"
                                       style="border-radius:12px;border:2px solid var(--cream);padding:15px 44px 15px 50px;"
                                       placeholder="Enter current password" required>
                                <button type="button" class="password-toggle" onclick="togglePw('cur_pw',this)"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color:var(--dark-brown);">New Password</label>
                                <div style="position:relative;display:flex;align-items:center;">
                                    <span class="input-icon" style="z-index:2;"><i class="fas fa-key"></i></span>
                                    <input type="password" name="new_password" id="new_pw"
                                           class="form-control"
                                           style="border-radius:12px;border:2px solid var(--cream);padding:15px 44px 15px 50px;"
                                           placeholder="Min 6 characters" required>
                                    <button type="button" class="password-toggle" onclick="togglePw('new_pw',this)"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color:var(--dark-brown);">Confirm New Password</label>
                                <div style="position:relative;display:flex;align-items:center;">
                                    <span class="input-icon" style="z-index:2;"><i class="fas fa-key"></i></span>
                                    <input type="password" name="confirm_password" id="con_pw"
                                           class="form-control"
                                           style="border-radius:12px;border:2px solid var(--cream);padding:15px 44px 15px 50px;"
                                           placeholder="Repeat new password" required>
                                    <button type="button" class="password-toggle" onclick="togglePw('con_pw',this)"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="change_password" class="btn-submit" style="width:auto;padding:12px 32px;font-size:0.95rem;">
                                <i class="fas fa-shield-alt me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Orders Quick View -->
            <?php if (!empty($orders)): ?>
            <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                <div class="card-header py-3 d-flex justify-content-between align-items-center"
                     style="background:linear-gradient(135deg,var(--primary-brown),var(--dark-brown));color:white;font-size:1rem;">
                    <span class="fw-bold"><i class="fas fa-history me-2"></i> Recent Orders</span>
                    <a href="<?php echo BASE_URL; ?>/user/orders/orders.php" style="color:#FFE4C4;font-size:0.85rem;">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0" style="font-size:0.9rem;">
                        <thead style="background:var(--cream);">
                            <tr>
                                <th class="ps-4 py-2">Order</th>
                                <th class="py-2">Date</th>
                                <th class="py-2">Status</th>
                                <th class="py-2 text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($orders, 0, 4) as $order): ?>
                                <?php
                                $sc = [
                                    'pending'   => '#856404', 'confirmed' => '#0C5460',
                                    'preparing' => '#155724', 'delivered' => '#155724',
                                    'cancelled' => '#721C24',
                                ][$order['status']] ?? '#856404';
                                ?>
                                <tr>
                                    <td class="ps-4 py-2 fw-semibold" style="color:var(--dark-brown);">
                                        <a href="<?php echo BASE_URL; ?>/user/orders/order-detail.php?id=<?php echo $order['id']; ?>"
                                           style="color:var(--primary-brown);text-decoration:none;">
                                            #<?php echo str_pad($order['id'], 5, '0', STR_PAD_LEFT); ?>
                                        </a>
                                    </td>
                                    <td class="py-2 text-muted"><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                                    <td class="py-2">
                                        <span style="color:<?php echo $sc; ?>;font-weight:600;font-size:0.82rem;">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="py-2 text-end pe-4 fw-bold" style="color:var(--primary-brown);">
                                        Rs. <?php echo number_format($order['total_amount'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
function togglePw(id, btn) {
    const f = document.getElementById(id);
    const i = btn.querySelector('i');
    if (f.type === 'password') {
        f.type = 'text';
        f.classList.add('toggle-visible');
        i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        f.type = 'password';
        f.classList.remove('toggle-visible');
        i.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
