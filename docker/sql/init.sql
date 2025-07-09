CREATE DATABASE IF NOT EXISTS healthfit
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE healthfit;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS measurements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  height FLOAT NOT NULL,
  weight FLOAT NOT NULL,
  bmi FLOAT NOT NULL,
  fat_percentage FLOAT,
  muscle_mass FLOAT,
  date DATE NOT NULL,
  notes TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Tạo tài khoản admin mặc định
INSERT INTO users (name, email, password, role)
SELECT 'Admin', 'admin@healthfit.vn', 'admin123', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM users WHERE email = 'admin@healthfit.vn'
);
