<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once __DIR__ . "/database/connection.php";

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));

// Update profile
$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $daily_hours = (int)$_POST['daily_hours'];
    $exam_date = mysqli_real_escape_string($conn, $_POST['exam_date']);
    
    $update = "UPDATE users SET name='$name', daily_hours=$daily_hours, exam_date='$exam_date' WHERE id=$user_id";
    if(mysqli_query($conn, $update)) {
        $_SESSION['user_name'] = $name;
        $success = "Profile updated successfully!";
        // Refresh user data
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}

// Get additional stats
$total_quizzes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM quiz_history WHERE user_id=$user_id"))['count'] ?? 0;
$avg_accuracy = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(correct/total)*100 as accuracy FROM quiz_history WHERE user_id=$user_id"))['accuracy'] ?? 0;
$total_topics_completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM user_progress WHERE user_id=$user_id AND status='completed'"))['count'] ?? 0;
$total_topics = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM topics"))['count'] ?? 10;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Profile</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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
            gap: 25px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #e0e0e0;
            font-weight: 500;
            transition: 0.3s;
            font-size: 14px;
            position: relative;
        }

        .nav-links a:hover {
            color: #a855f7;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #a855f7, #3b82f6);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
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

        .btn-logout::after {
            display: none;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 40px 60px;
        }

        /* Profile Card */
        .profile-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Avatar Section */
        .avatar-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 3rem;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.3);
        }

        .avatar-name {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .avatar-email {
            font-size: 13px;
            color: #9ca3af;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #d1d5db;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }

        .input-group input:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: 0.3s;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.3);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 5px;
        }

        /* Progress Bar */
        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #a855f7, #3b82f6);
            border-radius: 3px;
            transition: width 0.3s;
        }

        /* Buttons */
        .update-btn {
            width: 100%;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border: none;
            padding: 14px;
            border-radius: 40px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .update-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        }

        /* Messages */
        .success-message {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #22c55e;
            font-size: 13px;
        }

        .error-message {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ef4444;
            font-size: 13px;
        }

        /* Toast */
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        /* Footer */
        .profile-footer {
            margin-top: 30px;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 768px) {
            .container { padding: 80px 20px 40px; }
            .profile-card { padding: 25px; }
            .stats-grid { grid-template-columns: 1fr; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
            .avatar { width: 80px; height: 80px; font-size: 2.5rem; }
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
        <a href="profile.php" style="color: #a855f7;"><i class="fas fa-user"></i> Profile</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="container">
    <div class="profile-card" data-aos="fade-up">
        <!-- Avatar Section -->
        <div class="avatar-section">
            <div class="avatar">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="avatar-name"><?php echo htmlspecialchars($user['name']); ?></div>
            <div class="avatar-email"><?php echo htmlspecialchars($user['email']); ?></div>
        </div>

        <?php if(isset($success)): ?>
            <div class="success-message" data-aos="fade-up">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="error-message" data-aos="fade-up">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Stats Section -->
        <h3 style="margin: 20px 0 15px; font-size: 1.2rem;"><i class="fas fa-chart-line" style="color: #a855f7;"></i> Your Performance</h3>
        
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value"><?php echo floor($user['total_study_hours'] / 60); ?>h <?php echo $user['total_study_hours'] % 60; ?>m</div>
                <div class="stat-label">Total Study Hours</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo $total_quizzes; ?></div>
                <div class="stat-label">Quizzes Taken</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo round($avg_accuracy, 1); ?>%</div>
                <div class="stat-label">Average Accuracy</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo $avg_accuracy; ?>%"></div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><?php echo $total_topics_completed; ?>/<?php echo $total_topics; ?></div>
                <div class="stat-label">Topics Completed</div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo ($total_topics_completed / $total_topics) * 100; ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Update Form -->
        <h3 style="margin: 20px 0 15px; font-size: 1.2rem;"><i class="fas fa-user-edit" style="color: #3b82f6;"></i> Edit Profile</h3>
        
        <form method="POST" action="" id="profileForm">
            <div class="form-group">
                <label>Full Name</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>
            </div>
            
            <div class="form-group">
                <label>Daily Study Hours</label>
                <div class="input-group">
                    <i class="fas fa-hourglass-half"></i>
                    <select name="daily_hours">
                        <option value="2" <?php echo $user['daily_hours'] == 2 ? 'selected' : ''; ?>>2 hours/day</option>
                        <option value="4" <?php echo $user['daily_hours'] == 4 ? 'selected' : ''; ?>>4 hours/day</option>
                        <option value="6" <?php echo $user['daily_hours'] == 6 ? 'selected' : ''; ?>>6 hours/day</option>
                        <option value="8" <?php echo $user['daily_hours'] == 8 ? 'selected' : ''; ?>>8 hours/day</option>
                        <option value="10" <?php echo $user['daily_hours'] == 10 ? 'selected' : ''; ?>>10 hours/day</option>
                        <option value="12" <?php echo $user['daily_hours'] == 12 ? 'selected' : ''; ?>>12 hours/day</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>GATE Exam Date</label>
                <div class="input-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" name="exam_date" value="<?php echo $user['exam_date']; ?>" required>
                </div>
            </div>
            
            <button type="submit" class="update-btn">
                <i class="fas fa-save"></i> Update Profile
            </button>
        </form>

        <!-- Account Info -->
        <div class="profile-footer">
            <p><i class="fas fa-calendar-check"></i> Member since <?php echo date('F d, Y', strtotime($user['created_at'])); ?></p>
            <p style="font-size: 12px; color: #6b7280; margin-top: 8px;">
                <i class="fas fa-shield-alt"></i> Your data is secure and private
            </p>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="profileToast" class="toast-notification">
    <i class="fas fa-check-circle"></i> Profile updated successfully!
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 100 });

    // Create particles
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

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });

    // Show toast on form submit
    const profileForm = document.getElementById('profileForm');
    const toast = document.getElementById('profileToast');

    profileForm.addEventListener('submit', function(e) {
        // Don't prevent default - let form submit normally
        // But show toast if PHP success message appears
        setTimeout(() => {
            if(document.querySelector('.success-message')) {
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3000);
            }
        }, 500);
    });

    // Input focus effects
    const inputs = document.querySelectorAll('.input-group input, .input-group select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.borderColor = '#a855f7';
        });
        input.addEventListener('blur', function() {
            this.parentElement.style.borderColor = 'rgba(255,255,255,0.1)';
        });
    });
</script>
</body>
</html>