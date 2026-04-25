<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | About Us</title>
    
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

        .btn-gradient {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            padding: 8px 24px;
            border-radius: 40px;
            color: white !important;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        }

        .btn-gradient::after {
            display: none;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 40px 60px;
        }

        /* Hero Section */
        .about-hero {
            text-align: center;
            margin-bottom: 60px;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(139, 92, 246, 0.2);
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid rgba(139, 92, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .about-hero p {
            font-size: 1.2rem;
            color: #b0b0b0;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(139, 92, 246, 0.2);
        }

        /* Mission Card */
        .mission-card {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.08));
            border: 1px solid rgba(139, 92, 246, 0.2);
            margin-bottom: 40px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin: 50px 0;
        }

        .stat-item {
            text-align: center;
            padding: 25px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: block;
        }

        .stat-label {
            color: #9ca3af;
            margin-top: 8px;
            font-size: 14px;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin: 40px 0;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 12px;
        }

        .feature-card p {
            color: #b0b0b0;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .team-card {
            text-align: center;
            padding: 25px;
        }

        .team-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
        }

        .team-card h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .team-role {
            color: #a855f7;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .team-bio {
            color: #9ca3af;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Timeline */
        .timeline {
            margin: 50px 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, #a855f7, #3b82f6);
        }

        .timeline-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .timeline-date {
            width: 45%;
            text-align: right;
            padding-right: 30px;
            font-weight: 700;
            color: #a855f7;
        }

        .timeline-content {
            width: 45%;
            padding-left: 30px;
            background: rgba(255, 255, 255, 0.03);
            padding: 15px 20px;
            border-radius: 16px;
            border-left: 3px solid #a855f7;
        }

        .timeline-content h4 {
            margin-bottom: 5px;
        }

        .timeline-content p {
            color: #9ca3af;
            font-size: 13px;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.08));
            border-radius: 40px;
            margin-top: 50px;
            padding: 50px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .cta-section h2 {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .cta-section p {
            color: #b0b0b0;
            margin-bottom: 25px;
        }

        /* Footer */
        .footer {
            background: #050505;
            padding: 50px 10% 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 60px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 1.1rem;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .footer-section p {
            color: #b0b0b0;
            line-height: 1.8;
            font-size: 13px;
        }

        .footer-section a {
            color: #b0b0b0;
            text-decoration: none;
            transition: 0.3s;
            font-size: 13px;
            display: block;
            margin-bottom: 8px;
        }

        .footer-section a:hover {
            color: #a855f7;
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        .social-links a {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .social-links a:hover {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            color: #b0b0b0;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .container { padding: 80px 20px 40px; }
            .about-hero h1 { font-size: 2.2rem; }
            .timeline::before { left: 20px; }
            .timeline-item { flex-direction: column; }
            .timeline-date { width: 100%; text-align: left; padding-left: 40px; margin-bottom: 10px; }
            .timeline-content { width: 100%; margin-left: 20px; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
            .cta-section { padding: 30px 20px; }
            .cta-section h2 { font-size: 1.5rem; }
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
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="about.php" style="color: #a855f7;">About</a>
        <a href="contact.php">Contact</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="btn-gradient">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-gradient">Login</a>
            <a href="register.php" style="background: rgba(59,130,246,0.2); padding: 8px 20px; border-radius: 40px;">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <!-- Hero Section -->
    <div class="about-hero" data-aos="fade-up">
        <div class="hero-badge">
            <i class="fas fa-brain"></i> Who We Are
        </div>
        <h1>Redefining GATE Preparation<br>with Artificial Intelligence</h1>
        <p>SmartStudy AI is on a mission to make quality GATE preparation accessible, personalized, and effective for every aspirant across India.</p>
    </div>

    <!-- Mission Card -->
    <div class="glass-card mission-card" data-aos="fade-up" data-aos-delay="100">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <i class="fas fa-quote-left" style="font-size: 2rem; color: #a855f7;"></i>
            <h2 style="font-size: 1.5rem;">Our Mission</h2>
        </div>
        <p style="color: #b0b0b0; line-height: 1.8; font-size: 1.05rem;">
            Smart Study Planner uses Artificial Intelligence to help GATE aspirants optimize their study schedule, 
            identify weak areas, and maximize their exam scores. We combine proven learning techniques with cutting-edge 
            technology to make GATE preparation smarter and more effective. Our AI algorithms analyze thousands of data points 
            to create personalized study plans that adapt to your learning pace.
        </p>
    </div>

    <!-- Stats Section -->
    <div class="stats-grid" data-aos="fade-up" data-aos-delay="150">
        <div class="glass-card stat-item">
            <span class="stat-number">10,000+</span>
            <span class="stat-label">Active Students</span>
        </div>
        <div class="glass-card stat-item">
            <span class="stat-number">200+</span>
            <span class="stat-label">Practice Questions</span>
        </div>
        <div class="glass-card stat-item">
            <span class="stat-number">95%</span>
            <span class="stat-label">Success Rate</span>
        </div>
        <div class="glass-card stat-item">
            <span class="stat-number">24/7</span>
            <span class="stat-label">AI Support</span>
        </div>
    </div>

    <!-- Features Section -->
    <h2 class="text-center" style="font-size: 2rem; margin: 40px 0 20px; background: linear-gradient(135deg, #fff, #a855f7); -webkit-background-clip: text; background-clip: text; color: transparent;" data-aos="fade-up">What Makes Us Different</h2>
    
    <div class="features-grid">
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-icon"><i class="fas fa-robot" style="color: #a855f7;"></i></div>
            <h3>AI-Powered Scheduling</h3>
            <p>Our AI algorithm creates personalized study plans based on your strengths, weaknesses, and available time using machine learning models.</p>
        </div>
        
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="150">
            <div class="feature-icon"><i class="fas fa-chart-line" style="color: #3b82f6;"></i></div>
            <h3>Performance Analytics</h3>
            <p>Track your progress with detailed analytics, visualize your improvement, and get accurate GATE score predictions.</p>
        </div>
        
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-icon"><i class="fas fa-hourglass-half" style="color: #22c55e;"></i></div>
            <h3>Pomodoro Timer</h3>
            <p>Stay focused with our built-in study timer that follows the proven Pomodoro technique for maximum productivity.</p>
        </div>
        
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="250">
            <div class="feature-icon"><i class="fas fa-brain" style="color: #eab308;"></i></div>
            <h3>Weak Topic Detection</h3>
            <p>AI analyzes your quiz performance to identify topics that need more attention and suggests focused practice.</p>
        </div>
        
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-icon"><i class="fas fa-database" style="color: #ec4899;"></i></div>
            <h3>Smart Question Bank</h3>
            <p>Access 200+ GATE pattern questions with detailed explanations, organized by topic and difficulty level.</p>
        </div>
        
        <div class="glass-card feature-card" data-aos="fade-up" data-aos-delay="350">
            <div class="feature-icon"><i class="fas fa-trophy" style="color: #f59e0b;"></i></div>
            <h3>Gamification</h3>
            <p>Earn achievements, maintain study streaks, and stay motivated with our gamified learning experience.</p>
        </div>
    </div>

    <!-- Timeline Section -->
    <h2 class="text-center" style="font-size: 2rem; margin: 50px 0 20px; background: linear-gradient(135deg, #fff, #a855f7); -webkit-background-clip: text; background-clip: text; color: transparent;" data-aos="fade-up">Our Journey</h2>
    
    <div class="timeline" data-aos="fade-up" data-aos-delay="100">
        <div class="timeline-item">
            <div class="timeline-date">2024</div>
            <div class="timeline-content">
                <h4>💡 The Idea Was Born</h4>
                <p>Started as a vision to democratize GATE preparation using AI technology.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">2025</div>
            <div class="timeline-content">
                <h4>🚀 Beta Launch</h4>
                <p>First version launched with 100+ beta testers across India.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">2026</div>
            <div class="timeline-content">
                <h4>🏆 Full Release</h4>
                <p>Official launch with AI-powered features and 10,000+ active users.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">2027</div>
            <div class="timeline-content">
                <h4>🌟 The Future</h4>
                <p>Expanding to more exams and adding advanced AI features.</p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <h2 class="text-center" style="font-size: 2rem; margin: 50px 0 20px; background: linear-gradient(135deg, #fff, #a855f7); -webkit-background-clip: text; background-clip: text; color: transparent;" data-aos="fade-up">Meet Our Team</h2>
    
    <div class="team-grid">
        <div class="glass-card team-card" data-aos="fade-up" data-aos-delay="100">
            <div class="team-avatar"><i class="fas fa-user-tie"></i></div>
            <h4>Dr. Aditya Sharma</h4>
            <div class="team-role">Founder & AI Lead</div>
            <div class="team-bio">Former GATE AIR 45, PhD in Machine Learning from IIT Bombay.</div>
        </div>
        <div class="glass-card team-card" data-aos="fade-up" data-aos-delay="150">
            <div class="team-avatar"><i class="fas fa-chalkboard-user"></i></div>
            <h4>Prof. Neha Gupta</h4>
            <div class="team-role">Education Director</div>
            <div class="team-bio">15+ years of GATE coaching experience, taught 10,000+ students.</div>
        </div>
        <div class="glass-card team-card" data-aos="fade-up" data-aos-delay="200">
            <div class="team-avatar"><i class="fas fa-laptop-code"></i></div>
            <h4>Rahul Verma</h4>
            <div class="team-role">Lead Developer</div>
            <div class="team-bio">Full-stack developer passionate about ed-tech solutions.</div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section" data-aos="fade-up" data-aos-delay="200">
        <h2>Ready to Start Your GATE Journey?</h2>
        <p>Join thousands of students who achieved their dreams with SmartStudy AI</p>
        <div class="btn-group" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="register.php" style="background: linear-gradient(135deg, #a855f7, #3b82f6); padding: 12px 30px; border-radius: 40px; color: white; text-decoration: none; font-weight: 600; transition: 0.3s;">
                🚀 Get Started Free
            </a>
            <a href="contact.php" style="background: rgba(255,255,255,0.1); padding: 12px 30px; border-radius: 40px; color: white; text-decoration: none; font-weight: 600; transition: 0.3s;">
                📞 Contact Us
            </a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3><i class="fas fa-brain"></i> SmartStudy AI</h3>
            <p>Revolutionizing GATE preparation with artificial intelligence. Smart planning, smarter results.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="index.php"> Home</a>
            <a href="dashboard.php"> Dashboard</a>
            <a href="about.php"> About Us</a>
            <a href="contact.php"> Contact</a>
        </div>
        <div class="footer-section">
            <h3>Resources</h3>
            <a href="pdf-library.php"> GATE PDF Notes</a>
            <a href="#"> Previous Papers</a>
            <a href="#"> Study Tips</a>
            <a href=""> Success Stories</a>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p><i class="fas fa-envelope"></i> support@smartstudy.ai</p>
            <p><i class="fas fa-phone"></i> +880 12345 67890</p>
            <p><i class="fas fa-map-marker-alt"></i> Dhaka, Bangladesh</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 SmartStudy AI | Next-Gen GATE Preparation Platform | Version 3.0</p>
    </div>
</footer>

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
</script>
</body>
</html>