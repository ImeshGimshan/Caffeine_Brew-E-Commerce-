<?php
/**
 * Admin Dashboard
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once SRC_PATH . '/models/Product.php';
require_once SRC_PATH . '/models/Reservation.php';
require_once SRC_PATH . '/models/Order.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$productModel   = new Product();
$reservationModel = new Reservation();
$orderModel     = new Order();

// Get statistics
$allProducts      = $productModel->getAll();
$totalProducts    = count($allProducts);
$allReservations  = $reservationModel->getAll();
$totalReservations = count($allReservations);
$allOrders        = $orderModel->getAll();
$totalOrders      = count($allOrders);

// Revenue from completed/delivered orders
$totalRevenue = 0;
foreach ($allOrders as $o) {
    if (in_array($o['status'] ?? '', ['delivered', 'completed'])) {
        $totalRevenue += floatval($o['total_amount'] ?? 0);
    }
}

$pageTitle  = 'Admin Dashboard';
$currentPage = 'dashboard';
$customCSS  = ['admin.css'];
?>

<?php include dirname(__DIR__) . '/includes/header.php'; ?>
<?php include dirname(__DIR__) . '/includes/admin-navbar.php'; ?>

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-tachometer-alt me-2"></i> Dashboard</h1>
    <div class="admin-header-actions">
        <span style="color:var(--medium-brown); font-size:0.9rem;">
            <i class="fas fa-clock me-1"></i> <?php echo date('l, d M Y'); ?>
        </span>
        <a href="<?php echo BASE_URL; ?>/admin/products/add.php"
           class="btn btn-sm" style="background:var(--primary-brown);color:white;border-radius:8px;padding:8px 18px;">
            <i class="fas fa-plus me-1"></i> Add Product
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card products">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-value"><?php echo $totalProducts; ?></div>
        <div class="stat-label">Total Products</div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i>
            <a href="<?php echo BASE_URL; ?>/admin/products/manage.php" style="color:inherit;text-decoration:none;">Manage →</a>
        </div>
    </div>

    <div class="stat-card orders">
        <div class="stat-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-value"><?php echo $totalOrders; ?></div>
        <div class="stat-label">Total Orders</div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i>
            <a href="<?php echo BASE_URL; ?>/admin/orders/manage.php" style="color:inherit;text-decoration:none;">View Orders →</a>
        </div>
    </div>

    <div class="stat-card revenue">
        <div class="stat-icon">
            <i class="fas fa-wallet"></i>
        </div>
        <div class="stat-value">Rs.<?php echo number_format($totalRevenue, 0); ?></div>
        <div class="stat-label">Revenue (Delivered)</div>
        <div class="stat-trend up">
            <i class="fas fa-chart-line"></i> Completed orders
        </div>
    </div>

    <div class="stat-card customers">
        <div class="stat-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-value"><?php echo $totalReservations; ?></div>
        <div class="stat-label">Reservations</div>
        <div class="stat-trend up">
            <i class="fas fa-arrow-up"></i>
            <a href="<?php echo BASE_URL; ?>/admin/reservations/manage.php" style="color:inherit;text-decoration:none;">View All →</a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-bolt me-2" style="color:var(--gold-accent);"></i> Quick Actions</h2>
    </div>
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="<?php echo BASE_URL; ?>/admin/products/add.php"
               class="d-flex flex-column align-items-center justify-content-center gap-2 p-4 rounded-3 text-decoration-none"
               style="background:linear-gradient(135deg,#E3F2FD,#BBDEFB);color:#1565C0;transition:all .3s;height:120px;"
               onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-plus fa-2x"></i>
                <strong>Add Product</strong>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo BASE_URL; ?>/admin/products/manage.php"
               class="d-flex flex-column align-items-center justify-content-center gap-2 p-4 rounded-3 text-decoration-none"
               style="background:linear-gradient(135deg,#E8F5E9,#C8E6C9);color:#2E7D32;transition:all .3s;height:120px;"
               onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-edit fa-2x"></i>
                <strong>Manage Products</strong>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo BASE_URL; ?>/admin/orders/manage.php"
               class="d-flex flex-column align-items-center justify-content-center gap-2 p-4 rounded-3 text-decoration-none"
               style="background:linear-gradient(135deg,#FFF8E1,#FFECB3);color:#F57F17;transition:all .3s;height:120px;"
               onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-shopping-bag fa-2x"></i>
                <strong>View Orders</strong>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo BASE_URL; ?>/admin/reservations/manage.php"
               class="d-flex flex-column align-items-center justify-content-center gap-2 p-4 rounded-3 text-decoration-none"
               style="background:linear-gradient(135deg,#F3E5F5,#E1BEE7);color:#6A1B9A;transition:all .3s;height:120px;"
               onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
                <i class="fas fa-calendar-check fa-2x"></i>
                <strong>Reservations</strong>
            </a>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<?php
$recentOrders = array_slice($allOrders, 0, 5);
if (!empty($recentOrders)):
?>
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-clock me-2" style="color:var(--gold-accent);"></i> Recent Orders</h2>
        <a href="<?php echo BASE_URL; ?>/admin/orders/manage.php"
           class="btn-action view" style="text-decoration:none;">View All</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                    <?php
                    $status = $order['status'] ?? 'pending';
                    $badgeClass = match($status) {
                        'delivered','completed' => 'completed',
                        'pending'  => 'pending',
                        default    => 'inactive'
                    };
                    ?>
                    <tr>
                        <td><strong>#<?php echo $order['id']; ?></strong></td>
                        <td><?php echo SecurityHelper::escape($order['customer_name'] ?? 'N/A'); ?></td>
                        <td><?php echo date('d M Y', strtotime($order['created_at'] ?? 'now')); ?></td>
                        <td>Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><span class="status-badge <?php echo $badgeClass; ?>"><?php echo ucfirst($status); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php include dirname(__DIR__) . '/includes/admin-footer.php'; ?>
