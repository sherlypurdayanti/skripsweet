-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2025 pada 15.13
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
  `id_kriteria` varchar(5) NOT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `bobot_atasan` decimal(5,2) DEFAULT NULL,
  `bobot_rekan` decimal(5,2) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot_atasan`, `bobot_rekan`, `status_aktif`) VALUES
('K01', 'Presensi', 30.00, 0.00, 0),
('K02', 'Keterampilan Teknis', 40.00, 20.00, 0),
('K03', 'Perilaku', 60.00, 40.00, 0),
('K04', 'Key Perfomance Index', 30.00, 20.00, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `nip_penilai` varchar(20) DEFAULT NULL,
  `tipe_penilai` enum('Atasan','Rekan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `nip_dinilai` varchar(20) DEFAULT NULL,
  `nip_penilai` varchar(20) DEFAULT NULL,
  `tipe_penilai` enum('Atasan','Rekan') DEFAULT NULL,
  `id_kriteria` varchar(5) DEFAULT NULL,
  `id_subkriteria` varchar(5) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `periode_id` int(3) DEFAULT NULL,
  `tanggal_penilaian` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode_penilaian`
--

CREATE TABLE `periode_penilaian` (
  `id_periode` int(11) NOT NULL,
  `nama_periode` enum('Januari-Juni','Juli-Desemeber') NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `periode_penilaian`
--

INSERT INTO `periode_penilaian` (`id_periode`, `nama_periode`, `tahun`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`) VALUES
(1, 'Januari-Juni', 2025, '2025-01-03', '2025-06-02', 0),
(2, 'Juli-Desemeber', 2025, '2025-07-03', '2026-01-02', 0),
(3, 'Januari-Juni', 2024, '2024-01-03', '2024-06-02', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_subkriteria` varchar(5) NOT NULL,
  `id_kriteria` varchar(5) DEFAULT NULL,
  `kategori_kriteria` varchar(100) DEFAULT NULL,
  `nama_sub_kriteria` varchar(100) DEFAULT NULL,
  `bobot_atasan` decimal(5,2) DEFAULT NULL,
  `bobot_rekan` decimal(5,2) DEFAULT NULL,
  `status_aktif` tinyint(1) DEFAULT 1,
  `tipe_karyawan` enum('Karyawan Tetap','Karyawan Harian Lepas','Semua') DEFAULT NULL,
  `tipe_penilai` enum('Atasan','Rekan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_subkriteria`, `id_kriteria`, `kategori_kriteria`, `nama_sub_kriteria`, `bobot_atasan`, `bobot_rekan`, `status_aktif`, `tipe_karyawan`, `tipe_penilai`) VALUES
('SK01', 'K01', 'Presensi', 'Presensi', 30.00, 0.00, 0, NULL, NULL),
('SK02', 'K02', 'Keterampilan Teknis', 'Kualitas Kerja', 20.00, 10.00, 0, NULL, NULL),
('SK03', 'K02', 'Keterampilan Teknis', 'Inisiatif', 20.00, 10.00, 0, NULL, NULL),
('SK04', 'K03', 'Perilaku', 'Tata Tertib', 20.00, 25.00, 0, NULL, NULL),
('SK05', 'K03', 'Perilaku', 'Kedisiplinan', 20.00, 10.00, 0, NULL, NULL),
('SK06', 'K03', 'Perilaku', 'Hubungan Antar Rekan', 20.00, 25.00, 0, NULL, NULL),
('SK07', 'K04', 'Key Perfomance Index', 'Target', 30.00, 0.00, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_karyawan`
--

CREATE TABLE `tabel_karyawan` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) DEFAULT NULL,
  `bagian` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `status` enum('Karyawan Tetap','Karyawan Harian Lepas') DEFAULT NULL,
  `perusahaan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_karyawan`
--

INSERT INTO `tabel_karyawan` (`nip`, `nama`, `jenis_kelamin`, `bagian`, `jabatan`, `tanggal_masuk`, `status`, `perusahaan`) VALUES
('12233443', 'Budi Santoso', 'Laki-laki', 'Admin', 'Staff HRD', '2000-09-07', 'Karyawan Tetap', 'PT. Karis Water'),
('20220101 02 1001', 'Bella Putri Wulandari', 'Perempuan', NULL, 'Staff HRD', '2022-01-01', 'Karyawan Harian Lepas', 'PT. Berkah Sejahtera Investama');

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
(1, 'HRD001', 'hrd_tgm', '$2y$10$YYZPA321kTjn.cqa3MYkN.UAOxC0eT8nSQdpvhz.1rse2YzSW0cWm', 'hrd_tgm', '2025-05-18 08:54:23'),
(2, 'HRD002', 'hrd_bestama', '$2y$10$dEuHkOjkOoKMucs2fbzSTuZ6ioySlizmThy7rw6gUfRgVoc6VPxuu', 'hrd_bestama', '2025-05-18 08:54:23'),
(3, 'HRD003', 'hrd_wisyam', '$2y$10$DKHvB0B4DwO4b5P0qybZXuPw8Bpj4/zDMQX/LnLKGygeVwbW6zTbG', 'hrd_wisyam', '2025-05-18 08:54:23'),
(4, 'HRD004', 'hrd_foleya', '$2y$10$IktDVkeXC8JeMljtDSHOBeTVwA9sHjAa.664cZhYNTdIsvLVS25e2', 'hrd_foleya', '2025-05-18 08:54:23'),
(5, 'HRD005', 'hrd_karis', '$2y$10$LZYL.O8ZNB16c1I2VAyQhOVixQYhoDCUgO5oLOtIRNfkWZ8MLALxG', 'hrd_karis', '2025-05-18 08:54:23'),
(6, 'HRD006', 'managerhrd', '$2y$10$pXkX/guHGtZhx9BnLFrW6uuGQFa.pqMY2hM05qbBK.EzePSdM5EOi', 'manager_hrd', '2025-05-18 08:54:23'),
(7, 'HRD007', 'direkturutama', '$2y$10$mNv5SF6uH0vi.WUaJfhHdOEJSs2gMkFtXxybe1gg9KBoXj9J5swJi', 'direktur_utama', '2025-05-18 08:54:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD KEY `nip_penilai` (`nip_penilai`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `nip_dinilai` (`nip_dinilai`),
  ADD KEY `nip_penilai` (`nip_penilai`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_subkriteria` (`id_subkriteria`),
  ADD KEY `periode_id` (`periode_id`);

--
-- Indeks untuk tabel `periode_penilaian`
--
ALTER TABLE `periode_penilaian`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `tabel_karyawan`
--
ALTER TABLE `tabel_karyawan`
  ADD PRIMARY KEY (`nip`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `periode_penilaian`
--
ALTER TABLE `periode_penilaian`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penilai`
--
ALTER TABLE `penilai`
  ADD CONSTRAINT `penilai_ibfk_1` FOREIGN KEY (`nip_penilai`) REFERENCES `tabel_karyawan` (`nip`);

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`nip_dinilai`) REFERENCES `tabel_karyawan` (`nip`),
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`nip_penilai`) REFERENCES `tabel_karyawan` (`nip`),
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`),
  ADD CONSTRAINT `penilaian_ibfk_4` FOREIGN KEY (`id_subkriteria`) REFERENCES `sub_kriteria` (`id_subkriteria`),
  ADD CONSTRAINT `penilaian_ibfk_5` FOREIGN KEY (`periode_id`) REFERENCES `periode_penilaian` (`id_periode`);

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
