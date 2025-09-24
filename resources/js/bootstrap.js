document.addEventListener('DOMContentLoaded', () => {
    let kloterData = window.kloterData || {};
    
    // Fallback kalau kosong
    if (!kloterData.id) {
        kloterData = {
            id: 0,
            name: '',
            totalAmount: 0,
            totalSlots: 12,
            adminFeePercent: 2,
            takenSlots: [],
            period: 'bulan',
            category: 'bulanan'
        };
        console.warn('Using fallback kloterData');
    }
    
    console.log('JS kloterData:', kloterData);  // Debug
    
    let selectedSlot = null;

    // Sisanya sama: generateSlots(), calculateMonthlyPayment(), dll. (copy dari kode sebelumnya)
    function generateSlots() {
        const grid = document.getElementById('slotsGrid');
        if (!grid) return console.error('Grid not found');
        grid.innerHTML = '';
        for (let i = 1; i <= kloterData.totalSlots; i++) {
            const isTaken = kloterData.takenSlots.includes(i);
            const payment = calculateMonthlyPayment(i);
            const card = document.createElement('div');
            card.className = `slot-card ${isTaken ? 'taken' : ''}`;
            card.dataset.slot = i;
            if (!isTaken) card.addEventListener('click', () => selectSlot(i));
            card.innerHTML = `
                <div class="slot-header">
                    <div class="slot-number">${i}</div>
                    <div class="slot-status ${isTaken ? 'status-taken' : 'status-available'}">${isTaken ? 'Terisi' : 'Tersedia'}</div>
                </div>
                <div class="slot-info">
                    ${!isTaken ? `<div class="monthly-payment">Rp ${payment.toLocaleString('id-ID')}</div><div class="payment-description">Per ${kloterData.period}</div><div class="slot-benefits">Giliran ke-${i} • ${getSlotAdvantage(i)}</div>` : `<div class="taken-member"><i class="fas fa-user"></i> Terisi</div><div class="payment-description">Sudah diambil</div>`}
                </div>
            `;
            grid.appendChild(card);
        }
    }

    function calculateMonthlyPayment(slot) {
        const base = kloterData.totalAmount / kloterData.totalSlots;
        const adjustment = (kloterData.totalSlots - slot + 1) * (base * 0.08);
        return Math.round(base + adjustment);
    }

    function getSlotAdvantage(slot) {
        const third = Math.floor(kloterData.totalSlots / 3);
        if (slot <= third) return "Bayar tinggi, dapat cepat";
        if (slot <= third * 2) return "Seimbang";
        return "Bayar ringan, tunggu akhir";
    }

    function selectSlot(slot) {
        document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
        const card = document.querySelector(`[data-slot="${slot}"]`);
        if (card) card.classList.add('selected');
        selectedSlot = slot;
        updateSummary();
        checkFormValidity();
    }

    function updateSummary() {
        const section = document.getElementById('summarySection');
        if (!selectedSlot || !section) return section.style.display = 'none';
        const payment = calculateMonthlyPayment(selectedSlot);
        const fee = kloterData.totalAmount * (kloterData.adminFeePercent / 100);
        const total = payment + fee;
        section.style.display = 'block';
        document.getElementById('selectedSlotNumber').textContent = `Slot ${selectedSlot}`;
        document.getElementById('selectedMonthlyPayment').textContent = `Rp ${payment.toLocaleString('id-ID')}`;
        document.getElementById('estimatedTurn').textContent = `${kloterData.period.charAt(0).toUpperCase() + kloterData.period.slice(1)} ke-${selectedSlot}`;
        document.getElementById('totalMonthlyPayment').textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    function checkFormValidity() {
        const checkbox = document.getElementById('agreeTerms');
        const button = document.getElementById('joinButton');
        if (button && checkbox) button.disabled = !selectedSlot || !checkbox.checked;
    }

    function processJoin() {
        const errorEl = document.getElementById('errorMessage');
        const checkbox = document.getElementById('agreeTerms');
        if (!selectedSlot || !checkbox.checked) {
            errorEl.textContent = 'Pilih slot & setuju ketentuan.';
            errorEl.style.display = 'block';
            return;
        }
        errorEl.style.display = 'none';

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/kloter/${kloterData.id}/join`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify({ slot_number: selectedSlot, monthly_payment: calculateMonthlyPayment(selectedSlot) })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('popupSlotNumber').textContent = selectedSlot;
                document.getElementById('popupMonthlyPayment').textContent = `Rp ${(calculateMonthlyPayment(selectedSlot) + kloterData.totalAmount * (kloterData.adminFeePercent / 100)).toLocaleString('id-ID')}`;
                document.getElementById('popupEstimatedTurn').textContent = `${kloterData.period} ke-${selectedSlot}`;
                document.getElementById('popupOverlay').style.display = 'flex';
            } else {
                errorEl.textContent = data.message || 'Gagal bergabung.';
                errorEl.style.display = 'block';
            }
        })
        .catch(err => {
            console.error(err);
            errorEl.textContent = 'Error jaringan.';
            errorEl.style.display = 'block';
        });
    }

    function closePopupAndRedirect() {
        document.getElementById('popupOverlay').style.display = 'none';
        window.location.href = '/kloterAktif';
    }

    // Init
    generateSlots();
    document.getElementById('agreeTerms').addEventListener('change', checkFormValidity);
});