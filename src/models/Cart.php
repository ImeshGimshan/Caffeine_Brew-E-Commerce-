<?php
/**
 * Cart Model
 * Handles all cart-related database operations
 */

require_once dirname(__DIR__, 2) . '/config/config.php';

class Cart {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Get all cart items
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM cart ORDER BY cid DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get cart items by user (if user system is implemented)
     */
    public function getByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get cart item by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM cart WHERE cid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Check if product exists in cart
     */
    public function productExists($productId, $userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT * FROM cart WHERE pid = ? AND user_id = ?");
            $stmt->bind_param("ii", $productId, $userId);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM cart WHERE pid = ?");
            $stmt->bind_param("i", $productId);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    
    /**
     * Add item to cart
     */
    public function add($productId, $productName, $price, $quantity = 1, $userId = null) {
        // Check if product already exists
        if ($this->productExists($productId, $userId)) {
            return $this->updateQuantity($productId, $quantity, $userId, true);
        }
        
        $stmt = $this->db->prepare(
            "INSERT INTO cart (pid, name, price, quantity, user_id) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isdii", $productId, $productName, $price, $quantity, $userId);
        
        return $stmt->execute();
    }
    
    /**
     * Update cart item quantity
     */
    public function updateQuantity($productId, $quantity, $userId = null, $increment = false) {
        if ($increment) {
            $sql = "UPDATE cart SET quantity = quantity + ? WHERE pid = ?";
        } else {
            $sql = "UPDATE cart SET quantity = ? WHERE pid = ?";
        }
        
        if ($userId) {
            $sql .= " AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iii", $quantity, $productId, $userId);
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $quantity, $productId);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Remove item from cart
     */
    public function remove($cartId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE cid = ?");
        $stmt->bind_param("i", $cartId);
        return $stmt->execute();
    }
    
    /**
     * Clear entire cart
     */
    public function clear($userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            return $stmt->execute();
        } else {
            return $this->db->query("DELETE FROM cart");
        }
    }
    
    /**
     * Get cart total
     */
    public function getTotal($userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT SUM(price * quantity) as total FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query("SELECT SUM(price * quantity) as total FROM cart");
        }
        
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    /**
     * Get cart item count
     */
    public function getCount($userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->db->query("SELECT COUNT(*) as count FROM cart");
        }
        
        $row = $result->fetch_assoc();
        return $row['count'] ?? 0;
    }
}
