-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2018 at 10:18 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lapkeu`
--

-- --------------------------------------------------------

--
-- Table structure for table `t01_supplier`
--

CREATE TABLE `t01_supplier` (
  `id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `NoTelpHp` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t01_supplier`
--

INSERT INTO `t01_supplier` (`id`, `Nama`, `Alamat`, `NoTelpHp`) VALUES
(1, 'Grafis Media', NULL, NULL),
(2, 'Jaya Abadi Sejahtera, PT', NULL, NULL),
(3, 'Annida, Toko', NULL, NULL),
(4, 'Budi Jaya, UD', NULL, NULL),
(5, 'Doctor Computer', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t02_satuan`
--

CREATE TABLE `t02_satuan` (
  `id` int(11) NOT NULL,
  `Nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t02_satuan`
--

INSERT INTO `t02_satuan` (`id`, `Nama`) VALUES
(1, 'Pcs'),
(2, 'Unit'),
(3, 'Set'),
(4, 'Pack'),
(5, 'Rim');

-- --------------------------------------------------------

--
-- Table structure for table `t03_barang`
--

CREATE TABLE `t03_barang` (
  `id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `satuan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t03_barang`
--

INSERT INTO `t03_barang` (`id`, `Nama`, `satuan_id`) VALUES
(1, 'Buku Tulis', 1),
(2, 'Kertas A4', 5),
(3, 'Spidol', 1),
(4, 'Ballpoint', 1),
(5, 'Penghapus', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t04_maingroup`
--

CREATE TABLE `t04_maingroup` (
  `id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t04_maingroup`
--

INSERT INTO `t04_maingroup` (`id`, `Nama`) VALUES
(1, 'Kegiatan Awal Tahun (PPDB)'),
(2, 'Kegiatan Proses Belajar Mengajar');

-- --------------------------------------------------------

--
-- Table structure for table `t05_subgroup`
--

CREATE TABLE `t05_subgroup` (
  `id` int(11) NOT NULL,
  `maingroup_id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t05_subgroup`
--

INSERT INTO `t05_subgroup` (`id`, `maingroup_id`, `Nama`) VALUES
(1, 1, 'Formulir Pendaftaran'),
(2, 1, 'Banner PPDB'),
(3, 1, 'Brosur'),
(4, 1, 'Melekat (Mengenal Lebih Dekat)'),
(5, 2, 'ATK TU & Kantor'),
(6, 2, 'ATK KBM'),
(7, 2, 'Evaluasi Semester (2x)'),
(8, 2, 'Kebutuhan Akhir Kelas 6');

-- --------------------------------------------------------

--
-- Table structure for table `t06_pengeluaran`
--

CREATE TABLE `t06_pengeluaran` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `NoNota` varchar(25) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `Banyaknya` float(14,2) NOT NULL,
  `Harga` float(14,2) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  `maingroup_id` int(11) NOT NULL,
  `subgroup_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t06_pengeluaran`
--

INSERT INTO `t06_pengeluaran` (`id`, `supplier_id`, `Tanggal`, `NoNota`, `barang_id`, `Banyaknya`, `Harga`, `Jumlah`, `maingroup_id`, `subgroup_id`) VALUES
(1, 3, '2018-08-03', '11', 4, 222.00, 10000.00, 2220000.00, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t07_sekolah`
--

CREATE TABLE `t07_sekolah` (
  `id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `NoTelpHp` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t07_sekolah`
--

INSERT INTO `t07_sekolah` (`id`, `Nama`, `Alamat`, `NoTelpHp`) VALUES
(1, 'MINU', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t08_penerimaan`
--

CREATE TABLE `t08_penerimaan` (
  `id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `NoKwitansi` varchar(25) NOT NULL,
  `Keterangan` varchar(100) NOT NULL,
  `Jumlah` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t08_penerimaan`
--

INSERT INTO `t08_penerimaan` (`id`, `Tanggal`, `NoKwitansi`, `Keterangan`, `Jumlah`) VALUES
(1, '2018-08-09', '12', 'Dari Yayasan', 50000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t96_employees`
--

CREATE TABLE `t96_employees` (
  `EmployeeID` int(11) NOT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `Title` varchar(30) DEFAULT NULL,
  `TitleOfCourtesy` varchar(25) DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  `HireDate` datetime DEFAULT NULL,
  `Address` varchar(60) DEFAULT NULL,
  `City` varchar(15) DEFAULT NULL,
  `Region` varchar(15) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL,
  `Country` varchar(15) DEFAULT NULL,
  `HomePhone` varchar(24) DEFAULT NULL,
  `Extension` varchar(4) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Notes` longtext,
  `ReportsTo` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL DEFAULT '',
  `UserLevel` int(11) DEFAULT NULL,
  `Username` varchar(20) NOT NULL DEFAULT '',
  `Activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `Profile` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t96_employees`
--

INSERT INTO `t96_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'N', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t97_userlevels`
--

CREATE TABLE `t97_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t97_userlevels`
--

INSERT INTO `t97_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `t98_userlevelpermissions`
--

CREATE TABLE `t98_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t98_userlevelpermissions`
--

INSERT INTO `t98_userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t05_subgroup', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t97_userlevels', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t98_userlevelpermissions', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t05_subgroup', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t97_userlevels', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t98_userlevelpermissions', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t99_audittrail`
--

CREATE TABLE `t99_audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t99_audittrail`
--

INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2018-07-26 22:59:47', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '2018-07-27 17:34:55', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(3, '2018-07-27 20:18:26', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(4, '2018-07-27 20:18:30', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(5, '2018-07-30 20:12:47', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(6, '2018-07-31 07:40:39', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(7, '2018-08-03 14:10:12', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(8, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'supplier_id', '1', '', '3'),
(9, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Tanggal', '1', '', '2018-08-03'),
(10, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'NoNota', '1', '', '11'),
(11, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'barang_id', '1', '', '4'),
(12, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Banyaknya', '1', '', '222'),
(13, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Harga', '1', '', '10000'),
(14, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Jumlah', '1', '', '2220000'),
(15, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'maingroup_id', '1', '', '1'),
(16, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'subgroup_id', '1', '', '1'),
(17, '2018-08-03 16:12:52', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'id', '1', '', '1'),
(18, '2018-08-03 23:58:38', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(19, '2018-08-08 08:19:10', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(20, '2018-08-08 18:35:12', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(21, '2018-08-08 16:57:06', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(22, '2018-08-08 17:06:55', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(23, '2018-08-09 00:52:23', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(24, '2018-08-09 12:14:59', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(25, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Tanggal', '1', '', '2018-08-09'),
(26, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'NoKwitansi', '1', '', '12'),
(27, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Keterangan', '1', '', 'Dari Yayasan'),
(28, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Jumlah', '1', '', '50000000'),
(29, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'id', '1', '', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t01_supplier`
--
ALTER TABLE `t01_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t02_satuan`
--
ALTER TABLE `t02_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t03_barang`
--
ALTER TABLE `t03_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t04_maingroup`
--
ALTER TABLE `t04_maingroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t05_subgroup`
--
ALTER TABLE `t05_subgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t06_pengeluaran`
--
ALTER TABLE `t06_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t07_sekolah`
--
ALTER TABLE `t07_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t08_penerimaan`
--
ALTER TABLE `t08_penerimaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t96_employees`
--
ALTER TABLE `t96_employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `t97_userlevels`
--
ALTER TABLE `t97_userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `t98_userlevelpermissions`
--
ALTER TABLE `t98_userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t01_supplier`
--
ALTER TABLE `t01_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t02_satuan`
--
ALTER TABLE `t02_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t03_barang`
--
ALTER TABLE `t03_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t04_maingroup`
--
ALTER TABLE `t04_maingroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t05_subgroup`
--
ALTER TABLE `t05_subgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t06_pengeluaran`
--
ALTER TABLE `t06_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t07_sekolah`
--
ALTER TABLE `t07_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t08_penerimaan`
--
ALTER TABLE `t08_penerimaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
