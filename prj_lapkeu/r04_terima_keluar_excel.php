<?php

if ($_SERVER["HTTP_HOST"] == "lapkeu.selusin.net") {
	//include "adodb5/adodb.inc.php";
	//$conn = ADONewConnection('mysql');
	//$conn->Connect('mysql.idhostinger.com','u945388674_ambi2','M457r1P 81','u945388674_ambi2');
	include "conn_adodb.php";
}
else {
	include_once "phpfn14.php";
	$conn =& DbHelper();
}

//$db =& DbHelper(); 

/*function show_table($r) {
	echo "<table class='table table-striped table-bordered table-hover table-condensed'>";
	echo "<tr><th>No.</th><th colspan='4'>Keterangan</th></tr>";
	while (!$r->EOF) {
		$no = $r->fields["No"];
		echo "<tr><td>".$no.".</td><td colspan='4'>".$r->fields["Keterangan"]."</td></tr>";
		while ($no == $r->fields["No"]) {
			echo "
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>".$r->fields["TanggalJam"]."</td>
				<td>".$r->fields["Status2"]."</td>
				<td>".$r->fields["Keterangan2"]."</td>
			</tr>";
			$r->MoveNext();
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
	}
	echo "</table>";
}*/
?>

<!-- <div class="panel panel-default">
	<div class="panel-heading">Latest News</div>
	<div class="panel-body">
		<p>Laporan Keuangan. @2018 Selaras Solusindo. All rights reserved.</p>
	</div>
</div> -->

<style>
.panel-heading a{
  display:block;
}

.panel-heading a.collapsed {
  background: url(http://upload.wikimedia.org/wikipedia/commons/3/36/Vector_skin_right_arrow.png) center right no-repeat;
}

.panel-heading a {
  background: url(http://www.useragentman.com/blog/wp-content/themes/useragentman/images/widgets/downArrow.png) center right no-repeat;
}
</style>

<!-- <div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"><strong><a class='collapsed' data-toggle="collapse" href="#log">Log</a></strong></div>
			<div id="log" class="panel-collapse collapse in">
			<div class="panel-body">
				<?php
				/*$q = "
					select distinct
						a.No,
						a.Keterangan,
						a.TanggalJam,
						b.Status as Status2,
						a.Keterangan2
					from
						t92_log a
						left join t91_log_status b on a.Status = b.id
					order by
						no desc,
						tanggaljam asc";
				$r = Conn()->Execute($q);
				show_table($r);*/
				?>
			</div>
			</div>
		</div>
	</div>

</div> -->

<!-- penerimaan -->
<?php
$col = 5;
?>

<table border="1">
	<tr>
		<td colspan="<?php echo $col;?>">Penerimaan</td>
	</tr>
	<tr>
		<td colspan="<?php echo $col;?>">&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>Keterangan</td>
		<td>No. Kwitansi</td>
		<td>Jumlah</td>
		<td>Total</td>
	</tr>
<?php

$total_terima = 0;

$q = "select * from t08_penerimaan order by tanggal";
$r = $conn->Execute($q); // $r = Conn()->Execute($q);

while (!$r->EOF) {
	echo "
	<tr>
		<td>".$r->fields["Tanggal"]."</td>
		<td>".$r->fields["Keterangan"]."</td>
		<td>".$r->fields["NoKwitansi"]."</td>
		<td align='right'>".number_format($r->fields["Jumlah"])."</td>
		<td>&nbsp;</td>
	</tr>";
	$total_terima += $r->fields["Jumlah"];
	$r->MoveNext();
}
echo "
	<tr>
		<td align='right' colspan='4'>Total Penerimaan</td>
		<td align='right'>".number_format($total_terima)."</td>
	</tr>
";
?>
</table>


<p>&nbsp;</p>


<!-- pengeluaran -->
<?php
$col = 11;
?>

<table border="1">
	<tr>
		<td colspan="<?php echo $col;?>">Pengeluaran</td>
	</tr>
	<tr>
		<td colspan="<?php echo $col;?>">&nbsp;</td>
	</tr>
	<tr>
		<td colspan='2'>Jenis Pengeluaran</td>
		<td>Tanggal</td>
		<td>Supplier</td>
		<td>No. Nota</td>
		<td>Barang</td>
		<td>Banyaknya</td>
		<td>Satuan</td>
		<td>Harga</td>
		<td>Jumlah</td>
		<td>Total</td>
	</tr>
<?php

$total_keluar = 0;

// $q = "select * from t08_penerimaan order by tanggal";
$q = "
	SELECT 
		`a`.`Tanggal` AS `tanggal`,
		`b`.`Nama` AS `maingroup_nama`,
		`c`.`Nama` AS `subgroup_nama`,
		`d`.`Nama` AS `supplier_nama`,
		`a`.`NoNota` AS `nonota`,
		`e`.`Nama` AS `barang_nama`,
		`a`.`Banyaknya` AS `banyaknya`,
		`e`.`Satuan` AS `barang_satuan`,
		`a`.`Harga` AS `harga`,
		`a`.`Jumlah` AS `jumlah`
	FROM
		((((`t06_pengeluaran` `a`
		LEFT JOIN `t04_maingroup` `b` ON ((`a`.`maingroup_id` = `b`.`id`)))
		LEFT JOIN `t05_subgroup` `c` ON ((`a`.`subgroup_id` = `c`.`id`)))
		LEFT JOIN `t01_supplier` `d` ON ((`a`.`supplier_id` = `d`.`id`)))
		LEFT JOIN `v01_barang_satuan` `e` ON ((`a`.`barang_id` = `e`.`id`)))
";
$r = $conn->Execute($q); // $r = Conn()->Execute($q);

while (!$r->EOF) {
	$total_maingroup = 0;
	$maingroup_nama = $r->fields["maingroup_nama"];
	echo "
		<tr>
			<td>".$maingroup_nama."</td>
			<td colspan='".($col - 1)."'>&nbsp;</td>
		</tr>
	";
	while ($maingroup_nama == $r->fields["maingroup_nama"]) {
		$total_subgroup = 0;
		$subgroup_nama = $r->fields["subgroup_nama"];
		echo "
			<tr>
				<td>&nbsp;</td>
				<td>".$subgroup_nama."</td>
				<td colspan='".($col - 2)."'>&nbsp;</td>
			</tr>
		";
		while ($subgroup_nama == $r->fields["subgroup_nama"]) {
			echo "
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>".$r->fields["tanggal"]."</td>
					<td>".$r->fields["supplier_nama"]."</td>
					<td>".$r->fields["nonota"]."</td>
					<td>".$r->fields["barang_nama"]."</td>
					<td align='right'>".number_format($r->fields["banyaknya"])."</td>
					<td>".$r->fields["barang_satuan"]."</td>
					<td align='right'>".number_format($r->fields["harga"])."</td>
					<td align='right'>".number_format($r->fields["jumlah"])."</td>
					<td>&nbsp;</td>
				</tr>
			";
			$total_subgroup += $r->fields["jumlah"];
			$r->MoveNext();
		}
		echo "
			<tr>
				<td>&nbsp;</td>
				<td align='right' colspan='".($col - 3)."'>Sub Total ".$subgroup_nama."</td>
				<td align='right'>".number_format($total_subgroup)."</td>
				<td>&nbsp;</td>
			</tr>
		";
		$total_maingroup += $total_subgroup;
	}
	echo "
		<tr>
			<td align='right' colspan='".($col - 1)."'>Sub Total ".$maingroup_nama."</td>
			<td align='right'>".number_format($total_maingroup)."</td>
		</tr>
		<tr>
			<td colspan='".$col."'>&nbsp;</td>
		</tr>
	";
	$total_keluar += $total_subgroup;
}
echo "
	<tr>
		<td align='right' colspan='".($col - 1)."'>Total Pengeluaran</td>
		<td align='right'>".number_format($total_keluar)."</td>
	</tr>
";
?>
</table>


<p>&nbsp;</p>


<!-- saldo -->
<?php
$col = 2;
?>

<table border="1">
	<tr>
		<td colspan="<?php echo $col;?>">Saldo</td>
	</tr>
	<!-- <tr>
		<td colspan="<?php echo $col;?>">&nbsp;</td>
	</tr> -->
	<tr>
		<td>Total Penerimaan</td>
		<td align='right'><?php echo number_format($total_terima);?></td>
	</tr>
	<tr>
		<td>Total Pengeluaran</td>
		<td align='right'><?php echo number_format($total_keluar);?></td>
	</tr>
	<tr>
		<td align='right'>Saldo</td>
		<td align='right'><?php echo number_format($total_terima - $total_keluar);?></td>
	</tr>
</table>