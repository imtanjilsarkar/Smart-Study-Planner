<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Success Stories</title>
    
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
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
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
        .stories-hero {
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

        .stories-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .stories-hero p {
            font-size: 1.2rem;
            color: #b0b0b0;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Stats Banner */
        .stats-banner {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.08));
            border-radius: 40px;
            padding: 40px;
            margin-bottom: 50px;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .stats-banner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Stories Grid */
        .stories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .story-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s ease;
        }

        .story-card:hover {
            transform: translateY(-8px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .story-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .story-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
        }

        .story-info h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .story-rank {
            color: #a855f7;
            font-size: 12px;
            font-weight: 600;
        }

        .story-badge {
            display: inline-block;
            background: rgba(139, 92, 246, 0.2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            margin-top: 5px;
        }

        .story-quote {
            font-style: italic;
            color: #d1d5db;
            line-height: 1.6;
            margin-bottom: 20px;
            position: relative;
        }

        .story-quote::before {
            content: '"';
            font-size: 3rem;
            position: absolute;
            top: -15px;
            left: -10px;
            opacity: 0.3;
            color: #a855f7;
        }

        .story-meta {
            display: flex;
            gap: 15px;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 15px;
        }

        /* Submit Story Section */
        .submit-story {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.05));
            border-radius: 32px;
            padding: 50px;
            text-align: center;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .submit-story h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .submit-story p {
            color: #b0b0b0;
            margin-bottom: 25px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            padding: 12px 30px;
            border-radius: 40px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
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

        .footer-section p, .footer-section a {
            color: #b0b0b0;
            line-height: 1.8;
            font-size: 13px;
            text-decoration: none;
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
            .stories-hero h1 { font-size: 2rem; }
            .stories-grid { grid-template-columns: 1fr; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
            .submit-story { padding: 30px 20px; }
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
        <a href="about.php">About</a>
        <a href="success-stories.php" style="color: #a855f7;">Success Stories</a>
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
    <div class="stories-hero" data-aos="fade-up">
        <div class="hero-badge">
            <i class="fas fa-star"></i> Real Success Stories
        </div>
        <h1>From Dreamers to Achievers</h1>
        <p>Meet the students who transformed their GATE dreams into reality with SmartStudy AI</p>
    </div>

    <!-- Stats Banner -->
    <div class="stats-banner" data-aos="fade-up" data-aos-delay="100">
        <div class="stats-banner-grid">
            <div>
                <div class="stat-number">10,000+</div>
                <div style="font-size: 13px; color: #9ca3af;">Students Trained</div>
            </div>
            <div>
                <div class="stat-number">95%</div>
                <div style="font-size: 13px; color: #9ca3af;">Success Rate</div>
            </div>
            <div>
                <div class="stat-number">200+</div>
                <div style="font-size: 13px; color: #9ca3af;">Top 1000 Ranks</div>
            </div>
            <div>
                <div class="stat-number">50+</div>
                <div style="font-size: 13px; color: #9ca3af;">AIR Under 100</div>
            </div>
        </div>
    </div>

    <!-- Success Stories Grid -->
    <div class="stories-grid">
        <!-- Story 1 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="150">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="story-info">
                    <h3>Priya Sharma</h3>
                    <div class="story-rank">🏆 GATE AIR 47 (CSE)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Bombay, 2025</div>
                </div>
            </div>
            <div class="story-quote">
                SmartStudy AI completely changed my preparation strategy. The AI-powered schedule helped me focus on my weak areas, and the daily quizzes kept me on track. I went from scoring 45 marks in mocks to 82 in the actual exam!
            </div>
            <div class="story-meta">
                <span><i class="fas fa-clock"></i> 6 months of preparation</span>
                <span><i class="fas fa-chart-line"></i> +37 marks improvement</span>
            </div>
        </div>

        <!-- Story 2 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="200">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="story-info">
                    <h3>Rahul Verma</h3>
                    <div class="story-rank">🏆 GATE AIR 112 (ME)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Delhi, 2025</div>
                </div>
            </div>
            <div class="story-quote">
                Working professional with limited time, SmartStudy AI was a game-changer. The Pomodoro timer and weak topic detection helped me maximize my study efficiency. I could study just 3 hours daily but still cracked GATE with a top rank!
            </div>
            <div class="story-meta">
                <span><i class="fas fa-briefcase"></i> Working Professional</span>
                <span><i class="fas fa-fire"></i> 3 hours/day</span>
            </div>
        </div>

        <!-- Story 3 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="250">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-astronaut"></i>
                </div>
                <div class="story-info">
                    <h3>Anjali Patel</h3>
                    <div class="story-rank">🏆 GATE AIR 203 (ECE)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Madras, 2025</div>
                </div>
            </div>
            <div class="story-quote">
                The AI quiz system helped me identify my weak topics in Digital Logic and Networks. The personalized recommendations and progress tracking kept me motivated throughout my 8-month journey. Thank you SmartStudy AI!
            </div>
            <div class="story-meta">
                <span><i class="fas fa-graduation-cap"></i> First Attempt</span>
                <span><i class="fas fa-star"></i> 92% in mocks</span>
            </div>
        </div>

        <!-- Story 4 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="300">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-ninja"></i>
                </div>
                <div class="story-info">
                    <h3>Vikram Singh</h3>
                    <div class="story-rank">🏆 GATE AIR 89 (CS)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Kanpur, 2025</div>
                </div>
            </div>
            <div class="story-quote">
                The study streak feature kept me consistent for 200+ days! The AI schedule adapts as you progress, and the detailed analytics helped me understand exactly where I needed improvement. Best decision I made for GATE prep.
            </div>
            <div class="story-meta">
                <span><i class="fas fa-fire"></i> 200+ day streak</span>
                <span><i class="fas fa-trophy"></i> Top 100</span>
            </div>
        </div>

        <!-- Story 5 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="350">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="story-info">
                    <h3>Neha Gupta</h3>
                    <div class="story-rank">🏆 GATE AIR 456 (EE)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Roorkee, 2025</div>
                </div>
            </div>
            <div class="story-quote">
                SmartStudy AI's question bank is amazing! 200+ quality questions with detailed explanations. The weak topic detection helped me improve from 55% to 85% accuracy in just 3 months. Highly recommended for every GATE aspirant!
            </div>
            <div class="story-meta">
                <span><i class="fas fa-chart-line"></i> 30% improvement</span>
                <span><i class="fas fa-brain"></i> AI Recommendations</span>
            </div>
        </div>

        <!-- Story 6 -->
        <div class="story-card" data-aos="fade-up" data-aos-delay="400">
            <div class="story-header">
                <div class="story-avatar">
                    <i class="fas fa-user-astronaut"></i>
                </div>
                <div class="story-info">
                    <h3>Karthik S</h3>
                    <div class="story-rank">🏆 GATE AIR 78 (CSE)</div>
                    <div class="story-badge"><i class="fas fa-calendar"></i> IIT Bombay, 2026</div>
                </div>
            </div>
            <div class="story-quote">
                The AI score prediction was surprisingly accurate! It predicted 82 marks, and I scored 79. The daily quiz system with topic-wise analysis helped me track my progress perfectly. A must-have tool for serious aspirants!
            </div>
            <div class="story-meta">
                <span><i class="fas fa-robot"></i> 95% prediction accuracy</span>
                <span><i class="fas fa-chart-simple"></i> 200+ quizzes</span>
            </div>
        </div>
    </div>

    <!-- Submit Your Story Section -->
    <div class="submit-story" data-aos="fade-up" data-aos-delay="450">
        <h2>📢 Have a Success Story to Share?</h2>
        <p>Your journey could inspire thousands of GATE aspirants. Share your story with us!</p>
        <a href="contact.php" class="submit-btn">
            <i class="fas fa-pen-fancy"></i> Share Your Story
        </a>
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
            <a href="#"> GATE Syllabus</a>
            <a href="#"> Previous Papers</a>
            <a href="#"> Study Tips</a>
            <a href="#"> Rank Predictor</a>
            <a href="success-stories.php"> Success Stories</a>
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

    // Navbar scroll
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });
</script>
</body>
</html>