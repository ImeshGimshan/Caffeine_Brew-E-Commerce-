<?php
/**
 * User Registration Page
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = SecurityHelper::sanitize($_POST['username']);
    $email = SecurityHelper::sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields';
    } elseif (!SecurityHelper::validateEmail($email)) {
        $error = 'Invalid email format';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        $userModel = new User();
        
        // Check if username already exists
        if ($userModel->usernameExists($username)) {
            $error = 'Username already exists';
        } else {
            // Create user
            $userId = $userModel->create($username, $password, $email);
            
            if ($userId) {
                $success = 'Registration successful! You can now login.';
                // Auto-login after registration
                SessionHelper::login($userId, 'user', [
                    'username' => $username,
                    'email' => $email
                ]);
                
                // Redirect after 2 seconds
                header("refresh:2;url=" . BASE_URL . "/public/index.php");
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}

$pageTitle = 'Register';
$customCSS = ['login.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">

        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Create Account</h2>
            <p>Join the Caffeine Brew community</p>
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
                               placeholder="Choose a username"
                               value="<?php echo isset($username) ? SecurityHelper::escape($username) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" required
                               placeholder="Enter your email"
                               value="<?php echo isset($email) ? SecurityHelper::escape($email) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" required
                               placeholder="Create a password (min 6 chars)">
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password" required
                               placeholder="Repeat your password">
                        <button type="button" class="password-toggle" onclick="togglePassword('confirm_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="register" class="btn-submit">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>

            </form>
        </div>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in</a>
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
