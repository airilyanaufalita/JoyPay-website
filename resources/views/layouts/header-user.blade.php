<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JoyPay - User Navigation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        nav ul li a:not(.profile-btn):not(.notification-btn):hover {
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

        /* User Actions Container */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Notification Button Styles */
        .notification-dropdown {
            position: relative;
            display: inline-block;
        }

        .notification-btn {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white !important;
            padding: 12px !important;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
            border: none;
            position: relative;
        }

        .notification-btn:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.4);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        /* Profile Dropdown Styles */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            padding: 12px 16px !important;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
            border: none;
        }

        .profile-btn:hover {
            background: linear-gradient(135deg, #059669, #047857) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            z-index: 1000;
        }

        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 16px;
            height: 16px;
            background: white;
            border-left: 1px solid #e2e8f0;
            border-top: 1px solid #e2e8f0;
            transform: rotate(45deg);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: #059669;
        }

        .dropdown-item i {
            margin-right: 12px;
            width: 16px;
            text-align: center;
            font-size: 16px;
        }

        .dropdown-item:first-child {
            border-radius: 12px 12px 0 0;
        }

        .dropdown-item:last-child {
            border-radius: 0 0 12px 12px;
        }

        /* Notification Dropdown Styles */
        .notification-menu {
            min-width: 320px;
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-header {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            background-color: #f8fafc;
            border-radius: 12px 12px 0 0;
        }

        .notification-header h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 4px;
        }

        .notification-header p {
            font-size: 12px;
            color: #6b7280;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }

        .notification-item.unread {
            background-color: #eff6ff;
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #3b82f6;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .notification-icon.info {
            background-color: #dbeafe;
            color: #3b82f6;
        }

        .notification-icon.success {
            background-color: #d1fae5;
            color: #10b981;
        }

        .notification-icon.warning {
            background-color: #fef3c7;
            color: #f59e0b;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h5 {
            font-size: 14px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .notification-content p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.4;
            margin-bottom: 4px;
        }

        .notification-time {
            font-size: 12px;
            color: #9ca3af;
        }

        .notification-footer {
            padding: 12px 16px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            background-color: #f8fafc;
            border-radius: 0 0 12px 12px;
        }

        .view-all-btn {
            color: #3b82f6;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .view-all-btn:hover {
            color: #2563eb;
        }

        .empty-notifications {
            padding: 40px 16px;
            text-align: center;
            color: #9ca3af;
        }

        .empty-notifications i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }

        /* Pop-up Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 12px;
            padding: 32px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }

        .modal-icon {
            font-size: 48px;
            color: #ef4444;
            margin-bottom: 16px;
        }

        .modal h3 {
            font-size: 24px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 8px;
        }

        .modal p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
            transform: translateY(-1px);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .btn-confirm:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
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

            .user-actions {
                position: absolute;
                right: 60px;
                top: 50%;
                transform: translateY(-50%);
                gap: 12px;
            }

            .notification-btn, .profile-btn {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .logo h1 {
                font-size: 24px;
            }

            .modal {
                padding: 24px;
                max-width: 350px;
            }

            .modal h3 {
                font-size: 20px;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .dropdown-menu {
                right: -20px;
                min-width: 180px;
            }

            .notification-menu {
                min-width: 280px;
                right: -40px;
            }

            .dropdown-menu::before {
                right: 35px;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="navbar">
        <a href="/" class="logo">
            <img src="{{ asset('images/LogoJoyPay.png') }}" alt="JoyPay Logo">
        </a>

        <nav>
            <ul id="navMenu">
                <li><a href="/">Beranda</a></li>
                <li><a href="/informasi">Informasi</a></li>
                <li><a href="/kamus">Kamus</a></li>
                <li><a href="{{route('kloter.aktif')}}">Kloter Aktif</a></li>
                <li><a href="{{ route('pemenang.index') }}">Pemenang</a></li>
                    
                    <!-- Profile Button -->
                    <div class="profile-dropdown">
                        <button class="profile-btn" id="profileBtn">
                            <i class="fas fa-user"></i>
                        </button>
                        <div class="dropdown-menu" id="profileMenu">
                            <a href="{{ route('profile') }}" class="dropdown-item">
                                <i class="fas fa-user-circle"></i>
                                Profil
                            </a>
                            <a href="{{ route('kloter.user') }}" class="dropdown-item">
                                <i class="fas fa-users"></i>
                                Kloter yang Diikuti
                            </a>
                            <a href="{{ route('pendapatan.index') }}" class="dropdown-item">
    <i class="fas fa-money-bill-wave"></i>
    Pendapatan
</a>
                        </div>
                    </div>
                </li>
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

    // Toggle notification dropdown
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationMenu = document.getElementById('notificationMenu');

    if (notificationBtn && notificationMenu) {
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            notificationMenu.classList.toggle('active');
            
            // Tutup profile dropdown jika terbuka
            const profileMenu = document.getElementById('profileMenu');
            if (profileMenu && profileMenu.classList.contains('active')) {
                profileMenu.classList.remove('active');
            }
        });
    }

    // Toggle profile dropdown
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            profileMenu.classList.toggle('active');
            
            // Tutup notification dropdown jika terbuka
            if (notificationMenu && notificationMenu.classList.contains('active')) {
                notificationMenu.classList.remove('active');
            }
        });
    }

    // Tutup dropdowns jika klik di luar
    document.addEventListener('click', function(event) {
        if (notificationBtn && notificationMenu && 
            !notificationBtn.contains(event.target) && 
            !notificationMenu.contains(event.target)) {
            notificationMenu.classList.remove('active');
        }
        
        if (profileBtn && profileMenu && 
            !profileBtn.contains(event.target) && 
            !profileMenu.contains(event.target)) {
            profileMenu.classList.remove('active');
        }
    });

    // Tutup dropdown saat link diklik
    if (profileMenu) {
        const dropdownItems = profileMenu.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                profileMenu.classList.remove('active');
            });
        });
    }

    // Handle notification item clicks
    if (notificationMenu) {
        const notificationItems = notificationMenu.querySelectorAll('.notification-item');
        notificationItems.forEach(item => {
            item.addEventListener('click', function() {
                // Mark as read
                this.classList.remove('unread');
                
                // Update badge count
                const badge = document.getElementById('notificationBadge');
                const unreadCount = notificationMenu.querySelectorAll('.notification-item.unread').length;
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                } else {
                    badge.style.display = 'none';
                }
                
                // Close dropdown
                notificationMenu.classList.remove('active');
            });
        });
    }

    // Highlight menu aktif
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('nav ul li a:not(.dropdown-item):not(.notification-btn):not(.profile-btn)').forEach(link => {
            const linkPath = new URL(link.href).pathname;
            if (linkPath === currentPath || (linkPath === '/' && currentPath === '/')) {
                link.classList.add('active');
            }
        });
    });

    // Tutup dropdown saat mobile menu diklik
    function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        const profileMenu = document.getElementById('profileMenu');
        const notificationMenu = document.getElementById('notificationMenu');
        
        navMenu.classList.toggle('active');
        
        // Tutup profile dropdown jika terbuka
        if (profileMenu && profileMenu.classList.contains('active')) {
            profileMenu.classList.remove('active');
        }
        
        // Tutup notification dropdown jika terbuka
        if (notificationMenu && notificationMenu.classList.contains('active')) {
            notificationMenu.classList.remove('active');
        }
    }
</script>
</body>
</html>