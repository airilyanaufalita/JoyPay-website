<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        
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
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        /* Center page content */
        .top-bar, .filter-section, .content-card {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
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
                            <h4 class="mb-0">Konfirmasi Pembayaran</h4>
                            <small class="text-muted">Kelola dan konfirmasi pembayaran arisan</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-3">
                                <i class="fas fa-clock me-1"></i>
                                {{ $users->count() ?? 0 }} Total Pengguna
                            </span>
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $users->where('status', 'pending')->count() ?? 0 }} Menunggu Konfirmasi
                            </span>
                        </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Menunggu Konfirmasi</option>
                                    <option value="confirmed">Dikonfirmasi</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Periode</label>
                                <select class="form-select">
                                    <option value="">Semua Periode</option>
                                    <option value="today">Hari Ini</option>
                                    <option value="week">Minggu Ini</option>
                                    <option value="month">Bulan Ini</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Cari</label>
                                <input type="text" class="form-control" placeholder="Nama member atau ID transaksi...">
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-search me-1"></i>
                                    Filter
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment List -->
                    <div class="content-card">
                        <h5 class="mb-4">
                            <i class="fas fa-list me-2"></i>
                            Daftar Pembayaran
                        </h5>
                        
                        @forelse($users ?? [] as $user)
                        <div class="payment-card">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->name ?? 'Nama User' }}</h6>
                                            <small class="text-muted">{{ $user->email ?? 'email@example.com' }}</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div>
                                        <p class="mb-1 fw-bold">Arisan Keluarga Besar</p>
                                        <p class="mb-0 text-muted small">ID: TRX{{ $user->id ?? '001' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <h5 class="mb-0 text-success fw-bold">Rp 500.000</h5>
                                    <small class="text-muted">30 Agustus 2025</small>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <p class="mb-1 fw-bold">Transfer Bank BCA</p>
                                    <small class="text-muted">Agustus 2025</small>
                                </div>
                                
                                <div class="col-md-2 text-center">
                                    <span class="status-badge status-pending">
                                        Menunggu Konfirmasi
                                    </span>
                                </div>
                                
                                <div class="col-md-1">
                                    <div class="btn-group-vertical">
                                        <button class="btn btn-success btn-sm mb-1" title="Konfirmasi">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pembayaran</h5>
                            <p class="text-muted">Semua pembayaran telah dikonfirmasi atau belum ada yang masuk.</p>
                        </div>
                        @endforelse
                        
                        @if(($users ?? collect())->count() > 0)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>