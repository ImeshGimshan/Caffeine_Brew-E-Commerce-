<?php
/**
 * Session Helper
 * Manages user sessions and authentication
 */

class SessionHelper {
    
    /**
     * Initialize session
     */
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Set session variable
     */
    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session variable
     */
    public static function get($key, $default = null) {
        self::init();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Check if session variable exists
     */
    public static function has($key) {
        self::init();
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session variable
     */
    public static function remove($key) {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Destroy session
     */
    public static function destroy() {
        self::init();
        session_destroy();
        $_SESSION = [];
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return self::has('user_id') && self::has('user_type');
    }
    
    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return self::get('user_type') === 'admin';
    }
    
    /**
     * Get logged in user ID
     */
    public static function getUserId() {
        return self::get('user_id');
    }
    
    /**
     * Login user
     */
    public static function login($userId, $userType = 'user', $userData = []) {
        self::set('user_id', $userId);
        self::set('user_type', $userType);
        self::set('user_data', $userData);
        self::set('login_time', time());
    }
    
    /**
     * Logout user
     */
    public static function logout() {
        self::destroy();
    }
    
    /**
     * Require login (redirect if not logged in)
     */
    public static function requireLogin($redirectUrl = '/user/auth/login.php') {
        if (!self::isLoggedIn()) {
            header("Location: " . BASE_URL . $redirectUrl);
            exit();
        }
    }
    
    /**
     * Require admin (redirect if not admin)
     */
    public static function requireAdmin($redirectUrl = '/admin/auth/login.php') {
        if (!self::isAdmin()) {
            header("Location: " . BASE_URL . $redirectUrl);
            exit();
        }
    }
}
