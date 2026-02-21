<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="products.css"> 
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="img/logo.png" alt="Logo" class="navbar-logo">
            <span class="brand-name">Caffeine Brew</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="main-page.html">Home</a></li>
                <li class="nav-item"><a class="nav-link " href="about-page.html">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contactusDetails.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link active" href="products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Banner Section -->
    <section class="banner-section text-center">
        <div class="banner-content">
            <h1>OUR MENU</h1>
            <p>Choose from our delicious selection</p>
        </div>
    </section>

    <!-- Sidebar Section -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <h4 class="list-group-item active">Categories</h4>
                    <a href="products.php" class="list-group-item">All</a>
                    <a href="?category=Coffees" class="list-group-item">Coffee</a>
                    <a href="?category=Icecreams" class="list-group-item">Ice Cream</a>
                    <a href="?category=Cakes" class="list-group-item">Cakes</a>
                    <a href="?category=Buns" class="list-group-item">Buns</a>
                    <a href="?category=Pizza" class="list-group-item">Pizza</a>
                    <a href="?category=Bubble Tea" class="list-group-item">Bubble Tea</a>
                    <a href="?category=Juice" class="list-group-item">Juice</a>
                </div>
            </div>

            <!-- Products Section -->
            <div class="col-md-9">
                <section class="menu-section container my-5">
                    <div class="row">
                        <?php
                            include 'connection.php';

                            // Check if a category filter is applied
                            $category_filter = isset($_GET['category']) ? $_GET['category'] : '';

                            // SQL query to fetch products, optionally filtered by category
                            if ($category_filter) {
                                $sql = "SELECT * FROM products WHERE category = '$category_filter'";
                            } else {
                                $sql = "SELECT * FROM products";
                            }

                            $result = mysqli_query($conn, $sql);

                            // Check if there are any products
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through all products and display them
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div class="product-card col-md-4">';
                                    echo '<img src="proImg/' . $row['img'] . '" alt="' . $row['name'] . '" class="product-image">';
                                    echo '<h3 class="product-name">' . $row['name'] . '</h3>';
                                    echo '<p class="product-price">' ."$". $row['price'] . '</p>';
                                    echo '<form method="POST" action="products.php">';
                                    echo '<input type="hidden" name="product-name" value="' . $row['name'] . '">';
                                    echo '<input type="hidden" name="product-price" value="' . $row['price'] . '">';
                                    echo '<input type="hidden" name="product-image" value="' . $row['img'] . '">';
                                    echo '<button type="submit" class="btn" name="add_to_cart">Add to Cart</button>';
                                    echo '</form>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<script>alert('No products found!');</script>";
                            }

                            if (isset($_POST['add_to_cart'])) {
                                $product_name = $_POST['product-name'];
                                $product_price = $_POST['product-price'];
                                $product_image = $_POST['product-image'];
                                $product_quantity = 1;

                                //enter the product once in the cart
                                $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name'");
                                if (mysqli_num_rows($select_cart) > 0) {
                                    echo "<script>alert('Product already in cart!');</script>";
                                    exit();
                                }
                                else{
                                    // Add product to cart
                                    $sql = "INSERT INTO cart (name, price, image , quantity) VALUES ('$product_name', '$product_price', '$product_image', '$product_quantity')";
                                    if (mysqli_query($conn, $sql)) {
                                        echo "<script>alert('Product added to cart!');</script>";
                                    } else {
                                        echo "<script>alert('Failed to add product to cart!');</script>";
                                    }

                                }
                            }

                            // Close the database connection
                            mysqli_close($conn);
                        ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>
