<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once 'database/config.php';

// Initialize database connection
$database = new Database();
$pdo = $database->pdo;

// Initialize variables
$errors = [];
$email = '';
$success = '';

/**
 * Handle user login process
 * @param PDO $pdo Database connection
 * @param string $email User email
 * @param string $password User password
 * @param bool $remember Remember me option
 * @return array Result with success status and message
 */
function handleLogin($pdo, $email, $password, $remember) {
    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();
            
            // Update last login
            updateLastLogin($pdo, $user['id']);
            
            // Set remember me cookie if checked
            if ($remember) {
                setRememberMeCookie($email);
            }
            
            return ['success' => true, 'user' => $user];
            
        } else {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * Update user's last login timestamp
 * @param PDO $pdo Database connection
 * @param int $userId User ID
 */
function updateLastLogin($pdo, $userId) {
    $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
    $updateStmt->execute([$userId]);
}

/**
 * Set remember me cookie
 * @param string $email User email
 */
function setRememberMeCookie($email) {
    $token = bin2hex(random_bytes(32));
    setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
}

/**
 * Redirect user based on role
 * @param array $user User data
 */
function redirectByRole($user) {
    if ($user['role'] === 'admin') {
        // Open admin panel in popup window
        echo "<script>
            window.open('admin.php', 'adminPanel', 'width=1200,height=800,scrollbars=yes,resizable=yes,toolbar=no,menubar=no,location=no,status=no');
            window.location.href = 'index.php';
        </script>";
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

/**
 * Validate login form input
 * @param string $email User email
 * @param string $password User password
 * @return array Validation errors
 */
function validateLoginForm($email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "Email address is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    return $errors;
}

/**
 * Handle registration success message
 * @return string Success message or empty string
 */
function handleRegistrationSuccess() {
    $message = $_SESSION['register_success'] ?? '';
    unset($_SESSION['register_success']);
    return $message;
}

/**
 * Redirect with errors
 * @param array $errors Error messages
 * @param string $email User email
 */
function redirectWithErrors($errors, $email) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['login_email'] = $email;
    header("Location: index.php");
    exit();
}

/**
 * Redirect with success message
 * @param string $message Success message
 */
function redirectWithSuccess($message) {
    $_SESSION['login_success'] = $message;
    header("Location: index.php");
    exit();
}

// Main execution
$registration_success = handleRegistrationSuccess();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate input
    $errors = validateLoginForm($email, $password);
    
    // Show registration success message if coming from registration
    if (!empty($registration_success)) {
        $success = $registration_success;
    }
    
    // Attempt login if no validation errors
    if (empty($errors)) {
        $result = handleLogin($pdo, $email, $password, $remember);
        
        if ($result['success']) {
            redirectByRole($result['user']);
        } else {
            $errors[] = $result['message'];
        }
    }
    
    // If there's an error, redirect back to index.php with error message
    if (!empty($errors)) {
        redirectWithErrors($errors, $email);
    }
}

// If there's a success message from registration, show it
if (!empty($success)) {
    redirectWithSuccess($success);
}
?>
