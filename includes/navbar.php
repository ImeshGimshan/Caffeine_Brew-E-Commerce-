<!-- Modern Navbar -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top modern-navbar">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/public/index.php">
            <img src="<?php echo IMG_URL; ?>/logo.png" alt="Logo" class="navbar-logo">
            <span class="brand-name"><?php echo APP_NAME; ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'home' ? 'active' : ''; ?>" 
                       href="<?php echo BASE_URL; ?>/public/index.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'about' ? 'active' : ''; ?>" 
                       href="<?php echo BASE_URL; ?>/user/pages/about.php">
                        <i class="fas fa-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'products' ? 'active' : ''; ?>" 
                       href="<?php echo BASE_URL; ?>/user/products/products.php">
                        <i class="fas fa-coffee"></i> Menu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>" 
                       href="<?php echo BASE_URL; ?>/user/pages/contact.php">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/pages/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/orders/orders.php"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/user/auth/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a></li>
                        </ul>
                    <?php else: ?>
                        <a class="nav-link <?php echo ($currentPage ?? '') === 'login' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/user/auth/login.php">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    <?php endif; ?>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link cart-link" href="<?php echo BASE_URL; ?>/user/cart/cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <?php 
                        if (class_exists('Cart')) {
                            $cart = new Cart();
                            $count = $cart->getCount();
                            if ($count > 0) {
                                echo '<span class="cart-badge">' . $count . '</span>';
                            }
                        }
                        ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.modern-navbar {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    padding: 1rem 0;
    transition: all 0.3s ease;
}

.modern-navbar .navbar-brand {
    display: flex;
    align-items: center;
    font-family: var(--font-accent);
    font-size: 1.8rem;
    color: var(--dark-brown);
    font-weight: 700;
    transition: all 0.3s ease;
}

.modern-navbar .navbar-logo {
    height: 50px;
    margin-right: 12px;
    transition: transform 0.3s ease;
}

.modern-navbar .navbar-brand:hover .navbar-logo {
    transform: rotate(360deg);
}

.modern-navbar .brand-name {
    background: linear-gradient(135deg, var(--primary-brown), var(--gold-accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.modern-navbar .nav-link {
    color: var(--dark-brown);
    font-weight: 500;
    margin: 0 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    transition: all 0.3s ease;
    position: relative;
}

.modern-navbar .nav-link i {
    margin-right: 5px;
}

.modern-navbar .nav-link:hover {
    color: var(--warm-orange);
    background: var(--light-cream);
    transform: translateY(-2px);
}

.modern-navbar .nav-link.active {
    color: white;
    background: linear-gradient(135deg, var(--primary-brown), var(--dark-brown));
}

.modern-navbar .cart-link {
    position: relative;
}

.modern-navbar .cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--warm-orange);
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(255,107,53,0.4);
}

.modern-navbar .dropdown-menu {
    border: none;
    border-radius: 15px;
    box-shadow: var(--shadow-lg);
    padding: 0.5rem;
    margin-top: 0.5rem;
}

.modern-navbar .dropdown-item {
    border-radius: 10px;
    padding: 0.6rem 1rem;
    transition: all 0.3s ease;
    color: var(--dark-brown);
}

.modern-navbar .dropdown-item:hover {
    background: var(--light-cream);
    color: var(--warm-orange);
    transform: translateX(5px);
}

.modern-navbar .dropdown-item i {
    margin-right: 10px;
    width: 20px;
}

@media (max-width: 991px) {
    .modern-navbar .navbar-collapse {
        background: white;
        padding: 1rem;
        border-radius: 15px;
        margin-top: 1rem;
        box-shadow: var(--shadow-md);
    }
    
    .modern-navbar .nav-link {
        margin: 0.3rem 0;
    }
}
</style>
