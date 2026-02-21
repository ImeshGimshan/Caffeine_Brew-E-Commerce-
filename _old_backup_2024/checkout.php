<?php
include "connection.php";

// Get the grand total passed from the cart page
$grandTotal = isset($_GET['total']) ? $_GET['total'] : 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderItems = ''; // To store the list of ordered items
    $orderTotal = $_POST['total'];

    // Get the cart items
    $cartQuery = "SELECT * FROM cart";
    $cartResult = mysqli_query($conn, $cartQuery);

    if ($cartResult) {
        while ($cartItem = mysqli_fetch_assoc($cartResult)) {
            $product_id = $cartItem['cid'];
            $product_name = $cartItem['name'];
            $product_price = $cartItem['price'];
            $product_quantity = $cartItem['quantity'];
            $total_price = $product_price * $product_quantity;

            // Save each product to the orders table
            $insertOrderQuery = "INSERT INTO orders (pid, name, price, quantity, total) 
                                 VALUES ($product_id, '$product_name', $product_price, $product_quantity, $total_price)";
            mysqli_query($conn, $insertOrderQuery);
        }

        // Clear the cart after order
        $clearCartQuery = "DELETE FROM cart";
        mysqli_query($conn, $clearCartQuery);
    }

    // Redirect to the success page with the total amount
    header("Location: order-success.php?total=$orderTotal");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="container">
        <section class="checkout">
            <h1 class="heading">Checkout</h1>
            <p>Total Amount: $<?php echo number_format($grandTotal, 2); ?></p>
            <form method="POST" action="checkout.php">
                <input type="hidden" name="total" value="<?php echo $grandTotal; ?>">
                <button type="submit" class="btn btn-primary">Confirm Order</button>
            </form>
            <p><strong>Payment Method: Cash on Delivery</strong></p>
        </section>
    </div>
</body>
</html>
