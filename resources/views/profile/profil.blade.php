<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6B9B76;
            --primary-light: #7BA05B;
            --text-dark: #2d4f3a;
            --text-light: #6b7280;
            --bg-light: #f8fdf9;
            --border: #e8f4ea;
            --white: #ffffff;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
        }

        body {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding: 24px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .back-btn {
            background: var(--white);
            color: var(--text-dark);
            padding: 12px 20px;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 500;
            box-shadow: var(--shadow);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .logout-btn {
            background: var(--danger);
            color: var(--white);
            border: none;
            padding: 12px 20px;
            border-radius: var(--radius);
            font-weight: 500;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* Main Card */
        .card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-hover);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, rgba(107,155,118,0.05), rgba(123,160,91,0.02));
            padding: 48px 40px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 600;
            margin: 0 auto 24px;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .card-subtitle {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Content */
        .card-body {
            padding: 40px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            padding: 4px;
            background: var(--bg-light);
            border-radius: var(--radius);
        }

        .tab {
            flex: 1;
            padding: 12px 24px;
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            color: var(--text-light);
            transition: all 0.2s ease;
        }

        .tab.active {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: 15px;
            background: var(--white);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(107,155,118,0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        /* Error states */
        .form-input.error {
            border-color: var(--danger);
        }

        .error-message {
            color: var(--danger);
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Full width inputs */
        .form-group.full-width {
            grid-column: 1 / -1;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: var(--radius);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            min-width: 140px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-hover);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        /* Password Section */
        .password-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .password-form .form-group {
            margin-bottom: 20px;
        }

        .forgot-link {
            text-align: center;
            margin: 20px 0;
        }

        .forgot-link a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-link a:hover {
            text-decoration: underline;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background: var(--white);
            padding: 32px;
            border-radius: 16px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: var(--shadow-hover);
            transform: scale(0.9);
            transition: transform 0.2s ease;
        }

        .modal-overlay.show .modal {
            transform: scale(1);
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .modal-icon i {
            font-size: 24px;
            color: var(--danger);
        }

        .modal h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .modal p {
            color: var(--text-light);
            margin-bottom: 24px;
        }

        .modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: var(--text-dark);
            padding: 12px 24px;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-confirm {
            background: var(--danger);
            color: var(--white);
            padding: 12px 24px;
            border-radius: var(--radius);
            border: none;
            cursor: pointer;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .header {
                flex-direction: column;
                gap: 16px;
            }

            .back-btn, .logout-btn {
                width: 100%;
                justify-content: center;
            }

            .card-header {
                padding: 32px 24px;
            }

            .card-body {
                padding: 24px;
            }

            .tabs {
                flex-direction: column;
                gap: 4px;
            }

            .tab {
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .modal {
                margin: 20px;
                padding: 24px;
            }
        }

        /* Loading state */
        .btn.loading {
            position: relative;
            color: transparent;
        }

        .btn.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            
            <button type="button" class="logout-btn" onclick="showModal()">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>

        <!-- Main Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h1 class="card-title">{{ $user->name }}</h1>
                <p class="card-subtitle">Kelola informasi profil Anda</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" onclick="switchTab(event, 'profile')">
                        <i class="fas fa-user"></i> Profil
                    </button>
                    <button class="tab" onclick="switchTab(event, 'password')">
                        <i class="fas fa-lock"></i> Password
                    </button>
                </div>

                <!-- Profile Tab -->
                <div id="profile" class="tab-content active">
                    <form action="{{ route('profile.update') }}" method="POST" id="profile-form">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       class="form-input @error('name') error @enderror" placeholder="Nama lengkap" required>
                                @error('name')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="form-input @error('email') error @enderror" placeholder="Email" required>
                                @error('email')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label" for="address">Alamat</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" 
                                       class="form-input @error('address') error @enderror" placeholder="Alamat lengkap">
                                @error('address')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="phone">No. Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="form-input @error('phone') error @enderror" placeholder="Nomor telepon">
                                @error('phone')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="emergency_phone">No. Darurat</label>
                                <input type="text" id="emergency_phone" name="emergency_phone" value="{{ old('emergency_phone', $user->emergency_phone) }}" 
                                       class="form-input @error('emergency_phone') error @enderror" placeholder="Nomor darurat">
                                @error('emergency_phone')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="social_media">Media Sosial</label>
                                <input type="text" id="social_media" name="social_media" value="{{ old('social_media', $user->social_media) }}" 
                                       class="form-input @error('social_media') error @enderror" placeholder="Username sosmed">
                                @error('social_media')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="account_number">No. Rekening</label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $user->account_number) }}" 
                                       class="form-input @error('account_number') error @enderror" placeholder="Nomor rekening">
                                @error('account_number')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- Password Tab -->
                <div id="password" class="tab-content">
                    <form action="{{ route('profile.password') }}" method="POST" class="password-form" id="password-form">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="current_password">Password Lama</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-input @error('current_password') error @enderror" placeholder="Password saat ini" required>
                            @error('current_password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Password Baru</label>
                            <input type="password" id="password" name="password" 
                                   class="form-input @error('password') error @enderror" placeholder="Password baru" required>
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-input @error('password_confirmation') error @enderror" placeholder="Ulangi password baru" required>
                            @error('password_confirmation')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="forgot-link">
                            <a href="{{ route('forgot.form') }}">Lupa Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key"></i>
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Forms -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Modal -->
    <div class="modal-overlay" id="modal">
        <div class="modal">
            <div class="modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3>Konfirmasi Logout</h3>
            <p>Yakin ingin keluar dari akun Anda?</p>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="hideModal()">Batal</button>
                <button class="btn-confirm" onclick="logout()">Logout</button>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(evt, tabName) {
            // Hide all tab contents
            const tabContents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }

            // Remove active class from all tabs
            const tabs = document.getElementsByClassName('tab');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }

            // Show selected tab and mark button as active
            document.getElementById(tabName).classList.add('active');
            evt.currentTarget.classList.add('active');
        }

        // Modal functions
        function showModal() {
            document.getElementById('modal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            document.getElementById('modal').classList.remove('show');
            document.body.style.overflow = '';
        }

        function logout() {
            const btn = document.querySelector('.btn-confirm');
            btn.textContent = 'Logging out...';
            btn.disabled = true;
            
            setTimeout(() => {
                document.getElementById('logout-form').submit();
            }, 500);
        }

        // Close modal on outside click
        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) hideModal();
        });

        // Close modal on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') hideModal();
        });

        // Form loading states
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });

        document.getElementById('password-form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            }
        });

        // Auto-hide success message
        const alert = document.querySelector('.alert-success');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            }, 4000);
        }
    </script>
</body>
</html>