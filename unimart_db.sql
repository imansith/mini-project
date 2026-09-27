-- ========================================================
-- UniMart Database Setup Script
-- Database Name: unimart_db
-- Campus Marketplace for University Students
-- ========================================================

CREATE DATABASE IF NOT EXISTS `unimart_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `unimart_db`;

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for `messages` (Contact Form Inquiries)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for `products` (Marketplace Items)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `condition_type` VARCHAR(30) NOT NULL,
  `description` TEXT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `seller_name` VARCHAR(50) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Sample Data Insertion
-- --------------------------------------------------------

-- Default Admin/Demo User (Password: "Student123!")
INSERT INTO `users` (`username`, `email`, `password`) VALUES
('campus_buyer', 'buyer@university.edu', '$2y$10$wT0/K83lXQzG8kO7P6o3 and password hashed sample'),
('alex_cs', 'alex.dev@university.edu', '$2y$10$45zCgN/y4YJgT6vJ8eT14eQhZ4F5K6L7M8N9O0P1Q2R3S4T5U6V7W');

-- Initial Marketplace Listings
INSERT INTO `products` (`title`, `category`, `price`, `condition_type`, `description`, `image_url`, `seller_name`) VALUES
('Calculus: Early Transcendentals (8th Ed)', 'Books', 45.00, 'Like New', 'Essential textbook for MAT101 & MAT102. No highlights or markings inside.', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80', 'Sarah M.'),
('Logitech Wireless Noise-Canceling Headphones', 'Electronics', 65.00, 'Used - Good', 'Great sound quality for library study sessions. Includes charging cable and travel pouch.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', 'David K.'),
('Ergonomic Mesh Desk Chair', 'Furniture', 55.00, 'Good', 'Super comfortable for long study nights. Adjustable height and lumbar support.', 'https://images.unsplash.com/photo-1580481072645-022f9a6d1203?auto=format&fit=crop&w=600&q=80', 'Emma W.'),
('21-Speed City Commuter Bicycle', 'Sports', 120.00, 'Fair', 'Includes heavy-duty U-lock and helmet. Perfect for getting across campus quickly.', 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?auto=format&fit=crop&w=600&q=80', 'Marcus B.'),
('Mini Fridge (3.2 cu. ft. with Freezer)', 'Appliances', 85.00, 'Like New', 'Clean and quiet mini fridge. Perfect for dorm rooms or shared apartments.', 'https://images.unsplash.com/photo-1584269600464-37b1b58a9fe7?auto=format&fit=crop&w=600&q=80', 'Jessica T.'),
('iPad Air (64GB) with Apple Pencil 2', 'Electronics', 340.00, 'Like New', 'Includes original box, case, and screen protector installed. Ideal for digital note taking.', 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80', 'Liam R.');
