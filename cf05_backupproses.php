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

//backup_tables('localhost','root','admin','db_lapkeu');

// backup database
$info = array();
if (ew_CurrentUserIP () == "127.0.0.1"  || ew_CurrentUserIP () == ":: 1"  || ew_CurrentHost () == "localhost" ) { // testing on local PC
	$info["host"] = "localhost";
	$info["user"] = "root"; // sesuaikan dengan username database di komputer localhost
	$info["pass"] = "admin"; // sesuaikan dengan password database di komputer localhost
	$info["db"] = "db_lapkeu"; // sesuaikan dengan nama database di komputer localhost
} elseif (ew_CurrentHost () == "lapkeu.selusin.net") { // setting koneksi database untuk komputer server
	$info["host"] = "mysql.hostinger.co.id";  // sesuaikan dengan ip address atau hostname komputer server
	$info["user"] = "u433254588_lapke"; // sesuaikan dengan username database di komputer server
	$info["pass"] = "M457r1P 81"; // sesuaikan deengan password database di komputer server
	$info["db"] = "u433254588_lapke"; // sesuaikan dengan nama database di komputer server
}
//backup_tables('localhost','root','admin','db_lapkeu');
//backup_tables($info["host"], $info["user"], $info["pass"], $info["db"]);

require('phpmybackup.php');
$db = new MYSQL_DUMP;
$db->dbhost = $info["host"]; //'server.com';
$db->dbuser = $info["user"]; //'backup-user';
$db->dbpwd = $info["pass"]; //'backup-password';
$db->backupsToKeep = 30;
$db->showDebug = false;
$db->backupDir = 'backup/';
$db->includeDatabases = [$info["db"]];
//$db->ignoreDatabases = ['test','unimportant_db'];
//$db->emptyTables = ['largedb.large_table1','largedb.cachetable'];
$db->dumpDatabases();

// kembali ke cf05_backup
//header("location: cf05_backup.php?ok=1");
//header("location: .");

?>