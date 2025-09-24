<aside class="sidebar">
        <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="sidebar-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-shield me-2"></i>
                            Admin Panel
                        </h5>
                        <small class="text-muted">Arisan Barokah</small>
                    </div>
                    
                    <div class="sidebar-menu">
                        
                            <li class="nav-item">
    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" 
       href="/admin/dashboard">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>
</li>
<li class="nav-item">
<a class="nav-link {{ request()->routeIs('admin.konfirmasi-pendaftaran') ? 'active' : '' }}"
   href="{{ route('admin.konfirmasi-pendaftaran') }}">
    <i class="fas fa-user-check"></i>
    Konfirmasi Pendaftaran
</a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/manajemen-user') ? 'active' : '' }}" 
       href="/admin/manajemen-user">
        <i class="fas fa-users"></i>
        Manajemen Pengguna
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/arisan-aktif') ? 'active' : '' }}" 
       href="/admin/arisan-aktif">
        <i class="fas fa-list-alt"></i>
        Daftar Arisan Aktif
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/konfirmasi-masuk-kloter') ? 'active' : '' }}" 
       href="/admin/konfirmasi-masuk-kloter">
        <i class="fas fa-sign-in-alt"></i>
        Konfirmasi Masuk Kloter
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/konfirmasi-pembayaran') ? 'active' : '' }}" 
       href="/admin/konfirmasi-pembayaran">
        <i class="fas fa-check-circle"></i>
        Konfirmasi Pembayaran
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/jadwal-pembayaran') ? 'active' : '' }}" 
       href="/admin/jadwal-pembayaran">
        <i class="fas fa-calendar-alt"></i>
        Jadwal & Pembayaran
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('admin/testimoni') ? 'active' : '' }}" 
       href="/admin/testimoni">
        <i class="fas fa-comments"></i>
        Manajemen Testimoni
    </a>
</li>

                        <div class="mt-4 px-3">
                            <form action="/admin/logout" method="POST">
                                <input type="hidden" name="_token" value="dummy-csrf-token">
                                <button type="submit" class="logout-btn w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </nav>
</aside>

<style>
    body { background-color: #f8f9fa; }
        
        .sidebar {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #404040;
        }
        
        .sidebar-menu { padding: 20px 0; }
        
        .sidebar-menu .nav-link {
            color: #b0b0b0;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: white;
            background-color: rgba(220, 53, 69, 0.2);
            border-left: 4px solid #dc3545;
        }
        
        .sidebar-menu .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .top-bar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .top-bar, .filter-section, .content-card {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.8rem;
            color: white;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            border-radius: 10px;
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        