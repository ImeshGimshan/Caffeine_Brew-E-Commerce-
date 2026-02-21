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
$customCSS = ['register.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

<div class="login-container">
    <form method="post" action="">
        <h2>Register</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <input type="text" name="username" required placeholder="Username" class="box"
               value="<?php echo isset($username) ? SecurityHelper::escape($username) : ''; ?>">
        
        <input type="email" name="email" required placeholder="Email" class="box"
               value="<?php echo isset($email) ? SecurityHelper::escape($email) : ''; ?>">
        
        <input type="password" name="password" required placeholder="Password" class="box">
        
        <input type="password" name="confirm_password" required placeholder="Confirm Password" class="box">
        
        <input type="submit" name="register" value="Register" class="btn">
        
        <p class="link">Already have an account? <a href="login.php">Login Now</a></p>
        <p class="link"><a href="<?php echo BASE_URL; ?>/public/index.php">Back to Home</a></p>
    </form>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
