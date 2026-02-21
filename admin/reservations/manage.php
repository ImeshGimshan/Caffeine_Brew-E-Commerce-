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

<div class="container-fluid mt-4">
    <h1 class="mb-4"><i class="fas fa-calendar"></i> Manage Reservations</h1>
    
    <div class="card">
        <div class="card-body">
            <?php if (empty($reservations)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No reservations found.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
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
                                    <td><?php echo SecurityHelper::escape($reservation['name']); ?></td>
                                    <td><?php echo SecurityHelper::escape($reservation['email']); ?></td>
                                    <td><?php echo SecurityHelper::escape($reservation['phone']); ?></td>
                                    <td><?php echo $reservation['date']; ?></td>
                                    <td><?php echo $reservation['time']; ?></td>
                                    <td><?php echo $reservation['guests']; ?></td>
                                    <td><?php echo SecurityHelper::escape(substr($reservation['message'] ?? '', 0, 30)); ?>...</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
