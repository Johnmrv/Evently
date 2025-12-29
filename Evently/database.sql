-- Evently Database Schema
-- Created for Event Management System

-- Users table (Authentication & User Roles)
-- Backend: TRISTAN
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'organizer', 'user') DEFAULT 'user',
    profile_picture VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'banned') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Events table (Event Management)
-- Backend: STEFFI
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    venue_name VARCHAR(200) NOT NULL,
    venue_address TEXT NOT NULL,
    venue_image VARCHAR(255) DEFAULT NULL,
    max_capacity INT NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'unavailable') DEFAULT 'pending',
    admin_approved_by INT DEFAULT NULL,
    admin_approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_approved_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Event Images table (Multiple images per event)
-- Backend: STEFFI
CREATE TABLE IF NOT EXISTS event_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Bookings/Registrations table (Registration & Participants)
-- Backend: GERO
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    number_of_attendees INT NOT NULL DEFAULT 1,
    note TEXT DEFAULT NULL,
    status ENUM('pending', 'approved', 'declined', 'cancelled') DEFAULT 'pending',
    organizer_approved_by INT DEFAULT NULL,
    organizer_approved_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (organizer_approved_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_booking (event_id, user_id, event_date, event_time)
);

-- Insert default admin user
-- Backend: TRISTAN
-- Default password: admin123
-- To change password, use: UPDATE users SET password = PASSWORD_HASH('newpassword', PASSWORD_DEFAULT) WHERE username = 'admin';
-- Or login and change password through the profile page
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@evently.com', '$2y$10$0KIHnTcwgI6d5bxm2ry28.koNNQnBKNeO/IjNV7SqqVpArtbkCh6O', 'System Administrator', 'admin');

