<?php

// Global variable for table object
$t06_pengeluaran = NULL;

//
// Table class for t06_pengeluaran
//
class ct06_pengeluaran extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $supplier_id;
	var $Tanggal;
	var $NoNota;
	var $barang_id;
	var $Banyaknya;
	var $Harga;
	var $Jumlah;
	var $maingroup_id;
	var $subgroup_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't06_pengeluaran';
		$this->TableName = 't06_pengeluaran';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t06_pengeluaran`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// supplier_id
		$this->supplier_id = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_supplier_id', 'supplier_id', '`supplier_id`', '`supplier_id`', 3, -1, FALSE, '`EV__supplier_id`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->supplier_id->Sortable = TRUE; // Allow sort
		$this->supplier_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->supplier_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->supplier_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['supplier_id'] = &$this->supplier_id;

		// Tanggal
		$this->Tanggal = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_Tanggal', 'Tanggal', '`Tanggal`', ew_CastDateFieldForLike('`Tanggal`', 7, "DB"), 133, 7, FALSE, '`Tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tanggal->Sortable = TRUE; // Allow sort
		$this->Tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Tanggal'] = &$this->Tanggal;

		// NoNota
		$this->NoNota = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_NoNota', 'NoNota', '`NoNota`', '`NoNota`', 200, -1, FALSE, '`NoNota`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NoNota->Sortable = TRUE; // Allow sort
		$this->fields['NoNota'] = &$this->NoNota;

		// barang_id
		$this->barang_id = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_barang_id', 'barang_id', '`barang_id`', '`barang_id`', 3, -1, FALSE, '`EV__barang_id`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->barang_id->Sortable = TRUE; // Allow sort
		$this->barang_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->barang_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->barang_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['barang_id'] = &$this->barang_id;

		// Banyaknya
		$this->Banyaknya = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_Banyaknya', 'Banyaknya', '`Banyaknya`', '`Banyaknya`', 4, -1, FALSE, '`Banyaknya`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Banyaknya->Sortable = TRUE; // Allow sort
		$this->Banyaknya->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Banyaknya'] = &$this->Banyaknya;

		// Harga
		$this->Harga = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_Harga', 'Harga', '`Harga`', '`Harga`', 4, -1, FALSE, '`Harga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Harga->Sortable = TRUE; // Allow sort
		$this->Harga->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Harga'] = &$this->Harga;

		// Jumlah
		$this->Jumlah = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_Jumlah', 'Jumlah', '`Jumlah`', '`Jumlah`', 4, -1, FALSE, '`Jumlah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Jumlah->Sortable = TRUE; // Allow sort
		$this->Jumlah->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Jumlah'] = &$this->Jumlah;

		// maingroup_id
		$this->maingroup_id = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_maingroup_id', 'maingroup_id', '`maingroup_id`', '`maingroup_id`', 3, -1, FALSE, '`EV__maingroup_id`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->maingroup_id->Sortable = TRUE; // Allow sort
		$this->maingroup_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->maingroup_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->maingroup_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['maingroup_id'] = &$this->maingroup_id;

		// subgroup_id
		$this->subgroup_id = new cField('t06_pengeluaran', 't06_pengeluaran', 'x_subgroup_id', 'subgroup_id', '`subgroup_id`', '`subgroup_id`', 3, -1, FALSE, '`EV__subgroup_id`', TRUE, TRUE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->subgroup_id->Sortable = TRUE; // Allow sort
		$this->subgroup_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->subgroup_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->subgroup_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['subgroup_id'] = &$this->subgroup_id;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
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
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t06_pengeluaran`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT CONCAT(COALESCE(`Nama`, ''),'" . ew_ValueSeparator(1, $this->supplier_id) . "',COALESCE(`Alamat`,''),'" . ew_ValueSeparator(2, $this->supplier_id) . "',COALESCE(`NoTelpHp`,'')) FROM `t01_supplier` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`id` = `t06_pengeluaran`.`supplier_id` LIMIT 1) AS `EV__supplier_id`, (SELECT CONCAT(COALESCE(`Nama`, ''),'" . ew_ValueSeparator(1, $this->barang_id) . "',COALESCE(`Satuan`,'')) FROM `v01_barang_satuan` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`id` = `t06_pengeluaran`.`barang_id` LIMIT 1) AS `EV__barang_id`, (SELECT `Nama` FROM `t04_maingroup` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`id` = `t06_pengeluaran`.`maingroup_id` LIMIT 1) AS `EV__maingroup_id`, (SELECT `Nama` FROM `t05_subgroup` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`id` = `t06_pengeluaran`.`subgroup_id` LIMIT 1) AS `EV__subgroup_id` FROM `t06_pengeluaran`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		if ($this->UseVirtualFields()) {
			$sSelect = $this->getSqlSelectList();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		} else {
			$sSelect = $this->getSqlSelect();
			$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		}
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->UseSessionForListSQL ? $this->getSessionWhere() : $this->CurrentFilter;
		$sOrderBy = $this->UseSessionForListSQL ? $this->getSessionOrderByList() : "";
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if (strpos($sOrderBy, " " . $this->supplier_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->barang_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->maingroup_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->subgroup_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		if ($this->UseVirtualFields())
			$sql = ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		else
			$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t06_pengeluaranlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "t06_pengeluaranview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "t06_pengeluaranedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "t06_pengeluaranadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "t06_pengeluaranlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t06_pengeluaranview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t06_pengeluaranview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t06_pengeluaranadd.php?" . $this->UrlParm($parm);
		else
			$url = "t06_pengeluaranadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t06_pengeluaranedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t06_pengeluaranadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t06_pengeluarandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = $_POST["id"];
			elseif (isset($_GET["id"]))
				$arKeys[] = $_GET["id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->supplier_id->setDbValue($rs->fields('supplier_id'));
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->NoNota->setDbValue($rs->fields('NoNota'));
		$this->barang_id->setDbValue($rs->fields('barang_id'));
		$this->Banyaknya->setDbValue($rs->fields('Banyaknya'));
		$this->Harga->setDbValue($rs->fields('Harga'));
		$this->Jumlah->setDbValue($rs->fields('Jumlah'));
		$this->maingroup_id->setDbValue($rs->fields('maingroup_id'));
		$this->subgroup_id->setDbValue($rs->fields('subgroup_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// id
		// supplier_id
		// Tanggal
		// NoNota
		// barang_id
		// Banyaknya
		// Harga
		// Jumlah
		// maingroup_id
		// subgroup_id
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// supplier_id
		if ($this->supplier_id->VirtualValue <> "") {
			$this->supplier_id->ViewValue = $this->supplier_id->VirtualValue;
		} else {
		if (strval($this->supplier_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->supplier_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, `Alamat` AS `Disp2Fld`, `NoTelpHp` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_supplier`";
		$sWhereWrk = "";
		$this->supplier_id->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Alamat`', "dx3" => '`NoTelpHp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->supplier_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nama` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->supplier_id->ViewValue = $this->supplier_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->supplier_id->ViewValue = $this->supplier_id->CurrentValue;
			}
		} else {
			$this->supplier_id->ViewValue = NULL;
		}
		}
		$this->supplier_id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 7);
		$this->Tanggal->ViewCustomAttributes = "";

		// NoNota
		$this->NoNota->ViewValue = $this->NoNota->CurrentValue;
		$this->NoNota->ViewCustomAttributes = "";

		// barang_id
		if ($this->barang_id->VirtualValue <> "") {
			$this->barang_id->ViewValue = $this->barang_id->VirtualValue;
		} else {
		if (strval($this->barang_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->barang_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, `Satuan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `v01_barang_satuan`";
		$sWhereWrk = "";
		$this->barang_id->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Satuan`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Nama` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->barang_id->ViewValue = $this->barang_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->barang_id->ViewValue = $this->barang_id->CurrentValue;
			}
		} else {
			$this->barang_id->ViewValue = NULL;
		}
		}
		$this->barang_id->ViewCustomAttributes = "";

		// Banyaknya
		$this->Banyaknya->ViewValue = $this->Banyaknya->CurrentValue;
		$this->Banyaknya->ViewValue = ew_FormatNumber($this->Banyaknya->ViewValue, 2, -2, -2, -2);
		$this->Banyaknya->CellCssStyle .= "text-align: right;";
		$this->Banyaknya->ViewCustomAttributes = "";

		// Harga
		$this->Harga->ViewValue = $this->Harga->CurrentValue;
		$this->Harga->ViewValue = ew_FormatNumber($this->Harga->ViewValue, 2, -2, -2, -2);
		$this->Harga->CellCssStyle .= "text-align: right;";
		$this->Harga->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewValue = ew_FormatNumber($this->Jumlah->ViewValue, 2, -2, -2, -2);
		$this->Jumlah->CellCssStyle .= "text-align: right;";
		$this->Jumlah->ViewCustomAttributes = "";

		// maingroup_id
		if ($this->maingroup_id->VirtualValue <> "") {
			$this->maingroup_id->ViewValue = $this->maingroup_id->VirtualValue;
		} else {
		if (strval($this->maingroup_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->maingroup_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t04_maingroup`";
		$sWhereWrk = "";
		$this->maingroup_id->LookupFilters = array("dx1" => '`Nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->maingroup_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->maingroup_id->ViewValue = $this->maingroup_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->maingroup_id->ViewValue = $this->maingroup_id->CurrentValue;
			}
		} else {
			$this->maingroup_id->ViewValue = NULL;
		}
		}
		$this->maingroup_id->ViewCustomAttributes = "";

		// subgroup_id
		if ($this->subgroup_id->VirtualValue <> "") {
			$this->subgroup_id->ViewValue = $this->subgroup_id->VirtualValue;
		} else {
		if (strval($this->subgroup_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->subgroup_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t05_subgroup`";
		$sWhereWrk = "";
		$this->subgroup_id->LookupFilters = array("dx1" => '`Nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->subgroup_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->subgroup_id->ViewValue = $this->subgroup_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->subgroup_id->ViewValue = $this->subgroup_id->CurrentValue;
			}
		} else {
			$this->subgroup_id->ViewValue = NULL;
		}
		}
		$this->subgroup_id->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// supplier_id
		$this->supplier_id->LinkCustomAttributes = "";
		$this->supplier_id->HrefValue = "";
		$this->supplier_id->TooltipValue = "";

		// Tanggal
		$this->Tanggal->LinkCustomAttributes = "";
		$this->Tanggal->HrefValue = "";
		$this->Tanggal->TooltipValue = "";

		// NoNota
		$this->NoNota->LinkCustomAttributes = "";
		$this->NoNota->HrefValue = "";
		$this->NoNota->TooltipValue = "";

		// barang_id
		$this->barang_id->LinkCustomAttributes = "";
		$this->barang_id->HrefValue = "";
		$this->barang_id->TooltipValue = "";

		// Banyaknya
		$this->Banyaknya->LinkCustomAttributes = "";
		$this->Banyaknya->HrefValue = "";
		$this->Banyaknya->TooltipValue = "";

		// Harga
		$this->Harga->LinkCustomAttributes = "";
		$this->Harga->HrefValue = "";
		$this->Harga->TooltipValue = "";

		// Jumlah
		$this->Jumlah->LinkCustomAttributes = "";
		$this->Jumlah->HrefValue = "";
		$this->Jumlah->TooltipValue = "";

		// maingroup_id
		$this->maingroup_id->LinkCustomAttributes = "";
		$this->maingroup_id->HrefValue = "";
		$this->maingroup_id->TooltipValue = "";

		// subgroup_id
		$this->subgroup_id->LinkCustomAttributes = "";
		$this->subgroup_id->HrefValue = "";
		$this->subgroup_id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// supplier_id
		$this->supplier_id->EditAttrs["class"] = "form-control";
		$this->supplier_id->EditCustomAttributes = "";

		// Tanggal
		$this->Tanggal->EditAttrs["class"] = "form-control";
		$this->Tanggal->EditCustomAttributes = "";
		$this->Tanggal->EditValue = ew_FormatDateTime($this->Tanggal->CurrentValue, 7);
		$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

		// NoNota
		$this->NoNota->EditAttrs["class"] = "form-control";
		$this->NoNota->EditCustomAttributes = "";
		$this->NoNota->EditValue = $this->NoNota->CurrentValue;
		$this->NoNota->PlaceHolder = ew_RemoveHtml($this->NoNota->FldCaption());

		// barang_id
		$this->barang_id->EditAttrs["class"] = "form-control";
		$this->barang_id->EditCustomAttributes = "";

		// Banyaknya
		$this->Banyaknya->EditAttrs["class"] = "form-control";
		$this->Banyaknya->EditCustomAttributes = "";
		$this->Banyaknya->EditValue = $this->Banyaknya->CurrentValue;
		$this->Banyaknya->PlaceHolder = ew_RemoveHtml($this->Banyaknya->FldCaption());
		if (strval($this->Banyaknya->EditValue) <> "" && is_numeric($this->Banyaknya->EditValue)) $this->Banyaknya->EditValue = ew_FormatNumber($this->Banyaknya->EditValue, -2, -2, -2, -2);

		// Harga
		$this->Harga->EditAttrs["class"] = "form-control";
		$this->Harga->EditCustomAttributes = "";
		$this->Harga->EditValue = $this->Harga->CurrentValue;
		$this->Harga->PlaceHolder = ew_RemoveHtml($this->Harga->FldCaption());
		if (strval($this->Harga->EditValue) <> "" && is_numeric($this->Harga->EditValue)) $this->Harga->EditValue = ew_FormatNumber($this->Harga->EditValue, -2, -2, -2, -2);

		// Jumlah
		$this->Jumlah->EditAttrs["class"] = "form-control";
		$this->Jumlah->EditCustomAttributes = "";
		$this->Jumlah->EditValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
		if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -2, -2, -2);

		// maingroup_id
		$this->maingroup_id->EditAttrs["class"] = "form-control";
		$this->maingroup_id->EditCustomAttributes = "";

		// subgroup_id
		$this->subgroup_id->EditAttrs["class"] = "form-control";
		$this->subgroup_id->EditCustomAttributes = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->supplier_id->Exportable) $Doc->ExportCaption($this->supplier_id);
					if ($this->Tanggal->Exportable) $Doc->ExportCaption($this->Tanggal);
					if ($this->NoNota->Exportable) $Doc->ExportCaption($this->NoNota);
					if ($this->barang_id->Exportable) $Doc->ExportCaption($this->barang_id);
					if ($this->Banyaknya->Exportable) $Doc->ExportCaption($this->Banyaknya);
					if ($this->Harga->Exportable) $Doc->ExportCaption($this->Harga);
					if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
					if ($this->maingroup_id->Exportable) $Doc->ExportCaption($this->maingroup_id);
					if ($this->subgroup_id->Exportable) $Doc->ExportCaption($this->subgroup_id);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->supplier_id->Exportable) $Doc->ExportCaption($this->supplier_id);
					if ($this->Tanggal->Exportable) $Doc->ExportCaption($this->Tanggal);
					if ($this->NoNota->Exportable) $Doc->ExportCaption($this->NoNota);
					if ($this->barang_id->Exportable) $Doc->ExportCaption($this->barang_id);
					if ($this->Banyaknya->Exportable) $Doc->ExportCaption($this->Banyaknya);
					if ($this->Harga->Exportable) $Doc->ExportCaption($this->Harga);
					if ($this->Jumlah->Exportable) $Doc->ExportCaption($this->Jumlah);
					if ($this->maingroup_id->Exportable) $Doc->ExportCaption($this->maingroup_id);
					if ($this->subgroup_id->Exportable) $Doc->ExportCaption($this->subgroup_id);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->supplier_id->Exportable) $Doc->ExportField($this->supplier_id);
						if ($this->Tanggal->Exportable) $Doc->ExportField($this->Tanggal);
						if ($this->NoNota->Exportable) $Doc->ExportField($this->NoNota);
						if ($this->barang_id->Exportable) $Doc->ExportField($this->barang_id);
						if ($this->Banyaknya->Exportable) $Doc->ExportField($this->Banyaknya);
						if ($this->Harga->Exportable) $Doc->ExportField($this->Harga);
						if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
						if ($this->maingroup_id->Exportable) $Doc->ExportField($this->maingroup_id);
						if ($this->subgroup_id->Exportable) $Doc->ExportField($this->subgroup_id);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->supplier_id->Exportable) $Doc->ExportField($this->supplier_id);
						if ($this->Tanggal->Exportable) $Doc->ExportField($this->Tanggal);
						if ($this->NoNota->Exportable) $Doc->ExportField($this->NoNota);
						if ($this->barang_id->Exportable) $Doc->ExportField($this->barang_id);
						if ($this->Banyaknya->Exportable) $Doc->ExportField($this->Banyaknya);
						if ($this->Harga->Exportable) $Doc->ExportField($this->Harga);
						if ($this->Jumlah->Exportable) $Doc->ExportField($this->Jumlah);
						if ($this->maingroup_id->Exportable) $Doc->ExportField($this->maingroup_id);
						if ($this->subgroup_id->Exportable) $Doc->ExportField($this->subgroup_id);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't06_pengeluaran';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't06_pengeluaran';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't06_pengeluaran';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't06_pengeluaran';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		if (CheckDateBetween($rsnew["Tanggal"]) == FALSE) {
			$this->setFailureMessage("Periode tanggal yang diinput salah, mohon periksa ulang !");
			return FALSE;
		}
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		if (CheckDateBetween($rsnew["Tanggal"]) == FALSE) {
			$this->setFailureMessage("Periode tanggal yang diinput salah, mohon periksa ulang !");
			return FALSE;
		}
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

		$this->Jumlah->ReadOnly = true;
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
