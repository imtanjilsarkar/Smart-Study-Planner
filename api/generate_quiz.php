<?php
header('Content-Type: application/json');
session_start();
include_once __DIR__ . "/../database/connection.php";

if(!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Complete Question Bank (Built-in)
$question_bank = [
    'Algorithms' => [
        ['question' => 'What is the time complexity of Binary Search?', 'options' => ['O(n)', 'O(log n)', 'O(n²)', 'O(1)'], 'correct' => 1, 'explanation' => 'Binary Search divides search space in half each time.', 'difficulty' => 'Easy'],
        ['question' => 'Which sorting algorithm has the best average-case time complexity?', 'options' => ['Bubble Sort', 'Selection Sort', 'Quick Sort', 'Insertion Sort'], 'correct' => 2, 'explanation' => 'Quick Sort averages O(n log n).', 'difficulty' => 'Medium'],
        ['question' => 'What is the space complexity of Merge Sort?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n²)'], 'correct' => 2, 'explanation' => 'Merge Sort requires O(n) auxiliary space.', 'difficulty' => 'Medium'],
        ['question' => 'Which algorithm is used to find the shortest path in a graph?', 'options' => ['Dijkstra\'s Algorithm', 'Kruskal\'s Algorithm', 'Prim\'s Algorithm', 'Floyd\'s Algorithm'], 'correct' => 0, 'explanation' => 'Dijkstra\'s algorithm finds shortest paths from source to all vertices.', 'difficulty' => 'Hard'],
    ],
    'Data Structures' => [
        ['question' => 'Which data structure uses LIFO principle?', 'options' => ['Queue', 'Stack', 'Array', 'Linked List'], 'correct' => 1, 'explanation' => 'Stack follows Last-In-First-Out principle.', 'difficulty' => 'Easy'],
        ['question' => 'What is the time complexity of inserting at the beginning of a singly linked list?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct' => 0, 'explanation' => 'Insert at head is O(1) - just update the head pointer.', 'difficulty' => 'Easy'],
        ['question' => 'Which tree traversal gives sorted order in BST?', 'options' => ['Pre-order', 'Post-order', 'In-order', 'Level-order'], 'correct' => 2, 'explanation' => 'In-order traversal (Left-Root-Right) gives sorted order.', 'difficulty' => 'Medium'],
    ],
    'Operating Systems' => [
        ['question' => 'What is a deadlock?', 'options' => ['Processes waiting indefinitely', 'CPU overload', 'Memory full', 'Disk error'], 'correct' => 0, 'explanation' => 'Deadlock occurs when processes wait indefinitely for resources.', 'difficulty' => 'Easy'],
        ['question' => 'Which scheduling algorithm is non-preemptive?', 'options' => ['Round Robin', 'FCFS', 'SRTF', 'Priority Preemptive'], 'correct' => 1, 'explanation' => 'FCFS runs processes to completion without interruption.', 'difficulty' => 'Easy'],
        ['question' => 'What is thrashing?', 'options' => ['High page fault rate', 'CPU high usage', 'Memory leak', 'Process starvation'], 'correct' => 0, 'explanation' => 'Thrashing is excessive paging due to insufficient memory.', 'difficulty' => 'Medium'],
    ],
    'DBMS' => [
        ['question' => 'What does SQL stand for?', 'options' => ['Structured Query Language', 'Simple Query Language', 'System Query Language', 'Standard Query Language'], 'correct' => 0, 'explanation' => 'SQL = Structured Query Language for database management.', 'difficulty' => 'Easy'],
        ['question' => 'Which key uniquely identifies a record?', 'options' => ['Foreign Key', 'Primary Key', 'Candidate Key', 'Alternate Key'], 'correct' => 1, 'explanation' => 'Primary Key uniquely identifies each record in a table.', 'difficulty' => 'Easy'],
        ['question' => 'What is normalization?', 'options' => ['Remove redundancy', 'Add redundancy', 'Increase speed', 'Decrease size'], 'correct' => 0, 'explanation' => 'Normalization eliminates data redundancy and anomalies.', 'difficulty' => 'Medium'],
    ],
    'Computer Networks' => [
        ['question' => 'What is the default port for HTTP?', 'options' => ['21', '22', '80', '443'], 'correct' => 2, 'explanation' => 'HTTP uses port 80, HTTPS uses 443.', 'difficulty' => 'Easy'],
        ['question' => 'What does TCP guarantee?', 'options' => ['Speed', 'Reliability', 'Security', 'Multicasting'], 'correct' => 1, 'explanation' => 'TCP provides reliable, ordered delivery of data.', 'difficulty' => 'Easy'],
        ['question' => 'What is DNS used for?', 'options' => ['Convert domain to IP', 'Convert IP to domain', 'Routing', 'Switching'], 'correct' => 0, 'explanation' => 'DNS translates domain names to IP addresses.', 'difficulty' => 'Easy'],
    ],
    'Computer Architecture' => [
        ['question' => 'What is cache memory?', 'options' => ['Fast memory between CPU and RAM', 'Slow memory', 'Permanent storage', 'Virtual memory'], 'correct' => 0, 'explanation' => 'Cache is fast SRAM that stores frequently accessed data.', 'difficulty' => 'Easy'],
        ['question' => 'What is pipelining?', 'options' => ['Overlapping instructions', 'Sequential execution', 'Parallel processing', 'Memory management'], 'correct' => 0, 'explanation' => 'Pipelining overlaps execution of multiple instructions.', 'difficulty' => 'Medium'],
    ],
    'Digital Logic' => [
        ['question' => 'What is the output of AND gate when both inputs are 1?', 'options' => ['0', '1', 'Undefined', 'Floating'], 'correct' => 1, 'explanation' => 'AND gate outputs 1 only when ALL inputs are 1.', 'difficulty' => 'Easy'],
        ['question' => 'What does XOR gate output when inputs are different?', 'options' => ['0', '1', 'Undefined', 'Depends'], 'correct' => 1, 'explanation' => 'XOR outputs 1 when inputs are different.', 'difficulty' => 'Easy'],
    ],
    'Theory of Computation' => [
        ['question' => 'What does DFA stand for?', 'options' => ['Deterministic Finite Automata', 'Digital Finite Automata', 'Data Finite Automata', 'Dynamic Finite Automata'], 'correct' => 0, 'explanation' => 'DFA = Deterministic Finite Automaton.', 'difficulty' => 'Easy'],
        ['question' => 'Which language is not regular?', 'options' => ['aⁿbⁿ', 'a*b*', '(ab)*', 'a⁺b⁺'], 'correct' => 0, 'explanation' => 'aⁿbⁿ (equal count) requires memory, not regular.', 'difficulty' => 'Hard'],
    ],
    'Compiler Design' => [
        ['question' => 'What does a lexer do?', 'options' => ['Tokenizes input', 'Parses grammar', 'Generates code', 'Optimizes code'], 'correct' => 0, 'explanation' => 'Lexer converts source code into tokens.', 'difficulty' => 'Easy'],
        ['question' => 'What is a parse tree?', 'options' => ['Syntax tree', 'Token list', 'Symbol table', 'Intermediate code'], 'correct' => 0, 'explanation' => 'Parse tree represents syntactic structure.', 'difficulty' => 'Medium'],
    ],
    'Engineering Mathematics' => [
        ['question' => 'What is the derivative of sin(x)?', 'options' => ['cos(x)', '-cos(x)', 'sin(x)', '-sin(x)'], 'correct' => 0, 'explanation' => 'd/dx sin(x) = cos(x).', 'difficulty' => 'Easy'],
        ['question' => 'What is the determinant of [[a,b],[c,d]]?', 'options' => ['ad - bc', 'ab - cd', 'ac - bd', 'ad + bc'], 'correct' => 0, 'explanation' => 'Determinant = ad - bc.', 'difficulty' => 'Medium'],
    ]
];

// Get user's weak topics from database
$weak_topics = [];
$quiz_result = mysqli_query($conn, "SELECT topic, AVG(correct/total)*100 as accuracy 
                                     FROM quiz_history 
                                     WHERE user_id=$user_id 
                                     GROUP BY topic 
                                     HAVING accuracy < 60");
if($quiz_result && mysqli_num_rows($quiz_result) > 0) {
    while($row = mysqli_fetch_assoc($quiz_result)) {
        $weak_topics[] = $row['topic'];
    }
}

// If no weak topics, use all available topics
if(empty($weak_topics)) {
    $weak_topics = array_keys($question_bank);
}

// Select random topic
$selected_topic = $weak_topics[array_rand($weak_topics)];

// Get questions for selected topic
$questions = $question_bank[$selected_topic] ?? $question_bank['Algorithms'];

// Randomly select one question
$random_index = array_rand($questions);
$selected_question = $questions[$random_index];

// Log the quiz attempt
$log_query = "INSERT INTO quiz_history (user_id, topic, correct, total, quiz_date) 
              VALUES ($user_id, '$selected_topic', 0, 1, CURDATE())";
mysqli_query($conn, $log_query);

// Return JSON response
$response = [
    'success' => true,
    'topic' => $selected_topic,
    'difficulty' => $selected_question['difficulty'] ?? 'Medium',
    'question' => $selected_question['question'],
    'options' => $selected_question['options'],
    'correct' => $selected_question['correct'],
    'explanation' => $selected_question['explanation'],
    'total_questions' => count($questions),
    'weak_topics' => $weak_topics
];

echo json_encode($response);
?>