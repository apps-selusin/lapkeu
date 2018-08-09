<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(11, "mi_cf01_home_php", $Language->MenuPhrase("11", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10016, "mi_t08_penerimaan", $Language->MenuPhrase("10016", "MenuText"), "t08_penerimaanlist.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t08_penerimaan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_t06_pengeluaran", $Language->MenuPhrase("6", "MenuText"), "t06_pengeluaranlist.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(22, "mci_Setup", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(33, "mi_t07_sekolah", $Language->MenuPhrase("33", "MenuText"), "t07_sekolahlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t07_sekolah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_t01_supplier", $Language->MenuPhrase("1", "MenuText"), "t01_supplierlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t02_satuan", $Language->MenuPhrase("2", "MenuText"), "t02_satuanlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t03_barang", $Language->MenuPhrase("3", "MenuText"), "t03_baranglist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_t04_maingroup", $Language->MenuPhrase("4", "MenuText"), "t04_maingrouplist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(32, "mci_User", $Language->MenuPhrase("32", "MenuText"), "", 22, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(7, "mi_t96_employees", $Language->MenuPhrase("7", "MenuText"), "t96_employeeslist.php", 32, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_t97_userlevels", $Language->MenuPhrase("8", "MenuText"), "t97_userlevelslist.php", 32, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(23, "mi_t99_audittrail", $Language->MenuPhrase("23", "MenuText"), "t99_audittraillist.php", 32, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10012, "mci_Laporan", $Language->MenuPhrase("10012", "MenuText"), "", -1, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10019, "mri_r025fterima5fkeluar", $Language->MenuPhrase("10019", "MenuText"), "r02_terima_keluarsmry.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}r02_terima_keluar'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10007, "mri_t075fsekolah", $Language->MenuPhrase("10007", "MenuText"), "t07_sekolahrpt.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t07_sekolah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10001, "mri_t015fsupplier", $Language->MenuPhrase("10001", "MenuText"), "t01_supplierrpt.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t01_supplier'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10002, "mri_t025fsatuan", $Language->MenuPhrase("10002", "MenuText"), "t02_satuanrpt.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t02_satuan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10003, "mri_t035fbarang", $Language->MenuPhrase("10003", "MenuText"), "t03_barangrpt.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t03_barang'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10014, "mri_r015fjenis5fpengeluaran", $Language->MenuPhrase("10014", "MenuText"), "r01_jenis_pengeluaransmry.php", 10012, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}r01_jenis_pengeluaran'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
