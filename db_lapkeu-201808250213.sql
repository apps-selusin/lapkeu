-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 24, 2018 at 09:13 PM
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
(1, 3, '2018-08-03', '11', 4, 222.00, 10000.00, 2220000.00, 1, 1),
(2, 4, '2018-08-10', '22', 2, 3.00, 30000.00, 90000.00, 2, 5);

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
-- Table structure for table `t09_periode`
--

CREATE TABLE `t09_periode` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `TanggalAwal` date NOT NULL,
  `TanggalAkhir` date NOT NULL,
  `NamaBulan` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t09_periode`
--

INSERT INTO `t09_periode` (`id`, `Bulan`, `Tahun`, `TanggalAwal`, `TanggalAkhir`, `NamaBulan`) VALUES
(1, 8, 2018, '2018-08-01', '2018-08-31', 'Agustus');

-- --------------------------------------------------------

--
-- Table structure for table `t10_saldo`
--

CREATE TABLE `t10_saldo` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Jumlah` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t10_saldo`
--

INSERT INTO `t10_saldo` (`id`, `Bulan`, `Tahun`, `Jumlah`) VALUES
(1, 8, 2018, 10000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t11_saldoold`
--

CREATE TABLE `t11_saldoold` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Jumlah` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t12_penerimaanold`
--

CREATE TABLE `t12_penerimaanold` (
  `id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `NoKwitansi` varchar(25) NOT NULL,
  `Keterangan` varchar(100) NOT NULL,
  `Jumlah` float(14,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t13_pengeluaranold`
--

CREATE TABLE `t13_pengeluaranold` (
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

-- --------------------------------------------------------

--
-- Table structure for table `t14_periodeold`
--

CREATE TABLE `t14_periodeold` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `TanggalAwal` date NOT NULL,
  `TanggalAkhir` date NOT NULL,
  `NamaBulan` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php', 111),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf02_tutupbuku.php', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}r02_keuangan.php', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t05_subgroup', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t07_sekolah', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t08_penerimaan', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t09_periode', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t10_saldo', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t11_saldoold', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t12_penerimaanold', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t13_pengeluaranold', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t14_periodeold', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t97_userlevels', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t98_userlevelpermissions', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v01_barang_satuan', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v02_terima_keluar', 0),
(-2, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v03_pengeluaran', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}r01_jenis_pengeluaran', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}r03_pengeluaran', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t01_supplier', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t02_satuan', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t03_barang', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t04_maingroup', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t05_subgroup', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t06_pengeluaran', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t07_sekolah', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t08_penerimaan', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t09_periode', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t10_saldo', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t11_saldoold', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t12_penerimaanold', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t13_pengeluaranold', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t14_periodeold', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t96_employees', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t97_userlevels', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t98_userlevelpermissions', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t99_audittrail', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v01_barang_satuan', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v02_terima_keluar', 0),
(-2, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v03_pengeluaran', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php', 111),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}cf02_tutupbuku.php', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}r02_keuangan.php', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t05_subgroup', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t07_sekolah', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t08_penerimaan', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t09_periode', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t10_saldo', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t11_saldoold', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t12_penerimaanold', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t13_pengeluaranold', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t14_periodeold', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t97_userlevels', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t98_userlevelpermissions', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v01_barang_satuan', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v02_terima_keluar', 0),
(0, '{239A2A32-109A-412F-A3CB-FF6290C167FC}v03_pengeluaran', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}r01_jenis_pengeluaran', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}r03_pengeluaran', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t01_supplier', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t02_satuan', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t03_barang', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t04_maingroup', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t05_subgroup', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t06_pengeluaran', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t07_sekolah', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t08_penerimaan', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t09_periode', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t10_saldo', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t11_saldoold', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t12_penerimaanold', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t13_pengeluaranold', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t14_periodeold', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t96_employees', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t97_userlevels', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t98_userlevelpermissions', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}t99_audittrail', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v01_barang_satuan', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v02_terima_keluar', 0),
(0, '{3CDC6268-D928-4495-B72A-CA5D35EAE344}v03_pengeluaran', 0);

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
(29, '2018-08-09 13:19:03', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'id', '1', '', '1'),
(30, '2018-08-09 18:39:48', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(31, '2018-08-09 18:46:49', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(32, '2018-08-09 18:47:25', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(33, '2018-08-09 18:48:28', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(34, '2018-08-09 20:39:40', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(35, '2018-08-10 08:54:45', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(36, '2018-08-10 08:54:50', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(37, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'supplier_id', '2', '', '4'),
(38, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Tanggal', '2', '', '2018-08-10'),
(39, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'NoNota', '2', '', '22'),
(40, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'barang_id', '2', '', '2'),
(41, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Banyaknya', '2', '', '2'),
(42, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Harga', '2', '', '30000'),
(43, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'Jumlah', '2', '', '60000'),
(44, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'maingroup_id', '2', '', '1'),
(45, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'subgroup_id', '2', '', '1'),
(46, '2018-08-10 14:07:08', '/lapkeu/t06_pengeluaranadd.php', '1', 'A', 't06_pengeluaran', 'id', '2', '', '2'),
(47, '2018-08-10 14:26:20', '/lapkeu/t06_pengeluaranedit.php', '1', 'U', 't06_pengeluaran', 'Banyaknya', '2', '2.00', '3'),
(48, '2018-08-10 14:26:20', '/lapkeu/t06_pengeluaranedit.php', '1', 'U', 't06_pengeluaran', 'Jumlah', '2', '60000.00', '90000'),
(49, '2018-08-10 14:26:53', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(50, '2018-08-10 14:32:17', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(51, '2018-08-10 17:48:24', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(52, '2018-08-10 17:48:27', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(53, '2018-08-10 17:48:38', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(54, '2018-08-10 17:48:52', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(55, '2018-08-10 17:52:25', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(56, '2018-08-10 20:32:21', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(57, '2018-08-10 21:56:01', '/lapkeu/t06_pengeluaranedit.php', '1', 'U', 't06_pengeluaran', 'maingroup_id', '2', '1', '2'),
(58, '2018-08-10 21:56:01', '/lapkeu/t06_pengeluaranedit.php', '1', 'U', 't06_pengeluaran', 'subgroup_id', '2', '1', '5'),
(59, '2018-08-11 09:39:25', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(60, '2018-08-11 21:03:27', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(61, '2018-08-16 01:16:01', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(62, '2018-08-19 08:44:56', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(63, '2018-08-19 08:45:30', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(64, '2018-08-19 08:45:33', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(65, '2018-08-19 08:54:15', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(66, '2018-08-19 18:56:06', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(67, '2018-08-19 21:31:26', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '8', '9'),
(68, '2018-08-19 21:31:46', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '9', '2'),
(69, '2018-08-19 21:31:59', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Tahun', '1', '2018', '2020'),
(70, '2018-08-19 21:33:31', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '2', '8'),
(71, '2018-08-19 21:33:31', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Tahun', '1', '2020', '2018'),
(72, '2018-08-19 21:35:12', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '8', '9'),
(73, '2018-08-19 21:58:00', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '9', '8'),
(74, '2018-08-19 21:58:32', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Tanggal', '2', '', '2018-08-19'),
(75, '2018-08-19 21:58:32', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'NoKwitansi', '2', '', 'xx'),
(76, '2018-08-19 21:58:32', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Keterangan', '2', '', 'xx'),
(77, '2018-08-19 21:58:32', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'Jumlah', '2', '', '1'),
(78, '2018-08-19 21:58:32', '/lapkeu/t08_penerimaanadd.php', '1', 'A', 't08_penerimaan', 'id', '2', '', '2'),
(79, '2018-08-19 21:58:51', '/lapkeu/t08_penerimaanedit.php', '1', 'U', 't08_penerimaan', 'Tanggal', '2', '2018-08-19', '2018-10-01'),
(80, '2018-08-19 22:02:17', '/lapkeu/t08_penerimaanedit.php', '1', 'U', 't08_penerimaan', 'Tanggal', '2', '2018-10-01', '2018-10-02'),
(81, '2018-08-19 22:03:08', '/lapkeu/t08_penerimaanedit.php', '1', 'U', 't08_penerimaan', 'Tanggal', '2', '2018-10-02', '2018-08-19'),
(82, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', '*** Batch delete begin ***', 't08_penerimaan', '', '', '', ''),
(83, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', 'D', 't08_penerimaan', 'id', '2', '2', ''),
(84, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', 'D', 't08_penerimaan', 'Tanggal', '2', '2018-08-19', ''),
(85, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', 'D', 't08_penerimaan', 'NoKwitansi', '2', 'xx', ''),
(86, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', 'D', 't08_penerimaan', 'Keterangan', '2', 'xx', ''),
(87, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', 'D', 't08_penerimaan', 'Jumlah', '2', '1.00', ''),
(88, '2018-08-19 22:03:46', '/lapkeu/t08_penerimaandelete.php', '1', '*** Batch delete successful ***', 't08_penerimaan', '', '', '', ''),
(89, '2018-08-20 15:31:44', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(90, '2018-08-20 15:31:50', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(91, '2018-08-21 12:39:06', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(92, '2018-08-23 08:28:11', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(93, '2018-08-23 15:03:39', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '8', '9'),
(94, '2018-08-23 16:04:03', '/lapkeu/t09_periodelist.php', '1', 'U', 't09_periode', 'Bulan', '1', '9', '8'),
(95, '2018-08-24 01:14:03', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(96, '2018-08-24 02:12:53', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(97, '2018-08-24 13:38:35', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(98, '2018-08-24 18:40:33', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(99, '2018-08-24 21:29:25', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(100, '2018-08-24 23:55:37', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(101, '2018-08-24 23:58:45', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(102, '2018-08-24 23:58:52', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(103, '2018-08-25 00:01:00', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(104, '2018-08-25 00:02:45', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(105, '2018-08-25 00:13:17', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(106, '2018-08-25 00:13:22', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(107, '2018-08-25 00:16:01', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(108, '2018-08-25 00:16:06', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(109, '2018-08-25 00:16:11', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(110, '2018-08-25 00:18:36', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(111, '2018-08-25 00:35:41', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v01_barang_satuan`
-- (See below for the actual view)
--
CREATE TABLE `v01_barang_satuan` (
`id` int(11)
,`Nama` varchar(100)
,`Satuan` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v02_terima_keluar`
-- (See below for the actual view)
--
CREATE TABLE `v02_terima_keluar` (
`tanggal` date
,`ket1` varchar(116)
,`ket2` varchar(116)
,`ket3` varchar(100)
,`ket4` varchar(25)
,`ket5` varchar(100)
,`nilai1` double(14,2)
,`ket6` varchar(25)
,`nilai2` double(14,2)
,`terima_jumlah` float
,`keluar_jumlah` double(14,2)
,`saldo` float(14,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v03_pengeluaran`
-- (See below for the actual view)
--
CREATE TABLE `v03_pengeluaran` (
`tanggal` date
,`maingroup_nama` varchar(100)
,`subgroup_nama` varchar(100)
,`supplier_nama` varchar(100)
,`nonota` varchar(25)
,`barang_nama` varchar(100)
,`banyaknya` float(14,2)
,`barang_satuan` varchar(25)
,`harga` float(14,2)
,`Jumlah` float(14,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v04_pengeluaranold`
-- (See below for the actual view)
--
CREATE TABLE `v04_pengeluaranold` (
`tanggal` date
,`maingroup_nama` varchar(100)
,`subgroup_nama` varchar(100)
,`supplier_nama` varchar(100)
,`nonota` varchar(25)
,`barang_nama` varchar(100)
,`banyaknya` float(14,2)
,`barang_satuan` varchar(25)
,`harga` float(14,2)
,`Jumlah` float(14,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v01_barang_satuan`
--
DROP TABLE IF EXISTS `v01_barang_satuan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v01_barang_satuan`  AS  select `t03_barang`.`id` AS `id`,`t03_barang`.`Nama` AS `Nama`,`t02_satuan`.`Nama` AS `Satuan` from (`t03_barang` join `t02_satuan` on((`t03_barang`.`satuan_id` = `t02_satuan`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v02_terima_keluar`
--
DROP TABLE IF EXISTS `v02_terima_keluar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v02_terima_keluar`  AS  select `t08_penerimaan`.`Tanggal` AS `tanggal`,concat('1.',`t08_penerimaan`.`id`,' - ',`t08_penerimaan`.`Keterangan`) AS `ket1`,'' AS `ket2`,'' AS `ket3`,`t08_penerimaan`.`NoKwitansi` AS `ket4`,'' AS `ket5`,0 AS `nilai1`,'' AS `ket6`,0 AS `nilai2`,`t08_penerimaan`.`Jumlah` AS `terima_jumlah`,0 AS `keluar_jumlah`,`t08_penerimaan`.`Jumlah` AS `saldo` from `t08_penerimaan` union select `a`.`Tanggal` AS `tanggal`,concat('2.',`a`.`maingroup_id`,' - ',`b`.`Nama`) AS `CONCAT(``a``.``id``, ' - ', ``b``.``Nama``)`,concat('3.',`a`.`subgroup_id`,' - ',`c`.`Nama`) AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,0 AS `terima_jumlah`,`a`.`Jumlah` AS `keluar_jumlah`,`a`.`Jumlah` AS `Jumlah` from ((((`t06_pengeluaran` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v03_pengeluaran`
--
DROP TABLE IF EXISTS `v03_pengeluaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v03_pengeluaran`  AS  select `a`.`Tanggal` AS `tanggal`,`b`.`Nama` AS `maingroup_nama`,`c`.`Nama` AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,`a`.`Jumlah` AS `Jumlah` from ((((`t06_pengeluaran` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v04_pengeluaranold`
--
DROP TABLE IF EXISTS `v04_pengeluaranold`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v04_pengeluaranold`  AS  select `a`.`Tanggal` AS `tanggal`,`b`.`Nama` AS `maingroup_nama`,`c`.`Nama` AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,`a`.`Jumlah` AS `Jumlah` from ((((`t13_pengeluaranold` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`))) ;

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
-- Indexes for table `t09_periode`
--
ALTER TABLE `t09_periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t10_saldo`
--
ALTER TABLE `t10_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t11_saldoold`
--
ALTER TABLE `t11_saldoold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t12_penerimaanold`
--
ALTER TABLE `t12_penerimaanold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t13_pengeluaranold`
--
ALTER TABLE `t13_pengeluaranold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t14_periodeold`
--
ALTER TABLE `t14_periodeold`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `t09_periode`
--
ALTER TABLE `t09_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t10_saldo`
--
ALTER TABLE `t10_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t11_saldoold`
--
ALTER TABLE `t11_saldoold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t12_penerimaanold`
--
ALTER TABLE `t12_penerimaanold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t13_pengeluaranold`
--
ALTER TABLE `t13_pengeluaranold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t14_periodeold`
--
ALTER TABLE `t14_periodeold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t96_employees`
--
ALTER TABLE `t96_employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
