<?php
/**
 * Product Model
 * Handles all product-related database operations
 */

require_once dirname(__DIR__, 2) . '/config/config.php';

class Product {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Get all products
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get products by category
     */
    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category = ? ORDER BY id DESC");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get product by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Create new product
     */
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssdss",
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category'],
            $data['image']
        );
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }
    
    /**
     * Update product
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];
        $types = '';
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
            
            if ($key === 'price') {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        
        $values[] = $id;
        $types .= 'i';
        
        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }
    
    /**
     * Delete product
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Search products
     */
    public function search($keyword) {
        $searchTerm = "%$keyword%";
        $stmt = $this->db->prepare(
            "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR category LIKE ?"
        );
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get all categories
     */
    public function getCategories() {
        $result = $this->db->query("SELECT DISTINCT category FROM products ORDER BY category");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Check if product exists
     */
    public function exists($id) {
        return $this->getById($id) !== null;
    }
}
