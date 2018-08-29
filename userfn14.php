<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

function CheckDateBetween($sDateInput) {

	//$dDateInput = strtotime($sDateInput);
	$q = "select TanggalAwal, TanggalAkhir from t09_periode";
	$r = Conn()->Execute($q);
	if (
		(strtotime($sDateInput) >= strtotime($r->fields["TanggalAwal"]))
		and
		(strtotime($sDateInput) <= strtotime($r->fields["TanggalAkhir"]))
		) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function CheckPeriode($sPeriodeInput) {
	$q = "select Bulan, Tahun from t09_periode";
	$r = Conn()->Execute($q); //echo $sPeriodeInput."-".($r->fields["Tahun"].substr("00".$r->fields["Bulan"], -2)."01"); exit();
	if ($sPeriodeInput < ($r->fields["Tahun"].substr("00".$r->fields["Bulan"], -2)."01")) {
		return FALSE;
	}
	else {
		return TRUE;
	}
}

/* backup the db OR just a table */

function backup_tables($host,$user,$pass,$name,$tables = '*')
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
	$handle = fopen('backup/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}
?>
