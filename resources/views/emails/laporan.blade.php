<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Infrastruktur Rusak</title>
</head>
<body>
    <h2>Laporan Infrastruktur Rusak</h2>

    <p>
        Bersama email ini kami sampaikan laporan kerusakan infrastruktur
        yang telah diverifikasi melalui sistem <strong>LaporPak</strong>.
    </p>

    <p>
        <strong>Nomor Laporan:</strong> {{ $laporan->nomor_laporan }} <br>
        <strong>Lokasi:</strong> {{ $laporan->lokasi }} <br>
        <strong>Kategori:</strong> {{ $laporan->kategori }}
    </p>

    <p>
        Detail lengkap laporan terlampir dalam dokumen PDF.
    </p>

    <p>
        Hormat kami,<br>
        <strong>Admin LaporPak</strong>
    </p>
</body>
</html>
