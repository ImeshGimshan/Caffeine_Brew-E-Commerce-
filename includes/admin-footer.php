    </main><!-- /.admin-main -->
</div><!-- /.admin-wrapper -->

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<?php if (isset($customJS)): ?>
    <?php foreach ((array)$customJS as $js): ?>
        <script src="<?php echo JS_URL . '/' . $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script>
// Mobile sidebar toggle
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').style.display = 'none';
}

const toggleBtn = document.getElementById('sidebarToggle');
if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
    });
}

// Auto-dismiss alerts after 4s
document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
    setTimeout(function () {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        if (bsAlert) bsAlert.close();
    }, 4000);
});
</script>
</body>
</html>
