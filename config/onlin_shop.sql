CREATE DATABASE IF NOT EXISTS web_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web_project;

-- 1. جدول کاربران
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. جدول محصولات
CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. جدول سبد خرید
CREATE TABLE IF NOT EXISTS carts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. جدول آیتم‌های سبد خرید
CREATE TABLE IF NOT EXISTS cart_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cart_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------
-- 🧪 درج داده‌های نمونه
-- --------------------------------------

-- کاربران (رمز عبور هَش‌شده است: password)
INSERT INTO users (name, email, password) VALUES
('کاربر تست', 'test@example.com', '$2y$10$e0NRUO6dAfk.l1J7Q3zZzeQ5SGItKz5ODpd4J8f8h8CFUK/CdJG9y'); 

-- محصولات (با تصاویر فرضی)
INSERT INTO products (name, description, price, image) VALUES
('گوشی هوشمند A1', 'یک گوشی با کیفیت و قیمت مناسب', 4500000, 'elegant-smartphone-composition.jpg'),
('هدفون بی‌سیم X', 'صدای با کیفیت و طراحی ارگونومیک', 850000, '69f8794338e9a85e838eda2dce7c4a6f9b9359ad_1643522308.jpg'),
('لپ‌تاپ حرفه‌ای Z', 'مناسب برای کارهای گرافیکی و مهندسی', 12000000, 'images.jpg'),
('ماوس گیمینگ RGB', 'طراحی ارگونومیک با نورپردازی RGB', 350000, 'Perdiction M901-K-2 2.webp');

-- سبد خرید برای کاربر تست (id=1)
INSERT INTO carts (user_id) VALUES (1);

-- آیتم‌های سبد خرید (فرضاً محصول 1 و 2 در سبد)
INSERT INTO cart_items (cart_id, product_id, quantity) VALUES
(1, 1, 2),
(1, 2, 1);
