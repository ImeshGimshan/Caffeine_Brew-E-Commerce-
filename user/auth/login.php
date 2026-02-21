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

<div class="login-container">
    <form method="post" action="">
        <h2>Login</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <input type="text" name="username" required placeholder="Username" class="box" 
               value="<?php echo isset($username) ? SecurityHelper::escape($username) : ''; ?>">
        
        <input type="password" name="password" required placeholder="Password" class="box">
        
        <input type="submit" name="login" value="Login" class="btn">
        
        <p class="link">Don't have an account? <a href="register.php">Register Now</a></p>
        <p class="link"><a href="<?php echo BASE_URL; ?>/public/index.php">Back to Home</a></p>
    </form>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
