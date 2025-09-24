<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kloter User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            line-height: 1.6;
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #6B9B76, #7BA05B);
            z-index: 9999;
            transition: width 0.3s ease;
        }

        /* Container */
        .kloter-user-container {
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #6B9B76 0%, #7BA05B 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { 
                transform: translateY(0) rotate(0deg); 
            }
            100% { 
                transform: translateY(-100px) rotate(360deg); 
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 40px;
        }

        /* Category Navigation */
        .category-nav {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .category-btn {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .category-btn:hover,
        .category-btn.active {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            color: white;
            text-decoration: none;
        }

        /* Sub Category Navigation */
        .sub-category-nav {
            max-width: 1200px;
            margin: 40px auto 0;
            padding: 0 20px;
            display: none;
        }

        .sub-category-nav.active {
            display: block;
        }

        .sub-category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sub-category-btn {
            padding: 10px 20px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            color: #495057;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .sub-category-btn:hover,
        .sub-category-btn.active {
            background: linear-gradient(135deg, #6B9B76, #7BA05B);
            border-color: #6B9B76;
            color: white;
            transform: translateY(-1px);
            text-decoration: none;
        }

        /* Content Areas */
        .content-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Overview Section (Default) */
        .overview-section {
            display: block;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 4px solid #6B9B76;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #6B9B76;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        /* Kloter Grid */
        .kloter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .kloter-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid #6B9B76;
        }

        .kloter-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .kloter-header {
            padding: 20px 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .kloter-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 5px 0;
        }

        .kloter-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-verified {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background: #fecaca;
            color: #991b1b;
        }

        .status-paid {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-overdue {
            background: #fdf2f8;
            color: #be185d;
        }

        .kloter-info {
            padding: 20px;
        }

        .kloter-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .kloter-info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .kloter-info-label {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
        }

        .kloter-info-value {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
        }

        .amount-value {
            color: #10b981 !important;
            font-weight: 700 !important;
        }

        /* Revenue Section */
        .revenue-summary {
            background: linear-gradient(135deg, #6B9B76, #7BA05B);
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 40px;
            text-align: center;
        }

        .revenue-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .revenue-amount {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .revenue-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .revenue-stat {
            text-align: center;
        }

        .revenue-stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .revenue-stat-label {
            opacity: 0.9;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #374151;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 1.1rem;
            opacity: 0.8;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Back Button */
        .back-button {
            position: fixed;
            top: 30px;
            left: 30px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            color: #1f2937;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: #1f2937;
            text-decoration: none;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6B9B76, #7BA05B);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(107, 155, 118, 0.3);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 12px 30px rgba(107, 155, 118, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }

            .category-buttons {
                flex-direction: column;
                align-items: center;
            }

            .category-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .sub-category-buttons {
                flex-direction: column;
                align-items: center;
            }

            .sub-category-btn {
                width: 100%;
                max-width: 250px;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .kloter-grid {
                grid-template-columns: 1fr;
            }

            .revenue-stats {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .revenue-amount {
                font-size: 2rem;
            }

            .back-button {
                top: 20px;
                left: 20px;
                padding: 10px 15px;
            }

            .back-to-top {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Scroll Indicator -->
    <div class="scroll-indicator"></div>

    <!-- Back Button -->
    <a href="#" class="back-button" onclick="window.history.back(); return false;">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="kloter-user-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="page-title">Dashboard Kloter User</h1>
                <p class="page-subtitle">Kelola dan pantau semua aktivitas kloter Anda</p>
                
                <!-- Category Navigation -->
                <div class="category-nav">
                    <div class="category-buttons">
                        <button class="category-btn" onclick="showCategory('overview')">
                            <i class="fas fa-home"></i>
                            Semua Kloter
                        </button>
                        <button class="category-btn" onclick="showCategory('verifikasi')">
                            <i class="fas fa-shield-alt"></i>
                            Verifikasi Admin
                        </button>
                        <button class="category-btn" onclick="showCategory('kloter-diikuti')">
                            <i class="fas fa-users"></i>
                            Kloter yang Diikuti
                        </button>
                        <button class="category-btn" onclick="showCategory('pembayaran')">
                            <i class="fas fa-credit-card"></i>
                            Pembayaran
                        </button>
                        <button class="category-btn" onclick="showCategory('pendapatan')">
                            <i class="fas fa-chart-line"></i>
                            Pendapatan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub Category Navigation for Verifikasi -->
        <div class="sub-category-nav" id="sub-verifikasi">
            <div class="sub-category-buttons">
                <button class="sub-category-btn active" onclick="showSubCategory('verifikasi', 'terverifikasi')">
                    <i class="fas fa-check-circle"></i>
                    Terverifikasi
                </button>
                <button class="sub-category-btn" onclick="showSubCategory('verifikasi', 'ditolak')">
                    <i class="fas fa-times-circle"></i>
                    Verifikasi Ditolak
                </button>
            </div>
        </div>

        <!-- Sub Category Navigation for Pembayaran -->
        <div class="sub-category-nav" id="sub-pembayaran">
            <div class="sub-category-buttons">
                <button class="sub-category-btn active" onclick="showSubCategory('pembayaran', 'sudah-bayar')">
                    <i class="fas fa-check"></i>
                    Sudah Dibayar
                </button>
                <button class="sub-category-btn" onclick="showSubCategory('pembayaran', 'belum-bayar')">
                    <i class="fas fa-clock"></i>
                    Belum Dibayar
                </button>
                <button class="sub-category-btn" onclick="showSubCategory('pembayaran', 'menunggak')">
                    <i class="fas fa-exclamation-triangle"></i>
                    Menunggak
                </button>
                <button class="sub-category-btn" onclick="showSubCategory('pembayaran', 'pembayaran-ditolak')">
                    <i class="fas fa-ban"></i>
                    Verifikasi Ditolak
                </button>
            </div>
        </div>

        <!-- Overview Section (Default) -->
        <div class="content-section active" id="overview-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">12</div>
                    <div class="stat-label">Total Kloter</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">8</div>
                    <div class="stat-label">Terverifikasi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="stat-number">5</div>
                    <div class="stat-label">Sudah Bayar</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-number">Rp 2.5M</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>

            <div class="kloter-grid">
                <!-- Sample Kloter Cards -->
                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">Kloter Arisan A</h3>
                        </div>
                        <span class="kloter-status status-verified">Terverifikasi</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Jumlah Anggota:</span>
                            <span class="kloter-info-value">20</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Iuran Bulanan:</span>
                            <span class="kloter-info-value amount-value">Rp 500.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Status Pembayaran:</span>
                            <span class="kloter-status status-paid">Lunas</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Tanggal Bergabung:</span>
                            <span class="kloter-info-value">15 Jan 2024</span>
                        </div>
                    </div>
                </div>

                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">Kloter Arisan B</h3>
                        </div>
                        <span class="kloter-status status-pending">Menunggu</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Jumlah Anggota:</span>
                            <span class="kloter-info-value">15</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Iuran Bulanan:</span>
                            <span class="kloter-info-value amount-value">Rp 300.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Status Pembayaran:</span>
                            <span class="kloter-status status-unpaid">Belum Bayar</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Tanggal Bergabung:</span>
                            <span class="kloter-info-value">02 Feb 2024</span>
                        </div>
                    </div>
                </div>

                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">Kloter Arisan C</h3>
                        </div>
                        <span class="kloter-status status-rejected">Ditolak</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Jumlah Anggota:</span>
                            <span class="kloter-info-value">10</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Iuran Bulanan:</span>
                            <span class="kloter-info-value amount-value">Rp 200.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Status Pembayaran:</span>
                            <span class="kloter-status status-overdue">Menunggak</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Tanggal Bergabung:</span>
                            <span class="kloter-info-value">20 Mar 2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verifikasi Content -->
        <div class="content-section" id="verifikasi-content">
            <div id="verifikasi-terverifikasi" class="kloter-grid">
                <!-- Terverifikasi cards will be shown here -->
            </div>
            <div id="verifikasi-ditolak" class="kloter-grid" style="display: none;">
                <!-- Ditolak cards will be shown here -->
            </div>
        </div>

        <!-- Kloter Diikuti Content -->
        <div class="content-section" id="kloter-diikuti-content">
            <div class="kloter-grid">
                <!-- Kloter yang diikuti cards -->
            </div>
        </div>

        <!-- Pembayaran Content -->
        <div class="content-section" id="pembayaran-content">
            <div id="pembayaran-sudah-bayar" class="kloter-grid">
                <!-- Sudah bayar cards -->
            </div>
            <div id="pembayaran-belum-bayar" class="kloter-grid" style="display: none;">
                <!-- Belum bayar cards -->
            </div>
            <div id="pembayaran-menunggak" class="kloter-grid" style="display: none;">
                <!-- Menunggak cards -->
            </div>
            <div id="pembayaran-pembayaran-ditolak" class="kloter-grid" style="display: none;">
                <!-- Pembayaran ditolak cards -->
            </div>
        </div>

        <!-- Pendapatan Content -->
        <div class="content-section" id="pendapatan-content">
            <div class="revenue-summary">
                <h2 class="revenue-title">Total Pendapatan</h2>
                <div class="revenue-amount">Rp 2.500.000</div>
                <p>Pendapatan yang telah diterima dari kloter arisan</p>
                
                <div class="revenue-stats">
                    <div class="revenue-stat">
                        <div class="revenue-stat-number">5</div>
                        <div class="revenue-stat-label">Kloter Menguntungkan</div>
                    </div>
                    <div class="revenue-stat">
                        <div class="revenue-stat-number">3</div>
                        <div class="revenue-stat-label">Kali Menang</div>
                    </div>
                    <div class="revenue-stat">
                        <div class="revenue-stat-number">Rp 833.333</div>
                        <div class="revenue-stat-label">Rata-rata per Kloter</div>
                    </div>
                    <div class="revenue-stat">
                        <div class="revenue-stat-number">15%</div>
                        <div class="revenue-stat-label">ROI (Return on Investment)</div>
                    </div>
                </div>
            </div>

            <div class="kloter-grid">
                <!-- Revenue detail cards -->
                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">Kloter Arisan A</h3>
                        </div>
                        <span class="kloter-status status-verified">Selesai</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Total Setoran:</span>
                            <span class="kloter-info-value amount-value">Rp 6.000.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Pendapatan:</span>
                            <span class="kloter-info-value amount-value">Rp 10.000.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Keuntungan:</span>
                            <span class="kloter-info-value amount-value">Rp 4.000.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Tanggal Menang:</span>
                            <span class="kloter-info-value">15 Jun 2024</span>
                        </div>
                    </div>
                </div>

                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">Kloter Arisan D</h3>
                        </div>
                        <span class="kloter-status status-pending">Berjalan</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Total Setoran:</span>
                            <span class="kloter-info-value amount-value">Rp 2.400.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Potensi Pendapatan:</span>
                            <span class="kloter-info-value amount-value">Rp 7.200.000</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Status:</span>
                            <span class="kloter-info-value">Belum Menang</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Bulan ke:</span>
                            <span class="kloter-info-value">8 dari 24</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Sample data
        const sampleData = {
            terverifikasi: [
                {
                    nama: "Kloter Arisan A",
                    status: "Terverifikasi",
                    statusClass: "status-verified",
                    anggota: 20,
                    iuran: "Rp 500.000",
                    statusBayar: "Lunas",
                    statusBayarClass: "status-paid",
                    tanggal: "15 Jan 2024"
                },
                {
                    nama: "Kloter Arisan E",
                    status: "Terverifikasi",
                    statusClass: "status-verified",
                    anggota: 25,
                    iuran: "Rp 750.000",
                    statusBayar: "Lunas",
                    statusBayarClass: "status-paid",
                    tanggal: "10 Feb 2024"
                }
            ],
            ditolak: [
                {
                    nama: "Kloter Arisan C",
                    status: "Ditolak",
                    statusClass: "status-rejected",
                    anggota: 10,
                    iuran: "Rp 200.000",
                    statusBayar: "Menunggak",
                    statusBayarClass: "status-overdue",
                    tanggal: "20 Mar 2024"
                }
            ],
            kloterDiikuti: [
                {
                    nama: "Kloter Arisan A",
                    status: "Aktif",
                    statusClass: "status-verified",
                    anggota: 20,
                    iuran: "Rp 500.000",
                    statusBayar: "Lunas",
                    statusBayarClass: "status-paid",
                    tanggal: "15 Jan 2024"
                },
                {
                    nama: "Kloter Arisan B",
                    status: "Aktif",
                    statusClass: "status-pending",
                    anggota: 15,
                    iuran: "Rp 300.000",
                    statusBayar: "Belum Bayar",
                    statusBayarClass: "status-unpaid",
                    tanggal: "02 Feb 2024"
                }
            ],
            sudahBayar: [
                {
                    nama: "Kloter Arisan A",
                    status: "Lunas",
                    statusClass: "status-paid",
                    anggota: 20,
                    iuran: "Rp 500.000",
                    statusBayar: "Lunas",
                    statusBayarClass: "status-paid",
                    tanggal: "15 Jan 2024"
                }
            ],
            belumBayar: [
                {
                    nama: "Kloter Arisan B",
                    status: "Belum Bayar",
                    statusClass: "status-unpaid",
                    anggota: 15,
                    iuran: "Rp 300.000",
                    statusBayar: "Belum Bayar",
                    statusBayarClass: "status-unpaid",
                    tanggal: "02 Feb 2024"
                }
            ],
            menunggak: [
                {
                    nama: "Kloter Arisan C",
                    status: "Menunggak",
                    statusClass: "status-overdue",
                    anggota: 10,
                    iuran: "Rp 200.000",
                    statusBayar: "Menunggak",
                    statusBayarClass: "status-overdue",
                    tanggal: "20 Mar 2024"
                }
            ],
            pembayaranDitolak: [
                {
                    nama: "Kloter Arisan F",
                    status: "Pembayaran Ditolak",
                    statusClass: "status-rejected",
                    anggota: 12,
                    iuran: "Rp 400.000",
                    statusBayar: "Ditolak Admin",
                    statusBayarClass: "status-rejected",
                    tanggal: "05 Apr 2024"
                }
            ]
        };

        function createKloterCard(kloter) {
            return `
                <div class="kloter-card">
                    <div class="kloter-header">
                        <div>
                            <h3 class="kloter-name">${kloter.nama}</h3>
                        </div>
                        <span class="kloter-status ${kloter.statusClass}">${kloter.status}</span>
                    </div>
                    <div class="kloter-info">
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Jumlah Anggota:</span>
                            <span class="kloter-info-value">${kloter.anggota}</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Iuran Bulanan:</span>
                            <span class="kloter-info-value amount-value">${kloter.iuran}</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Status Pembayaran:</span>
                            <span class="kloter-status ${kloter.statusBayarClass}">${kloter.statusBayar}</span>
                        </div>
                        <div class="kloter-info-item">
                            <span class="kloter-info-label">Tanggal Bergabung:</span>
                            <span class="kloter-info-value">${kloter.tanggal}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        function showCategory(category) {
            // Remove active class from all category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active');
            
            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Hide all sub category navs
            document.querySelectorAll('.sub-category-nav').forEach(nav => {
                nav.classList.remove('active');
            });

            // Show appropriate content
            if (category === 'overview') {
                document.getElementById('overview-content').classList.add('active');
            } else if (category === 'verifikasi') {
                document.getElementById('sub-verifikasi').classList.add('active');
                document.getElementById('verifikasi-content').classList.add('active');
                showSubCategory('verifikasi', 'terverifikasi');
            } else if (category === 'kloter-diikuti') {
                document.getElementById('kloter-diikuti-content').classList.add('active');
                loadKloterDiikuti();
            } else if (category === 'pembayaran') {
                document.getElementById('sub-pembayaran').classList.add('active');
                document.getElementById('pembayaran-content').classList.add('active');
                showSubCategory('pembayaran', 'sudah-bayar');
            } else if (category === 'pendapatan') {
                document.getElementById('pendapatan-content').classList.add('active');
            }
        }

        function showSubCategory(mainCategory, subCategory) {
            // Remove active class from sub category buttons
            document.querySelectorAll(`#sub-${mainCategory} .sub-category-btn`).forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active');

            if (mainCategory === 'verifikasi') {
                // Hide all verifikasi sub contents
                document.getElementById('verifikasi-terverifikasi').style.display = 'none';
                document.getElementById('verifikasi-ditolak').style.display = 'none';
                
                if (subCategory === 'terverifikasi') {
                    document.getElementById('verifikasi-terverifikasi').style.display = 'grid';
                    loadVerifikasiData('terverifikasi');
                } else if (subCategory === 'ditolak') {
                    document.getElementById('verifikasi-ditolak').style.display = 'grid';
                    loadVerifikasiData('ditolak');
                }
            } else if (mainCategory === 'pembayaran') {
                // Hide all pembayaran sub contents
                document.getElementById('pembayaran-sudah-bayar').style.display = 'none';
                document.getElementById('pembayaran-belum-bayar').style.display = 'none';
                document.getElementById('pembayaran-menunggak').style.display = 'none';
                document.getElementById('pembayaran-pembayaran-ditolak').style.display = 'none';
                
                if (subCategory === 'sudah-bayar') {
                    document.getElementById('pembayaran-sudah-bayar').style.display = 'grid';
                    loadPembayaranData('sudahBayar');
                } else if (subCategory === 'belum-bayar') {
                    document.getElementById('pembayaran-belum-bayar').style.display = 'grid';
                    loadPembayaranData('belumBayar');
                } else if (subCategory === 'menunggak') {
                    document.getElementById('pembayaran-menunggak').style.display = 'grid';
                    loadPembayaranData('menunggak');
                } else if (subCategory === 'pembayaran-ditolak') {
                    document.getElementById('pembayaran-pembayaran-ditolak').style.display = 'grid';
                    loadPembayaranData('pembayaranDitolak');
                }
            }
        }

        function loadVerifikasiData(type) {
            const container = document.getElementById(`verifikasi-${type}`);
            const data = sampleData[type];
            
            if (data && data.length > 0) {
                container.innerHTML = data.map(kloter => createKloterCard(kloter)).join('');
            } else {
                container.innerHTML = `
                    <div class="empty-state">
                        <h3>📋 Tidak Ada Data</h3>
                        <p>Belum ada kloter dengan status ${type === 'terverifikasi' ? 'terverifikasi' : 'ditolak'}.</p>
                    </div>
                `;
            }
        }

        function loadKloterDiikuti() {
            const container = document.querySelector('#kloter-diikuti-content .kloter-grid');
            const data = sampleData.kloterDiikuti;
            
            if (data && data.length > 0) {
                container.innerHTML = data.map(kloter => createKloterCard(kloter)).join('');
            } else {
                container.innerHTML = `
                    <div class="empty-state">
                        <h3>👥 Tidak Ada Kloter</h3>
                        <p>Anda belum mengikuti kloter apapun.</p>
                    </div>
                `;
            }
        }

        function loadPembayaranData(type) {
            const container = document.getElementById(`pembayaran-${type.replace(/([A-Z])/g, '-$1').toLowerCase()}`);
            const data = sampleData[type];
            
            if (data && data.length > 0) {
                container.innerHTML = data.map(kloter => createKloterCard(kloter)).join('');
            } else {
                container.innerHTML = `
                    <div class="empty-state">
                        <h3>💳 Tidak Ada Data</h3>
                        <p>Tidak ada kloter dengan status pembayaran ini.</p>
                    </div>
                `;
            }
        }

        // Back to top functionality
        const backToTop = document.getElementById('backToTop');

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Scroll indicator
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.querySelector('.scroll-indicator').style.width = scrolled + '%';
        });

        // Keyboard accessibility for back to top
        backToTop.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        // Initialize with overview active
        document.addEventListener('DOMContentLoaded', () => {
            // Set default active state
            document.querySelector('.category-btn').classList.add('active');
        });
    </script>
</body>
</html>