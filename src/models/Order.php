<?php
/**
 * Order Model
 * Handles order creation and retrieval
 */

require_once dirname(__DIR__, 2) . '/config/config.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /**
     * Create a new order with its items
     */
    public function create($userId, $totalAmount, $paymentMethod, $shippingAddress, $cartItems) {
        // Insert into orders table
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, status)
             VALUES (?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param("idss", $userId, $totalAmount, $paymentMethod, $shippingAddress);

        if (!$stmt->execute()) {
            return false;
        }

        $orderId = $this->db->insert_id;

        // Insert order items
        $itemStmt = $this->db->prepare(
            "INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
             VALUES (?, ?, ?, ?, ?)"
        );

        foreach ($cartItems as $item) {
            $itemStmt->bind_param(
                "iisid",
                $orderId,
                $item['pid'],
                $item['name'],
                $item['quantity'],
                $item['price']
            );
            $itemStmt->execute();
        }

        return $orderId;
    }

    /**
     * Get all orders for a user
     */
    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get a single order with its items
     */
    public function getById($orderId, $userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $orderId, $userId);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->bind_param("i", $orderId);
        }
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();

        if (!$order) return null;

        // Fetch items
        $iStmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $iStmt->bind_param("i", $orderId);
        $iStmt->execute();
        $order['items'] = $iStmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $order;
    }

    /**
     * Get all orders (admin) - joined with user info
     */
    public function getAll() {
        $result = $this->db->query(
            "SELECT o.*, u.name AS customer_name
             FROM orders o
             LEFT JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update order status (admin)
     */
    public function updateStatus($orderId, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        return $stmt->execute();
    }
}
