# 🛠️ LaporPak! - Platform Pelaporan Infrastruktur Rusak

**LaporPak!** adalah platform berbasis web yang memungkinkan masyarakat melaporkan kondisi infrastruktur publik yang rusak, seperti jalan berlubang atau jembatan yang bermasalah.  
Tujuannya adalah menciptakan transparansi antara masyarakat dan pemerintah, serta membantu pemerintah menentukan prioritas perbaikan berdasarkan laporan yang masuk.

---

## 🎯 Tujuan Proyek
- Memberikan **saluran resmi** bagi warga untuk melaporkan kerusakan infrastruktur.  
- Menyediakan **dashboard interaktif** untuk pemerintah dalam memantau laporan dan mengambil keputusan.  
- Meningkatkan **partisipasi masyarakat** dalam pembangunan infrastruktur yang lebih baik.  
- Menjamin **transparansi & akuntabilitas** melalui tracking laporan dan umpan balik.

---

## ✨ Fitur Utama
### Untuk Warga (User)
- **Pelaporan kerusakan**: kirim laporan dengan deskripsi, foto, dan lokasi.  
- **Kategori laporan**: pilih jenis infrastruktur (jalan, jembatan, dll.).  
- **Tracking laporan**: cek status laporan dengan nomor unik.  
- **Umpan balik**: berikan pendapat setelah perbaikan selesai.  

### Untuk Admin / Pemerintah
- **Dashboard laporan**: melihat daftar laporan masuk.  
- **Statistik & peta**: visualisasi sebaran laporan berdasarkan wilayah.  
- **Filter & pencarian**: cari laporan berdasarkan kategori, status, atau ID laporan.  
- **Manajemen laporan**: ubah status (baru, diproses, selesai), beri catatan tindak lanjut.  

---

## 🏗️ Arsitektur Sistem (Sederhana)

- **Frontend (User & Admin)**: Laravel Blade / Bootstrap / Tailwind.  
- **Backend**: Laravel (REST API untuk laporan & dashboard).  
- **Database**: MySQL.  
- **Deployment**: XAMPP / Laravel Sail / VPS.  

---

## 🔮 Fitur Masa Depan (Roadmap)
- **Mobile App (Android/iOS)** → memudahkan laporan langsung via smartphone.  
- **Machine Learning** → validasi foto & klasifikasi tingkat kerusakan.  
- **IoT Integration (Crowd Sensing)** → gunakan sensor smartphone (GPS, accelerometer) untuk laporan otomatis.  
- **Gamifikasi** → poin, leaderboard, badge untuk meningkatkan partisipasi warga.  
- **Data Fusion** → integrasi dengan data pemerintah atau sensor IoT jalan/lampu.  

---

## ⚙️ Cara Menjalankan Proyek
1. **Clone repository**
   ```bash
   git clone https://github.com/username/laporpak.git
   cd laporpak
2. **Instal Dependensi**
composer install
npm install && npm run dev

3. **Setup environment**

Copy .env.example ke .env
Atur konfigurasi database MySQL
Generate key
php artisan key:generate