<?php
session_start();
include_once __DIR__ . "/database/connection.php";

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $exam_date = mysqli_real_escape_string($conn, $_POST['exam_date']);
    $daily_hours = (int)$_POST['daily_hours'];
    
    // Check if email exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0) {
        $error = "Email already registered!";
    } else {
        $query = "INSERT INTO users (name, email, password, exam_date, daily_hours) 
                  VALUES ('$name', '$email', '$password', '$exam_date', $daily_hours)";
        
        if(mysqli_query($conn, $query)) {
            $success = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
        }
        .gradient-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            z-index: -2;
            animation: bgPulse 8s ease-in-out infinite;
        }
        @keyframes bgPulse { 0%, 100% { opacity: 0.5; } 50% { opacity: 1; } }
        .noise-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
            z-index: -1;
        }
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
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a855f7, #3b82f6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .nav-links { display: flex; gap: 25px; align-items: center; }
        .nav-links a { text-decoration: none; color: #e0e0e0; font-weight: 500; font-size: 14px; }
        .nav-links a:hover { color: #a855f7; }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 80px;
        }
        .register-card {
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .register-header { text-align: center; margin-bottom: 30px; }
        .register-header h1 { font-size: 2rem; font-weight: 700; background: linear-gradient(135deg, #fff, #a855f7); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 13px; color: #d1d5db; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #6b7280; }
        .input-group input, .input-group select {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }
        .input-group input:focus, .input-group select:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }
        .register-btn {
            width: 100%;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border: none;
            padding: 14px;
            border-radius: 40px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }
        .register-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4); }
        .error-message { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 12px; margin-bottom: 20px; color: #ef4444; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .success-message { background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 12px; margin-bottom: 20px; color: #22c55e; font-size: 13px; }
        .login-link { text-align: center; margin-top: 25px; font-size: 13px; color: #9ca3af; }
        .login-link a { color: #a855f7; text-decoration: none; font-weight: 600; }
        @media (max-width: 768px) {
            .register-card { padding: 30px 20px; margin: 0 15px; }
            .register-header h1 { font-size: 1.5rem; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
        }
    </style>
</head>
<body>
<div class="gradient-bg"></div>
<div class="noise-bg"></div>

<nav class="glass-nav">
    <div class="logo"><i class="fas fa-brain"></i> SmartStudy<span style="color: #a855f7;">AI</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php" style="background: rgba(139,92,246,0.2); padding: 8px 20px; border-radius: 40px;">Login</a>
    </div>
</nav>

<div class="container">
    <div class="register-card" data-aos="fade-up">
        <div class="register-header">
            <h1>Create Account 🚀</h1>
        </div>
        
        <?php if($error): ?>
            <div class="error-message"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="success-message"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Full Name</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Create a password" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>GATE Exam Date</label>
                <div class="input-group">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="exam_date" required value="2026-02-10">
                </div>
            </div>
            
            <div class="form-group">
                <label>Daily Study Hours</label>
                <div class="input-group">
                    <i class="fas fa-hourglass-half"></i>
                    <select name="daily_hours">
                        <option value="2">2 hours/day</option>
                        <option value="4" selected>4 hours/day</option>
                        <option value="6">6 hours/day</option>
                        <option value="8">8 hours/day</option>
                        <option value="10">10 hours/day</option>
                        <option value="12">12 hours/day</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="register-btn"><i class="fas fa-user-plus"></i> Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login →</a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script> AOS.init({ duration: 800, once: true }); </script>
</body>
</html>