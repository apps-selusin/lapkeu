<?php

// Global variable for table object
$r02_terima_keluar = NULL;

//
// Table class for r02_terima_keluar
//
class crr02_terima_keluar extends crTableBase {
	var $ShowGroupHeaderAsRow = TRUE;
	var $ShowCompactSummaryFooter = TRUE;
	var $tanggal;
	var $ket1;
	var $ket2;
	var $ket3;
	var $ket4;
	var $ket5;
	var $nilai1;
	var $ket6;
	var $nilai2;
	var $terima_jumlah;
	var $keluar_jumlah;
	var $saldo;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 'r02_terima_keluar';
		$this->TableName = 'r02_terima_keluar';
		$this->TableType = 'REPORT';
		$this->TableReportType = 'summary';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)

		// tanggal
		$this->tanggal = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_tanggal', 'tanggal', '`tanggal`', 133, EWR_DATATYPE_DATE, 7);
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectField");
		$this->tanggal->DateFilter = "";
		$this->tanggal->SqlSelect = "";
		$this->tanggal->SqlOrderBy = "";
		$this->fields['tanggal'] = &$this->tanggal;

		// ket1
		$this->ket1 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket1', 'ket1', '`ket1`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket1->Sortable = TRUE; // Allow sort
		$this->ket1->GroupingFieldId = 1;
		$this->ket1->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->ket1->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->ket1->DateFilter = "";
		$this->ket1->SqlSelect = "";
		$this->ket1->SqlOrderBy = "";
		$this->ket1->FldGroupByType = "";
		$this->ket1->FldGroupInt = "0";
		$this->ket1->FldGroupSql = "";
		$this->fields['ket1'] = &$this->ket1;

		// ket2
		$this->ket2 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket2', 'ket2', '`ket2`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket2->Sortable = TRUE; // Allow sort
		$this->ket2->GroupingFieldId = 2;
		$this->ket2->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->ket2->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->ket2->DateFilter = "";
		$this->ket2->SqlSelect = "";
		$this->ket2->SqlOrderBy = "";
		$this->ket2->FldGroupByType = "";
		$this->ket2->FldGroupInt = "0";
		$this->ket2->FldGroupSql = "";
		$this->fields['ket2'] = &$this->ket2;

		// ket3
		$this->ket3 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket3', 'ket3', '`ket3`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket3->Sortable = TRUE; // Allow sort
		$this->ket3->DateFilter = "";
		$this->ket3->SqlSelect = "";
		$this->ket3->SqlOrderBy = "";
		$this->fields['ket3'] = &$this->ket3;

		// ket4
		$this->ket4 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket4', 'ket4', '`ket4`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket4->Sortable = TRUE; // Allow sort
		$this->ket4->DateFilter = "";
		$this->ket4->SqlSelect = "";
		$this->ket4->SqlOrderBy = "";
		$this->fields['ket4'] = &$this->ket4;

		// ket5
		$this->ket5 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket5', 'ket5', '`ket5`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket5->Sortable = TRUE; // Allow sort
		$this->ket5->DateFilter = "";
		$this->ket5->SqlSelect = "";
		$this->ket5->SqlOrderBy = "";
		$this->fields['ket5'] = &$this->ket5;

		// nilai1
		$this->nilai1 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_nilai1', 'nilai1', '`nilai1`', 5, EWR_DATATYPE_NUMBER, -1);
		$this->nilai1->Sortable = TRUE; // Allow sort
		$this->nilai1->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->nilai1->DateFilter = "";
		$this->nilai1->SqlSelect = "";
		$this->nilai1->SqlOrderBy = "";
		$this->fields['nilai1'] = &$this->nilai1;

		// ket6
		$this->ket6 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_ket6', 'ket6', '`ket6`', 200, EWR_DATATYPE_STRING, -1);
		$this->ket6->Sortable = TRUE; // Allow sort
		$this->ket6->DateFilter = "";
		$this->ket6->SqlSelect = "";
		$this->ket6->SqlOrderBy = "";
		$this->fields['ket6'] = &$this->ket6;

		// nilai2
		$this->nilai2 = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_nilai2', 'nilai2', '`nilai2`', 5, EWR_DATATYPE_NUMBER, -1);
		$this->nilai2->Sortable = TRUE; // Allow sort
		$this->nilai2->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->nilai2->DateFilter = "";
		$this->nilai2->SqlSelect = "";
		$this->nilai2->SqlOrderBy = "";
		$this->fields['nilai2'] = &$this->nilai2;

		// terima_jumlah
		$this->terima_jumlah = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_terima_jumlah', 'terima_jumlah', '`terima_jumlah`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->terima_jumlah->Sortable = TRUE; // Allow sort
		$this->terima_jumlah->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->terima_jumlah->DateFilter = "";
		$this->terima_jumlah->SqlSelect = "";
		$this->terima_jumlah->SqlOrderBy = "";
		$this->fields['terima_jumlah'] = &$this->terima_jumlah;

		// keluar_jumlah
		$this->keluar_jumlah = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_keluar_jumlah', 'keluar_jumlah', '`keluar_jumlah`', 5, EWR_DATATYPE_NUMBER, -1);
		$this->keluar_jumlah->Sortable = TRUE; // Allow sort
		$this->keluar_jumlah->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->keluar_jumlah->DateFilter = "";
		$this->keluar_jumlah->SqlSelect = "";
		$this->keluar_jumlah->SqlOrderBy = "";
		$this->fields['keluar_jumlah'] = &$this->keluar_jumlah;

		// saldo
		$this->saldo = new crField('r02_terima_keluar', 'r02_terima_keluar', 'x_saldo', 'saldo', '`saldo`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->saldo->Sortable = TRUE; // Allow sort
		$this->saldo->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->saldo->DateFilter = "";
		$this->saldo->SqlSelect = "";
		$this->saldo->SqlOrderBy = "";
		$this->fields['saldo'] = &$this->saldo;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ofld->GroupingFieldId == 0) {
				if ($ctrl) {
					$sOrderBy = $this->getDetailOrderBy();
					if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
						$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
					} else {
						if ($sOrderBy <> "") $sOrderBy .= ", ";
						$sOrderBy .= $sSortField . " " . $sThisSort;
					}
					$this->setDetailOrderBy($sOrderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
				}
			}
		} else {
			if ($ofld->GroupingFieldId == 0 && !$ctrl) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v02_terima_keluar`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`ket1` ASC, `ket2` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`ket1`";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`ket1` ASC";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`terima_jumlah`) AS `sum_terima_jumlah`, SUM(`keluar_jumlah`) AS `sum_keluar_jumlah` FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Get record count
	public function getRecordCount($sql)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery and SELECT DISTINCT
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) && !preg_match('/^\s*select\s+distinct\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Sort URL
	function SortUrl(&$fld) {
		global $grDashboardReport;
		if ($this->Export <> "" || $grDashboardReport ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {

			//$sUrlParm = "order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort();
			$sUrlParm = "order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort();
			return ewr_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $grLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		if ($this->terima_jumlah->CurrentValue > 0) {
			$GLOBALS["final_saldo"] = $GLOBALS["final_saldo"] + $this->terima_jumlah->CurrentValue;
		}
		else {
			$GLOBALS["final_saldo"] = $GLOBALS["final_saldo"] - $this->keluar_jumlah->CurrentValue;
		}
		$this->saldo->ViewValue = number_format($GLOBALS["final_saldo"]);
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
