<?php

// Menu
$RootMenu = new crMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(12, "mci_Laporan", $ReportLanguage->MenuPhrase("12", "MenuText"), "", -1, "", TRUE, FALSE, TRUE, "");
$RootMenu->AddMenuItem(7, "mi_t07_sekolah", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("7", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "t07_sekolahrpt.php", 12, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_t01_supplier", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("1", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "t01_supplierrpt.php", 12, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_t02_satuan", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("2", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "t02_satuanrpt.php", 12, "", TRUE, FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_t03_barang", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("3", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "t03_barangrpt.php", 12, "", TRUE, FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
