<?php
header('Content-Type: application/json');
session_start();

$demo_score = [
    'predicted_score' => 72,
    'confidence' => 85,
    'recommendation' => 'Great progress! Keep practicing weak topics.'
];

echo json_encode($demo_score);
?>
