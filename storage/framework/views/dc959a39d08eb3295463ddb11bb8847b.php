<?php
    echo "<!-- Debug Info: -->\n";
    echo "<!-- Total Users: " . $users->count() . " -->\n";
    echo "<!-- Stats: " . json_encode($stats) . " -->\n";
    foreach($users as $user) {
        echo "<!-- User: " . $user->id . " - " . $user->name . " - " . $user->status . " -->\n";
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Konfirmasi Pendaftaran - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }
        
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
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .top-bar, .filter-section, .content-card {
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
            color: white;
        }
        
        .stats-number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .status-badge {
            padding: 7px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pending { 
            background: #fff3cd; 
            color: #856404; 
        }
        
        .status-approved { 
            background: #d4edda; 
            color: #155724; 
        }
        
        .status-rejected { 
            background: #f8d7da; 
            color: #721c24; 
        }
        
        .btn-action {
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin: 0 3px;
            transition: all 0.2s;
        }
        
        .btn-action:hover {
            transform: scale(1.05);
        }
        
        .filter-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
            padding: 15px;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .bank-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
        }
        
        .select-all-checkbox {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php echo $__env->make('pages.admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Top Bar -->
                    <div class="top-bar d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Konfirmasi Pendaftaran</h4>
                            <small class="text-muted">Kelola dan konfirmasi pendaftaran member baru</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary me-3" id="bulkApproveBtn" onclick="bulkApprove()">
                                <i class="fas fa-check-double me-1"></i>
                                Setujui Terpilih
                            </button>
                            <span class="me-3">
                                <i class="fas fa-clock me-1"></i>
                                <span id="currentDateTime"></span>
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
                                <div class="stats-number" id="totalCount"><?php echo e($stats['total']); ?></div>
                                <div class="stats-label">Total Pendaftar</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stats-number" id="pendingCount"><?php echo e($stats['pending']); ?></div>
                                <div class="stats-label">Menunggu Review</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stats-number" id="approvedCount"><?php echo e($stats['approved']); ?></div>
                                <div class="stats-label">Disetujui</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="stats-icon bg-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stats-number" id="rejectedCount"><?php echo e($stats['rejected']); ?></div>
                                <div class="stats-label">Ditolak</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="pending" selected>Menunggu Konfirmasi</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tanggal Daftar</label>
                                <select class="form-select" id="filterDate">
                                    <option value="">Semua Tanggal</option>
                                    <option value="today">Hari Ini</option>
                                    <option value="week">Minggu Ini</option>
                                    <option value="month">Bulan Ini</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tipe Member</label>
                                <select class="form-select" id="filterType">
                                    <option value="">Semua Tipe</option>
                                    <option value="regular">Regular</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cari</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari nama/email...">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registrations List -->
                    <div class="content-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Daftar Pendaftaran
                            </h5>
                            <button class="btn btn-outline-primary btn-sm" onclick="loadRegistrations()">
                                <i class="fas fa-sync-alt me-1"></i>Refresh
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover" id="registrationsTable">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" class="form-check-input select-all-checkbox" id="selectAll">
                                        </th>
                                        <th>Pendaftar</th>
                                        <th>Informasi</th>
                                        <th>Status</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Reviewer</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="registrationsBody">
                                    <?php if($users->count() > 0): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-status="<?php echo e($user->status); ?>" data-type="<?php echo e($user->type); ?>" data-date="<?php echo e($user->created_at); ?>" data-user-id="<?php echo e($user->id); ?>">
                                            <td>
                                                <input type="checkbox" class="form-check-input select-registration" value="<?php echo e($user->id); ?>" <?php echo e($user->status !== 'pending' ? 'disabled' : ''); ?>>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-3">
                                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo e($user->name); ?></div>
                                                        <small class="text-muted"><?php echo e($user->email); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><strong>Telepon:</strong> <?php echo e($user->phone ?? '-'); ?></div>
                                                <div><strong>Bank:</strong> 
                                                    <?php if($user->bank): ?>
                                                        <span class="bank-badge"><?php echo e(strtoupper($user->bank)); ?></span>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </div>
                                                <div><strong>Rekening:</strong> <?php echo e($user->account_number ?? '-'); ?></div>
                                            </td>
                                            <td>
                                                <?php if($user->status === 'pending'): ?>
                                                    <span class="status-badge status-pending">
                                                        <i class="fas fa-clock me-1"></i>Menunggu
                                                    </span>
                                                <?php elseif($user->status === 'approved'): ?>
                                                    <span class="status-badge status-approved">
                                                        <i class="fas fa-check me-1"></i>Disetujui
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge status-rejected">
                                                        <i class="fas fa-times me-1"></i>Ditolak
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?php echo e($user->created_at->format('d M Y H:i')); ?></small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php if($user->status === 'pending'): ?>
                                                        -
                                                    <?php elseif($user->status === 'approved' && $user->approvedBy): ?>
                                                        <?php echo e($user->approvedBy->name); ?>

                                                    <?php elseif($user->status === 'rejected' && $user->rejectedBy): ?>
                                                        <?php echo e($user->rejectedBy->name); ?>

                                                    <?php else: ?>
                                                        Admin
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php if($user->status === 'pending'): ?>
                                                    <button class="btn btn-success btn-action btn-sm" onclick="approveRegistration(<?php echo e($user->id); ?>)">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-action btn-sm" onclick="showRejectionModal(<?php echo e($user->id); ?>)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button class="btn btn-info btn-action btn-sm" onclick="viewRegistration(<?php echo e($user->id); ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-info btn-action btn-sm" onclick="viewRegistration(<?php echo e($user->id); ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-user-slash"></i>
                                                    <h5>Tidak ada pendaftaran</h5>
                                                    <p class="text-muted">Belum ada pengguna yang mendaftar</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Detail Modal -->
    <div class="modal fade" id="registrationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>
                        Detail Pendaftaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="registrationDetails">
                        <!-- Registration details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="approveBtn" style="display: none;">
                        <i class="fas fa-check me-1"></i>Setujui
                    </button>
                    <button type="button" class="btn btn-danger" id="rejectBtn" style="display: none;">
                        <i class="fas fa-times me-1"></i>Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
<!-- Registrations List -->
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Pendaftaran
        </h5>
        <button class="btn btn-outline-primary btn-sm" onclick="location.reload()">
            <i class="fas fa-sync-alt me-1"></i>Refresh
        </button>
    </div>
    
    <?php if($users->count() > 0): ?>
    <div class="table-responsive">
        <table class="table table-hover" id="registrationsTable">
            <!-- Table content here -->
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-check-circle" style="color: #28a745; font-size: 5rem;"></i>
        <h5>Tidak Ada Pendaftaran yang Perlu Diverifikasi</h5>
        <p class="text-muted">Semua pendaftaran telah diproses atau belum ada user yang mendaftar.</p>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>
    <?php endif; ?>
</div>
    <!-- Rejection Reason Modal -->
    <div class="modal fade" id="rejectionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>
                        Alasan Penolakan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectionForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" id="rejectUserId" name="user_id">
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="rejection_reason" rows="4" required placeholder="Berikan alasan penolakan yang jelas..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Saran Perbaikan (Opsional)</label>
                            <textarea class="form-control" name="improvement_suggestion" rows="3" placeholder="Berikan saran untuk perbaikan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i>Tolak Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
           let currentRegistrationId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '<?php echo e(csrf_token()); ?>';
        
        $(document).ready(function() {
            // Update current date time
            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Select all functionality
            $('#selectAll').on('change', function() {
                $('.select-registration:not(:disabled)').prop('checked', this.checked);
                updateBulkActions();
            });

            $(document).on('change', '.select-registration', function() {
                updateBulkActions();
                
                const totalCheckboxes = $('.select-registration:not(:disabled)').length;
                const checkedCheckboxes = $('.select-registration:checked').length;
                
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
                $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
            });

            // Filter functionality
            $('#filterStatus, #filterDate, #filterType').on('change', function() {
                applyFilters();
            });

            // Search functionality
            $('#searchInput').on('keyup', function() {
                applyFilters();
            });

            // Rejection form
            $('#rejectionForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const userId = $('#rejectUserId').val();
                
                fetch(`/admin/registrations/${userId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#rejectionModal').modal('hide');
                        Swal.fire('Berhasil', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                });
            });
        });

    function approveRegistration(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Setujui pendaftaran ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/registrations/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                });
            }
        });
    }

        function showRejectionModal(id) {
            currentRegistrationId = id;
            $('#rejectUserId').val(id);
            $('#rejectionForm')[0].reset();
            $('#rejectionModal').modal('show');
        }

        function viewRegistration(id) {
            fetch(`/admin/registrations/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.data;
                    let detailsHtml = `
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    ${user.name.charAt(0)}
                                </div>
                                <h5>${user.name}</h5>
                                <p class="text-muted">${user.email}</p>
                                <span class="badge bg-${user.status === 'pending' ? 'warning' : (user.status === 'approved' ? 'success' : 'danger')}">
                                    ${user.status === 'pending' ? 'Menunggu Konfirmasi' : (user.status === 'approved' ? 'Disetujui' : 'Ditolak')}
                                </span>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted mb-3">Informasi Pribadi</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2"><strong>Nama:</strong> ${user.name}</div>
                                        <div class="mb-2"><strong>Email:</strong> ${user.email}</div>
                                        <div class="mb-2"><strong>No. Telepon:</strong> ${user.phone || '-'}</div>
                                        <div class="mb-2"><strong>No. Darurat:</strong> ${user.emergency_phone || '-'}</div>
                                        <div class="mb-2"><strong>Tipe Member:</strong> ${user.type || 'regular'}</div>
                                        <div class="mb-2"><strong>Tanggal Daftar:</strong> ${new Date(user.created_at).toLocaleDateString('id-ID')}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2"><strong>Alamat:</strong> ${user.address || '-'}</div>
                                        <div class="mb-2"><strong>Media Sosial:</strong> ${user.social_media || '-'}</div>
                                        <div class="mb-2"><strong>Bank:</strong> ${user.bank || '-'}</div>
                                        <div class="mb-2"><strong>No. Rekening:</strong> ${user.account_number || '-'}</div>
                                    </div>
                                </div>
                                
                                ${user.rejection_reason ? `
                                <h6 class="text-muted mb-3 mt-3">Alasan Penolakan</h6>
                                <p class="text-danger">${user.rejection_reason}</p>
                                ${user.improvement_suggestion ? `<p class="text-info"><strong>Saran:</strong> ${user.improvement_suggestion}</p>` : ''}
                                ` : ''}

                                ${user.approved_by ? `
                                <h6 class="text-muted mb-3 mt-3">Informasi Review</h6>
                                <p><strong>Disetujui oleh:</strong> ${user.approved_by_admin || 'Admin'}</p>
                                <p><strong>Tanggal Persetujuan:</strong> ${new Date(user.approved_at).toLocaleDateString('id-ID')}</p>
                                ` : ''}

                                ${user.rejected_by ? `
                                <h6 class="text-muted mb-3 mt-3">Informasi Review</h6>
                                <p><strong>Ditolak oleh:</strong> ${user.rejected_by_admin || 'Admin'}</p>
                                <p><strong>Tanggal Penolakan:</strong> ${new Date(user.rejected_at).toLocaleDateString('id-ID')}</p>
                                ` : ''}
                            </div>
                        </div>
                    `;
                    
                    $('#registrationDetails').html(detailsHtml);
                    
                    // Show/hide action buttons
                    if (user.status === 'pending') {
                        $('#approveBtn').show().off('click').on('click', () => approveRegistration(id));
                        $('#rejectBtn').show().off('click').on('click', () => showRejectionModal(id));
                    } else {
                        $('#approveBtn').hide();
                        $('#rejectBtn').hide();
                    }
                    
                    $('#registrationModal').modal('show');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
            });
        }

        function bulkApprove() {
            const selected = $('.select-registration:checked').map(function() {
                return parseInt(this.value);
            }).get();

            if (selected.length === 0) {
                Swal.fire('Peringatan', 'Pilih pendaftaran yang akan disetujui', 'warning');
                return;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: `Setujui ${selected.length} pendaftaran terpilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/registrations/bulk-approve', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            ids: selected
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan', 'error');
                    });
                }
            });
        }

        function refreshData() {
            location.reload();
        }
        
        function updateDateTime() {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
        }

        function updateBulkActions() {
            const selected = $('.select-registration:checked').length;
            const bulkBtn = $('#bulkApproveBtn');
            
            if (selected > 0) {
                bulkBtn.html(`<i class="fas fa-check-double me-1"></i>Setujui ${selected} Terpilih`);
                bulkBtn.removeClass('btn-primary').addClass('btn-success');
            } else {
                bulkBtn.html('<i class="fas fa-check-double me-1"></i>Setujui Terpilih');
                bulkBtn.removeClass('btn-success').addClass('btn-primary');
            }
        }

        function applyFilters() {
            // Implementasi filter
            const status = $('#filterStatus').val();
            const type = $('#filterType').val();
            const date = $('#filterDate').val();
            const search = $('#searchInput').val().toLowerCase();
            
            $('tbody tr').each(function() {
                const rowStatus = $(this).data('status');
                const rowType = $(this).data('type');
                const rowDate = $(this).data('date');
                const rowText = $(this).text().toLowerCase();
                
                let statusMatch = !status || rowStatus === status;
                let typeMatch = !type || rowType === type;
                let searchMatch = !search || rowText.includes(search);
                
                // Filter tanggal (sederhana)
                let dateMatch = true;
                if (date) {
                    const rowDateObj = new Date(rowDate);
                    const now = new Date();
                    
                    if (date === 'today') {
                        dateMatch = rowDateObj.toDateString() === now.toDateString();
                    } else if (date === 'week') {
                        const oneWeekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                        dateMatch = rowDateObj >= oneWeekAgo;
                    } else if (date === 'month') {
                        const oneMonthAgo = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate());
                        dateMatch = rowDateObj >= oneMonthAgo;
                    }
                }
                
                if (statusMatch && typeMatch && dateMatch && searchMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\joypayy\resources\views/pages/admin/konfirmasi_pendaftaran.blade.php ENDPATH**/ ?>