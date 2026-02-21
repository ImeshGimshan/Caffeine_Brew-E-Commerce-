<!-- Admin Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>/admin/index.php">
        <i class="fas fa-user-shield"></i> Admin Panel
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/admin/index.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'products' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/admin/products/manage.php">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'reservations' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/admin/reservations/manage.php">
                    <i class="fas fa-calendar"></i> Reservations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/admin/contact/manage.php">
                    <i class="fas fa-envelope"></i> Contact Messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/public/index.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/admin/auth/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>
