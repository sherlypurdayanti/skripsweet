-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2025 pada 19.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bestama_skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_akhir`
--

CREATE TABLE `hasil_akhir` (
  `id_hasil` int(4) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `nilai_akhir` varchar(10) NOT NULL,
  `keputusan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `bobot_atasan` decimal(5,2) DEFAULT NULL,
  `bobot_rekan` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `bobot_atasan`, `bobot_rekan`) VALUES
(1, 'Presensi', 30.00, 0.00),
(2, 'Keterampilan Teknis\r\n', 40.00, 20.00),
(3, 'Perilaku', 60.00, 40.00),
(4, 'Key Perfomance Index', 30.00, 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `periode` enum('Januari - Juni','Juli - Desember') NOT NULL,
  `penilai` varchar(20) DEFAULT NULL,
  `kriteria_id` int(11) DEFAULT NULL,
  `sub_kriteria_id` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `nip`, `nama`, `tahun`, `periode`, `penilai`, `kriteria_id`, `sub_kriteria_id`, `nilai`, `tanggal_input`) VALUES
(2, '12345678', 'Andi Wijaya', 2000, 'Januari - Juni', '1', 1, 1, 90, '2025-05-06 11:44:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` int(11) NOT NULL,
  `kriteria_id` int(11) DEFAULT NULL,
  `nama_sub_kriteria` varchar(100) NOT NULL,
  `kategori_kriteria` varchar(100) DEFAULT NULL,
  `bobot_atasan` decimal(5,2) DEFAULT NULL,
  `bobot_rekan` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `kriteria_id`, `nama_sub_kriteria`, `kategori_kriteria`, `bobot_atasan`, `bobot_rekan`) VALUES
(1, 1, 'Presensi', 'Presensi', 30.00, 0.00),
(2, 2, 'Kualitas Kerja', 'Keterampilan Teknis', 20.00, 10.00),
(3, 2, 'Inisiatif', 'Keterampilan Teknis', 20.00, 10.00),
(5, 3, 'Tata Tertib', 'Perilaku', 20.00, 25.00),
(6, 3, 'Kedisiplinan', 'Perilaku', 20.00, 0.00),
(7, 3, 'Hubungan Antar Rekan', 'Perilaku', 20.00, 25.00),
(8, 4, 'Target', 'Key Perfomance Index', 30.00, 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_karyawan`
--

CREATE TABLE `tabel_karyawan` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bagian` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` enum('Karyawan Tetap','Karyawan Harian Lepas') DEFAULT NULL,
  `perusahaan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_karyawan`
--

INSERT INTO `tabel_karyawan` (`nip`, `nama`, `bagian`, `jabatan`, `tanggal_masuk`, `status`, `perusahaan`) VALUES
('12233443', 'Budi Santoso', 'Teknologi Informasi', 'Staff HRD', '2000-09-07', 'Karyawan Tetap', 'PT. Karis Water'),
('20220101 02 1001', 'Bella Putri Wulandari', 'HRD', 'Staff HRD', '2022-01-01', 'Karyawan Harian Lepas', 'PT. Berkah Sejahtera Investama');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_keputusan`
--

CREATE TABLE `tabel_keputusan` (
  `id_keputusan` int(11) NOT NULL,
  `bobot_nilai` varchar(5) NOT NULL,
  `keputusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('hrd_karis','hrd_tgm','hrd_foleya','hrd_wisyam','hrd_bestama','manager_hrd','direktur_utama') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'HRD001', 'hrd_tgm', '$2y$10$YYZPA321kTjn.cqa3MYkN.UAOxC0eT8nSQdpvhz.1rse2YzSW0cWm', 'hrd_tgm', '2025-05-18 15:54:23'),
(2, 'HRD002', 'hrd_bestama', '$2y$10$dEuHkOjkOoKMucs2fbzSTuZ6ioySlizmThy7rw6gUfRgVoc6VPxuu', 'hrd_bestama', '2025-05-18 15:54:23'),
(3, 'HRD003', 'hrd_wisyam', '$2y$10$DKHvB0B4DwO4b5P0qybZXuPw8Bpj4/zDMQX/LnLKGygeVwbW6zTbG', 'hrd_wisyam', '2025-05-18 15:54:23'),
(4, 'HRD004', 'hrd_foleya', '$2y$10$IktDVkeXC8JeMljtDSHOBeTVwA9sHjAa.664cZhYNTdIsvLVS25e2', 'hrd_foleya', '2025-05-18 15:54:23'),
(5, 'HRD005', 'hrd_karis', '$2y$10$LZYL.O8ZNB16c1I2VAyQhOVixQYhoDCUgO5oLOtIRNfkWZ8MLALxG', 'hrd_karis', '2025-05-18 15:54:23'),
(6, 'HRD006', 'managerhrd', '$2y$10$pXkX/guHGtZhx9BnLFrW6uuGQFa.pqMY2hM05qbBK.EzePSdM5EOi', 'manager_hrd', '2025-05-18 15:54:23'),
(7, 'HRD007', 'direkturutama', '$2y$10$mNv5SF6uH0vi.WUaJfhHdOEJSs2gMkFtXxybe1gg9KBoXj9J5swJi', 'direktur_utama', '2025-05-18 15:54:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `kriteria_id` (`kriteria_id`),
  ADD KEY `sub_kriteria_id` (`sub_kriteria_id`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indeks untuk tabel `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`sub_kriteria_id`) REFERENCES `sub_kriteria` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
