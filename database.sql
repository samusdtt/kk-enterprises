-- Create database
CREATE DATABASE IF NOT EXISTS kgn_water_app;
USE kgn_water_app;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT,
    role ENUM('client','staff','admin') NOT NULL,
    login_hours_enabled TINYINT(1) DEFAULT 0
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','delivered','paid','due_requested') DEFAULT 'pending',
    payment_method ENUM('cash','online','due') DEFAULT 'cash',
    total_amount DECIMAL(10,2) NOT NULL,
    category ENUM('Mall','Flats','Site','Store') DEFAULT 'Flats',
    FOREIGN KEY (client_id) REFERENCES users(id)
);

-- Order items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Staff delivery logs
CREATE TABLE IF NOT EXISTS staff_delivery_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_id INT NOT NULL,
    order_id INT NOT NULL,
    delivered_at DATETIME,
    paid_verified TINYINT(1) DEFAULT 0,
    FOREIGN KEY (staff_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Daily jar record
CREATE TABLE IF NOT EXISTS jar_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    record_date DATE,
    total_jars INT,
    refilling INT,
    empty INT,
    onboard INT
);

-- Daily accounts
CREATE TABLE IF NOT EXISTS daily_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    record_date DATE,
    type ENUM('income','expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    notes TEXT
);

-- Default products
INSERT INTO products (name, price) VALUES
('Amust Jar', 50.00),
('Bisleri Jar', 100.00),
('Amust 200ml box', 105.00),
('Bisleri 250ml box', 135.00)
ON DUPLICATE KEY UPDATE price = VALUES(price);

