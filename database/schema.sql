-- Lion Equipment Company Database Schema
-- MySQL Database Setup

-- Create database
CREATE DATABASE lion_equipment_db;

-- Use the database
USE lion_equipment_db;

-- Users table for login system
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'manager') DEFAULT 'user',
    phone VARCHAR(20),
    department VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(255) NULL,
    INDEX (email),
    INDEX (remember_token)
);

-- Projects table for managing projects
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    client_name VARCHAR(100),
    location VARCHAR(200),
    start_date DATE,
    end_date DATE,
    status ENUM('planning', 'active', 'completed', 'on_hold') DEFAULT 'planning',
    project_type VARCHAR(50),
    budget DECIMAL(12,2),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX (status),
    INDEX (project_type)
);

-- Equipment table for managing crane fleet
CREATE TABLE equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name VARCHAR(100) NOT NULL,
    equipment_type VARCHAR(50) NOT NULL,
    capacity_tons DECIMAL(8,2),
    model VARCHAR(100),
    serial_number VARCHAR(100),
    purchase_date DATE,
    last_maintenance DATE,
    status ENUM('available', 'rented', 'maintenance', 'retired') DEFAULT 'available',
    hourly_rate DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (status),
    INDEX (equipment_type)
);

-- Login sessions table for tracking user sessions
CREATE TABLE login_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (session_token),
    INDEX (expires_at)
);

-- Activity log for tracking admin actions
CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id),
    INDEX (created_at)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (full_name, email, password, role, phone, department) VALUES 
('Administrator', 'admin@lionequipment.com', '$2y$10$abcdefghijklmnopqrstuvwx', 'admin', '09182563327', 'Management');

-- Insert default regular user (password: user123)
INSERT INTO users (full_name, email, password, role, phone, department) VALUES 
('Regular User', 'user@lionequipment.com', '$2y$10$abcdefghijklmnopqrstuvwx', 'user', '09189103808', 'Operations');

-- Insert default personal user (password: password123)
INSERT INTO users (full_name, email, password, role, phone, department) VALUES 
('Ronald Roldan', 'ronaldroldan101@gmail.com', '$2y$10$abcdefghijklmnopqrstuvwx', 'user', '09182563327', 'Management');
