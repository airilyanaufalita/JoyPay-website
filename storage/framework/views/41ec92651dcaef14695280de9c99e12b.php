<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoyPay Style Navigation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8fafc;
        }

        header {
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px 0 16px; 
            height: 105px;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1a202c;
        }

        .logo img {
            height: 150px;
            width: auto;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 40px;
            align-items: center;
        }

        nav ul li a {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.2s ease;
            position: relative;
        }

        nav ul li a:not(.login-btn):hover {
            color: #059669; 
            background-color: #e6ffee; 
            transform: translateY(-1px); 
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.1); 
                        border-radius: 55px;
        }

        nav ul li a.active {
            color: #059669;
            background-color: #cdf8ebff;
            border-radius: 55px;
        }

        .login-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            padding: 12px 24px !important;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #059669, #047857) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
        }

        /* Mobile Responsive */
        .mobile-menu {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-menu span {
            width: 25px;
            height: 3px;
            background-color: #475569;
            margin: 3px 0;
            transition: 0.3s;
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 16px 0 8px;
            }

            nav ul {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                gap: 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transform: translateY(-100%);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                padding: 20px 0;
            }

            nav ul.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            nav ul li {
                width: 100%;
                text-align: center;
                padding: 8px 0;
            }

            nav ul li a {
                display: block;
                width: 100%;
                padding: 12px 24px;
            }

            .mobile-menu {
                display: flex;
            }

            .logo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="/" class="logo">
                <img src="<?php echo e(asset('images/LogoJoyPay.png')); ?>" alt="JoyPay Logo">
            </a>

            <nav>
                <ul id="navMenu">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="/informasi">Informasi</a></li>
                    <li><a href="/kamus">Kamus</a></li>
                    <li><a href="/kloterAktif">Kloter Aktif</a></li>
                    <li><a href="/login" class="login-btn">Masuk</a></li>
                </ul>
            </nav>

            <div class="mobile-menu" onclick="toggleMobileMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>



    <script>
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('.navbar');
            const navMenu = document.getElementById('navMenu');
            
            // Check if the click is outside the navbar and the menu is active
            if (!navbar.contains(event.target) && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname; 
            document.querySelectorAll('nav ul li a:not(.login-btn)').forEach(link => {

                const linkPath = new URL(link.href).pathname;

                if (linkPath === currentPath || (linkPath === '/' && currentPath === '/')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\joypayy\resources\views/layouts/header.blade.php ENDPATH**/ ?>