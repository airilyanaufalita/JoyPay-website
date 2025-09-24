<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Verifikasi Email Anda</h1>
    <p>
        Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.<br>
        Jika Anda tidak menerima email,
    </p>

    @if (session('message'))
        <p style="color:green">{{ session('message') }}</p>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>
</body>
</html>
