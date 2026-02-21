<?php
/**
 * Admin Login Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Admin.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

// Initialize session
SessionHelper::init();

// Redirect if already logged in as admin
if (SessionHelper::isAdmin()) {
    SecurityHelper::redirect(BASE_URL . '/admin/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = SecurityHelper::sanitize($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $adminModel = new Admin();
        $admin = $adminModel->authenticate($username, $password);
        
        if ($admin) {
            SessionHelper::login($admin['id'], 'admin', [
                'username' => $admin['name']
            ]);
            SecurityHelper::redirect(BASE_URL . '/admin/index.php');
        } else {
            $error = 'Invalid admin credentials';
        }
    }
}

$pageTitle = 'Admin Login';
$customCSS = ['login.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Admin Panel</h2>
            <p class="auth-subtitle">Sign in to manage Caffeine Brew</p>
        </div>
        <div class="auth-body">
            <?php if ($error): ?>
                <div class="alert alert-danger mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="" class="auth-form">
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold" style="color:var(--dark-brown);">Username</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--primary-brown);pointer-events:none;">
                            <i class="fas fa-user-shield"></i>
                        </span>
                        <input type="text" id="username" name="username" class="form-control" required
                               placeholder="Admin username"
                               style="padding-left:40px;"
                               value="<?php echo isset($username) ? SecurityHelper::escape($username) : ''; ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold" style="color:var(--dark-brown);">Password</label>
                    <div style="position:relative;display:flex;align-items:center;">
                        <span style="position:absolute;left:14px;color:var(--primary-brown);pointer-events:none;z-index:2;">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" required
                               placeholder="Admin password"
                               style="padding-left:40px;padding-right:44px;flex:1;">
                        <button type="button" class="password-toggle" onclick="togglePw()"
                                style="position:absolute;right:12px;background:none;border:none;padding:0;color:var(--primary-brown);cursor:pointer;z-index:2;">
                            <i class="fas fa-eye" id="pwIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login" class="btn-submit w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>
        </div>
        <div class="auth-footer" style="text-align:center;padding:20px;border-top:1px solid var(--cream);font-size:0.9rem;">
            <a href="<?php echo BASE_URL; ?>/public/index.php" style="color:var(--primary-brown);text-decoration:none;">
                <i class="fas fa-arrow-left me-1"></i> Back to Site
            </a>
        </div>
    </div>
</div>

<script>
function togglePw() {
    const pw = document.getElementById('password');
    const icon = document.getElementById('pwIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pw.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
