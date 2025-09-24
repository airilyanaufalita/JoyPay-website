<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Masuk Kloter - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Top Bar -->
                    <div class="bg-white p-3 mb-4 rounded shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="mb-0">
                                    <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                                    Konfirmasi Masuk Kloter
                                </h4>
                                <small class="text-muted">Kelola permintaan masuk kloter dari peserta</small>
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="badge bg-primary fs-6 px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ now()->format('d M Y H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    <div id="alert-container"></div>
                    
                    <!-- Search and Filter -->
                    <div class="bg-white p-3 mb-4 rounded shadow-sm">
                        <form method="GET" id="filter-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Cari peserta..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" name="kloter_id">
                                        <option value="">Semua Kloter</option>
                                        @foreach($kloters as $kloter)
                                            <option value="{{ $kloter->id }}" {{ request('kloter_id') == $kloter->id ? 'selected' : '' }}>
                                                {{ $kloter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded shadow-sm text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-clock text-warning fs-4"></i>
                                </div>
                                <h3 class="mb-1 text-warning">{{ $pendingCount }}</h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded shadow-sm text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-check text-success fs-4"></i>
                                </div>
                                <h3 class="mb-1 text-success">{{ $approvedCount }}</h3>
                                <p class="text-muted mb-0">Disetujui</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded shadow-sm text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-times text-danger fs-4"></i>
                                </div>
                                <h3 class="mb-1 text-danger">{{ $rejectedCount }}</h3>
                                <p class="text-muted mb-0">Ditolak</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-white p-3 rounded shadow-sm text-center">
                                <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-users text-info fs-4"></i>
                                </div>
                                <h3 class="mb-1 text-info">{{ $totalRequests }}</h3>
                                <p class="text-muted mb-0">Total</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Requests Table -->
                    <div class="bg-white p-3 rounded shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2 text-primary"></i>
                                Daftar Permintaan Masuk Kloter
                            </h5>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-success btn-sm" onclick="refreshTable()">
                                    <i class="fas fa-sync-alt me-1"></i> Refresh
                                </button>
                            </div>
                        </div>
                        
                        @if($pendingJoins->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
                                <h5 class="text-muted mt-3">Belum ada permintaan masuk kloter</h5>
                                <p class="text-muted">Permintaan dari peserta akan muncul di sini</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Kloter</th>
                                            <th>Slot</th>
                                            <th>Pembayaran/{{ ucfirst($pendingJoins->first()->kloter->duration_unit ?? 'bulan') }}</th>
                                            <th>Tanggal Request</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingJoins as $index => $member)
                                        <tr id="row-{{ $member->id }}" data-member-id="{{ $member->id }}">
                                            <td>{{ $pendingJoins->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $member->user->name ?? 'Unknown User' }}</strong>
                                                        <br><small class="text-muted">{{ $member->user->email ?? 'No Email' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $member->kloter->name ?? 'Unknown Kloter' }}</span>
                                                <br><small class="text-muted">Rp {{ number_format($member->kloter->nominal ?? 0, 0, ',', '.') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">Slot {{ $member->slot_number }}</span>
                                                <br><small class="text-muted">Rp {{ number_format($member->monthly_payment ?? 0, 0, ',', '.') }}</small>
                                            </td>
                                            <td>Rp {{ number_format($member->monthly_payment ?? 0, 0, ',', '.') }}</td>
                                            <td>{{ $member->joined_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="badge {{ $member->status === 'pending' ? 'bg-warning' : ($member->status === 'approved' ? 'bg-success' : 'bg-danger') }}" id="status-{{ $member->id }}">
                                                    {{ ucfirst($member->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" id="actions-{{ $member->id }}">
                                                    @if($member->status === 'pending')
                                                        <button class="btn btn-success btn-sm me-1" 
                                                                onclick="approveMember({{ $member->id }})" 
                                                                title="Setujui">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm me-1" 
                                                                onclick="showRejectModal({{ $member->id }})" 
                                                                title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @endif
                                                    <!-- Tombol detail selalu ada untuk semua status -->
                                                    <button class="btn btn-info btn-sm" onclick="showDetailModal({{ $member->id }})" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $pendingJoins->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Detail Permintaan Masuk Kloter
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-times-circle me-2"></i>
                        Tolak Permintaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectForm">
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Anda yakin ingin menolak permintaan ini?
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan Penolakan (Opsional)</label>
                            <textarea class="form-control" name="rejection_note" rows="3" 
                                    placeholder="Berikan alasan penolakan untuk peserta..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times me-1"></i>
                            Tolak Permintaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentMemberId = null;

        // Store member data in memory untuk fallback
        const memberDataCache = {};

        function showAlert(type, message) {
            const alertContainer = document.getElementById('alert-container');
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            alertContainer.innerHTML = alertHtml;
            
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }

        function updateStats() {
            fetch('/admin/member-requests/stats', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.text-warning').textContent = data.pendingCount;
                    document.querySelector('.text-success').textContent = data.approvedCount;
                    document.querySelector('.text-danger').textContent = data.rejectedCount;
                    document.querySelector('.text-info').textContent = data.totalRequests;
                }
            })
            .catch(error => console.error('Error updating stats:', error));
        }

        function approveMember(memberId) {
            if (!confirm('Apakah Anda yakin ingin menyetujui permintaan ini?')) return;

            const button = document.querySelector(`#actions-${memberId} .btn-success`);
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            fetch(`/admin/member-requests/${memberId}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    const statusBadge = document.getElementById(`status-${memberId}`);
                    statusBadge.className = 'badge bg-success';
                    statusBadge.textContent = 'Approved';
                    
                    // Update actions container - hapus tombol approve/reject, biarkan tombol detail
                    const actionsContainer = document.getElementById(`actions-${memberId}`);
                    actionsContainer.innerHTML = `
                        <button class="btn btn-info btn-sm" onclick="showDetailModal(${memberId})" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    `;
                    updateStats();
                } else {
                    showAlert('danger', data.message || 'Gagal menyetujui permintaan.');
                    button.innerHTML = originalHtml;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Terjadi kesalahan saat memproses permintaan.');
                button.innerHTML = originalHtml;
                button.disabled = false;
            });
        }

        function showRejectModal(memberId) {
            currentMemberId = memberId;
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        function showDetailModal(memberId) {
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalBody = document.getElementById('detailModalBody');
            
            modalBody.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            
            modal.show();

            // Coba ambil data dari server dulu
            fetch(`/admin/member-requests/${memberId}/detail`, {
                method: 'GET',
                headers: { 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken 
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const member = data.data;
                    // Simpan data ke cache
                    memberDataCache[memberId] = member;
                    displayMemberDetail(member);
                } else {
                    // Kalau gagal dari server, coba ambil dari cache atau DOM
                    tryFallbackDetail(memberId);
                }
            })
            .catch(error => {
                console.error('Error fetching detail:', error);
                // Kalau ada error, coba ambil dari cache atau DOM
                tryFallbackDetail(memberId);
            });
        }

        function tryFallbackDetail(memberId) {
            // Cek apakah ada data di cache
            if (memberDataCache[memberId]) {
                displayMemberDetail(memberDataCache[memberId]);
                return;
            }

            // Jika tidak ada cache, ambil data dari DOM table
            const row = document.querySelector(`tr[data-member-id="${memberId}"]`);
            if (row) {
                const cells = row.querySelectorAll('td');
                const memberFromDOM = {
                    id: memberId,
                    user: {
                        name: cells[1].querySelector('strong').textContent,
                        email: cells[1].querySelector('small').textContent
                    },
                    kloter: {
                        name: cells[2].querySelector('.badge').textContent,
                        nominal: cells[2].querySelector('small').textContent.replace('Rp ', '').replace(/\./g, '').replace(',', '')
                    },
                    slot_number: cells[3].querySelector('.badge').textContent.replace('Slot ', ''),
                    monthly_payment: cells[4].textContent.replace('Rp ', '').replace(/\./g, '').replace(',', ''),
                    joined_at: cells[5].textContent,
                    status: cells[6].querySelector('.badge').textContent.toLowerCase()
                };
                
                displayMemberDetailFromDOM(memberFromDOM);
            } else {
                // Jika sama sekali tidak bisa ambil data
                document.getElementById('detailModalBody').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Gagal memuat data</strong><br>
                        Data permintaan tidak dapat dimuat. Kemungkinan data sudah dihapus atau terjadi masalah koneksi.
                        <br><br>
                        <small class="text-muted">Error ID: ${memberId}</small>
                    </div>
                `;
            }
        }

        function displayMemberDetail(member) {
            const modalBody = document.getElementById('detailModalBody');
            
            // Buat alert khusus untuk status rejected
            let statusAlert = '';
            if (member.status === 'rejected') {
                statusAlert = `
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-times-circle me-3 mt-1" style="font-size: 1.2rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Permintaan Ditolak</h6>
                                <p class="mb-2">Permintaan masuk kloter ini telah ditolak oleh admin.</p>
                                ${member.rejection_note ? `
                                    <div class="mt-3 p-3 bg-white bg-opacity-50 rounded">
                                        <small class="text-muted d-block mb-1"><strong>Alasan Penolakan:</strong></small>
                                        <div class="text-dark">${member.rejection_note}</div>
                                    </div>
                                ` : `
                                    <small class="text-muted"><em>Admin tidak memberikan alasan khusus untuk penolakan ini.</em></small>
                                `}
                                ${member.rejected_at ? `<div class="mt-2"><small class="text-muted">Ditolak pada: ${new Date(member.rejected_at).toLocaleString('id-ID')}</small></div>` : ''}
                                ${member.rejected_by ? `<div><small class="text-muted">Ditolak oleh: ${member.rejected_by}</small></div>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            } else if (member.status === 'approved') {
                statusAlert = `
                    <div class="alert alert-success mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3" style="font-size: 1.2rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-1">Permintaan Disetujui</h6>
                                <p class="mb-0">Permintaan masuk kloter ini telah disetujui dan peserta sudah bergabung.</p>
                                ${member.verified_at ? `<small class="text-muted d-block mt-1">Disetujui pada: ${new Date(member.verified_at).toLocaleString('id-ID')}</small>` : ''}
                                ${member.verified_by ? `<small class="text-muted d-block">Disetujui oleh: ${member.verified_by}</small>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }
            
            modalBody.innerHTML = `
                ${statusAlert}
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>Informasi Peserta
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nama:</strong></td><td>${member.user.name}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${member.user.email}</td></tr>
                            <tr><td><strong>Username:</strong></td><td>${member.user.username || '-'}</td></tr>
                            <tr><td><strong>Phone:</strong></td><td>${member.user.phone || '-'}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-users me-2"></i>Informasi Kloter
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nama:</strong></td><td>${member.kloter.name}</td></tr>
                            <tr><td><strong>Nominal:</strong></td><td>Rp ${parseInt(member.kloter.nominal).toLocaleString('id-ID')}</td></tr>
                            <tr><td><strong>Durasi:</strong></td><td>${member.kloter.duration_value} ${member.kloter.duration_unit}</td></tr>
                            <tr><td><strong>Slot Terisi:</strong></td><td>${member.kloter.filled_slots || 0}/${member.kloter.total_slots || 0}</td></tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>Detail Permintaan
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Slot yang dipilih:</strong></td><td><span class="badge bg-secondary">Slot ${member.slot_number}</span></td></tr>
                            <tr><td><strong>Pembayaran per ${member.kloter.duration_unit}:</strong></td><td><strong>Rp ${parseInt(member.monthly_payment).toLocaleString('id-ID')}</strong></td></tr>
                            <tr><td><strong>Status:</strong></td><td><span class="badge ${member.status === 'pending' ? 'bg-warning' : (member.status === 'approved' ? 'bg-success' : 'bg-danger')}">${ucfirst(member.status)}</span></td></tr>
                            <tr><td><strong>Tanggal Bergabung:</strong></td><td>${new Date(member.joined_at).toLocaleString('id-ID')}</td></tr>
                        </table>
                    </div>
                </div>
            `;
        }

        // Helper function untuk capitalize first letter
        function ucfirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function displayMemberDetailFromDOM(member) {
            const modalBody = document.getElementById('detailModalBody');
            
            // Alert untuk rejection dengan note jika ada
            let statusAlert = '';
            if (member.status === 'rejected') {
                statusAlert = `
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-times-circle me-3 mt-1" style="font-size: 1.2rem;"></i>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Permintaan Ditolak</h6>
                                <p class="mb-2">Permintaan masuk kloter ini telah ditolak oleh admin.</p>
                                ${member.rejection_note ? `
                                    <div class="mt-3 p-3 bg-white bg-opacity-50 rounded">
                                        <small class="text-muted d-block mb-1"><strong>Alasan Penolakan:</strong></small>
                                        <div class="text-dark">${member.rejection_note}</div>
                                    </div>
                                ` : `
                                    <small class="text-muted"><em>Alasan penolakan tidak tersedia (data terbatas dari cache).</em></small>
                                `}
                            </div>
                        </div>
                    </div>
                `;
            }
            
            modalBody.innerHTML = `
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Data terbatas</strong><br>
                    Menampilkan data yang tersedia dari cache (beberapa detail mungkin tidak lengkap)
                </div>
                ${statusAlert}
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>Informasi Peserta
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nama:</strong></td><td>${member.user.name}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${member.user.email}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-users me-2"></i>Informasi Kloter
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nama:</strong></td><td>${member.kloter.name}</td></tr>
                            <tr><td><strong>Nominal:</strong></td><td>${member.kloter.nominal}</td></tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>Detail Permintaan
                        </h6>
                        <table class="table table-sm">
                            <tr><td><strong>Slot yang dipilih:</strong></td><td><span class="badge bg-secondary">Slot ${member.slot_number}</span></td></tr>
                            <tr><td><strong>Pembayaran bulanan:</strong></td><td><strong>${member.monthly_payment}</strong></td></tr>
                            <tr><td><strong>Status:</strong></td><td><span class="badge ${member.status === 'pending' ? 'bg-warning' : (member.status === 'approved' ? 'bg-success' : 'bg-danger')}">${ucfirst(member.status)}</span></td></tr>
                            <tr><td><strong>Tanggal Bergabung:</strong></td><td>${member.joined_at}</td></tr>
                        </table>
                    </div>
                </div>
            `;
        }

        function refreshTable() {
            location.reload();
        }

        // Handle reject form submission
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentMemberId) return;

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalHtml = submitButton.innerHTML;
            
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
            submitButton.disabled = true;

            fetch(`/admin/member-requests/${currentMemberId}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    
                    const statusBadge = document.getElementById(`status-${currentMemberId}`);
                    statusBadge.className = 'badge bg-danger';
                    statusBadge.textContent = 'Rejected';
                    
                    // Simpan rejection note ke cache untuk ditampilkan di detail
                    const rejectionNote = formData.get('rejection_note');
                    if (memberDataCache[currentMemberId]) {
                        memberDataCache[currentMemberId].rejection_note = rejectionNote;
                        memberDataCache[currentMemberId].status = 'rejected';
                    }
                    
                    // Update actions container - hapus tombol approve/reject, biarkan tombol detail
                    const actionsContainer = document.getElementById(`actions-${currentMemberId}`);
                    actionsContainer.innerHTML = `
                        <button class="btn btn-info btn-sm" onclick="showDetailModal(${currentMemberId})" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    `;
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
                    modal.hide();
                    this.reset();
                    updateStats();
                } else {
                    showAlert('danger', data.message || 'Gagal menolak permintaan.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Terjadi kesalahan saat memproses permintaan.');
            })
            .finally(() => {
                submitButton.innerHTML = originalHtml;
                submitButton.disabled = false;
            });
        });

        // Cache data member saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua row dan simpan data ke cache
            const rows = document.querySelectorAll('tr[data-member-id]');
            rows.forEach(row => {
                const memberId = row.dataset.memberId;
                const cells = row.querySelectorAll('td');
                if (cells.length >= 6) {
                    const memberData = {
                        id: memberId,
                        user: {
                            name: cells[1].querySelector('strong')?.textContent || 'Unknown',
                            email: cells[1].querySelector('small')?.textContent || 'No Email'
                        },
                        kloter: {
                            name: cells[2].querySelector('.badge')?.textContent || 'Unknown',
                            nominal: cells[2].querySelector('small')?.textContent?.replace('Rp ', '')?.replace(/\./g, '')?.replace(',', '') || '0'
                        },
                        slot_number: cells[3].querySelector('.badge')?.textContent?.replace('Slot ', '') || '0',
                        monthly_payment: cells[4]?.textContent?.replace('Rp ', '')?.replace(/\./g, '')?.replace(',', '') || '0',
                        joined_at: cells[5]?.textContent || new Date().toISOString(),
                        status: cells[6].querySelector('.badge')?.textContent?.toLowerCase() || 'pending'
                    };
                    memberDataCache[memberId] = memberData;
                }
            });
        });
    </script>
</body>
</html>