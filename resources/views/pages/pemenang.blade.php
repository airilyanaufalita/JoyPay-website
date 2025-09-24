<link rel="stylesheet" href="{{ asset('css/pemenang.css') }}">
<!-- Scroll Indicator -->
<div class="scroll-indicator"></div>
<div class="pemenang-container">
    <!-- Header -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="page-title">Pemenang Kloter</h1>
            <p class="page-subtitle">Daftar pemenang arisan dari berbagai kloter aktif</p>
            
            <!-- Filter Section in Header -->
            <div class="header-main-content">
                <div class="header-filter-section">
                    <form method="GET" action="{{ route('pemenang.index') }}">
                        <div class="header-filter-container">
                            <div class="filter-group">
                                <label for="nama">Cari Nama Pemenang</label>
                                <input type="text" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Cari nama kloter...">
                            </div>

                            <div class="filter-group">
                                <div class="filter-actions">
                                    <button type="submit" class="btn-filter">🔍</button>
                                    <a href="{{ route('pemenang.index') }}" class="btn-reset">↻</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<br>
    <!-- Winners Grid -->
    @if($winners->count() > 0)
        <div class="winners-grid">
            @foreach($winners as $winner)
                <div class="winner-card">
                    <div class="winner-header">
                        <h3 class="winner-name">{{ $winner->nama }}</h3>
                        <span class="winner-kloter">{{ $winner->kloter_nama }}</span>
                    </div>

                    <div class="winner-info">
                        <div class="winner-info-item">
                            <span class="winner-info-label">🏆 Kloter:</span>
                            <span class="winner-info-value">{{ $winner->kloter_nama }}</span>
                        </div>
                        
                        <div class="winner-info-item">
                            <span class="winner-info-label">🎯 Tanggal Menang:</span>
                            <span class="winner-info-value">{{ date('d M Y', strtotime($winner->tanggal_menang)) }}</span>
                        </div>
                        
                        <div class="winner-info-item">
                            <span class="winner-info-label">💰 Jumlah Hadiah:</span>
                            <span class="winner-info-value winner-hadiah">Rp {{ number_format($winner->hadiah, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="winner-info-item">
                            <span class="winner-info-label">📅 Tercatat:</span>
                            <span class="winner-info-value">{{ date('d M Y', strtotime($winner->created_at)) }}</span>
                        </div>
                    </div>

                    <div class="winner-actions">
                        <a href="{{ route('pemenang.show', $winner->id) }}" class="btn-detail">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="empty-state">
            <h3>🔍 Tidak Ada Pemenang</h3>
            <p>Belum ada data pemenang yang sesuai dengan kriteria pencarian Anda.</p>
        </div>
    @endif
</div>
<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</button>
<script>
    // Back to top functionality
const backToTop = document.getElementById('backToTop');

// Click event untuk smooth scroll ke atas
backToTop.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Show/hide back to top button berdasarkan scroll position
window.addEventListener('scroll', () => {
    if (window.scrollY > 500) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
});

// Optional: Keyboard accessibility (Enter dan Space)
backToTop.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
});
window.addEventListener('scroll', () => {
    // Update scroll indicator
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.querySelector('.scroll-indicator').style.width = scrolled + '%';
});
</script>