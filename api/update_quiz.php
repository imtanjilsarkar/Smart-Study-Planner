<?php
header('Content-Type: application/json');
session_start();
include_once __DIR__ . "/../database/connection.php";

if(!isset($_SESSION['user_id'])) { echo json_encode(['error' => 'Not logged in']); exit(); }

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];
$topic = mysqli_real_escape_string($conn, $data['topic'] ?? 'General');
$correct = (int)($data['correct'] ?? 0);
$total = (int)($data['total'] ?? 1);

$query = "INSERT INTO quiz_history (user_id, topic, correct, total, quiz_date) VALUES ($user_id, '$topic', $correct, $total, CURDATE())";
mysqli_query($conn, $query);
echo json_encode(['success' => true]);
?>