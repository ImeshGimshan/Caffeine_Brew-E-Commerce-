<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>/public/index.php">
        <img src="<?php echo IMG_URL; ?>/logo.png" alt="Logo" class="navbar-logo">
        <span class="brand-name"><?php echo APP_NAME; ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'home' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/public/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'about' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/user/pages/about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/user/pages/contact.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'products' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/user/products/products.php">Products</a>
            </li>
            
            <?php if (SessionHelper::isLoggedIn()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/user/auth/logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'login' ? 'active' : ''; ?>" 
                       href="<?php echo BASE_URL; ?>/user/auth/login.php">Login</a>
                </li>
            <?php endif; ?>
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/user/cart/cart.php">
                    <i class="fas fa-shopping-cart"></i>
                    <?php 
                    if (class_exists('Cart')) {
                        $cart = new Cart();
                        $count = $cart->getCount();
                        if ($count > 0) {
                            echo '<span class="badge badge-danger">' . $count . '</span>';
                        }
                    }
                    ?>
                </a>
            </li>
        </ul>
    </div>
</nav>
