<?php
/**
 * User Model
 * Handles all user-related database operations
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Create new user
     */
    public function create($username, $password, $email = null) {
        $hashedPassword = SecurityHelper::hashPassword($password);
        
        $stmt = $this->db->prepare("INSERT INTO users (name, password, email, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $hashedPassword, $email);
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }
    
    /**
     * Find user by username
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Find user by ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Authenticate user
     */
    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);
        
        if ($user) {
            // Check for old MD5 passwords (for backward compatibility)
            if (strlen($user['password']) === 32) {
                // Old MD5 hash
                if (md5($password) === $user['password']) {
                    // Update to bcrypt
                    $this->updatePassword($user['id'], $password);
                    return $user;
                }
            } else {
                // New bcrypt hash
                if (SecurityHelper::verifyPassword($password, $user['password'])) {
                    return $user;
                }
            }
        }
        return false;
    }
    
    /**
     * Update user password
     */
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = SecurityHelper::hashPassword($newPassword);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        return $stmt->execute();
    }
    
    /**
     * Check if username exists
     */
    public function usernameExists($username) {
        return $this->findByUsername($username) !== null;
    }
    
    /**
     * Update user profile
     */
    public function update($userId, $data) {
        $fields = [];
        $values = [];
        $types = '';
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
            $types .= 's';
        }
        
        $values[] = $userId;
        $types .= 'i';
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }
    
    /**
     * Delete user
     */
    public function delete($userId) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
}
