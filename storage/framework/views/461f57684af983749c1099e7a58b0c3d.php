<footer style="
    background: #5a5a5a;
    color: white;
    position: relative;
    overflow: hidden;
">
    <div style="
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px 30px;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 60px;
        position: relative;
        z-index: 2;
    " class="footer-content">
        
        
        <div class="footer-section footer-brand">
            <div style="
                width: 180px;
                height: 180px;
                background: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 30px;
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                margin-left: 0;
                margin-right: auto;
            " class="logo-circle">
                <img src="<?php echo e(asset('images/LogoJoyPay.png')); ?>" alt="JoyPay Logo" style="
                    width: 80%;
                    height: auto;
                    object-fit: contain;
                ">
            </div>

            <div style="text-align: left;">
                <a href="#" style="
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    background: transparent;
                    color: #ffffffff;
                    padding: 12px 20px;
                    border: 2px solid #ffffffff;
                    border-radius: 25px;
                    text-decoration: none;
                    font-size: 0.9rem;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                " class="back-to-top" onclick="scrollToTop()">
                    <i class="fas fa-arrow-up"></i>
                    BACK TO TOP
                </a>
            </div>
        </div>

        
        <div class="footer-section">
            <h3 style="
                color: white;
                margin-bottom: 30px;
                font-size: 1.3rem;
                font-weight: 800; 
                letter-spacing: 1px;
                text-transform: uppercase;
                text-align: left; /* Ensure the heading is left-aligned */
            ">SOCIAL</h3>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fab fa-instagram" style="
                        font-size: 1.5rem;
                        color: #ffffffff;
                        width: 30px;
                    "></i>
                    <span style="color: #e5e7eb; font-size: 1rem;">@arisan_barokah</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fab fa-whatsapp" style="
                        font-size: 1.5rem;
                        color: #ffffffff;
                        width: 30px;
                    "></i>
                    <span style="color: #e5e7eb; font-size: 1rem;">08123456789</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-phone" style="
                        font-size: 1.5rem;
                        color: #fefefeff;
                        width: 30px;
                    "></i>
                    <span style="color: #e5e7eb; font-size: 1rem;">08123456789</span>
                </div>
            </div>
        </div>

        
        <div class="footer-section">
            <h3 style="
                color: white;
                margin-bottom: 30px;
                font-size: 1.3rem;
                font-weight: 800; 
                letter-spacing: 1px;
                text-transform: uppercase;
                text-align: left; /* Ensure the heading is left-aligned */
            ">SITE MAP</h3>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-home" style="
                        font-size: 1.2rem;
                        color: #fbfffeff;
                        width: 30px;
                    "></i>
                    <a href="<?php echo e(route('home')); ?>" style="
                        color: #e5e7eb;
                        text-decoration: none;
                        font-size: 1rem;
                        transition: all 0.3s ease;
                    ">Beranda</a>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-info-circle" style="
                        font-size: 1.2rem;
                        color: #ffffffff;
                        width: 30px;
                    "></i>
                    <a href="<?php echo e(route('informasi')); ?>" style="
                        color: #e5e7eb;
                        text-decoration: none;
                        font-size: 1rem;
                        transition: all 0.3s ease;
                    ">Informasi</a>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-book" style="
                        font-size: 1.2rem;
                        color: #ffffffff;
                        width: 30px;
                    "></i>
                    <a href="<?php echo e(route('kamus')); ?>" style="
                        color: #e5e7eb;
                        text-decoration: none;
                        font-size: 1rem;
                        transition: all 0.3s ease;
                    ">Kamus</a>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-users" style="
                        font-size: 1.2rem;
                        color: #f6f7f7ff;
                        width: 30px;
                    "></i>
                    <a href="<?php echo e(route('kloter.aktif')); ?>" style="
                        color: #e5e7eb;
                        text-decoration: none;
                        font-size: 1rem;
                        transition: all 0.3s ease;
                    ">Kloter Aktif</a>
                </div>
<?php if(auth()->guard()->check()): ?>
<div style="display: flex; align-items: center; gap: 15px;">
    <i class="fas fa-trophy" style="
        font-size: 1.2rem;
        color: #f6f7f7ff;
        width: 30px;
    "></i>
    <a href="<?php echo e(route('pemenang.index')); ?>" style="
        color: #e5e7eb;
        text-decoration: none;
        font-size: 1rem;
        transition: all 0.3s ease;
    ">Pemenang</a>
</div>
<?php endif; ?>
            </div>
        </div>
    </div>

</footer>


<style>
    .footer-section a:hover {
        color: #ffffffff !important;
        transform: translateX(5px);
    }

    .back-to-top:hover {
        background: rgba(16, 185, 129, 0.6) !important;
        color: white !important;
        border-color: #10b981 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 968px) {
        .footer-content {
            grid-template-columns: 1fr !important;
            gap: 40px !important;
            text-align: center;
        }
        .footer-section h3 {
            text-align: center !important; /* Center headings on smaller screens */
        }
        .footer-section .logo-circle,
        .footer-section .back-to-top,
        .footer-section div[style*="flex-direction: column"] {
            align-items: center !important; /* Center content within columns on smaller screens */
        }
    }

    @media (max-width: 640px) {
        .footer-content {
            padding: 40px 20px !important;
        }
        
        .logo-circle {
            margin: 0 auto 30px !important;
        }
        
        .back-to-top {
            margin: 0 auto !important;
        }
    }
</style>


<script>
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Add scroll effect for back to top button
    window.addEventListener('scroll', function() {
        const backToTop = document.querySelector('.back-to-top');
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.style.opacity = '1';
            } else {
                backToTop.style.opacity = '0.7';
            }
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"><?php /**PATH C:\xampp\htdocs\joypayy\resources\views/layouts/footer.blade.php ENDPATH**/ ?>