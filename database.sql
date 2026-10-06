-- ========================================================
-- Database Schema for Online Examination Cell & Student Portal
-- Database Name: `mid-marks`
-- Compatible with MySQL 5.7+ / MariaDB 10.2+ / phpMyAdmin
-- ========================================================

CREATE DATABASE IF NOT EXISTS `mid-marks` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mid-marks`;

-- --------------------------------------------------------
-- Table structure for table `users` (Admin Authentication)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed default user accounts (Passwords: admin123, bunny123)
INSERT INTO `users` (`username`, `email`, `password`, `full_name`) VALUES
('admin', 'admin@examinationcell.edu', 'admin123', 'System Administrator'),
('bunny', 'bunny@examinationcell.edu', 'bunny123', 'Staff Evaluator')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------
-- Table structure for table `student_data`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `student_data` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pin_number` VARCHAR(30) NOT NULL UNIQUE,
  `student_name` VARCHAR(100) NOT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `gender` VARCHAR(15) DEFAULT NULL,
  `mobile_number` VARCHAR(20) DEFAULT NULL,
  `father_name` VARCHAR(100) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `department` VARCHAR(20) NOT NULL,
  `batch` VARCHAR(20) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed initial sample students
INSERT INTO `student_data` (`pin_number`, `student_name`, `date_of_birth`, `gender`, `mobile_number`, `father_name`, `address`, `department`, `batch`) VALUES
('21A91A0501', 'Shaik Althaf', '2002-05-14', 'Male', '9876543210', 'Shaik Vali', 'Vijayawada, Andhra Pradesh', 'CSE', '2021-2025'),
('21A91A0502', 'Aarav Sharma', '2002-08-21', 'Male', '9845123456', 'Ramesh Sharma', 'Hyderabad, Telangana', 'CSE', '2021-2025'),
('21A91A0401', 'Priya Patel', '2003-01-11', 'Female', '9701234567', 'Kishore Patel', 'Bengaluru, Karnataka', 'ECE', '2021-2025'),
('21A91A0201', 'Rohan Verma', '2002-11-05', 'Male', '9988776655', 'Suresh Verma', 'Visakhapatnam, Andhra Pradesh', 'EEE', '2021-2025'),
('21A91A0101', 'Sneha Reddy', '2003-04-19', 'Female', '9123456780', 'Narayana Reddy', 'Guntur, Andhra Pradesh', 'CIVIL', '2021-2025')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------
-- Table structure for table `marks` (Mid-Term Marks)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `marks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `rollNumber` VARCHAR(30) NOT NULL,
  `department` VARCHAR(20) NOT NULL,
  `semester` VARCHAR(30) NOT NULL,
  `subject` VARCHAR(100) NOT NULL,
  `mid1` DECIMAL(5,2) DEFAULT 0.00,
  `mid2` DECIMAL(5,2) DEFAULT 0.00,
  `total` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed sample mid-term marks
INSERT INTO `marks` (`rollNumber`, `department`, `semester`, `subject`, `mid1`, `mid2`, `total`) VALUES
('21A91A0501', 'CSE', 'Semester 3', 'Mathematics-2', 26.50, 28.00, '27.25'),
('21A91A0501', 'CSE', 'Semester 3', 'Digital Electronics', 25.00, 27.50, '26.25'),
('21A91A0501', 'CSE', 'Semester 3', 'Operating System', 28.00, 29.00, '28.50'),
('21A91A0501', 'CSE', 'Semester 3', 'Data Structures Through C', 27.00, 28.50, '27.75'),
('21A91A0501', 'CSE', 'Semester 3', 'DBMS', 29.00, 29.50, '29.25');

-- --------------------------------------------------------
-- Table structure for table `internal` (Internal / Lab Marks)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `internal` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `rollNumber` VARCHAR(30) NOT NULL,
  `department` VARCHAR(20) NOT NULL,
  `semester` VARCHAR(30) NOT NULL,
  `subject` VARCHAR(100) NOT NULL,
  `total` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed sample internal marks
INSERT INTO `internal` (`rollNumber`, `department`, `semester`, `subject`, `total`) VALUES
('21A91A0501', 'CSE', 'Semester 3', 'Mathematics-2', 92.00),
('21A91A0501', 'CSE', 'Semester 3', 'Digital Electronics', 88.50),
('21A91A0501', 'CSE', 'Semester 3', 'Operating System', 95.00),
('21A91A0501', 'CSE', 'Semester 3', 'Data Structures Through C', 91.00),
('21A91A0501', 'CSE', 'Semester 3', 'DBMS', 96.00);
