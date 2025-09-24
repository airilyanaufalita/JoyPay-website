<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'JoyPay' }}</title>
    <style>

    </style>
</head>
<body>
@php
        $page = $page ?? 'default';
        echo '<!-- Debug: Page set to ' . $page . ' -->';  // Tambah ini buat cek
    @endphp
@if (!in_array($page ?? '', ['forgot-password', 'reset-password', 'login', 'register', 'kloter-bergabung', 'kloter-user']))
    @auth
        @include('layouts.header-user')
    @else
        @include('layouts.header')
    @endauth
@endif

    <main>
        
        @php
            $page = $page ?? 'default';
        @endphp

        @switch($page)
            @case('dashboard')
                @include('pages.dashboard')
                @break

            @case('home')
                @include('pages.home')
                @break

            @case('informasi')
                @include('pages.informasi')
                @break

            @case('kamus')
                @include('pages.kamus')
                @break

@case('profil')
    @include('profile.profil')
    @break
@case('kloter')
    @include('kloters.index')
    @break
            @case('kloteraktif')
                @include('pages.kloteraktif')
                @break
                @case('kloter-detail')
    @include('pages.kloter-detail')
    @break
    @case('kloter-bergabung')
    @include('pages.kloter-bergabung')
    @break
        @case('kloter-bayar')
    @include('pages.kloter-bayar')
    @break
        @case('kloter-user')
    @include('pages.kloter-user')
    @break
 @case('forgot-password')
    @include('auth.forgot-password')
    @break
        
@case('reset-password')
    @include('auth.reset-password')
    @break

    @case('pemenang')
    @include('pages.pemenang')
    @break
@case('pemenang-detail')
    @include('pages.pemenang-detail')
    @break

            @case('login')
                @include('auth.login')
                @break

            @case('register')
                @include('auth.register') 
                @break

            @default
                <p>Halaman tidak ditemukan</p>
        @endswitch
    </main>
    @if (!in_array($page ?? '', ['forgot-password', 'reset-password', 'login', 'register', 'kloter-bergabung', 'kloter-user']))
        @include('layouts.footer')
    @endif

</body>
</html>
