-- ========================================
-- Smart Study Planner - Complete Database
-- GATE Preparation Platform
-- Version: 3.0 | 2026
-- ========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS study_planner_db;
USE study_planner_db;

-- ========================================
-- 1. USERS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    exam_date DATE,
    daily_hours INT DEFAULT 4,
    preferred_time VARCHAR(20) DEFAULT 'morning',
    weak_topics TEXT,
    strong_topics TEXT,
    completed_topics TEXT,
    total_study_hours INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================================
-- 2. STUDY SESSIONS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS study_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    topic VARCHAR(100),
    duration INT COMMENT 'minutes',
    study_date DATE,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ========================================
-- 3. QUIZ HISTORY TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS quiz_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    topic VARCHAR(100),
    correct INT,
    total INT,
    time_taken INT COMMENT 'seconds',
    quiz_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ========================================
-- 4. TOPICS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS topics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE,
    weightage DECIMAL(5,2) COMMENT 'GATE weightage in %',
    estimated_hours INT,
    prerequisites TEXT
);

-- ========================================
-- 5. USER PROGRESS TABLE
-- ========================================
CREATE TABLE IF NOT EXISTS user_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    topic_id INT,
    status ENUM('not_started', 'in_progress', 'completed', 'revising') DEFAULT 'not_started',
    confidence_level INT DEFAULT 0 COMMENT '1-100',
    last_studied DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (topic_id) REFERENCES topics(id)
);

-- ========================================
-- 6. INSERT GATE TOPICS (10 Topics)
-- ========================================
INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES
('Algorithms', 18.5, 45, 'Data Structures, Programming'),
('Data Structures', 16.2, 40, 'Programming Basics'),
('Operating Systems', 12.8, 35, NULL),
('DBMS', 10.5, 30, NULL),
('Computer Networks', 9.6, 28, NULL),
('Digital Logic', 7.2, 20, NULL),
('Computer Architecture', 8.4, 25, 'Digital Logic'),
('Theory of Computation', 7.8, 30, 'Discrete Mathematics'),
('Compiler Design', 5.5, 22, 'Theory of Computation'),
('Engineering Mathematics', 12.0, 35, 'High School Math');

-- ========================================
-- 7. INSERT DEMO USERS
-- Password for all: password123 (hashed)
-- ========================================

-- Demo User 1: Test User
INSERT IGNORE INTO users (name, email, password, exam_date, daily_hours) VALUES
('Test User', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-10', 6);

-- Demo User 2: Test User 2
INSERT IGNORE INTO users (name, email, password, exam_date, daily_hours) VALUES
('Test User 2', 'test2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-10', 4);

-- Demo User 3: Demo Student
INSERT IGNORE INTO users (name, email, password, exam_date, daily_hours) VALUES
('Demo Student', 'demo@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-15', 5);

-- ========================================
-- 8. INSERT SAMPLE STUDY SESSIONS
-- ========================================
INSERT IGNORE INTO study_sessions (user_id, topic, duration, study_date) VALUES
(1, 'Algorithms', 150, CURDATE()),
(1, 'Data Structures', 120, CURDATE() - INTERVAL 1 DAY),
(1, 'Operating Systems', 90, CURDATE() - INTERVAL 2 DAY),
(2, 'DBMS', 120, CURDATE()),
(2, 'Computer Networks', 100, CURDATE() - INTERVAL 1 DAY);

-- ========================================
-- 9. INSERT SAMPLE QUIZ HISTORY
-- ========================================
INSERT IGNORE INTO quiz_history (user_id, topic, correct, total, quiz_date) VALUES
(1, 'Algorithms', 3, 5, CURDATE()),
(1, 'Data Structures', 4, 5, CURDATE() - INTERVAL 1 DAY),
(1, 'Operating Systems', 2, 5, CURDATE() - INTERVAL 2 DAY),
(1, 'DBMS', 5, 5, CURDATE() - INTERVAL 3 DAY),
(2, 'Algorithms', 4, 5, CURDATE()),
(2, 'Computer Networks', 3, 5, CURDATE() - INTERVAL 1 DAY);

-- ========================================
-- 10. INSERT SAMPLE USER PROGRESS
-- ========================================
INSERT IGNORE INTO user_progress (user_id, topic_id, status, confidence_level, last_studied) VALUES
(1, 1, 'in_progress', 65, CURDATE()),
(1, 2, 'completed', 85, CURDATE() - INTERVAL 5 DAY),
(1, 3, 'not_started', 0, NULL),
(2, 1, 'completed', 80, CURDATE() - INTERVAL 3 DAY),
(2, 4, 'in_progress', 70, CURDATE());

-- ========================================
-- 11. CREATE INDEXES FOR PERFORMANCE
-- ========================================
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_session_user ON study_sessions(user_id);
CREATE INDEX idx_quiz_user ON quiz_history(user_id);
CREATE INDEX idx_progress_user ON user_progress(user_id);

-- ========================================
-- 12. VERIFY INSTALLATION
-- ========================================
SELECT '✅ Database Setup Complete!' AS Status;
SELECT COUNT(*) AS Total_Topics FROM topics;
SELECT COUNT(*) AS Total_Users FROM users;
SELECT COUNT(*) AS Total_Study_Sessions FROM study_sessions;

-- ========================================
-- END OF SQL FILE
-- ========================================