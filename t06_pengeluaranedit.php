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

$t06_pengeluaran_edit = NULL; // Initialize page object first

class ct06_pengeluaran_edit extends ct06_pengeluaran {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't06_pengeluaran';

	// Page object name
	var $PageObjName = 't06_pengeluaran_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->supplier_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->NoNota->SetVisibility();
		$this->barang_id->SetVisibility();
		$this->Banyaknya->SetVisibility();
		$this->Harga->SetVisibility();
		$this->Jumlah->SetVisibility();
		$this->maingroup_id->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "t06_pengeluaranview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $RecCnt;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";

		// Load record by position
		$loadByPosition = FALSE;
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_id")) {
				$this->id->setFormValue($objForm->GetValue("x_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["id"])) {
				$this->id->setQueryStringValue($_GET["id"]);
				$loadByQuery = TRUE;
			} else {
				$this->id->CurrentValue = NULL;
			}
			if (!$loadByQuery)
				$loadByPosition = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("t06_pengeluaranlist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->id->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->id->CurrentValue) == strval($this->Recordset->fields('id'))) {
						$this->setStartRecordNumber($this->StartRec); // Save record position
						$loaded = TRUE;
						break;
					} else {
						$this->StartRec++;
						$this->Recordset->MoveNext();
					}
				}
			}
		}

		// Load current row values
		if ($loaded)
			$this->LoadRowValues($this->Recordset);

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("t06_pengeluaranlist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t06_pengeluaranlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->supplier_id->FldIsDetailKey) {
			$this->supplier_id->setFormValue($objForm->GetValue("x_supplier_id"));
		}
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		}
		if (!$this->NoNota->FldIsDetailKey) {
			$this->NoNota->setFormValue($objForm->GetValue("x_NoNota"));
		}
		if (!$this->barang_id->FldIsDetailKey) {
			$this->barang_id->setFormValue($objForm->GetValue("x_barang_id"));
		}
		if (!$this->Banyaknya->FldIsDetailKey) {
			$this->Banyaknya->setFormValue($objForm->GetValue("x_Banyaknya"));
		}
		if (!$this->Harga->FldIsDetailKey) {
			$this->Harga->setFormValue($objForm->GetValue("x_Harga"));
		}
		if (!$this->Jumlah->FldIsDetailKey) {
			$this->Jumlah->setFormValue($objForm->GetValue("x_Jumlah"));
		}
		if (!$this->maingroup_id->FldIsDetailKey) {
			$this->maingroup_id->setFormValue($objForm->GetValue("x_maingroup_id"));
		}
		if (!$this->subgroup_id->FldIsDetailKey) {
			$this->subgroup_id->setFormValue($objForm->GetValue("x_subgroup_id"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->supplier_id->CurrentValue = $this->supplier_id->FormValue;
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		$this->NoNota->CurrentValue = $this->NoNota->FormValue;
		$this->barang_id->CurrentValue = $this->barang_id->FormValue;
		$this->Banyaknya->CurrentValue = $this->Banyaknya->FormValue;
		$this->Harga->CurrentValue = $this->Harga->FormValue;
		$this->Jumlah->CurrentValue = $this->Jumlah->FormValue;
		$this->maingroup_id->CurrentValue = $this->maingroup_id->FormValue;
		$this->subgroup_id->CurrentValue = $this->subgroup_id->FormValue;
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
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderByList())));
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
		if (array_key_exists('EV__supplier_id', $rs->fields)) {
			$this->supplier_id->VirtualValue = $rs->fields('EV__supplier_id'); // Set up virtual field value
		} else {
			$this->supplier_id->VirtualValue = ""; // Clear value
		}
		$this->Tanggal->setDbValue($row['Tanggal']);
		$this->NoNota->setDbValue($row['NoNota']);
		$this->barang_id->setDbValue($row['barang_id']);
		if (array_key_exists('EV__barang_id', $rs->fields)) {
			$this->barang_id->VirtualValue = $rs->fields('EV__barang_id'); // Set up virtual field value
		} else {
			$this->barang_id->VirtualValue = ""; // Clear value
		}
		$this->Banyaknya->setDbValue($row['Banyaknya']);
		$this->Harga->setDbValue($row['Harga']);
		$this->Jumlah->setDbValue($row['Jumlah']);
		$this->maingroup_id->setDbValue($row['maingroup_id']);
		if (array_key_exists('EV__maingroup_id', $rs->fields)) {
			$this->maingroup_id->VirtualValue = $rs->fields('EV__maingroup_id'); // Set up virtual field value
		} else {
			$this->maingroup_id->VirtualValue = ""; // Clear value
		}
		$this->subgroup_id->setDbValue($row['subgroup_id']);
		if (array_key_exists('EV__subgroup_id', $rs->fields)) {
			$this->subgroup_id->VirtualValue = $rs->fields('EV__subgroup_id'); // Set up virtual field value
		} else {
			$this->subgroup_id->VirtualValue = ""; // Clear value
		}
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
		$row['maingroup_id'] = NULL;
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
		$this->maingroup_id->DbValue = $row['maingroup_id'];
		$this->subgroup_id->DbValue = $row['subgroup_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		// maingroup_id
		// subgroup_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// supplier_id
			$this->supplier_id->EditCustomAttributes = "";
			if (trim(strval($this->supplier_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->supplier_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, `Alamat` AS `Disp2Fld`, `NoTelpHp` AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t01_supplier`";
			$sWhereWrk = "";
			$this->supplier_id->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Alamat`', "dx3" => '`NoTelpHp`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->supplier_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nama` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
				$this->supplier_id->ViewValue = $this->supplier_id->DisplayValue($arwrk);
			} else {
				$this->supplier_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->supplier_id->EditValue = $arwrk;

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 7));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// NoNota
			$this->NoNota->EditAttrs["class"] = "form-control";
			$this->NoNota->EditCustomAttributes = "";
			$this->NoNota->EditValue = ew_HtmlEncode($this->NoNota->CurrentValue);
			$this->NoNota->PlaceHolder = ew_RemoveHtml($this->NoNota->FldCaption());

			// barang_id
			$this->barang_id->EditCustomAttributes = "";
			if (trim(strval($this->barang_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->barang_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, `Satuan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `v01_barang_satuan`";
			$sWhereWrk = "";
			$this->barang_id->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Satuan`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nama` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
				$this->barang_id->ViewValue = $this->barang_id->DisplayValue($arwrk);
			} else {
				$this->barang_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->barang_id->EditValue = $arwrk;

			// Banyaknya
			$this->Banyaknya->EditAttrs["class"] = "form-control";
			$this->Banyaknya->EditCustomAttributes = "";
			$this->Banyaknya->EditValue = ew_HtmlEncode($this->Banyaknya->CurrentValue);
			$this->Banyaknya->PlaceHolder = ew_RemoveHtml($this->Banyaknya->FldCaption());
			if (strval($this->Banyaknya->EditValue) <> "" && is_numeric($this->Banyaknya->EditValue)) $this->Banyaknya->EditValue = ew_FormatNumber($this->Banyaknya->EditValue, -2, -2, -2, -2);

			// Harga
			$this->Harga->EditAttrs["class"] = "form-control";
			$this->Harga->EditCustomAttributes = "";
			$this->Harga->EditValue = ew_HtmlEncode($this->Harga->CurrentValue);
			$this->Harga->PlaceHolder = ew_RemoveHtml($this->Harga->FldCaption());
			if (strval($this->Harga->EditValue) <> "" && is_numeric($this->Harga->EditValue)) $this->Harga->EditValue = ew_FormatNumber($this->Harga->EditValue, -2, -2, -2, -2);

			// Jumlah
			$this->Jumlah->EditAttrs["class"] = "form-control";
			$this->Jumlah->EditCustomAttributes = "";
			$this->Jumlah->EditValue = ew_HtmlEncode($this->Jumlah->CurrentValue);
			$this->Jumlah->PlaceHolder = ew_RemoveHtml($this->Jumlah->FldCaption());
			if (strval($this->Jumlah->EditValue) <> "" && is_numeric($this->Jumlah->EditValue)) $this->Jumlah->EditValue = ew_FormatNumber($this->Jumlah->EditValue, -2, -2, -2, -2);

			// maingroup_id
			$this->maingroup_id->EditCustomAttributes = "";
			if (trim(strval($this->maingroup_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->maingroup_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t04_maingroup`";
			$sWhereWrk = "";
			$this->maingroup_id->LookupFilters = array("dx1" => '`Nama`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->maingroup_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->maingroup_id->ViewValue = $this->maingroup_id->DisplayValue($arwrk);
			} else {
				$this->maingroup_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->maingroup_id->EditValue = $arwrk;

			// subgroup_id
			$this->subgroup_id->EditCustomAttributes = "";
			if (trim(strval($this->subgroup_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->subgroup_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `maingroup_id` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t05_subgroup`";
			$sWhereWrk = "";
			$this->subgroup_id->LookupFilters = array("dx1" => '`Nama`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->subgroup_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->subgroup_id->ViewValue = $this->subgroup_id->DisplayValue($arwrk);
			} else {
				$this->subgroup_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->subgroup_id->EditValue = $arwrk;

			// Edit refer script
			// supplier_id

			$this->supplier_id->LinkCustomAttributes = "";
			$this->supplier_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// NoNota
			$this->NoNota->LinkCustomAttributes = "";
			$this->NoNota->HrefValue = "";

			// barang_id
			$this->barang_id->LinkCustomAttributes = "";
			$this->barang_id->HrefValue = "";

			// Banyaknya
			$this->Banyaknya->LinkCustomAttributes = "";
			$this->Banyaknya->HrefValue = "";

			// Harga
			$this->Harga->LinkCustomAttributes = "";
			$this->Harga->HrefValue = "";

			// Jumlah
			$this->Jumlah->LinkCustomAttributes = "";
			$this->Jumlah->HrefValue = "";

			// maingroup_id
			$this->maingroup_id->LinkCustomAttributes = "";
			$this->maingroup_id->HrefValue = "";

			// subgroup_id
			$this->subgroup_id->LinkCustomAttributes = "";
			$this->subgroup_id->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->supplier_id->FldIsDetailKey && !is_null($this->supplier_id->FormValue) && $this->supplier_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->supplier_id->FldCaption(), $this->supplier_id->ReqErrMsg));
		}
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!$this->NoNota->FldIsDetailKey && !is_null($this->NoNota->FormValue) && $this->NoNota->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NoNota->FldCaption(), $this->NoNota->ReqErrMsg));
		}
		if (!$this->barang_id->FldIsDetailKey && !is_null($this->barang_id->FormValue) && $this->barang_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->barang_id->FldCaption(), $this->barang_id->ReqErrMsg));
		}
		if (!$this->Banyaknya->FldIsDetailKey && !is_null($this->Banyaknya->FormValue) && $this->Banyaknya->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Banyaknya->FldCaption(), $this->Banyaknya->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Banyaknya->FormValue)) {
			ew_AddMessage($gsFormError, $this->Banyaknya->FldErrMsg());
		}
		if (!$this->Harga->FldIsDetailKey && !is_null($this->Harga->FormValue) && $this->Harga->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Harga->FldCaption(), $this->Harga->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Harga->FormValue)) {
			ew_AddMessage($gsFormError, $this->Harga->FldErrMsg());
		}
		if (!$this->Jumlah->FldIsDetailKey && !is_null($this->Jumlah->FormValue) && $this->Jumlah->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Jumlah->FldCaption(), $this->Jumlah->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->Jumlah->FldErrMsg());
		}
		if (!$this->maingroup_id->FldIsDetailKey && !is_null($this->maingroup_id->FormValue) && $this->maingroup_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->maingroup_id->FldCaption(), $this->maingroup_id->ReqErrMsg));
		}
		if (!$this->subgroup_id->FldIsDetailKey && !is_null($this->subgroup_id->FormValue) && $this->subgroup_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->subgroup_id->FldCaption(), $this->subgroup_id->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// supplier_id
			$this->supplier_id->SetDbValueDef($rsnew, $this->supplier_id->CurrentValue, 0, $this->supplier_id->ReadOnly);

			// Tanggal
			$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7), ew_CurrentDate(), $this->Tanggal->ReadOnly);

			// NoNota
			$this->NoNota->SetDbValueDef($rsnew, $this->NoNota->CurrentValue, "", $this->NoNota->ReadOnly);

			// barang_id
			$this->barang_id->SetDbValueDef($rsnew, $this->barang_id->CurrentValue, 0, $this->barang_id->ReadOnly);

			// Banyaknya
			$this->Banyaknya->SetDbValueDef($rsnew, $this->Banyaknya->CurrentValue, 0, $this->Banyaknya->ReadOnly);

			// Harga
			$this->Harga->SetDbValueDef($rsnew, $this->Harga->CurrentValue, 0, $this->Harga->ReadOnly);

			// Jumlah
			$this->Jumlah->SetDbValueDef($rsnew, $this->Jumlah->CurrentValue, 0, $this->Jumlah->ReadOnly);

			// maingroup_id
			$this->maingroup_id->SetDbValueDef($rsnew, $this->maingroup_id->CurrentValue, 0, $this->maingroup_id->ReadOnly);

			// subgroup_id
			$this->subgroup_id->SetDbValueDef($rsnew, $this->subgroup_id->CurrentValue, 0, $this->subgroup_id->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t06_pengeluaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_supplier_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, `Alamat` AS `Disp2Fld`, `NoTelpHp` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_supplier`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Alamat`', "dx3" => '`NoTelpHp`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->supplier_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nama` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_barang_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, `Satuan` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `v01_barang_satuan`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Nama`', "dx2" => '`Satuan`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->barang_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Nama` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_maingroup_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t04_maingroup`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->maingroup_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_subgroup_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t05_subgroup`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array("dx1" => '`Nama`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` IN ({filter_value})', "t0" => "3", "fn0" => "", "f1" => '`maingroup_id` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->subgroup_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t06_pengeluaran_edit)) $t06_pengeluaran_edit = new ct06_pengeluaran_edit();

// Page init
$t06_pengeluaran_edit->Page_Init();

// Page main
$t06_pengeluaran_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t06_pengeluaran_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft06_pengeluaranedit = new ew_Form("ft06_pengeluaranedit", "edit");

// Validate form
ft06_pengeluaranedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_supplier_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->supplier_id->FldCaption(), $t06_pengeluaran->supplier_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->Tanggal->FldCaption(), $t06_pengeluaran->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pengeluaran->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NoNota");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->NoNota->FldCaption(), $t06_pengeluaran->NoNota->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_barang_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->barang_id->FldCaption(), $t06_pengeluaran->barang_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Banyaknya");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->Banyaknya->FldCaption(), $t06_pengeluaran->Banyaknya->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Banyaknya");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pengeluaran->Banyaknya->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Harga");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->Harga->FldCaption(), $t06_pengeluaran->Harga->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Harga");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pengeluaran->Harga->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->Jumlah->FldCaption(), $t06_pengeluaran->Jumlah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t06_pengeluaran->Jumlah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_maingroup_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->maingroup_id->FldCaption(), $t06_pengeluaran->maingroup_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_subgroup_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t06_pengeluaran->subgroup_id->FldCaption(), $t06_pengeluaran->subgroup_id->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft06_pengeluaranedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft06_pengeluaranedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft06_pengeluaranedit.Lists["x_supplier_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","x_Alamat","x_NoTelpHp",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_supplier"};
ft06_pengeluaranedit.Lists["x_supplier_id"].Data = "<?php echo $t06_pengeluaran_edit->supplier_id->LookupFilterQuery(FALSE, "edit") ?>";
ft06_pengeluaranedit.Lists["x_barang_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","x_Satuan","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"v01_barang_satuan"};
ft06_pengeluaranedit.Lists["x_barang_id"].Data = "<?php echo $t06_pengeluaran_edit->barang_id->LookupFilterQuery(FALSE, "edit") ?>";
ft06_pengeluaranedit.Lists["x_maingroup_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":[],"ChildFields":["x_subgroup_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t04_maingroup"};
ft06_pengeluaranedit.Lists["x_maingroup_id"].Data = "<?php echo $t06_pengeluaran_edit->maingroup_id->LookupFilterQuery(FALSE, "edit") ?>";
ft06_pengeluaranedit.Lists["x_subgroup_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":["x_maingroup_id"],"ChildFields":[],"FilterFields":["x_maingroup_id"],"Options":[],"Template":"","LinkTable":"t05_subgroup"};
ft06_pengeluaranedit.Lists["x_subgroup_id"].Data = "<?php echo $t06_pengeluaran_edit->subgroup_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t06_pengeluaran_edit->ShowPageHeader(); ?>
<?php
$t06_pengeluaran_edit->ShowMessage();
?>
<?php if (!$t06_pengeluaran_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t06_pengeluaran_edit->Pager)) $t06_pengeluaran_edit->Pager = new cPrevNextPager($t06_pengeluaran_edit->StartRec, $t06_pengeluaran_edit->DisplayRecs, $t06_pengeluaran_edit->TotalRecs, $t06_pengeluaran_edit->AutoHidePager) ?>
<?php if ($t06_pengeluaran_edit->Pager->RecordCount > 0 && $t06_pengeluaran_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t06_pengeluaran_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t06_pengeluaran_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t06_pengeluaran_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t06_pengeluaran_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t06_pengeluaran_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t06_pengeluaran_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft06_pengeluaranedit" id="ft06_pengeluaranedit" class="<?php echo $t06_pengeluaran_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t06_pengeluaran_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t06_pengeluaran_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t06_pengeluaran">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t06_pengeluaran_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t06_pengeluaran->supplier_id->Visible) { // supplier_id ?>
	<div id="r_supplier_id" class="form-group">
		<label id="elh_t06_pengeluaran_supplier_id" for="x_supplier_id" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->supplier_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->supplier_id->CellAttributes() ?>>
<span id="el_t06_pengeluaran_supplier_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_supplier_id"><?php echo (strval($t06_pengeluaran->supplier_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t06_pengeluaran->supplier_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t06_pengeluaran->supplier_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_supplier_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t06_pengeluaran->supplier_id->ReadOnly || $t06_pengeluaran->supplier_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t06_pengeluaran" data-field="x_supplier_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t06_pengeluaran->supplier_id->DisplayValueSeparatorAttribute() ?>" name="x_supplier_id" id="x_supplier_id" value="<?php echo $t06_pengeluaran->supplier_id->CurrentValue ?>"<?php echo $t06_pengeluaran->supplier_id->EditAttributes() ?>>
<?php if (AllowAdd(CurrentProjectID() . "t01_supplier") && !$t06_pengeluaran->supplier_id->ReadOnly) { ?>
<button type="button" title="<?php echo ew_HtmlTitle($Language->Phrase("AddLink")) . "&nbsp;" . $t06_pengeluaran->supplier_id->FldCaption() ?>" onclick="ew_AddOptDialogShow({lnk:this,el:'x_supplier_id',url:'t01_supplieraddopt.php'});" class="ewAddOptBtn btn btn-default btn-sm" id="aol_x_supplier_id"><span class="glyphicon glyphicon-plus ewIcon"></span><span class="hide"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $t06_pengeluaran->supplier_id->FldCaption() ?></span></button>
<?php } ?>
</span>
<?php echo $t06_pengeluaran->supplier_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->Tanggal->Visible) { // Tanggal ?>
	<div id="r_Tanggal" class="form-group">
		<label id="elh_t06_pengeluaran_Tanggal" for="x_Tanggal" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->Tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->Tanggal->CellAttributes() ?>>
<span id="el_t06_pengeluaran_Tanggal">
<input type="text" data-table="t06_pengeluaran" data-field="x_Tanggal" data-format="7" name="x_Tanggal" id="x_Tanggal" placeholder="<?php echo ew_HtmlEncode($t06_pengeluaran->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t06_pengeluaran->Tanggal->EditValue ?>"<?php echo $t06_pengeluaran->Tanggal->EditAttributes() ?>>
<?php if (!$t06_pengeluaran->Tanggal->ReadOnly && !$t06_pengeluaran->Tanggal->Disabled && !isset($t06_pengeluaran->Tanggal->EditAttrs["readonly"]) && !isset($t06_pengeluaran->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ft06_pengeluaranedit", "x_Tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $t06_pengeluaran->Tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->NoNota->Visible) { // NoNota ?>
	<div id="r_NoNota" class="form-group">
		<label id="elh_t06_pengeluaran_NoNota" for="x_NoNota" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->NoNota->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->NoNota->CellAttributes() ?>>
<span id="el_t06_pengeluaran_NoNota">
<input type="text" data-table="t06_pengeluaran" data-field="x_NoNota" name="x_NoNota" id="x_NoNota" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t06_pengeluaran->NoNota->getPlaceHolder()) ?>" value="<?php echo $t06_pengeluaran->NoNota->EditValue ?>"<?php echo $t06_pengeluaran->NoNota->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->NoNota->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->barang_id->Visible) { // barang_id ?>
	<div id="r_barang_id" class="form-group">
		<label id="elh_t06_pengeluaran_barang_id" for="x_barang_id" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->barang_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->barang_id->CellAttributes() ?>>
<span id="el_t06_pengeluaran_barang_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_barang_id"><?php echo (strval($t06_pengeluaran->barang_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t06_pengeluaran->barang_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t06_pengeluaran->barang_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_barang_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t06_pengeluaran->barang_id->ReadOnly || $t06_pengeluaran->barang_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t06_pengeluaran" data-field="x_barang_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t06_pengeluaran->barang_id->DisplayValueSeparatorAttribute() ?>" name="x_barang_id" id="x_barang_id" value="<?php echo $t06_pengeluaran->barang_id->CurrentValue ?>"<?php echo $t06_pengeluaran->barang_id->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->barang_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->Banyaknya->Visible) { // Banyaknya ?>
	<div id="r_Banyaknya" class="form-group">
		<label id="elh_t06_pengeluaran_Banyaknya" for="x_Banyaknya" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->Banyaknya->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->Banyaknya->CellAttributes() ?>>
<span id="el_t06_pengeluaran_Banyaknya">
<input type="text" data-table="t06_pengeluaran" data-field="x_Banyaknya" name="x_Banyaknya" id="x_Banyaknya" size="30" placeholder="<?php echo ew_HtmlEncode($t06_pengeluaran->Banyaknya->getPlaceHolder()) ?>" value="<?php echo $t06_pengeluaran->Banyaknya->EditValue ?>"<?php echo $t06_pengeluaran->Banyaknya->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->Banyaknya->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->Harga->Visible) { // Harga ?>
	<div id="r_Harga" class="form-group">
		<label id="elh_t06_pengeluaran_Harga" for="x_Harga" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->Harga->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->Harga->CellAttributes() ?>>
<span id="el_t06_pengeluaran_Harga">
<input type="text" data-table="t06_pengeluaran" data-field="x_Harga" name="x_Harga" id="x_Harga" size="30" placeholder="<?php echo ew_HtmlEncode($t06_pengeluaran->Harga->getPlaceHolder()) ?>" value="<?php echo $t06_pengeluaran->Harga->EditValue ?>"<?php echo $t06_pengeluaran->Harga->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->Harga->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->Jumlah->Visible) { // Jumlah ?>
	<div id="r_Jumlah" class="form-group">
		<label id="elh_t06_pengeluaran_Jumlah" for="x_Jumlah" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->Jumlah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->Jumlah->CellAttributes() ?>>
<span id="el_t06_pengeluaran_Jumlah">
<input type="text" data-table="t06_pengeluaran" data-field="x_Jumlah" name="x_Jumlah" id="x_Jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($t06_pengeluaran->Jumlah->getPlaceHolder()) ?>" value="<?php echo $t06_pengeluaran->Jumlah->EditValue ?>"<?php echo $t06_pengeluaran->Jumlah->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->Jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->maingroup_id->Visible) { // maingroup_id ?>
	<div id="r_maingroup_id" class="form-group">
		<label id="elh_t06_pengeluaran_maingroup_id" for="x_maingroup_id" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->maingroup_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->maingroup_id->CellAttributes() ?>>
<span id="el_t06_pengeluaran_maingroup_id">
<?php $t06_pengeluaran->maingroup_id->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t06_pengeluaran->maingroup_id->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_maingroup_id"><?php echo (strval($t06_pengeluaran->maingroup_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t06_pengeluaran->maingroup_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t06_pengeluaran->maingroup_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_maingroup_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t06_pengeluaran->maingroup_id->ReadOnly || $t06_pengeluaran->maingroup_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t06_pengeluaran" data-field="x_maingroup_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t06_pengeluaran->maingroup_id->DisplayValueSeparatorAttribute() ?>" name="x_maingroup_id" id="x_maingroup_id" value="<?php echo $t06_pengeluaran->maingroup_id->CurrentValue ?>"<?php echo $t06_pengeluaran->maingroup_id->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->maingroup_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t06_pengeluaran->subgroup_id->Visible) { // subgroup_id ?>
	<div id="r_subgroup_id" class="form-group">
		<label id="elh_t06_pengeluaran_subgroup_id" for="x_subgroup_id" class="<?php echo $t06_pengeluaran_edit->LeftColumnClass ?>"><?php echo $t06_pengeluaran->subgroup_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t06_pengeluaran_edit->RightColumnClass ?>"><div<?php echo $t06_pengeluaran->subgroup_id->CellAttributes() ?>>
<span id="el_t06_pengeluaran_subgroup_id">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next(":not([disabled])").click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_subgroup_id"><?php echo (strval($t06_pengeluaran->subgroup_id->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t06_pengeluaran->subgroup_id->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t06_pengeluaran->subgroup_id->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_subgroup_id',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"<?php echo (($t06_pengeluaran->subgroup_id->ReadOnly || $t06_pengeluaran->subgroup_id->Disabled) ? " disabled" : "")?>><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t06_pengeluaran" data-field="x_subgroup_id" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t06_pengeluaran->subgroup_id->DisplayValueSeparatorAttribute() ?>" name="x_subgroup_id" id="x_subgroup_id" value="<?php echo $t06_pengeluaran->subgroup_id->CurrentValue ?>"<?php echo $t06_pengeluaran->subgroup_id->EditAttributes() ?>>
</span>
<?php echo $t06_pengeluaran->subgroup_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="t06_pengeluaran" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t06_pengeluaran->id->CurrentValue) ?>">
<?php if (!$t06_pengeluaran_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t06_pengeluaran_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t06_pengeluaran_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$t06_pengeluaran_edit->IsModal) { ?>
<?php if (!isset($t06_pengeluaran_edit->Pager)) $t06_pengeluaran_edit->Pager = new cPrevNextPager($t06_pengeluaran_edit->StartRec, $t06_pengeluaran_edit->DisplayRecs, $t06_pengeluaran_edit->TotalRecs, $t06_pengeluaran_edit->AutoHidePager) ?>
<?php if ($t06_pengeluaran_edit->Pager->RecordCount > 0 && $t06_pengeluaran_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t06_pengeluaran_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t06_pengeluaran_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t06_pengeluaran_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t06_pengeluaran_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t06_pengeluaran_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t06_pengeluaran_edit->PageUrl() ?>start=<?php echo $t06_pengeluaran_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t06_pengeluaran_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft06_pengeluaranedit.Init();
</script>
<?php
$t06_pengeluaran_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t06_pengeluaran_edit->Page_Terminate();
?>
