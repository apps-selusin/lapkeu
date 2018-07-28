<?php

// Global variable for table object
$t96_employees = NULL;

//
// Table class for t96_employees
//
class crt96_employees extends crTableBase {
	var $ShowGroupHeaderAsRow = FALSE;
	var $ShowCompactSummaryFooter = TRUE;
	var $EmployeeID;
	var $LastName;
	var $FirstName;
	var $Title;
	var $TitleOfCourtesy;
	var $BirthDate;
	var $HireDate;
	var $Address;
	var $City;
	var $Region;
	var $PostalCode;
	var $Country;
	var $HomePhone;
	var $Extension;
	var $_Email;
	var $Photo;
	var $Notes;
	var $ReportsTo;
	var $Password;
	var $UserLevel;
	var $Username;
	var $Activated;
	var $Profile;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $grLanguage;
		$this->TableVar = 't96_employees';
		$this->TableName = 't96_employees';
		$this->TableType = 'TABLE';
		$this->TableReportType = 'rpt';
		$this->SourcTableIsCustomView = FALSE;
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0;

		// EmployeeID
		$this->EmployeeID = new crField('t96_employees', 't96_employees', 'x_EmployeeID', 'EmployeeID', '`EmployeeID`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->EmployeeID->Sortable = TRUE; // Allow sort
		$this->EmployeeID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->EmployeeID->DateFilter = "";
		$this->EmployeeID->SqlSelect = "";
		$this->EmployeeID->SqlOrderBy = "";
		$this->fields['EmployeeID'] = &$this->EmployeeID;

		// LastName
		$this->LastName = new crField('t96_employees', 't96_employees', 'x_LastName', 'LastName', '`LastName`', 200, EWR_DATATYPE_STRING, -1);
		$this->LastName->Sortable = TRUE; // Allow sort
		$this->LastName->DateFilter = "";
		$this->LastName->SqlSelect = "";
		$this->LastName->SqlOrderBy = "";
		$this->fields['LastName'] = &$this->LastName;

		// FirstName
		$this->FirstName = new crField('t96_employees', 't96_employees', 'x_FirstName', 'FirstName', '`FirstName`', 200, EWR_DATATYPE_STRING, -1);
		$this->FirstName->Sortable = TRUE; // Allow sort
		$this->FirstName->DateFilter = "";
		$this->FirstName->SqlSelect = "";
		$this->FirstName->SqlOrderBy = "";
		$this->fields['FirstName'] = &$this->FirstName;

		// Title
		$this->Title = new crField('t96_employees', 't96_employees', 'x_Title', 'Title', '`Title`', 200, EWR_DATATYPE_STRING, -1);
		$this->Title->Sortable = TRUE; // Allow sort
		$this->Title->DateFilter = "";
		$this->Title->SqlSelect = "";
		$this->Title->SqlOrderBy = "";
		$this->fields['Title'] = &$this->Title;

		// TitleOfCourtesy
		$this->TitleOfCourtesy = new crField('t96_employees', 't96_employees', 'x_TitleOfCourtesy', 'TitleOfCourtesy', '`TitleOfCourtesy`', 200, EWR_DATATYPE_STRING, -1);
		$this->TitleOfCourtesy->Sortable = TRUE; // Allow sort
		$this->TitleOfCourtesy->DateFilter = "";
		$this->TitleOfCourtesy->SqlSelect = "";
		$this->TitleOfCourtesy->SqlOrderBy = "";
		$this->fields['TitleOfCourtesy'] = &$this->TitleOfCourtesy;

		// BirthDate
		$this->BirthDate = new crField('t96_employees', 't96_employees', 'x_BirthDate', 'BirthDate', '`BirthDate`', 135, EWR_DATATYPE_DATE, 0);
		$this->BirthDate->Sortable = TRUE; // Allow sort
		$this->BirthDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->BirthDate->DateFilter = "";
		$this->BirthDate->SqlSelect = "";
		$this->BirthDate->SqlOrderBy = "";
		$this->fields['BirthDate'] = &$this->BirthDate;

		// HireDate
		$this->HireDate = new crField('t96_employees', 't96_employees', 'x_HireDate', 'HireDate', '`HireDate`', 135, EWR_DATATYPE_DATE, 0);
		$this->HireDate->Sortable = TRUE; // Allow sort
		$this->HireDate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EWR_DATE_FORMAT"], $ReportLanguage->Phrase("IncorrectDate"));
		$this->HireDate->DateFilter = "";
		$this->HireDate->SqlSelect = "";
		$this->HireDate->SqlOrderBy = "";
		$this->fields['HireDate'] = &$this->HireDate;

		// Address
		$this->Address = new crField('t96_employees', 't96_employees', 'x_Address', 'Address', '`Address`', 200, EWR_DATATYPE_STRING, -1);
		$this->Address->Sortable = TRUE; // Allow sort
		$this->Address->DateFilter = "";
		$this->Address->SqlSelect = "";
		$this->Address->SqlOrderBy = "";
		$this->fields['Address'] = &$this->Address;

		// City
		$this->City = new crField('t96_employees', 't96_employees', 'x_City', 'City', '`City`', 200, EWR_DATATYPE_STRING, -1);
		$this->City->Sortable = TRUE; // Allow sort
		$this->City->DateFilter = "";
		$this->City->SqlSelect = "";
		$this->City->SqlOrderBy = "";
		$this->fields['City'] = &$this->City;

		// Region
		$this->Region = new crField('t96_employees', 't96_employees', 'x_Region', 'Region', '`Region`', 200, EWR_DATATYPE_STRING, -1);
		$this->Region->Sortable = TRUE; // Allow sort
		$this->Region->DateFilter = "";
		$this->Region->SqlSelect = "";
		$this->Region->SqlOrderBy = "";
		$this->fields['Region'] = &$this->Region;

		// PostalCode
		$this->PostalCode = new crField('t96_employees', 't96_employees', 'x_PostalCode', 'PostalCode', '`PostalCode`', 200, EWR_DATATYPE_STRING, -1);
		$this->PostalCode->Sortable = TRUE; // Allow sort
		$this->PostalCode->DateFilter = "";
		$this->PostalCode->SqlSelect = "";
		$this->PostalCode->SqlOrderBy = "";
		$this->fields['PostalCode'] = &$this->PostalCode;

		// Country
		$this->Country = new crField('t96_employees', 't96_employees', 'x_Country', 'Country', '`Country`', 200, EWR_DATATYPE_STRING, -1);
		$this->Country->Sortable = TRUE; // Allow sort
		$this->Country->DateFilter = "";
		$this->Country->SqlSelect = "";
		$this->Country->SqlOrderBy = "";
		$this->fields['Country'] = &$this->Country;

		// HomePhone
		$this->HomePhone = new crField('t96_employees', 't96_employees', 'x_HomePhone', 'HomePhone', '`HomePhone`', 200, EWR_DATATYPE_STRING, -1);
		$this->HomePhone->Sortable = TRUE; // Allow sort
		$this->HomePhone->DateFilter = "";
		$this->HomePhone->SqlSelect = "";
		$this->HomePhone->SqlOrderBy = "";
		$this->fields['HomePhone'] = &$this->HomePhone;

		// Extension
		$this->Extension = new crField('t96_employees', 't96_employees', 'x_Extension', 'Extension', '`Extension`', 200, EWR_DATATYPE_STRING, -1);
		$this->Extension->Sortable = TRUE; // Allow sort
		$this->Extension->DateFilter = "";
		$this->Extension->SqlSelect = "";
		$this->Extension->SqlOrderBy = "";
		$this->fields['Extension'] = &$this->Extension;

		// Email
		$this->_Email = new crField('t96_employees', 't96_employees', 'x__Email', 'Email', '`Email`', 200, EWR_DATATYPE_STRING, -1);
		$this->_Email->Sortable = TRUE; // Allow sort
		$this->_Email->DateFilter = "";
		$this->_Email->SqlSelect = "";
		$this->_Email->SqlOrderBy = "";
		$this->fields['Email'] = &$this->_Email;

		// Photo
		$this->Photo = new crField('t96_employees', 't96_employees', 'x_Photo', 'Photo', '`Photo`', 200, EWR_DATATYPE_STRING, -1);
		$this->Photo->Sortable = TRUE; // Allow sort
		$this->Photo->DateFilter = "";
		$this->Photo->SqlSelect = "";
		$this->Photo->SqlOrderBy = "";
		$this->fields['Photo'] = &$this->Photo;

		// Notes
		$this->Notes = new crField('t96_employees', 't96_employees', 'x_Notes', 'Notes', '`Notes`', 201, EWR_DATATYPE_MEMO, -1);
		$this->Notes->Sortable = TRUE; // Allow sort
		$this->Notes->DateFilter = "";
		$this->Notes->SqlSelect = "";
		$this->Notes->SqlOrderBy = "";
		$this->fields['Notes'] = &$this->Notes;

		// ReportsTo
		$this->ReportsTo = new crField('t96_employees', 't96_employees', 'x_ReportsTo', 'ReportsTo', '`ReportsTo`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ReportsTo->Sortable = TRUE; // Allow sort
		$this->ReportsTo->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->ReportsTo->DateFilter = "";
		$this->ReportsTo->SqlSelect = "";
		$this->ReportsTo->SqlOrderBy = "";
		$this->fields['ReportsTo'] = &$this->ReportsTo;

		// Password
		$this->Password = new crField('t96_employees', 't96_employees', 'x_Password', 'Password', '`Password`', 200, EWR_DATATYPE_STRING, -1);
		$this->Password->Sortable = TRUE; // Allow sort
		$this->Password->DateFilter = "";
		$this->Password->SqlSelect = "";
		$this->Password->SqlOrderBy = "";
		$this->fields['Password'] = &$this->Password;

		// UserLevel
		$this->UserLevel = new crField('t96_employees', 't96_employees', 'x_UserLevel', 'UserLevel', '`UserLevel`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->UserLevel->Sortable = TRUE; // Allow sort
		$this->UserLevel->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->UserLevel->DateFilter = "";
		$this->UserLevel->SqlSelect = "";
		$this->UserLevel->SqlOrderBy = "";
		$this->fields['UserLevel'] = &$this->UserLevel;

		// Username
		$this->Username = new crField('t96_employees', 't96_employees', 'x_Username', 'Username', '`Username`', 200, EWR_DATATYPE_STRING, -1);
		$this->Username->Sortable = TRUE; // Allow sort
		$this->Username->DateFilter = "";
		$this->Username->SqlSelect = "";
		$this->Username->SqlOrderBy = "";
		$this->fields['Username'] = &$this->Username;

		// Activated
		$this->Activated = new crField('t96_employees', 't96_employees', 'x_Activated', 'Activated', '`Activated`', 202, EWR_DATATYPE_STRING, -1);
		$this->Activated->Sortable = TRUE; // Allow sort
		$this->Activated->DateFilter = "";
		$this->Activated->SqlSelect = "";
		$this->Activated->SqlOrderBy = "";
		$this->fields['Activated'] = &$this->Activated;

		// Profile
		$this->Profile = new crField('t96_employees', 't96_employees', 'x_Profile', 'Profile', '`Profile`', 201, EWR_DATATYPE_MEMO, -1);
		$this->Profile->Sortable = TRUE; // Allow sort
		$this->Profile->DateFilter = "";
		$this->Profile->SqlSelect = "";
		$this->Profile->SqlOrderBy = "";
		$this->fields['Profile'] = &$this->Profile;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t96_employees`";
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
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
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

	// User ID filter
	function GetUserIDFilter() {
		global $Security;
		$sUserID = $Security->CurrentUserID();
		$sUserIDFilter = "";
		if (!$Security->IsAdmin()) {
			$sUserIDFilter = $Security->UserIDList();
			if ($sUserIDFilter <> "")
				$sUserIDFilter = '`EmployeeID` IN (' . $sUserIDFilter . ')';
			if ($sUserIDFilter == "")
				$sUserIDFilter = "0=1";
		}

		// Call Row Rendered event
		$this->UserID_Filtering($sUserIDFilter);
		return $sUserIDFilter;
	}

	// Function to get the child user id list for this user
	function ChildUserIDList($sUserID) {
		$conn = &$this->Connection();

		// Get all values
		if ($sUserID == "-1") {
			$sSql = "SELECT `EmployeeID` FROM `t96_employees`";
		} else {
			$sSql = "SELECT `EmployeeID` FROM `t96_employees` WHERE `EmployeeID` = " . ewr_QuotedValue($sUserID, EWR_DATATYPE_NUMBER, $this->DBID);
		}
		$rs = $conn->Execute($sSql);
		$arUser = array();
		if ($rs) {
			while (!$rs->EOF) {
				$arUser[] = $rs->fields('EmployeeID');
				$rs->MoveNext();
			}
			$rs->Close();
		}
		sort($arUser);
		return $arUser;
	}

	function UserIDList($ar) {
		$sWrk = "";
		if (is_array($ar)) {
			$cntar = count($ar);
			for ($i = 0; $i < $cntar; $i++) {
				if ($sWrk <> "")
					$sWrk .= ", ";
				$sWrk .= ewr_QuotedValue($ar[$i], EWR_DATATYPE_NUMBER, $this->DBID);
			}
		}
		return $sWrk;
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
