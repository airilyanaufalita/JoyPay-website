
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        
        /* Center page content */
        .top-bar, .content-card {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .user-avatar.online {
            position: relative;
        }
        
        .user-avatar.online::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        .status-suspended { background: #fff3cd; color: #856404; }

        .btn-action {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin: 0 2px;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
            font-weight: 600;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box .fas {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .search-box input {
            padding-left: 45px;
            border-radius: 25px;
        }
        
        .filter-dropdown {
            border-radius: 10px;
        }
        
        .user-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .stat-item {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #495057;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .activity-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .activity-online { background: #28a745; }
        .activity-away { background: #ffc107; }
        .activity-offline { background: #6c757d; }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-bottom: none;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }
        
        .profile-section {
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .arisan-participation {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .participation-item {
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .bulk-actions {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }
        
        .bulk-actions.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->stopSection(); ?>
            <!-- Main Content -->
            <div class="col-md-20 col-lg-21">
                <div class="main-content">
                    <!-- Top Bar -->
                    <div class="top-bar d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Manajemen Pengguna</h4>
                            <small class="text-muted">Kelola semua pengguna sistem arisan</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e(now()->format('d M Y H:i')); ?>

                            </span>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-success mb-2"></i>
                                    <h5 class="card-title"><?php echo e($totalUsers ?? 0); ?></h5>
                                    <p class="card-text text-muted">Total Pengguna</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-check fa-2x text-primary mb-2"></i>
                                    <h5 class="card-title"><?php echo e($activeUsers ?? 0); ?></h5>
                                    <p class="card-text text-muted">Pengguna Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bulk Actions -->
                    <div class="bulk-actions" id="bulkActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span id="selectedCount">0 pengguna dipilih</span>
                            <div>
                                <button class="btn btn-danger btn-sm" onclick="bulkDelete()">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Users Table -->
                    <div class="content-card">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Daftar Pengguna
                            </h5>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" id="userSearch" placeholder="Cari pengguna...">
                                </div>
                                <select class="form-select filter-dropdown" id="statusFilter" style="width: 150px;">
                                    <option value="">Semua Status</option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                    <option value="suspended">Tersuspensi</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover" id="usersTable">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>Pengguna</th>
                                        <th>Kontak</th>
                                        <th>Account Number</th>
                                        <th>Social Media</th>
                                        <th>Bergabung</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input select-user" value="<?php echo e($user->id); ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar <?php echo e($user->is_online ? 'online' : ''); ?>">
                                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                                </div>
                                                <div>
                                                    <div class="fw-bold"><?php echo e($user->name); ?></div>
                                                    <small class="text-muted">ID: <?php echo e($user->id); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo e($user->email); ?></div>
                                            <small class="text-muted"><?php echo e($user->phone ?? '-'); ?></small>
                                        </td>

                                        <td>
                                            <div class="fw-bold"><?php echo e($user->account_number ?? '-'); ?></div>
                                            <small class="text-muted">Account</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($user->social_media ?? '-'); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?php echo e($user->created_at->format('d M Y')); ?></small>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-action btn-sm" onclick="deleteUser(<?php echo e($user->id); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada pengguna</p>
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

    <!-- User Detail Modal -->
    <div class="modal fade" id="userDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>
                        Detail Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="profile-section text-center">
                                <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2rem;" id="modalUserAvatar">
                                </div>
                                <h5 id="modalUserName"></h5>
                                <p class="text-muted" id="modalUserEmail"></p>
                                <div id="modalUserStatus"></div>
                            </div>
                            
                            <div class="user-stats">
                                <div class="stat-item">
                                    <div class="stat-number" id="modalArisanCount">0</div>
                                    <div class="stat-label">Arisan Diikuti</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" id="modalPaymentCount">0</div>
                                    <div class="stat-label">Pembayaran</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" id="modalWinCount">0</div>
                                    <div class="stat-label">Menang</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="profile-section">
                                <h6 class="text-muted mb-3">Informasi Pribadi</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong>No. Telepon:</strong>
                                            <span id="modalUserPhone"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Role:</strong>
                                            <span id="modalUserRole"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Bergabung:</strong>
                                            <span id="modalJoinDate"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong>Account Number:</strong>
                                            <span id="modalAccountNumber"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Status Email:</strong>
                                            <span id="modalEmailStatus"></span>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Social Media:</strong>
                                            <span id="modalSocialMedia"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h6 class="text-muted mb-3">Partisipasi Arisan</h6>
                                <div class="arisan-participation" id="modalArisanList">
                                    <!-- Arisan participation will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="modalActionBtn">
                        <i class="fas fa-cog me-1"></i>Kelola
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#usersTable').DataTable({
                pageLength: 15,
                order: [[6, 'desc']],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                }
            });

            // Search functionality
            $('#userSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filter functionality
            $('#statusFilter, #roleFilter').on('change', function() {
                const statusFilter = $('#statusFilter').val();
                const roleFilter = $('#roleFilter').val();
                
                if (statusFilter) {
                    table.column(4).search(statusFilter).draw();
                } else {
                    table.column(4).search('').draw();
                }
                
                if (roleFilter) {
                    table.column(3).search(roleFilter).draw();
                } else {
                    table.column(3).search('').draw();
                }
            });

            // Select all functionality
            $('#selectAll').on('change', function() {
                $('.select-user').prop('checked', this.checked);
                updateBulkActions();
            });

            $('.select-user').on('change', function() {
                updateBulkActions();
            });

            // (Form tambah pengguna dihapus)
        });

        function updateBulkActions() {
            const selected = $('.select-user:checked').length;
            if (selected > 0) {
                $('#bulkActions').addClass('show');
                $('#selectedCount').text(`${selected} pengguna dipilih`);
            } else {
                $('#bulkActions').removeClass('show');
            }
        }

        function viewUser(id) {
            $.get(`/admin/users/${id}`)
                .done(function(data) {
                    $('#modalUserAvatar').text(data.name.charAt(0));
                    $('#modalUserName').text(data.name);
                    $('#modalUserEmail').text(data.email);
                    $('#modalUserPhone').text(data.phone || '-');
                    $('#modalUserRole').html(`<span class="role-badge role-${data.role}">${data.role}</span>`);
                    $('#modalJoinDate').text(new Date(data.created_at).toLocaleDateString('id-ID'));
                    $('#modalLastLogin').text(data.last_login ? new Date(data.last_login).toLocaleDateString('id-ID') : 'Belum pernah');
                    $('#modalEmailStatus').html(data.email_verified_at ? '<span class="badge bg-success">Terverifikasi</span>' : '<span class="badge bg-warning">Belum Verifikasi</span>');
                    $('#modalLastIP').text(data.last_ip || '-');
                    
                    const statusBadges = {
                        'active': '<span class="badge bg-success">Aktif</span>',
                        'suspended': '<span class="badge bg-warning">Tersuspensi</span>',
                        'inactive': '<span class="badge bg-secondary">Tidak Aktif</span>'
                    };
                    $('#modalUserStatus').html(statusBadges[data.status]);
                    
                    // Stats
                    $('#modalArisanCount').text(data.arisan_count || 0);
                    $('#modalPaymentCount').text(data.payment_count || 0);
                    $('#modalWinCount').text(data.win_count || 0);
                    
                    // Arisan participation
                    let arisanHtml = '';
                    if (data.arisans && data.arisans.length > 0) {
                        data.arisans.forEach(function(arisan) {
                            arisanHtml += `
                                <div class="participation-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>${arisan.name}</strong>
                                            <div class="text-muted small">Rp ${new Intl.NumberFormat('id-ID').format(arisan.amount)} - ${arisan.duration} bulan</div>
                                        </div>
                                        <span class="badge bg-${arisan.status === 'active' ? 'success' : 'secondary'}">${arisan.status}</span>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        arisanHtml = '<div class="text-center text-muted">Belum mengikuti arisan</div>';
                    }
                    $('#modalArisanList').html(arisanHtml);
                    
                    $('#modalEditBtn').attr('onclick', `editUser(${id})`);
                    $('#userDetailModal').modal('show');
                })
                .fail(function() {
                    Swal.fire('Error', 'Gagal memuat detail pengguna', 'error');
                });
        }

        function editUser(id) {
            // Redirect to edit user page or show edit modal
            console.log('Edit user:', id);
        }

        function suspendUser(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Suspend pengguna ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Suspend',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/users/${id}/suspend`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengguna telah disuspend', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses permintaan', 'error');
                    });
                }
            });
        }

        function activateUser(id) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Aktifkan kembali pengguna ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(`/admin/users/${id}/activate`, {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengguna telah diaktifkan', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses permintaan', 'error');
                    });
                }
            });
        }

        function bulkActivate() {
            const selected = $('.select-user:checked').map(function() {
                return this.value;
            }).get();

            Swal.fire({
                title: 'Konfirmasi',
                text: `Aktifkan ${selected.length} pengguna terpilih?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/admin/users/bulk-activate', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: selected
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengguna terpilih telah diaktifkan', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses permintaan', 'error');
                    });
                }
            });
        }

        function bulkSuspend() {
            const selected = $('.select-user:checked').map(function() {
                return this.value;
            }).get();

            Swal.fire({
                title: 'Konfirmasi',
                text: `Suspend ${selected.length} pengguna terpilih?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Suspend',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/admin/users/bulk-suspend', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: selected
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengguna terpilih telah disuspend', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses permintaan', 'error');
                    });
                }
            });
        }

        function bulkDelete() {
            const selected = $('.select-user:checked').map(function() {
                return this.value;
            }).get();

            Swal.fire({
                title: 'Peringatan!',
                text: `Hapus ${selected.length} pengguna terpilih? Tindakan ini tidak dapat dibatalkan!`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/admin/users/bulk-delete', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: selected
                    }).done(function() {
                        Swal.fire('Berhasil', 'Pengguna terpilih telah dihapus', 'success');
                        location.reload();
                    }).fail(function() {
                        Swal.fire('Error', 'Gagal memproses permintaan', 'error');
                    });
                }
            });
        }
    </script>
</body>
</html>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\joypayy\resources\views/pages/admin/manajemen_user.blade.php ENDPATH**/ ?>