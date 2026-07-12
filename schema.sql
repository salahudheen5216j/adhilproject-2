-- Todo List Database Schema
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    color VARCHAR(7) DEFAULT '#3498db',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT,
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    due_date DATETIME,
    reminder_date DATETIME,
    reminder_sent BOOLEAN DEFAULT FALSE,
    is_completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_due_date (due_date),
    INDEX idx_reminder_date (reminder_date),
    INDEX idx_is_completed (is_completed)
);

CREATE TABLE IF NOT EXISTS reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    todo_id INT NOT NULL,
    reminder_type ENUM('email', 'notification', 'both') DEFAULT 'notification',
    reminder_time DATETIME NOT NULL,
    is_sent BOOLEAN DEFAULT FALSE,
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (todo_id) REFERENCES todos(id) ON DELETE CASCADE,
    INDEX idx_is_sent (is_sent),
    INDEX idx_reminder_time (reminder_time)
);

-- Insert default categories
INSERT IGNORE INTO categories (id, name, color) VALUES 
(1, 'Work', '#e74c3c'),
(2, 'Personal', '#3498db'),
(3, 'Shopping', '#f39c12'),
(4, 'Health', '#27ae60'),
(5, 'Other', '#95a5a6');