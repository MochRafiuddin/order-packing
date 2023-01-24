-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2023 at 05:53 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_kurir`
--

CREATE TABLE `m_kurir` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 1,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_kurir`
--

INSERT INTO `m_kurir` (`id`, `nama`, `deleted`, `created_date`, `updated_date`) VALUES
(1, 'Jnt', 1, '2023-01-17 03:55:32', '2023-01-17 03:55:32'),
(2, 'sicepat', 1, '2023-01-17 03:55:46', '2023-01-17 03:55:46'),
(3, 'Jnt cargo', 1, '2023-01-17 03:56:00', '2023-01-17 03:56:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_marketplace`
--

CREATE TABLE `m_marketplace` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 1,
  `updated_date` datetime NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_marketplace`
--

INSERT INTO `m_marketplace` (`id`, `nama`, `deleted`, `updated_date`, `created_date`) VALUES
(1, 'shopee', 1, '2023-01-17 03:32:14', '2023-01-17 03:32:14'),
(2, 'tokopedia', 1, '2023-01-17 03:33:16', '2023-01-17 03:32:29'),
(3, 'tiktok', 1, '2023-01-17 03:32:46', '2023-01-17 03:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `m_pengiriman`
--

CREATE TABLE `m_pengiriman` (
  `id` int(11) NOT NULL,
  `kode` text NOT NULL,
  `tanggal` date NOT NULL,
  `id_marketplace` int(11) NOT NULL,
  `id_kurir` int(11) NOT NULL,
  `cetak` int(1) NOT NULL COMMENT '1 sudah 0 belum',
  `verifikasi` int(1) NOT NULL COMMENT ' 0 belum, 1 menunggu, 2 approve, 3 tolak',
  `catatan_verif` text DEFAULT NULL,
  `file` text DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT 1,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_pengiriman`
--

INSERT INTO `m_pengiriman` (`id`, `kode`, `tanggal`, `id_marketplace`, `id_kurir`, `cetak`, `verifikasi`, `catatan_verif`, `file`, `deleted`, `created_date`, `updated_date`) VALUES
(1, '[C@27a51b21673851385388.pdf', '2023-01-17', 3, 1, 1, 2, 'mmmm', '1674017548424.png', 1, '2023-01-17 10:32:29', '2023-01-18 06:16:11'),
(3, 'Label Pengiriman-273.pdf', '2023-01-17', 1, 1, 0, 1, NULL, '1674021469963.jpg', 1, '2023-01-17 10:41:38', '2023-01-18 05:57:50'),
(4, '[C@66e8bf91673851393911.pdf', '2023-01-18', 3, 1, 1, 2, 'dsds', '1674023208252.jpg', 1, '2023-01-18 02:46:40', '2023-01-19 08:34:07'),
(5, 'Label Pengiriman-413.pdf', '2023-01-18', 1, 1, 0, 1, NULL, '1674024459394.jpg', 1, '2023-01-18 06:24:13', '2023-01-18 06:47:39'),
(6, 'Label Pengiriman-281.pdf', '2023-01-18', 1, 1, 0, 1, NULL, '1674024501381.png', 1, '2023-01-18 06:24:13', '2023-01-18 06:48:21'),
(7, 'Label Pengiriman-413.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:34:36', '2023-01-19 08:41:45'),
(8, 'Label Pengiriman-281.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:34:36', '2023-01-19 08:41:54'),
(9, 'Label Pengiriman-413.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:35:51', '2023-01-19 08:42:02'),
(10, 'Label Pengiriman-281.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:35:51', '2023-01-19 08:42:14'),
(11, 'Label Pengiriman-413.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:37:44', '2023-01-19 08:42:24'),
(12, 'Label Pengiriman-281.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 0, '2023-01-19 08:37:44', '2023-01-19 08:42:36'),
(13, 'Label Pengiriman-413.pdf', '2023-01-19', 1, 1, 0, 1, NULL, '63c90f14ad65b.png', 1, '2023-01-19 08:53:11', '2023-01-19 09:36:20'),
(14, 'Label Pengiriman-281.pdf', '2023-01-19', 1, 1, 0, 0, NULL, NULL, 1, '2023-01-19 08:53:11', '2023-01-19 08:53:11'),
(15, 'Label Pengiriman-413.pdf', '2023-01-20', 1, 1, 0, 0, NULL, NULL, 1, '2023-01-20 02:31:40', '2023-01-20 02:31:40'),
(16, 'Label Pengiriman-281.pdf', '2023-01-20', 1, 1, 0, 0, NULL, NULL, 1, '2023-01-20 02:31:42', '2023-01-20 02:31:42'),
(17, '[C@27a51b21673851385388.pdf', '2023-01-20', 3, 1, 0, 1, NULL, '63ca1b2630e0e.png', 1, '2023-01-20 02:34:32', '2023-01-20 04:40:06'),
(18, '[C@66e8bf91673851393911.pdf', '2023-01-20', 3, 1, 0, 1, NULL, '63c9ff699f3f8.png', 1, '2023-01-20 02:34:33', '2023-01-20 02:41:45'),
(19, 'Label Pengiriman-273.pdf', '2023-01-20', 1, 1, 1, 1, NULL, '63c9fe5e7dbdc.png', 1, '2023-01-20 02:35:38', '2023-01-20 02:37:41'),
(20, '[C@27a51b21673851385388.pdf', '2023-01-20', 3, 1, 0, 0, NULL, NULL, 1, '2023-01-20 04:40:18', '2023-01-20 04:40:18'),
(21, '[C@27a51b21673851385388.pdf', '2023-01-20', 3, 1, 0, 0, NULL, NULL, 1, '2023-01-20 04:40:27', '2023-01-20 04:40:27'),
(22, '[C@66e8bf91673851393911.pdf', '2023-01-20', 3, 1, 0, 0, NULL, NULL, 1, '2023-01-20 04:40:28', '2023-01-20 04:40:28'),
(23, 'Label Pengiriman-273.pdf', '2023-01-20', 1, 1, 0, 0, NULL, NULL, 1, '2023-01-20 04:40:29', '2023-01-20 04:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE `m_users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 1,
  `created_date` timestamp NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `m_users`
--

INSERT INTO `m_users` (`id_user`, `username`, `password`, `deleted`, `created_date`, `updated_date`) VALUES
(1, 'admin', '$2y$10$442wusHOKmBPXxXoP.zKyOJ3B7/V4/iORVBR7DTCXNFH2C5K1R9ya', 1, '2023-01-17 02:37:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kurir`
--
ALTER TABLE `m_kurir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_marketplace`
--
ALTER TABLE `m_marketplace`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_pengiriman`
--
ALTER TABLE `m_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_kurir`
--
ALTER TABLE `m_kurir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_marketplace`
--
ALTER TABLE `m_marketplace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_pengiriman`
--
ALTER TABLE `m_pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `m_users`
--
ALTER TABLE `m_users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
