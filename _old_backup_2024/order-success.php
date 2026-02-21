<?php
// Get the order total from the URL query string
$orderTotal = isset($_GET['total']) ? $_GET['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="cart.css">
    <style>
        /* Style for the confirmation box */
        .confirmation-box {
            width: 80%;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
            background-color: #ff8800;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-family: 'Arial', sans-serif;
        }

        .confirmation-box h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .confirmation-box p {
            font-size: 18px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h1>Thank You for Your Purchase!</h1>
        <p>Your order has been successfully placed.</p>
        <p><strong>Total Order Amount: $<?php echo number_format($orderTotal, 2); ?></strong></p>
        <p><strong>Payment Method: Cash on Delivery</strong></p>
        <a href="products.php" class="btn">Continue Shopping</a>
    </div>
</body>
</html>
