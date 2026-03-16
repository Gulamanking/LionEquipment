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
$success = '';
$full_name = $email = '';
$phone = '';
$company = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($full_name)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email address is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $errors[] = "Email address already registered";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    // If no errors, create account
    if (empty($errors)) {
        try {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $pdo->prepare("
                INSERT INTO users (full_name, email, phone, company, password, created_at, status) 
                VALUES (?, ?, ?, ?, ?, NOW(), 'active')
            ");
            
            $result = $stmt->execute([$full_name, $email, $phone, $company, $hashed_password]);
            
            if ($result) {
                $_SESSION['register_success'] = "Account created successfully! Welcome to Lion Equipment Company. You can now log in.";
                
                // Redirect to index page to show success in modal
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Failed to create account. Please try again.";
            }
            
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// If there are errors or it's not a POST request, redirect back to index.php
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_form_data'] = [
        'full_name' => $full_name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company
    ];
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Lion Equipment Company</title>
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
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            color: #333333;
        }
        
        .bg-white {
            background-color: #ffffff !important;
        }
        
        .text-gray-800 {
            color: #333333 !important;
        }
        
        .text-gray-700 {
            color: #555555 !important;
        }
        
        .text-gray-600 {
            color: #666666 !important;
        }
        
        .text-gray-500 {
            color: #777777 !important;
        }
        
        .border-gray-200 {
            border-color: #e5e5e5 !important;
        }
        
        .border-gray-300 {
            border-color: #d1d5db !important;
        }
        
        input, select, textarea {
            background-color: #ffffff !important;
            color: #333333 !important;
            border-color: #d1d5db !important;
        }
        
        .bg-red-600 {
            background-color: #dc2626 !important;
        }
        
        .hover\:bg-red-700:hover {
            background-color: #b91c1c !important;
        }
        
        .text-red-600 {
            color: #dc2626 !important;
        }
        
        .hover\:text-red-600:hover {
            color: #dc2626 !important;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }
        
        .modal-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease-out;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .input-focus:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Modal Overlay -->
    <div class="modal-overlay">
        <div class="modal-container">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 p-6 flex justify-between items-center">
                <div class="flex items-center">
                    <img src="img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                </div>
                <a href="index.php" class="text-gray-500 hover:text-gray-700 text-2xl font-bold transition">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
            <?php if (!empty($errors)): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                        <h3 class="text-red-800 font-semibold">Please fix the following errors:</h3>
                    </div>
                    <ul class="text-red-700 text-sm space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li>• <?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <p class="text-green-800"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-red-600"></i>Full Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required
                        value="<?php echo htmlspecialchars($full_name); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                        placeholder="John Doe"
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-red-600"></i>Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        value="<?php echo htmlspecialchars($email); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                        placeholder="john@example.com"
                    >
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-red-600"></i>Phone Number
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        required
                        value="<?php echo htmlspecialchars($phone); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                        placeholder="+63 912 345 6789"
                    >
                </div>

                <!-- Company (Optional) -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building mr-2 text-red-600"></i>Company (Optional)
                    </label>
                    <input 
                        type="text" 
                        id="company" 
                        name="company"
                        value="<?php echo htmlspecialchars($company); ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                        placeholder="Your company name"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-red-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                            placeholder="Min. 8 characters"
                        >
                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-600 transition"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-red-600"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus transition duration-200"
                            placeholder="Confirm your password"
                        >
                        <button 
                            type="button" 
                            id="toggleConfirmPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-red-600 transition"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        required
                        class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-red-600 hover:text-red-700">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full btn-primary text-white py-3 px-4 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2"
                >
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="index.php" class="text-red-600 hover:text-red-700 font-semibold transition">Sign In</a>
                </p>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('confirm_password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Password strength validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;
            
            // You can add visual feedback here if needed
        });
    </script>
</body>
</html>
