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
        <strong>Kategori:</strong> {{ $laporan->kategori }}<br>
        <strong>Deskripsi:</strong> {{ $laporan->deskripsi }}<br>
        <strong>Tanggal Laporan:</strong> {{ $laporan->created_at->format('d M Y H:i') }}<br>
        <strong>Koordinat:</strong> {{ $laporan->lokasi }}<br>
            <a>Lihat lokasi di Google Maps: </a><br>
            <a href="{{ $googleMapsUrl }}">
                {{ $googleMapsUrl }}
            </a>
            <br>
        <strong>Bukti Laporan:</strong><br>
        @if($imageBase64)
            <img src="{{ $imageBase64 }}" 
                style="width:300px; height:auto; margin-top:10px;">
        @else
            <p>Gambar tidak tersedia</p>
        @endif

    </p>

    <p>
        Hormat kami,<br>
        <strong>Admin LaporPak</strong>
    </p>
</body>
</html>
