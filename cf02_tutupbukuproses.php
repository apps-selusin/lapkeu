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
$saldo_akhir = 0;



// tabel saldo --------------------------------------------------
// ambil data saldo awal
$q = "select Jumlah from t10_saldo";
$r = Conn()->Execute($q);
$saldo_akhir = $r->fields["Jumlah"]; // simpan data saldo awal untuk saldo akhir

// proses pindah data dari tabel saldo ke tabel saldoold
$q = "insert into t11_saldoold (Bulan, Tahun, Jumlah) select Bulan, Tahun, Jumlah from t10_saldo";
Conn()->Execute($q);

// kosongkan data di tabel saldo
$q = "truncate t10_saldo";
Conn()->Execute($q);



// tabel penerimaan --------------------------------------------------
// ambil data akumulasi penerimaan
$q = "select sum(Jumlah) as Jumlah from t08_penerimaan";
$r = Conn()->Execute($q);
$saldo_akhir += $r->fields["Jumlah"]; // simpan data akumulasi jumlah penerimaan untuk saldo akhir

// proses pindah data dari tabel penerimaan ke tabel penerimaan_old
$q = "insert into t12_penerimaanold (Tanggal, NoKwitansi, Keterangan, Jumlah) select Tanggal, NoKwitansi, Keterangan, Jumlah from t08_penerimaan";
Conn()->Execute($q);

// kosongkan data di tabel penerimaan
$q = "truncate t08_penerimaan";
Conn()->Execute($q);



// tabel pengeluaran --------------------------------------------------
// ambil data akumulasi pengeluaran
$q = "select sum(Jumlah) as Jumlah from t06_pengeluaran";
$r = Conn()->Execute($q);
$saldo_akhir -= $r->fields["Jumlah"]; // simpan data akumulasi jumlah pengeluaran untuk saldo akhir

// proses pindah data dari tabel pengeluaran ke tabel pengeluaran_old
$q = "insert into t13_pengeluaranold (
    supplier_id,
    Tanggal,
    NoNota,
    barang_id,
    Banyaknya,
    Harga,
    Jumlah,
    maingroup_id,
    subgroup_id) 
    select 
    supplier_id,
    Tanggal,
    NoNota,
    barang_id,
    Banyaknya,
    Harga,
    Jumlah,
    maingroup_id,
    subgroup_id
    from t06_pengeluaran";
Conn()->Execute($q);

// kosongkan data di tabel pengeluaran
$q = "truncate t06_pengeluaran";
Conn()->Execute($q);



// tabel periode --------------------------------------------------
// proses pindah data dari tabel periode ke tabel periode_old
$q = "insert into t14_periodeold (Bulan, Tahun, TanggalAwal, TanggalAkhir, NamaBulan) select Bulan, Tahun, TanggalAwal, TanggalAkhir, NamaBulan from t09_periode";
Conn()->Execute($q);

// update data di tabel periode dengan data periode baru
$q = "select * from t09_periode";
$r = Conn()->Execute($q);
$periode_lalu_bulan = $r->fields["Bulan"];
$periode_lalu_tahun = $r->fields["Tahun"];
$periode_skrg_bulan = $periode_lalu_bulan + 1;
$periode_skrg_tahun = $periode_lalu_tahun;
if ($periode_skrg_bulan == 13) {
    $periode_skrg_bulan = 1;
    $periode_skrg_tahun = $periode_lalu_tahun + 1;
}
$tanggalawal = $periode_skrg_tahun . "-" . substr("00".$periode_skrg_bulan, -2) . "-" . "01";
$tanggalakhir = $periode_skrg_tahun . "-" . substr("00".$periode_skrg_bulan, -2) . "-" . date("t", mktime(0, 0, 0, substr("00".$periode_skrg_bulan, -2), 1, $periode_skrg_tahun));
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
$q = "truncate t09_periode";
Conn()->Execute($q);

$q = "insert into t09_periode values (null, ".$periode_skrg_bulan.", ".$periode_skrg_tahun.", 
    '".$tanggalawal."', '".$tanggalakhir."', '".$aBulan[$periode_skrg_bulan]."')";
Conn()->Execute($q); //echo $q; exit();



// inputkan nilai saldo akhir sebagai saldo awal di periode baru di tabel saldo
$q = "insert into t10_saldo values (null, ".$periode_skrg_bulan.", ".$periode_skrg_tahun.", ".$saldo_akhir.")";
Conn()->Execute($q); //echo $q;



// kembali ke cf02_tutupbuku
header("location: cf02_tutupbuku.php?ok=1");
?>