CREATE DATABASE database; --Вставьте сюда своё название бд

-- Использование базы данных
USE database; --И сюда тоже
CREATE TABLE visits
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    ip         VARCHAR(45),
    city       VARCHAR(100),
    device     TEXT,
    visit_time DATETIME DEFAULT CURRENT_TIMESTAMP
);