CREATE DATABASE urbanloka_db;
USE urbanloka_db;

-- 1. Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    role ENUM('admin', 'kasir') DEFAULT 'kasir'
);

-- 2. Tabel categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- 3. Tabel products (Update: Drop Status & Featured)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    sku_code VARCHAR(50) NOT NULL UNIQUE,
    price INT NOT NULL,
    stock INT NOT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    drop_status ENUM('Limited', 'General') DEFAULT 'General',
    image VARCHAR(255),
    category_id INT DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 4. Tabel orders (Update: Total Before Discount & Amount)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    total_before_discount INT DEFAULT 0,
    discount_amount INT DEFAULT 0,
    final_total INT NOT NULL,
    promo_type VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabel order_details
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT NOT NULL,
    subtotal INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 6. Tabel company_profile
CREATE TABLE company_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    established_year INT(4),
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    mission TEXT,
    vision TEXT,
    description TEXT
);

-- ==========================================
-- DATA DUMMY (DATA AWAL)
-- ==========================================

INSERT INTO users (username, password, fullname, role) VALUES
('admin', '$2y$10$7zB3qY9n3XfC9Y6uM1z6euO9Y8P.OueM7F2rB0G7X.R.u5r2z2G0h', 'Administrator Urbanloka', 'admin'),
('kasir', '$2y$10$7zB3qY9n3XfC9Y6uM1z6euO9Y8P.OueM7F2rB0G7X.R.u5r2z2G0h', 'Kasir Urbanloka', 'kasir');

INSERT INTO categories (name) VALUES ('Apparel'), ('Accessories'), ('Footwear');

INSERT INTO products (name, sku_code, price, stock, is_featured, drop_status, image, category_id) VALUES
('T-Shirt Urban Signature', 'UL-001', 120000, 50, 1, 'General', 'tshirt.jpg', 1),
('Urban Cap Neon', 'UL-002', 90000, 12, 1, 'Limited', 'cap.jpg', 2),
('Street Industrial Hoodie', 'UL-003', 350000, 20, 0, 'General', 'hoodie.jpg', 1);

INSERT INTO company_profile (name, established_year, email, phone, address, mission, vision, description) VALUES
('URBANLOKA', 2024, 'info@urbanloka.com', '08123456789', 'Jl. Streetwear No. 101, Jakarta', 'Elevating street culture through fashion.', 'Becoming the center of urban identity.', 'Street-Industrial Warehouse');