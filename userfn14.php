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
	$r = Conn->Execute($q);
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
?>
