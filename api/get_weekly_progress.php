<?php
header('Content-Type: application/json');
session_start();

$demo_progress = [
    'hours' => [2.5, 3.0, 2.0, 3.5, 4.0, 2.5, 3.0]
];

echo json_encode($demo_progress);
?>
