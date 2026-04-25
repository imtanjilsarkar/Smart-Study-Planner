<?php
$host = 'localhost';
$user = 'root';
$password = '';

// Create connection
$conn = mysqli_connect($host, $user, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS study_planner_db";
if (mysqli_query($conn, $sql)) {
    echo "✅ Database created successfully<br>";
} else {
    echo "❌ Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select database
mysqli_select_db($conn, 'study_planner_db');

// SQL queries
$queries = [
    "CREATE TABLE IF NOT EXISTS users (
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
    )",
    
    "CREATE TABLE IF NOT EXISTS study_sessions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        topic VARCHAR(100),
        duration INT COMMENT 'minutes',
        study_date DATE,
        notes TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",
    
    "CREATE TABLE IF NOT EXISTS quiz_history (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        topic VARCHAR(100),
        correct INT,
        total INT,
        time_taken INT COMMENT 'seconds',
        quiz_date DATE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",
    
    "CREATE TABLE IF NOT EXISTS topics (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) UNIQUE,
        weightage DECIMAL(5,2),
        estimated_hours INT,
        prerequisites TEXT
    )",
    
    "CREATE TABLE IF NOT EXISTS user_progress (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        topic_id INT,
        status ENUM('not_started', 'in_progress', 'completed', 'revising') DEFAULT 'not_started',
        confidence_level INT DEFAULT 0,
        last_studied DATE,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (topic_id) REFERENCES topics(id)
    )"
];

// Execute each query
foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "✅ Table created successfully<br>";
    } else {
        echo "❌ Error: " . mysqli_error($conn) . "<br>";
    }
}

// Insert topics
$topics = [
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Algorithms', 18.5, 40, 'Data Structures, Programming')",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Data Structures', 16.2, 35, 'Programming Basics')",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Operating Systems', 12.8, 30, NULL)",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('DBMS', 10.5, 25, NULL)",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Computer Networks', 9.6, 28, NULL)",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Digital Logic', 7.2, 20, NULL)",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Computer Architecture', 8.4, 25, 'Digital Logic')",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Theory of Computation', 7.8, 30, 'Discrete Mathematics')",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Compiler Design', 5.5, 22, 'Theory of Computation')",
    "INSERT IGNORE INTO topics (name, weightage, estimated_hours, prerequisites) VALUES ('Engineering Mathematics', 12.0, 35, 'High School Math')"
];

foreach ($topics as $topic) {
    if (mysqli_query($conn, $topic)) {
        echo "✅ Topic inserted<br>";
    }
}

// Insert sample user (password: password123)
$sample_user = "INSERT IGNORE INTO users (name, email, password, exam_date, daily_hours) VALUES 
                ('Test User', 'test@example.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-02-10', 6)";

if (mysqli_query($conn, $sample_user)) {
    echo "✅ Sample user created (test@example.com / password123)<br>";
}

echo "<hr>";
echo "<h2>✅ Installation Complete!</h2>";
echo "<a href='login.php'>Go to Login Page →</a>";

mysqli_close($conn);
?>