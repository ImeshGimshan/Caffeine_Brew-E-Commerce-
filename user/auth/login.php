<?php
/**
 * User Login Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/User.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

// Initialize session
SessionHelper::init();

// Redirect if already logged in
if (SessionHelper::isLoggedIn()) {
    SecurityHelper::redirect(BASE_URL . '/public/index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = SecurityHelper::sanitize($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $userModel = new User();
        $user = $userModel->authenticate($username, $password);
        
        if ($user) {
            SessionHelper::login($user['id'], 'user', [
                'username' => $user['name'],
                'email' => $user['email'] ?? ''
            ]);
            SecurityHelper::redirect(BASE_URL . '/public/index.php');
        } else {
            $error = 'Invalid username or password';
        }
    }
}

$pageTitle = 'Login';
$customCSS = ['login.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">

        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Sign in to your Caffeine Brew account</p>
        </div>

        <div class="auth-body">
            <form class="auth-form" method="post" action="">

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="username" name="username" required
                               placeholder="Enter your username"
                               value="<?php echo isset($username) ? SecurityHelper::escape($username) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" required
                               placeholder="Enter your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="login" class="btn-submit">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>

            </form>
        </div>

        <div class="auth-footer">
            Don't have an account? <a href="register.php">Create one</a>
            &nbsp;&bull;&nbsp;
            <a href="<?php echo BASE_URL; ?>/public/index.php">Back to Home</a>
        </div>

    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        field.classList.add('toggle-visible');
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        field.classList.remove('toggle-visible');
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
