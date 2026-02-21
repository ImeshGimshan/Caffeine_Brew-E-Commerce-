<!-- Modern Footer -->
<footer class="modern-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="footer-brand">
                    <h3 class="brand-name"><?php echo APP_NAME; ?></h3>
                    <p class="mt-3">Your premium coffee destination. Quality brews, delightful treats, and exceptional service that keeps you coming back for more.</p>
                    <div class="social-links mt-4">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo BASE_URL; ?>/public/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/pages/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/products/products.php"><i class="fas fa-chevron-right"></i> Our Menu</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/user/pages/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <h5 class="footer-title">Opening Hours</h5>
                <ul class="footer-hours">
                    <li><span>Monday - Friday</span> <strong>7:00 AM - 10:00 PM</strong></li>
                    <li><span>Saturday</span> <strong>8:00 AM - 11:00 PM</strong></li>
                    <li><span>Sunday</span> <strong>9:00 AM - 9:00 PM</strong></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <h5 class="footer-title">Contact Info</h5>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>123 Coffee Street<br>Colombo, Sri Lanka</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+94 123 456 789</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@caffeinebrew.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved. | Crafted with <i class="fas fa-heart"></i> by Caffeine Team</p>
        </div>
    </div>
</footer>

<style>
.modern-footer {
    background: linear-gradient(135deg, #2C1810 0%, #3E2723 50%, #2C1810 100%);
    color: #D7CCC8;
    padding: 60px 0 20px;
    margin-top: 80px;
}

.modern-footer .footer-brand .brand-name {
    font-family: var(--font-accent);
    font-size: 2rem;
    background: linear-gradient(135deg, var(--gold-accent), #FFD700);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0;
}

.modern-footer p {
    color: #BCAAA4;
    line-height: 1.8;
}

.modern-footer .social-links {
    display: flex;
    gap: 15px;
}

.modern-footer .social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold-accent);
    transition: all 0.3s ease;
}

.modern-footer .social-link:hover {
    background: var(--gold-accent);
    color: var(--dark-brown);
    transform: translateY(-5px);
}

.modern-footer .footer-title {
    color: white;
    font-family: var(--font-heading);
    font-size: 1.3rem;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

.modern-footer .footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: var(--gold-accent);
    border-radius: 2px;
}

.modern-footer .footer-links {
    list-style: none;
    padding: 0;
}

.modern-footer .footer-links li {
    margin-bottom: 12px;
}

.modern-footer .footer-links a {
    color: #BCAAA4;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modern-footer .footer-links a:hover {
    color: var(--gold-accent);
    transform: translateX(5px);
}

.modern-footer .footer-links i {
    font-size: 0.7rem;
}

.modern-footer .footer-hours {
    list-style: none;
    padding: 0;
}

.modern-footer .footer-hours li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 10px;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}

.modern-footer .footer-hours span {
    color: #BCAAA4;
}

.modern-footer .footer-hours strong {
    color: var(--gold-accent);
}

.modern-footer .footer-contact {
    list-style: none;
    padding: 0;
}

.modern-footer .footer-contact li {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    align-items: flex-start;
}

.modern-footer .footer-contact i {
    color: var(--gold-accent);
    font-size: 1.2rem;
    margin-top: 3px;
}

.modern-footer .footer-contact span {
    color: #BCAAA4;
    line-height: 1.6;
}

.modern-footer .footer-divider {
    border-color: rgba(255,255,255,0.1);
    margin: 40px 0 25px;
}

.modern-footer .footer-bottom {
    text-align: center;
}

.modern-footer .footer-bottom p {
    color: #8D6E63;
    margin: 0;
    font-size: 0.95rem;
}

.modern-footer .footer-bottom i.fa-heart {
    color: var(--warm-orange);
    animation: heartbeat 1.5s infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@media (max-width: 768px) {
    .modern-footer {
        padding: 40px 0 20px;
    }
    
    .modern-footer .footer-hours li {
        flex-direction: column;
        gap: 5px;
    }
}
</style>

<!-- Bootstrap 5 JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
</script>

<!-- Custom JS -->
<?php if (isset($customJS)): ?>
    <?php foreach ((array)$customJS as $js): ?>
        <script src="<?php echo JS_URL . '/' . $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
