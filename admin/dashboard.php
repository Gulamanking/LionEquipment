<?php
/**
 * Lion Equipment Company - Admin Dashboard
 * Secure admin panel with authentication check
 */

require_once '../database/config.php';

// Start session
session_start();

// Check authentication
class Dashboard {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Check if user is authenticated
     */
    public function requireAuth() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
            header('Location: ../index.html');
            exit();
        }
    }
    
    /**
     * Check if user has admin role
     */
    public function requireAdmin() {
        $this->requireAuth();
        
        if ($_SESSION['user_role'] !== 'admin') {
            echo "<div class='alert alert-danger'>
                    <h3>Access Denied</h3>
                    <p>You don't have permission to access this page.</p>
                    <a href='../index.html'>Go Home</a>
                  </div>";
            exit();
        }
    }
    
    /**
     * Get dashboard statistics
     */
    public function getStats() {
        $stats = [];
        
        // Total users
        $sql = "SELECT COUNT(*) as total FROM users WHERE is_active = TRUE";
        $result = $this->db->fetch($sql);
        $stats['total_users'] = $result['total'];
        
        // Total projects
        $sql = "SELECT COUNT(*) as total FROM projects";
        $result = $this->db->fetch($sql);
        $stats['total_projects'] = $result['total'];
        
        // Active projects
        $sql = "SELECT COUNT(*) as total FROM projects WHERE status = 'active'";
        $result = $this->db->fetch($sql);
        $stats['active_projects'] = $result['total'];
        
        // Total equipment
        $sql = "SELECT COUNT(*) as total FROM equipment";
        $result = $this->db->fetch($sql);
        $stats['total_equipment'] = $result['total'];
        
        // Available equipment
        $sql = "SELECT COUNT(*) as total FROM equipment WHERE status = 'available'";
        $result = $this->db->fetch($sql);
        $stats['available_equipment'] = $result['total'];
        
        // Recent logins
        $sql = "SELECT COUNT(*) as total FROM login_sessions 
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $result = $this->db->fetch($sql);
        $stats['recent_logins'] = $result['total'];
        
        return $stats;
    }
    
    /**
     * Get recent users
     */
    public function getRecentUsers() {
        $sql = "SELECT full_name, email, role, last_login 
                 FROM users 
                 WHERE is_active = TRUE 
                 ORDER BY last_login DESC 
                 LIMIT 10";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Get recent projects
     */
    public function getRecentProjects() {
        $sql = "SELECT p.*, u.full_name as created_by_name 
                 FROM projects p 
                 LEFT JOIN users u ON p.created_by = u.id 
                 ORDER BY p.created_at DESC 
                 LIMIT 10";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Get activity log
     */
    public function getActivityLog($limit = 20) {
        $sql = "SELECT al.*, u.full_name 
                 FROM activity_log al 
                 LEFT JOIN users u ON al.user_id = u.id 
                 ORDER BY al.created_at DESC 
                 LIMIT ?";
        return $this->db->fetchAll($sql, [$limit]);
    }
}

// Initialize dashboard
$dashboard = new Dashboard($db);

// Require admin access
$dashboard->requireAdmin();

// Get dashboard data
$stats = $dashboard->getStats();
$recentUsers = $dashboard->getRecentUsers();
$recentProjects = $dashboard->getRecentProjects();
$activityLog = $dashboard->getActivityLog();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lion Equipment Company</title>
    <link rel="icon" type="image/jpg" href="../img/logo.jpg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Prompt', 'Inter', sans-serif; 
            font-weight: 700;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="../img/logo.jpg" alt="Lion Equipment Company" class="h-10 w-10 mr-3 rounded-full border-2 border-red-600">
                    <span class="text-2xl font-bold text-gray-800">Lion Equipment Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-users text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo $stats['total_users']; ?></h3>
                        <p class="text-gray-600">Total Users</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-project-diagram text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo $stats['total_projects']; ?></h3>
                        <p class="text-gray-600">Total Projects</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-truck text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo $stats['total_equipment']; ?></h3>
                        <p class="text-gray-600">Total Equipment</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo $stats['recent_logins']; ?></h3>
                        <p class="text-gray-600">Recent Logins (7 days)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Users</h3>
                <div class="space-y-3">
                    <?php foreach ($recentUsers as $user): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></p>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">
                                <?php echo htmlspecialchars($user['role']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Projects</h3>
                <div class="space-y-3">
                    <?php foreach ($recentProjects as $project): ?>
                    <div class="p-3 bg-gray-50 rounded">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-800"><?php echo htmlspecialchars($project['title']); ?></h4>
                            <span class="px-2 py-1 bg-<?php echo $project['status'] === 'completed' ? 'green' : 'yellow'; ?>-100 text-<?php echo $project['status'] === 'completed' ? 'green' : 'yellow'; ?>-600 text-xs rounded-full">
                                <?php echo htmlspecialchars($project['status']); ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars(substr($project['description'], 0, 100)); ?>...</p>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>By: <?php echo htmlspecialchars($project['created_by_name']); ?></span>
                            <span><?php echo date('M j, Y', strtotime($project['created_at'])); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Activity Log</h3>
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    <?php foreach ($activityLog as $activity): ?>
                    <div class="flex items-start p-2 bg-gray-50 rounded">
                        <div class="flex-shrink-0 w-2 h-2 bg-red-600 rounded-full mt-1 mr-3"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">
                                <strong><?php echo htmlspecialchars($activity['full_name']); ?></strong> - 
                                <?php echo htmlspecialchars($activity['action']); ?>
                            </p>
                            <?php if (!empty($activity['description'])): ?>
                            <p class="text-xs text-gray-600"><?php echo htmlspecialchars($activity['description']); ?></p>
                            <?php endif; ?>
                            <p class="text-xs text-gray-500"><?php echo date('M j, Y H:i', strtotime($activity['created_at'])); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
