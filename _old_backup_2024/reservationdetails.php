<?php 
    include('connection.php');

    // Fetch all reservation details from the database
    $query = mysqli_query($conn, "SELECT * FROM reservation");

    if (mysqli_num_rows($query) > 0) {
        $reservations = mysqli_fetch_all($query, MYSQLI_ASSOC);
    } else {
        echo "<script>alert('No reservations found');</script>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="reservationdetails.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="admin-dashboard.html">
            <img src="img/logo.png" alt="Logo" class="navbar-logo">
            <span class="brand-name">Caffeine Brew</span>
        </a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="addproducts.php">Add Products</a></li>
                <li class="nav-item"><a class="nav-link " href="manageproducts.php">Manage Products</a></li>
                <li class="nav-item"><a class="nav-link " href="reservationdetails.php">Reservation Details</a></li>
 
            </ul>
        </div>
    </nav>
        <!-- Banner Section -->
        <section class="banner-section text-center">
            <div class="banner-content">
                <h1>Reservation Details</h1>
            </div>
        </section>

    <div class="reservation-details-container">
        <?php
        // Loop through all reservations and display them
        foreach ($reservations as $reservation) {
            echo '<div class="reservation-details">';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($reservation['name']) . '</p>';
            echo '<p><strong>Phone Number:</strong> ' . htmlspecialchars($reservation['tele']) . '</p>';
            echo '<p><strong>Number of People:</strong> ' . htmlspecialchars($reservation['pax']) . '</p>';
            echo '<p><strong>Date:</strong> ' . htmlspecialchars($reservation['date']) . '</p>';
            echo '</div>';
        }
        ?>
    </div>

</body>
</html>
