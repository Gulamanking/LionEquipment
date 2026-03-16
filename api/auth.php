<?php
/**
 * Lion Equipment Company - Login Authentication System
 * Secure login with database validation and session management
 */

require_once 'config.php';

// Start session
session_start();

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

class Auth {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Secure password hashing
     */
    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password
     */
    private function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Generate secure session token
     */
    private function generateSessionToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Validate email format
     */
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Sanitize input data
     */
    private function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    /**
     * Log user activity
     */
    private function logActivity($userId, $action, $description = '') {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $sql = "INSERT INTO activity_log (user_id, action, description, ip_address) VALUES (?, ?, ?)";
        $this->db->prepare($sql, [$userId, $action, $description]);
    }
    
    /**
     * Handle login request
     */
    public function login($email, $password, $remember = false) {
        try {
            // Validate input
            $email = $this->sanitize($email);
            $password = $this->sanitize($password);
            
            if (!$this->validateEmail($email)) {
                return [
                    'success' => false,
                    'message' => 'Invalid email format'
                ];
            }
            
            if (empty($password)) {
                return [
                    'success' => false,
                    'message' => 'Password is required'
                ];
            }
            
            // Query user from database
            $sql = "SELECT id, full_name, email, password, role, phone, department, is_active 
                     FROM users WHERE email = ? AND is_active = TRUE";
            $user = $this->db->fetch($sql, [$email]);
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password'
                ];
            }
            
            // Verify password
            if (!$this->verifyPassword($password, $user['password'])) {
                return [
                    'success' => false,
                    'message' => 'Invalid email or password'
                ];
            }
            
            // Generate session token
            $sessionToken = $this->generateSessionToken();
            $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Store session
            $this->db->beginTransaction();
            
            try {
                // Insert new session
                $sessionSql = "INSERT INTO login_sessions (user_id, session_token, ip_address, user_agent, expires_at) 
                              VALUES (?, ?, ?, ?, ?)";
                $this->db->prepare($sessionSql, [
                    $user['id'],
                    $sessionToken,
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT'],
                    $expiresAt
                ]);
                
                // Update last login
                $updateSql = "UPDATE users SET last_login = NOW() WHERE id = ?";
                $this->db->prepare($updateSql, [$user['id']]);
                
                // Handle remember me
                if ($remember) {
                    $rememberToken = $this->generateSessionToken();
                    $rememberExpires = date('Y-m-d H:i:s', strtotime('+30 days'));
                    
                    $rememberSql = "UPDATE users SET remember_token = ? WHERE id = ?";
                    $this->db->prepare($rememberSql, [$rememberToken, $user['id']]);
                    
                    setcookie('remember_token', $rememberToken, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                }
                
                $this->db->commit();
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['session_token'] = $sessionToken;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                
                // Log activity
                $this->logActivity($user['id'], 'LOGIN', 'User logged in successfully');
                
                return [
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['full_name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'phone' => $user['phone'],
                        'department' => $user['department']
                    ]
                ];
                
            } catch (Exception $e) {
                $this->db->rollback();
                error_log("Login Error: " . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Login failed. Please try again.'
                ];
            }
            
        } catch (Exception $e) {
            error_log("Auth Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'System error. Please try again later.'
            ];
        }
    }
    
    /**
     * Handle logout
     */
    public function logout() {
        // Log activity if user is logged in
        if (isset($_SESSION['user_id'])) {
            $this->logActivity($_SESSION['user_id'], 'LOGOUT', 'User logged out');
        }
        
        // Destroy session
        session_destroy();
        
        // Clear remember cookie
        setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        
        return [
            'success' => true,
            'message' => 'Logged out successfully'
        ];
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['session_token']);
    }
    
    /**
     * Get current user info
     */
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'],
                'email' => $_SESSION['user_email'],
                'role' => $_SESSION['user_role'],
                'login_time' => $_SESSION['login_time']
            ];
        }
        return null;
    }
    
    /**
     * Check user role
     */
    public function hasRole($role) {
        return $this->isLoggedIn() && $_SESSION['user_role'] === $role;
    }
    
    /**
     * Auto-login from remember token
     */
    public function autoLogin() {
        if (isset($_COOKIE['remember_token']) && !$this->isLoggedIn()) {
            $token = $_COOKIE['remember_token'];
            
            $sql = "SELECT id, full_name, email, role, phone, department 
                     FROM users WHERE remember_token = ? AND is_active = TRUE";
            $user = $this->db->fetch($sql, [$token]);
            
            if ($user) {
                $sessionToken = $this->generateSessionToken();
                $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
                
                // Create new session
                $sessionSql = "INSERT INTO login_sessions (user_id, session_token, ip_address, user_agent, expires_at) 
                              VALUES (?, ?, ?, ?, ?)";
                $this->db->prepare($sessionSql, [
                    $user['id'],
                    $sessionToken,
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT'],
                    $expiresAt
                ]);
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['session_token'] = $sessionToken;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                
                $this->logActivity($user['id'], 'AUTO_LOGIN', 'Auto-login from remember token');
                
                return true;
            }
        }
        return false;
    }
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth($db);
    
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'login':
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);
            
            $result = $auth->login($email, $password, $remember);
            echo json_encode($result);
            break;
            
        case 'logout':
            $result = $auth->logout();
            echo json_encode($result);
            break;
            
        case 'check':
            $result = [
                'loggedIn' => $auth->isLoggedIn(),
                'user' => $auth->getCurrentUser()
            ];
            echo json_encode($result);
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST requests allowed'
    ]);
}
?>
