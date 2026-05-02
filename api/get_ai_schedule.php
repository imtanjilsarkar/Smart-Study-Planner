<?php
header('Content-Type: application/json');
session_start();

// Demo schedule data (works without Python)
$demo_schedule = [
    'schedule' => [
        ['topic' => 'Algorithms', 'total_hours' => 45, 'daily_hours' => 2.5, 'priority' => 25],
        ['topic' => 'Data Structures', 'total_hours' => 40, 'daily_hours' => 2.2, 'priority' => 22],
        ['topic' => 'Operating Systems', 'total_hours' => 35, 'daily_hours' => 1.9, 'priority' => 18],
        ['topic' => 'DBMS', 'total_hours' => 30, 'daily_hours' => 1.6, 'priority' => 15],
        ['topic' => 'Computer Networks', 'total_hours' => 25, 'daily_hours' => 1.4, 'priority' => 12]
    ]
];

echo json_encode($demo_schedule);
?>
