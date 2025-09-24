<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kloter Aktif - Admin Arisan Barokah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .top-bar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            margin-bottom: 25px;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: none;
            transition: all 0.3s ease;
        }
        
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stats-card.primary { border-left-color: #667eea; }
        .stats-card.success { border-left-color: #28a745; }
        .stats-card.warning { border-left-color: #ffc107; }
        .stats-card.danger { border-left-color: #dc3545; }
        .stats-card.info { border-left-color: #17a2b8; }
        
        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }
        
        .btn-action {
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin: 0 2px;
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .table th {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #e9ecef;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9ff;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-open { background: #d4edda; color: #155724; }
        .status-full { background: #fff3cd; color: #856404; }
        .status-running { background: #cce5ff; color: #004085; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-draft { background: #e2e3e5; color: #383d41; }
        
        .search-filter-bar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .progress-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }
        
        .member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            margin-right: 5px;
        }
        
        .pagination-wrapper {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: #667eea;
            font-weight: 600;
        }
        
        .page-link:hover, .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
            
            .btn-action {
                padding: 6px 8px;
                font-size: 0.75rem;
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
            <h5>Memproses...</h5>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <div class="main-content animate-fade-in">
                    <!-- Top Bar -->
                    <div class="top-bar">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-1"><i class="fas fa-cogs me-2"></i>Kelola Kloter Aktif</h3>
                                <p class="mb-0 opacity-75">Manage dan monitor semua kloter arisan yang sedang berjalan</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-light me-3" onclick="refreshData()">
                                    <i class="fas fa-sync-alt me-1"></i>Refresh
                                </button>
                                <span class="opacity-75">
                                    <i class="fas fa-clock me-1"></i>
                                    <span id="currentTime"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Overview -->
                    <div class="stats-grid">
                        <div class="stats-card primary">
                            <i class="fas fa-layer-group stats-icon text-primary"></i>
                            <h3 class="fw-bold mb-1">{{ $totalKloters }}</h3>
                            <p class="text-muted mb-0">Total Kloter</p>
                        </div>
                        <div class="stats-card success">
                            <i class="fas fa-play-circle stats-icon text-success"></i>
                            <h3 class="fw-bold mb-1">{{ $activeKloters }}</h3>
                            <p class="text-muted mb-0">Kloter Aktif</p>
                        </div>
                        <div class="stats-card warning">
                            <i class="fas fa-users stats-icon text-warning"></i>
                            <h3 class="fw-bold mb-1">{{ $fullKloters }}</h3>
                            <p class="text-muted mb-0">Kloter Penuh</p>
                        </div>
                        <div class="stats-card info">
                            <i class="fas fa-money-bill-wave stats-icon text-info"></i>
                            <h3 class="fw-bold mb-1">{{ number_format($totalValue, 1) }}M</h3>
                            <p class="text-muted mb-0">Total Nilai (Juta)</p>
                        </div>
                    </div>
                    
                    <!-- Search & Filter Bar -->
                    <div class="search-filter-bar">
                        <form method="GET" action="{{ route('admin.kelola-kloter-aktif') }}">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Cari kloter..." name="search" value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Aktif</option>
                                        <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Penuh</option>
                                        <option value="running" {{ request('status') == 'running' ? 'selected' : '' }}>Berjalan</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="category">
                                        <option value="">Semua Kategori</option>
                                        <option value="bulanan" {{ request('category') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="mingguan" {{ request('category') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="sort">
                                        <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>Terlama</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                        <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Nominal Tertinggi</option>
                                        <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Nominal Terendah</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.buat-kloter') }}" class="btn btn-gradient">
                                            <i class="fas fa-plus me-1"></i>Buat Kloter
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>Nama Kloter</th>
                                        <th>Nominal/Anggota</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Periode</th>
                                        <th>Pemenang Terakhir</th>
                                        <th>Dibuat</th>
                                        <th width="200">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kloterTableBody">
                                    @forelse($kloters as $kloter)
                                    <tr data-id="{{ $kloter->id }}" data-status="{{ $kloter->status }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input row-select" value="{{ $kloter->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <h6 class="mb-0">{{ $kloter->name }}</h6>
                                                    <small class="text-muted">{{ ucfirst($kloter->category) }} • {{ $kloter->duration_value }} {{ $kloter->duration_unit }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="fw-bold text-primary">Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</div>
                                                <small class="text-muted">per anggota</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress-circle 
                                                    @if($kloter->status == 'completed') bg-success 
                                                    @elseif($kloter->status == 'running') bg-info 
                                                    @elseif($kloter->status == 'full') bg-warning 
                                                    @else bg-primary 
                                                    @endif text-white me-2">
                                                    {{ $kloter->filled_slots }}/{{ $kloter->total_slots }}
                                                </div>
                                                <div>
                                                    <div class="progress" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar 
                                                            @if($kloter->status == 'completed') bg-success 
                                                            @elseif($kloter->status == 'running') bg-info 
                                                            @elseif($kloter->status == 'full') bg-warning 
                                                            @else bg-primary 
                                                            @endif" 
                                                            style="width: {{ $kloter->progress_percentage }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $kloter->progress_percentage }}%</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $kloter->status }}">{{ ucfirst($kloter->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="fw-bold">{{ $kloter->current_period }}/{{ $kloter->total_slots }}</div>
                                                <small class="text-muted">periode</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                @php
                                                    $lastWinner = $kloter->members->where('is_winner', true)->last();
                                                @endphp
                                                @if($lastWinner)
                                                    <span class="text-success">
                                                        <i class="fas fa-crown me-1"></i>
                                                        {{ $lastWinner->user->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Belum ada
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $kloter->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-info btn-action" onclick="viewDetails({{ $kloter->id }})" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-primary btn-action" onclick="editKloter({{ $kloter->id }})" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if($kloter->status == 'draft')
                                                <button class="btn btn-success btn-action" onclick="publishKloter({{ $kloter->id }})" title="Publikasikan">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                                @endif
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary btn-action dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="duplicateKloter({{ $kloter->id }})"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{ $kloter->id }})"><i class="fas fa-power-off me-2"></i>Ubah Status</a></li>
                                                        @if($kloter->status == 'running')
                                                        <li><a class="dropdown-item" href="#" onclick="manageLottery({{ $kloter->id }})"><i class="fas fa-random me-2"></i>Kelola Undian</a></li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteKloter({{ $kloter->id }})"><i class="fas fa-trash me-2"></i>Hapus</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                <p>Belum ada kloter yang dibuat</p>
                                                <a href="{{ route('admin.buat-kloter') }}" class="btn btn-gradient">
                                                    <i class="fas fa-plus me-1"></i>Buat Kloter Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($kloters->hasPages())
                    <div class="pagination-wrapper">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $kloters->firstItem() }}-{{ $kloters->lastItem() }} dari {{ $kloters->total() }} kloter
                                </small>
                            </div>
                            <nav>
                                {{ $kloters->appends(request()->query())->links() }}
                            </nav>
                            <div>
                                <select class="form-select form-select-sm" style="width: auto;" onchange="changePageSize(this)">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Bulk Actions Bar (Hidden by default) -->
                    <div class="content-card" id="bulkActionsBar" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold" id="selectedCount">0 kloter dipilih</span>
                            </div>
                            <div>
                                <button class="btn btn-warning me-2" onclick="bulkChangeStatus()">
                                    <i class="fas fa-power-off me-1"></i>Ubah Status
                                </button>
                                <button class="btn btn-danger" onclick="bulkDelete()">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Detail Kloter Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-list-alt me-2"></i>
                        Detail Kloter Arisan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="editFromDetail()">
                        <i class="fas fa-edit me-1"></i>Edit Kloter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script>
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let selectedRows = [];
        let currentKloterId = null;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentTime();
            setInterval(updateCurrentTime, 1000);
            
            // Initialize select all functionality
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.row-select');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                    toggleRowSelection(checkbox);
                });
            });

            // Initialize individual checkboxes
            document.querySelectorAll('.row-select').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    toggleRowSelection(this);
                });
            });
        });

        function updateCurrentTime() {
            const now = new Date();
            const options = {
                year: 'numeric', month: '2-digit', day: '2-digit',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                timeZone: 'Asia/Jakarta'
            };
            document.getElementById('currentTime').textContent = now.toLocaleString('id-ID', options);
        }

        function toggleRowSelection(checkbox) {
            const id = checkbox.value;
            if (checkbox.checked) {
                if (!selectedRows.includes(id)) {
                    selectedRows.push(id);
                }
            } else {
                selectedRows = selectedRows.filter(rowId => rowId !== id);
            }
            updateBulkActionsBar();
        }

        function updateBulkActionsBar() {
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectedCount = document.getElementById('selectedCount');
            
            if (selectedRows.length > 0) {
                bulkActionsBar.style.display = 'block';
                selectedCount.textContent = `${selectedRows.length} kloter dipilih`;
            } else {
                bulkActionsBar.style.display = 'none';
            }
        }

        // CRUD Functions
        function viewDetails(id) {
            showLoading();
            
            fetch(`{{ url('/admin/kloters') }}/${id}/detail`)
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        displayKloterDetail(data.data);
                        new bootstrap.Modal(document.getElementById('detailModal')).show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat memuat detail kloter', 'error');
                });
        }

        function displayKloterDetail(kloter) {
            const detailBody = document.getElementById('detailModalBody');
            const lastWinner = kloter.last_winner || 'Belum ada';
            
            detailBody.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="content-card">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-1"></i>Informasi Kloter
                            </h6>
                            <table class="table table-borderless mb-0">
                                <tr><td class="fw-bold text-muted">Nama Kloter:</td><td>${kloter.name}</td></tr>
                                <tr><td class="fw-bold text-muted">Nominal:</td><td>Rp ${new Intl.NumberFormat('id-ID').format(kloter.nominal)}</td></tr>
                                <tr><td class="fw-bold text-muted">Status:</td><td><span class="status-badge status-${kloter.status}">${kloter.status.toUpperCase()}</span></td></tr>
                                <tr><td class="fw-bold text-muted">Kategori:</td><td>${kloter.category.charAt(0).toUpperCase() + kloter.category.slice(1)}</td></tr>
                                <tr><td class="fw-bold text-muted">Dibuat:</td><td>${new Date(kloter.created_at).toLocaleDateString('id-ID')}</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-card">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-chart-bar me-1"></i>Statistik
                            </h6>
                            <table class="table table-borderless mb-0">
                                <tr><td class="fw-bold text-muted">Total Anggota:</td><td>${kloter.total_slots}</td></tr>
                                <tr><td class="fw-bold text-muted">Anggota Terdaftar:</td><td>${kloter.filled_slots}</td></tr>
                                <tr><td class="fw-bold text-muted">Progress:</td><td>${kloter.progress_percentage}%</td></tr>
                                <tr><td class="fw-bold text-muted">Periode:</td><td>${kloter.current_period}/${kloter.total_slots}</td></tr>
                                <tr><td class="fw-bold text-muted">Pemenang Terakhir:</td><td>${lastWinner}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-primary mb-0">
                            <i class="fas fa-users me-1"></i>Daftar Anggota (${kloter.members.length})
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Slot</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${kloter.members.map(member => `
                                    <tr>
                                        <td><span class="badge bg-primary">${member.slot_number}</span></td>
                                        <td>${member.name}</td>
                                        <td>${member.email}</td>
                                        <td><span class="badge bg-success">${member.status}</span></td>
                                        <td><span class="badge bg-${member.payment_status === 'paid' ? 'success' : 'warning'}">${member.payment_status}</span></td>
                                        <td>${new Date(member.joined_at).toLocaleDateString('id-ID')}</td>
                                    </tr>
                                `).join('')}
                                ${kloter.members.length === 0 ? '<tr><td colspan="6" class="text-center text-muted">Belum ada anggota</td></tr>' : ''}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            currentKloterId = kloter.id;
        }

        function editKloter(id) {
            window.location.href = `/admin/kloters/${id}/edit-page`;
            showLoading();
            
            fetch(`{{ url('/admin/kloters') }}/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        populateEditForm(data.data);
                        new bootstrap.Modal(document.getElementById('kloterModal')).show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat memuat data kloter', 'error');
                });
        }

        function populateEditForm(kloter) {
            document.getElementById('kloterId').value = kloter.id;
            document.getElementById('editName').value = kloter.name;
            document.getElementById('editCategory').value = kloter.category;
            document.getElementById('editNominal').value = kloter.nominal;
            document.getElementById('editTotalSlots').value = kloter.total_slots;
            document.getElementById('editDurationValue').value = kloter.duration_value;
            document.getElementById('editDurationUnit').value = kloter.duration_unit;
            document.getElementById('editStatus').value = kloter.status;
            document.getElementById('editAdminFeePercentage').value = kloter.admin_fee_percentage || '';
            document.getElementById('editPaymentMethod').value = kloter.payment_method || 'Transfer Bank';
            document.getElementById('editDescription').value = kloter.description || '';
            currentKloterId = kloter.id;
        }

        function saveKloter() {
            const form = document.getElementById('kloterForm');
            const formData = new FormData(form);
            const id = document.getElementById('kloterId').value;
            
            showLoading();
            
            fetch(`{{ url('/admin/kloters') }}/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('kloterModal')).hide();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan kloter', 'error');
            });
        }

        function deleteKloter(id) {
            Swal.fire({
                title: 'Hapus Kloter?',
                text: 'Kloter dan semua datanya akan dihapus permanen! Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    
                    fetch(`{{ url('/admin/kloters') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus kloter', 'error');
                    });
                }
            });
        }

        function duplicateKloter(id) {
            Swal.fire({
                title: 'Duplikasi Kloter?',
                text: 'Akan membuat salinan baru dari kloter ini.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Duplikasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    
                    fetch(`{{ url('/admin/kloters') }}/${id}/duplicate`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat menduplikasi kloter', 'error');
                    });
                }
            });
        }

        function changeStatus(id) {
            Swal.fire({
                title: 'Ubah Status Kloter?',
                input: 'select',
                inputOptions: {
                    'open': 'Aktif',
                    'full': 'Penuh',
                    'running': 'Berjalan',
                    'completed': 'Selesai',
                    'cancelled': 'Dibatalkan',
                    'draft': 'Draft'
                },
                inputPlaceholder: 'Pilih status baru',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ubah Status',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    showLoading();
                    
                    fetch(`{{ url('/admin/kloters') }}/${id}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ status: result.value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat mengubah status', 'error');
                    });
                }
            });
        }

        function publishKloter(id) {
            changeStatus(id); // Reuse change status function
        }

        function manageLottery(id) {
            Swal.fire({
                title: 'Kelola Undian',
                text: 'Fitur kelola undian sedang dalam pengembangan.',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        }

        // Bulk Actions
        function bulkChangeStatus() {
            if (selectedRows.length === 0) {
                Swal.fire('Peringatan', 'Pilih kloter terlebih dahulu', 'warning');
                return;
            }

            Swal.fire({
                title: 'Ubah Status Massal?',
                input: 'select',
                inputOptions: {
                    'open': 'Aktif',
                    'full': 'Penuh',
                    'running': 'Berjalan',
                    'completed': 'Selesai',
                    'cancelled': 'Dibatalkan',
                    'draft': 'Draft'
                },
                inputPlaceholder: 'Pilih status baru',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ubah Status',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    showLoading();
                    
                    // Process each selected item
                    const promises = selectedRows.map(id => 
                        fetch(`{{ url('/admin/kloters') }}/${id}/status`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ status: result.value })
                        })
                    );
                    
                    Promise.all(promises)
                        .then(() => {
                            hideLoading();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: `Status ${selectedRows.length} kloter berhasil diubah`,
                                icon: 'success',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan saat mengubah status', 'error');
                        });
                }
            });
        }


        function bulkDelete() {
            if (selectedRows.length === 0) {
                Swal.fire('Peringatan', 'Pilih kloter terlebih dahulu', 'warning');
                return;
            }

            Swal.fire({
                title: 'Hapus Kloter Terpilih?',
                text: `${selectedRows.length} kloter dan semua datanya akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    
                    const promises = selectedRows.map(id => 
                        fetch(`{{ url('/admin/kloters') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            }
                        })
                    );
                    
                    Promise.all(promises)
                        .then(() => {
                            hideLoading();
                            Swal.fire({
                                title: 'Terhapus!',
                                text: `${selectedRows.length} kloter berhasil dihapus`,
                                icon: 'success',
                                confirmButtonColor: '#667eea'
                            }).then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error:', error);
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus kloter', 'error');
                        });
                }
            });
        }



        function refreshData() {
            showLoading();
            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        function editFromDetail() {
            bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
            editKloter(currentKloterId);
        }

        function changePageSize(select) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', select.value);
            window.location.href = url.toString();
        }

        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('show');
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('show');
        }

        // Show success/error messages from session
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#667eea'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        @endif
    </script>
</body>
</html>