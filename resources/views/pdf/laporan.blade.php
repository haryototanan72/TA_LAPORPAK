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
        <strong>Kategori:</strong> {{ $laporan->kategori }}<br>
        <strong>Deskripsi:</strong> {{ $laporan->deskripsi }}<br>
        <strong>Tanggal Laporan:</strong> {{ $laporan->created_at->format('d M Y H:i') }}<br>
        <strong>Bukti Laporan:</strong> {{ $laporan->bukti_laporan }}<br>

    </p>

    <p>
        Hormat kami,<br>
        <strong>Admin LaporPak</strong>
    </p>
</body>
</html>
