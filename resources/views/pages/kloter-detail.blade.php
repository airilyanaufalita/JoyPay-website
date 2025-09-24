<!-- resources/views/pages/kloter-detail.blade.php -->
<link rel="stylesheet" href="{{ asset('css/kloter-detail.css') }}">

<div class="detail-container">
    <!-- Back Button -->
    <button class="back-btn" onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Daftar Kloter
    </button>

    <!-- Detail Container -->
    <div class="container">
        <!-- Header Section -->
        <div class="detail-header">
            <div class="detail-header-content">
                <h1 class="detail-title" id="kloterName">{{ $kloter->name }}</h1>
                <p class="detail-subtitle">
                    Detail lengkap informasi kloter arisan
                </p>
            </div>
        </div>

        <!-- Detail Content -->
        <div class="detail-content">
            <div class="detail-form">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Dasar
                    </h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Kloter</label>
                            <div class="form-value" id="modalKloterName">{{ $kloter->name }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Admin</label>
                            <div class="form-value" id="kloterManager">Farah Proping Dewi</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nominal Arisan</label>
                            <div class="form-value highlight" id="kloterAmount">Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="form-value status-{{ $kloter->status }}" id="kloterStatus">
                                @if($kloter->status === 'open') Masih Buka
                                @elseif($kloter->status === 'full') Penuh
                                @elseif($kloter->status === 'running') Sedang Berjalan
                                @elseif($kloter->status === 'completed') Selesai
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Durasi</label>
                            <div class="form-value" id="kloterDuration">{{ $kloter->duration_value }} {{ ucfirst($kloter->duration_unit) }}</div>
                        </div>
                        <div class="form-group">
                                                       <label class="form-label">Admin Fee</label>
                            <div class="form-value" id="adminFee">{{ $kloter->admin_fee_percentage }}% (Rp {{ number_format($kloter->admin_fee_amount, 0, ',', '.') }})</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                           
                        </div>
                    </div>
                </div>

                <!-- Progress Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-chart-line"></i>
                        Progress Member
                    </h3>
                    <div class="progress-ring">
                        <div class="ring-container">
                            <svg class="ring-progress">
                                <defs>
                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <circle class="ring-background" cx="60" cy="60" r="45"></circle>
                                <circle class="ring-fill" cx="60" cy="60" r="45" id="progressRing"></circle>
                            </svg>
                            <div class="ring-text">
                                <div class="ring-percentage" id="progressPercentage">{{ $kloter->progress_percentage }}%</div>
                                <div class="ring-label">Terisi</div>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress-stats">
                                <div class="stat-item">
                                    <div class="stat-number animated-counter" id="joinedMembers">{{ $kloter->filled_slots }}</div>
                                    <div class="stat-label">Member Bergabung</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number animated-counter" id="remainingSlots">{{ $kloter->total_slots - $kloter->filled_slots }}</div>
                                    <div class="stat-label">Slot Tersisa</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number animated-counter" id="totalSlots">{{ $kloter->total_slots }}</div>
                                    <div class="stat-label">Total Slot</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number animated-counter" id="daysLeft">
                                        @php
                                            $daysLeft = $kloter->start_date ? now()->diffInDays($kloter->start_date, false) : 0;
                                            $daysLeft = max(0, $daysLeft);
                                        @endphp
                                        {{ $daysLeft }}
                                    </div>
                                    <div class="stat-label">Hari Tersisa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Member Slots Visual -->
                    <div class="member-slots">
                        <div class="slots-grid">
                            @for($i = 1; $i <= $kloter->total_slots; $i++)
                                <div class="slot {{ $i <= $kloter->filled_slots ? 'filled' : 'empty' }}" 
                                     title="Slot {{ $i }} - {{ $i <= $kloter->filled_slots ? 'Terisi' : 'Kosong' }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Member List -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Daftar Member Yang Bergabung
                    </h3>
                    <table class="member-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Tanggal Bergabung</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="memberTableBody">
                            @forelse($members as $index => $member)
                                <tr>
                                    <td>
                                        <div class="member-number">{{ $index + 1 }}</div>
                                    </td>
                                    <td>{{ $member->user->name ?? 'Member ' . ($index + 1) }}</td>
                                    <td>{{ $member->joined_at ? $member->joined_at->format('d M Y') : '-' }}</td>
                                    <td><span class="member-status {{ $member->status ?? 'active' }}">{{ ucfirst($member->status ?? 'Aktif') }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 20px;">Belum ada member yang bergabung</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Schedule & Payment -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-calendar-alt"></i>
                        Jadwal & Pembayaran
                    </h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Pembayaran Per Bulan</label>
                            <div class="form-value highlight">Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Admin Fee</label>
                            <div class="form-value">Rp {{ number_format($kloter->admin_fee_amount, 0, ',', '.') }} ({{ $kloter->admin_fee_percentage }}%)</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Total Per Bulan</label>
                            <div class="form-value highlight">Rp {{ number_format($kloter->nominal + $kloter->admin_fee_amount, 0, ',', '.') }}</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="form-value">Transfer Bank</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Jadwal Bayar</label>
                            <div class="form-value">sesuai dengan tanggal kloter penuh</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jadwal Undian</label>
                            <div class="form-value">sesuai dengan slot yang dipilih</div>
                        </div>
                    </div>
                </div>

                <!-- Rules & Terms -->
<div class="form-section">
    <h3 class="section-title">
        <i class="fas fa-file-contract"></i>
        Aturan & Ketentuan
    </h3>
    <div class="rules-list">
        <ul>
            <li>
                <i class="fas fa-check-circle"></i>
                <span>Pembayaran harus dilakukan tepat waktu sesuai jadwal</span>
            </li>
            <li>
                <i class="fas fa-check-circle"></i>
                <span>Keterlambatan pembayaran 3x berturut-turut akan dikeluarkan dari kloter</span>
            </li>
            <li>
                <i class="fas fa-check-circle"></i>
                <span>Tidak boleh keluar dari kloter sebelum periode selesai</span>
            </li>
            <li>
                <i class="fas fa-check-circle"></i>
                <span>Undian akan didapatkan sesuai dengan slot yang kamu pilih</span>
            </li>
            <li>
                <i class="fas fa-check-circle"></i>
                <span>Dilarang melakukan tindakan yang merugikan anggota lain</span>
            </li>
        </ul>
    </div>
</div>

                <!-- Join Action -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class="fas fa-user-plus"></i>
                        Bergabung dengan Kloter
                    </h3>
                    <div class="join-section">
                        @auth
                            @if($kloter->status === 'open' && $kloter->filled_slots < $kloter->total_slots)
                                <button class="btn-join-main" onclick="openJoinModal()">
                                    <i class="fas fa-handshake"></i>
                                    Bergabung Sekarang
                                </button>
                                
                            @else
                                <button class="btn-join-main disabled" disabled>
                                    <i class="fas fa-ban"></i>
                                    {{ $kloter->status === 'full' ? 'Kloter Penuh' : 'Tidak Tersedia' }}
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-join-main">
                                <i class="fas fa-sign-in-alt"></i>
                                Login untuk Bergabung
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Join Modal -->
<div class="modal-overlay" id="joinModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Konfirmasi Bergabung</h3>
            <button class="modal-close" onclick="closeJoinModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="join-summary">
                <h4>{{ $kloter->name }}</h4>
                <div class="summary-item">
                    <span>Nominal per {{ $kloter->duration_unit }}:</span>
                    <span>Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span>Admin fee:</span>
                    <span>Rp {{ number_format($kloter->admin_fee_amount, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item total">
                    <span>Total pembayaran per {{ $kloter->duration_unit }}:</span>
                    <span>Rp {{ number_format($kloter->nominal + $kloter->admin_fee_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="agreement">
                <label class="checkbox-container">
                    <input type="checkbox" id="agreeTerms">
                    <span class="checkmark"></span>
                    Saya setuju dengan semua aturan dan ketentuan kloter ini
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeJoinModal()">Batal</button>
            <form action="{{ route('kloter.join', $kloter->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-confirm" onclick="return confirmJoin()">Bergabung</button>
            </form>
        </div>
    </div>
</div>

<script>
// Modal Functions


// Progress Ring Animation
function updateProgressRing() {
    const ring = document.getElementById('progressRing');
    const percentage = {{ $kloter->progress_percentage }};
    const circumference = 2 * Math.PI * 45;
    const offset = circumference - (percentage / 100) * circumference;
    
    ring.style.strokeDasharray = circumference;
    ring.style.strokeDashoffset = offset;
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateProgressRing();
    

    
    // Animate counters
    const counters = document.querySelectorAll('.animated-counter');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = Math.max(1, target / 50);
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 30);
    });
});
</script>