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
?>
