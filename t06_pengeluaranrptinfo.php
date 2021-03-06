<?php

// Global variable for table object
$t06_pengeluaran = NULL;

//
// Table class for t06_pengeluaran
//
class crt06_pengeluaran extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $id;
	var $supplier_id;
	var $Tanggal;
	var $NoNota;
	var $barang_id;
	var $Banyaknya;
	var $Harga;
	var $Jumlah;
	var $subgroup_id;
	var $maingroup_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 't06_pengeluaran';
		$this->TableName = 't06_pengeluaran';
		$this->TableType = 'TABLE';
		$this->TableReportType = 'rpt';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)

		// id
		$this->id = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_id', 'id', '`id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->id->DateFilter = "";
		$this->id->SqlSelect = "";
		$this->id->SqlOrderBy = "";
		$this->fields['id'] = &$this->id;

		// supplier_id
		$this->supplier_id = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_supplier_id', 'supplier_id', '`supplier_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->supplier_id->Sortable = TRUE; // Allow sort
		$this->supplier_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->supplier_id->DateFilter = "";
		$this->supplier_id->SqlSelect = "";
		$this->supplier_id->SqlOrderBy = "";
		$this->fields['supplier_id'] = &$this->supplier_id;

		// Tanggal
		$this->Tanggal = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_Tanggal', 'Tanggal', '`Tanggal`', 133, EWR_DATATYPE_DATE, 0);
		$this->Tanggal->Sortable = TRUE; // Allow sort
		$this->Tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->Tanggal->DateFilter = "";
		$this->Tanggal->SqlSelect = "";
		$this->Tanggal->SqlOrderBy = "";
		$this->fields['Tanggal'] = &$this->Tanggal;

		// NoNota
		$this->NoNota = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_NoNota', 'NoNota', '`NoNota`', 200, EWR_DATATYPE_STRING, -1);
		$this->NoNota->Sortable = TRUE; // Allow sort
		$this->NoNota->DateFilter = "";
		$this->NoNota->SqlSelect = "";
		$this->NoNota->SqlOrderBy = "";
		$this->fields['NoNota'] = &$this->NoNota;

		// barang_id
		$this->barang_id = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_barang_id', 'barang_id', '`barang_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->barang_id->Sortable = TRUE; // Allow sort
		$this->barang_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->barang_id->DateFilter = "";
		$this->barang_id->SqlSelect = "";
		$this->barang_id->SqlOrderBy = "";
		$this->fields['barang_id'] = &$this->barang_id;

		// Banyaknya
		$this->Banyaknya = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_Banyaknya', 'Banyaknya', '`Banyaknya`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Banyaknya->Sortable = TRUE; // Allow sort
		$this->Banyaknya->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Banyaknya->DateFilter = "";
		$this->Banyaknya->SqlSelect = "";
		$this->Banyaknya->SqlOrderBy = "";
		$this->fields['Banyaknya'] = &$this->Banyaknya;

		// Harga
		$this->Harga = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_Harga', 'Harga', '`Harga`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Harga->Sortable = TRUE; // Allow sort
		$this->Harga->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Harga->DateFilter = "";
		$this->Harga->SqlSelect = "";
		$this->Harga->SqlOrderBy = "";
		$this->fields['Harga'] = &$this->Harga;

		// Jumlah
		$this->Jumlah = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_Jumlah', 'Jumlah', '`Jumlah`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Jumlah->Sortable = TRUE; // Allow sort
		$this->Jumlah->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Jumlah->DateFilter = "";
		$this->Jumlah->SqlSelect = "";
		$this->Jumlah->SqlOrderBy = "";
		$this->fields['Jumlah'] = &$this->Jumlah;

		// subgroup_id
		$this->subgroup_id = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_subgroup_id', 'subgroup_id', '`subgroup_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->subgroup_id->Sortable = TRUE; // Allow sort
		$this->subgroup_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->subgroup_id->DateFilter = "";
		$this->subgroup_id->SqlSelect = "";
		$this->subgroup_id->SqlOrderBy = "";
		$this->fields['subgroup_id'] = &$this->subgroup_id;

		// maingroup_id
		$this->maingroup_id = new crField('t06_pengeluaran', 't06_pengeluaran', 'x_maingroup_id', 'maingroup_id', '`maingroup_id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->maingroup_id->Sortable = TRUE; // Allow sort
		$this->maingroup_id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->maingroup_id->DateFilter = "";
		$this->maingroup_id->SqlSelect = "";
		$this->maingroup_id->SqlOrderBy = "";
		$this->fields['maingroup_id'] = &$this->maingroup_id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t06_pengeluaran`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`Jumlah`) AS `sum_jumlah` FROM " . $this->getSqlFrom();
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
