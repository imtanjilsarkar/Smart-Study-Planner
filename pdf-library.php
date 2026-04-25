<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Library - SmartStudy AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Animated Background */
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

        .particles { position: fixed; width: 100%; height: 100%; overflow: hidden; z-index: -1; }
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
        .glass-nav.scrolled { top: 10px; background: rgba(10, 10, 10, 0.95); }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a855f7, #3b82f6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-links { display: flex; gap: 25px; align-items: center; flex-wrap: wrap; }
        .nav-links a { text-decoration: none; color: #e0e0e0; font-weight: 500; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover { color: #a855f7; }

        .btn-gradient {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            padding: 8px 24px;
            border-radius: 40px;
            color: white !important;
        }

        .container { max-width: 1400px; margin: 0 auto; padding: 100px 40px 60px; }

        /* Hero Section */
        .library-hero { text-align: center; margin-bottom: 40px; }
        .hero-badge {
            display: inline-block;
            background: rgba(139, 92, 246, 0.2);
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        .library-hero h1 { font-size: 3rem; font-weight: 800; background: linear-gradient(135deg, #fff, #a855f7); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 15px; }

        /* PDF Cards Grid */
        .pdf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .pdf-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .pdf-card:hover { transform: translateY(-5px); border-color: rgba(139, 92, 246, 0.4); }

        .pdf-icon { font-size: 3rem; color: #ef4444; margin-bottom: 15px; }
        .pdf-card h3 { font-size: 1.1rem; margin-bottom: 8px; }
        .pdf-card p { font-size: 12px; color: #9ca3af; margin-bottom: 10px; }
        .pdf-badge {
            display: inline-block;
            background: rgba(139, 92, 246, 0.2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
        }

        /* PDF Viewer Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 2000;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            height: 90%;
            background: #1a1a2e;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .modal-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 { font-size: 1.1rem; }
        .close-modal { background: none; border: none; color: white; font-size: 24px; cursor: pointer; }

        .pdf-viewer {
            width: 100%;
            height: calc(100% - 60px);
            border: none;
        }

        /* Footer */
        .footer {
            background: #050505;
            padding: 50px 10% 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 60px;
        }
        .footer-content { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px; }
        .footer-section h3 { margin-bottom: 20px; font-size: 1.1rem; background: linear-gradient(135deg, #a855f7, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .footer-section p, .footer-section a { color: #b0b0b0; line-height: 1.8; font-size: 13px; text-decoration: none; display: block; margin-bottom: 8px; }
        .footer-section a:hover { color: #a855f7; }
        .footer-bottom { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); color: #b0b0b0; font-size: 12px; }

        @media (max-width: 768px) {
            .container { padding: 80px 20px 40px; }
            .library-hero h1 { font-size: 2rem; }
            .modal-content { width: 95%; height: 95%; }
            .glass-nav { padding: 10px 15px; }
            .nav-links { gap: 12px; }
            .nav-links a { font-size: 11px; }
        }
    </style>
</head>
<body>

<div class="gradient-bg"></div>
<div class="noise-bg"></div>
<div class="particles" id="particles"></div>

<nav class="glass-nav" id="navbar">
    <div class="logo"><i class="fas fa-brain"></i> SmartStudy<span style="color: #a855f7;">AI</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="pdf-library.php" style="color: #a855f7;"> PDF Library</a>
        <a href="success-stories.php">Success Stories</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="btn-gradient">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-gradient">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <div class="library-hero" data-aos="fade-up">
        <div class="hero-badge"><i class="fas fa-book-open"></i> Free Study Material</div>
        <h1>📚 GATE Study Library</h1>
        <p>Access free PDF books, notes, and previous year papers - Read directly in your browser</p>
    </div>

    <!-- PDF Cards Grid -->
    <div class="pdf-grid" id="pdfGrid">
        <!-- PDF 1 - Algorithms Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="100" onclick="openPDF('https://drive.google.com/file/d/1gnOwY0t7R_HX4AdTnh_iwetH14_WpsDp/preview', 'Algorithms Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Algorithms Notes For Professional</h3>
            <p>Complete syllabus coverage with practice questions for CSE/IT aspirants</p>
            <span class="pdf-badge"><i class="fas fa-database"></i> 450+ pages</span>
            <span class="pdf-badge"><i class="fas fa-star"></i> Best Seller</span>
        </div>

        <!-- PDF 2 - C Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="150" onclick="openPDF('https://drive.google.com/file/d/198LPpAWagWjL7RHuX0QnTL5iHP9DqXjc/preview', 'C Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>C Notes For Professional</h3>
            <p>Comprehensive notes on C programming for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> C Programming</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 600+ pages</span>
        </div>

        <!-- PDF 3 - C++ Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="200" onclick="openPDF('https://drive.google.com/file/d/1diBu8Y1j5uF4Jn42tjku7xmgb8gon75v/preview', 'C++ Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>C++ Notes For Professional</h3>
            <p>Comprehensive notes on C++ programming for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> C++ Programming</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 500+ pages</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 500+ pages</span>
        </div>

        <!-- PDF 4 - CSS Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="250" onclick="openPDF('https://drive.google.com/file/d/1m1GjrEp27xsWWuIRjqDvXgmMQkm89V7R/preview', 'CSS Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>CSS Notes For Professional</h3>
            <p>Comprehensive notes on CSS for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> CSS</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 300+ pages</span>
        </div>

        <!-- PDF 5 - Gits Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="300" onclick="openPDF('https://drive.google.com/file/d/1Fspuhuz0UdswQT9ByIa8uGNscFwIKAcA/preview', 'Gits Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Gits Notes For Professional</h3>
            <p>Comprehensive notes on Gits for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> Gits</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 350+ pages</span>
        </div>

        <!-- PDF 6 -- HTML Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/17U1XWhna5-lN8nYFK4RUHNEQ-RPWOJX-/preview', 'HTML Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>HTML Notes For Professional</h3>
            <p>Comprehensive notes on HTML for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> HTML</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 250+ pages</span>
        </div>

        <!-- PDF 7 -- Java Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/1wWOaEYmII39PW_DdJ3FTpFkRsIawftWZ/preview', 'Java Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Java Notes For Professional</h3>
            <p>Comprehensive notes on Java for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> Java</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 400+ pages</span>
        </div>

        <!-- PDF 8 -- Java Script Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/1k6qVttSeSu3AQ4tkrJ5MaRTE4fic3mLa/preview', 'Java Script Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Java Script Notes For Professional</h3>
            <p>Comprehensive notes on Java Script for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> Java Script</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 400+ pages</span>
        </div>

        <!-- PDF 9 -- Node.js Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/1ZaVgNvsjpLJbvd1cLUcF5E6fd9uZ36sr/preview', 'Node.js Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Node.js Notes For Professional</h3>
            <p>Comprehensive notes on Node.js for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> Node.js</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 400+ pages</span>
        </div>

        <!-- PDF 10 -- Python Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/1RNuzVqQCzLEBDV5o4L9ao6a0Jo9s8VE1/preview', 'Python Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>Python Notes For Professional</h3>
            <p>Comprehensive notes on Python for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> Python</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 400+ pages</span>
        </div>

         <!-- PDF 11 -- SQL Notes -->
        <div class="pdf-card" data-aos="fade-up" data-aos-delay="350" onclick="openPDF('https://drive.google.com/file/d/1WhlUv0cLXtLZB4lU7Gt4ftDM8IBrOqto/preview', 'SQL Notes For Professional')">
            <div class="pdf-icon"><i class="fas fa-file-pdf"></i></div>
            <h3>SQL Notes For Professional</h3>
            <p>Comprehensive notes on SQL for GATE preparation</p>
            <span class="pdf-badge"><i class="fas fa-code"></i> SQL</span>
            <span class="pdf-badge"><i class="fas fa-layer-group"></i> 400+ pages</span>
        </div>
    </div>

    <!-- Upload Your PDF Section -->
    <div style="text-align: center; margin-top: 40px; padding: 30px; background: rgba(139,92,246,0.1); border-radius: 24px;" data-aos="fade-up">
        <i class="fas fa-upload" style="font-size: 2rem; color: #a855f7; margin-bottom: 15px;"></i>
        <h3 style="margin-bottom: 10px;">Have a PDF to Share?</h3>
        <p style="color: #9ca3af; margin-bottom: 20px;">Upload your study materials to Google Drive and share the link with us!</p>
        <a href="contact.php" class="btn-gradient" style="display: inline-block; text-decoration: none;">Contact Admin to Add PDF</a>
    </div>
</div>

<!-- PDF Viewer Modal -->
<div id="pdfModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="pdfTitle">PDF Viewer</h3>
            <button class="close-modal" onclick="closePDF()">&times;</button>
        </div>
        <iframe id="pdfFrame" class="pdf-viewer" src=""></iframe>
    </div>
</div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section"><h3><i class="fas fa-brain"></i> SmartStudy AI</h3><p>Revolutionizing GATE preparation with AI.</p></div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="index.php"> Home</a>
            <a href="dashboard.php"> Dashboard</a>
            <a href="pdf-library.php"> PDF Library</a>
            <a href="success-stories.php"> Success Stories</a>
        </div>
        <div class="footer-section"><h3>Contact</h3><p><i class="fas fa-envelope"></i> support@smartstudy.ai</p><p><i class="fas fa-phone"></i> +880 12345 67890</p></div>
    </div>
    <div class="footer-bottom"><p>&copy; 2026 SmartStudy AI | GATE Preparation Platform</p></div>
</footer>

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

    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });

    // PDF Functions
    function openPDF(pdfUrl, title) {
        document.getElementById('pdfTitle').innerText = title;
        document.getElementById('pdfFrame').src = pdfUrl;
        document.getElementById('pdfModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closePDF() {
        document.getElementById('pdfModal').style.display = 'none';
        document.getElementById('pdfFrame').src = '';
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePDF();
    });
</script>
</body>
</html>