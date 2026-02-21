<?php
/**
 * Main Home Page
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/models/Cart.php';

SessionHelper::init();

$pageTitle = 'Home';
$currentPage = 'home';
$customCSS = ['main-page.css'];
$customJS = ['main-page.js'];
?>

<?php include dirname(__DIR__) . '/includes/header.php'; ?>
<?php include dirname(__DIR__) . '/includes/navbar.php'; ?>

<!-- Main Banner Section -->
<section id="main-banner">
    <div id="mainCarousel" class="carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="<?php echo IMG_URL; ?>/slide1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h1>Welcome to Caffeine Brew</h1>
                    <p>Experience the perfect blend of flavor and ambiance</p>
                    <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn carousel-slide-btn btn-lg">Explore Menu</a>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="<?php echo IMG_URL; ?>/slide2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h1>Freshly Brewed Coffee</h1>
                    <p>Made with premium beans from around the world</p>
                    <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn carousel-slide-btn btn-lg">Order Now</a>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="<?php echo IMG_URL; ?>/slide3.jpg" class="d-block w-100" alt="Slide 3">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h1>Delicious Treats</h1>
                    <p>Pair your favorite beverage with our fresh pastries</p>
                    <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn carousel-slide-btn btn-lg">View Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Why Choose Us</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-coffee fa-3x mb-3" style="color: var(--primary-brown)"></i>
                <h4>Premium Quality</h4>
                <p>We source the finest coffee beans and ingredients for an exceptional taste experience.</p>
            </div>
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-shipping-fast fa-3x mb-3" style="color: var(--primary-brown)"></i>
                <h4>Fast Delivery</h4>
                <p>Get your orders delivered quickly and fresh to your doorstep.</p>
            </div>
            <div class="col-md-4 text-center mb-4" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-award fa-3x mb-3" style="color: var(--primary-brown)"></i>
                <h4>Award Winning</h4>
                <p>Recognized for our quality and service by coffee enthusiasts nationwide.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6" data-aos="fade-right">
                <img src="<?php echo IMG_URL; ?>/coffeebeans.jpg" alt="Coffee Beans" class="img-fluid rounded">
            </div>
            <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                <h2>About Caffeine Brew</h2>
                <p>At Caffeine Brew, we're passionate about delivering the perfect cup of coffee. Our journey began with a simple mission: to share our love for exceptional coffee with the world.</p>
                <p>From carefully selected beans to expert brewing techniques, every cup tells a story of dedication and craftsmanship.</p>
                <a href="<?php echo BASE_URL; ?>/user/pages/about.php" class="btn landing-brown-btn">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 text-center text-white" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; background-attachment: fixed;">
    <div class="container">
        <h2 class="mb-4" data-aos="fade-up">Ready to Order?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Browse our menu and discover your new favorite drink today!</p>
        <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn landing-cta-btn btn-lg mr-3" data-aos="fade-up" data-aos-delay="200">View Menu</a>
        <a href="<?php echo BASE_URL; ?>/user/pages/reservation.php" class="btn landing-cta-btn btn-lg" data-aos="fade-up" data-aos-delay="300">Make Reservation</a>
    </div>
</section>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
