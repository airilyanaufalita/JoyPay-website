<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kloter - Admin Arisan Barokah</title>
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
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: none;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
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
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-outline-gradient {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-gradient:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .required {
            color: #dc3545;
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
        
        .status-badge {
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-draft { background: #e2e3e5; color: #383d41; }
        .status-open { background: #d4edda; color: #155724; }
        .status-full { background: #fff3cd; color: #856404; }
        .status-running { background: #cce5ff; color: #004085; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .info-card {
            background: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
        }
        
        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: white;
        }
        
        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.9);
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
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-2">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.kelola-kloter-aktif') }}">Kelola Kloter</a>
                                        </li>
                                        <li class="breadcrumb-item active">Edit Kloter</li>
                                    </ol>
                                </nav>
                                <h3 class="mb-1">
                                    <i class="fas fa-edit me-2"></i>Edit Kloter
                                </h3>
                                <p class="mb-0 opacity-75">Ubah data dan pengaturan kloter arisan</p>
                            </div>
                            <div>
                                <a href="{{ route('admin.kelola-kloter-aktif') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Kloter Info -->
                    <div class="info-card" id="kloterInfo" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="text-primary mb-2">Informasi Kloter Saat Ini</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Nama:</small>
                                        <div class="fw-bold" id="currentName">-</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Status:</small>
                                        <div><span id="currentStatus" class="status-badge">-</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">Anggota:</small>
                                <div class="fw-bold" id="currentMembers">0/0</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Form -->
                    <div class="content-card">
                        <form id="editKloterForm">
                            <input type="hidden" id="kloterId" name="kloter_id">
                            
                            <!-- Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kloter <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="editName" required 
                                           placeholder="Masukkan nama kloter">
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori <span class="required">*</span></label>
                                    <select class="form-select" name="category" id="editCategory" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="harian">Harian</option>
                                        <option value="mingguan">Mingguan</option>
                                        <option value="bulanan">Bulanan</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description" id="editDescription" rows="3"
                                              placeholder="Masukkan deskripsi kloter (opsional)"></textarea>
                                </div>
                            </div>
                            
                            <!-- Financial Settings -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-money-bill-wave me-2"></i>Pengaturan Keuangan
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nominal per Anggota <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="nominal" id="editNominal" 
                                               required min="0" step="1000" placeholder="0">
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Biaya Admin (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="admin_fee_percentage" 
                                               id="editAdminFeePercentage" step="0.1" min="0" max="10" placeholder="0">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <small class="text-muted">Maksimal 10%</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <input type="text" class="form-control" name="payment_method" 
                                           id="editPaymentMethod" placeholder="Transfer Bank">
                                </div>
                            </div>
                            
                            <!-- Kloter Settings -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-cogs me-2"></i>Pengaturan Kloter
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Anggota <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="total_slots" id="editTotalSlots" 
                                           required min="2" max="100" placeholder="2">
                                    <small class="text-muted">Minimal 2, maksimal 100 anggota</small>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Durasi Kloter <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="duration_value" 
                                               id="editDurationValue" required min="1" placeholder="1">
                                        <select class="form-select" name="duration_unit" id="editDurationUnit" required>
                                            <option value="">Pilih Unit</option>
                                            <option value="hari">Hari</option>
                                            <option value="minggu">Minggu</option>
                                            <option value="bulan">Bulan</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="required">*</span></label>
                                    <select class="form-select" name="status" id="editStatus" required>
                                        <option value="draft">Draft</option>
                                        <option value="open">Aktif (Buka)</option>
                                        <option value="full">Penuh</option>
                                        <option value="running">Berjalan</option>
                                        <option value="completed">Selesai</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <!-- Additional Settings -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-sliders-h me-2"></i>Pengaturan Tambahan
                                    </h5>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jadwal Pembayaran</label>
                                    <input type="text" class="form-control" name="payment_schedule" 
                                           id="editPaymentSchedule" placeholder="Setiap tanggal 1">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jadwal Undian</label>
                                    <input type="text" class="form-control" name="draw_schedule" 
                                           id="editDrawSchedule" placeholder="Setiap tanggal 15">
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-3">
                                        <a href="{{ route('admin.kelola-kloter-aktif') }}" class="btn btn-outline-gradient">
                                            <i class="fas fa-times me-1"></i>Batal
                                        </a>
                                        <button type="submit" class="btn btn-gradient">
                                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script>
        // Get kloter ID from URL - Fixed to handle /admin/kloters/{id}/edit-page format
        function getKloterIdFromUrl() {
            // First try query parameter ?id=
            const urlParams = new URLSearchParams(window.location.search);
            const queryId = urlParams.get('id');
            if (queryId) return queryId;
            
            // Then try to extract from path /admin/kloters/{id}/edit-page
            const pathParts = window.location.pathname.split('/');
            const kloterIndex = pathParts.indexOf('kloters');
            if (kloterIndex !== -1 && pathParts[kloterIndex + 1]) {
                const potentialId = pathParts[kloterIndex + 1];
                // Make sure it's a number and not 'edit-page'
                if (!isNaN(potentialId) && potentialId !== 'edit-page') {
                    return potentialId;
                }
            }
            
            return null;
        }
        
        const kloterId = getKloterIdFromUrl();

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Detected kloter ID:', kloterId); // Debug log
            if (kloterId) {
                loadKloterData(kloterId);
            } else {
                console.error('No kloter ID found in URL:', window.location.href);
                Swal.fire({
                    title: 'Error',
                    text: 'ID kloter tidak ditemukan dalam URL',
                    icon: 'error',
                    confirmButtonColor: '#667eea'
                }).then(() => {
                    window.location.href = '{{ route("admin.kelola-kloter-aktif") }}';
                });
            }

            // Form submission
            document.getElementById('editKloterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                saveKloter();
            });

            // Admin fee calculation
            document.getElementById('editAdminFeePercentage').addEventListener('input', calculateAdminFee);
            document.getElementById('editNominal').addEventListener('input', calculateAdminFee);
        });

        // FIXED: Add the missing loadKloterData function with better error handling
        function loadKloterData(id) {
            console.log('Loading kloter data for ID:', id);
            showLoading();
            
            fetch(`/admin/kloters/${id}/edit`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    hideLoading();
                    if (data.success) {
                        populateForm(data.data);
                        showKloterInfo(data.data);
                    } else {
                        console.error('Server returned error:', data.message);
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Gagal memuat data kloter',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        }).then(() => {
                            window.location.href = '{{ route("admin.kelola-kloter-aktif") }}';
                        });
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Fetch error details:', error);
                    
                    let errorMessage = 'Terjadi kesalahan saat memuat data kloter';
                    if (error.message.includes('404')) {
                        errorMessage = 'Data kloter tidak ditemukan atau route tidak tersedia';
                    } else if (error.message.includes('500')) {
                        errorMessage = 'Kesalahan server internal';
                    } else if (error.message.includes('NetworkError')) {
                        errorMessage = 'Koneksi bermasalah, periksa jaringan internet';
                    }
                    
                    Swal.fire({
                        title: 'Error',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        window.location.href = '{{ route("admin.kelola-kloter-aktif") }}';
                    });
                });
        }

        function populateForm(kloter) {
            // Set form values
            document.getElementById('kloterId').value = kloter.id;
            document.getElementById('editName').value = kloter.name || '';
            document.getElementById('editCategory').value = kloter.category || '';
            document.getElementById('editDescription').value = kloter.description || '';
            document.getElementById('editNominal').value = kloter.nominal || '';
            document.getElementById('editAdminFeePercentage').value = kloter.admin_fee_percentage || '';
            document.getElementById('editPaymentMethod').value = kloter.payment_method || 'Transfer Bank';
            document.getElementById('editTotalSlots').value = kloter.total_slots || '';
            document.getElementById('editDurationValue').value = kloter.duration_value || '';
            document.getElementById('editDurationUnit').value = kloter.duration_unit || '';
            document.getElementById('editStatus').value = kloter.status || 'draft';
            document.getElementById('editPaymentSchedule').value = kloter.payment_schedule || '';
            document.getElementById('editDrawSchedule').value = kloter.draw_schedule || '';

            // Set minimum total_slots based on filled_slots
            if (kloter.filled_slots > 0) {
                document.getElementById('editTotalSlots').min = kloter.filled_slots;
                const totalSlotsInput = document.getElementById('editTotalSlots');
                totalSlotsInput.parentElement.querySelector('small').textContent = 
                    `Minimal ${kloter.filled_slots} (jumlah anggota saat ini), maksimal 100 anggota`;
            }
        }

        function showKloterInfo(kloter) {
            document.getElementById('currentName').textContent = kloter.name;
            document.getElementById('currentStatus').textContent = kloter.status.toUpperCase();
            document.getElementById('currentStatus').className = `status-badge status-${kloter.status}`;
            document.getElementById('currentMembers').textContent = `${kloter.filled_slots}/${kloter.total_slots}`;
            document.getElementById('kloterInfo').style.display = 'block';
        }

        function calculateAdminFee() {
            const nominal = parseFloat(document.getElementById('editNominal').value) || 0;
            const percentage = parseFloat(document.getElementById('editAdminFeePercentage').value) || 0;
            
            if (nominal > 0 && percentage > 0) {
                const adminFee = Math.round(nominal * percentage / 100);
                console.log('Admin Fee:', adminFee);
            }
        }

        function saveKloter() {
            const form = document.getElementById('editKloterForm');
            const formData = new FormData(form);
            const id = document.getElementById('kloterId').value;
            
            // Convert FormData to JSON
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            showLoading();
            
            fetch(`/admin/kloters/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
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
                        window.location.href = '{{ route("admin.kelola-kloter-aktif") }}';
                    });
                } else {
                    if (data.errors) {
                        showValidationErrors(data.errors);
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Gagal menyimpan perubahan',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan kloter',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }

        function showValidationErrors(errors) {
            // Clear previous errors
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });

            // Show new errors
            for (let field in errors) {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.parentElement.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.textContent = errors[field][0];
                    }
                }
            }

            // Scroll to first error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
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