-- Add company column if it doesn't exist
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `company` varchar(255) DEFAULT NULL AFTER `phone`;
