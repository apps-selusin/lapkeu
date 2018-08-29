<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(11, "mi_cf01_home_php", $Language->MenuPhrase("11", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10016, "mi_t08_penerimaan", $Language->MenuPhrase("10016", "MenuText"), "t08_penerimaanlist.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t08_penerimaan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_t06_pengeluaran", $Language->MenuPhrase("6", "MenuText"), "t06_pengeluaranlist.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10088, "mci_Laporan", $Language->MenuPhrase("10088", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10018, "mri_t085fpenerimaan", $Language->MenuPhrase("10018", "MenuText"), "t08_penerimaanrpt.php", 10088, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t08_penerimaan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10019, "mri_r035fpengeluaran", $Language->MenuPhrase("10019", "MenuText"), "r03_pengeluaransmry.php", 10088, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}r03_pengeluaran'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10132, "mi_r02_keuangan_php", $Language->MenuPhrase("10132", "MenuText"), "r02_keuangan.php", 10088, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}r02_keuangan.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10131, "mi_cf02_tutupbuku_php", $Language->MenuPhrase("10131", "MenuText"), "cf02_tutupbuku.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf02_tutupbuku.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10171, "mci_Laporan_28Closed29", $Language->MenuPhrase("10171", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10175, "mi_cf03_homeold_php", $Language->MenuPhrase("10175", "MenuText"), "cf03_homeold.php", 10171, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf03_homeold.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10027, "mri_t145fperiodeold", $Language->MenuPhrase("10027", "MenuText"), "t14_periodeoldrpt.php", 10171, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t14_periodeold'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10024, "mri_t115fsaldoold", $Language->MenuPhrase("10024", "MenuText"), "t11_saldooldrpt.php", 10171, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t11_saldoold'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10025, "mri_t125fpenerimaanold", $Language->MenuPhrase("10025", "MenuText"), "t12_penerimaanoldrpt.php", 10171, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t12_penerimaanold'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10029, "mri_r045fpengeluaranold", $Language->MenuPhrase("10029", "MenuText"), "r04_pengeluaranoldsmry.php", 10171, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}r04_pengeluaranold'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10174, "mi_r05_keuanganold_php", $Language->MenuPhrase("10174", "MenuText"), "r05_keuanganold.php", 10171, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}r05_keuanganold.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(22, "mci_Setup", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10129, "mi_t09_periode", $Language->MenuPhrase("10129", "MenuText"), "t09_periodelist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t09_periode'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10130, "mi_t10_saldo", $Language->MenuPhrase("10130", "MenuText"), "t10_saldolist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t10_saldo'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(33, "mi_t07_sekolah", $Language->MenuPhrase("33", "MenuText"), "t07_sekolahlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t07_sekolah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_t01_supplier", $Language->MenuPhrase("1", "MenuText"), "t01_supplierlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t02_satuan", $Language->MenuPhrase("2", "MenuText"), "t02_satuanlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t03_barang", $Language->MenuPhrase("3", "MenuText"), "t03_baranglist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_t04_maingroup", $Language->MenuPhrase("4", "MenuText"), "t04_maingrouplist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(32, "mci_User", $Language->MenuPhrase("32", "MenuText"), "", 22, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(7, "mi_t96_employees", $Language->MenuPhrase("7", "MenuText"), "t96_employeeslist.php", 32, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_t97_userlevels", $Language->MenuPhrase("8", "MenuText"), "t97_userlevelslist.php", 32, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(23, "mi_t99_audittrail", $Language->MenuPhrase("23", "MenuText"), "t99_audittraillist.php", 32, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10176, "mi_cf04_update_php", $Language->MenuPhrase("10176", "MenuText"), "cf04_update.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf04_update.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10177, "mi_cf05_backup_php", $Language->MenuPhrase("10177", "MenuText"), "cf05_backup.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf05_backup.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10118, "mci_List", $Language->MenuPhrase("10118", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(10007, "mri_t075fsekolah", $Language->MenuPhrase("10007", "MenuText"), "t07_sekolahrpt.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t07_sekolah'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10001, "mri_t015fsupplier", $Language->MenuPhrase("10001", "MenuText"), "t01_supplierrpt.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t01_supplier'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10002, "mri_t025fsatuan", $Language->MenuPhrase("10002", "MenuText"), "t02_satuanrpt.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t02_satuan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10003, "mri_t035fbarang", $Language->MenuPhrase("10003", "MenuText"), "t03_barangrpt.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t03_barang'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10014, "mri_r015fjenis5fpengeluaran", $Language->MenuPhrase("10014", "MenuText"), "r01_jenis_pengeluaransmry.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}r01_jenis_pengeluaran'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10011, "mri_t995faudittrail", $Language->MenuPhrase("10011", "MenuText"), "t99_audittrailrpt.php", 10118, "{3CDC6268-D928-4495-B72A-CA5D35EAE344}", AllowListMenu('{3CDC6268-D928-4495-B72A-CA5D35EAE344}t99_audittrail'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
