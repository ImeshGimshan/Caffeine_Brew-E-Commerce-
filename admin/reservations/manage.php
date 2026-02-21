<?php
/**
 * Manage Reservations - Admin
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Reservation.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::init();
SessionHelper::requireAdmin();

$reservationModel = new Reservation();
$reservations = $reservationModel->getAll();

$pageTitle = 'Manage Reservations';
$currentPage = 'reservations';
$customCSS = ['admin.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/admin-navbar.php'; ?>

<!-- Page Header -->
<div class="admin-header">
    <h1><i class="fas fa-calendar-alt me-2"></i> Manage Reservations</h1>
    <div class="admin-header-actions">
        <span style="color:var(--medium-brown);font-size:0.9rem;">
            <i class="fas fa-info-circle me-1"></i> <?php echo count($reservations); ?> total reservations
        </span>
    </div>
</div>

<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-list me-2" style="color:var(--gold-accent);"></i> All Reservations
            <span class="badge ms-2" style="background:var(--primary-brown);font-size:0.8rem;"><?php echo count($reservations); ?></span>
        </h2>
    </div>

    <?php if (empty($reservations)): ?>
        <div class="text-center py-5" style="color:var(--medium-brown);">
            <i class="fas fa-calendar-times fa-3x mb-3" style="opacity:0.4;"></i>
            <p>No reservations found.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo $reservation['id']; ?></td>
                            <td><strong><?php echo SecurityHelper::escape($reservation['name']); ?></strong></td>
                            <td><?php echo SecurityHelper::escape($reservation['email']); ?></td>
                            <td><?php echo SecurityHelper::escape($reservation['phone']); ?></td>
                            <td><?php echo date('d M Y', strtotime($reservation['date'])); ?></td>
                            <td><?php echo $reservation['time']; ?></td>
                            <td>
                                <span class="status-badge pending"><?php echo $reservation['guests']; ?> guests</span>
                            </td>
                            <td style="max-width:200px;color:var(--medium-brown);">
                                <?php echo SecurityHelper::escape(substr($reservation['message'] ?? '', 0, 40)); ?><?php echo strlen($reservation['message'] ?? '') > 40 ? '…' : ''; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include dirname(__DIR__, 2) . '/includes/admin-footer.php'; ?>
