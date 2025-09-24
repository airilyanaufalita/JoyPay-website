<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arisan Barokah - Platform Arisan Digital Terpercaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Arisan Barokah<br>Since 2020</h1>
                <p class="hero-description">
                    Arisan Barokah by Owner Farah Proping Dewi, 
                    cocok untuk investasi jangka pendek dengan pilihan 
                    kloter yang banyak.
                </p>
            </div>
            
            <div class="hero-visual">
                <div class="laptop-container">
                     <img src="{{ asset('images/2laptop.png') }}" alt="Laptop showing Arisan Barokah platform" class="laptop-image">
                    <div class="floating-elements">
                        <div class="floating-item"></div>
                        <div class="floating-item"></div>
                        <div class="floating-item"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Mengapa Pilih Arisan Barokah?</h2>
            <p class="section-description animate-on-scroll">
                Kami menyediakan platform arisan digital yang aman, transparan, dan mudah digunakan
            </p>
            
            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Keamanan Terjamin</h3>
                    <p class="feature-description">
                        Sistem keamanan berlapis dengan enkripsi tingkat bank untuk melindungi dana dan data pribadi Anda
                    </p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Komunitas Terpercaya</h3>
                    <p class="feature-description">
                        Bergabung dengan komunitas arisan yang telah diverifikasi dan memiliki reputasi baik
                    </p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mudah Digunakan</h3>
                    <p class="feature-description">
                        Interface yang intuitif dan user-friendly, dapat diakses kapan saja melalui smartphone atau komputer
                    </p>
                </div>
                
               
            </div>
        </div>
    </section>

    <!-- Stats Section -->


    <!-- Image Gallery Section -->
   


<!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Apa Kata Mereka</h2>
            <p class="section-description animate-on-scroll">
                Testimoni dari ribuan pengguna yang puas dengan layanan Arisan Barokah
            </p>
            
            
            <div class="testimonial-grid">
                <div class="testimonial-card animate-on-scroll">
                    
                    <p class="testimonial-text">
                        "Arisan Barokah sangat membantu saya mengelola keuangan dengan sistem arisan yang transparan dan aman. Sudah 2 tahun menggunakan dan tidak pernah ada masalah!"
                    </p>
                    <div class="testimonial-author">Adinda</div>
                    <div class="testimonial-role">Ibu Rumah Tangga</div>
                </div>
                
                <div class="testimonial-card animate-on-scroll">
                   
                    <p class="testimonial-text">
                        "Sebagai pengusaha, Arisan Barokah membantu saya mengatur cashflow dengan lebih baik. Interface yang mudah dan customer service yang responsif."
                    </p>
                    <div class="testimonial-author">Airilya</div>
                    <div class="testimonial-role">Pengusaha</div>
                </div>
                
                <div class="testimonial-card animate-on-scroll">
                    
                    <p class="testimonial-text">
                        "Fitur otomatis Arisan Barokah sangat memudahkan. Saya tidak perlu repot mengatur jadwal pembayaran manual. Semuanya berjalan lancar!"
                    </p>
                    <div class="testimonial-author">Zaki</div>
                    <div class="testimonial-role">Karyawan Swasta</div>
                </div>
            </div>

            <br>
            @auth
            <div class="testimoni-action animate-on-scroll" style="text-align: center; margin-bottom: 40px;">
                <a href="{{ route('testimoni.create') }}" class="btn-testimoni">
                    <i class="fas fa-plus"></i>
                    Bagikan Testimoni Anda
                </a>
            </div>
            @endauth
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Cara Kerja Arisan Barokah</h2>
            <p class="section-description animate-on-scroll">
                Mulai arisan digital Anda hanya dalam 3 langkah mudah
            </p>
            
            <div class="steps-container">
                <div class="step-item animate-on-scroll">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Daftar & Verifikasi</h3>
                    <p class="step-description">
                        Buat akun dengan mudah dan lakukan verifikasi identitas untuk keamanan maksimal
                    </p>
                </div>
                
                <div class="step-item animate-on-scroll">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Pilih Kloter Arisan</h3>
                    <p class="step-description">
                        Pilih kloter arisan yang sesuai dengan kemampuan dan kebutuhan Anda
                    </p>
                </div>
                
                <div class="step-item animate-on-scroll">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Mulai Berarisan</h3>
                    <p class="step-description">
                        Lakukan pembayaran rutin dan nikmati kemudahan arisan digital yang aman
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title animate-on-scroll">Siap Memulai Arisan Digital?</h2>
            <p class="cta-description animate-on-scroll">
                Bergabunglah dengan ribuan orang yang telah merasakan kemudahan Arisan Barokah
            </p>
            <div class="cta-buttons animate-on-scroll">
                <a href="{{ route('kloter.aktif') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>
<!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>

        // Smooth scroll animation
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animated');
                }
            });
        }

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const animationDuration = 2000; // 2 seconds
            const frameDuration = 1000 / 60; // 60fps
            const totalFrames = Math.round(animationDuration / frameDuration);
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                let frame = 0;
                
                const countAnimation = () => {
                    frame++;
                    const progress = frame / totalFrames;
                    const currentCount = Math.round(target * progress);
                    
                    counter.textContent = currentCount;
                    
                    if (frame < totalFrames) {
                        requestAnimationFrame(countAnimation);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                countAnimation();
            });
        }

        // Back to top functionality
        const backToTop = document.getElementById('backToTop');
        
        // Click event untuk smooth scroll ke atas
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize animations
        window.addEventListener('scroll', () => {
            animateOnScroll();
            
            // Show/hide back to top button berdasarkan scroll position
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        window.addEventListener('load', () => {
            animateOnScroll();
            
            // Start counter animation when stats section is visible
            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                });
                observer.observe(statsSection);
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Add hover effect to feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add click ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });

        // Scroll indicator
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.querySelector('.scroll-indicator').style.width = scrolled + '%';
        });

        // Initialize animations
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', () => {
            animateOnScroll();
            
            // Start counter animation when stats section is visible
            const statsSection = document.querySelector('.stats-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(statsSection);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Add hover effect to feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add click ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
    </script>

    <style>
        /* Additional styles for enhanced interactions */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        body {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        body.loaded {
            opacity: 1;
        }

        /* Enhanced button styles */
        .btn {
            position: relative;
            overflow: hidden;
        }

        /* Enhanced floating animations */
        .floating-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.7;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 1;
            }
        }

        /* Enhanced scroll indicator */
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background:  linear-gradient(135deg, #6B9B76, #7BA05B);
            z-index: 1000;
            transition: width 0.1s ease;
        }
    </style>

    <!-- Add scroll indicator -->
    <div class="scroll-indicator"></div>

    <script>
        // Scroll indicator
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.querySelector('.scroll-indicator').style.width = scrolled + '%';
        });
    </script>
</body>
</html>