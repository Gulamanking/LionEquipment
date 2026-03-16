<?php
/**
 * Database Setup Script
 * This script will create/fix users table structure and handle column renaming
 */

require_once 'config.php';

try {
    $database = new Database();
    $pdo = $database->pdo;
    
    echo "<h2>Database Setup</h2>";
    
    // Read and execute the SQL fix file
    $sqlFile = __DIR__ . '/fix_users_table.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        
        // Handle multi-statement SQL with conditional logic
        $pdo->exec("SET @rename_name = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                       WHERE TABLE_SCHEMA = DATABASE() 
                       AND TABLE_NAME = 'users' 
                       AND COLUMN_NAME = 'name')");
        
        $pdo->exec("SET @rename_full_name = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                            WHERE TABLE_SCHEMA = DATABASE() 
                            AND TABLE_NAME = 'users' 
                            AND COLUMN_NAME = 'full_name')");
        
        // Execute the conditional rename
        $pdo->exec("SET @sql = IF(@rename_name > 0 AND @rename_full_name = 0, 
                       'ALTER TABLE `users` CHANGE COLUMN `name` `full_name` varchar(255) NOT NULL',
                       'SELECT 1')");
        $pdo->exec("PREPARE stmt FROM @sql");
        $pdo->exec("EXECUTE stmt");
        $pdo->exec("DEALLOCATE PREPARE stmt");
        
        // Now execute the ALTER TABLE statements
        $alterStatements = [
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `full_name` varchar(255) NOT NULL AFTER `id`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `email` varchar(255) NOT NULL AFTER `full_name`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `phone` varchar(20) NOT NULL AFTER `email`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `company` varchar(255) DEFAULT NULL AFTER `phone`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `password` varchar(255) NOT NULL AFTER `company`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `status` enum('pending','active','suspended') NOT NULL DEFAULT 'pending' AFTER `password`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `role` enum('user','admin') NOT NULL DEFAULT 'user' AFTER `status`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `role`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`",
            "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `last_login` datetime DEFAULT NULL AFTER `updated_at`"
        ];
        
        foreach ($alterStatements as $statement) {
            try {
                $pdo->exec($statement);
                echo "<p style='color: green;'>✓ Executed: " . htmlspecialchars(substr($statement, 0, 50)) . "...</p>";
            } catch (PDOException $e) {
                // Some statements might fail if columns already exist, that's okay
                echo "<p style='color: orange;'>⚠ " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        
        // Create table if it doesn't exist
        $createTable = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `full_name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `phone` varchar(20) NOT NULL,
            `company` varchar(255) DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `status` enum('pending','active','suspended') NOT NULL DEFAULT 'pending',
            `role` enum('user','admin') NOT NULL DEFAULT 'user',
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `last_login` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($createTable);
        echo "<p style='color: green;'>✓ Table structure verified/created</p>";
        
        // Insert admin user
        $insertAdmin = "INSERT IGNORE INTO `users` (`full_name`, `email`, `phone`, `company`, `password`, `status`, `role`) 
                        VALUES ('Administrator', 'admin@lionequipment.com', '+639123456789', 'Lion Equipment Company', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active', 'admin')";
        
        $pdo->exec($insertAdmin);
        echo "<p style='color: green;'>✓ Admin user verified/created</p>";
        
        echo "<h3 style='color: green;'>Database setup completed!</h3>";
        
        // Verify table structure
        $stmt = $pdo->prepare("DESCRIBE users");
        $stmt->execute();
        $columns = $stmt->fetchAll();
        
        echo "<h3>Current users table structure:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = 'admin@lionequipment.com'");
        $stmt->execute();
        $admin = $stmt->fetch();
        
        if ($admin) {
            echo "<p style='color: green;'>✓ Admin user exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Admin user not found</p>";
        }
        
    } else {
        echo "<p style='color: red;'>SQL file not found: $sqlFile</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><a href='../index.php'>← Back to website</a>";
?>
