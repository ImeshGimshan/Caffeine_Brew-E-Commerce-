<?php
/**
 * Reservation Model
 * Handles all reservation-related database operations
 */

require_once dirname(__DIR__, 2) . '/config/config.php';

class Reservation {
    private $db;
    
    public function __construct() {
        $this->db = getDB();
    }
    
    /**
     * Get all reservations
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM reservation ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get reservation by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM reservation WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
    
    /**
     * Create new reservation
     */
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO reservation (name, email, phone, date, time, guests, message, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param(
            "sssssss",
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['date'],
            $data['time'],
            $data['guests'],
            $data['message']
        );
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }
    
    /**
     * Update reservation status
     */
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE reservation SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
    
    /**
     * Delete reservation
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM reservation WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    /**
     * Get reservations by date
     */
    public function getByDate($date) {
        $stmt = $this->db->prepare("SELECT * FROM reservation WHERE date = ? ORDER BY time");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
