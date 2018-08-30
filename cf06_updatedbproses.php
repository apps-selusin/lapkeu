<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>

<?php
// 201808311708
// update field db
// untuk penambahan tanda tangan laporan
$q = "
    ALTER TABLE `t07_sekolah` 
    ADD `TTD1Nama` VARCHAR(50) NULL,
    ADD `TTD1Jabatan` VARCHAR(50) NULL,
    ADD `TTD2Nama` VARCHAR(50) NULL,
    ADD `TTD2Jabatan` VARCHAR(50) NULL;
";
Conn()->Execute($q);

// kembali ke cf06_updatedb
header("location: cf06_updatedb.php?ok=1");
?>