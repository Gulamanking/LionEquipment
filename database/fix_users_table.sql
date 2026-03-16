-- Fix users table - add missing columns if they don't exist
-- Run this script to fix the database structure

-- First, check if old 'name' column exists and rename it to 'full_name'
SET @rename_name = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                   WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = 'users' 
                   AND COLUMN_NAME = 'name');

SET @rename_full_name = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = 'users' 
                        AND COLUMN_NAME = 'full_name');

-- Rename old 'name' column to 'full_name' if it exists but 'full_name' doesn't
SET @sql = IF(@rename_name > 0 AND @rename_full_name = 0, 
               'ALTER TABLE `users` CHANGE COLUMN `name` `full_name` varchar(255) NOT NULL',
               'SELECT 1');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check if table exists and add missing columns
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `full_name` varchar(255) NOT NULL AFTER `id`,
ADD COLUMN IF NOT EXISTS `email` varchar(255) NOT NULL AFTER `full_name`,
ADD COLUMN IF NOT EXISTS `phone` varchar(20) NOT NULL AFTER `email`,
ADD COLUMN IF NOT EXISTS `company` varchar(255) DEFAULT NULL AFTER `phone`,
ADD COLUMN IF NOT EXISTS `password` varchar(255) NOT NULL AFTER `company`,
ADD COLUMN IF NOT EXISTS `status` enum('pending','active','suspended') NOT NULL DEFAULT 'pending' AFTER `password`,
ADD COLUMN IF NOT EXISTS `role` enum('user','admin') NOT NULL DEFAULT 'user' AFTER `status`,
ADD COLUMN IF NOT EXISTS `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `role`,
ADD COLUMN IF NOT EXISTS `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`,
ADD COLUMN IF NOT EXISTS `last_login` datetime DEFAULT NULL AFTER `updated_at`;

-- If table doesn't exist at all, create it
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user if not exists
INSERT IGNORE INTO `users` (`full_name`, `email`, `phone`, `company`, `password`, `status`, `role`) 
VALUES ('Administrator', 'admin@lionequipment.com', '+639123456789', 'Lion Equipment Company', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'active', 'admin');
