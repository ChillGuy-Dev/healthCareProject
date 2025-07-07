CREATE DATABASE IF NOT EXISTS healthfit DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE healthfit;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password, role)
SELECT 'Admin', 'admin@healthfit.vn', 'admin123', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE email = 'admin@healthfit.vn'
);
USE healthfit;

UPDATE users
SET password = 'admin123'
WHERE email = 'admin@healthfit.vn';
