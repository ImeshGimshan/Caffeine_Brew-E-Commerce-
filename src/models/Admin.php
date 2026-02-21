<?php
/**
 * Admin Model
 * Handles all admin-related database operations
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

class Admin {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Find admin by username
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Authenticate admin
     */
    public function authenticate($username, $password) {
        $admin = $this->findByUsername($username);
        
        if ($admin) {
            // Check for plain text or hashed passwords
            if (strlen($admin['password']) === 32) {
                // Old MD5 hash
                if (md5($password) === $admin['password']) {
                    // Update to bcrypt
                    $this->updatePassword($admin['id'], $password);
                    return $admin;
                }
            } elseif (password_verify($password, $admin['password'])) {
                // Bcrypt hash
                return $admin;
            } elseif ($password === $admin['password']) {
                // Plain text (for backward compatibility)
                $this->updatePassword($admin['id'], $password);
                return $admin;
            }
        }
        return false;
    }
    
    /**
     * Update admin password
     */
    public function updatePassword($adminId, $newPassword) {
        $hashedPassword = SecurityHelper::hashPassword($newPassword);
        $stmt = $this->db->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $adminId);
        return $stmt->execute();
    }
    
    /**
     * Find admin by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
}
