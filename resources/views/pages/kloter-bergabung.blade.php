<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bergabung Kloter - {{ $kloter->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            min-height: 100vh;
            color: #1e293b;
        }

        .detail-container {
            min-height: 100vh;
            position: relative;
        }

        .back-btn {
            position: fixed;
            top: 30px;
            left: 30px;
            background: rgba(255,255,255,0.95);
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 12px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 100;
            text-decoration: none;
        }

        .back-btn:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            color: #10b981;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            min-height: 100vh;
        }

        .detail-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 80px 40px 40px;
            position: relative;
            overflow: hidden;
        }

        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="1.5" fill="white" opacity="0.1"/><circle cx="40" cy="80" r="1" fill="white" opacity="0.1"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .detail-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .detail-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .detail-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 400;
            margin-bottom: 40px;
        }

        .kloter-info {
            background: rgba(255,255,255,0.15);
            padding: 24px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            max-width: 800px;
            margin: 0 auto;
        }

        .info-item {
            text-align: center;
        }

        .info-item .label {
            display: block;
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .info-item .value {
            font-size: 1.3rem;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .detail-content {
            padding: 40px;
        }

        .form-section {
            background: #f8fafc;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid #10b981;
        }

        .section-title i {
            color: #10b981;
            font-size: 1.3rem;
        }

        .slot-explanation {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .explanation-text {
            color: #475569;
            line-height: 1.7;
            margin-bottom: 16px;
            font-size: 1rem;
        }

        .highlight-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 18px;
            border-radius: 12px;
            color: #92400e;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #fbbf24;
        }

        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .slot-card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .slot-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #059669);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .slot-card:hover:not(.taken) {
            border-color: #10b981;
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15);
        }

        .slot-card:hover:not(.taken):before {
            transform: scaleX(1);
        }

        .slot-card.selected {
            border-color: #10b981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(5, 150, 105, 0.05));
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.2);
        }

        .slot-card.selected:before {
            transform: scaleX(1);
        }

        .slot-card.taken {
            border-color: #e2e8f0;
            background: #f8fafc;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .slot-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .slot-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .slot-card.taken .slot-number {
            background: #9ca3af;
            box-shadow: none;
        }

        .slot-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-available {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .status-taken {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .slot-info {
            text-align: center;
        }

        .monthly-payment {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .slot-card.selected .monthly-payment {
            color: #10b981;
        }

        .payment-description {
            font-size: 0.95rem;
            color: #64748b;
            margin-bottom: 12px;
        }

        .slot-benefits {
            font-size: 0.85rem;
            color: #059669;
            font-weight: 500;
        }

        .taken-member {
            font-size: 0.95rem;
            color: #64748b;
            margin-top: 8px;
        }

        .summary-section {
            background: white;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 1rem;
        }

        .summary-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            font-weight: 600;
            font-size: 1.2rem;
            color: #10b981;
        }

        .agreement {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            cursor: pointer;
            line-height: 1.6;
            font-size: 1rem;
        }

        .checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #10b981;
            cursor: pointer;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 160px;
            justify-content: center;
            text-decoration: none;
        }

        .btn-cancel {
            background: #64748b;
            color: white;
            border: 2px solid transparent;
        }

        .btn-cancel:hover {
            background: #475569;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(100, 116, 139, 0.3);
        }

        .btn-join {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: 2px solid transparent;
        }

        .btn-join:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-join:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: none;
            font-weight: 500;
        }

        .success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: none;
            font-weight: 500;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .back-btn {
                position: relative;
                top: 0;
                left: 0;
                margin: 20px;
            }

            .detail-header {
                padding: 60px 20px 30px;
            }

            .detail-title {
                font-size: 2rem;
            }

            .detail-content {
                padding: 20px;
            }

            .form-section {
                padding: 20px;
            }

            .kloter-info {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .slots-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <a href="{{ route('kloter.aktif') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

        <div class="container">
            <div class="detail-header">
                <div class="detail-header-content">
                    <h1 class="detail-title">Bergabung dengan Kloter</h1>
                    <p class="detail-subtitle">Pilih slot yang sesuai dengan kemampuan pembayaran {{ $period }} Anda</p>
                    
                    <div class="kloter-info">
                        <div class="info-item">
                            <span class="label">Nama Kloter</span>
                            <span class="value">{{ $kloter->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Total Nominal</span>
                            <span class="value">Rp {{ number_format($kloter->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Durasi</span>
                            <span class="value">{{ $kloter->duration_value }} {{ ucfirst($kloter->duration_unit) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Total Slot</span>
                            <span class="value">{{ $kloter->total_slots }} Slot</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Slot Tersisa</span>
                            <span class="value">{{ $kloter->total_slots - count($takenSlots) }} Slot</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-content">
                <form id="joinKloterForm">
                    @csrf
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Cara Kerja Sistem Slot
                        </div>
                        
                        <div class="slot-explanation">
                            <p class="explanation-text">
                                Setiap slot memiliki nominal pembayaran {{ $period }} yang berbeda. Slot dengan nomor lebih kecil memiliki pembayaran {{ $period }} yang lebih tinggi, namun akan mendapat giliran arisan lebih awal. Sebaliknya, slot dengan nomor besar memiliki pembayaran {{ $period }} lebih rendah tapi mendapat giliran lebih akhir.
                            </p>
                            <div class="highlight-box">
                                <i class="fas fa-lightbulb"></i>
                                <span><strong>Hasil Akhir Tetap Sama!</strong> Total yang Anda terima tetap Rp {{ number_format($kloter->nominal, 0, ',', '.') }}, hanya cara pembayarannya yang berbeda.</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-th-large"></i>
                            Pilih Slot Anda
                        </div>

                        <div class="error-message" id="errorMessage"></div>
                        <div class="success-message" id="successMessage"></div>

                        <div class="slots-grid" id="slotsGrid">
                            @foreach($slots as $slot)
                            <div class="slot-card {{ $slot['is_taken'] ? 'taken' : '' }}" 
                                 data-slot="{{ $slot['number'] }}"
                                 data-payment="{{ $slot['monthly_payment'] }}"
                                 onclick="{{ $slot['is_taken'] ? '' : 'selectSlot(' . $slot['number'] . ')' }}">
                                
                                <div class="slot-header">
                                    <div class="slot-number">{{ $slot['number'] }}</div>
                                    <div class="slot-status {{ $slot['is_taken'] ? 'status-taken' : 'status-available' }}">
                                        {{ $slot['is_taken'] ? 'Terisi' : 'Tersedia' }}
                                    </div>
                                </div>
                                
                                <div class="slot-info">
                                    @if(!$slot['is_taken'])
                                        <div class="monthly-payment">Rp {{ number_format($slot['monthly_payment'], 0, ',', '.') }}</div>
                                        <div class="payment-description">Per {{ $period }}</div>
                                        <div class="slot-benefits">
                                            {{ $slot['period_label'] }} • {{ $slot['number'] <= 3 ? 'Dapat duluan' : ($slot['number'] <= ($kloter->total_slots / 2) ? 'Dapat tengah' : 'Bayar ringan') }}
                                        </div>
                                    @else
                                        <div class="taken-member">
                                            <i class="fas fa-user"></i> Member sudah terisi
                                        </div>
                                        <div class="payment-description">Slot sudah terisi</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-section" id="summarySection" style="display: none;">
                        <div class="section-title">
                            <i class="fas fa-receipt"></i>
                            Ringkasan Pilihan
                        </div>
                        
                        <div class="summary-section">
                            <div class="summary-item">
                                <span>Slot yang dipilih:</span>
                                <span id="selectedSlotNumber">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Pembayaran per {{ $period }}:</span>
                                <span id="selectedMonthlyPayment">-</span>
                            </div>
                            <div class="summary-item">
                                <span>Admin fee ({{ $kloter->admin_fee_percentage ?? 2 }}%):</span>
                                <span id="adminFee">Rp {{ number_format($kloter->admin_fee_amount ?? 10000, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Estimasi giliran arisan:</span>
                                <span id="estimatedTurn">-</span>
                            </div>
                            <div class="summary-item">
                                <span><strong>Total per {{ $period }}:</strong></span>
                                <span id="totalMonthlyPayment"><strong>-</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="agreement">
                            <label class="checkbox-container">
                                <input type="checkbox" id="agreeTerms" name="agree_terms" value="1">
                                <span>
                                    Saya setuju dengan semua aturan dan ketentuan kloter ini, termasuk:
                                    <br>• Pembayaran kontribusi tepat waktu sesuai slot yang dipilih
                                    <br>• Tidak dapat keluar sebelum mendapat giliran arisan
                                    <br>• Mengikuti sistem undian yang fair dan transparan
                                    <br>• Bergabung dalam grup koordinasi kloter
                                    <br>• Menunggu verifikasi admin sebelum dapat aktif
                                </span>
                            </label>
                        </div>

                        <div class="action-buttons">
                            <a href="{{ route('kloter.aktif') }}" class="btn btn-cancel">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-join" id="joinButton" disabled>
                                <i class="fas fa-handshake"></i>
                                Bergabung Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
        const kloterData = {
            id: {{ $kloter->id }},
            name: "{{ $kloter->name }}",
            nominal: {{ $kloter->nominal }},
            totalSlots: {{ $kloter->total_slots }},
            adminFeeAmount: {{ $kloter->admin_fee_amount ?? 10000 }},
            period: "{{ $period }}",
            durationUnit: "{{ $kloter->duration_unit }}"
        };

        const slotsData = @json($slots);
        let selectedSlot = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fungsi untuk cek apakah ada slot tersedia
        function hasAvailableSlots() {
            return slotsData.some(slot => !slot.is_taken);
        }

        // Pilih slot
        function selectSlot(slotNumber) {
            document.querySelectorAll('.slot-card').forEach(card => card.classList.remove('selected'));
            const slotCard = document.querySelector(`[data-slot="${slotNumber}"]`);
            if (slotCard && !slotCard.classList.contains('taken')) {
                slotCard.classList.add('selected');
                selectedSlot = slotNumber;
                updateSummary();
                checkFormValidity();
            }
        }

        // Update ringkasan
        function updateSummary() {
            const summarySection = document.getElementById('summarySection');
            if (!selectedSlot) {
                summarySection.style.display = 'none';
                return;
            }

            const slotData = slotsData.find(s => s.number === selectedSlot);
            if (!slotData) return;

            const monthlyPayment = slotData.monthly_payment;
            const adminFee = kloterData.adminFeeAmount;
            const totalMonthly = monthlyPayment + adminFee;

            document.getElementById('selectedSlotNumber').textContent = `Slot ${selectedSlot}`;
            document.getElementById('selectedMonthlyPayment').textContent = `Rp ${monthlyPayment.toLocaleString('id-ID')}`;
            document.getElementById('estimatedTurn').textContent = slotData.period_label;
            document.getElementById('totalMonthlyPayment').innerHTML = `<strong>Rp ${totalMonthly.toLocaleString('id-ID')}</strong>`;
            summarySection.style.display = 'block';
        }

        // Cek validitas form
        function checkFormValidity() {
            const agreeCheckbox = document.getElementById('agreeTerms');
            const agreeTerms = agreeCheckbox ? agreeCheckbox.checked : false;
            const joinButton = document.getElementById('joinButton');
            const availableSlots = hasAvailableSlots();
            const isValid = selectedSlot && agreeTerms && availableSlots;

            joinButton.disabled = !isValid;

            if (!availableSlots) {
                document.querySelectorAll('.slot-card').forEach(card => card.style.pointerEvents = 'none');
                showMessage('error', 'Maaf, semua slot sudah terisi.');
            } else if (!isValid) {
                let reason = [];
                if (!selectedSlot) reason.push('Belum pilih slot');
                if (!agreeTerms) reason.push('Belum centang persetujuan');
                showMessage('error', `Silakan lengkapi: ${reason.join(', ')}.`);
            } else {
                showMessage('', '');
                document.querySelectorAll('.slot-card').forEach(card => card.style.pointerEvents = 'auto');
            }
        }

        // Tampilkan pesan
        function showMessage(type, message) {
            const errorDiv = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMessage');
            errorDiv.style.display = 'none';
            successDiv.style.display = 'none';

            if (type === 'error' && errorDiv) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else if (type === 'success' && successDiv) {
                successDiv.textContent = message;
                successDiv.style.display = 'block';
                successDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        // Handle form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('joinKloterForm');
            if (!form) return;

            if (!hasAvailableSlots()) {
                const slotsGrid = document.getElementById('slotsGrid');
                slotsGrid.innerHTML = `
                    <div style="
                        background: #fef2f2;
                        border: 1px solid #fecaca;
                        color: #991b1b;
                        padding: 16px;
                        border-radius: 12px;
                        text-align: center;
                        font-weight: 500;
                    ">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Maaf, semua slot sudah terisi. Anda tidak bisa bergabung saat ini.
                    </div>
                `;
                document.getElementById('joinButton').disabled = true;
                document.querySelectorAll('.slot-card').forEach(card => card.style.pointerEvents = 'none');
                return;
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showMessage('', '');

                if (!hasAvailableSlots()) {
                    showMessage('error', 'Maaf, semua slot sudah terisi.');
                    return;
                }

                if (!selectedSlot) {
                    showMessage('error', 'Silakan pilih salah satu slot yang tersedia.');
                    return;
                }

                const agreeCheckbox = document.getElementById('agreeTerms');
                if (!agreeCheckbox.checked) {
                    showMessage('error', 'Anda harus menyetujui aturan dan ketentuan terlebih dahulu.');
                    return;
                }

                const joinButton = document.getElementById('joinButton');
                const originalHTML = joinButton.innerHTML;
                joinButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                joinButton.disabled = true;
                const container = document.querySelector('.container');
                if (container) container.classList.add('loading');

                const formData = { slot_number: selectedSlot, agree_terms: 1 };

                fetch(`/kloter/${kloterData.id}/join`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (container) container.classList.remove('loading');
                    joinButton.innerHTML = originalHTML;
                    joinButton.disabled = false;

                    if (data.success) {
                        showMessage('success', data.message || 'Permintaan bergabung berhasil dikirim, menunggu verifikasi admin.');
                        joinButton.innerHTML = '<i class="fas fa-check-circle"></i> Permintaan Dikirim!';
                        joinButton.style.background = 'linear-gradient(135deg, #059669, #047857)';
                        joinButton.disabled = true;
                        if (data.data) showSuccessPopup(data.data);
                    } else {
                        showMessage('error', data.message || 'Terjadi kesalahan saat mengirim permintaan.');
                    }
                })
                .catch(error => {
                    if (container) container.classList.remove('loading');
                    joinButton.innerHTML = originalHTML;
                    joinButton.disabled = false;
                    showMessage('error', 'Terjadi kesalahan koneksi. Silakan coba lagi.');
                    console.error('Fetch error:', error);
                });
            });

            document.getElementById('agreeTerms').addEventListener('change', checkFormValidity);
            checkFormValidity();
        });

        // Show success popup
        function showSuccessPopup(data) {
            const overlay = document.createElement('div');
            overlay.className = 'popup-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(8px);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            `;

            overlay.innerHTML = `
                <div class="success-popup" style="
                    background: white;
                    border-radius: 20px;
                    max-width: 600px;
                    width: 90%;
                    max-height: 90vh;
                    overflow-y: auto;
                    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
                    transform: scale(0.9);
                    transition: transform 0.3s ease;
                ">
                    <div class="popup-header" style="
                        background: linear-gradient(135deg, #059669, #047857);
                        color: white;
                        padding: 40px 30px;
                        text-align: center;
                        border-radius: 20px 20px 0 0;
                    ">
                        <div class="success-icon" style="
                            width: 80px;
                            height: 80px;
                            background: rgba(255, 255, 255, 0.2);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 20px;
                            animation: successPulse 2s ease-in-out infinite;
                        ">
                            <i class="fas fa-check-circle" style="font-size: 2.5rem;"></i>
                        </div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px;">
                            Permintaan Berhasil Dikirim!
                        </h2>
                        <p style="font-size: 1.1rem; opacity: 0.9;">
                            Menunggu verifikasi dari admin
                        </p>
                    </div>
                    <div class="popup-content" style="padding: 30px;">
                        <div class="kloter-details" style="
                            background: #f8fafc;
                            border-radius: 12px;
                            padding: 24px;
                            margin-bottom: 24px;
                        ">
                            <h3 style="
                                color: #1e293b;
                                font-size: 1.2rem;
                                font-weight: 600;
                                margin-bottom: 16px;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                                <i class="fas fa-info-circle" style="color: #059669;"></i> 
                                Detail Pendaftaran
                            </h3>
                            <div style="display: grid; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                    <span style="color: #64748b; font-weight: 500;">Kloter:</span>
                                    <span style="color: #1e293b; font-weight: 600;">${data.kloter_name}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                    <span style="color: #64748b; font-weight: 500;">Slot yang dipilih:</span>
                                    <span style="color: #1e293b; font-weight: 600;">${data.slot_number}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                    <span style="color: #64748b; font-weight: 500;">Pembayaran ${kloterData.period}:</span>
                                    <span style="color: #1e293b; font-weight: 600;">Rp ${data.monthly_payment.toLocaleString('id-ID')}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0;">
                                    <span style="color: #64748b; font-weight: 500;">Status:</span>
                                    <span style="color: #dc2626; font-weight: 600; background: #fef2f2; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">Menunggu Verifikasi</span>
                                </div>
                            </div>
                        </div>
                        <div class="next-steps" style="
                            background: #f8fafc;
                            border-radius: 12px;
                            padding: 24px;
                            margin-bottom: 24px;
                        ">
                            <h3 style="
                                color: #1e293b;
                                font-size: 1.2rem;
                                font-weight: 600;
                                margin-bottom: 16px;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                                <i class="fas fa-tasks" style="color: #10b981;"></i> 
                                Langkah Selanjutnya
                            </h3>
                            <div style="display: grid; gap: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: white; border-radius: 8px; border-left: 4px solid #10b981;">
                                    <i class="fas fa-clock" style="color: #10b981; font-size: 1.2rem; width: 20px; text-align: center;"></i>
                                    <span style="color: #374151; line-height: 1.5;">Tunggu verifikasi dari admin (1-24 jam)</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: white; border-radius: 8px; border-left: 4px solid #10b981;">
                                    <i class="fas fa-users" style="color: #10b981; font-size: 1.2rem; width: 20px; text-align: center;"></i>
                                    <span style="color: #374151; line-height: 1.5;">Tunggu hingga semua slot terisi penuh</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 12px; padding: 16px; background: white; border-radius: 8px; border-left: 4px solid #10b981;">
                                    <i class="fas fa-credit-card" style="color: #10b981; font-size: 1.2rem; width: 20px; text-align: center;"></i>
                                    <span style="color: #374151; line-height: 1.5;">Mulai pembayaran sesuai jadwal yang ditentukan</span>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center; background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 20px; border-radius: 12px; margin-bottom: 0; border: 1px solid #fbbf24;">
                           
                            <span style="color: #92400e; font-weight: 500; font-size: 1.1rem;">Terima kasih telah bergabung dengan <strong>${data.kloter_name}</strong>!</span>
                        </div>
                    </div>
                    <div style="padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                        <button onclick="closePopupAndRedirect()" style="
                            background: linear-gradient(135deg, #10b981, #059669);
                            color: white;
                            padding: 14px 32px;
                            border-radius: 12px;
                            border: none;
                            font-size: 1rem;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                        ">
                            <i class="fas fa-home"></i>
                            Kembali ke Daftar Kloter
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(overlay);
            const style = document.createElement('style');
            style.textContent = `@keyframes successPulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }`;
            document.head.appendChild(style);

            setTimeout(() => {
                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';
                overlay.querySelector('.success-popup').style.transform = 'scale(1)';
            }, 100);
        }

        function closePopupAndRedirect() {
            const overlay = document.querySelector('.popup-overlay');
            if (overlay) {
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
                setTimeout(() => {
                    document.body.removeChild(overlay);
                    window.location.href = '{{ route("kloter.aktif") }}';
                }, 300);
            }
        }
    </script>
</body>
</html>