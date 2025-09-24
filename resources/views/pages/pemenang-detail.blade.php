<link rel="stylesheet" href="{{ asset('css/pemenang.css') }}">

<div class="detail-container">
    <div class="detail-card">
        <!-- Header -->
        <div class="detail-header">
            <h1 class="detail-title">🏆 Detail Pemenang</h1>
            <p class="detail-subtitle">Informasi lengkap pemenang {{ $winner->kloter_nama }}</p>
        </div>

        <!-- Winner Information -->
        <div class="detail-info">
            <!-- Personal Information -->
            <div class="detail-info-group">
                <h4>👤 Informasi Pemenang</h4>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Nama Lengkap</span>
                    <span class="detail-info-value">{{ $winner->nama }}</span>
                </div>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Nama Kloter</span>
                    <span class="detail-info-value">{{ $winner->kloter_nama }}</span>
                </div>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Tanggal Menang</span>
                    <span class="detail-info-value">{{ date('d F Y', strtotime($winner->tanggal_menang)) }}</span>
                </div>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Jumlah Hadiah</span>
                    <span class="detail-info-value winner-hadiah">Rp {{ number_format($winner->hadiah, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="detail-info-group">
                <h4>📅 Informasi Tambahan</h4>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Tanggal Dicatat</span>
                    <span class="detail-info-value">{{ date('d F Y H:i', strtotime($winner->created_at)) }}</span>
                </div>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">Terakhir Update</span>
                    <span class="detail-info-value">{{ date('d F Y H:i', strtotime($winner->updated_at)) }}</span>
                </div>
                
                <div class="detail-info-item">
                    <span class="detail-info-label">ID Pemenang</span>
                    <span class="detail-info-value">#{{ $winner->id }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="detail-actions">
            <a href="{{ route('pemenang.index') }}" class="btn-back">
                ← Kembali ke Daftar Pemenang
            </a>
        </div>
    </div>
</div>