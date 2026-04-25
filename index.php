<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Next-Gen GATE Preparation 2026</title>
    
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
            padding: 16px 40px;
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
            background: rgba(10, 10, 10, 0.9);
            border-color: rgba(139, 92, 246, 0.3);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a855f7, #3b82f6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: logoGlow 3s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }

        .nav-links a {
            text-decoration: none;
            color: #e0e0e0;
            font-weight: 500;
            transition: 0.3s;
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
            padding: 10px 28px;
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

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10%;
            position: relative;
        }

        .hero-content {
            flex: 1;
            z-index: 2;
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
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(139, 92, 246, 0); }
        }

        .hero-content h1 {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #b0b0b0;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            color: white;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5);
        }

        .btn-outline {
            border: 2px solid #a855f7;
            color: white;
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(139, 92, 246, 0.1);
            transform: translateY(-3px);
            border-color: #3b82f6;
        }

        /* Stats Animation */
        .hero-stats {
            flex: 1;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .stat-circle {
            text-align: center;
        }

        .circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.05));
            border: 2px solid rgba(139, 92, 246, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
        }

        .circle::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), transparent);
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: #a855f7;
        }

        /* Features Section */
        .section {
            padding: 100px 10%;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 3rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #fff, #a855f7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .section-title p {
            color: #b0b0b0;
            font-size: 1.1rem;
        }

        /* Glass Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-10px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(139, 92, 246, 0.2);
        }

        .glass-card i {
            font-size: 3.5rem;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .glass-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .glass-card p {
            color: #b0b0b0;
            line-height: 1.6;
        }

        /* How It Works */
        .steps-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 auto 20px;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(59, 130, 246, 0.08));
            border-radius: 40px;
            margin: 40px 10%;
            padding: 60px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta-section p {
            color: #b0b0b0;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .footer {
            background: #050505;
            padding: 60px 10% 30px;
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
            font-size: 1.2rem;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .footer-section p {
            color: #b0b0b0;
            line-height: 1.8;
        }

        .footer-section a {
            color: #b0b0b0;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-section a:hover {
            color: #a855f7;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
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
        }

        /* Responsive */
        @media (max-width: 968px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 120px;
            }
            .hero-content h1 {
                font-size: 2.8rem;
            }
            .btn-group {
                justify-content: center;
            }
            .hero-stats {
                margin-top: 50px;
            }
            .glass-nav {
                padding: 12px 20px;
            }
            .nav-links {
                gap: 15px;
            }
            .nav-links a {
                font-size: 0.9rem;
            }
            .section {
                padding: 60px 20px;
            }
            .section-title h2 {
                font-size: 2rem;
            }
            .cta-section {
                margin: 40px 20px;
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="gradient-bg"></div>
<div class="noise-bg"></div>

<!-- Particles -->
<div class="particles" id="particles"></div>

<!-- Glass Navbar -->
<nav class="glass-nav" id="navbar">
    <div class="logo">
        <i class="fas fa-brain"></i> SmartStudy<span style="color: #a855f7;">AI</span>
    </div>
    <div class="nav-links" style="display: flex; gap: 30px; align-items: center;">
        <a href="index.php">Home</a>
        <a href="#features">Features</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="btn-gradient">Dashboard</a>
        <?php else: ?>
            <a href="login.php" class="btn-gradient">Login</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
        <div class="hero-badge">
            <i class="fas fa-robot"></i> AI-Powered GATE 2026
        </div>
        <h1>Smart Study,<br>Smarter Results</h1>
        <p>Revolutionize your GATE preparation with AI-driven personalized study plans, real-time progress tracking, and intelligent quiz systems. Join 10,000+ successful aspirants.</p>
        <div class="btn-group">
            <a href="register.php" class="btn btn-primary"><i class="fas fa-rocket"></i> Start Free Journey</a>
            <a href="#features" class="btn btn-outline"><i class="fas fa-play"></i> See How It Works</a>
        </div>
    </div>
    <div class="hero-stats" data-aos="fade-left" data-aos-duration="1000">
        <div class="stat-circle">
            <div class="circle">
                <span class="stat-number" id="stat1">10K+</span>
            </div>
            <p>Active Students</p>
        </div>
        <div class="stat-circle">
            <div class="circle">
                <span class="stat-number" id="stat2">95%</span>
            </div>
            <p>Success Rate</p>
        </div>
        <div class="stat-circle">
            <div class="circle">
                <span class="stat-number" id="stat3">200+</span>
            </div>
            <p>Practice Questions</p>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" id="features">
    <div class="section-title" data-aos="fade-up">
        <h2>Why Choose SmartStudy AI?</h2>
        <p>Experience the future of exam preparation with cutting-edge technology</p>
    </div>
    <div class="cards-grid">
        <div class="glass-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-robot"></i>
            <h3>AI-Powered Planning</h3>
            <p>Personalized study schedules using machine learning algorithms that adapt to your learning pace and weak areas.</p>
        </div>
        <div class="glass-card" data-aos="fade-up" data-aos-delay="200">
            <i class="fas fa-chart-line"></i>
            <h3>Smart Analytics</h3>
            <p>Track your progress with detailed insights, predict your GATE score, and identify improvement areas.</p>
        </div>
        <div class="glass-card" data-aos="fade-up" data-aos-delay="300">
            <i class="fas fa-hourglass-half"></i>
            <h3>Focus Timer</h3>
            <p>Pomodoro technique integrated with AI to optimize your study sessions and maintain peak productivity.</p>
        </div>
        <div class="glass-card" data-aos="fade-up" data-aos-delay="400">
            <i class="fas fa-database"></i>
            <h3>200+ Questions</h3>
            <p>Comprehensive GATE pattern question bank with detailed explanations and performance tracking.</p>
        </div>
        <div class="glass-card" data-aos="fade-up" data-aos-delay="500">
            <i class="fas fa-trophy"></i>
            <h3>Achievement Badges</h3>
            <p>Stay motivated with gamification elements and unlock achievements as you progress.</p>
        </div>
        <div class="glass-card" data-aos="fade-up" data-aos-delay="600">
            <i class="fas fa-mobile-alt"></i>
            <h3>Fully Responsive</h3>
            <p>Access your study plan anytime, anywhere on any device - desktop, tablet, or mobile.</p>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section" style="background: rgba(0,0,0,0.2);">
    <div class="section-title" data-aos="fade-up">
        <h2>How It Works</h2>
        <p>Simple steps to ace your GATE preparation</p>
    </div>
    <div class="steps-container">
        <div class="step" data-aos="fade-up" data-aos-delay="100">
            <div class="step-number">1</div>
            <h3>Sign Up Free</h3>
            <p>Create your account and set your GATE exam target date</p>
        </div>
        <div class="step" data-aos="fade-up" data-aos-delay="200">
            <div class="step-number">2</div>
            <h3>Take Assessment</h3>
            <p>AI analyzes your strengths and weaknesses</p>
        </div>
        <div class="step" data-aos="fade-up" data-aos-delay="300">
            <div class="step-number">3</div>
            <h3>Get Smart Plan</h3>
            <p>Receive personalized study schedule</p>
        </div>
        <div class="step" data-aos="fade-up" data-aos-delay="400">
            <div class="step-number">4</div>
            <h3>Track Progress</h3>
            <p>Monitor improvement and achieve your goal</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" data-aos="fade-up">
    <h2>Ready to Transform Your Preparation?</h2>
    <p>Join thousands of successful GATE aspirants who achieved their dreams with SmartStudy AI</p>
    <div class="btn-group" style="justify-content: center;">
        <a href="register.php" class="btn btn-primary"><i class="fas fa-hand-peace"></i> Start Your Journey Now</a>
        <a href="login.php" class="btn btn-outline"><i class="fas fa-sign-in-alt"></i> Already have an account?</a>
    </div>
</section>

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
            <p><a href="index.php">🏠 Home</a></p>
            <p><a href="#features">✨ Features</a></p>
            <p><a href="about.php">📖 About Us</a></p>
            <p><a href="contact.php">📞 Contact</a></p>
        </div>
        <div class="footer-section">
            <h3>Resources</h3>
            <p><a href="#">📚 GATE Syllabus</a></p>
            <p><a href="#">📝 Previous Papers</a></p>
            <p><a href="#">💡 Study Tips</a></p>
            <p><a href="#">🎯 Success Stories</a></p>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <p><i class="fas fa-envelope"></i> support@smartstudy.ai</p>
            <p><i class="fas fa-phone"></i> +91 12345 67890</p>
            <p><i class="fas fa-map-marker-alt"></i> Bangalore, India</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 SmartStudy AI | Next-Gen GATE Preparation Platform | Version 3.0</p>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Create floating particles
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 5 + 2;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDuration = Math.random() * 20 + 10 + 's';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particlesContainer.appendChild(particle);
        }
    }
    createParticles();

    // Animated counter for stats
    function animateCounter(element, target, suffix = '') {
        let current = 0;
        const increment = target / 50;
        const interval = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target + suffix;
                clearInterval(interval);
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
        }, 30);
    }

    // Trigger counter animation when stats come into view
    const observerOptions = {
        threshold: 0.5
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(document.getElementById('stat1'), 10, 'K+');
                animateCounter(document.getElementById('stat2'), 95, '%');
                animateCounter(document.getElementById('stat3'), 200, '+');
                observer.disconnect();
            }
        });
    }, observerOptions);
    
    observer.observe(document.querySelector('.hero-stats'));

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
</body>
</html>