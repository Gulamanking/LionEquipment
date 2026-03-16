<?php
/**
 * Lion Equipment Company - Logout Handler
 * Secure logout with session destruction
 */

require_once '../api/auth.php';

// Initialize auth system
$auth = new Auth($db);

// Handle logout
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['logout'])) {
    $result = $auth->logout();
    
    // Redirect to home page
    header('Location: ../index.html');
    exit();
} else {
    // If not POST, show logout page
    header('Location: dashboard.php');
    exit();
}
?>
