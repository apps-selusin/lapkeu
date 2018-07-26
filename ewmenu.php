<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(11, "mi_cf01_home_php", $Language->MenuPhrase("11", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}cf01_home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(6, "mi_t06_pengeluaran", $Language->MenuPhrase("6", "MenuText"), "t06_pengeluaranlist.php", -1, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t06_pengeluaran'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(22, "mci_Setup", $Language->MenuPhrase("22", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_t01_supplier", $Language->MenuPhrase("1", "MenuText"), "t01_supplierlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t01_supplier'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t02_satuan", $Language->MenuPhrase("2", "MenuText"), "t02_satuanlist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t02_satuan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t03_barang", $Language->MenuPhrase("3", "MenuText"), "t03_baranglist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t03_barang'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_t04_maingroup", $Language->MenuPhrase("4", "MenuText"), "t04_maingrouplist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t04_maingroup'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_t96_employees", $Language->MenuPhrase("7", "MenuText"), "t96_employeeslist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t96_employees'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_t97_userlevels", $Language->MenuPhrase("8", "MenuText"), "t97_userlevelslist.php", 22, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(9, "mi_t98_userlevelpermissions", $Language->MenuPhrase("9", "MenuText"), "t98_userlevelpermissionslist.php", 22, "", IsAdmin(), FALSE, FALSE, "");
$RootMenu->AddMenuItem(23, "mi_t99_audittrail", $Language->MenuPhrase("23", "MenuText"), "t99_audittraillist.php", 22, "", AllowListMenu('{239A2A32-109A-412F-A3CB-FF6290C167FC}t99_audittrail'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
