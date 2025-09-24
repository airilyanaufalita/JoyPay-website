<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Testimoni - Admin Dashboard</title>
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
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .action-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            margin: 0 2px;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        
        .search-box {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        
        .filter-dropdown {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
        }
        
        .testimoni-card {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .testimoni-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .testimoni-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .testimoni-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #007bff, #0056b3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .testimoni-content {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            font-style: italic;
            border-left: 4px solid #007bff;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        @extends('pages.admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@endsection
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0">
                            <i class="fas fa-comments me-2 text-primary"></i>
                            Manajemen Testimoni
                        </h4>
                        <small class="text-muted">Kelola testimoni dari peserta arisan</small>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Search and Filter -->
            <div class="content-card">
                <form method="GET" action="{{ route('admin.testimoni') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control search-box border-start-0" 
                                       placeholder="Cari testimoni..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select filter-dropdown">
                                <option value="">Semua Status</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="content-card text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-check text-success fs-4"></i>
                        </div>
                        <h3 class="mb-1 text-success">{{ $statistics['approved'] }}</h3>
                        <p class="text-muted mb-0">Disetujui</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-card text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock text-warning fs-4"></i>
                        </div>
                        <h3 class="mb-1 text-warning">{{ $statistics['pending'] }}</h3>
                        <p class="text-muted mb-0">Menunggu Persetujuan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content-card text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-comments text-info fs-4"></i>
                        </div>
                        <h3 class="mb-1 text-info">{{ $statistics['total'] }}</h3>
                        <p class="text-muted mb-0">Total Testimoni</p>
                    </div>
                </div>
            </div>
            
            <!-- Testimonials List -->
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2 text-primary"></i>
                        Daftar Testimoni
                    </h5>
                </div>
                
                <!-- Testimoni Cards -->
                <div class="row">
                    @forelse($testimonis as $testimoni)
                    <div class="col-md-6">
                        <div class="testimoni-card">
                            <div class="testimoni-header">
                                <div class="testimoni-author">
                                    <div class="author-avatar">
                                        {{ strtoupper(substr($testimoni->nama, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $testimoni->nama }}</h6>
                                        <small class="text-muted">{{ $testimoni->pekerjaan }}</small>
                                        @if($testimoni->user)
                                        <br><small class="text-info">ID User: {{ $testimoni->user->id }}</small>
                                        @endif
                                    </div>
                                </div>
                                <span class="status-badge {{ $testimoni->is_approved ? 'status-approved' : 'status-pending' }}">
                                    {{ $testimoni->is_approved ? 'Disetujui' : 'Menunggu Persetujuan' }}
                                </span>
                            </div>
                            
                            <div class="testimoni-content">
                                "{{ $testimoni->testimoni }}"
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $testimoni->created_at->format('d M Y, H:i') }}</small>
                                <div class="btn-group" role="group">
                                    @if(!$testimoni->is_approved)
                                    <form action="{{ route('admin.testimoni.approve', $testimoni->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-approve" title="Setujui Testimoni"
                                                onclick="return confirm('Apakah Anda yakin ingin menyetujui testimoni ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.testimoni.destroy', $testimoni->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Hapus Testimoni"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-comments fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada testimoni</h5>
                            <p class="text-muted">Testimoni dari peserta akan muncul di sini</p>
                        </div>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($testimonis->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $testimonis->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>