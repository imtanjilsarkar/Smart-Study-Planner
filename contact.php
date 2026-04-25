<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartStudy AI | Contact Us</title>
    
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
        .contact-hero {
            text-align: center;
            margin-bottom: 50px;
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

        .contact-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
        }

        .contact-hero p {
            font-size: 1.2rem;
            color: #b0b0b0;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Contact Grid */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
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
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Contact Info Items */
        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            transition: 0.3s;
        }

        .contact-info-item:hover {
            background: rgba(139, 92, 246, 0.1);
            transform: translateX(5px);
        }

        .info-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .info-content h4 {
            font-size: 1rem;
            color: #9ca3af;
            margin-bottom: 5px;
        }

        .info-content p {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Social Links */
        .social-section {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .social-title {
            font-size: 1.1rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: 0.3s;
            text-decoration: none;
            color: white;
        }

        .social-icon:hover {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.4);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #a855f7;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
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
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        }

        /* Map Section */
        .map-card {
            margin-top: 30px;
            overflow: hidden;
        }

        .map-placeholder {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.05));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* FAQ Section */
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .faq-item {
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            transition: 0.3s;
        }

        .faq-item:hover {
            background: rgba(139, 92, 246, 0.05);
        }

        .faq-item h4 {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #a855f7;
        }

        .faq-item p {
            font-size: 13px;
            color: #9ca3af;
            line-height: 1.5;
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

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            color: #b0b0b0;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .container { padding: 80px 20px 40px; }
            .contact-hero h1 { font-size: 2rem; }
            .contact-grid { grid-template-columns: 1fr; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 12px; }
            .info-content p { font-size: 14px; }
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
        <a href="contact.php" style="color: #a855f7;">Contact</a>
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
    <div class="contact-hero" data-aos="fade-up">
        <div class="hero-badge">
            <i class="fas fa-headset"></i> Get in Touch
        </div>
        <h1>Let's Talk</h1>
        <p>Have questions? We're here to help. Reach out to us anytime.</p>
    </div>

    <!-- Contact Grid -->
    <div class="contact-grid">
        <!-- Contact Information -->
        <div class="glass-card" data-aos="fade-right" data-aos-delay="100">
            <h2 style="font-size: 1.5rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-address-card" style="color: #a855f7;"></i> Contact Information
            </h2>
            
            <div class="contact-info-item">
                <div class="info-icon" style="color: #a855f7;"><i class="fas fa-envelope"></i></div>
                <div class="info-content">
                    <h4>Email Us</h4>
                    <p>support@smartstudy.ai</p>
                    <p style="font-size: 12px; color: #6b7280;">info@smartstudy.ai</p>
                </div>
            </div>
            
            <div class="contact-info-item">
                <div class="info-icon" style="color: #3b82f6;"><i class="fas fa-phone-alt"></i></div>
                <div class="info-content">
                    <h4>Call Us</h4>
                    <p>+91 12345 67890</p>
                    <p style="font-size: 12px; color: #6b7280;">Mon-Fri, 9AM-6PM IST</p>
                </div>
            </div>
            
            <div class="contact-info-item">
                <div class="info-icon" style="color: #22c55e;"><i class="fab fa-whatsapp"></i></div>
                <div class="info-content">
                    <h4>WhatsApp</h4>
                    <p>+91 98765 43210</p>
                    <p style="font-size: 12px; color: #6b7280;">Quick responses within 2hrs</p>
                </div>
            </div>
            
            <div class="contact-info-item">
                <div class="info-icon" style="color: #eab308;"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-content">
                    <h4>Visit Us</h4>
                    <p>SmartStudy AI Headquarters</p>
                    <p style="font-size: 12px; color: #6b7280;">Bangalore, Karnataka, India - 560001</p>
                </div>
            </div>

            <!-- Social Section -->
            <div class="social-section">
                <div class="social-title">
                    <i class="fas fa-share-alt"></i> Follow Us
                </div>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-discord"></i></a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="glass-card" data-aos="fade-left" data-aos-delay="150">
            <h2 style="font-size: 1.5rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-paper-plane" style="color: #3b82f6;"></i> Send a Message
            </h2>
            
            <form id="contactForm">
                <div class="form-group">
                    <input type="text" id="name" placeholder="Your Full Name" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" placeholder="Your Email Address" required>
                </div>
                <div class="form-group">
                    <select id="subject">
                        <option value="">Select Subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="feedback">Feedback</option>
                        <option value="partnership">Partnership</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea id="message" placeholder="Your Message..." required></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="glass-card" data-aos="fade-up" data-aos-delay="200">
        <h2 style="font-size: 1.5rem; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-question-circle" style="color: #eab308;"></i> Frequently Asked Questions
        </h2>
        
        <div class="faq-grid">
            <div class="faq-item">
                <h4>❓ How do I reset my password?</h4>
                <p>Click on "Forgot Password" on the login page. You'll receive a reset link via email.</p>
            </div>
            <div class="faq-item">
                <h4>❓ Is the platform free?</h4>
                <p>Yes! SmartStudy AI offers free access to all core features including study planning and quizzes.</p>
            </div>
            <div class="faq-item">
                <h4>❓ How accurate is the AI prediction?</h4>
                <p>Our AI model has 90%+ accuracy based on historical GATE data and user performance.</p>
            </div>
            <div class="faq-item">
                <h4>❓ Can I use it on mobile?</h4>
                <p>Absolutely! The platform is fully responsive and works on all devices.</p>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="glass-card map-card" data-aos="fade-up" data-aos-delay="250">
        <h2 style="font-size: 1.3rem; margin-bottom: 20px;"><i class="fas fa-map-marked-alt" style="color: #22c55e;"></i> Our Location</h2>
        <div class="map-placeholder">
            <i class="fas fa-map-marker-alt" style="font-size: 3rem; color: #a855f7;"></i>
            <p>SmartStudy AI Headquarters</p>
            <p style="font-size: 12px; color: #9ca3af;">Bangalore, India</p>
            <p style="font-size: 12px; color: #6b7280;">📍 Interactive map available in full version</p>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="contactToast" class="toast-notification">
    <i class="fas fa-check-circle"></i> Message sent successfully! We'll get back to you soon.
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3><i class="fas fa-brain"></i> SmartStudy AI</h3>
            <p>Revolutionizing GATE preparation with artificial intelligence. Smart planning, smarter results.</p>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="index.php">🏠 Home</a>
            <a href="dashboard.php">📊 Dashboard</a>
            <a href="about.php">📖 About Us</a>
            <a href="contact.php">📞 Contact</a>
        </div>
        <div class="footer-section">
            <h3>Support</h3>
            <a href="#">📚 Help Center</a>
            <a href="#">📝 Privacy Policy</a>
            <a href="#">⚖️ Terms of Service</a>
            <a href="#">💡 FAQ</a>
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

    // Contact Form Handler
    const contactForm = document.getElementById('contactForm');
    const toast = document.getElementById('contactToast');

    function showToast() {
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        
        // Simple validation
        if(!name || !email || !subject || !message) {
            alert('Please fill in all fields');
            return;
        }
        
        if(!email.includes('@')) {
            alert('Please enter a valid email address');
            return;
        }
        
        // Show success message
        showToast();
        
        // Reset form
        contactForm.reset();
        
        // Optional: Send to server via AJAX
        // fetch('api/send_contact.php', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ name, email, subject, message })
        // });
    });
</script>
</body>
</html>