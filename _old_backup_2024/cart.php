<?php
    include "connection.php";

    // Query to get cart items
    $sql = "SELECT * FROM cart";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $grandTotal = 0; // Variable to store the total price

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="container">
        <section class="scart">
            <h1 class="heading">Cart</h1>
            <table>
                <thead>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $product_id = $row['cid'];
                        $product_name = $row['name'];
                        $product_price = $row['price'];
                        $product_quantity = $row['quantity'];
                        $total_price = $product_price * $product_quantity;

                        // Add the total price of this product to the grand total
                        $grandTotal += $total_price;

                        echo "<tr id='product-{$product_id}'>";
                        echo "<td>{$product_id}</td>";
                        echo "<td>{$product_name}</td>";
                        echo "<td>\${$product_price}</td>";
                        echo "<td>
                                <button onclick='changeQuantity({$product_id}, -1)' class='btn btn-sm btn-secondary'>-</button>
                                <span id='quantity-{$product_id}'>{$product_quantity}</span>
                                <button onclick='changeQuantity({$product_id}, 1)' class='btn btn-sm btn-secondary'>+</button>
                            </td>";
                        echo "<td id='total-{$product_id}'>\${$total_price}</td>";
                        echo "<td><button class='btn btn-danger' onclick='removeFromCart({$product_id})'>Remove</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<script>alert('No items in the cart');</script>";
                }
                ?>
                </tbody>

            </table>
            <div class="total-price">
                <!-- Display the calculated grand total -->
                <span id="total-price">Total Price: $<?php echo number_format($grandTotal, 2); ?></span>
            </div>
            <div class="table-footer">
                <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
                <a href="checkout.php?total=<?php echo $grandTotal; ?>" class="btn btn-primary">Checkout</a>
                <button class="btn btn-danger" onclick="clearCart()">Clear Cart</button>
            </div>
        </section>
    </div>

    <script>
        function removeFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from the cart?')) {
                window.location.href = `remove-from-cart.php?id=${productId}`;
            }
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear the cart?')) {
                window.location.href = 'clear-cart.php';
            }
        }

        function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const totalCell = row.querySelector('td:nth-child(5)');
            if (totalCell) {
                grandTotal += parseFloat(totalCell.textContent.replace('$', ''));
            }
        });
            document.getElementById('total-price').textContent = `Total Price: $${grandTotal.toFixed(2)}`;
        }


        function changeQuantity(productId, change) {
        const quantityElement = document.getElementById(`quantity-${productId}`);
        let currentQuantity = parseInt(quantityElement.textContent);

        // Prevent quantity from dropping below 1
        if (currentQuantity + change < 1) {
            alert('Quantity cannot be less than 1.');
            return;
        }

        // Update the quantity in the cart
        currentQuantity += change;

        // Send an AJAX request to update the server-side quantity
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update-cart.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (this.status === 200) {
                // Update the UI
                quantityElement.textContent = currentQuantity;
                document.getElementById(`total-${productId}`).textContent = `$${parseFloat(this.responseText).toFixed(2)}`;

                // Optionally, update the grand total here
                updateGrandTotal();
            }
        };
        xhr.send(`id=${productId}&quantity=${currentQuantity}`);
    }

    </script>
</body>
</html>
