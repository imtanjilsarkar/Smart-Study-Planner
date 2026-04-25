<?php
header('Content-Type: application/json');
session_start();
include_once __DIR__ . "/../database/connection.php";

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['topics' => [], 'scores' => []]);
    exit();
}

$user_id = $_SESSION['user_id'];
$topics = ['Algorithms', 'Data Structures', 'Operating Systems', 'DBMS', 'Computer Networks'];
$scores = [];

foreach($topics as $topic) {
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(correct/total)*100 as score FROM quiz_history WHERE user_id=$user_id AND topic='$topic'"));
    $scores[] = round($result['score'] ?? 50);
}

echo json_encode(['topics' => $topics, 'scores' => $scores]);
?>