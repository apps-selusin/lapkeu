-- ---------------------------------------------------------
--
-- SIMPLE SQL Dump
-- 
-- nawa (at) yahoo (dot) com
--
-- Host Connection Info: localhost via TCP/IP
-- Generation Time: August 29, 2018 at 23:28 PM ( Asia/Jakarta )
-- Server version: 5.6.14
-- PHP Version: 5.5.6
--
-- ---------------------------------------------------------



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- ---------------------------------------------------------
--
-- Table structure for table : `t01_supplier`
--
-- ---------------------------------------------------------

CREATE TABLE `t01_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `NoTelpHp` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t01_supplier`
--

INSERT INTO `t01_supplier` (`id`, `Nama`, `Alamat`, `NoTelpHp`) VALUES
(1, 'Abadi, Toko', '', ''),
(2, 'Outsourcing', '', '');



-- ---------------------------------------------------------
--
-- Table structure for table : `t02_satuan`
--
-- ---------------------------------------------------------

CREATE TABLE `t02_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t02_satuan`
--

INSERT INTO `t02_satuan` (`id`, `Nama`) VALUES
(1, 'Pcs'),
(2, 'ea');



-- ---------------------------------------------------------
--
-- Table structure for table : `t03_barang`
--
-- ---------------------------------------------------------

CREATE TABLE `t03_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(100) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t03_barang`
--

INSERT INTO `t03_barang` (`id`, `Nama`, `satuan_id`) VALUES
(1, 'Pulpen', 1),
(2, 'Transport KKG', 2);



-- ---------------------------------------------------------
--
-- Table structure for table : `t04_maingroup`
--
-- ---------------------------------------------------------

CREATE TABLE `t04_maingroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t04_maingroup`
--

INSERT INTO `t04_maingroup` (`id`, `Nama`) VALUES
(2, 'Kegiatan Awal Tahun (PPDB)'),
(3, 'Pelatihan Tenaga Pendidik dan Kependidikan');



-- ---------------------------------------------------------
--
-- Table structure for table : `t05_subgroup`
--
-- ---------------------------------------------------------

CREATE TABLE `t05_subgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maingroup_id` int(11) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t05_subgroup`
--

INSERT INTO `t05_subgroup` (`id`, `maingroup_id`, `Nama`) VALUES
(1, 2, 'Formulir Pendaftaran'),
(2, 2, 'Banner PPDB'),
(3, 3, 'Pelatihan dan pengarahan');



-- ---------------------------------------------------------
--
-- Table structure for table : `t06_pengeluaran`
--
-- ---------------------------------------------------------

CREATE TABLE `t06_pengeluaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `NoNota` varchar(25) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `Banyaknya` float(14,2) NOT NULL,
  `Harga` float(14,2) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  `maingroup_id` int(11) NOT NULL,
  `subgroup_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ---------------------------------------------------------
--
-- Table structure for table : `t07_sekolah`
--
-- ---------------------------------------------------------

CREATE TABLE `t07_sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) DEFAULT NULL,
  `NoTelpHp` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t07_sekolah`
--

INSERT INTO `t07_sekolah` (`id`, `Nama`, `Alamat`, `NoTelpHp`) VALUES
(1, 'MINU', '', '');



-- ---------------------------------------------------------
--
-- Table structure for table : `t08_penerimaan`
--
-- ---------------------------------------------------------

CREATE TABLE `t08_penerimaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` date NOT NULL,
  `NoKwitansi` varchar(25) NOT NULL,
  `Keterangan` varchar(100) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ---------------------------------------------------------
--
-- Table structure for table : `t09_periode`
--
-- ---------------------------------------------------------

CREATE TABLE `t09_periode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `TanggalAwal` date NOT NULL,
  `TanggalAkhir` date NOT NULL,
  `NamaBulan` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t09_periode`
--

INSERT INTO `t09_periode` (`id`, `Bulan`, `Tahun`, `TanggalAwal`, `TanggalAkhir`, `NamaBulan`) VALUES
(1, 8, 2018, '2018-08-01', '2018-08-31', 'Agustus');



-- ---------------------------------------------------------
--
-- Table structure for table : `t10_saldo`
--
-- ---------------------------------------------------------

CREATE TABLE `t10_saldo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t10_saldo`
--

INSERT INTO `t10_saldo` (`id`, `Bulan`, `Tahun`, `Jumlah`) VALUES
(1, 8, 2018, -110000.00);



-- ---------------------------------------------------------
--
-- Table structure for table : `t11_saldoold`
--
-- ---------------------------------------------------------

CREATE TABLE `t11_saldoold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t11_saldoold`
--

INSERT INTO `t11_saldoold` (`id`, `Bulan`, `Tahun`, `Jumlah`) VALUES
(1, 7, 2018, 0.00);



-- ---------------------------------------------------------
--
-- Table structure for table : `t12_penerimaanold`
--
-- ---------------------------------------------------------

CREATE TABLE `t12_penerimaanold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tanggal` date NOT NULL,
  `NoKwitansi` varchar(25) NOT NULL,
  `Keterangan` varchar(100) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t12_penerimaanold`
--

INSERT INTO `t12_penerimaanold` (`id`, `Tanggal`, `NoKwitansi`, `Keterangan`, `Jumlah`) VALUES
(1, '2018-07-02', '-', 'Dari Yayasan', 0.00);



-- ---------------------------------------------------------
--
-- Table structure for table : `t13_pengeluaranold`
--
-- ---------------------------------------------------------

CREATE TABLE `t13_pengeluaranold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `NoNota` varchar(25) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `Banyaknya` float(14,2) NOT NULL,
  `Harga` float(14,2) NOT NULL,
  `Jumlah` float(14,2) NOT NULL,
  `maingroup_id` int(11) NOT NULL,
  `subgroup_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t13_pengeluaranold`
--

INSERT INTO `t13_pengeluaranold` (`id`, `supplier_id`, `Tanggal`, `NoNota`, `barang_id`, `Banyaknya`, `Harga`, `Jumlah`, `maingroup_id`, `subgroup_id`) VALUES
(1, 2, '2018-07-09', '-', 2, 1.00, 100000.00, 100000.00, 3, 3);



-- ---------------------------------------------------------
--
-- Table structure for table : `t14_periodeold`
--
-- ---------------------------------------------------------

CREATE TABLE `t14_periodeold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `TanggalAwal` date NOT NULL,
  `TanggalAkhir` date NOT NULL,
  `NamaBulan` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t14_periodeold`
--

INSERT INTO `t14_periodeold` (`id`, `Bulan`, `Tahun`, `TanggalAwal`, `TanggalAkhir`, `NamaBulan`) VALUES
(1, 7, 2018, '2018-07-01', '2018-07-31', 'Juli');



-- ---------------------------------------------------------
--
-- Table structure for table : `t96_employees`
--
-- ---------------------------------------------------------

CREATE TABLE `t96_employees` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
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
  `Profile` longtext,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t96_employees`
--

INSERT INTO `t96_employees` (`EmployeeID`, `LastName`, `FirstName`, `Title`, `TitleOfCourtesy`, `BirthDate`, `HireDate`, `Address`, `City`, `Region`, `PostalCode`, `Country`, `HomePhone`, `Extension`, `Email`, `Photo`, `Notes`, `ReportsTo`, `Password`, `UserLevel`, `Username`, `Activated`, `Profile`) VALUES
(1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', -1, 'admin', 'N', '');



-- ---------------------------------------------------------
--
-- Table structure for table : `t97_userlevels`
--
-- ---------------------------------------------------------

CREATE TABLE `t97_userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL,
  PRIMARY KEY (`userlevelid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t97_userlevels`
--

INSERT INTO `t97_userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');



-- ---------------------------------------------------------
--
-- Table structure for table : `t98_userlevelpermissions`
--
-- ---------------------------------------------------------

CREATE TABLE `t98_userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY (`userlevelid`,`tablename`)
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



-- ---------------------------------------------------------
--
-- Table structure for table : `t99_audittrail`
--
-- ---------------------------------------------------------

CREATE TABLE `t99_audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t99_audittrail`
--

INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2018-08-29 13:48:58', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '2018-08-29 13:58:09', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(3, '2018-08-29 13:58:20', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(4, '2018-08-29 14:33:33', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(5, '2018-08-29 14:41:16', '/lapkeu/t10_saldolist.php', 1, 'U', 't10_saldo', 'Jumlah', 1, 10000000.00, 5000000),
(6, '2018-08-29 14:41:52', '/lapkeu/t10_saldolist.php', 1, 'U', 't10_saldo', 'Jumlah', 1, 5000000.00, 4000000),
(7, '2018-08-29 14:42:13', '/lapkeu/t10_saldolist.php', 1, 'U', 't10_saldo', 'Jumlah', 1, 4000000.00, 6500000),
(8, '2018-08-29 14:46:13', '/lapkeu/t08_penerimaanadd.php', 1, 'A', 't08_penerimaan', 'Tanggal', 1, '', '2018-07-02'),
(9, '2018-08-29 14:46:13', '/lapkeu/t08_penerimaanadd.php', 1, 'A', 't08_penerimaan', 'NoKwitansi', 1, '', '-'),
(10, '2018-08-29 14:46:13', '/lapkeu/t08_penerimaanadd.php', 1, 'A', 't08_penerimaan', 'Keterangan', 1, '', 'Dari Yayasan'),
(11, '2018-08-29 14:46:13', '/lapkeu/t08_penerimaanadd.php', 1, 'A', 't08_penerimaan', 'Jumlah', 1, '', 25000000),
(12, '2018-08-29 14:46:13', '/lapkeu/t08_penerimaanadd.php', 1, 'A', 't08_penerimaan', 'id', 1, '', 1),
(13, '2018-08-29 14:46:47', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(14, '2018-08-29 14:47:16', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(15, '2018-08-29 14:49:50', '/lapkeu/t10_saldolist.php', 1, 'U', 't10_saldo', 'Jumlah', 1, 6500000.00, 0),
(16, '2018-08-29 14:50:09', '/lapkeu/t08_penerimaanedit.php', 1, 'U', 't08_penerimaan', 'Jumlah', 1, 25000000.00, 0),
(17, '2018-08-29 14:51:53', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'Nama', 1, '', 'Abadi, Toko'),
(18, '2018-08-29 14:51:53', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'Alamat', 1, '', ''),
(19, '2018-08-29 14:51:53', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'NoTelpHp', 1, '', ''),
(20, '2018-08-29 14:51:53', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'id', 1, '', 1),
(21, '2018-08-29 15:00:20', '/lapkeu/t02_satuanaddopt.php', 1, 'A', 't02_satuan', 'Nama', 1, '', 'Pcs'),
(22, '2018-08-29 15:00:20', '/lapkeu/t02_satuanaddopt.php', 1, 'A', 't02_satuan', 'id', 1, '', 1),
(23, '2018-08-29 15:00:23', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'Nama', 1, '', 'Pulpen'),
(24, '2018-08-29 15:00:23', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'satuan_id', 1, '', 1),
(25, '2018-08-29 15:00:23', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'id', 1, '', 1),
(26, '2018-08-29 15:02:12', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'Nama', 1, '', 'Kegiatan Awal Tahun (PPDB)'),
(27, '2018-08-29 15:02:12', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'id', 1, '', 1),
(28, '2018-08-29 15:03:21', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(29, '2018-08-29 15:03:52', '/lapkeu/t04_maingroupdelete.php', 1, '*** Batch delete begin ***', 't04_maingroup', '', '', '', ''),
(30, '2018-08-29 15:03:52', '/lapkeu/t04_maingroupdelete.php', 1, 'D', 't04_maingroup', 'id', 1, 1, ''),
(31, '2018-08-29 15:03:52', '/lapkeu/t04_maingroupdelete.php', 1, 'D', 't04_maingroup', 'Nama', 1, 'Kegiatan Awal Tahun (PPDB)', ''),
(32, '2018-08-29 15:03:52', '/lapkeu/t04_maingroupdelete.php', 1, '*** Batch delete successful ***', 't04_maingroup', '', '', '', ''),
(33, '2018-08-29 15:04:10', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'Nama', 2, '', 'Kegiatan Awal Tahun (PPDB)'),
(34, '2018-08-29 15:04:10', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'id', 2, '', 2),
(35, '2018-08-29 15:04:41', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'maingroup_id', 1, '', 2),
(36, '2018-08-29 15:04:41', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'Nama', 1, '', 'Formulir Pendaftaran'),
(37, '2018-08-29 15:04:41', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'id', 1, '', 1),
(38, '2018-08-29 15:05:37', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'maingroup_id', 2, '', 2),
(39, '2018-08-29 15:05:37', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'Nama', 2, '', 'Banner PPDB'),
(40, '2018-08-29 15:05:37', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'id', 2, '', 2),
(41, '2018-08-29 15:18:09', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'Nama', 2, '', 'Outsourcing'),
(42, '2018-08-29 15:18:09', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'Alamat', 2, '', ''),
(43, '2018-08-29 15:18:09', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'NoTelpHp', 2, '', ''),
(44, '2018-08-29 15:18:09', '/lapkeu/t01_supplieraddopt.php', 1, 'A', 't01_supplier', 'id', 2, '', 2),
(45, '2018-08-29 15:19:22', '/lapkeu/t02_satuanaddopt.php', 1, 'A', 't02_satuan', 'Nama', 2, '', 'ea'),
(46, '2018-08-29 15:19:22', '/lapkeu/t02_satuanaddopt.php', 1, 'A', 't02_satuan', 'id', 2, '', 2),
(47, '2018-08-29 15:19:26', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'Nama', 2, '', 'Transport KKG'),
(48, '2018-08-29 15:19:26', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'satuan_id', 2, '', 2),
(49, '2018-08-29 15:19:26', '/lapkeu/t03_barangadd.php', 1, 'A', 't03_barang', 'id', 2, '', 2),
(50, '2018-08-29 15:20:53', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'Nama', 3, '', 'Pelatihan Tenaga Pendidik dan Kependidikan'),
(51, '2018-08-29 15:20:53', '/lapkeu/t04_maingroupadd.php', 1, 'A', 't04_maingroup', 'id', 3, '', 3),
(52, '2018-08-29 15:21:23', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'maingroup_id', 3, '', 3),
(53, '2018-08-29 15:21:23', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'Nama', 3, '', 'Pelatihan dan pengarahan'),
(54, '2018-08-29 15:21:23', '/lapkeu/t05_subgroupadd.php', 1, 'A', 't05_subgroup', 'id', 3, '', 3),
(55, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'supplier_id', 1, '', 2),
(56, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'Tanggal', 1, '', '2018-07-09'),
(57, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'NoNota', 1, '', '-'),
(58, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'barang_id', 1, '', 2),
(59, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'Banyaknya', 1, '', 1),
(60, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'Harga', 1, '', 100000),
(61, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'Jumlah', 1, '', 100000),
(62, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'maingroup_id', 1, '', 3),
(63, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'subgroup_id', 1, '', 3),
(64, '2018-08-29 15:22:29', '/lapkeu/t06_pengeluaranadd.php', 1, 'A', 't06_pengeluaran', 'id', 1, '', 1),
(65, '2018-08-29 18:46:39', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(66, '2018-08-29 20:03:33', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(67, '2018-08-29 20:18:36', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(68, '2018-08-29 20:19:11', '/lapkeu/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(69, '2018-08-29 20:37:31', '/lapkeu/login.php', 'admin', 'login', '::1', '', '', '', ''),
(70, '2018-08-29 22:44:39', '/lapkeu/t10_saldolist.php', 1, 'U', 't10_saldo', 'Jumlah', 1, -100000.00, -110000.00);



-- ---------------------------------------------------------
--
-- Table structure for table : `v01_barang_satuan`
--
-- ---------------------------------------------------------

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v01_barang_satuan` AS select `t03_barang`.`id` AS `id`,`t03_barang`.`Nama` AS `Nama`,`t02_satuan`.`Nama` AS `Satuan` from (`t03_barang` join `t02_satuan` on((`t03_barang`.`satuan_id` = `t02_satuan`.`id`)));

--
-- Dumping data for table `v01_barang_satuan`
--

INSERT INTO `v01_barang_satuan` (`id`, `Nama`, `Satuan`) VALUES
(1, 'Pulpen', 'Pcs'),
(2, 'Transport KKG', 'ea');



-- ---------------------------------------------------------
--
-- Table structure for table : `v02_terima_keluar`
--
-- ---------------------------------------------------------

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v02_terima_keluar` AS select `t08_penerimaan`.`Tanggal` AS `tanggal`,concat('1.',`t08_penerimaan`.`id`,' - ',`t08_penerimaan`.`Keterangan`) AS `ket1`,'' AS `ket2`,'' AS `ket3`,`t08_penerimaan`.`NoKwitansi` AS `ket4`,'' AS `ket5`,0 AS `nilai1`,'' AS `ket6`,0 AS `nilai2`,`t08_penerimaan`.`Jumlah` AS `terima_jumlah`,0 AS `keluar_jumlah`,`t08_penerimaan`.`Jumlah` AS `saldo` from `t08_penerimaan` union select `a`.`Tanggal` AS `tanggal`,concat('2.',`a`.`maingroup_id`,' - ',`b`.`Nama`) AS `CONCAT(``a``.``id``, ' - ', ``b``.``Nama``)`,concat('3.',`a`.`subgroup_id`,' - ',`c`.`Nama`) AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,0 AS `terima_jumlah`,`a`.`Jumlah` AS `keluar_jumlah`,`a`.`Jumlah` AS `Jumlah` from ((((`t06_pengeluaran` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`)));



-- ---------------------------------------------------------
--
-- Table structure for table : `v03_pengeluaran`
--
-- ---------------------------------------------------------

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v03_pengeluaran` AS select `a`.`Tanggal` AS `tanggal`,`b`.`Nama` AS `maingroup_nama`,`c`.`Nama` AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,`a`.`Jumlah` AS `Jumlah` from ((((`t06_pengeluaran` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`)));



-- ---------------------------------------------------------
--
-- Table structure for table : `v04_pengeluaranold`
--
-- ---------------------------------------------------------

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v04_pengeluaranold` AS select `a`.`Tanggal` AS `tanggal`,`b`.`Nama` AS `maingroup_nama`,`c`.`Nama` AS `subgroup_nama`,`d`.`Nama` AS `supplier_nama`,`a`.`NoNota` AS `nonota`,`e`.`Nama` AS `barang_nama`,`a`.`Banyaknya` AS `banyaknya`,`e`.`Satuan` AS `barang_satuan`,`a`.`Harga` AS `harga`,`a`.`Jumlah` AS `Jumlah` from ((((`t13_pengeluaranold` `a` left join `t04_maingroup` `b` on((`a`.`maingroup_id` = `b`.`id`))) left join `t05_subgroup` `c` on((`a`.`subgroup_id` = `c`.`id`))) left join `t01_supplier` `d` on((`a`.`supplier_id` = `d`.`id`))) left join `v01_barang_satuan` `e` on((`a`.`barang_id` = `e`.`id`)));

--
-- Dumping data for table `v04_pengeluaranold`
--

INSERT INTO `v04_pengeluaranold` (`tanggal`, `maingroup_nama`, `subgroup_nama`, `supplier_nama`, `nonota`, `barang_nama`, `banyaknya`, `barang_satuan`, `harga`, `Jumlah`) VALUES
('2018-07-09', 'Pelatihan Tenaga Pendidik dan Kependidikan', 'Pelatihan dan pengarahan', 'Outsourcing', '-', 'Transport KKG', 1.00, 'ea', 100000.00, 100000.00);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;