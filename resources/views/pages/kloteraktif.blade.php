@auth
    @include('layouts.header-user')
@else
    @include('layouts.header')
@endauth
<link rel="stylesheet" href="{{ asset('css/kloteraktif.css') }}">

<!-- Scroll Indicator -->
<div class="scroll-indicator"></div>

<div class="kloter-container">
    <!-- Header Page Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="page-title">Kloter Aktif</h1>
            <p class="page-subtitle">Temukan dan bergabung dengan kloter arisan yang sedang aktif</p>
            
            <!-- Stats and Filter Container -->
            <div class="header-main-content">
                <!-- Filter Section in Header (Left) -->
                <div class="header-filter-section">
                    <div class="header-filter-container">
                        <div class="filter-group">
                            <label>Kategori</label>
                            <select id="kategori-filter">
                                <option value="">Semua Kategori</option>
                                <option value="bulanan">Bulanan</option>
                                <option value="mingguan">Mingguan</option>
                                
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Nominal</label>
                            <select id="nominal-filter">
                                <option value="">Semua Nominal</option>
                                <option value="100000">Rp 100.000</option>
                                <option value="500000">Rp 500.000</option>
                                <option value="1000000">Rp 1.000.000</option>
                                <option value="2000000">Rp 2.000.000+</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Status</label>
                            <select id="status-filter">
                                <option value="">Semua Status</option>
                                <option value="open">Masih Buka</option>
                                <option value="full">Penuh</option>
                                <option value="running">Berjalan</option>
                            </select>
                        </div>
                        <div class="search-group">
                            <input type="text" placeholder="Cari nama kloter..." id="search-input">
                            <button class="search-btn">🔍</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- Kloter Grid -->
    <div class="kloter-grid">
        @forelse ($kloters as $kloter)
            @if($kloter->total_slots <= 0)
                @continue
            @endif
            <div class="kloter-card" 
                 data-kategori="{{ $kloter->category }}" 
                 data-nominal="{{ $kloter->nominal }}" 
                 data-status="{{ $kloter->status }}">
                <div class="card-header">
                    <div class="card-status {{ $kloter->status }}">
                        @if($kloter->status === 'open') Masih Buka
                        @elseif($kloter->status === 'full') Penuh
                        @elseif($kloter->status === 'running') Sedang Berjalan
                        @endif
                    </div>
                    <div class="card-category">{{ ucfirst($kloter->category) }}</div>
                </div>
                <div class="card-body">
                    <h3>{{ $kloter->name }}</h3>
                    <p class="card-description">{{ $kloter->description ?? 'Deskripsi kloter' }}</p>
                    
                    <div class="card-info">
                        <div class="info-item">
                            <span class="label">Nominal:</span>
                            <span class="value">Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Durasi:</span>
                            <span class="value">{{ $kloter->duration_value }} {{ ucfirst($kloter->duration_unit) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Member:</span>
                            <span class="value">{{ $kloter->filled_slots }}/{{ $kloter->total_slots }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Admin Fee:</span>
                            <span class="value">{{ $kloter->admin_fee_percentage }}%</span>
                        </div>
                    </div>

<div class="progress-section">
    <div class="progress-label">
        <span>{{ $kloter->is_running ? 'Periode Ke' : 'Progress Member' }}</span>
        <span>{{ $kloter->progress_label }}</span>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" data-width="{{ $kloter->progress_percentage }}"></div>
    </div>
</div>
                </div>
                <div class="card-footer">
                    
                    <button class="btn-detail" onclick="window.location.href='/kloterAktif/detail/{{ $kloter->id }}'">Lihat Detail</button>
@auth
    @if(($kloter->status ?? '') === 'open' && ($kloter->filled_slots ?? 0) < ($kloter->total_slots ?? 0))
        <a href="{{ route('kloter.join.show', $kloter->id) }}" class="btn btn-primary btn-join">
            <i class=""></i>
            Bergabung
        </a>
    @else
        <button class="btn btn-secondary btn-join disabled">{{ ($kloter->status ?? '') === 'full' ? 'Penuh' : 'Tidak Tersedia' }}</button>
    @endif
@else
    <button class="btn btn-secondary disabled">Login dulu</button>
@endauth
                </div>
            </div>
        @empty
            <div class="no-data">Tidak ada kloter aktif saat ini. <a href="/admin/kloter">Buat baru (admin)</a></div>
        @endforelse

    </div>
</div>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</button>

<script>
    // Back to top functionality
    const backToTop = document.getElementById('backToTop');

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    });

    backToTop.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriFilter = document.getElementById('kategori-filter');
        const nominalFilter = document.getElementById('nominal-filter');
        const statusFilter = document.getElementById('status-filter');
        const searchInput = document.getElementById('search-input');
        const kloterCards = document.querySelectorAll('.kloter-card');

        function filterKloter() {
            const kategori = kategoriFilter.value;
            const nominal = nominalFilter.value;
            const status = statusFilter.value;
            const search = searchInput.value.toLowerCase();

            kloterCards.forEach(card => {
                let show = true;

                if (kategori && card.dataset.kategori !== kategori) {
                    show = false;
                }

                if (nominal && card.dataset.nominal !== nominal) {
                    show = false;
                }

                if (status && card.dataset.status !== status) {
                    show = false;
                }

                if (search) {
                    const cardTitle = card.querySelector('h3').textContent.toLowerCase();
                    if (!cardTitle.includes(search)) {
                        show = false;
                    }
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        kategoriFilter.addEventListener('change', filterKloter);
        nominalFilter.addEventListener('change', filterKloter);
        statusFilter.addEventListener('change', filterKloter);
        searchInput.addEventListener('input', filterKloter);
    });

    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.querySelector('.scroll-indicator').style.width = scrolled + '%';
    });
    document.addEventListener('DOMContentLoaded', function() {
    const progressFills = document.querySelectorAll('.progress-fill');
    progressFills.forEach(fill => {
        const width = fill.dataset.width;
        if (width) {
            fill.style.width = width + '%';
        }
    });
});
</script>
@include('layouts.footer')