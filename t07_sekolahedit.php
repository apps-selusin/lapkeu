<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t07_sekolahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t07_sekolah_edit = NULL; // Initialize page object first

class ct07_sekolah_edit extends ct07_sekolah {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't07_sekolah';

	// Page object name
	var $PageObjName = 't07_sekolah_edit';

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

		// Table object (t07_sekolah)
		if (!isset($GLOBALS["t07_sekolah"]) || get_class($GLOBALS["t07_sekolah"]) == "ct07_sekolah") {
			$GLOBALS["t07_sekolah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t07_sekolah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't07_sekolah', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t07_sekolahlist.php"));
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
		$this->Nama->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->TTD1Nama->SetVisibility();
		$this->TTD1Jabatan->SetVisibility();
		$this->TTD2Nama->SetVisibility();
		$this->TTD2Jabatan->SetVisibility();
		$this->Logo->SetVisibility();

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
		global $EW_EXPORT, $t07_sekolah;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t07_sekolah);
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
					if ($pageName == "t07_sekolahview.php")
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
			$this->Page_Terminate("t07_sekolahlist.php"); // Return to list page
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
					$this->Page_Terminate("t07_sekolahlist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t07_sekolahlist.php")
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
		$this->Logo->Upload->Index = $objForm->Index;
		$this->Logo->Upload->UploadFile();
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Nama->FldIsDetailKey) {
			$this->Nama->setFormValue($objForm->GetValue("x_Nama"));
		}
		if (!$this->Alamat->FldIsDetailKey) {
			$this->Alamat->setFormValue($objForm->GetValue("x_Alamat"));
		}
		if (!$this->NoTelpHp->FldIsDetailKey) {
			$this->NoTelpHp->setFormValue($objForm->GetValue("x_NoTelpHp"));
		}
		if (!$this->TTD1Nama->FldIsDetailKey) {
			$this->TTD1Nama->setFormValue($objForm->GetValue("x_TTD1Nama"));
		}
		if (!$this->TTD1Jabatan->FldIsDetailKey) {
			$this->TTD1Jabatan->setFormValue($objForm->GetValue("x_TTD1Jabatan"));
		}
		if (!$this->TTD2Nama->FldIsDetailKey) {
			$this->TTD2Nama->setFormValue($objForm->GetValue("x_TTD2Nama"));
		}
		if (!$this->TTD2Jabatan->FldIsDetailKey) {
			$this->TTD2Jabatan->setFormValue($objForm->GetValue("x_TTD2Jabatan"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->id->CurrentValue = $this->id->FormValue;
		$this->Nama->CurrentValue = $this->Nama->FormValue;
		$this->Alamat->CurrentValue = $this->Alamat->FormValue;
		$this->NoTelpHp->CurrentValue = $this->NoTelpHp->FormValue;
		$this->TTD1Nama->CurrentValue = $this->TTD1Nama->FormValue;
		$this->TTD1Jabatan->CurrentValue = $this->TTD1Jabatan->FormValue;
		$this->TTD2Nama->CurrentValue = $this->TTD2Nama->FormValue;
		$this->TTD2Jabatan->CurrentValue = $this->TTD2Jabatan->FormValue;
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
		$this->Nama->setDbValue($row['Nama']);
		$this->Alamat->setDbValue($row['Alamat']);
		$this->NoTelpHp->setDbValue($row['NoTelpHp']);
		$this->TTD1Nama->setDbValue($row['TTD1Nama']);
		$this->TTD1Jabatan->setDbValue($row['TTD1Jabatan']);
		$this->TTD2Nama->setDbValue($row['TTD2Nama']);
		$this->TTD2Jabatan->setDbValue($row['TTD2Jabatan']);
		$this->Logo->Upload->DbValue = $row['Logo'];
		$this->Logo->setDbValue($this->Logo->Upload->DbValue);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['id'] = NULL;
		$row['Nama'] = NULL;
		$row['Alamat'] = NULL;
		$row['NoTelpHp'] = NULL;
		$row['TTD1Nama'] = NULL;
		$row['TTD1Jabatan'] = NULL;
		$row['TTD2Nama'] = NULL;
		$row['TTD2Jabatan'] = NULL;
		$row['Logo'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->NoTelpHp->DbValue = $row['NoTelpHp'];
		$this->TTD1Nama->DbValue = $row['TTD1Nama'];
		$this->TTD1Jabatan->DbValue = $row['TTD1Jabatan'];
		$this->TTD2Nama->DbValue = $row['TTD2Nama'];
		$this->TTD2Jabatan->DbValue = $row['TTD2Jabatan'];
		$this->Logo->Upload->DbValue = $row['Logo'];
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Nama
		// Alamat
		// NoTelpHp
		// TTD1Nama
		// TTD1Jabatan
		// TTD2Nama
		// TTD2Jabatan
		// Logo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// NoTelpHp
		$this->NoTelpHp->ViewValue = $this->NoTelpHp->CurrentValue;
		$this->NoTelpHp->ViewCustomAttributes = "";

		// TTD1Nama
		$this->TTD1Nama->ViewValue = $this->TTD1Nama->CurrentValue;
		$this->TTD1Nama->ViewCustomAttributes = "";

		// TTD1Jabatan
		$this->TTD1Jabatan->ViewValue = $this->TTD1Jabatan->CurrentValue;
		$this->TTD1Jabatan->ViewCustomAttributes = "";

		// TTD2Nama
		$this->TTD2Nama->ViewValue = $this->TTD2Nama->CurrentValue;
		$this->TTD2Nama->ViewCustomAttributes = "";

		// TTD2Jabatan
		$this->TTD2Jabatan->ViewValue = $this->TTD2Jabatan->CurrentValue;
		$this->TTD2Jabatan->ViewCustomAttributes = "";

		// Logo
		$this->Logo->UploadPath = 'images/';
		if (!ew_Empty($this->Logo->Upload->DbValue)) {
			$this->Logo->ViewValue = $this->Logo->Upload->DbValue;
		} else {
			$this->Logo->ViewValue = "";
		}
		$this->Logo->ViewCustomAttributes = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";
			$this->Alamat->TooltipValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";
			$this->NoTelpHp->TooltipValue = "";

			// TTD1Nama
			$this->TTD1Nama->LinkCustomAttributes = "";
			$this->TTD1Nama->HrefValue = "";
			$this->TTD1Nama->TooltipValue = "";

			// TTD1Jabatan
			$this->TTD1Jabatan->LinkCustomAttributes = "";
			$this->TTD1Jabatan->HrefValue = "";
			$this->TTD1Jabatan->TooltipValue = "";

			// TTD2Nama
			$this->TTD2Nama->LinkCustomAttributes = "";
			$this->TTD2Nama->HrefValue = "";
			$this->TTD2Nama->TooltipValue = "";

			// TTD2Jabatan
			$this->TTD2Jabatan->LinkCustomAttributes = "";
			$this->TTD2Jabatan->HrefValue = "";
			$this->TTD2Jabatan->TooltipValue = "";

			// Logo
			$this->Logo->LinkCustomAttributes = "";
			$this->Logo->UploadPath = 'images/';
			if (!ew_Empty($this->Logo->Upload->DbValue)) {
				$this->Logo->HrefValue = ew_GetFileUploadUrl($this->Logo, $this->Logo->Upload->DbValue); // Add prefix/suffix
				$this->Logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Logo->HrefValue = ew_FullUrl($this->Logo->HrefValue, "href");
			} else {
				$this->Logo->HrefValue = "";
			}
			$this->Logo->HrefValue2 = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;
			$this->Logo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Nama
			$this->Nama->EditAttrs["class"] = "form-control";
			$this->Nama->EditCustomAttributes = "";
			$this->Nama->EditValue = ew_HtmlEncode($this->Nama->CurrentValue);
			$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

			// Alamat
			$this->Alamat->EditAttrs["class"] = "form-control";
			$this->Alamat->EditCustomAttributes = "";
			$this->Alamat->EditValue = ew_HtmlEncode($this->Alamat->CurrentValue);
			$this->Alamat->PlaceHolder = ew_RemoveHtml($this->Alamat->FldCaption());

			// NoTelpHp
			$this->NoTelpHp->EditAttrs["class"] = "form-control";
			$this->NoTelpHp->EditCustomAttributes = "";
			$this->NoTelpHp->EditValue = ew_HtmlEncode($this->NoTelpHp->CurrentValue);
			$this->NoTelpHp->PlaceHolder = ew_RemoveHtml($this->NoTelpHp->FldCaption());

			// TTD1Nama
			$this->TTD1Nama->EditAttrs["class"] = "form-control";
			$this->TTD1Nama->EditCustomAttributes = "";
			$this->TTD1Nama->EditValue = ew_HtmlEncode($this->TTD1Nama->CurrentValue);
			$this->TTD1Nama->PlaceHolder = ew_RemoveHtml($this->TTD1Nama->FldCaption());

			// TTD1Jabatan
			$this->TTD1Jabatan->EditAttrs["class"] = "form-control";
			$this->TTD1Jabatan->EditCustomAttributes = "";
			$this->TTD1Jabatan->EditValue = ew_HtmlEncode($this->TTD1Jabatan->CurrentValue);
			$this->TTD1Jabatan->PlaceHolder = ew_RemoveHtml($this->TTD1Jabatan->FldCaption());

			// TTD2Nama
			$this->TTD2Nama->EditAttrs["class"] = "form-control";
			$this->TTD2Nama->EditCustomAttributes = "";
			$this->TTD2Nama->EditValue = ew_HtmlEncode($this->TTD2Nama->CurrentValue);
			$this->TTD2Nama->PlaceHolder = ew_RemoveHtml($this->TTD2Nama->FldCaption());

			// TTD2Jabatan
			$this->TTD2Jabatan->EditAttrs["class"] = "form-control";
			$this->TTD2Jabatan->EditCustomAttributes = "";
			$this->TTD2Jabatan->EditValue = ew_HtmlEncode($this->TTD2Jabatan->CurrentValue);
			$this->TTD2Jabatan->PlaceHolder = ew_RemoveHtml($this->TTD2Jabatan->FldCaption());

			// Logo
			$this->Logo->EditAttrs["class"] = "form-control";
			$this->Logo->EditCustomAttributes = "";
			$this->Logo->UploadPath = 'images/';
			if (!ew_Empty($this->Logo->Upload->DbValue)) {
				$this->Logo->EditValue = $this->Logo->Upload->DbValue;
			} else {
				$this->Logo->EditValue = "";
			}
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->Logo);

			// Edit refer script
			// Nama

			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";

			// NoTelpHp
			$this->NoTelpHp->LinkCustomAttributes = "";
			$this->NoTelpHp->HrefValue = "";

			// TTD1Nama
			$this->TTD1Nama->LinkCustomAttributes = "";
			$this->TTD1Nama->HrefValue = "";

			// TTD1Jabatan
			$this->TTD1Jabatan->LinkCustomAttributes = "";
			$this->TTD1Jabatan->HrefValue = "";

			// TTD2Nama
			$this->TTD2Nama->LinkCustomAttributes = "";
			$this->TTD2Nama->HrefValue = "";

			// TTD2Jabatan
			$this->TTD2Jabatan->LinkCustomAttributes = "";
			$this->TTD2Jabatan->HrefValue = "";

			// Logo
			$this->Logo->LinkCustomAttributes = "";
			$this->Logo->UploadPath = 'images/';
			if (!ew_Empty($this->Logo->Upload->DbValue)) {
				$this->Logo->HrefValue = ew_GetFileUploadUrl($this->Logo, $this->Logo->Upload->DbValue); // Add prefix/suffix
				$this->Logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Logo->HrefValue = ew_FullUrl($this->Logo->HrefValue, "href");
			} else {
				$this->Logo->HrefValue = "";
			}
			$this->Logo->HrefValue2 = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;
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
		if (!$this->Nama->FldIsDetailKey && !is_null($this->Nama->FormValue) && $this->Nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nama->FldCaption(), $this->Nama->ReqErrMsg));
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
			$this->Logo->OldUploadPath = 'images/';
			$this->Logo->UploadPath = $this->Logo->OldUploadPath;
			$rsnew = array();

			// Nama
			$this->Nama->SetDbValueDef($rsnew, $this->Nama->CurrentValue, "", $this->Nama->ReadOnly);

			// Alamat
			$this->Alamat->SetDbValueDef($rsnew, $this->Alamat->CurrentValue, NULL, $this->Alamat->ReadOnly);

			// NoTelpHp
			$this->NoTelpHp->SetDbValueDef($rsnew, $this->NoTelpHp->CurrentValue, NULL, $this->NoTelpHp->ReadOnly);

			// TTD1Nama
			$this->TTD1Nama->SetDbValueDef($rsnew, $this->TTD1Nama->CurrentValue, NULL, $this->TTD1Nama->ReadOnly);

			// TTD1Jabatan
			$this->TTD1Jabatan->SetDbValueDef($rsnew, $this->TTD1Jabatan->CurrentValue, NULL, $this->TTD1Jabatan->ReadOnly);

			// TTD2Nama
			$this->TTD2Nama->SetDbValueDef($rsnew, $this->TTD2Nama->CurrentValue, NULL, $this->TTD2Nama->ReadOnly);

			// TTD2Jabatan
			$this->TTD2Jabatan->SetDbValueDef($rsnew, $this->TTD2Jabatan->CurrentValue, NULL, $this->TTD2Jabatan->ReadOnly);

			// Logo
			if ($this->Logo->Visible && !$this->Logo->ReadOnly && !$this->Logo->Upload->KeepFile) {
				$this->Logo->Upload->DbValue = $rsold['Logo']; // Get original value
				if ($this->Logo->Upload->FileName == "") {
					$rsnew['Logo'] = NULL;
				} else {
					$rsnew['Logo'] = $this->Logo->Upload->FileName;
				}
			}
			if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
				$this->Logo->UploadPath = 'images/';
				$OldFiles = ew_Empty($this->Logo->Upload->DbValue) ? array() : array($this->Logo->Upload->DbValue);
				if (!ew_Empty($this->Logo->Upload->FileName)) {
					$NewFiles = array($this->Logo->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->Logo->Upload->Index < 0) ? $this->Logo->FldVar : substr($this->Logo->FldVar, 0, 1) . $this->Logo->Upload->Index . substr($this->Logo->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->Logo->TblVar) . $file)) {
								$file1 = ew_UploadFileNameEx($this->Logo->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->Logo->TblVar) . $file1) || file_exists($this->Logo->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->Logo->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->Logo->TblVar) . $file, ew_UploadTempPath($fldvar, $this->Logo->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->Logo->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->Logo->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->Logo->SetDbValueDef($rsnew, $this->Logo->Upload->FileName, NULL, $this->Logo->ReadOnly);
				}
			}

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
					if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->Logo->Upload->DbValue) ? array() : array($this->Logo->Upload->DbValue);
						if (!ew_Empty($this->Logo->Upload->FileName)) {
							$NewFiles = array($this->Logo->Upload->FileName);
							$NewFiles2 = array($rsnew['Logo']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->Logo->Upload->Index < 0) ? $this->Logo->FldVar : substr($this->Logo->FldVar, 0, 1) . $this->Logo->Upload->Index . substr($this->Logo->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->Logo->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->Logo->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
					}
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

		// Logo
		ew_CleanUploadTempPath($this->Logo, $this->Logo->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t07_sekolahlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($t07_sekolah_edit)) $t07_sekolah_edit = new ct07_sekolah_edit();

// Page init
$t07_sekolah_edit->Page_Init();

// Page main
$t07_sekolah_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_sekolah_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft07_sekolahedit = new ew_Form("ft07_sekolahedit", "edit");

// Validate form
ft07_sekolahedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t07_sekolah->Nama->FldCaption(), $t07_sekolah->Nama->ReqErrMsg)) ?>");

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
ft07_sekolahedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft07_sekolahedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t07_sekolah_edit->ShowPageHeader(); ?>
<?php
$t07_sekolah_edit->ShowMessage();
?>
<?php if (!$t07_sekolah_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t07_sekolah_edit->Pager)) $t07_sekolah_edit->Pager = new cPrevNextPager($t07_sekolah_edit->StartRec, $t07_sekolah_edit->DisplayRecs, $t07_sekolah_edit->TotalRecs, $t07_sekolah_edit->AutoHidePager) ?>
<?php if ($t07_sekolah_edit->Pager->RecordCount > 0 && $t07_sekolah_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t07_sekolah_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t07_sekolah_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t07_sekolah_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t07_sekolah_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t07_sekolah_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t07_sekolah_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft07_sekolahedit" id="ft07_sekolahedit" class="<?php echo $t07_sekolah_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t07_sekolah_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t07_sekolah_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t07_sekolah">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t07_sekolah_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t07_sekolah->Nama->Visible) { // Nama ?>
	<div id="r_Nama" class="form-group">
		<label id="elh_t07_sekolah_Nama" for="x_Nama" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->Nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->Nama->CellAttributes() ?>>
<span id="el_t07_sekolah_Nama">
<input type="text" data-table="t07_sekolah" data-field="x_Nama" name="x_Nama" id="x_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->Nama->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->Nama->EditValue ?>"<?php echo $t07_sekolah->Nama->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->Nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->Alamat->Visible) { // Alamat ?>
	<div id="r_Alamat" class="form-group">
		<label id="elh_t07_sekolah_Alamat" for="x_Alamat" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->Alamat->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->Alamat->CellAttributes() ?>>
<span id="el_t07_sekolah_Alamat">
<input type="text" data-table="t07_sekolah" data-field="x_Alamat" name="x_Alamat" id="x_Alamat" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->Alamat->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->Alamat->EditValue ?>"<?php echo $t07_sekolah->Alamat->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->Alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->NoTelpHp->Visible) { // NoTelpHp ?>
	<div id="r_NoTelpHp" class="form-group">
		<label id="elh_t07_sekolah_NoTelpHp" for="x_NoTelpHp" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->NoTelpHp->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->NoTelpHp->CellAttributes() ?>>
<span id="el_t07_sekolah_NoTelpHp">
<input type="text" data-table="t07_sekolah" data-field="x_NoTelpHp" name="x_NoTelpHp" id="x_NoTelpHp" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->NoTelpHp->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->NoTelpHp->EditValue ?>"<?php echo $t07_sekolah->NoTelpHp->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->NoTelpHp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->TTD1Nama->Visible) { // TTD1Nama ?>
	<div id="r_TTD1Nama" class="form-group">
		<label id="elh_t07_sekolah_TTD1Nama" for="x_TTD1Nama" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->TTD1Nama->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->TTD1Nama->CellAttributes() ?>>
<span id="el_t07_sekolah_TTD1Nama">
<input type="text" data-table="t07_sekolah" data-field="x_TTD1Nama" name="x_TTD1Nama" id="x_TTD1Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->TTD1Nama->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->TTD1Nama->EditValue ?>"<?php echo $t07_sekolah->TTD1Nama->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->TTD1Nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->TTD1Jabatan->Visible) { // TTD1Jabatan ?>
	<div id="r_TTD1Jabatan" class="form-group">
		<label id="elh_t07_sekolah_TTD1Jabatan" for="x_TTD1Jabatan" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->TTD1Jabatan->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->TTD1Jabatan->CellAttributes() ?>>
<span id="el_t07_sekolah_TTD1Jabatan">
<input type="text" data-table="t07_sekolah" data-field="x_TTD1Jabatan" name="x_TTD1Jabatan" id="x_TTD1Jabatan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->TTD1Jabatan->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->TTD1Jabatan->EditValue ?>"<?php echo $t07_sekolah->TTD1Jabatan->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->TTD1Jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->TTD2Nama->Visible) { // TTD2Nama ?>
	<div id="r_TTD2Nama" class="form-group">
		<label id="elh_t07_sekolah_TTD2Nama" for="x_TTD2Nama" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->TTD2Nama->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->TTD2Nama->CellAttributes() ?>>
<span id="el_t07_sekolah_TTD2Nama">
<input type="text" data-table="t07_sekolah" data-field="x_TTD2Nama" name="x_TTD2Nama" id="x_TTD2Nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->TTD2Nama->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->TTD2Nama->EditValue ?>"<?php echo $t07_sekolah->TTD2Nama->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->TTD2Nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->TTD2Jabatan->Visible) { // TTD2Jabatan ?>
	<div id="r_TTD2Jabatan" class="form-group">
		<label id="elh_t07_sekolah_TTD2Jabatan" for="x_TTD2Jabatan" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->TTD2Jabatan->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->TTD2Jabatan->CellAttributes() ?>>
<span id="el_t07_sekolah_TTD2Jabatan">
<input type="text" data-table="t07_sekolah" data-field="x_TTD2Jabatan" name="x_TTD2Jabatan" id="x_TTD2Jabatan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t07_sekolah->TTD2Jabatan->getPlaceHolder()) ?>" value="<?php echo $t07_sekolah->TTD2Jabatan->EditValue ?>"<?php echo $t07_sekolah->TTD2Jabatan->EditAttributes() ?>>
</span>
<?php echo $t07_sekolah->TTD2Jabatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t07_sekolah->Logo->Visible) { // Logo ?>
	<div id="r_Logo" class="form-group">
		<label id="elh_t07_sekolah_Logo" class="<?php echo $t07_sekolah_edit->LeftColumnClass ?>"><?php echo $t07_sekolah->Logo->FldCaption() ?></label>
		<div class="<?php echo $t07_sekolah_edit->RightColumnClass ?>"><div<?php echo $t07_sekolah->Logo->CellAttributes() ?>>
<span id="el_t07_sekolah_Logo">
<div id="fd_x_Logo">
<span title="<?php echo $t07_sekolah->Logo->FldTitle() ? $t07_sekolah->Logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($t07_sekolah->Logo->ReadOnly || $t07_sekolah->Logo->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="t07_sekolah" data-field="x_Logo" name="x_Logo" id="x_Logo"<?php echo $t07_sekolah->Logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Logo" id= "fn_x_Logo" value="<?php echo $t07_sekolah->Logo->Upload->FileName ?>">
<?php if (@$_POST["fa_x_Logo"] == "0") { ?>
<input type="hidden" name="fa_x_Logo" id= "fa_x_Logo" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_Logo" id= "fa_x_Logo" value="1">
<?php } ?>
<input type="hidden" name="fs_x_Logo" id= "fs_x_Logo" value="50">
<input type="hidden" name="fx_x_Logo" id= "fx_x_Logo" value="<?php echo $t07_sekolah->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Logo" id= "fm_x_Logo" value="<?php echo $t07_sekolah->Logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $t07_sekolah->Logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="t07_sekolah" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t07_sekolah->id->CurrentValue) ?>">
<?php if (!$t07_sekolah_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t07_sekolah_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t07_sekolah_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$t07_sekolah_edit->IsModal) { ?>
<?php if (!isset($t07_sekolah_edit->Pager)) $t07_sekolah_edit->Pager = new cPrevNextPager($t07_sekolah_edit->StartRec, $t07_sekolah_edit->DisplayRecs, $t07_sekolah_edit->TotalRecs, $t07_sekolah_edit->AutoHidePager) ?>
<?php if ($t07_sekolah_edit->Pager->RecordCount > 0 && $t07_sekolah_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t07_sekolah_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t07_sekolah_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t07_sekolah_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t07_sekolah_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t07_sekolah_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t07_sekolah_edit->PageUrl() ?>start=<?php echo $t07_sekolah_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t07_sekolah_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft07_sekolahedit.Init();
</script>
<?php
$t07_sekolah_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t07_sekolah_edit->Page_Terminate();
?>
