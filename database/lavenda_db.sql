-- إنشاء قاعدة البيانات
CREATE DATABASE IF NOT EXISTS lavenda_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE lavenda_db;

-- جدول المستخدمين
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول المنتجات
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الرسائل (تواصل معنا)
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- جدول الطلبات
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- إدخال منتجات افتراضية
INSERT INTO products (name, description, price, image) VALUES
('كريم العناية', 'كريم مرطب للبشرة الجافة', 8000.00, 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=500'),
('مجموعة المكياج', 'مجموعة مكياج كاملة', 12000.00, 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=500'),
('مجموعة الجمال', 'مجموعة عناية متكاملة', 10000.00, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500');

-- إدخال مستخدم تجريبي (كلمة المرور: 123456)
INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@lavenda.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1HlCS4bZJ18JuywdB6M4N5q8Z0K1W2');