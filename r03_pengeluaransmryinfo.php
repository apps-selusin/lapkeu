<?php

// Global variable for table object
$r03_pengeluaran = NULL;

//
// Table class for r03_pengeluaran
//
class crr03_pengeluaran extends crTableBase {
	var $ShowGroupHeaderAsRow = TRUE;
	var $ShowCompactSummaryFooter = TRUE;
	var $tanggal;
	var $maingroup_nama;
	var $subgroup_nama;
	var $supplier_nama;
	var $nonota;
	var $barang_nama;
	var $banyaknya;
	var $barang_satuan;
	var $harga;
	var $Jumlah;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 'r03_pengeluaran';
		$this->TableName = 'r03_pengeluaran';
		$this->TableType = 'REPORT';
		$this->TableReportType = 'summary';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)

		// tanggal
		$this->tanggal = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_tanggal', 'tanggal', '`tanggal`', 133, EWR_DATATYPE_DATE, 7);
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_SEPARATOR"], $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->tanggal->DateFilter = "";
		$this->tanggal->SqlSelect = "";
		$this->tanggal->SqlOrderBy = "";
		ewr_RegisterFilter($this->tanggal, "@@Past", $ReportLanguage->Phrase("Past"), "ewr_IsPast");
		ewr_RegisterFilter($this->tanggal, "@@Future", $ReportLanguage->Phrase("Future"), "ewr_IsFuture");
		$this->fields['tanggal'] = &$this->tanggal;

		// maingroup_nama
		$this->maingroup_nama = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_maingroup_nama', 'maingroup_nama', '`maingroup_nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->maingroup_nama->Sortable = TRUE; // Allow sort
		$this->maingroup_nama->GroupingFieldId = 1;
		$this->maingroup_nama->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->maingroup_nama->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->maingroup_nama->DateFilter = "";
		$this->maingroup_nama->SqlSelect = "";
		$this->maingroup_nama->SqlOrderBy = "";
		$this->maingroup_nama->FldGroupByType = "";
		$this->maingroup_nama->FldGroupInt = "0";
		$this->maingroup_nama->FldGroupSql = "";
		$this->fields['maingroup_nama'] = &$this->maingroup_nama;

		// subgroup_nama
		$this->subgroup_nama = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_subgroup_nama', 'subgroup_nama', '`subgroup_nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->subgroup_nama->Sortable = TRUE; // Allow sort
		$this->subgroup_nama->GroupingFieldId = 2;
		$this->subgroup_nama->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->subgroup_nama->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->subgroup_nama->DateFilter = "";
		$this->subgroup_nama->SqlSelect = "";
		$this->subgroup_nama->SqlOrderBy = "";
		$this->subgroup_nama->FldGroupByType = "";
		$this->subgroup_nama->FldGroupInt = "0";
		$this->subgroup_nama->FldGroupSql = "";
		$this->fields['subgroup_nama'] = &$this->subgroup_nama;

		// supplier_nama
		$this->supplier_nama = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_supplier_nama', 'supplier_nama', '`supplier_nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->supplier_nama->Sortable = TRUE; // Allow sort
		$this->supplier_nama->DateFilter = "";
		$this->supplier_nama->SqlSelect = "";
		$this->supplier_nama->SqlOrderBy = "";
		$this->fields['supplier_nama'] = &$this->supplier_nama;

		// nonota
		$this->nonota = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_nonota', 'nonota', '`nonota`', 200, EWR_DATATYPE_STRING, -1);
		$this->nonota->Sortable = TRUE; // Allow sort
		$this->nonota->DateFilter = "";
		$this->nonota->SqlSelect = "";
		$this->nonota->SqlOrderBy = "";
		$this->fields['nonota'] = &$this->nonota;

		// barang_nama
		$this->barang_nama = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_barang_nama', 'barang_nama', '`barang_nama`', 200, EWR_DATATYPE_STRING, -1);
		$this->barang_nama->Sortable = TRUE; // Allow sort
		$this->barang_nama->DateFilter = "";
		$this->barang_nama->SqlSelect = "";
		$this->barang_nama->SqlOrderBy = "";
		$this->fields['barang_nama'] = &$this->barang_nama;

		// banyaknya
		$this->banyaknya = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_banyaknya', 'banyaknya', '`banyaknya`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->banyaknya->Sortable = TRUE; // Allow sort
		$this->banyaknya->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->banyaknya->DateFilter = "";
		$this->banyaknya->SqlSelect = "";
		$this->banyaknya->SqlOrderBy = "";
		$this->fields['banyaknya'] = &$this->banyaknya;

		// barang_satuan
		$this->barang_satuan = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_barang_satuan', 'barang_satuan', '`barang_satuan`', 200, EWR_DATATYPE_STRING, -1);
		$this->barang_satuan->Sortable = TRUE; // Allow sort
		$this->barang_satuan->DateFilter = "";
		$this->barang_satuan->SqlSelect = "";
		$this->barang_satuan->SqlOrderBy = "";
		$this->fields['barang_satuan'] = &$this->barang_satuan;

		// harga
		$this->harga = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_harga', 'harga', '`harga`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->harga->Sortable = TRUE; // Allow sort
		$this->harga->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->harga->DateFilter = "";
		$this->harga->SqlSelect = "";
		$this->harga->SqlOrderBy = "";
		$this->fields['harga'] = &$this->harga;

		// Jumlah
		$this->Jumlah = new crField('r03_pengeluaran', 'r03_pengeluaran', 'x_Jumlah', 'Jumlah', '`Jumlah`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Jumlah->Sortable = TRUE; // Allow sort
		$this->Jumlah->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->Jumlah->DateFilter = "";
		$this->Jumlah->SqlSelect = "";
		$this->Jumlah->SqlOrderBy = "";
		$this->fields['Jumlah'] = &$this->Jumlah;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v03_pengeluaran`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`maingroup_nama` ASC, `subgroup_nama` ASC";
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
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`maingroup_nama`";
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
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`maingroup_nama` ASC";
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
		case "x_maingroup_nama":
			$fld->LookupFilters = array("d" => "DB", "f0" => '`maingroup_nama` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter), "af" => json_encode($fld->AdvancedFilters));
		$sWhereWrk = "";
		$fld->LookupFilters += array(
			"select" => "SELECT DISTINCT `maingroup_nama`, `maingroup_nama` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_pengeluaran`",
			"where" => $sWhereWrk,
			"orderby" => "`maingroup_nama` ASC"
		);
		$this->Lookup_Selecting($fld, $fld->LookupFilters["where"]); // Call Lookup selecting
		$fld->LookupFilters["s"] = ewr_BuildReportSql($fld->LookupFilters["select"], $fld->LookupFilters["where"], "", "", $fld->LookupFilters["orderby"], "", "");
			break;
		case "x_subgroup_nama":
			$fld->LookupFilters = array("d" => "DB", "f0" => '`subgroup_nama` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter), "f1" => '`maingroup_nama` = {filter_value}', "t1" => "200", "fn1" => "", "af" => json_encode($fld->AdvancedFilters));
		$sWhereWrk = "{filter}";
		$fld->LookupFilters += array(
			"select" => "SELECT DISTINCT `subgroup_nama`, `subgroup_nama` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `v03_pengeluaran`",
			"where" => $sWhereWrk,
			"orderby" => "`subgroup_nama` ASC"
		);
		$this->Lookup_Selecting($fld, $fld->LookupFilters["where"]); // Call Lookup selecting
		$fld->LookupFilters["s"] = ewr_BuildReportSql($fld->LookupFilters["select"], $fld->LookupFilters["where"], "", "", $fld->LookupFilters["orderby"], "", "");
			break;
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
