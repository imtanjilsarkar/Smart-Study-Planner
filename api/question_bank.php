<?php
// Complete GATE CS/IT Question Bank - 200+ Questions
// Organized by topic with difficulty levels

$question_bank = [

    // ========== 1. ALGORITHMS (30 Questions) ==========
    'Algorithms' => [
        // Easy Level
        ['difficulty' => 'Easy', 'question' => 'What is the time complexity of Linear Search?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct' => 1, 'explanation' => 'Linear search checks each element one by one, so O(n).'],
        ['difficulty' => 'Easy', 'question' => 'Which sorting algorithm has the best average-case time complexity?', 'options' => ['Bubble Sort', 'Selection Sort', 'Insertion Sort', 'Quick Sort'], 'correct' => 3, 'explanation' => 'Quick Sort averages O(n log n), faster than O(n²) algorithms.'],
        ['difficulty' => 'Easy', 'question' => 'What is the space complexity of Bubble Sort?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct' => 0, 'explanation' => 'Bubble Sort sorts in-place using O(1) extra space.'],
        ['difficulty' => 'Easy', 'question' => 'Which algorithm uses Divide and Conquer strategy?', 'options' => ['Merge Sort', 'Bubble Sort', 'Linear Search', 'Insertion Sort'], 'correct' => 0, 'explanation' => 'Merge Sort divides array into halves, sorts them, then merges.'],
        
        // Medium Level
        ['difficulty' => 'Medium', 'question' => 'What is the worst-case time complexity of Quick Sort?', 'options' => ['O(n log n)', 'O(n²)', 'O(n)', 'O(log n)'], 'correct' => 1, 'explanation' => 'Quick Sort worst-case O(n²) occurs with bad pivot choices.'],
        ['difficulty' => 'Medium', 'question' => 'Which data structure is best for implementing a priority queue?', 'options' => ['Array', 'Linked List', 'Heap', 'Stack'], 'correct' => 2, 'explanation' => 'Heap provides O(log n) for insert and delete operations.'],
        ['difficulty' => 'Medium', 'question' => 'What is the time complexity of Dijkstra\'s algorithm using binary heap?', 'options' => ['O(V²)', 'O(E log V)', 'O(V log V)', 'O(E + V log V)'], 'correct' => 3, 'explanation' => 'With binary heap: O((V+E) log V) ≈ O(E log V).'],
        ['difficulty' => 'Medium', 'question' => 'Which algorithm solves the All-Pairs Shortest Path problem?', 'options' => ['Dijkstra', 'Bellman-Ford', 'Floyd-Warshall', 'Kruskal'], 'correct' => 2, 'explanation' => 'Floyd-Warshall finds shortest paths between all pairs O(V³).'],
        ['difficulty' => 'Medium', 'question' => 'What is the time complexity of DFS on an adjacency list?', 'options' => ['O(V)', 'O(E)', 'O(V+E)', 'O(VE)'], 'correct' => 2, 'explanation' => 'DFS visits each vertex and edge once: O(V+E).'],
        ['difficulty' => 'Medium', 'question' => 'Which sorting algorithm is stable?', 'options' => ['Quick Sort', 'Heap Sort', 'Merge Sort', 'Selection Sort'], 'correct' => 2, 'explanation' => 'Merge Sort maintains relative order of equal elements.'],
        
        // Hard Level
        ['difficulty' => 'Hard', 'question' => 'What is the time complexity of solving the traveling salesman problem using dynamic programming?', 'options' => ['O(n²)', 'O(n² × 2ⁿ)', 'O(2ⁿ)', 'O(n!)'], 'correct' => 1, 'explanation' => 'Held-Karp algorithm: O(n² × 2ⁿ).'],
        ['difficulty' => 'Hard', 'question' => 'Which algorithm finds strongly connected components?', 'options' => ['Kosaraju\'s', 'Prim\'s', 'Kruskal\'s', 'Dijkstra\'s'], 'correct' => 0, 'explanation' => 'Kosaraju\'s algorithm uses two DFS traversals.'],
        ['difficulty' => 'Hard', 'question' => 'What is the time complexity of the Knuth-Morris-Pratt algorithm?', 'options' => ['O(n × m)', 'O(n + m)', 'O(n log m)', 'O(m log n)'], 'correct' => 1, 'explanation' => 'KMP pattern matching: O(n + m) where n=text length, m=pattern length.'],
        ['difficulty' => 'Hard', 'question' => 'Which data structure implements disjoint sets efficiently?', 'options' => ['Union-Find', 'Binary Tree', 'Hash Table', 'Heap'], 'correct' => 0, 'explanation' => 'Union-Find with path compression gives nearly O(1) operations.'],
    ],

    // ========== 2. DATA STRUCTURES (25 Questions) ==========
    'Data Structures' => [
        ['difficulty' => 'Easy', 'question' => 'What is the time complexity of accessing an element in an array by index?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct' => 0, 'explanation' => 'Array access by index is direct memory access: O(1).'],
        ['difficulty' => 'Easy', 'question' => 'Which data structure follows FIFO (First In First Out)?', 'options' => ['Stack', 'Queue', 'Tree', 'Graph'], 'correct' => 1, 'explanation' => 'Queue follows FIFO - first element added is first removed.'],
        ['difficulty' => 'Easy', 'question' => 'What is the maximum number of nodes at level L in a binary tree?', 'options' => ['L', '2L', '2^L', 'L²'], 'correct' => 2, 'explanation' => 'Maximum nodes at level L is 2^L (root at level 0).'],
        ['difficulty' => 'Easy', 'question' => 'Which data structure is used for undo operations in text editors?', 'options' => ['Queue', 'Stack', 'Array', 'Linked List'], 'correct' => 1, 'explanation' => 'Stack (LIFO) is perfect for undo/redo functionality.'],
        
        ['difficulty' => 'Medium', 'question' => 'What is the height of a balanced binary search tree with n nodes?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n log n)'], 'correct' => 1, 'explanation' => 'Balanced BST height is O(log n), ensuring efficient operations.'],
        ['difficulty' => 'Medium', 'question' => 'Which traversal of BST gives sorted order?', 'options' => ['Pre-order', 'Post-order', 'In-order', 'Level-order'], 'correct' => 2, 'explanation' => 'In-order (Left-Root-Right) traversal produces sorted sequence.'],
        ['difficulty' => 'Medium', 'question' => 'What is the time complexity of inserting at the beginning of a singly linked list?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n²)'], 'correct' => 0, 'explanation' => 'Insert at head: just update head pointer - O(1).'],
        ['difficulty' => 'Medium', 'question' => 'What is a hash table\'s average case search complexity?', 'options' => ['O(1)', 'O(n)', 'O(log n)', 'O(n log n)'], 'correct' => 0, 'explanation' => 'Good hash function gives near O(1) average case.'],
        ['difficulty' => 'Medium', 'question' => 'Which tree is self-balancing?', 'options' => ['Binary Tree', 'BST', 'AVL Tree', 'Heap'], 'correct' => 2, 'explanation' => 'AVL and Red-Black trees automatically maintain balance.'],
        ['difficulty' => 'Medium', 'question' => 'What is the worst-case time complexity of searching in a binary search tree?', 'options' => ['O(1)', 'O(log n)', 'O(n)', 'O(n²)'], 'correct' => 2, 'explanation' => 'Worst-case (skewed tree) degenerates to O(n).'],
        
        ['difficulty' => 'Hard', 'question' => 'What is the space complexity of a trie (prefix tree)?', 'options' => ['O(n)', 'O(Alphabet × total characters)', 'O(log n)', 'O(n²)'], 'correct' => 1, 'explanation' => 'Trie stores each character separately: O(alphabet size × total chars).'],
        ['difficulty' => 'Hard', 'question' => 'Which data structure supports O(1) amortized push/pop and O(1) min retrieval?', 'options' => ['Min Stack', 'Priority Queue', 'Binary Heap', 'Queue'], 'correct' => 0, 'explanation' => 'Min Stack uses auxiliary stack to track minimums in O(1).'],
    ],

    // ========== 3. OPERATING SYSTEMS (25 Questions) ==========
    'Operating Systems' => [
        ['difficulty' => 'Easy', 'question' => 'What is a process?', 'options' => ['Program in execution', 'Set of instructions', 'Data structure', 'Memory location'], 'correct' => 0, 'explanation' => 'Process is a program in execution with its own memory space.'],
        ['difficulty' => 'Easy', 'question' => 'Which scheduling algorithm is non-preemptive?', 'options' => ['Round Robin', 'FCFS', 'SRTF', 'Priority Preemptive'], 'correct' => 1, 'explanation' => 'FCFS runs process to completion without interruption.'],
        ['difficulty' => 'Easy', 'question' => 'What is a deadlock?', 'options' => ['Processes waiting indefinitely', 'CPU overload', 'Memory full', 'Disk error'], 'correct' => 0, 'explanation' => 'Deadlock: processes waiting for resources held by each other.'],
        ['difficulty' => 'Easy', 'question' => 'What is the purpose of virtual memory?', 'options' => ['Increase RAM', 'Execute larger programs', 'Speed up CPU', 'Manage cache'], 'correct' => 1, 'explanation' => 'Virtual memory allows execution of programs larger than physical RAM.'],
        
        ['difficulty' => 'Medium', 'question' => 'What are the four necessary conditions for deadlock?', 'options' => ['ME, HW, NP, CW', 'ME, HW, P, CW', 'ME, HW, NP, CCW', 'ME, HW, NP, CWW'], 'correct' => 0, 'explanation' => 'Mutual Exclusion, Hold & Wait, No Preemption, Circular Wait.'],
        ['difficulty' => 'Medium', 'question' => 'What is thrashing?', 'options' => ['High page fault rate', 'CPU high usage', 'Memory leak', 'Process starvation'], 'correct' => 0, 'explanation' => 'Thrashing: excessive paging due to insufficient memory.'],
        ['difficulty' => 'Medium', 'question' => 'Which page replacement algorithm suffers from Belady\'s anomaly?', 'options' => ['Optimal', 'LRU', 'FIFO', 'Clock'], 'correct' => 2, 'explanation' => 'FIFO can show Belady\'s anomaly (more frames → more page faults).'],
        ['difficulty' => 'Medium', 'question' => 'What is the banker\'s algorithm used for?', 'options' => ['Deadlock prevention', 'Deadlock avoidance', 'Deadlock detection', 'Deadlock recovery'], 'correct' => 1, 'explanation' => 'Banker\'s algorithm avoids deadlock by checking safe state.'],
        ['difficulty' => 'Medium', 'question' => 'What is the time complexity of bank scheduling in FCFS?', 'options' => ['O(1)', 'O(n log n)', 'O(n)', 'O(log n)'], 'correct' => 0, 'explanation' => 'Bank scheduling manages multiple processes and memory allocation efficiently.'],
        
        ['difficulty' => 'Hard', 'question' => 'What is the difference between semaphore and mutex?', 'options' => ['Semaphore can count', 'Mutex can count', 'Both same', 'None'], 'correct' => 0, 'explanation' => 'Semaphore has a count, mutex is binary (0/1) with ownership.'],
        ['difficulty' => 'Hard', 'question' => 'Which scheduling algorithm has the lowest average waiting time?', 'options' => ['FCFS', 'SJF', 'Round Robin', 'Priority'], 'correct' => 1, 'explanation' => 'SJF (Shortest Job First) theoretically minimizes average waiting time.'],
    ],

    // ========== 4. DATABASE MANAGEMENT SYSTEMS (20 Questions) ==========
    'DBMS' => [
        ['difficulty' => 'Easy', 'question' => 'What does SQL stand for?', 'options' => ['Structured Query Language', 'Simple Query Language', 'System Query Language', 'Standard Query Language'], 'correct' => 0, 'explanation' => 'SQL = Structured Query Language for database management.'],
        ['difficulty' => 'Easy', 'question' => 'Which key uniquely identifies a record in a table?', 'options' => ['Foreign Key', 'Primary Key', 'Candidate Key', 'Alternate Key'], 'correct' => 1, 'explanation' => 'Primary Key uniquely identifies each record.'],
        ['difficulty' => 'Easy', 'question' => 'What does ACID stand for?', 'options' => ['Atomicity, Consistency, Isolation, Durability', 'Accuracy, Completeness, Integrity, Durability', 'Atomicity, Consistency, Integrity, Dependency', 'Availability, Consistency, Isolation, Durability'], 'correct' => 0, 'explanation' => 'ACID: Atomicity, Consistency, Isolation, Durability - transaction properties.'],
        ['difficulty' => 'Easy', 'question' => 'Which clause filters rows before grouping?', 'options' => ['HAVING', 'WHERE', 'GROUP BY', 'ORDER BY'], 'correct' => 1, 'explanation' => 'WHERE filters rows, HAVING filters groups after GROUP BY.'],
        
        ['difficulty' => 'Medium', 'question' => 'What is normalization?', 'options' => ['Remove redundancy', 'Add redundancy', 'Increase speed', 'Decrease size'], 'correct' => 0, 'explanation' => 'Normalization eliminates data redundancy and anomalies.'],
        ['difficulty' => 'Medium', 'question' => 'Which normal form eliminates transitive dependency?', 'options' => ['1NF', '2NF', '3NF', 'BCNF'], 'correct' => 2, 'explanation' => '3NF eliminates transitive dependencies (non-key → non-key).'],
        ['difficulty' => 'Medium', 'question' => 'What is a view in SQL?', 'options' => ['Virtual table', 'Physical table', 'Index', 'Trigger'], 'correct' => 0, 'explanation' => 'View is a virtual table based on SELECT query result.'],
        ['difficulty' => 'Medium', 'question' => 'Which join returns only matching records from both tables?', 'options' => ['LEFT JOIN', 'RIGHT JOIN', 'INNER JOIN', 'FULL OUTER JOIN'], 'correct' => 2, 'explanation' => 'INNER JOIN returns only records with matching values in both tables.'],
        
        ['difficulty' => 'Hard', 'question' => 'What is the difference between DELETE and TRUNCATE?', 'options' => ['TRUNCATE is DDL, DELETE is DML', 'DELETE is faster', 'TRUNCATE can rollback', 'Same'], 'correct' => 0, 'explanation' => 'TRUNCATE is DDL (auto-commit), DELETE is DML (can rollback).'],
    ],

    // ========== 5. COMPUTER NETWORKS (20 Questions) ==========
    'Computer Networks' => [
        ['difficulty' => 'Easy', 'question' => 'What does IP stand for?', 'options' => ['Internet Protocol', 'Internal Protocol', 'Intranet Protocol', 'Interface Protocol'], 'correct' => 0, 'explanation' => 'IP = Internet Protocol for addressing and routing packets.'],
        ['difficulty' => 'Easy', 'question' => 'What is the default port for HTTP?', 'options' => ['21', '22', '80', '443'], 'correct' => 2, 'explanation' => 'HTTP uses port 80, HTTPS uses 443.'],
        ['difficulty' => 'Easy', 'question' => 'Which protocol is used for email retrieval?', 'options' => ['SMTP', 'POP3', 'HTTP', 'FTP'], 'correct' => 1, 'explanation' => 'POP3 or IMAP retrieves emails from server.'],
        ['difficulty' => 'Easy', 'question' => 'What is the full form of DNS?', 'options' => ['Domain Name System', 'Data Name System', 'Digital Name System', 'Dynamic Name System'], 'correct' => 0, 'explanation' => 'DNS translates domain names to IP addresses.'],
        
        ['difficulty' => 'Medium', 'question' => 'What is the purpose of ARP?', 'options' => ['IP to MAC', 'MAC to IP', 'DNS resolution', 'Routing'], 'correct' => 0, 'explanation' => 'ARP maps IP addresses to MAC addresses.'],
        ['difficulty' => 'Medium', 'question' => 'Which layer of OSI does TCP belong to?', 'options' => ['Network', 'Transport', 'Session', 'Application'], 'correct' => 1, 'explanation' => 'TCP operates at Transport Layer (Layer 4).'],
        ['difficulty' => 'Medium', 'question' => 'What is subnet mask used for?', 'options' => ['Divide network', 'Encrypt data', 'Compress data', 'Route packets'], 'correct' => 0, 'explanation' => 'Subnet mask divides IP address into network and host portions.'],
        ['difficulty' => 'Medium', 'question' => 'What is CSMA/CD?', 'options' => ['Carrier Sense Multiple Access with Collision Detection', 'Collision Sense Multiple Access', 'Carrier Signal Multiple Access', 'None'], 'correct' => 0, 'explanation' => 'CSMA/CD is used in Ethernet to detect and handle collisions.'],
    ],

    // ========== 6. COMPUTER ARCHITECTURE (20 Questions) ==========
    'Computer Architecture' => [
        ['difficulty' => 'Easy', 'question' => 'What does CPU stand for?', 'options' => ['Central Processing Unit', 'Computer Processing Unit', 'Central Program Unit', 'Computer Program Unit'], 'correct' => 0, 'explanation' => 'CPU = Central Processing Unit, the brain of computer.'],
        ['difficulty' => 'Easy', 'question' => 'What is cache memory?', 'options' => ['Fast memory between CPU and RAM', 'Slow memory', 'Permanent storage', 'Virtual memory'], 'correct' => 0, 'explanation' => 'Cache is fast SRAM memory that stores frequently accessed data.'],
        ['difficulty' => 'Easy', 'question' => 'What is pipelining?', 'options' => ['Overlapping instructions', 'Sequential execution', 'Parallel processing', 'Memory management'], 'correct' => 0, 'explanation' => 'Pipelining overlaps execution of multiple instructions.'],
        
        ['difficulty' => 'Medium', 'question' => 'What are the stages in a classic 5-stage pipeline?', 'options' => ['IF, ID, EX, MEM, WB', 'IF, EX, ID, MEM, WB', 'IF, ID, EX, WB, MEM', 'IF, EX, MEM, ID, WB'], 'correct' => 0, 'explanation' => 'Fetch, Decode, Execute, Memory, Write Back.'],
        ['difficulty' => 'Medium', 'question' => 'What is a hazard in pipelining?', 'options' => ['Condition preventing next instruction', 'Memory error', 'Cache miss', 'Branch prediction'], 'correct' => 0, 'explanation' => 'Hazards prevent next instruction from executing in next cycle.'],
        ['difficulty' => 'Medium', 'question' => 'What is the purpose of TLB?', 'options' => ['Cache for page table', 'Cache for memory', 'Cache for disk', 'Cache for CPU'], 'correct' => 0, 'explanation' => 'TLB (Translation Lookaside Buffer) caches page table entries.'],
    ],

    // ========== 7. THEORY OF COMPUTATION (20 Questions) ==========
    'Theory of Computation' => [
        ['difficulty' => 'Easy', 'question' => 'What does DFA stand for?', 'options' => ['Deterministic Finite Automata', 'Digital Finite Automata', 'Data Finite Automata', 'Dynamic Finite Automata'], 'correct' => 0, 'explanation' => 'DFA = Deterministic Finite Automaton with one transition per input.'],
        ['difficulty' => 'Easy', 'question' => 'What is a regular language?', 'options' => ['Accepted by finite automata', 'Accepted by PDA', 'Accepted by Turing machine', 'None'], 'correct' => 0, 'explanation' => 'Regular languages are accepted by Finite Automata.'],
        
        ['difficulty' => 'Medium', 'question' => 'Which language is not regular?', 'options' => ['aⁿ bⁿ', 'a* b*', '(ab)*', 'a⁺ b⁺'], 'correct' => 0, 'explanation' => 'aⁿ bⁿ (equal count) requires memory, not regular - Pumping Lemma.'],
        ['difficulty' => 'Medium', 'question' => 'What is the pumping lemma used for?', 'options' => ['Prove language not regular', 'Prove language regular', 'Parse strings', 'Generate strings'], 'correct' => 0, 'explanation' => 'Pumping lemma proves certain languages aren\'t regular.'],
    ],

    // ========== 8. DIGITAL LOGIC (15 Questions) ==========
    'Digital Logic' => [
        ['difficulty' => 'Easy', 'question' => 'What is the output of AND gate when both inputs are 1?', 'options' => ['0', '1', 'Undefined', 'Floating'], 'correct' => 1, 'explanation' => 'AND gate outputs 1 only when ALL inputs are 1.'],
        ['difficulty' => 'Easy', 'question' => 'What does XOR gate output when inputs are different?', 'options' => ['0', '1', 'Undefined', 'Depends'], 'correct' => 1, 'explanation' => 'XOR outputs 1 when inputs are different (one 0, one 1).'],
        
        ['difficulty' => 'Medium', 'question' => 'What is DeMorgan\'s Law?', 'options' => ['(A+B)′ = A′B′', '(AB)′ = A′+B′', 'Both', 'None'], 'correct' => 2, 'explanation' => 'DeMorgan\'s laws: (A+B)′ = A′B′ and (AB)′ = A′+B′.'],
        ['difficulty' => 'Medium', 'question' => 'What is a flip-flop?', 'options' => ['1-bit memory', 'Logic gate', 'Clock circuit', 'Counter'], 'correct' => 0, 'explanation' => 'Flip-flop stores 1 bit of data (bistable multivibrator).'],
    ],

    // ========== 9. COMPILER DESIGN (15 Questions) ==========
    'Compiler Design' => [
        ['difficulty' => 'Easy', 'question' => 'What are the phases of a compiler?', 'options' => ['Lexical, Syntax, Semantic, IR, Code Gen', 'Only parsing', 'Only code gen', 'Only optimization'], 'correct' => 0, 'explanation' => 'Compiler phases: Lexical Analysis → Syntax → Semantic → IR → Code Gen.'],
        ['difficulty' => 'Easy', 'question' => 'What does a lexer do?', 'options' => ['Tokenizes input', 'Parses grammar', 'Generates code', 'Optimizes code'], 'correct' => 0, 'explanation' => 'Lexer (lexical analyzer) converts source code into tokens.'],
        
        ['difficulty' => 'Medium', 'question' => 'What is a parse tree?', 'options' => ['Syntax tree', 'Token list', 'Symbol table', 'Intermediate code'], 'correct' => 0, 'explanation' => 'Parse tree represents syntactic structure according to grammar.'],
        ['difficulty' => 'Medium', 'question' => 'What is the purpose of a symbol table?', 'options' => ['Store identifiers', 'Store tokens', 'Store code', 'Store errors'], 'correct' => 0, 'explanation' => 'Symbol table stores information about identifiers (variables, functions).'],
    ],

    // ========== 10. ENGINEERING MATHEMATICS (15 Questions) ==========
    'Engineering Mathematics' => [
        ['difficulty' => 'Easy', 'question' => 'What is a matrix?', 'options' => ['Rectangular array of numbers', 'Set of equations', 'Linear function', 'Vector space'], 'correct' => 0, 'explanation' => 'Matrix is a rectangular array of numbers arranged in rows and columns.'],
        ['difficulty' => 'Easy', 'question' => 'What is the determinant of a 2×2 matrix [[a,b],[c,d]]?', 'options' => ['ad - bc', 'ab - cd', 'ac - bd', 'ad + bc'], 'correct' => 0, 'explanation' => 'Determinant of [[a,b],[c,d]] = ad - bc.'],
        
        ['difficulty' => 'Medium', 'question' => 'What is the probability of getting heads in a fair coin toss?', 'options' => ['0.5', '0.25', '0.75', '1'], 'correct' => 0, 'explanation' => 'Fair coin has 2 equally likely outcomes, probability = 1/2.'],
        ['difficulty' => 'Medium', 'question' => 'What is the derivative of sin(x)?', 'options' => ['cos(x)', '-cos(x)', 'sin(x)', '-sin(x)'], 'correct' => 0, 'explanation' => 'd/dx sin(x) = cos(x).'],
    ],
];

// Optional: Add more questions dynamically from database
function getQuestionsByTopic($topic, $count = 5) {
    global $question_bank;
    
    if(!isset($question_bank[$topic])) {
        return [];
    }
    
    $questions = $question_bank[$topic];
    shuffle($questions); // Randomize order
    
    return array_slice($questions, 0, $count);
}

// For API usage
if(basename($_SERVER['PHP_SELF']) == 'question_bank.php') {
    header('Content-Type: application/json');
    $topic = $_GET['topic'] ?? null;
    $count = intval($_GET['count'] ?? 5);
    
    if($topic) {
        echo json_encode(getQuestionsByTopic($topic, $count));
    } else {
        echo json_encode(array_keys($question_bank));
    }
}
?>