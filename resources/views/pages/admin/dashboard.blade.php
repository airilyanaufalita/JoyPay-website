<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        /* Center page content */
        .top-bar, .content-card {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @extends('pages.admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@endsection

            <!-- Main Content -->
            <div class="col-md-20 col-lg-21">
                <div class="main-content">
                    <!-- Top Bar -->
                    <div class="top-bar d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Dashboard</h4>
                            <small class="text-muted">Selamat datang di panel administrasi</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="fas fa-clock me-1"></i>
                                {{ now()->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stats-number">1,234</div>
                                <div class="stats-label">Total Pengguna</div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-success">
                                    <i class="fas fa-list-alt"></i>
                                </div>
                                <div class="stats-number">56</div>
                                <div class="stats-label">Kloter Aktif</div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stats-number">23</div>
                                <div class="stats-label">Menunggu Konfirmasi</div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-info">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="stats-number">Rp 2.5M</div>
                                <div class="stats-label">Total Transaksi</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="recent-activity">
                        <h5 class="mb-3">
                            <i class="fas fa-history me-2"></i>
                            Aktivitas Terbaru
                        </h5>
                        
                        <div class="activity-item d-flex align-items-center">
                            <div class="activity-icon bg-success text-white">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Pendaftaran Baru</div>
                                <small class="text-muted">Sari Indah mendaftar sebagai anggota baru</small>
                            </div>
                            <small class="text-muted ms-auto">2 jam yang lalu</small>
                        </div>
                        
                        <div class="activity-item d-flex align-items-center">
                            <div class="activity-icon bg-primary text-white">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Pembayaran Dikonfirmasi</div>
                                <small class="text-muted">Budi Santoso melakukan pembayaran kloter A</small>
                            </div>
                            <small class="text-muted ms-auto">4 jam yang lalu</small>
                        </div>
                        
                        <div class="activity-item d-flex align-items-center">
                            <div class="activity-icon bg-warning text-white">
                                <i class="fas fa-random"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Undian Kloter B</div>
                                <small class="text-muted">Undian kloter B selesai, pemenang: Maya Sari</small>
                            </div>
                            <small class="text-muted ms-auto">6 jam yang lalu</small>
                        </div>
                        
                        <div class="activity-item d-flex align-items-center">
                            <div class="activity-icon bg-info text-white">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Kloter Baru Dibuat</div>
                                <small class="text-muted">Kloter C - 24 Bulan dengan nominal Rp 2.000.000</small>
                            </div>
                            <small class="text-muted ms-auto">1 hari yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

