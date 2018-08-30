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

// data sekolah
$q = "select * from t07_sekolah";
$r = Conn()->Execute($q);
$sekolah_nama = $r->fields["Nama"];
$sekolah_alamat = $r->fields["Alamat"];
$sekolah_notelphp = $r->fields["NoTelpHp"];
$sekolah_ttd1nama = $r->fields["TTD1Nama"];
$sekolah_ttd1jabatan = $r->fields["TTD1Jabatan"];
$sekolah_ttd2nama = $r->fields["TTD2Nama"];
$sekolah_ttd2jabatan = $r->fields["TTD2Jabatan"];

$aBulan = array(
	"",
	"Januari",
	"Februari",
	"Maret",
	"April",
	"Mei",
	"Juni",
	"Juli",
	"Agustus",
	"September",
	"Oktober",
	"November",
	"Desember"
	);

$TanggalLaporan  = date("d") . " " . $aBulan[date("n")] . " " . date("Y"); //$rsnew["Tahun"] . "-" . $rsnew["Bulan"] . "-" . "01";
	

// data periode
$q = "select * from t09_periode";
$r = Conn()->Execute($q);
$periode_bulan = $r->fields["Bulan"];
$periode_namabulan = $r->fields["NamaBulan"];
$periode_tahun = $r->fields["Tahun"];
$tanggalawal = date("d-m-Y", strtotime($r->fields["TanggalAwal"]));
$tanggalakhir = date("d-m-Y", strtotime($r->fields["TanggalAkhir"]));

$q = "select * from t10_saldo";
$r = Conn()->Execute($q);
$saldo = $r->fields["Jumlah"];

$q = "select * from t08_penerimaan order by Tanggal";
$rpenerimaan = Conn()->Execute($q);

$no = 1;
?>
<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$baris = 1;
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, 'Laporan Keuangan'); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$baris++;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $sekolah_nama); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$baris++;

//$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $sekolah_alamat . " - " . $sekolah_notelphp); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $sekolah_alamat); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$baris++;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, "Periode ".$periode_namabulan . " " . $periode_tahun); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$baris++;

$objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':M'.$baris);
$baris++;
//$objPHPExcel->getActiveSheet()->setCellValue('B3', $_SESSION["r03_pengeluaran_filter"]); $objPHPExcel->getActiveSheet()->mergeCells('B3:L3'); $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//$baris = 4; // baris mulai untuk tampilkan header kolom
$baris_mulai_data = $baris;
$kolom_akhir = "M";



// saldo awal ----------------------------------------------------------------------------------------------------
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'Saldo Awal'); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':M'.$baris.'');
$baris++;

// kolom header saldo awal
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, 'Tanggal');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, 'Keterangan'); $objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':L'.$baris.'');
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, 'Jumlah');
$baris++;

// show data saldo awal
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no++);
$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $tanggalawal);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, 'Saldo Awal'); $objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':L'.$baris.'');
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $saldo); $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$baris++;

// pemisah; baris kosong;
$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;



// penerimaan ----------------------------------------------------------------------------------------------------
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'Penerimaan'); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':M'.$baris.'');
$baris++;

// kolom header penerimaan
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, 'Tanggal');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, 'Keterangan'); $objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':F'.$baris.'');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, 'No. Kwitansi'); $objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':K'.$baris.'');
$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, 'Jumlah');
$baris++;

$penerimaan = 0;
while (!$rpenerimaan->EOF) {
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $no++);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, date("d-m-Y", strtotime($rpenerimaan->fields["Tanggal"])));
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $rpenerimaan->fields["Keterangan"]); $objPHPExcel->getActiveSheet()->getStyle('C'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); $objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':F'.$baris.'');
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $rpenerimaan->fields["NoKwitansi"]); $objPHPExcel->getActiveSheet()->getStyle('G'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); $objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':K'.$baris.'');
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $rpenerimaan->fields["Jumlah"]); $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$baris++;
	$penerimaan += $rpenerimaan->fields["Jumlah"];
 	$rpenerimaan->MoveNext();
}
$saldo += $penerimaan;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, "Total Penerimaan"); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $penerimaan); $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$baris++;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, "Saldo Awal + Total Penerimaan"); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $saldo); $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$baris++;

// pemisah; baris kosong;
$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;



// pengeluaran ----------------------------------------------------------------------------------------------------
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'Pengeluaran'); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':M'.$baris.'');
$baris++;

// kolom header pengeluaran
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, 'Jenis Pengeluaran'); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':B'.$baris.'');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, 'No.');
$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, 'Tanggal');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, 'Supplier');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, 'No. Nota');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, 'Barang');
$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, 'Banyaknya');
$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, 'Satuan');
$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, 'Harga');
$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, 'Jumlah');
$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, 'Sub Total');
$baris++;

// query data
// filtering data
$filter = "";
if ($_SESSION["r03_pengeluaran_filter"]) {
	$filter = "where ".$_SESSION["r03_pengeluaran_filter"];
}
$q = "select * from v03_pengeluaran ".$filter." order by maingroup_nama, subgroup_nama, tanggal";
$r = Conn()->Execute($q);

$total_keluar = 0;

while (!$r->EOF) {
	$total_maingroup = 0;
	$maingroup_nama = $r->fields["maingroup_nama"];
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, $maingroup_nama); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris.'');
	$baris++;
	while ($maingroup_nama == $r->fields["maingroup_nama"]) {
		$total_subgroup = 0;
		$subgroup_nama = $r->fields["subgroup_nama"];
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $subgroup_nama); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':K'.$baris.'');
		$baris++;
		while ($subgroup_nama == $r->fields["subgroup_nama"]) {
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$baris, $no++);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$baris, date("d-m-Y", strtotime($r->fields["tanggal"])));
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$baris, $r->fields["supplier_nama"]);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$baris, $r->fields["nonota"]);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $r->fields["barang_nama"]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$baris, $r->fields["banyaknya"]); $objPHPExcel->getActiveSheet()->getStyle('H'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$baris, $r->fields["barang_satuan"]);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$baris, $r->fields["harga"]); $objPHPExcel->getActiveSheet()->getStyle('J'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $r->fields["Jumlah"]); $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$baris++;
			$total_subgroup += $r->fields["Jumlah"];
			$r->MoveNext();
		}
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, "Sub Total ".$subgroup_nama); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':J'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('B'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$baris, $total_subgroup); $objPHPExcel->getActiveSheet()->getStyle('K'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$baris++;
		$total_maingroup += $total_subgroup;
	}
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, "Sub Total ".$maingroup_nama); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':K'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$baris, $total_maingroup); $objPHPExcel->getActiveSheet()->getStyle('L'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$baris++; 
	$total_keluar += $total_maingroup;
}
$saldo -= $total_keluar;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;

$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, "Total Pengeluaran"); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $total_keluar); $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$baris++;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':'.$kolom_akhir.$baris.'');
$baris++;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$baris, "Saldo Akhir = (Saldo Awal + Total Penerimaan) - Total Pengeluaran"); $objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':L'.$baris.''); $objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->setCellValue('M'.$baris, $saldo); $objPHPExcel->getActiveSheet()->getStyle('M'.$baris)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
//$baris++;


$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
//$objPHPExcel->getActiveSheet()->getStyle('A4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// tampilkan border line di all column
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);
$objPHPExcel->getActiveSheet()->getStyle('A'.$baris_mulai_data.':M'.$baris)->applyFromArray($styleArray);

$baris += 3;
$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, 'Bojonegoro, '.$TanggalLaporan); $objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':J'.$baris);
$baris++;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $sekolah_ttd1jabatan); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':E'.$baris);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $sekolah_ttd2jabatan); $objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':J'.$baris);
$baris+= 4;

$objPHPExcel->getActiveSheet()->setCellValue('B'.$baris, $sekolah_ttd1nama); $objPHPExcel->getActiveSheet()->mergeCells('B'.$baris.':E'.$baris);
$objPHPExcel->getActiveSheet()->setCellValue('G'.$baris, $sekolah_ttd2nama); $objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':J'.$baris);
//$baris+= 3;

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Add a drawing to the worksheet
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/officelogo.jpg');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


/*$objPHPExcel->getActiveSheet()->setCellValue('A4', '1001');
$objPHPExcel->getActiveSheet()->setCellValue('B4', 'PHP for dummies');
$objPHPExcel->getActiveSheet()->setCellValue('C4', '20');
$objPHPExcel->getActiveSheet()->setCellValue('D4', '1');
$objPHPExcel->getActiveSheet()->setCellValue('E4', '=IF(D4<>"",C4*D4,"")');

$objPHPExcel->getActiveSheet()->setCellValue('A5', '1012');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'OpenXML for dummies');
$objPHPExcel->getActiveSheet()->setCellValue('C5', '22');
$objPHPExcel->getActiveSheet()->setCellValue('D5', '2');
$objPHPExcel->getActiveSheet()->setCellValue('E5', '=IF(D5<>"",C5*D5,"")');

$objPHPExcel->getActiveSheet()->setCellValue('E6', '=IF(D6<>"",C6*D6,"")');
$objPHPExcel->getActiveSheet()->setCellValue('E7', '=IF(D7<>"",C7*D7,"")');
$objPHPExcel->getActiveSheet()->setCellValue('E8', '=IF(D8<>"",C8*D8,"")');
$objPHPExcel->getActiveSheet()->setCellValue('E9', '=IF(D9<>"",C9*D9,"")');

$objPHPExcel->getActiveSheet()->setCellValue('D11', 'Total excl.:');
$objPHPExcel->getActiveSheet()->setCellValue('E11', '=SUM(E4:E9)');

$objPHPExcel->getActiveSheet()->setCellValue('D12', 'VAT:');
$objPHPExcel->getActiveSheet()->setCellValue('E12', '=E11*0.21');

$objPHPExcel->getActiveSheet()->setCellValue('D13', 'Total incl.:');
$objPHPExcel->getActiveSheet()->setCellValue('E13', '=E11+E12');*/

/*
// Add comment
echo date('H:i:s') , " Add comments" , EOL;

$objPHPExcel->getActiveSheet()->getComment('E11')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E11')->getText()->createTextRun('Total amount on the current invoice, excluding VAT.');

$objPHPExcel->getActiveSheet()->getComment('E12')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E12')->getText()->createTextRun('Total amount of VAT on the current invoice.');

$objPHPExcel->getActiveSheet()->getComment('E13')->setAuthor('PHPExcel');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun('PHPExcel:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun("\r\n");
$objPHPExcel->getActiveSheet()->getComment('E13')->getText()->createTextRun('Total amount on the current invoice, including VAT.');
$objPHPExcel->getActiveSheet()->getComment('E13')->setWidth('100pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->setHeight('100pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->setMarginLeft('150pt');
$objPHPExcel->getActiveSheet()->getComment('E13')->getFillColor()->setRGB('EEEEEE');


// Add rich-text string
echo date('H:i:s') , " Add rich-text string" , EOL;
$objRichText = new PHPExcel_RichText();
$objRichText->createText('This invoice is ');

$objPayable = $objRichText->createTextRun('payable within thirty days after the end of the month');
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setItalic(true);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );

$objRichText->createText(', unless specified otherwise on the invoice.');

$objPHPExcel->getActiveSheet()->getCell('A18')->setValue($objRichText);

// Merge cells
echo date('H:i:s') , " Merge cells" , EOL;
$objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
$objPHPExcel->getActiveSheet()->mergeCells('A28:B28');		// Just to test...
$objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');	// Just to test...

// Protect cells
echo date('H:i:s') , " Protect cells" , EOL;
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);	// Needs to be set to true in order to enable any worksheet protection!
$objPHPExcel->getActiveSheet()->protectCells('A3:E13', 'PHPExcel');

// Set cell number formats
echo date('H:i:s') , " Set cell number formats" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('E4:E13')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

// Set column widths
echo date('H:i:s') , " Set column widths" , EOL;
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);

// Set fonts
echo date('H:i:s') , " Set fonts" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D13')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E13')->getFont()->setBold(true);

// Set alignments
echo date('H:i:s') , " Set alignments" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setShrinkToFit(true);

// Set thin black border outline around column
echo date('H:i:s') , " Set thin black border outline around column" , EOL;
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A4:E10')->applyFromArray($styleThinBlackBorderOutline);


// Set thick brown border outline around "Total"
echo date('H:i:s') , " Set thick brown border outline around Total" , EOL;
$styleThickBrownBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => 'FF993300'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('D13:E13')->applyFromArray($styleThickBrownBorderOutline);

// Set fills
echo date('H:i:s') , " Set fills" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FF808080');

// Set style for header row using alternative method
echo date('H:i:s') , " Set style for header row using alternative method" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'left'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray(
		array(
			'borders' => array(
				'right'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

// Unprotect a cell
echo date('H:i:s') , " Unprotect a cell" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('B1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

// Add a hyperlink to the sheet
echo date('H:i:s') , " Add a hyperlink to an external website" , EOL;
$objPHPExcel->getActiveSheet()->setCellValue('E26', 'www.phpexcel.net');
$objPHPExcel->getActiveSheet()->getCell('E26')->getHyperlink()->setUrl('http://www.phpexcel.net');
$objPHPExcel->getActiveSheet()->getCell('E26')->getHyperlink()->setTooltip('Navigate to website');
$objPHPExcel->getActiveSheet()->getStyle('E26')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

echo date('H:i:s') , " Add a hyperlink to another cell on a different worksheet within the workbook" , EOL;
$objPHPExcel->getActiveSheet()->setCellValue('E27', 'Terms and conditions');
$objPHPExcel->getActiveSheet()->getCell('E27')->getHyperlink()->setUrl("sheet://'Terms and conditions'!A1");
$objPHPExcel->getActiveSheet()->getCell('E27')->getHyperlink()->setTooltip('Review terms and conditions');
$objPHPExcel->getActiveSheet()->getStyle('E27')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// Add a drawing to the worksheet
echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/officelogo.jpg');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Add a drawing to the worksheet
echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Paid');
$objDrawing->setDescription('Paid');
$objDrawing->setPath('./images/paid.png');
$objDrawing->setCoordinates('B15');
$objDrawing->setOffsetX(110);
$objDrawing->setRotation(25);
$objDrawing->getShadow()->setVisible(true);
$objDrawing->getShadow()->setDirection(45);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Add a drawing to the worksheet
echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('./images/phpexcel_logo.gif');
$objDrawing->setHeight(36);
$objDrawing->setCoordinates('D24');
$objDrawing->setOffsetX(10);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Play around with inserting and removing rows and columns
echo date('H:i:s') , " Play around with inserting and removing rows and columns" , EOL;
$objPHPExcel->getActiveSheet()->insertNewRowBefore(6, 10);
$objPHPExcel->getActiveSheet()->removeRow(6, 10);
$objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', 5);
$objPHPExcel->getActiveSheet()->removeColumn('E', 5);

// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
echo date('H:i:s') , " Set header/footer" , EOL;
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size
echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Rename first worksheet
echo date('H:i:s') , " Rename first worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Invoice');


// Create a new worksheet, after the default sheet
echo date('H:i:s') , " Create a second Worksheet object" , EOL;
$objPHPExcel->createSheet();

// Llorem ipsum...
$sLloremIpsum = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus eget ante. Sed cursus nunc semper tortor. Aliquam luctus purus non elit. Fusce vel elit commodo sapien dignissim dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur accumsan magna sed massa. Nullam bibendum quam ac ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin augue. Praesent malesuada justo sed orci. Pellentesque lacus ligula, sodales quis, ultricies a, ultricies vitae, elit. Sed luctus consectetuer dolor. Vivamus vel sem ut nisi sodales accumsan. Nunc et felis. Suspendisse semper viverra odio. Morbi at odio. Integer a orci a purus venenatis molestie. Nam mattis. Praesent rhoncus, nisi vel mattis auctor, neque nisi faucibus sem, non dapibus elit pede ac nisl. Cras turpis.';

// Add some data to the second sheet, resembling some different data types
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Terms and conditions');
$objPHPExcel->getActiveSheet()->setCellValue('A3', $sLloremIpsum);
$objPHPExcel->getActiveSheet()->setCellValue('A4', $sLloremIpsum);
$objPHPExcel->getActiveSheet()->setCellValue('A5', $sLloremIpsum);
$objPHPExcel->getActiveSheet()->setCellValue('A6', $sLloremIpsum);

// Set the worksheet tab color
echo date('H:i:s') , " Set the worksheet tab color" , EOL;
$objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');;

// Set alignments
echo date('H:i:s') , " Set alignments" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A3:A6')->getAlignment()->setWrapText(true);

// Set column widths
echo date('H:i:s') , " Set column widths" , EOL;
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(80);

// Set fonts
echo date('H:i:s') , " Set fonts" , EOL;
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);

$objPHPExcel->getActiveSheet()->getStyle('A3:A6')->getFont()->setSize(8);

// Add a drawing to the worksheet
echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Terms and conditions');
$objDrawing->setDescription('Terms and conditions');
$objDrawing->setPath('./images/termsconditions.jpg');
$objDrawing->setCoordinates('B14');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// Set page orientation and size
echo date('H:i:s') , " Set page orientation and size" , EOL;
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Rename second worksheet
echo date('H:i:s') , " Rename second worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Terms and conditions');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
*/
