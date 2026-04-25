<?php
session_start();
include_once __DIR__ . "/database/connection.php";

$error = '';

// Check if connection exists
if(!isset($conn) || !$conn) {
    die("Database connection failed. Please check your database configuration.");
}

// Handle login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Login</title>
    
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
            min-height: 100vh;
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

        /* Glass Navbar */
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
        }

        .nav-links a:hover {
            color: #a855f7;
        }

        /* Container */
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 80px;
        }

        /* Login Card */
        .login-card {
            max-width: 450px;
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #9ca3af;
            font-size: 14px;
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

        .input-group input {
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

        .input-group input:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }

        /* Login Button */
        .login-btn {
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

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        }

        /* Demo Buttons Section */
        .demo-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .demo-title {
            font-size: 13px;
            color: #9ca3af;
            text-align: center;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .demo-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .demo-btn {
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            padding: 12px 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: 0.3s;
        }

        .demo-btn:hover {
            background: rgba(139, 92, 246, 0.25);
            transform: translateX(5px);
            border-color: rgba(139, 92, 246, 0.5);
        }

        .demo-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .demo-email {
            font-size: 13px;
            font-weight: 500;
            color: white;
        }

        .demo-pass {
            font-size: 11px;
            color: #9ca3af;
        }

        .demo-icon {
            color: #a855f7;
            font-size: 18px;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #9ca3af;
        }

        .register-link a {
            color: #a855f7;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Error Message */
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

        @media (max-width: 768px) {
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
            .login-card { padding: 30px 20px; margin: 0 15px; }
            .login-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<div class="gradient-bg"></div>
<div class="noise-bg"></div>
<div class="particles" id="particles"></div>

<!-- Glass Navbar -->
<nav class="glass-nav">
    <div class="logo">
        <i class="fas fa-brain"></i> SmartStudy<span style="color: #a855f7;">AI</span>
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="register.php" style="background: rgba(59,130,246,0.2); padding: 8px 20px; border-radius: 40px;">Register</a>
    </div>
</nav>

<div class="container">
    <div class="login-card" data-aos="fade-up" data-aos-duration="800">
        <div class="login-header">
            <h1>Welcome Back! 👋</h1>
            <p>Login to continue your GATE preparation journey</p>
        </div>

        <?php if($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="loginForm">
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <!-- Demo Login Section -->
        <div class="demo-section">
            <div class="demo-title">
                <i class="fas fa-flask"></i> Demo Accounts (Click to Login)
                <i class="fas fa-mouse-pointer"></i>
            </div>
            <div class="demo-buttons">
                <!-- Demo Account 1 -->
                <div class="demo-btn" onclick="fillDemoLogin('tanjilsarkar2@gmail.com', '123456')">
                    <div class="demo-info">
                        <span class="demo-email"><i class="fas fa-user-circle"></i> tanjilsarkar2@gmail.com</span>
                        <span class="demo-pass">🔑 Password: 123456</span>
                    </div>
                    <div class="demo-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Demo Account 2 -->
                <div class="demo-btn" onclick="fillDemoLogin('test1@example.com', '123456')">
                    <div class="demo-info">
                        <span class="demo-email"><i class="fas fa-user-circle"></i> test1@example.com</span>
                        <span class="demo-pass">🔑 Password: 123456</span>
                    </div>
                    <div class="demo-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Demo Account 3 -->
                <div class="demo-btn" onclick="fillDemoLogin('test2@example.com', '123456')">
                    <div class="demo-info">
                        <span class="demo-email"><i class="fas fa-user-circle"></i> test2@example.com</span>
                        <span class="demo-pass">🔑 Password: 123456</span>
                    </div>
                    <div class="demo-icon">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-link">
            Don't have an account? <a href="register.php">Create Account →</a>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="loginToast" class="toast-notification">
    <i class="fas fa-spinner fa-spin"></i> Logging in...
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });

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

    // Demo Login Function
    function fillDemoLogin(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        
        // Show toast notification
        const toast = document.getElementById('loginToast');
        toast.innerHTML = '<i class="fas fa-check-circle"></i> Demo account loaded! Click Login to continue.';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
        
        // Optional: Auto-submit form (uncomment if you want auto-login)
        // document.getElementById('loginForm').submit();
    }

    // Add floating label effect
    const inputs = document.querySelectorAll('.input-group input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.borderColor = '#a855f7';
        });
        input.addEventListener('blur', function() {
            this.parentElement.style.borderColor = 'rgba(255,255,255,0.1)';
        });
    });

    // Form submit loading state
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.querySelector('.login-btn');
    
    loginForm.addEventListener('submit', function(e) {
        const toast = document.getElementById('loginToast');
        toast.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        toast.classList.add('show');
        // Keep toast visible during redirect
        setTimeout(() => toast.classList.remove('show'), 2000);
    });
</script>
</body>
</html>