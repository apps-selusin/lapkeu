<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t06_pengeluaraninfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t06_pengeluaran_delete = NULL; // Initialize page object first

class ct06_pengeluaran_delete extends ct06_pengeluaran {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't06_pengeluaran';

	// Page object name
	var $PageObjName = 't06_pengeluaran_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t06_pengeluaran)
		if (!isset($GLOBALS["t06_pengeluaran"]) || get_class($GLOBALS["t06_pengeluaran"]) == "ct06_pengeluaran") {
			$GLOBALS["t06_pengeluaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t06_pengeluaran"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't06_pengeluaran', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct96_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t06_pengeluaranlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->id->Visible = FALSE;
		$this->supplier_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->NoNota->SetVisibility();
		$this->barang_id->SetVisibility();
		$this->Banyaknya->SetVisibility();
		$this->Harga->SetVisibility();
		$this->Jumlah->SetVisibility();
		$this->subgroup_id->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $t06_pengeluaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t06_pengeluaran);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t06_pengeluaranlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t06_pengeluaran class, t06_pengeluaraninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t06_pengeluaranlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->id->setDbValue($row['id']);
		$this->supplier_id->setDbValue($row['supplier_id']);
		$this->Tanggal->setDbValue($row['Tanggal']);
		$this->NoNota->setDbValue($row['NoNota']);
		$this->barang_id->setDbValue($row['barang_id']);
		$this->Banyaknya->setDbValue($row['Banyaknya']);
		$this->Harga->setDbValue($row['Harga']);
		$this->Jumlah->setDbValue($row['Jumlah']);
		$this->subgroup_id->setDbValue($row['subgroup_id']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['supplier_id'] = NULL;
		$row['Tanggal'] = NULL;
		$row['NoNota'] = NULL;
		$row['barang_id'] = NULL;
		$row['Banyaknya'] = NULL;
		$row['Harga'] = NULL;
		$row['Jumlah'] = NULL;
		$row['subgroup_id'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->supplier_id->DbValue = $row['supplier_id'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->NoNota->DbValue = $row['NoNota'];
		$this->barang_id->DbValue = $row['barang_id'];
		$this->Banyaknya->DbValue = $row['Banyaknya'];
		$this->Harga->DbValue = $row['Harga'];
		$this->Jumlah->DbValue = $row['Jumlah'];
		$this->subgroup_id->DbValue = $row['subgroup_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Banyaknya->FormValue == $this->Banyaknya->CurrentValue && is_numeric(ew_StrToFloat($this->Banyaknya->CurrentValue)))
			$this->Banyaknya->CurrentValue = ew_StrToFloat($this->Banyaknya->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Harga->FormValue == $this->Harga->CurrentValue && is_numeric(ew_StrToFloat($this->Harga->CurrentValue)))
			$this->Harga->CurrentValue = ew_StrToFloat($this->Harga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Jumlah->FormValue == $this->Jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->Jumlah->CurrentValue)))
			$this->Jumlah->CurrentValue = ew_StrToFloat($this->Jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// supplier_id
		// Tanggal
		// NoNota
		// barang_id
		// Banyaknya
		// Harga
		// Jumlah
		// subgroup_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// supplier_id
		$this->supplier_id->ViewValue = $this->supplier_id->CurrentValue;
		$this->supplier_id->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// NoNota
		$this->NoNota->ViewValue = $this->NoNota->CurrentValue;
		$this->NoNota->ViewCustomAttributes = "";

		// barang_id
		$this->barang_id->ViewValue = $this->barang_id->CurrentValue;
		$this->barang_id->ViewCustomAttributes = "";

		// Banyaknya
		$this->Banyaknya->ViewValue = $this->Banyaknya->CurrentValue;
		$this->Banyaknya->ViewCustomAttributes = "";

		// Harga
		$this->Harga->ViewValue = $this->Harga->CurrentValue;
		$this->Harga->ViewCustomAttributes = "";

		// Jumlah
		$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
		$this->Jumlah->ViewCustomAttributes = "";

		// subgroup_id
		$this->subgroup_id->ViewValue = $this->subgroup_id->CurrentValue;
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

			// subgroup_id
			$this->subgroup_id->LinkCustomAttributes = "";
			$this->subgroup_id->HrefValue = "";
			$this->subgroup_id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t06_pengeluaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t06_pengeluaran_delete)) $t06_pengeluaran_delete = new ct06_pengeluaran_delete();

// Page init
$t06_pengeluaran_delete->Page_Init();

// Page main
$t06_pengeluaran_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t06_pengeluaran_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft06_pengeluarandelete = new ew_Form("ft06_pengeluarandelete", "delete");

// Form_CustomValidate event
ft06_pengeluarandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft06_pengeluarandelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t06_pengeluaran_delete->ShowPageHeader(); ?>
<?php
$t06_pengeluaran_delete->ShowMessage();
?>
<form name="ft06_pengeluarandelete" id="ft06_pengeluarandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t06_pengeluaran_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t06_pengeluaran_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t06_pengeluaran">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t06_pengeluaran_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($t06_pengeluaran->id->Visible) { // id ?>
		<th class="<?php echo $t06_pengeluaran->id->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_id" class="t06_pengeluaran_id"><?php echo $t06_pengeluaran->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->supplier_id->Visible) { // supplier_id ?>
		<th class="<?php echo $t06_pengeluaran->supplier_id->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_supplier_id" class="t06_pengeluaran_supplier_id"><?php echo $t06_pengeluaran->supplier_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->Tanggal->Visible) { // Tanggal ?>
		<th class="<?php echo $t06_pengeluaran->Tanggal->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_Tanggal" class="t06_pengeluaran_Tanggal"><?php echo $t06_pengeluaran->Tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->NoNota->Visible) { // NoNota ?>
		<th class="<?php echo $t06_pengeluaran->NoNota->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_NoNota" class="t06_pengeluaran_NoNota"><?php echo $t06_pengeluaran->NoNota->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->barang_id->Visible) { // barang_id ?>
		<th class="<?php echo $t06_pengeluaran->barang_id->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_barang_id" class="t06_pengeluaran_barang_id"><?php echo $t06_pengeluaran->barang_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
		<th class="<?php echo $t06_pengeluaran->Banyaknya->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_Banyaknya" class="t06_pengeluaran_Banyaknya"><?php echo $t06_pengeluaran->Banyaknya->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->Harga->Visible) { // Harga ?>
		<th class="<?php echo $t06_pengeluaran->Harga->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_Harga" class="t06_pengeluaran_Harga"><?php echo $t06_pengeluaran->Harga->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->Jumlah->Visible) { // Jumlah ?>
		<th class="<?php echo $t06_pengeluaran->Jumlah->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_Jumlah" class="t06_pengeluaran_Jumlah"><?php echo $t06_pengeluaran->Jumlah->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t06_pengeluaran->subgroup_id->Visible) { // subgroup_id ?>
		<th class="<?php echo $t06_pengeluaran->subgroup_id->HeaderCellClass() ?>"><span id="elh_t06_pengeluaran_subgroup_id" class="t06_pengeluaran_subgroup_id"><?php echo $t06_pengeluaran->subgroup_id->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t06_pengeluaran_delete->RecCnt = 0;
$i = 0;
while (!$t06_pengeluaran_delete->Recordset->EOF) {
	$t06_pengeluaran_delete->RecCnt++;
	$t06_pengeluaran_delete->RowCnt++;

	// Set row properties
	$t06_pengeluaran->ResetAttrs();
	$t06_pengeluaran->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t06_pengeluaran_delete->LoadRowValues($t06_pengeluaran_delete->Recordset);

	// Render row
	$t06_pengeluaran_delete->RenderRow();
?>
	<tr<?php echo $t06_pengeluaran->RowAttributes() ?>>
<?php if ($t06_pengeluaran->id->Visible) { // id ?>
		<td<?php echo $t06_pengeluaran->id->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_id" class="t06_pengeluaran_id">
<span<?php echo $t06_pengeluaran->id->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->supplier_id->Visible) { // supplier_id ?>
		<td<?php echo $t06_pengeluaran->supplier_id->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_supplier_id" class="t06_pengeluaran_supplier_id">
<span<?php echo $t06_pengeluaran->supplier_id->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->supplier_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->Tanggal->Visible) { // Tanggal ?>
		<td<?php echo $t06_pengeluaran->Tanggal->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_Tanggal" class="t06_pengeluaran_Tanggal">
<span<?php echo $t06_pengeluaran->Tanggal->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->Tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->NoNota->Visible) { // NoNota ?>
		<td<?php echo $t06_pengeluaran->NoNota->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_NoNota" class="t06_pengeluaran_NoNota">
<span<?php echo $t06_pengeluaran->NoNota->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->NoNota->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->barang_id->Visible) { // barang_id ?>
		<td<?php echo $t06_pengeluaran->barang_id->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_barang_id" class="t06_pengeluaran_barang_id">
<span<?php echo $t06_pengeluaran->barang_id->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->barang_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
		<td<?php echo $t06_pengeluaran->Banyaknya->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_Banyaknya" class="t06_pengeluaran_Banyaknya">
<span<?php echo $t06_pengeluaran->Banyaknya->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->Banyaknya->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->Harga->Visible) { // Harga ?>
		<td<?php echo $t06_pengeluaran->Harga->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_Harga" class="t06_pengeluaran_Harga">
<span<?php echo $t06_pengeluaran->Harga->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->Harga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->Jumlah->Visible) { // Jumlah ?>
		<td<?php echo $t06_pengeluaran->Jumlah->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_Jumlah" class="t06_pengeluaran_Jumlah">
<span<?php echo $t06_pengeluaran->Jumlah->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->Jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t06_pengeluaran->subgroup_id->Visible) { // subgroup_id ?>
		<td<?php echo $t06_pengeluaran->subgroup_id->CellAttributes() ?>>
<span id="el<?php echo $t06_pengeluaran_delete->RowCnt ?>_t06_pengeluaran_subgroup_id" class="t06_pengeluaran_subgroup_id">
<span<?php echo $t06_pengeluaran->subgroup_id->ViewAttributes() ?>>
<?php echo $t06_pengeluaran->subgroup_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t06_pengeluaran_delete->Recordset->MoveNext();
}
$t06_pengeluaran_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t06_pengeluaran_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft06_pengeluarandelete.Init();
</script>
<?php
$t06_pengeluaran_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t06_pengeluaran_delete->Page_Terminate();
?>
