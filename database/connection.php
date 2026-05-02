<?php
// InfinityFree Database Configuration
$host = 'sql113.infinityfree.com';
$user = 'if0_41809097';
$password = 'Tanji1CSEHero25';
$database = 'if0_41809097_smartstudyplanner';

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
