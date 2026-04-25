<?php
header('Content-Type: application/json');
session_start();
include_once __DIR__ . "/../database/connection.php";

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get last 7 days of study data
$hours = [];
for($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(duration) as total 
                                                        FROM study_sessions 
                                                        WHERE user_id=$user_id AND study_date='$date'"));
    $hours[] = round(($result['total'] ?? 0) / 60, 1);
}

echo json_encode(['hours' => $hours]);
?>