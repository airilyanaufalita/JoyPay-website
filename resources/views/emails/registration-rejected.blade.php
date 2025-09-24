<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Ditolak</title>
</head>
<body>
    <h2>Kepada {{ $name }},</h2>
    <p>Kami menyesal untuk menginformasikan bahwa pendaftaran Anda di Arisan Barokah telah ditolak.</p>
    
    <h3>Alasan Penolakan:</h3>
    <p>{{ $rejectionReason }}</p>
    
    @if($improvementSuggestion)
    <h3>Saran Perbaikan:</h3>
    <p>{{ $improvementSuggestion }}</p>
    @endif
    
    <p>Anda dapat mencoba mendaftar kembali setelah memperbaiki masalah yang disebutkan di atas.</p>
    <br>
    <p>Terima kasih,<br>Tim Arisan Barokah</p>
</body>
</html>