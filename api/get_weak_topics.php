<?php
header('Content-Type: application/json');
session_start();

$demo_weak = [
    'weak_topics' => ['Algorithms', 'Operating Systems'],
    'strong_topics' => ['DBMS', 'Computer Networks'],
    'recommendation' => 'Focus on mastering Algorithms first. Practice daily for 2 hours!'
];

echo json_encode($demo_weak);
?>
