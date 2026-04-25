<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'study_planner_db';

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// For debugging (remove in production)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>