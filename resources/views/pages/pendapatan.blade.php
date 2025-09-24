<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoyPay - Pendapatan Saya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Back Button */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: #475569;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.back-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    background: #f8fafc;
    color: #334155;
}

.back-button i {
    font-size: 1rem;
}

/* Page Header */
.page-header {
    text-align: center;
    margin-bottom: 40px;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    opacity: 0.03;
    z-index: 1;
}

.page-header > * {
    position: relative;
    z-index: 2;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #10b981, #059669);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #64748b;
    margin-bottom: 20px;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.stats-card {
    background: white;
    padding: 32px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #10b981, #059669);
    z-index: 1;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    color: white;
    font-size: 24px;
    position: relative;
}

.stats-icon::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 120%;
    height: 120%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    transform: translate(-50%, -50%);
    border-radius: 50%;
}

.stats-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.stats-label {
    color: #64748b;
    font-size: 1rem;
    font-weight: 500;
}

/* Content Section */
.content-section {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 32px;
}

.section-header {
    padding: 32px 32px 24px 32px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.section-subtitle {
    color: #64748b;
    font-size: 1.1rem;
}

/* Filters */
.filters {
    padding: 24px 32px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
    background: #fafbfc;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.filter-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
}

.filter-select {
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 0.95rem;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 140px;
}

.filter-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    transform: translateY(-1px);
}

.filter-select:hover {
    border-color: #9ca3af;
    background: #f9fafb;
}

/* Pendapatan List */
.pendapatan-list {
    padding: 0;
}

.pendapatan-item {
    padding: 28px 32px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
}

.pendapatan-item:last-child {
    border-bottom: none;
}

.pendapatan-item:hover {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    transform: translateX(8px);
}

.pendapatan-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: linear-gradient(135deg, #10b981, #059669);
    transition: width 0.3s ease;
}

.pendapatan-item:hover::before {
    width: 4px;
}

.pendapatan-info {
    display: flex;
    align-items: center;
    flex: 1;
}

.pendapatan-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-right: 20px;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.pendapatan-icon::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% { transform: scale(0.8) rotate(0deg); opacity: 0.3; }
    50% { transform: scale(1.2) rotate(180deg); opacity: 0.6; }
}

.pendapatan-details {
    flex: 1;
}

.pendapatan-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.pendapatan-meta {
    display: flex;
    gap: 20px;
    font-size: 0.95rem;
    color: #64748b;
    align-items: center;
}

.pendapatan-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.pendapatan-meta i {
    font-size: 0.85rem;
}

.pendapatan-amount {
    text-align: right;
}

.amount-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #10b981;
    margin-bottom: 6px;
}

.amount-date {
    font-size: 0.95rem;
    color: #64748b;
    font-weight: 500;
}

/* Status Badges */
.status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-received {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #f59e0b;
}

/* Empty State */
.empty-state {
    padding: 80px 32px;
    text-align: center;
    color: #64748b;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 24px;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 12px;
    color: #374151;
}

.empty-state p {
    font-size: 1.1rem;
    line-height: 1.6;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    padding: 32px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-top: 1px solid #e2e8f0;
}

.pagination button {
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s ease;
    min-width: 44px;
}

.pagination button:hover:not(:disabled) {
    background: #f3f4f6;
    border-color: #9ca3af;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.pagination button.active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-color: #10b981;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination button:disabled:hover {
    transform: none;
    box-shadow: none;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }

    .page-header {
        padding: 32px 20px;
    }

    .page-title {
        font-size: 2rem;
    }

    .page-subtitle {
        font-size: 1rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stats-card {
        padding: 24px 16px;
    }

    .stats-icon {
        width: 64px;
        height: 64px;
        font-size: 24px;
    }

    .stats-value {
        font-size: 1.8rem;
    }

    .section-header,
    .filters,
    .pendapatan-item {
        padding: 20px 16px;
    }

    .pendapatan-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .pendapatan-info {
        width: 100%;
    }

    .pendapatan-amount {
        width: 100%;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filters {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .filter-group {
        width: 100%;
        justify-content: space-between;
    }

    .filter-select {
        flex: 1;
        max-width: 200px;
    }

    .pagination {
        padding: 20px 16px;
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stats-value {
        font-size: 1.6rem;
    }

    .amount-value {
        font-size: 1.5rem;
    }

    .pendapatan-title {
        font-size: 1.1rem;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .pendapatan-meta {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }
}

/* Additional Interactive Elements */
.stats-card:hover .stats-icon {
    transform: scale(1.05);
}

.pendapatan-item:hover .pendapatan-icon {
    transform: scale(1.05) rotate(5deg);
}

/* Smooth transitions for all interactive elements */
* {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #059669, #047857);
}
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h1 class="page-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Pendapatan Saya
                </h1>
                <p class="page-subtitle">Riwayat pendapatan dari kloter arisan yang Anda ikuti</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stats-value">Rp 1.500.000</div>
                <div class="stats-label">Total Pendapatan</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stats-value">3</div>
                <div class="stats-label">Kloter Selesai</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-value">2</div>
                <div class="stats-label">Menunggu Giliran</div>
            </div>
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stats-value">5</div>
                <div class="stats-label">Total Kloter</div>
            </div>
        </div>

        <!-- Riwayat Pendapatan -->
        <div class="content-section">
            <div class="section-header">
                <h2 class="section-title">Riwayat Pendapatan</h2>
                <p class="section-subtitle">Daftar pendapatan yang telah Anda terima dari kloter arisan</p>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <label class="filter-label">Status:</label>
                    <select class="filter-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="received">Sudah Diterima</option>
                        <option value="pending">Menunggu Giliran</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tahun:</label>
                    <select class="filter-select" id="yearFilter">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Kloter:</label>
                    <select class="filter-select" id="kloterFilter">
                        <option value="">Semua Kloter</option>
                        <option value="arisan-berkah">Arisan Berkah</option>
                        <option value="arisan-rezeki">Arisan Rezeki</option>
                        <option value="arisan-harapan">Arisan Harapan</option>
                    </select>
                </div>
            </div>

            <div class="pendapatan-list" id="pendapatanList">
                <!-- Pendapatan Item 1 -->
                <div class="pendapatan-item" data-status="received" data-year="2024" data-kloter="arisan-berkah">
                    <div class="pendapatan-info">
                        <div class="pendapatan-icon">
                            <i class="fas fa-hand-holding-dollar"></i>
                        </div>
                        <div class="pendapatan-details">
                            <h3 class="pendapatan-title">Kloter Arisan Berkah</h3>
                            <div class="pendapatan-meta">
                                <span><i class="fas fa-users"></i> Slot 10 dari 12</span>
                                <span><i class="fas fa-calendar"></i> Minggu ke-10</span>
                                <span class="status-badge status-received">Diterima</span>
                            </div>
                        </div>
                    </div>
                    <div class="pendapatan-amount">
                        <div class="amount-value">Rp 500.000</div>
                        <div class="amount-date">15 Okt 2024</div>
                    </div>
                </div>

                <!-- Pendapatan Item 2 -->
                <div class="pendapatan-item" data-status="received" data-year="2024" data-kloter="arisan-rezeki">
                    <div class="pendapatan-info">
                        <div class="pendapatan-icon">
                            <i class="fas fa-hand-holding-dollar"></i>
                        </div>
                        <div class="pendapatan-details">
                            <h3 class="pendapatan-title">Kloter Arisan Rezeki</h3>
                            <div class="pendapatan-meta">
                                <span><i class="fas fa-users"></i> Slot 5 dari 10</span>
                                <span><i class="fas fa-calendar"></i> Minggu ke-5</span>
                                <span class="status-badge status-received">Diterima</span>
                            </div>
                        </div>
                    </div>
                    <div class="pendapatan-amount">
                        <div class="amount-value">Rp 1.000.000</div>
                        <div class="amount-date">22 Sep 2024</div>
                    </div>
                </div>

                <!-- Pendapatan Item 3 - Pending -->
                <div class="pendapatan-item" data-status="pending" data-year="2024" data-kloter="arisan-harapan">
                    <div class="pendapatan-info">
                        <div class="pendapatan-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="pendapatan-details">
                            <h3 class="pendapatan-title">Kloter Arisan Harapan</h3>
                            <div class="pendapatan-meta">
                                <span><i class="fas fa-users"></i> Slot 8 dari 15</span>
                                <span><i class="fas fa-calendar"></i> Minggu ke-8</span>
                                <span class="status-badge status-pending">Menunggu</span>
                            </div>
                        </div>
                    </div>
                    <div class="pendapatan-amount">
                        <div class="amount-value">Rp 750.000</div>
                        <div class="amount-date">Est. Des 2024</div>
                    </div>
                </div>

                <!-- Pendapatan Item 4 - Pending -->
                <div class="pendapatan-item" data-status="pending" data-year="2024" data-kloter="arisan-berkah">
                    <div class="pendapatan-info">
                        <div class="pendapatan-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="pendapatan-details">
                            <h3 class="pendapatan-title">Kloter Arisan Berkah (Baru)</h3>
                            <div class="pendapatan-meta">
                                <span><i class="fas fa-users"></i> Slot 12 dari 12</span>
                                <span><i class="fas fa-calendar"></i> Minggu ke-12</span>
                                <span class="status-badge status-pending">Menunggu</span>
                            </div>
                        </div>
                    </div>
                    <div class="pendapatan-amount">
                        <div class="amount-value">Rp 500.000</div>
                        <div class="amount-date">Est. Feb 2025</div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button id="prevBtn" disabled><i class="fas fa-chevron-left"></i></button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button id="nextBtn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const yearFilter = document.getElementById('yearFilter');
            const kloterFilter = document.getElementById('kloterFilter');
            const pendapatanItems = document.querySelectorAll('.pendapatan-item');

            function filterItems() {
                const statusValue = statusFilter.value;
                const yearValue = yearFilter.value;
                const kloterValue = kloterFilter.value;

                let visibleCount = 0;

                pendapatanItems.forEach(item => {
                    const itemStatus = item.dataset.status;
                    const itemYear = item.dataset.year;
                    const itemKloter = item.dataset.kloter;

                    const statusMatch = !statusValue || itemStatus === statusValue;
                    const yearMatch = !yearValue || itemYear === yearValue;
                    const kloterMatch = !kloterValue || itemKloter === kloterValue;

                    if (statusMatch && yearMatch && kloterMatch) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show empty state if no items visible
                const pendapatanList = document.getElementById('pendapatanList');
                const existingEmptyState = pendapatanList.querySelector('.empty-state');
                
                if (visibleCount === 0) {
                    if (!existingEmptyState) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'empty-state';
                        emptyState.innerHTML = `
                            <i class="fas fa-search"></i>
                            <h3>Tidak Ada Data</h3>
                            <p>Tidak ada pendapatan yang sesuai dengan filter yang dipilih.</p>
                        `;
                        pendapatanList.appendChild(emptyState);
                    }
                } else {
                    if (existingEmptyState) {
                        existingEmptyState.remove();
                    }
                }
            }

            statusFilter.addEventListener('change', filterItems);
            yearFilter.addEventListener('change', filterItems);
            kloterFilter.addEventListener('change', filterItems);

            // Pagination functionality
            const paginationButtons = document.querySelectorAll('.pagination button:not(#prevBtn):not(#nextBtn)');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            paginationButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    paginationButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Update prev/next button states
                    prevBtn.disabled = index === 0;
                    nextBtn.disabled = index === paginationButtons.length - 1;
                });
            });

            prevBtn.addEventListener('click', function() {
                const currentActive = document.querySelector('.pagination button.active');
                const prevButton = currentActive.previousElementSibling;
                if (prevButton && !prevButton.id) {
                    prevButton.click();
                }
            });

            nextBtn.addEventListener('click', function() {
                const currentActive = document.querySelector('.pagination button.active');
                const nextButton = currentActive.nextElementSibling;
                if (nextButton && !nextButton.id) {
                    nextButton.click();
                }
            });

            // Add hover effects to pendapatan items
            pendapatanItems.forEach(item => {
                item.addEventListener('click', function() {
                    // You can add click functionality here
                    console.log('Clicked item:', this.querySelector('.pendapatan-title').textContent);
                });
            });
        });

        // Update statistics when filters change
        function updateStatistics() {
            const visibleItems = document.querySelectorAll('.pendapatan-item[style="display: flex;"], .pendapatan-item:not([style])');
            const receivedItems = Array.from(visibleItems).filter(item => item.dataset.status === 'received');
            const pendingItems = Array.from(visibleItems).filter(item => item.dataset.status === 'pending');
            
            // Calculate total pendapatan from visible received items
            let totalPendapatan = 0;
            receivedItems.forEach(item => {
                const amountText = item.querySelector('.amount-value').textContent;
                const amount = parseInt(amountText.replace(/[^0-9]/g, ''));
                totalPendapatan += amount;
            });

            // Update stats (you can implement this to update the actual numbers)
            console.log('Total Pendapatan:', totalPendapatan);
            console.log('Received Items:', receivedItems.length);
            console.log('Pending Items:', pendingItems.length);
        }
    </script>
</body>
</html>