-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 13, 2023 at 03:01 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_gudang_stok`
--

CREATE TABLE `log_gudang_stok` (
  `log_gudang_id` int(20) NOT NULL,
  `user` int(10) NOT NULL,
  `barang` int(20) NOT NULL,
  `stok_awal` int(10) NOT NULL,
  `stok_jumlah` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `alasan` text NOT NULL,
  `keterangan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barangmasuk`
--

CREATE TABLE `transaksi_barangmasuk` (
  `transaksi_barangmasuk_id` int(10) NOT NULL,
  `transaksi_barangmasuk_nota_print` int(10) NOT NULL,
  `transaksi_barangmasuk_nofaktur` varchar(30) NOT NULL,
  `transaksi_barangmasuk_tanggal` date NOT NULL,
  `transaksi_barangmasuk_waktu` time NOT NULL,
  `transaksi_barangmasuk_bulan` varchar(10) NOT NULL,
  `transaksi_barangmasuk_member` int(5) NOT NULL,
  `transaksi_barangmasuk_total` int(20) NOT NULL,
  `transaksi_barangmasuk_diskon` int(20) NOT NULL,
  `transaksi_barangmasuk_tax` int(11) NOT NULL,
  `transaksi_barangmasuk_tax_service` int(10) NOT NULL,
  `transaksi_barangmasuk_bayar` int(20) NOT NULL,
  `transaksi_barangmasuk_type_bayar` varchar(20) NOT NULL,
  `transaksi_barangmasuk_user` int(5) NOT NULL,
  `transaksi_barangmasuk_ket` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barangmasuk_detail`
--

CREATE TABLE `transaksi_barangmasuk_detail` (
  `transaksi_barangmasuk_detail_id` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_nota` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_barang_id` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_harga` int(20) NOT NULL,
  `transaksi_barangmasuk_detail_harga_beli` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_diskon` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_jumlah` int(5) NOT NULL,
  `transaksi_barangmasuk_detail_total` int(20) NOT NULL,
  `transaksi_barangmasuk_detail_keterangan` text NOT NULL,
  `transaksi_barangmasuk_detail_status` int(1) NOT NULL,
  `transaksi_barangmasuk_detail_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barangmasuk_detail_temp`
--

CREATE TABLE `transaksi_barangmasuk_detail_temp` (
  `transaksi_barangmasuk_detail_temp_id` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_temp_barang_id` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_temp_harga` int(20) NOT NULL,
  `transaksi_barangmasuk_detail_temp_harga_beli` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_temp_diskon` int(10) NOT NULL,
  `transaksi_barangmasuk_detail_temp_jumlah` int(5) NOT NULL,
  `transaksi_barangmasuk_detail_temp_total` int(20) NOT NULL,
  `transaksi_barangmasuk_detail_temp_keterangan` text NOT NULL,
  `transaksi_barangmasuk_detail_temp_status` varchar(10) NOT NULL,
  `transaksi_barangmasuk_detail_temp_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barangmasuk_temp`
--

CREATE TABLE `transaksi_barangmasuk_temp` (
  `transaksi_barangmasuk_temp_id` int(5) NOT NULL,
  `transaksi_barangmasuk_temp_nofaktur` varchar(30) NOT NULL,
  `transaksi_barangmasuk_temp_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_gudang`
--

CREATE TABLE `transaksi_gudang` (
  `transaksi_gudang_id` int(10) NOT NULL,
  `transaksi_gudang_nota_print` varchar(10) NOT NULL,
  `transaksi_gudang_tanggal` date NOT NULL,
  `transaksi_gudang_waktu` time NOT NULL,
  `transaksi_gudang_bulan` varchar(10) NOT NULL,
  `transaksi_gudang_member` int(5) NOT NULL,
  `transaksi_gudang_total` int(20) NOT NULL,
  `transaksi_gudang_diskon` int(20) NOT NULL,
  `transaksi_gudang_tax` int(11) NOT NULL,
  `transaksi_gudang_tax_service` int(10) NOT NULL,
  `transaksi_gudang_bayar` int(20) NOT NULL,
  `transaksi_gudang_type_bayar` varchar(20) NOT NULL,
  `transaksi_gudang_bayar_debet` int(10) NOT NULL,
  `transaksi_gudang_bayar_debet_ket` varchar(20) NOT NULL,
  `transaksi_gudang_user` int(5) NOT NULL,
  `transaksi_gudang_therapist` int(5) NOT NULL,
  `transaksi_gudang_nama` varchar(50) NOT NULL,
  `transaksi_gudang_cs` int(5) NOT NULL,
  `transaksi_gudang_kasir` int(5) NOT NULL,
  `transaksi_gudang_ket` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_gudang_detail`
--

CREATE TABLE `transaksi_gudang_detail` (
  `transaksi_gudang_detail_id` int(10) NOT NULL,
  `transaksi_gudang_detail_nota` int(10) NOT NULL,
  `transaksi_gudang_detail_barang_id` int(10) NOT NULL,
  `transaksi_gudang_detail_harga` int(20) NOT NULL,
  `transaksi_gudang_detail_harga_beli` int(10) NOT NULL,
  `transaksi_gudang_detail_diskon` int(10) NOT NULL,
  `transaksi_gudang_detail_jumlah` int(5) NOT NULL,
  `transaksi_gudang_detail_total` int(20) NOT NULL,
  `transaksi_gudang_detail_keterangan` text NOT NULL,
  `transaksi_gudang_detail_status` int(1) NOT NULL,
  `transaksi_gudang_detail_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_gudang_detail_temp`
--

CREATE TABLE `transaksi_gudang_detail_temp` (
  `transaksi_gudang_detail_temp_id` int(10) NOT NULL,
  `transaksi_gudang_detail_temp_barang_id` int(10) NOT NULL,
  `transaksi_gudang_detail_temp_harga` int(20) NOT NULL,
  `transaksi_gudang_detail_temp_harga_beli` int(10) NOT NULL,
  `transaksi_gudang_detail_temp_diskon` int(10) NOT NULL,
  `transaksi_gudang_detail_temp_jumlah` int(5) NOT NULL,
  `transaksi_gudang_detail_temp_total` int(20) NOT NULL,
  `transaksi_gudang_detail_temp_keterangan` text NOT NULL,
  `transaksi_gudang_detail_temp_status` varchar(10) NOT NULL,
  `transaksi_gudang_detail_temp_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_gudang_stok`
--
ALTER TABLE `log_gudang_stok`
  ADD PRIMARY KEY (`log_gudang_id`);

--
-- Indexes for table `transaksi_barangmasuk`
--
ALTER TABLE `transaksi_barangmasuk`
  ADD PRIMARY KEY (`transaksi_barangmasuk_id`);

--
-- Indexes for table `transaksi_barangmasuk_detail`
--
ALTER TABLE `transaksi_barangmasuk_detail`
  ADD PRIMARY KEY (`transaksi_barangmasuk_detail_id`);

--
-- Indexes for table `transaksi_barangmasuk_detail_temp`
--
ALTER TABLE `transaksi_barangmasuk_detail_temp`
  ADD PRIMARY KEY (`transaksi_barangmasuk_detail_temp_id`);

--
-- Indexes for table `transaksi_barangmasuk_temp`
--
ALTER TABLE `transaksi_barangmasuk_temp`
  ADD PRIMARY KEY (`transaksi_barangmasuk_temp_id`);

--
-- Indexes for table `transaksi_gudang`
--
ALTER TABLE `transaksi_gudang`
  ADD PRIMARY KEY (`transaksi_gudang_id`);

--
-- Indexes for table `transaksi_gudang_detail`
--
ALTER TABLE `transaksi_gudang_detail`
  ADD PRIMARY KEY (`transaksi_gudang_detail_id`);

--
-- Indexes for table `transaksi_gudang_detail_temp`
--
ALTER TABLE `transaksi_gudang_detail_temp`
  ADD PRIMARY KEY (`transaksi_gudang_detail_temp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_gudang_stok`
--
ALTER TABLE `log_gudang_stok`
  MODIFY `log_gudang_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_barangmasuk`
--
ALTER TABLE `transaksi_barangmasuk`
  MODIFY `transaksi_barangmasuk_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_barangmasuk_detail`
--
ALTER TABLE `transaksi_barangmasuk_detail`
  MODIFY `transaksi_barangmasuk_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_barangmasuk_detail_temp`
--
ALTER TABLE `transaksi_barangmasuk_detail_temp`
  MODIFY `transaksi_barangmasuk_detail_temp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_barangmasuk_temp`
--
ALTER TABLE `transaksi_barangmasuk_temp`
  MODIFY `transaksi_barangmasuk_temp_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_gudang`
--
ALTER TABLE `transaksi_gudang`
  MODIFY `transaksi_gudang_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_gudang_detail`
--
ALTER TABLE `transaksi_gudang_detail`
  MODIFY `transaksi_gudang_detail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_gudang_detail_temp`
--
ALTER TABLE `transaksi_gudang_detail_temp`
  MODIFY `transaksi_gudang_detail_temp_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
