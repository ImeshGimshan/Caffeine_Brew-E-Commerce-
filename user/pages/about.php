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
$customCSS = ['pages.css'];
?>

<?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>
<?php include dirname(__DIR__, 2) . '/includes/navbar.php'; ?>

<!-- About Section -->
<section class="about-hero text-center py-5" style="background: linear-gradient(rgba(62,39,35,0.75), rgba(62,39,35,0.75)), url('<?php echo IMG_URL; ?>/banner.jpg'); background-size: cover; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4" style="color: #fff; text-shadow: 2px 4px 10px rgba(0,0,0,0.5); font-weight: 700;" data-aos="fade-down">About Caffeine Brew</h1>
        <p class="lead" style="color: #FFE4C4; text-shadow: 1px 2px 6px rgba(0,0,0,0.4);" data-aos="fade-up" data-aos-delay="150">Your Premium Coffee Destination</p>
    </div>
</section>

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6" data-aos="fade-right">
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
        <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
            <img src="<?php echo IMG_URL; ?>/coffeebeans.jpg" alt="Coffee Beans" class="img-fluid rounded">
        </div>
    </div>
    
    <div class="row align-items-center mt-5">
        <div class="col-md-6 order-md-2" data-aos="fade-left">
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
        <div class="col-md-6 order-md-1" data-aos="fade-right" data-aos-delay="100">
            <img src="<?php echo IMG_URL; ?>/banner2.jpg" alt="Coffee Shop" class="img-fluid rounded">
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center" data-aos="fade-up">
            <h2>Visit Us Today</h2>
            <p class="lead">Experience the Caffeine Brew difference for yourself!</p>
            <a href="<?php echo BASE_URL; ?>/user/products/products.php" class="btn about-cta-btn btn-lg mr-2" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-shopping-cart"></i> Shop Now
            </a>
            <a href="<?php echo BASE_URL; ?>/user/pages/contact.php" class="btn about-cta-btn btn-lg" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>
    </div>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
