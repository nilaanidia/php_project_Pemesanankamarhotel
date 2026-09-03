-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Sep 2026 pada 21.32
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
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `checkin_checkout`
--

CREATE TABLE `checkin_checkout` (
  `ID_CHECKIN_OUT` int(11) NOT NULL,
  `ID_PEMESANAN` int(11) DEFAULT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `ID_KAMAR` int(11) DEFAULT NULL,
  `ID_JENIS_KAMAR` int(11) DEFAULT NULL,
  `TGL_CHECK_IN` date DEFAULT NULL,
  `JAM_CHECK_IN` time DEFAULT NULL,
  `LAMA_INAP` varchar(255) DEFAULT NULL,
  `TGL_CHECK_OUT` date DEFAULT NULL,
  `STATUS_PEMBAYARAN` varchar(125) NOT NULL,
  `STATUS_CHECKINOUT` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `checkin_checkout`
--

INSERT INTO `checkin_checkout` (`ID_CHECKIN_OUT`, `ID_PEMESANAN`, `ID_PELANGGAN`, `ID_KAMAR`, `ID_JENIS_KAMAR`, `TGL_CHECK_IN`, `JAM_CHECK_IN`, `LAMA_INAP`, `TGL_CHECK_OUT`, `STATUS_PEMBAYARAN`, `STATUS_CHECKINOUT`) VALUES
(12, 33, 37, 1, 1, '2025-12-29', '00:00:00', '4', '2026-01-02', 'Lunas', 'Sudah Checkout'),
(14, 35, 42, 2, 2, '2025-12-03', '00:00:00', '2', '2025-12-05', 'Lunas', 'Sudah Checkout'),
(21, 37, 74, 2, 2, '2026-08-26', '00:00:00', '1', '2026-08-27', 'Lunas', 'Sudah Checkout'),
(22, 36, 74, 1, 1, '2026-08-15', '00:00:00', '1', '2026-08-16', 'Lunas', 'Sudah Checkout');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_food_n_beverage`
--

CREATE TABLE `detail_food_n_beverage` (
  `ID_DETAIL_FNB` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `ID_FNB` int(11) DEFAULT NULL,
  `TGL_FNB` date DEFAULT NULL,
  `JAM_FNB` time DEFAULT NULL,
  `FOOD` varchar(255) DEFAULT NULL,
  `BEVERAGE` varchar(255) DEFAULT NULL,
  `JUMLAH_FNB` int(11) DEFAULT NULL,
  `SUBTOTAL_FNB` int(11) DEFAULT NULL,
  `TOTAL_FNB` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_food_n_beverage`
--

INSERT INTO `detail_food_n_beverage` (`ID_DETAIL_FNB`, `ID_PELANGGAN`, `ID_FNB`, `TGL_FNB`, `JAM_FNB`, `FOOD`, `BEVERAGE`, `JUMLAH_FNB`, `SUBTOTAL_FNB`, `TOTAL_FNB`) VALUES
(8, 74, 16, '2026-08-30', '17:02:00', '0', 'teh pucuk', 1, 90000, 90000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_laundry`
--

CREATE TABLE `detail_laundry` (
  `ID_DETAIL_LAUNDRY` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `ID_LAUNDRY` int(11) DEFAULT NULL,
  `TGL_LAUNDRY` date DEFAULT NULL,
  `JENIS_LAUNDRY` varchar(255) DEFAULT NULL,
  `JAM_LAUNDRY` time DEFAULT NULL,
  `HARGA_SATUAN` int(11) DEFAULT NULL,
  `JUMLAH_LAUNDRY` int(11) DEFAULT NULL,
  `TOTAL_LAUNDRY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_laundry`
--

INSERT INTO `detail_laundry` (`ID_DETAIL_LAUNDRY`, `ID_PELANGGAN`, `ID_LAUNDRY`, `TGL_LAUNDRY`, `JENIS_LAUNDRY`, `JAM_LAUNDRY`, `HARGA_SATUAN`, `JUMLAH_LAUNDRY`, `TOTAL_LAUNDRY`) VALUES
(10, 74, 10, '2026-08-30', '0', '17:02:00', 8965, 1, 8965);

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback_pelanggan`
--

CREATE TABLE `feedback_pelanggan` (
  `ID_FEEDBACK` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) NOT NULL,
  `ID_CHECKIN_OUT` int(100) NOT NULL,
  `RATING` int(11) NOT NULL,
  `KATEGORI_FEEDBACK` enum('pujian','saran','keluhan','') NOT NULL,
  `PESAN` text NOT NULL,
  `FOTO_FEEDBACK` varchar(255) NOT NULL,
  `TGL_FEEDBACK` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `feedback_pelanggan`
--

INSERT INTO `feedback_pelanggan` (`ID_FEEDBACK`, `ID_PELANGGAN`, `ID_CHECKIN_OUT`, `RATING`, `KATEGORI_FEEDBACK`, `PESAN`, `FOTO_FEEDBACK`, `TGL_FEEDBACK`) VALUES
(3, 37, 12, 5, 'pujian', 'wedfgh', 'feedback_1764746208_692fe3e09d592.jpg', '0000-00-00 00:00:00'),
(7, 37, 12, 5, 'saran', 'bnm,', 'feedback_1764747580_692fe93c2df72.png', '0000-00-00 00:00:00'),
(8, 42, 14, 5, 'saran', '222', 'feedback_1764776367_693059af22a2e.jpg', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `food_n_beverage`
--

CREATE TABLE `food_n_beverage` (
  `ID_FNB` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `ID_KAMAR` int(11) DEFAULT NULL,
  `KODE_FNB` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `food_n_beverage`
--

INSERT INTO `food_n_beverage` (`ID_FNB`, `ID_PELANGGAN`, `ID_KAMAR`, `KODE_FNB`) VALUES
(16, 74, 1, 'FNB001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kamar`
--

CREATE TABLE `jenis_kamar` (
  `ID_JENIS_KAMAR` int(11) NOT NULL,
  `JENIS_KAMAR` varchar(255) DEFAULT NULL,
  `FASILITAS` varchar(255) DEFAULT NULL,
  `TARIF` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_kamar`
--

INSERT INTO `jenis_kamar` (`ID_JENIS_KAMAR`, `JENIS_KAMAR`, `FASILITAS`, `TARIF`) VALUES
(1, 'delux', 'lengkap', 25000),
(2, 'Standard Room', 'AC, TV', 500000),
(3, 'Deluxe King', 'Lengkap, Bathtub', 850000),
(4, 'Family Suite', 'Lengkap, Dapur Kecil', 1500000),
(5, 'Executive Suite', 'Lengkap, Ruang Tamu', 2200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `ID_KAMAR` int(11) NOT NULL,
  `ID_JENIS_KAMAR` int(11) DEFAULT NULL,
  `NO_KAMAR` varchar(255) DEFAULT NULL,
  `STATUS` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`ID_KAMAR`, `ID_JENIS_KAMAR`, `NO_KAMAR`, `STATUS`) VALUES
(1, 1, '12', 'Tersedia'),
(2, 2, '1001', 'Tersedia'),
(3, 3, '2001', 'Tersedia'),
(5, 4, '3001', 'Tersedia'),
(6, 5, '4001', 'Tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laundry`
--

CREATE TABLE `laundry` (
  `ID_LAUNDRY` int(11) NOT NULL,
  `ID_KAMAR` int(11) DEFAULT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `KODE_LAUNDRY` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laundry`
--

INSERT INTO `laundry` (`ID_LAUNDRY`, `ID_KAMAR`, `ID_PELANGGAN`, `KODE_LAUNDRY`) VALUES
(2, 1, 1, 'LDR001'),
(10, 1, 74, 'LDR002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `NAMA_PELANGGAN` varchar(255) DEFAULT NULL,
  `JENIS_KELAMIN` varchar(255) DEFAULT NULL,
  `ALAMAT` varchar(255) DEFAULT NULL,
  `KOTA` varchar(255) DEFAULT NULL,
  `NO_TLP` varchar(255) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(125) NOT NULL,
  `STATUS_PELANGGAN` varchar(125) NOT NULL,
  `ROLE` varchar(125) NOT NULL,
  `verify_token` varchar(150) NOT NULL,
  `verify_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `JENIS_KELAMIN`, `ALAMAT`, `KOTA`, `NO_TLP`, `EMAIL`, `PASSWORD`, `STATUS_PELANGGAN`, `ROLE`, `verify_token`, `verify_status`) VALUES
(1, 'admin', 'L', 'jghkjhg', 'ee', 'eee', 'admin@gmail.com', 'admin', 'Tidak Aktif', 'admin', '', 0),
(37, 'swed', 'Perempuan', 'www222', 'wadungasih', '222', 'percobaan@gmail.com', '$2y$10$9/j8qlwKJHXIqfYA.4agy.w9BAcLmz0au1Zwmh9Pi/K0RXtQayygm', 'Aktif', 'Pelanggan', '626a9c10a09362fd0e93b7c7099e1023', 1),
(42, 'NYLA ANIDIA ASTRI', 'Perempuan', 'weee', 'sidoarjo', '085234804959', 'nylaastri12223@gmail.com', '$2y$10$wp/tAltwf6q7wxumvcRTjOmFGHLdF7qTaLbmFKq/g.Zs10qd4WGUa', 'Tidak Aktif', 'Pelanggan', '038acad3d1702d3c5a57d445a0248e01', 0),
(74, 'nyla', 'Laki-Laki', 'aa', 'aa', '082', 'percobaan@gmail.com', '$2y$10$sBCTPc3Nn0VKqM6lhHUVtOvtw8h/21Chy/ErEhLd552A/WvD88Z5S', 'Aktif', 'Pelanggan', 'eb0f6563aff529e9f5aab015583b673f', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `ID_PEMBAYARAN` int(11) NOT NULL,
  `ID_JENIS_KAMAR` int(11) DEFAULT NULL,
  `ID_FNB` int(11) DEFAULT NULL,
  `ID_LAUNDRY` int(11) DEFAULT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `TGL_CHECK_IN` varchar(125) NOT NULL,
  `ID_CHECKIN_OUT` varchar(125) NOT NULL,
  `LAMA_INAP` varchar(125) NOT NULL,
  `TOTAL` varchar(125) NOT NULL,
  `UANG_MUKA` varchar(125) NOT NULL,
  `SISA_PEMBAYARAN` varchar(125) NOT NULL,
  `BIAYA_LAUNDRY` varchar(125) NOT NULL,
  `BIAYA_FNB` varchar(125) NOT NULL,
  `TOTAL_BAYAR` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`ID_PEMBAYARAN`, `ID_JENIS_KAMAR`, `ID_FNB`, `ID_LAUNDRY`, `ID_PELANGGAN`, `TGL_CHECK_IN`, `ID_CHECKIN_OUT`, `LAMA_INAP`, `TOTAL`, `UANG_MUKA`, `SISA_PEMBAYARAN`, `BIAYA_LAUNDRY`, `BIAYA_FNB`, `TOTAL_BAYAR`) VALUES
(9, 2, NULL, NULL, 74, '2026-08-26', '21', '1', '500000', '250', '0', '0', '0', '499750'),
(10, 1, 16, 10, 74, '2026-08-15', '22', '1', '25000', '23000', '0', '8965', '90000', '100965');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `ID_PEMESANAN` int(11) NOT NULL,
  `ID_JENIS_KAMAR` int(11) DEFAULT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `TGL_PESAN` date DEFAULT NULL,
  `JAM_PESAN` time DEFAULT NULL,
  `TGL_CHECK_IN` varchar(125) NOT NULL,
  `UANG_MUKA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`ID_PEMESANAN`, `ID_JENIS_KAMAR`, `ID_PELANGGAN`, `TGL_PESAN`, `JAM_PESAN`, `TGL_CHECK_IN`, `UANG_MUKA`) VALUES
(33, 1, 37, '2025-12-26', '01:31:00', '2025-12-29', 22220),
(35, 2, 42, '2025-12-03', '23:28:00', '2025-12-03', 230000),
(36, 1, 74, '2026-08-30', '17:41:00', '2026-08-15', 23000),
(37, 2, 74, '2026-08-20', '20:40:00', '2026-08-26', 250);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(125) NOT NULL,
  `password` varchar(125) NOT NULL,
  `id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `id_level`) VALUES
(1, 'admin', 'admin', 0),
(5, 'nyla', 'nyla', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `checkin_checkout`
--
ALTER TABLE `checkin_checkout`
  ADD PRIMARY KEY (`ID_CHECKIN_OUT`),
  ADD KEY `RELATIONSHIP_6_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_10_FK` (`ID_JENIS_KAMAR`),
  ADD KEY `RELATIONSHIP_15_FK` (`ID_KAMAR`),
  ADD KEY `RELATIONSHIP_19_FK` (`ID_PEMESANAN`);

--
-- Indeks untuk tabel `detail_food_n_beverage`
--
ALTER TABLE `detail_food_n_beverage`
  ADD PRIMARY KEY (`ID_DETAIL_FNB`),
  ADD KEY `RELATIONSHIP_5_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_18_FK` (`ID_FNB`);

--
-- Indeks untuk tabel `detail_laundry`
--
ALTER TABLE `detail_laundry`
  ADD PRIMARY KEY (`ID_DETAIL_LAUNDRY`),
  ADD KEY `RELATIONSHIP_2_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_16_FK` (`ID_LAUNDRY`);

--
-- Indeks untuk tabel `feedback_pelanggan`
--
ALTER TABLE `feedback_pelanggan`
  ADD PRIMARY KEY (`ID_FEEDBACK`),
  ADD KEY `ID_PELANGGAN` (`ID_PELANGGAN`) USING BTREE,
  ADD KEY `ID_CHECKIN_OUT` (`ID_CHECKIN_OUT`) USING BTREE;

--
-- Indeks untuk tabel `food_n_beverage`
--
ALTER TABLE `food_n_beverage`
  ADD PRIMARY KEY (`ID_FNB`),
  ADD KEY `RELATIONSHIP_4_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_12_FK` (`ID_KAMAR`);

--
-- Indeks untuk tabel `jenis_kamar`
--
ALTER TABLE `jenis_kamar`
  ADD PRIMARY KEY (`ID_JENIS_KAMAR`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`ID_KAMAR`),
  ADD KEY `RELATIONSHIP_8_FK` (`ID_JENIS_KAMAR`);

--
-- Indeks untuk tabel `laundry`
--
ALTER TABLE `laundry`
  ADD PRIMARY KEY (`ID_LAUNDRY`),
  ADD KEY `RELATIONSHIP_3_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_13_FK` (`ID_KAMAR`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`ID_PEMBAYARAN`),
  ADD KEY `RELATIONSHIP_7_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_9_FK` (`ID_JENIS_KAMAR`),
  ADD KEY `RELATIONSHIP_14_FK` (`ID_LAUNDRY`),
  ADD KEY `RELATIONSHIP_17_FK` (`ID_FNB`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`ID_PEMESANAN`),
  ADD KEY `RELATIONSHIP_1_FK` (`ID_PELANGGAN`),
  ADD KEY `RELATIONSHIP_11_FK` (`ID_JENIS_KAMAR`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `checkin_checkout`
--
ALTER TABLE `checkin_checkout`
  MODIFY `ID_CHECKIN_OUT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `detail_food_n_beverage`
--
ALTER TABLE `detail_food_n_beverage`
  MODIFY `ID_DETAIL_FNB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `detail_laundry`
--
ALTER TABLE `detail_laundry`
  MODIFY `ID_DETAIL_LAUNDRY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `feedback_pelanggan`
--
ALTER TABLE `feedback_pelanggan`
  MODIFY `ID_FEEDBACK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `food_n_beverage`
--
ALTER TABLE `food_n_beverage`
  MODIFY `ID_FNB` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `jenis_kamar`
--
ALTER TABLE `jenis_kamar`
  MODIFY `ID_JENIS_KAMAR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `ID_KAMAR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `laundry`
--
ALTER TABLE `laundry`
  MODIFY `ID_LAUNDRY` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_PELANGGAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `ID_PEMBAYARAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `ID_PEMESANAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `checkin_checkout`
--
ALTER TABLE `checkin_checkout`
  ADD CONSTRAINT `FK_CHECKIN__RELATIONS_JENIS_KA` FOREIGN KEY (`ID_JENIS_KAMAR`) REFERENCES `jenis_kamar` (`ID_JENIS_KAMAR`),
  ADD CONSTRAINT `FK_CHECKIN__RELATIONS_KAMAR` FOREIGN KEY (`ID_KAMAR`) REFERENCES `kamar` (`ID_KAMAR`),
  ADD CONSTRAINT `FK_CHECKIN__RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`),
  ADD CONSTRAINT `FK_CHECKIN__RELATIONS_PEMESANA` FOREIGN KEY (`ID_PEMESANAN`) REFERENCES `pemesanan` (`ID_PEMESANAN`);

--
-- Ketidakleluasaan untuk tabel `detail_food_n_beverage`
--
ALTER TABLE `detail_food_n_beverage`
  ADD CONSTRAINT `FK_DETAIL_F_RELATIONS_FOOD_N_B` FOREIGN KEY (`ID_FNB`) REFERENCES `food_n_beverage` (`ID_FNB`),
  ADD CONSTRAINT `FK_DETAIL_F_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Ketidakleluasaan untuk tabel `detail_laundry`
--
ALTER TABLE `detail_laundry`
  ADD CONSTRAINT `FK_DETAIL_L_RELATIONS_LAUNDRY` FOREIGN KEY (`ID_LAUNDRY`) REFERENCES `laundry` (`ID_LAUNDRY`),
  ADD CONSTRAINT `FK_DETAIL_L_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Ketidakleluasaan untuk tabel `feedback_pelanggan`
--
ALTER TABLE `feedback_pelanggan`
  ADD CONSTRAINT `feedback_pelanggan_ibfk_1` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`),
  ADD CONSTRAINT `feedback_pelanggan_ibfk_2` FOREIGN KEY (`ID_CHECKIN_OUT`) REFERENCES `checkin_checkout` (`ID_CHECKIN_OUT`);

--
-- Ketidakleluasaan untuk tabel `food_n_beverage`
--
ALTER TABLE `food_n_beverage`
  ADD CONSTRAINT `FK_FOOD_N_B_RELATIONS_KAMAR` FOREIGN KEY (`ID_KAMAR`) REFERENCES `kamar` (`ID_KAMAR`),
  ADD CONSTRAINT `FK_FOOD_N_B_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Ketidakleluasaan untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `FK_KAMAR_RELATIONS_JENIS_KA` FOREIGN KEY (`ID_JENIS_KAMAR`) REFERENCES `jenis_kamar` (`ID_JENIS_KAMAR`);

--
-- Ketidakleluasaan untuk tabel `laundry`
--
ALTER TABLE `laundry`
  ADD CONSTRAINT `FK_LAUNDRY_RELATIONS_KAMAR` FOREIGN KEY (`ID_KAMAR`) REFERENCES `kamar` (`ID_KAMAR`),
  ADD CONSTRAINT `FK_LAUNDRY_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `FK_PEMBAYAR_RELATIONS_FOOD_N_B` FOREIGN KEY (`ID_FNB`) REFERENCES `food_n_beverage` (`ID_FNB`),
  ADD CONSTRAINT `FK_PEMBAYAR_RELATIONS_JENIS_KA` FOREIGN KEY (`ID_JENIS_KAMAR`) REFERENCES `jenis_kamar` (`ID_JENIS_KAMAR`),
  ADD CONSTRAINT `FK_PEMBAYAR_RELATIONS_LAUNDRY` FOREIGN KEY (`ID_LAUNDRY`) REFERENCES `laundry` (`ID_LAUNDRY`),
  ADD CONSTRAINT `FK_PEMBAYAR_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `FK_PEMESANA_RELATIONS_JENIS_KA` FOREIGN KEY (`ID_JENIS_KAMAR`) REFERENCES `jenis_kamar` (`ID_JENIS_KAMAR`),
  ADD CONSTRAINT `FK_PEMESANA_RELATIONS_PELANGGA` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
