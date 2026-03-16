<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Include database configuration
require_once 'database/config.php';
$database = new Database();
$pdo = $database->pdo;

// Get user information
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Lion Equipment Company</title>
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@700;900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { 
            font-family: 'Prompt', 'Inter', sans-serif; 
            font-weight: 700;
            background-color: #000000;
            color: #ffffff;
        }
        
        .bg-white {
            background-color: #000000 !important;
        }
        
        .text-gray-800 {
            color: #ffffff !important;
        }
        
        .text-gray-700 {
            color: #ffffff !important;
        }
        
        .text-gray-600 {
            color: #ffffff !important;
        }
        
        .border-gray-200 {
            border-color: #ff0000 !important;
        }
        
        .bg-red-600 {
            background-color: #ff0000 !important;
        }
        
        .hover\:bg-red-700:hover {
            background-color: #cc0000 !important;
        }
        
        .text-red-600 {
            color: #ff0000 !important;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <span class="text-2xl font-bold text-gray-800">Lion Equipment Company</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</span>
                    <a href="logout.php" class="text-red-600 hover:text-red-700 font-semibold transition">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
            
            <!-- User Information -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Information</h2>
                    <div class="space-y-3">
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Name:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($user['name']); ?></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Email:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Phone:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($user['phone']); ?></span>
                        </div>
                        <?php if (!empty($user['company'])): ?>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Company:</span>
                            <span class="text-gray-800"><?php echo htmlspecialchars($user['company']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Status:</span>
                            <span class="text-gray-800">
                                <span class="px-2 py-1 rounded text-xs font-semibold 
                                    <?php echo $user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo ucfirst($user['status']); ?>
                                </span>
                            </span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Role:</span>
                            <span class="text-gray-800"><?php echo ucfirst($user['role']); ?></span>
                        </div>
                        <?php if ($user['last_login']): ?>
                        <div class="flex">
                            <span class="font-semibold text-gray-600 w-32">Last Login:</span>
                            <span class="text-gray-800"><?php echo date('M j, Y H:i', strtotime($user['last_login'])); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="#" class="block bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition text-center">
                            <i class="fas fa-crane mr-2"></i>View Services
                        </a>
                        <a href="#" class="block bg-gray-700 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition text-center">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                        <a href="#" class="block bg-gray-700 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition text-center">
                            <i class="fas fa-history mr-2"></i>Order History
                        </a>
                        <a href="#" class="block bg-gray-700 text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition text-center">
                            <i class="fas fa-envelope mr-2"></i>Messages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <?php if ($user['status'] === 'pending'): ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                    <div>
                        <h3 class="text-yellow-800 font-semibold">Account Pending Approval</h3>
                        <p class="text-yellow-700 text-sm">Your account is currently pending approval by an administrator. You'll be notified once it's approved.</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Welcome Message -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Welcome to Lion Equipment Company!</h2>
                <p class="text-gray-700">
                    Thank you for creating an account with us. As a registered user, you can access our premium services, 
                    request quotes, track your orders, and manage your equipment rental needs efficiently.
                </p>
                <div class="mt-4">
                    <a href="index.php" class="text-red-600 hover:text-red-700 font-semibold transition">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
