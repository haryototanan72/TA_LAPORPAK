-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2026 at 12:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporpak2`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `isi` text NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `gambar` varchar(255) DEFAULT NULL,
  `test_tag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `kategori`, `isi`, `tanggal_terbit`, `status`, `gambar`, `test_tag`, `created_at`, `updated_at`) VALUES
(1, 'Jalan Rusak di Pasar Kordon Ganggu Aktivitas Warga, Pemerintah Diminta Bertindak Cepat', 'Jalan Rusak', '<p>Kerusakan jalan di kawasan Pasar Kordon semakin parah dan mengganggu aktivitas warga yang melintas setiap hari. Lubang besar dan permukaan jalan yang bergelombang menyebabkan kemacetan, terutama pada jam sibuk, serta meningkatkan risiko kecelakaan bagi pengendara motor. Warga berharap pemerintah segera melakukan perbaikan karena kondisi ini telah lama dikeluhkan namun belum mendapatkan penanganan yang signifikan.</p>\n', '2025-11-17', 'publish', 'berita/1763378430.jpeg', NULL, '2025-11-17 04:20:30', '2025-11-17 04:20:30'),
(2, 'Perbaikan Jalan Di Pasar Kordon!', 'Jalan', '<p>Perbaikan jalan telah rampung</p>\n', '2025-11-18', 'publish', 'berita/1763433684.jpeg', NULL, '2025-11-17 19:41:24', '2025-11-17 19:41:24');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` enum('diajukan','diverifikasi','diterima','ditolak','ditindaklanjuti','ditanggapi','selesai') NOT NULL DEFAULT 'diajukan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Siapa saja yang dapat menggunakan LaporPak?', 'LaporPak dapat digunakan oleh seluruh masyarakat umum tanpa terkecuali. Baik individu, kelompok, maupun organisasi dapat menyampaikan laporan, saran, atau keluhan melalui platform ini tanpa perlu memiliki akun khusus.', 1, '2025-11-17 04:17:52', '2025-11-17 04:17:52'),
(2, 'Berapa lama waktu yang dibutuhkan untuk menindaklanjuti laporan saya?', 'Waktu tindak lanjut dapat bervariasi tergantung pada jenis laporan dan instansi yang terkait. Namun, secara umum laporan akan mulai diproses dalam waktu 1–3 hari kerja setelah dikirimkan, dan pelapor akan mendapatkan notifikasi jika ada perkembangan.', 1, '2025-11-17 04:18:27', '2025-11-17 04:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `laporan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `kategori` varchar(255) NOT NULL,
  `feedback_file` varchar(255) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `saran` text DEFAULT NULL,
  `is_processed` tinyint(1) NOT NULL DEFAULT 0,
  `testcase_tag` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `laporan_id`, `rating`, `kategori`, `feedback_file`, `pesan`, `saran`, `is_processed`, `testcase_tag`, `created_at`, `updated_at`) VALUES
(2, 2, 1, NULL, 'Jalan Rusak', 'feedback_proof/1OYHmbdbR1UHcs6RczD4nfgDHbNsNrLZWKbbNs7t.jpg', NULL, NULL, 0, NULL, '2025-11-17 07:44:02', '2025-11-17 07:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `instansis`
--

CREATE TABLE `instansis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"6307c4c7-c5d1-4473-a9f3-321ff564ae36\",\"displayName\":\"App\\\\Notifications\\\\FeedbackUserRequest\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\FeedbackUserRequest\\\":2:{s:10:\\\"\\u0000*\\u0000laporan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Laporan\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"4bf44642-a88e-48af-9295-8c8af9ab1229\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"}}', 0, NULL, 1763388204, 1763388204),
(2, 'default', '{\"uuid\":\"1f57dfff-ca28-4df8-b05d-1f2345ede96e\",\"displayName\":\"App\\\\Notifications\\\\FeedbackUserRequest\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\FeedbackUserRequest\\\":2:{s:10:\\\"\\u0000*\\u0000laporan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Laporan\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"4bf44642-a88e-48af-9295-8c8af9ab1229\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1763388204, 1763388204),
(3, 'default', '{\"uuid\":\"c1d999ce-f9df-46ed-a09a-2c6cbc99ae13\",\"displayName\":\"App\\\\Notifications\\\\FeedbackUserRequest\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\FeedbackUserRequest\\\":2:{s:10:\\\"\\u0000*\\u0000laporan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Laporan\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"fac614ad-be5c-456e-a522-c6e3ec9acb38\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"}}', 0, NULL, 1763390642, 1763390642),
(4, 'default', '{\"uuid\":\"e4b82329-0a8d-4a2b-8f9a-38f461e3f8d9\",\"displayName\":\"App\\\\Notifications\\\\FeedbackUserRequest\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:37:\\\"App\\\\Notifications\\\\FeedbackUserRequest\\\":2:{s:10:\\\"\\u0000*\\u0000laporan\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Laporan\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"fac614ad-be5c-456e-a522-c6e3ec9acb38\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:8:\\\"database\\\";}}\"}}', 0, NULL, 1763390642, 1763390642);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_laporan` enum('Privat','Publik') NOT NULL,
  `bukti_laporan` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `ciri_khusus` varchar(255) DEFAULT NULL,
  `kategori` enum('Jalan Rusak','Jembatan Rusak','Banjir') NOT NULL,
  `deskripsi` text NOT NULL,
  `nomor_laporan` varchar(255) NOT NULL,
  `status` enum('diajukan','diverifikasi','diterima','ditolak','ditindaklanjuti','ditanggapi','selesai') NOT NULL DEFAULT 'diajukan',
  `verified_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `user_id`, `jenis_laporan`, `bukti_laporan`, `lokasi`, `ciri_khusus`, `kategori`, `deskripsi`, `nomor_laporan`, `status`, `verified_at`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Publik', 'bukti/D5BpYi6r6WC9jMtuRAsKUFlPY0oEgsPycXe3DVAV.jpg', '-6.9550299,107.6333816', NULL, 'Jalan Rusak', 'Terdapat jalan berlubang', 'LPR-YLU7O8W3', 'diverifikasi', NULL, NULL, '2025-11-17 04:12:48', '2025-11-17 07:31:11'),
(3, 1, 'Publik', 'bukti/YTbG7aMcj50wrnVMC4fhl4inkXCzuYiL4I4SgWeF.mp4', '-6.954156,107.6393081', 'Dekat tugu', 'Jalan Rusak', 'Terjadi kecelakaan karena adanya jalan rusak', 'LPR-9HBUHH2T', 'diajukan', NULL, NULL, '2025-11-17 06:28:05', '2025-11-17 06:28:05'),
(4, 1, 'Publik', 'bukti/8bxGxymA1SdIhAA9huvSd2cTKQoAMiN5c2tZjsyV.mp4', '-6.9550299,107.6333816', NULL, 'Jalan Rusak', 'Terjadi kecelakaan karna jalan berlubang', 'LPR-3ZLPZRWC', 'diajukan', NULL, NULL, '2025-11-17 20:28:58', '2025-11-17 20:28:58'),
(5, 1, 'Publik', 'bukti/Zspu6CDtTJqnYlwgvOppUi53wg5SWK5XrxugnILH.mp4', '-6.9550299,107.6333816', NULL, 'Jalan Rusak', 'Terjadi kecelakaan karna jalan berlubang', 'LPR-LXJUB0VR', 'diajukan', NULL, NULL, '2025-11-17 20:29:03', '2025-11-17 20:29:03'),
(6, 1, 'Publik', 'bukti/bn8LWzh5QOiUf9GjCxB37i8H1BetYcg5XPFDpUzE.jpg', '-6.9784956,107.6333816', NULL, 'Jalan Rusak', 'Jalan bolong', 'LPR-ELUZMVC3', 'diverifikasi', NULL, NULL, '2025-11-25 00:21:16', '2026-02-10 06:02:07'),
(7, 1, 'Publik', 'bukti/jeYGotLEUmRE3kjilGhpJQ3fogoKx9p4SizDKNZs.mp4', '-6.9135557,107.6126655', NULL, 'Jalan Rusak', 'Jalan berlubang', 'LPR-TOZKQTJO', 'diverifikasi', NULL, NULL, '2025-12-02 09:26:25', '2025-12-02 09:29:12'),
(8, 1, 'Privat', 'bukti/0XmlUsNiTKLSkbkbSgbIFgF0ZN9UousSzBiYHAjH.png', '-6.953551340246322,107.64386648441442', NULL, 'Jembatan Rusak', 'Jembatan rusak a', 'LPR-QUHEJZVR', 'diajukan', NULL, NULL, '2026-02-10 06:04:15', '2026-02-10 06:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_petugas`
--

CREATE TABLE `laporan_petugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laporan_id` bigint(20) UNSIGNED NOT NULL,
  `petugas_id` bigint(20) UNSIGNED NOT NULL,
  `status_verifikasi` varchar(255) DEFAULT NULL,
  `kondisi_lapangan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_petugas`
--

INSERT INTO `laporan_petugas` (`id`, `laporan_id`, `petugas_id`, `status_verifikasi`, `kondisi_lapangan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL, NULL, '2025-11-17 07:40:11', '2025-11-17 07:40:11'),
(2, 7, 1, NULL, NULL, NULL, '2025-12-02 09:31:49', '2025-12-02 09:31:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_15_095600_create_berita_table', 1),
(5, '2025_04_15_100438_add_role_to_users_table', 1),
(6, '2025_04_19_043339_create_reports_table', 1),
(7, '2025_04_25_082012_create_laporans_table', 1),
(8, '2025_04_25_083916_create_complaints_table', 1),
(9, '2025_04_26_221800_add_status_to_users_table', 1),
(10, '2025_04_27_000000_add_profile_fields_to_users_table', 1),
(11, '2025_04_27_000001_modify_status_enum_in_complaints_table', 1),
(12, '2025_04_28_000001_update_and_modify_status_enum_in_laporans_table', 1),
(13, '2025_04_28_000002_modify_status_enum_in_complaints_table', 1),
(14, '2025_04_28_000003_change_status_laporans_to_string', 1),
(15, '2025_04_28_000004_sync_status_enum_in_laporans_table', 1),
(16, '2025_05_07_140612_create_faqs_table', 1),
(17, '2025_05_10_000000_create_notifications_table', 1),
(18, '2025_05_11_072706_add_status_to_faqs_table', 1),
(19, '2025_05_14_063015_create_feedback_table', 1),
(20, '2025_05_15_000000_create_petugas_table', 1),
(21, '2025_05_16_000001_create_laporan_petugas_table', 1),
(22, '2025_05_16_082029_update_read_at_column_in_notifications_table', 1),
(23, '2025_05_17_140444_add_kondisi_lapangan_to_laporan_petugas_table', 1),
(24, '2025_05_20_043659_alter_notifications_data_to_longtext', 1),
(25, '2025_05_26_093100_check_berita_paths', 1),
(26, '2025_05_26_093800_check_first_berita', 1),
(27, '2025_05_26_093900_check_all_beritas', 1),
(28, '2025_05_26_100300_ensure_berita_table_exists', 1),
(29, '2025_05_26_100500_setup_berita_table', 1),
(30, '2025_05_31_180300_add_testcase_tag_to_feedback_table', 1),
(31, '2025_06_01_000001_add_test_tag_to_berita_table', 1),
(32, '2025_06_02_033000_add_feedback_file_to_feedback_table', 1),
(33, '2025_06_02_033100_make_rating_pesan_saran_nullable_on_feedback_table', 1),
(34, '2026_02_09_123145_add_points_and_title_to_users_table', 2),
(35, '2026_02_10_112144_add_verifikasi_fields_to_laporans_table', 3),
(36, '2026_02_10_113045_create_instansis_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` longtext NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1da1eb6b-e98a-4fac-af0d-173317608259', 'App\\Notifications\\LaporanStatusUpdated', 'App\\Models\\User', 1, '{\"laporan_id\":1,\"nomor_laporan\":\"LPR-YLU7O8W3\",\"status\":\"Diverifikasi\",\"message\":\"Status laporan \'LPR-YLU7O8W3\' telah berubah menjadi diverifikasi.\"}', '2025-11-17 07:44:48', '2025-11-17 07:31:28', '2025-11-17 07:44:48'),
('273c9e81-3c81-4b99-8192-ae13f620b130', 'App\\Notifications\\LaporanStatusUpdated', 'App\\Models\\User', 1, '{\"laporan_id\":7,\"nomor_laporan\":\"LPR-TOZKQTJO\",\"status\":\"Diverifikasi\",\"message\":\"Status laporan \'LPR-TOZKQTJO\' telah berubah menjadi diverifikasi.\"}', '2026-02-09 04:44:45', '2025-12-02 09:29:23', '2026-02-09 04:44:45'),
('e8ef577c-4c81-41e5-88f0-1435da53d934', 'App\\Notifications\\LaporanStatusUpdated', 'App\\Models\\User', 1, '{\"laporan_id\":6,\"nomor_laporan\":\"LPR-ELUZMVC3\",\"status\":\"Diverifikasi\",\"message\":\"Status laporan \'LPR-ELUZMVC3\' telah berubah menjadi diverifikasi.\"}', NULL, '2026-02-10 06:02:13', '2026-02-10 06:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kontak` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama`, `foto`, `kontak`, `created_at`, `updated_at`) VALUES
(1, 'rafi', 'petugas/5cx93odguGiRfTsxjXg2pqVC8Dypu8r1npfnHxGp.jpg', '0832142314123', '2025-11-17 07:30:18', '2025-11-17 07:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_laporan` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('Diajukan','Diproses','Diterima','Ditolak','Ditindaklanjuti','Ditanggapi','Selesai') NOT NULL DEFAULT 'Diajukan',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('XBgIsiDkY4qAulnxlvRUafOZY1G95Z8F9XqwT78o', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEY0bEZJaENHalVGMUVXTEd4QW1vMVkxN3gzd0FhVG00TDNsSEZJRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9mYXEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1770729030);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `status` enum('aktif','tidak aktif') NOT NULL DEFAULT 'aktif',
  `points` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL DEFAULT 'Warga Baru'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `address`, `profile_picture`, `gender`, `birth_date`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`, `points`, `title`) VALUES
(1, 'Haryo', 'user@example.com', '082312313912', 'Jl. Buah Batu', 'profile-pictures/vihkJzLSRu1kuVjFPXOCgpqvIf2oA8BqeUG8Ypym.jpg', 'Laki-laki', NULL, NULL, '$2y$12$Nf.vWG1mSsTgMluI6WND5uKLTuyZ7DT03imCpbBHgW5xHWqCr.ynG', NULL, '2025-11-17 04:09:38', '2026-02-09 06:15:32', 'user', 'aktif', 60, 'Pelapor Aktif'),
(2, 'Admin', 'admin@laporpak.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$w.VS2HISznyonTS05sJg8uyFa8.GlfUHBHu3LbP5b8lAYaO4v7IxG', NULL, '2025-11-17 04:15:03', '2025-11-17 04:15:03', 'admin', 'aktif', 0, 'Warga Baru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berita_test_tag_index` (`test_tag`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`),
  ADD KEY `feedback_laporan_id_foreign` (`laporan_id`);

--
-- Indexes for table `instansis`
--
ALTER TABLE `instansis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `laporans_nomor_laporan_unique` (`nomor_laporan`),
  ADD KEY `laporans_user_id_foreign` (`user_id`);

--
-- Indexes for table `laporan_petugas`
--
ALTER TABLE `laporan_petugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_petugas_laporan_id_foreign` (`laporan_id`),
  ADD KEY `laporan_petugas_petugas_id_foreign` (`petugas_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_nomor_laporan_unique` (`nomor_laporan`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `instansis`
--
ALTER TABLE `instansis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laporan_petugas`
--
ALTER TABLE `laporan_petugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan_petugas`
--
ALTER TABLE `laporan_petugas`
  ADD CONSTRAINT `laporan_petugas_laporan_id_foreign` FOREIGN KEY (`laporan_id`) REFERENCES `laporans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_petugas_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
