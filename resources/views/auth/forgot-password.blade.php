<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JoyPay</title>
    <link rel="stylesheet" href="{{ asset('css/forgot-reset.css') }}">
</head>
<div class="forgot-password-form">
    <div class="left-panel">
        <div class="brand-content">
            <h1>Arisan Barokah</h1>
            <p>Platform arisan digital terpercaya sejak 2020</p>
            
            <div class="features">
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    <span>Keamanan terjamin</span>
                </div>
                
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                    <span>Komunitas terpercaya</span>
                </div>
                
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                    <span>Mudah digunakan</span>
                </div>
                
                <div class="feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M12 1v6m0 6v6"/>
                    </svg>
                    <span>Otomatis & praktis</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-panel">
        <h2>Lupa Password?</h2>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('forgot.check') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="name">name</label>
                <input type="text" id="name" name="name" placeholder="Masukkan name Anda" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required>
            </div>

            <button type="submit" class="submit-btn">Verifikasi Data</button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('login') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7fb069" stroke-width="2">
                    <path d="M19 12H5"/>
                    <path d="M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Login
            </a>
        </div>
    </div>
</div>
</html>