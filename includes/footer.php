<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5><?php echo APP_NAME; ?></h5>
                <p>Your premium coffee destination. Quality brews, delightful treats, and exceptional service.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo BASE_URL; ?>/public/index.php" class="text-white">Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/pages/about.php" class="text-white">About</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/products/products.php" class="text-white">Products</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/pages/contact.php" class="text-white">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Info</h5>
                <p>
                    <i class="fas fa-phone"></i> +94 123 456 789<br>
                    <i class="fas fa-envelope"></i> info@caffeinebrew.com<br>
                    <i class="fas fa-map-marker-alt"></i> Colombo, Sri Lanka
                </p>
            </div>
        </div>
        <hr class="bg-white">
        <div class="text-center">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<?php if (isset($customJS)): ?>
    <?php foreach ((array)$customJS as $js): ?>
        <script src="<?php echo JS_URL . '/' . $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
