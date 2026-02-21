<?php
/**
 * Security Helper
 * Provides security functions for the application
 */

class SecurityHelper {
    
    /**
     * Hash password using bcrypt
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Sanitize input data
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
        } else {
            $data = htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }
    
    /**
     * Validate email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!SessionHelper::has('csrf_token')) {
            SessionHelper::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return SessionHelper::get('csrf_token');
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token) {
        return SessionHelper::has('csrf_token') && 
               hash_equals(SessionHelper::get('csrf_token'), $token);
    }
    
    /**
     * Prevent XSS attacks
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Redirect safely
     */
    public static function redirect($url) {
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Generate random string
     */
    public static function generateRandomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
}
