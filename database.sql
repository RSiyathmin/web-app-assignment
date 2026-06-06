CREATE DATABASE IF NOT EXISTS shopforge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE shopforge;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(500),
    featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, category, stock, featured) VALUES
('Wireless Noise-Cancelling Headphones', 'Premium over-ear headphones with 40-hour battery life and studio-grade sound.', 129.99, 'Electronics', 45, 1),
('Minimalist Leather Wallet', 'Slim RFID-blocking wallet in genuine full-grain leather. Holds up to 12 cards.', 49.99, 'Accessories', 120, 1),
('Ceramic Pour-Over Coffee Set', 'Hand-thrown ceramic dripper with matching server. Makes 2-4 cups of exceptional coffee.', 74.99, 'Kitchen', 30, 1),
('Mechanical Keyboard TKL', 'Tenkeyless mechanical keyboard with Cherry MX Brown switches and RGB backlighting.', 99.99, 'Electronics', 60, 0),
('Bamboo Desk Organizer', 'Eco-friendly 5-slot desk organizer made from sustainable bamboo.', 34.99, 'Office', 85, 1),
('Stainless Steel Water Bottle', 'Double-wall vacuum insulated 750ml bottle. Keeps drinks cold 24hrs, hot 12hrs.', 29.99, 'Kitchen', 200, 0),
('Merino Wool Beanie', 'Ultra-soft extra-fine merino wool beanie. One size fits all.', 39.99, 'Accessories', 150, 0),
('USB-C Hub 7-in-1', 'Expand your laptop with 4K HDMI, 3x USB-A, SD card, and 100W PD charging.', 59.99, 'Electronics', 75, 0);

INSERT INTO admin_users (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
