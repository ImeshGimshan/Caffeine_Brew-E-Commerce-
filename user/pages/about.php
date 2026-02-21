<?php
/**
 * About Page
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/models/Cart.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';

SessionHelper::init();

$pageTitle = 'About Us';
$currentPage = 'about';
$customCSS = ['about-page.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- About Section -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover;">
    <div class="container text-white">
        <h1 class="display-4">About Caffeine Brew</h1>
        <p class="lead">Your Premium Coffee Destination</p>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Our Story</h2>
            <p>
                Caffeine Brew was founded with a simple passion: to serve the perfect cup of coffee. 
                What started as a small dream has grown into a beloved destination for coffee enthusiasts 
                throughout the region.
            </p>
            <p>
                We believe that great coffee is more than just a beverage—it's an experience. From the 
                moment you step through our doors (or visit our online store), we're committed to delivering 
                exceptional quality and service.
            </p>
        </div>
        <div class="col-md-6">
            <img src="<?php echo IMG_URL; ?>/coffeebeans.jpg" alt="Coffee Beans" class="img-fluid rounded">
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6 order-md-2">
            <h2>Our Mission</h2>
            <p>
                At Caffeine Brew, our mission is to craft exceptional coffee experiences that bring people 
                together. We source only the finest beans from sustainable farms around the world and prepare 
                each cup with care and expertise.
            </p>
            <p>
                Beyond great coffee, we're committed to building a community of coffee lovers and creating 
                a welcoming space where everyone feels at home.
            </p>
        </div>
        <div class="col-md-6 order-md-1">
            <img src="<?php echo IMG_URL; ?>/banner2.jpg" alt="Coffee Shop" class="img-fluid rounded">
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h2>Why Choose Us?</h2>
        </div>
        <div class="col-md-4 text-center mt-4">
            <i class="fas fa-coffee fa-4x text-primary mb-3"></i>
            <h4>Premium Quality</h4>
            <p>We source the finest coffee beans and ingredients from around the world.</p>
        </div>
        <div class="col-md-4 text-center mt-4">
            <i class="fas fa-users fa-4x text-primary mb-3"></i>
            <h4>Expert Baristas</h4>
            <p>Our skilled team is passionate about crafting the perfect cup every time.</p>
        </div>
        <div class="col-md-4 text-center mt-4">
            <i class="fas fa-heart fa-4x text-primary mb-3"></i>
            <h4>Community Focus</h4>
            <p>We're more than a coffee shop—we're a gathering place for our community.</p>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h2>Visit Us Today</h2>
            <p class="lead">Experience the Caffeine Brew difference for yourself!</p>
            <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn btn-primary btn-lg mr-2">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="<?php echo BASE_URL; ?>/user/pages/contact.php" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
