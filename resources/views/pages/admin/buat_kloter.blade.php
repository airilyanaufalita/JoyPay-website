<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kloter - Arisan Barokah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        .loading.active {
            display: block;
        }
        .preview-card {
            min-height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .preview-card.active {
            border: 2px solid #10b981;
            background-color: #f0fdf4;
        }
    </style>
</head>
<body>
  @extends('pages.admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@endsection
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar (sama seperti sebelumnya) -->
        <div class="top-bar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Buat Kloter Baru</h4>
                <small class="text-muted">Buat kloter arisan baru untuk member</small>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3">
                    <i class="fas fa-clock me-1"></i>
                    {{ now()->format('d M Y H:i') }}
                </span>
            </div>
        </div>

        <!-- Form Buat Kloter -->
        <div class="content-card">
            <form id="createKloterForm" method="POST" action="{{ route('admin.buat-kloter.store') }}">
                @csrf <!-- CSRF token untuk POST -->
                <div class="row">
                    <div class="col-md-8">
                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Dasar Kloter
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Kloter *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Contoh: Kloter A - Keluarga Besar" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Arisan *</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="bulanan">Bulanan</option>
                                        <option value="mingguan">Mingguan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nominal Kloter (Rp) *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="nominal" class="form-control" placeholder="100000" step="0.01" required>
                                    </div>
                                    <small class="text-muted">Total pot hadiah kloter (per anggota = nominal / jumlah slots)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jumlah Anggota Maksimum *</label>
                                    <input type="number" name="total_slots" class="form-control" placeholder="24" min="2" max="100" required>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Waktu -->
                        <div class="form-section">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-calendar me-2"></i>
                                Pengaturan Waktu
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Durasi Kloter *</label>
                                    <div class="input-group">
                                        <input type="number" name="duration_value" class="form-control" placeholder="24" min="1" required>
                                        <select name="duration_unit" class="form-select" required>
                                            <option value="bulan">Bulan</option>
                                            <option value="minggu">Minggu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Keanggotaan -->
                        <div class="form-section">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-users me-2"></i>
                                Pengaturan Keanggotaan
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Minimal Anggota</label>
                                    <input type="number" name="min_slots" class="form-control" placeholder="20" min="2">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Maksimal Anggota</label>
                                    <input type="number" name="max_slots" class="form-control" placeholder="30" min="2">
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Tambahan -->
                        <div class="form-section">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-cog me-2"></i>
                                Pengaturan Tambahan
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Persentase Biaya Admin (%)</label>
                                    <input type="number" name="admin_fee_percentage" class="form-control" placeholder="2.5" step="0.1" min="0" max="100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Biaya Admin Tetap (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="admin_fee_amount" class="form-control" placeholder="10000" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Denda Keterlambatan (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="late_fee" class="form-control" placeholder="10000" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Grace Period (Hari)</label>
                                    <input type="number" name="grace_period" class="form-control" placeholder="3" min="0" max="7">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Deskripsi Kloter</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan detail kloter ini..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Preview Kloter -->
                        <div class="content-card preview-card" id="kloterPreview">
                            <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Preview akan muncul di sini</h6>
                            <small class="text-muted">Isi form di sebelah kiri untuk melihat preview</small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="content-card">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Buat Kloter
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>
                                    Reset Form
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="saveDraft()">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Draft
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-calculate and update preview
        document.querySelectorAll('input[type="number"], input[type="text"], select, textarea').forEach(input => {
            input.addEventListener('input', updatePreview); // Ubah ke 'input' untuk real-time
            input.addEventListener('change', updatePreview);
        });

        function updatePreview() {
            const name = document.querySelector('input[name="name"]').value || 'Kloter Baru';
            const nominalKloter = parseFloat(document.querySelector('input[name="nominal"]').value) || 0;
            const totalSlots = parseInt(document.querySelector('input[name="total_slots"]').value) || 0;
            const nominalPerAnggota = totalSlots > 0 ? Math.round(nominalKloter / totalSlots) : 0;
            const category = document.querySelector('select[name="category"]').value || 'Bulanan';
            const durationValue = parseInt(document.querySelector('input[name="duration_value"]').value) || 0;
            const durationUnit = document.querySelector('select[name="duration_unit"]').value || 'Bulan';
            const adminName = document.querySelector('input[name="admin_name"]').value || 'Farah Proping Dewi';

            const preview = document.getElementById('kloterPreview');
            console.log('Preview debug:', { name, nominalKloter, totalSlots, nominalPerAnggota, durationValue }); // Debug di console

            // FIX: Kondisi lebih fleksibel - tampilkan preview jika minimal nama, nominal, dan slots diisi
            if (name !== 'Kloter Baru' && nominalKloter > 0 && totalSlots > 0) {
                let previewHTML = `
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h6 class="fw-bold">${name}</h6>
                    <p class="mb-1"><strong>Nominal Kloter:</strong> Rp ${nominalKloter.toLocaleString('id-ID')}</p>
                    <p class="mb-1"><strong>Per Anggota:</strong> Rp ${nominalPerAnggota.toLocaleString('id-ID')}</p>
                    <p class="mb-1"><strong>Anggota:</strong> ${totalSlots} orang</p>
                    <p class="mb-1"><strong>Jenis:</strong> ${category}</p>
                `;
                if (durationValue > 0) {
                    previewHTML += `<p class="mb-1"><strong>Durasi:</strong> ${durationValue} ${durationUnit}</p>`;
                }
                previewHTML += `<p class="mb-0"><strong>Admin:</strong> ${adminName}</p>`;
                
                preview.innerHTML = previewHTML;
                preview.classList.add('active');
            } else {
                preview.innerHTML = `
                    <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Preview akan muncul di sini</h6>
                    <small class="text-muted">Isi form di sebelah kiri untuk melihat preview</small>
                `;
                preview.classList.remove('active');
            }
        }

        // Form submission dengan debug lebih baik
        document.getElementById('createKloterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            submitBtn.disabled = true;
            loadingSpinner.classList.add('active');

            const formData = new FormData(form);

            // Tambah field default yang tidak ada di form
            formData.append('filled_slots', 0); // Default saat buat kloter baru
            formData.append('current_period', 0); // Default saat buat kloter baru
            formData.append('status', 'open'); // Default status baru

            console.log('Submitting form data:', Object.fromEntries(formData)); // Debug form data di console

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Tambah ini untuk Laravel AJAX
                },
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug status
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response body:', text); // Debug detail error
                        throw new Error('Gagal menyimpan kloter: ' + text);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success data:', data); // Debug success
                if (data.success) {
                    alert('Kloter berhasil dibuat!');
                    window.location.href = '{{ route("admin.arisan-aktif") }}'; // Redirect ke daftar arisan aktif
                } else {
                    alert('Error: ' + (data.message || 'Coba lagi'));
                }
            })
            .catch(error => {
                console.error('Full fetch error:', error); // Debug full error
                alert('Error: ' + error.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                loadingSpinner.classList.remove('active');
            });
        });

        function resetForm() {
            document.getElementById('createKloterForm').reset();
            document.querySelector('input[name="admin_name"]').value = 'Farah Proping Dewi'; // Reset admin name
            document.querySelector('select[name="duration_unit"]').value = 'bulan'; // Reset default durasi
            updatePreview();
        }

        function saveDraft() {
            alert('Fitur simpan draft belum diimplementasikan!');
        }

        // Panggil preview awal
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
</body>
</html>