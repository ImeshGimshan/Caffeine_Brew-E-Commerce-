<?php
$_adminData = SessionHelper::get('user_data') ?? [];
$adminUser  = $_adminData['username'] ?? 'Admin';
?>
<!-- Admin Wrapper + Sidebar -->
<div class="admin-wrapper">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-logo">
            <h2><i class="fas fa-mug-hot"></i> Caffeine</h2>
            <p>Administration Panel</p>
        </div>
        <nav class="admin-nav">
            <a href="<?php echo BASE_URL; ?>/admin/index.php"
               class="admin-nav-item <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/products/manage.php"
               class="admin-nav-item <?php echo ($currentPage ?? '') === 'products' ? 'active' : ''; ?>">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/orders/manage.php"
               class="admin-nav-item <?php echo ($currentPage ?? '') === 'orders' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-bag"></i> Orders
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/reservations/manage.php"
               class="admin-nav-item <?php echo ($currentPage ?? '') === 'reservations' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt"></i> Reservations
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/contact/manage.php"
               class="admin-nav-item <?php echo ($currentPage ?? '') === 'contact' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Messages
            </a>
            <hr style="border-color:rgba(255,255,255,0.15); margin: 10px 20px;">
            <a href="<?php echo BASE_URL; ?>/public/index.php" target="_blank" class="admin-nav-item">
                <i class="fas fa-external-link-alt"></i> View Site
            </a>
            <a href="<?php echo BASE_URL; ?>/admin/auth/logout.php" class="admin-nav-item" style="color:#FFCDD2;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
        <div style="padding:20px 30px; border-top:1px solid rgba(255,255,255,0.1); margin-top:auto;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div class="admin-user-avatar" style="flex-shrink:0;">
                    <?php echo strtoupper(substr($adminUser, 0, 1)); ?>
                </div>
                <div>
                    <div style="color:white; font-weight:600; font-size:0.9rem;"><?php echo htmlspecialchars($adminUser); ?></div>
                    <div style="color:#BCAAA4; font-size:0.78rem;">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile toggle button -->
    <button class="d-lg-none btn" id="sidebarToggle"
            style="position:fixed;top:15px;left:15px;z-index:1100;background:var(--primary-brown);color:white;border-radius:8px;padding:8px 12px;">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Sidebar overlay for mobile -->
    <div id="sidebarOverlay" onclick="closeSidebar()"
         style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999;"></div>

    <main class="admin-main">
