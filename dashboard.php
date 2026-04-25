<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once __DIR__ . "/database/connection.php";

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));

// Calculate days left
$days_left = 0;
if($user['exam_date']) {
    $exam = new DateTime($user['exam_date']);
    $today = new DateTime();
    $days_left = $today->diff($exam)->days;
    if($days_left < 0) $days_left = 30;
}

// Get total study hours
$hours_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(duration) as total FROM study_sessions WHERE user_id=$user_id"));
$total_hours = $hours_result['total'] ?? 0;
$total_hours_hrs = floor($total_hours / 60);
$total_hours_mins = $total_hours % 60;

// Get completed topics count
$completed_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM user_progress WHERE user_id=$user_id AND status='completed'"))['count'] ?? 0;
$total_topics = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM topics"))['count'] ?? 10;
$progress = $total_topics > 0 ? round(($completed_count / $total_topics) * 100) : 0;

// Get today's study hours
$today_study = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(duration) as total FROM study_sessions WHERE user_id=$user_id AND study_date=CURDATE()"))['total'] ?? 0;
$today_hours = floor($today_study / 60);
$today_mins = $today_study % 60;

// Calculate study streak
$streak = 0;
$current_date = date('Y-m-d');
$check_date = $current_date;
for($i = 0; $i < 30; $i++) {
    $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM study_sessions WHERE user_id=$user_id AND study_date='$check_date'"));
    if($check['count'] > 0) {
        $streak++;
        $check_date = date('Y-m-d', strtotime("-$i days"));
    } else {
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Student Dashboard</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Animated Gradient Background */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.08) 0%, transparent 50%);
            z-index: -2;
            animation: bgPulse 8s ease-in-out infinite;
        }

        @keyframes bgPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        /* Noise Texture */
        .noise-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
            z-index: -1;
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: rgba(139, 92, 246, 0.3);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.5;
            }
            90% {
                opacity: 0.5;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Glassmorphism Navbar */
        .glass-nav {
            position: fixed;
            top: 20px;
            left: 5%;
            right: 5%;
            width: 90%;
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border-radius: 80px;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .glass-nav.scrolled {
            top: 10px;
            background: rgba(10, 10, 10, 0.95);
            border-color: rgba(139, 92, 246, 0.3);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a855f7, #3b82f6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #e0e0e0;
            font-weight: 500;
            transition: 0.3s;
            font-size: 14px;
        }

        .nav-links a:hover {
            color: #a855f7;
        }

        .user-badge {
            background: rgba(139, 92, 246, 0.2);
            padding: 8px 16px;
            border-radius: 40px;
            border: 1px solid rgba(139, 92, 246, 0.3);
            font-size: 14px;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.2);
            padding: 8px 20px;
            border-radius: 40px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.4);
            color: white !important;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 40px 40px;
        }

        /* Welcome Section */
        .welcome-card {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.08));
            border-radius: 28px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(139, 92, 246, 0.2);
            backdrop-filter: blur(10px);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin: 3px;
        }

        .badge-gold { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #000; }
        .badge-silver { background: linear-gradient(135deg, #9ca3af, #6b7280); color: #fff; }
        .badge-fire { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
        .badge-purple { background: linear-gradient(135deg, #a855f7, #7c3aed); color: #fff; }

        /* Two Column Layout */
        .two-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Timer Circle */
        .timer-circle {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(139, 92, 246, 0.5);
            position: relative;
        }

        .timer-circle::before {
            content: '';
            position: absolute;
            width: 110%;
            height: 110%;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), transparent);
            filter: blur(10px);
            z-index: -1;
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .timer-text {
            font-size: 36px;
            font-weight: 700;
            font-family: monospace;
        }

        .timer-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .timer-btn {
            padding: 8px 20px;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-start { background: linear-gradient(135deg, #22c55e, #16a34a); color: white; }
        .btn-pause { background: linear-gradient(135deg, #eab308, #ca8a04); color: white; }
        .btn-reset { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }

        .topic-select {
            width: 100%;
            padding: 12px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-family: 'Inter', sans-serif;
        }

        /* Quiz Section */
        .quiz-question {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 16px;
            padding: 20px;
            margin-top: 15px;
        }

        .quiz-option {
            background: rgba(255, 255, 255, 0.05);
            padding: 12px;
            margin: 8px 0;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
        }

        .quiz-option:hover {
            background: rgba(139, 92, 246, 0.3);
            transform: translateX(5px);
        }

        /* Table */
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table th, .schedule-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .schedule-table th {
            background: rgba(139, 92, 246, 0.15);
            color: #a855f7;
        }

        .schedule-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Weak Topics */
        .weak-topic {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .weak-topic:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateX(5px);
        }

        .focus-btn {
            background: linear-gradient(135deg, #a855f7, #7c3aed);
            border: none;
            padding: 6px 15px;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .focus-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
        }

        .recommendation-card {
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 16px;
            padding: 15px;
            margin-top: 15px;
        }

        /* Toast Notification */
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 15px 25px;
            border-radius: 12px;
            color: white;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        /* Footer */
        .dashboard-footer {
            margin-top: 40px;
            padding: 30px;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 768px) {
            .container { padding: 80px 20px 20px; }
            .two-columns { grid-template-columns: 1fr; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 10px; }
            .nav-links a { font-size: 12px; }
            .user-badge { display: none; }
        }
    </style>
</head>
<body>

<div class="gradient-bg"></div>
<div class="noise-bg"></div>
<div class="particles" id="particles"></div>

<!-- Glass Navbar -->
<nav class="glass-nav" id="navbar">
    <div class="logo">
        <i class="fas fa-brain"></i> SmartStudy<span style="color: #a855f7;">AI</span>
    </div>
    <div class="nav-links">
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
        <span class="user-badge"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="container">
    <!-- Welcome Section -->
    <div class="welcome-card" data-aos="fade-up">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div>
                <h1 style="font-size: 28px; margin-bottom: 8px;">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
                <p>GATE 2026 in <strong style="color: #a855f7;"><?php echo $days_left; ?> days</strong> • Stay consistent and focused!</p>
                <div style="display: flex; gap: 15px; margin-top: 15px; flex-wrap: wrap;">
                    <span style="background: rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 20px; font-size: 12px;"><i class="fas fa-calendar"></i> Target: <?php echo date('d M Y', strtotime($user['exam_date'])); ?></span>
                    <span style="background: rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 20px; font-size: 12px;"><i class="fas fa-bullseye"></i> Daily Goal: <?php echo $user['daily_hours']; ?> hrs</span>
                </div>
            </div>
            <div>
                <a href="index.php" style="background: rgba(139,92,246,0.2); padding: 10px 20px; border-radius: 40px; text-decoration: none; color: white;">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-value"><?php echo $total_hours_hrs; ?>h <?php echo $total_hours_mins; ?>m</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">Total Study Hours</div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-value"><?php echo $today_hours; ?>h <?php echo $today_mins; ?>m</div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">Today's Study</div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-value"><?php echo $completed_count; ?>/<?php echo $total_topics; ?></div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">Topics Completed</div>
            <div class="progress-bar" style="margin-top: 8px;">
                <div style="width: <?php echo $progress; ?>%; height: 4px; background: linear-gradient(90deg, #a855f7, #3b82f6); border-radius: 2px;"></div>
            </div>
        </div>
        <div class="stat-card" data-aos="fade-up" data-aos-delay="250">
            <div class="stat-value"><i class="fas fa-fire" style="color: #f97316; font-size: 28px;"></i> <?php echo $streak; ?></div>
            <div style="font-size: 12px; color: #9ca3af; margin-top: 5px;">Day Streak</div>
        </div>
    </div>

    <!-- Badges -->
    <div class="glass-card" style="margin-bottom: 30px;" data-aos="fade-up" data-aos-delay="300">
        <div class="card-title"><i class="fas fa-medal"></i> Your Achievements</div>
        <div>
            <?php if($streak >= 7): ?><span class="badge badge-fire"><i class="fas fa-fire"></i> 7-Day Streak</span><?php endif; ?>
            <?php if($total_hours >= 600): ?><span class="badge badge-gold"><i class="fas fa-crown"></i> 10+ Hours</span><?php endif; ?>
            <?php if($progress >= 50): ?><span class="badge badge-silver"><i class="fas fa-star"></i> Halfway Hero</span><?php endif; ?>
            <span class="badge badge-purple"><i class="fas fa-rocket"></i> GATE Warrior</span>
            <span class="badge badge-purple"><i class="fas fa-brain"></i> AI Learner</span>
        </div>
    </div>

    <!-- Two Columns -->
    <div class="two-columns">
        <!-- Timer Card -->
        <div class="glass-card" data-aos="fade-right" data-aos-delay="400">
            <div class="card-title"><i class="fas fa-hourglass-half" style="color: #22c55e;"></i> Focus Flow Timer</div>
            <div class="timer-circle">
                <div class="timer-text" id="timerDisplay">25:00</div>
            </div>
            <div class="timer-buttons">
                <button class="timer-btn btn-start" id="startBtn"><i class="fas fa-play"></i> Start</button>
                <button class="timer-btn btn-pause" id="pauseBtn"><i class="fas fa-pause"></i> Pause</button>
                <button class="timer-btn btn-reset" id="resetBtn"><i class="fas fa-redo"></i> Reset</button>
            </div>
            <select id="topicSelect" class="topic-select">
                <option value="">📖 Select topic you're studying...</option>
                <?php $topics = mysqli_query($conn, "SELECT name FROM topics"); while($t = mysqli_fetch_assoc($topics)) echo "<option value='{$t['name']}'>{$t['name']}</option>"; ?>
            </select>
        </div>

        <!-- Quiz Card -->
        <div class="glass-card" data-aos="fade-left" data-aos-delay="400">
            <div class="card-title"><i class="fas fa-question-circle" style="color: #eab308;"></i> Daily AI Quiz</div>
            <div id="quizContainer">
                <div class="quiz-question">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span style="background: #8b5cf6; padding: 4px 10px; border-radius: 20px; font-size: 11px;"><i class="fas fa-tag"></i> Algorithms</span>
                        <span style="font-size: 11px; color: #9ca3af;"><i class="fas fa-database"></i> GATE 2026 Pattern</span>
                    </div>
                    <p style="font-size: 16px; margin-bottom: 15px;"><strong>📝 What is the time complexity of Binary Search?</strong></p>
                    <div>
                        <div class="quiz-option" onclick="demoAnswer(0, 1)"><strong>A.</strong> O(n)</div>
                        <div class="quiz-option" onclick="demoAnswer(1, 1)"><strong>B.</strong> O(log n)</div>
                        <div class="quiz-option" onclick="demoAnswer(2, 1)"><strong>C.</strong> O(n²)</div>
                        <div class="quiz-option" onclick="demoAnswer(3, 1)"><strong>D.</strong> O(1)</div>
                    </div>
                    <div id="quizFeedback"></div>
                </div>
                <button onclick="loadNextDemoQuestion()" style="margin-top: 15px; background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; padding: 8px 15px; border-radius: 10px; color: white; cursor: pointer; width: 100%; transition: 0.3s;">
                    <i class="fas fa-sync-alt"></i> Next Question
                </button>
            </div>
        </div>
    </div>

    <div class="two-columns">
        <!-- AI Schedule -->
        <div class="glass-card" data-aos="fade-right" data-aos-delay="500">
            <div class="card-title"><i class="fas fa-robot" style="color: #a855f7;"></i> AI Study Schedule</div>
            <div style="overflow-x: auto;">
                <table class="schedule-table">
                    <thead>
                        <tr><th>Topic</th><th>Total Hrs</th><th>Daily Hrs</th><th>Priority</th><th></th></tr>
                    </thead>
                    <tbody id="scheduleBody">
                        <tr><td>Algorithms</td><td>45h</td><td>2.5h</td><td style="color:#ef4444;">25%</td><td><button onclick="studyTopic('Algorithms')" class="focus-btn" style="padding: 4px 12px;">Study</button></td></tr>
                        <tr><td>Data Structures</td><td>40h</td><td>2.2h</td><td style="color:#ef4444;">22%</td><td><button onclick="studyTopic('Data Structures')" class="focus-btn" style="padding: 4px 12px;">Study</button></td></tr>
                        <tr><td>Operating Systems</td><td>35h</td><td>1.9h</td><td style="color:#f97316;">18%</td><td><button onclick="studyTopic('Operating Systems')" class="focus-btn" style="padding: 4px 12px;">Study</button></td></tr>
                        <tr><td>DBMS</td><td>30h</td><td>1.6h</td><td style="color:#eab308;">15%</td><td><button onclick="studyTopic('DBMS')" class="focus-btn" style="padding: 4px 12px;">Study</button></td></tr>
                        <tr><td>Computer Networks</td><td>25h</td><td>1.4h</td><td style="color:#eab308;">12%</td><td><button onclick="studyTopic('Computer Networks')" class="focus-btn" style="padding: 4px 12px;">Study</button></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weak Areas -->
        <div class="glass-card" data-aos="fade-left" data-aos-delay="500">
            <div class="card-title"><i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> Weak Areas</div>
            <div id="weakContent">
                <div class="weak-topic"><span><i class="fas fa-fire" style="color:#ef4444;"></i> Algorithms (Need Practice)</span><button onclick="studyTopic('Algorithms')" class="focus-btn">Focus Now</button></div>
                <div class="weak-topic"><span><i class="fas fa-chart-line" style="color:#eab308;"></i> Operating Systems (Average)</span><button onclick="studyTopic('Operating Systems')" class="focus-btn">Focus Now</button></div>
                <div class="weak-topic"><span><i class="fas fa-rocket" style="color:#22c55e;"></i> Computer Networks (Improving)</span><button onclick="studyTopic('Computer Networks')" class="focus-btn">Focus Now</button></div>
            </div>
            <div class="recommendation-card">
                <i class="fas fa-lightbulb" style="color:#eab308;"></i> 🎯 Priority: Master Algorithms first, then focus on OS. Daily 2 hours practice recommended!
            </div>
        </div>
    </div>

    <!-- Subject Performance Chart -->
    <div class="glass-card" data-aos="fade-up" data-aos-delay="600">
        <div class="card-title"><i class="fas fa-chart-pie" style="color: #3b82f6;"></i> Subject-wise Performance</div>
        <canvas id="subjectChart" height="80"></canvas>
    </div>

    <!-- Footer -->
    <div class="dashboard-footer" data-aos="fade-up" data-aos-delay="700">
        <p><i class="fas fa-heart" style="color: #ef4444;"></i> Keep pushing forward! Every hour of study brings you closer to your GATE dream.</p>
        <div style="margin-top: 15px;">
            <a href="index.php" style="color: #a855f7; text-decoration: none; margin: 0 10px;"> Home</a>
            <a href="profile.php" style="color: #a855f7; text-decoration: none; margin: 0 10px;"> Profile</a>
            <a href="about.php" style="color: #a855f7; text-decoration: none; margin: 0 10px;"> About</a>
            <a href="contact.php" style="color: #a855f7; text-decoration: none; margin: 0 10px;"> Contact</a>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="studyToast" class="toast-notification"><i class="fas fa-check-circle"></i> Study session logged! 🔥</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true, offset: 100 });

// Particles
function createParticles() {
    const container = document.getElementById('particles');
    for (let i = 0; i < 50; i++) {
        const p = document.createElement('div');
        p.classList.add('particle');
        const size = Math.random() * 5 + 2;
        p.style.width = size + 'px';
        p.style.height = size + 'px';
        p.style.left = Math.random() * 100 + '%';
        p.style.animationDuration = Math.random() * 20 + 10 + 's';
        p.style.animationDelay = Math.random() * 10 + 's';
        container.appendChild(p);
    }
}
createParticles();

// Navbar scroll
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
});

// Demo Questions
let demoQuestions = [
    { topic: 'Algorithms', question: 'What is the time complexity of Binary Search?', options: ['O(n)', 'O(log n)', 'O(n²)', 'O(1)'], correct: 1, explanation: 'Binary Search divides search space in half each time, giving O(log n).' },
    { topic: 'Data Structures', question: 'Which data structure uses LIFO?', options: ['Queue', 'Stack', 'Array', 'Linked List'], correct: 1, explanation: 'Stack follows Last-In-First-Out.' },
    { topic: 'Operating Systems', question: 'What is a deadlock?', options: ['Processes waiting indefinitely', 'CPU overload', 'Memory full', 'Disk error'], correct: 0, explanation: 'Deadlock: processes waiting for resources held by each other.' },
    { topic: 'DBMS', question: 'What does SQL stand for?', options: ['Structured Query Language', 'Simple Query Language', 'System Query Language', 'Standard Query Language'], correct: 0, explanation: 'SQL = Structured Query Language.' },
    { topic: 'Computer Networks', question: 'What is the default port for HTTP?', options: ['21', '22', '80', '443'], correct: 2, explanation: 'HTTP uses port 80, HTTPS uses 443.' }
];

let currentIndex = 0;

function loadNextDemoQuestion() {
    currentIndex = (currentIndex + 1) % demoQuestions.length;
    let q = demoQuestions[currentIndex];
    let optionsHtml = '';
    q.options.forEach((opt, idx) => {
        let letter = String.fromCharCode(65 + idx);
        optionsHtml += `<div class="quiz-option" onclick="demoAnswer(${idx}, ${q.correct}, '${q.topic}', '${q.explanation.replace(/'/g, "\\'")}')"><strong>${letter}.</strong> ${opt}</div>`;
    });
    document.getElementById('quizContainer').innerHTML = `
        <div class="quiz-question">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <span style="background: #8b5cf6; padding: 4px 10px; border-radius: 20px; font-size: 11px;"><i class="fas fa-tag"></i> ${q.topic}</span>
                <span style="font-size: 11px; color: #9ca3af;"><i class="fas fa-database"></i> GATE 2026 Pattern</span>
            </div>
            <p style="font-size: 16px; margin-bottom: 15px;"><strong>📝 ${q.question}</strong></p>
            <div id="quizOptions">${optionsHtml}</div>
            <div id="quizFeedback"></div>
        </div>
        <button onclick="loadNextDemoQuestion()" style="margin-top: 15px; background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; padding: 8px 15px; border-radius: 10px; color: white; cursor: pointer; width: 100%;">
            <i class="fas fa-sync-alt"></i> Next Question
        </button>
    `;
}

window.demoAnswer = (selected, correct, topic, explanation) => {
    const feedback = document.getElementById('quizFeedback');
    const options = document.querySelectorAll('.quiz-option');
    options.forEach(opt => { opt.style.pointerEvents = 'none'; opt.style.opacity = '0.7'; });
    if (selected === correct) {
        feedback.innerHTML = `<div class="quiz-result quiz-correct" style="margin-top: 15px; background: rgba(34,197,94,0.2); padding: 10px; border-radius: 10px;"><i class="fas fa-check-circle"></i> ✅ Correct! <div style="font-size: 12px; margin-top: 5px; color: #9ca3af;">${explanation}</div></div>`;
        options[correct].style.background = 'rgba(34,197,94,0.3)';
    } else {
        feedback.innerHTML = `<div class="quiz-result quiz-wrong" style="margin-top: 15px; background: rgba(239,68,68,0.2); padding: 10px; border-radius: 10px;"><i class="fas fa-times-circle"></i> ❌ Incorrect! <div style="margin-top: 5px;">Correct: <strong>${String.fromCharCode(65 + correct)}. ${options[correct].innerText.split('.')[1]}</strong></div><div style="font-size: 12px; margin-top: 5px;">📖 ${explanation}</div></div>`;
        options[selected].style.background = 'rgba(239,68,68,0.3)';
        options[correct].style.background = 'rgba(34,197,94,0.3)';
    }
    setTimeout(() => loadNextDemoQuestion(), 3000);
};

// Timer
let timeLeft = 25 * 60, timerInterval = null, isRunning = false;
const timerDisplay = document.getElementById('timerDisplay');
document.getElementById('startBtn').addEventListener('click', () => {
    if (isRunning) return;
    isRunning = true;
    timerInterval = setInterval(() => {
        if (timeLeft <= 1) {
            clearInterval(timerInterval); isRunning = false;
            alert('🎉 Session complete! +25 mins logged.');
            timeLeft = 25 * 60; timerDisplay.textContent = '25:00';
        } else {
            timeLeft--;
            let mins = Math.floor(timeLeft / 60), secs = timeLeft % 60;
            timerDisplay.textContent = `${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
        }
    }, 1000);
});
document.getElementById('pauseBtn').addEventListener('click', () => { if (timerInterval) { clearInterval(timerInterval); timerInterval = null; isRunning = false; } });
document.getElementById('resetBtn').addEventListener('click', () => { if (timerInterval) { clearInterval(timerInterval); timerInterval = null; } isRunning = false; timeLeft = 25 * 60; timerDisplay.textContent = '25:00'; });

window.studyTopic = (topic) => {
    document.getElementById('topicSelect').value = topic;
    document.getElementById('resetBtn').click();
    document.getElementById('startBtn').click();
    alert(`🎯 Focus on ${topic}! Timer started.`);
};

// Chart
new Chart(document.getElementById('subjectChart'), {
    type: 'bar',
    data: { labels: ['Algorithms', 'DS', 'OS', 'DBMS', 'Networks'], datasets: [{ label: 'Accuracy %', data: [65, 70, 55, 80, 60], backgroundColor: '#a855f7', borderRadius: 10 }] },
    options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { labels: { color: 'white' } } }, scales: { y: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } }, x: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } } } }
});
</script>
</body>
</html>