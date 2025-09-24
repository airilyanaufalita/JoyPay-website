<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JoyPay</title>
    <link rel="stylesheet" href="{{ asset('css/login-register.css') }}">
</head>
<body>
    <div class="login-form">
        <div class="left-panel">
            <div class="brand-content">
                <h1>Arisan Barokah</h1>
                <p>Platform arisan digital terpercaya sejak 2020</p>
                
                <div class="features">
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/>
                            <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/>
                            <path d="M3 12h6m6 0h6"/>
                        </svg>
                        <span>Keamanan terjamin</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span>Komunitas terpercaya</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                        <span>Mudah digunakan</span>
                    </div>
                    
                    <div class="feature-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 1v6m0 6v6"/>
                            <path d="M21 12h-6m-6 0H3"/>
                        </svg>
                        <span>Otomatis & praktis</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-panel">
            <a href="{{ route('home') }}" class="back-btn">Kembali ke Beranda</a>
            <h2>Login</h2>

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                    @error('email') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                    @error('password') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>
            
            <div class="privacy-notice">
                <a href="{{ route('register') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7fb069" stroke-width="2">
                       
                    </svg>
                    Belum punya akun? Daftar sekarang
                </a>
            </div>

            <div class="privacy-notice">
                <a href="{{ route('forgot.form') }}">Lupa Password?</a>
            </div>
        </div>
    </div>
</body>
</html>