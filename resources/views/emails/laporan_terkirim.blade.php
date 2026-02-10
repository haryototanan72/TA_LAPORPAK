<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Terkirim</title>
</head>
<body>
    <h2>Laporan Baru Masuk</h2>

    <p><strong>Nomor Laporan:</strong> {{ $laporan->nomor_laporan }}</p>
    <p><strong>Kategori:</strong> {{ $laporan->kategori }}</p>
    <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>

    <p>Detail lengkap terdapat pada file PDF terlampir.</p>
</body>
</html>
