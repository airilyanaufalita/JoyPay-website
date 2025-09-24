<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal & Pembayaran - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        
        .sidebar {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #404040;
        }
        
        .sidebar-menu { padding: 20px 0; }
        
        .sidebar-menu .nav-link {
            color: #b0b0b0;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: rgba(220, 53, 69, 0.2);
            border-left: 4px solid #dc3545;
        }
        
        .sidebar-menu .nav-link i {
            margin-right: 10px;
            width: 20px;
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
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 10px;
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        .calendar-container {
            min-height: 600px;
        }
        
        .fc-event {
            border-radius: 8px;
            border: none;
            padding: 2px 5px;
        }
        
        .fc-event-payment {
            background: #28a745;
            color: white;
        }
        
        .fc-event-lottery {
            background: #ffc107;
            color: #212529;
        }
        
        .fc-event-reminder {
            background: #17a2b8;
            color: white;
        }
        
        .fc-event-overdue {
            background: #dc3545;
            color: white;
        }
        
        .schedule-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 1.5rem;
            color: white;
        }
        
        .summary-number {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .summary-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .payment-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .payment-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .payment-item:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .payment-info {
            display: flex;
            align-items: center;
        }
        
        .payment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 15px;
        }
        
        .payment-details h6 {
            margin: 0;
            color: #2c3e50;
        }
        
        .payment-details small {
            color: #6c757d;
        }
        
        .payment-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        
        .tab-content {
            margin-top: 20px;
        }
        
        .nav-tabs .nav-link {
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
            color: #6c757d;
            font-weight: 600;
        }
        
        .nav-tabs .nav-link.active {
            background: white;
            color: #495057;
        }
        
        /* Center page content */
        .top-bar, .content-card, .schedule-summary, .filter-section {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
        }
        
        .btn-action {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin: 0 2px;
        }
        
        .reminder-section {
            border-left: 4px solid #17a2b8;
            padding-left: 15px;
        }
        
        .upcoming-events {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 25px;
        }
        
        .event-item {
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .event-item:last-child {
            border-bottom: none;
        }
        
        .event-date {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .event-description {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .filter-tabs {
            margin-bottom: 20px;
        }
        
        .filter-tabs .nav-link {
            border-radius: 20px;
            margin-right: 10px;
            color: #6c757d;
            font-weight: 600;
            padding: 8px 20px;
        }
        
        .filter-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-shield me-2"></i>
                            Admin Panel
                        </h5>
                        <small class="text-muted">Arisan Barokah</small>
                    </div>
                    
                    <div class="sidebar-menu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.konfirmasi-pendaftaran') }}">
                                    <i class="fas fa-user-check"></i>
                                    Konfirmasi Pendaftaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.manajemen-user') }}">
                                    <i class="fas fa-users"></i>
                                    Manajemen Pengguna
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.buat-kloter') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    Buat Kloter
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.arisan-aktif') }}">
                                    <i class="fas fa-list-alt"></i>
                                    Daftar Arisan Aktif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.konfirmasi-masuk-kloter') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Konfirmasi Masuk Kloter
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.konfirmasi-pembayaran') }}">
                                    <i class="fas fa-check-circle"></i>
                                    Konfirmasi Pembayaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.jadwal-pembayaran') }}">
                                    <i class="fas fa-calendar-alt"></i>
                                    Jadwal & Pembayaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.testimoni') }}">
                                    <i class="fas fa-comments"></i>
                                    Manajemen Testimoni
                                </a>
                            </li>
                        </ul>
                        
                        <div class="mt-4 px-3">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="logout-btn w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-20 col-lg-21">
                <div class="main-content">
                    <!-- Top Bar -->
                    <div class="top-bar d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Jadwal & Pembayaran</h4>
                            <small class="text-muted">Kelola jadwal pembayaran dan undian arisan</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-3" onclick="createReminder()">
                                <i class="fas fa-bell-plus me-1"></i>
                                Buat Pengingat
                            </button>
                            <span class="me-3">
                                <i class="fas fa-clock me-1"></i>
                                {{ now()->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Summary Cards -->
                    <div class="schedule-summary">
                        <div class="summary-card">
                            <div class="summary-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="summary-number">{{ $pendingPayments ?? 0 }}</div>
                            <div class="summary-label">Pembayaran Tertunda</div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="summary-icon bg-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="summary-number">{{ $overduePayments ?? 0 }}</div>
                            <div class="summary-label">Terlambat Bayar</div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="summary-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="summary-number">{{ $paidToday ?? 0 }}</div>
                            <div class="summary-label">Lunas Hari Ini</div>
                        </div>
                        
                        <div class="summary-card">
                            <div class="summary-icon bg-info">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="summary-number">{{ $upcomingLotteries ?? 0 }}</div>
                            <div class="summary-label">Undian Mendatang</div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Calendar Section -->
                        <div class="col-lg-8">
                            <div class="content-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Kalender Jadwal
                                    </h5>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-success">Pembayaran</span>
                                        <span class="badge bg-warning text-dark">Undian</span>
                                        <span class="badge bg-info">Pengingat</span>
                                        <span class="badge bg-danger">Terlambat</span>
                                    </div>
                                </div>
                                
                                <div class="calendar-container" id="calendar"></div>
                            </div>
                        </div>
                        
                        <!-- Upcoming Events & Reminders -->
                        
   
                    
                    <!-- Payment Management Tabs -->
                    <div class="content-card">
                        <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button">
                                    <i class="fas fa-clock me-1"></i>
                                    Tertunda ({{ $pendingPayments ?? 0 }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue" type="button">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Terlambat ({{ $overduePayments ?? 0 }})
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Lunas
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Atur Jadwal
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="paymentTabContent">
                            <!-- Pending Payments -->
                            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                                <div class="payment-list">
                                    @forelse($pendingPaymentsList ?? [] as $payment)
                                    <div class="payment-item">
                                        <div class="payment-info">
                                            <div class="payment-avatar">
                                                {{ substr($payment->user->name, 0, 1) }}
                                            </div>
                                            <div class="payment-details">
                                                <h6>{{ $payment->user->name }}</h6>
                                                <small>{{ $payment->arisan->name }} - Periode {{ $payment->period }}</small>
                                                <br><small class="text-muted">Jatuh tempo: {{ $payment->due_date->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 text-end">
                                                <div class="fw-bold">Rp {{ number_format($payment->amount) }}</div>
                                                <span class="payment-status status-pending">Tertunda</span>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-action btn-sm" onclick="markPaid({{ $payment->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-info btn-action btn-sm" onclick="sendReminder({{ $payment->id }})">
                                                    <i class="fas fa-bell"></i>
                                                </button>
                                                <button class="btn btn-warning btn-action btn-sm" onclick="extendDueDate({{ $payment->id }})">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                        <p class="text-muted">Semua pembayaran sudah lunas!</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Overdue Payments -->
                            <div class="tab-pane fade" id="overdue" role="tabpanel">
                                <div class="payment-list">
                                    @forelse($overduePaymentsList ?? [] as $payment)
                                    <div class="payment-item border-danger">
                                        <div class="payment-info">
                                            <div class="payment-avatar bg-danger">
                                                {{ substr($payment->user->name, 0, 1) }}
                                            </div>
                                            <div class="payment-details">
                                                <h6>{{ $payment->user->name }}</h6>
                                                <small>{{ $payment->arisan->name }} - Periode {{ $payment->period }}</small>
                                                <br><small class="text-danger">Terlambat {{ $payment->days_overdue }} hari</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 text-end">
                                                <div class="fw-bold">Rp {{ number_format($payment->amount) }}</div>
                                                <span class="payment-status status-overdue">Terlambat</span>
                                            </div>
                                            <div>
                                                <button class="btn btn-success btn-action btn-sm" onclick="markPaid({{ $payment->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger btn-action btn-sm" onclick="sendUrgentReminder({{ $payment->id }})">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </button>
                                                <button class="btn btn-secondary btn-action btn-sm" onclick="handleOverdue({{ $payment->id }})">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-smile fa-3x text-success mb-3"></i>
                                        <p class="text-muted">Tidak ada pembayaran yang terlambat!</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Paid Payments -->
                            <div class="tab-pane fade" id="paid" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Kloter</th>
                                                <th>Periode</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Bayar</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($paidPayments ?? [] as $payment)
                                            <tr>
                                                <td>{{ $payment->user->name }}</td>
                                                <td>{{ $payment->arisan->name }}</td>
                                                <td>{{ $payment->period }}</td>
                                                <td>Rp {{ number_format($payment->amount) }}</td>
                                                <td>{{ $payment->paid_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="payment-status status-paid">
                                                        <i class="fas fa-check me-1"></i>Lunas
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada pembayaran lunas</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Schedule Management -->
                            <div class="tab-pane fade" id="schedule" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Atur Jadwal Pembayaran</h6>
                                        <form id="scheduleForm">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Kloter</label>
                                                <select class="form-select" name="arisan_id" required>
                                                    <option value="">Pilih kloter...</option>
                                                    @foreach($activeArisans ?? [] as $arisan)
                                                        <option value="{{ $arisan->id }}">{{ $arisan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Periode</label>
                                                <input type="number" class="form-control" name="period" min="1" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                                <input type="date" class="form-control" name="due_date" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Catatan (Opsional)</label>
                                                <textarea class="form-control" name="notes" rows="3"></textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>
                                                Atur Jadwal
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Jadwal Undian</h6>
                                        <form id="lotteryScheduleForm">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Kloter</label>
                                                <select class="form-select" name="arisan_id" required>
                                                    <option value="">Pilih kloter...</option>
                                                    @foreach($activeArisans ?? [] as $arisan)
                                                        <option value="{{ $arisan->id }}">{{ $arisan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Undian</label>
                                                <input type="datetime-local" class="form-control" name="lottery_date" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="auto_draw" id="autoDraw">
                                                    <label class="form-check-label" for="autoDraw">
                                                        Undian otomatis
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Pengingat Sebelum Undian</label>
                                                <select class="form-select" name="reminder_before">
                                                    <option value="1">1 hari sebelum</option>
                                                    <option value="3">3 hari sebelum</option>
                                                    <option value="7">1 minggu sebelum</option>
                                                </select>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-trophy me-1"></i>
                                                Jadwalkan Undian
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Detail Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-credit-card me-2"></i>
                        Detail Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="paymentDetails">
                        <!-- Payment details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="confirmPaymentBtn">
                        <i class="fas fa-check me-1"></i>Konfirmasi Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reminder Modal -->
    <div class="modal fade" id="reminderModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-bell me-2"></i>
                        Buat Pengingat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reminderForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Pengingat</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal & Waktu</label>
                            <input type="datetime-local" class="form-control" name="schedule" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tipe Pengingat</label>
                            <select class="form-select" name="type" required>
                                <option value="payment">Pembayaran</option>
                                <option value="lottery">Undian</option>
                                <option value="general">Umum</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_email" id="sendEmail">
                                <label class="form-check-label" for="sendEmail">
                                    Kirim via email
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="send_sms" id="sendSMS">
                                <label class="form-check-label" for="sendSMS">
                                    Kirim via SMS
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize FullCalendar
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: '/admin/schedule/events', // API endpoint for events
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                dateClick: function(info) {
                    createEventAtDate(info.date);
                },
                height: 'auto',
                locale: 'id'
            });
            calendar.render();

            // Schedule form submission
            $('#scheduleForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                $.post('/admin/schedule/payment', formData)
                    .done(function() {
                        Swal.fire('Berhasil', 'Jadwal pembayaran telah diatur', 'success');
                        calendar.refetchEvents();
                        $('#scheduleForm')[0].reset();
                    })
                    .fail(function() {
                        Swal.fire('Error', 'Gagal mengatur jadwal', 'error');
                    });
            });

            // Lottery schedule form
            $('#lotteryScheduleForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                $.post('/admin/schedule/lottery', formData)
                    .done(function() {
                        Swal.fire('Berhasil', 'Jadwal undian telah diatur', 'success');
                        calendar.refetchEvents();
                        $('#lotteryScheduleForm')[0].reset();
                    })
                    .fail(function() {
                        Swal.fire('Error', 'Gagal mengatur jadwal undian', 'error');
                    });
            });

            // Reminder form
            $('#reminderForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                $.post('/admin/reminders', formData)
                    .done(function() {
                        $('#reminderModal').modal('hide');
                        Swal.fire('Berhasil', 'Pengingat telah dibuat', 'success');
                        location.reload();
                    })
                    .fail(function() {
                        Swal.fire('Error', 'Gagal membuat pengingat', 'error');
                    });
            });
        });

        function markPaid(paymentId) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Tandai pembayaran ini sebagai lunas?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lunas',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/payments/${paymentId}/mark-paid`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pembayaran telah ditandai lunas', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses pembayaran', 'error');
                    });
                }
            });
        }

        function sendReminder(paymentId) {
            Swal.fire({
                title: 'Kirim Pengingat',
                text: 'Kirim pengingat pembayaran ke anggota?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/payments/${paymentId}/remind`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengingat telah dikirim', 'success');
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal mengirim pengingat', 'error');
                    });
                }
            });
        }

        function sendUrgentReminder(paymentId) {
            Swal.fire({
                title: 'Kirim Pengingat Mendesak',
                text: 'Kirim pengingat mendesak untuk pembayaran yang terlambat?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/payments/${paymentId}/urgent-remind`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengingat mendesak telah dikirim', 'success');
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal mengirim pengingat', 'error');
                    });
                }
            });
        }

        function extendDueDate(paymentId) {
            Swal.fire({
                title: 'Perpanjang Jatuh Tempo',
                input: 'number',
                inputLabel: 'Perpanjang berapa hari?',
                inputPlaceholder: 'Masukkan jumlah hari',
                showCancelButton: true,
                confirmButtonText: 'Perpanjang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    $.post(`/admin/payments/${paymentId}/extend`, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        days: result.value
                    }).done(function() {
                        Swal.fire('Berhasil', `Jatuh tempo diperpanjang ${result.value} hari`, 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memperpanjang jatuh tempo', 'error');
                    });
                }
            });
        }

        function handleOverdue(paymentId) {
            // Show options for handling overdue payment
            Swal.fire({
                title: 'Tindakan Pembayaran Terlambat',
                html: `
                    <div class="text-start">
                        <p>Pilih tindakan untuk pembayaran yang terlambat:</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="overdueAction" id="extend" value="extend">
                            <label class="form-check-label" for="extend">Perpanjang jatuh tempo</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="overdueAction" id="penalty" value="penalty">
                            <label class="form-check-label" for="penalty">Beri denda keterlambatan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="overdueAction" id="exclude" value="exclude">
                            <label class="form-check-label" for="exclude">Keluarkan dari kloter</label>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Proses',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const action = document.querySelector('input[name="overdueAction"]:checked');
                    if (!action) {
                        Swal.showValidationMessage('Pilih tindakan yang akan diambil');
                        return false;
                    }
                    return action.value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    processOverdueAction(paymentId, result.value);
                }
            });
        }

        function processOverdueAction(paymentId, action) {
            $.post(`/admin/payments/${paymentId}/handle-overdue`, {
                _token: $('meta[name="csrf-token"]').attr('content'),
                action: action
            }).done(function(response) {
                Swal.fire('Berhasil', response.message || 'Tindakan telah diproses', 'success');
                location.reload();
            }).fail(function() {
                Swal.fire('Error', 'Gagal memproses tindakan', 'error');
            });
        }

        function createReminder() {
            $('#reminderModal').modal('show');
        }

        function removeReminder(reminderId) {
            Swal.fire({
                title: 'Hapus Pengingat',
                text: 'Hapus pengingat ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.delete(`/admin/reminders/${reminderId}`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengingat telah dihapus', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal menghapus pengingat', 'error');
                    });
                }
            });
        }

        function showEventDetails(event) {
            // Display event details in modal or alert
            Swal.fire({
                title: event.title,
                html: `
                    <div class="text-start">
                        <p><strong>Tanggal:</strong> ${event.start.toLocaleDateString('id-ID')}</p>
                        <p><strong>Waktu:</strong> ${event.start.toLocaleTimeString('id-ID')}</p>
                        <p><strong>Tipe:</strong> ${event.extendedProps.type}</p>
                        ${event.extendedProps.description ? `<p><strong>Deskripsi:</strong> ${event.extendedProps.description}</p>` : ''}
                    </div>
                `,
                icon: 'info'
            });
        }

        function createEventAtDate(date) {
            $('#reminderModal').modal('show');
            // Pre-fill the date
            $('input[name="schedule"]').val(date.toISOString().slice(0, 16));
        }
    </script>
</body>
</html>
</html>