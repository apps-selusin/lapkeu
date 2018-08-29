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
backup_tables($info["host"], $info["user"], $info["pass"], $info["db"]);

// kembali ke cf05_backup
//header("location: cf05_backup.php?ok=1");
header("location: .");

/* backup the db OR just a table */
function backup_tables_old($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

?>