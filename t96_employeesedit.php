<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$t96_employees_edit = NULL; // Initialize page object first

class ct96_employees_edit extends ct96_employees {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't96_employees';

	// Page object name
	var $PageObjName = 't96_employees_edit';

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

		// Table object (t96_employees)
		if (!isset($GLOBALS["t96_employees"]) || get_class($GLOBALS["t96_employees"]) == "ct96_employees") {
			$GLOBALS["t96_employees"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t96_employees"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't96_employees', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t96_employeeslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("t96_employeeslist.php"));
			}
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->LastName->SetVisibility();
		$this->FirstName->SetVisibility();
		$this->UserLevel->SetVisibility();
		$this->Username->SetVisibility();
		$this->Password->SetVisibility();

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
		global $EW_EXPORT, $t96_employees;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t96_employees);
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
					if ($pageName == "t96_employeesview.php")
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
			if ($objForm->HasValue("x_EmployeeID")) {
				$this->EmployeeID->setFormValue($objForm->GetValue("x_EmployeeID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["EmployeeID"])) {
				$this->EmployeeID->setQueryStringValue($_GET["EmployeeID"]);
				$loadByQuery = TRUE;
			} else {
				$this->EmployeeID->CurrentValue = NULL;
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
			$this->Page_Terminate("t96_employeeslist.php"); // Return to list page
		} elseif ($loadByPosition) { // Load record by position
			$this->SetupStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$this->Recordset->Move($this->StartRec-1);
				$loaded = TRUE;
			}
		} else { // Match key values
			if (!is_null($this->EmployeeID->CurrentValue)) {
				while (!$this->Recordset->EOF) {
					if (strval($this->EmployeeID->CurrentValue) == strval($this->Recordset->fields('EmployeeID'))) {
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
					$this->Page_Terminate("t96_employeeslist.php"); // Return to list page
				} else {
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t96_employeeslist.php")
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
		if (!$this->LastName->FldIsDetailKey) {
			$this->LastName->setFormValue($objForm->GetValue("x_LastName"));
		}
		if (!$this->FirstName->FldIsDetailKey) {
			$this->FirstName->setFormValue($objForm->GetValue("x_FirstName"));
		}
		if (!$this->UserLevel->FldIsDetailKey) {
			$this->UserLevel->setFormValue($objForm->GetValue("x_UserLevel"));
		}
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		if (!$this->EmployeeID->FldIsDetailKey)
			$this->EmployeeID->setFormValue($objForm->GetValue("x_EmployeeID"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->EmployeeID->CurrentValue = $this->EmployeeID->FormValue;
		$this->LastName->CurrentValue = $this->LastName->FormValue;
		$this->FirstName->CurrentValue = $this->FirstName->FormValue;
		$this->UserLevel->CurrentValue = $this->UserLevel->FormValue;
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('edit');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
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
		$this->EmployeeID->setDbValue($row['EmployeeID']);
		$this->LastName->setDbValue($row['LastName']);
		$this->FirstName->setDbValue($row['FirstName']);
		$this->Title->setDbValue($row['Title']);
		$this->TitleOfCourtesy->setDbValue($row['TitleOfCourtesy']);
		$this->BirthDate->setDbValue($row['BirthDate']);
		$this->HireDate->setDbValue($row['HireDate']);
		$this->Address->setDbValue($row['Address']);
		$this->City->setDbValue($row['City']);
		$this->Region->setDbValue($row['Region']);
		$this->PostalCode->setDbValue($row['PostalCode']);
		$this->Country->setDbValue($row['Country']);
		$this->HomePhone->setDbValue($row['HomePhone']);
		$this->Extension->setDbValue($row['Extension']);
		$this->_Email->setDbValue($row['Email']);
		$this->Photo->setDbValue($row['Photo']);
		$this->Notes->setDbValue($row['Notes']);
		$this->ReportsTo->setDbValue($row['ReportsTo']);
		$this->UserLevel->setDbValue($row['UserLevel']);
		$this->Username->setDbValue($row['Username']);
		$this->Password->setDbValue($row['Password']);
		$this->Activated->setDbValue($row['Activated']);
		$this->Profile->setDbValue($row['Profile']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['EmployeeID'] = NULL;
		$row['LastName'] = NULL;
		$row['FirstName'] = NULL;
		$row['Title'] = NULL;
		$row['TitleOfCourtesy'] = NULL;
		$row['BirthDate'] = NULL;
		$row['HireDate'] = NULL;
		$row['Address'] = NULL;
		$row['City'] = NULL;
		$row['Region'] = NULL;
		$row['PostalCode'] = NULL;
		$row['Country'] = NULL;
		$row['HomePhone'] = NULL;
		$row['Extension'] = NULL;
		$row['Email'] = NULL;
		$row['Photo'] = NULL;
		$row['Notes'] = NULL;
		$row['ReportsTo'] = NULL;
		$row['UserLevel'] = NULL;
		$row['Username'] = NULL;
		$row['Password'] = NULL;
		$row['Activated'] = NULL;
		$row['Profile'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->EmployeeID->DbValue = $row['EmployeeID'];
		$this->LastName->DbValue = $row['LastName'];
		$this->FirstName->DbValue = $row['FirstName'];
		$this->Title->DbValue = $row['Title'];
		$this->TitleOfCourtesy->DbValue = $row['TitleOfCourtesy'];
		$this->BirthDate->DbValue = $row['BirthDate'];
		$this->HireDate->DbValue = $row['HireDate'];
		$this->Address->DbValue = $row['Address'];
		$this->City->DbValue = $row['City'];
		$this->Region->DbValue = $row['Region'];
		$this->PostalCode->DbValue = $row['PostalCode'];
		$this->Country->DbValue = $row['Country'];
		$this->HomePhone->DbValue = $row['HomePhone'];
		$this->Extension->DbValue = $row['Extension'];
		$this->_Email->DbValue = $row['Email'];
		$this->Photo->DbValue = $row['Photo'];
		$this->Notes->DbValue = $row['Notes'];
		$this->ReportsTo->DbValue = $row['ReportsTo'];
		$this->UserLevel->DbValue = $row['UserLevel'];
		$this->Username->DbValue = $row['Username'];
		$this->Password->DbValue = $row['Password'];
		$this->Activated->DbValue = $row['Activated'];
		$this->Profile->DbValue = $row['Profile'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("EmployeeID")) <> "")
			$this->EmployeeID->CurrentValue = $this->getKey("EmployeeID"); // EmployeeID
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
		// EmployeeID
		// LastName
		// FirstName
		// Title
		// TitleOfCourtesy
		// BirthDate
		// HireDate
		// Address
		// City
		// Region
		// PostalCode
		// Country
		// HomePhone
		// Extension
		// Email
		// Photo
		// Notes
		// ReportsTo
		// UserLevel
		// Username
		// Password
		// Activated
		// Profile

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// EmployeeID
		$this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
		$this->EmployeeID->ViewCustomAttributes = "";

		// LastName
		$this->LastName->ViewValue = $this->LastName->CurrentValue;
		$this->LastName->ViewCustomAttributes = "";

		// FirstName
		$this->FirstName->ViewValue = $this->FirstName->CurrentValue;
		$this->FirstName->ViewCustomAttributes = "";

		// Title
		$this->Title->ViewValue = $this->Title->CurrentValue;
		$this->Title->ViewCustomAttributes = "";

		// TitleOfCourtesy
		$this->TitleOfCourtesy->ViewValue = $this->TitleOfCourtesy->CurrentValue;
		$this->TitleOfCourtesy->ViewCustomAttributes = "";

		// BirthDate
		$this->BirthDate->ViewValue = $this->BirthDate->CurrentValue;
		$this->BirthDate->ViewValue = ew_FormatDateTime($this->BirthDate->ViewValue, 0);
		$this->BirthDate->ViewCustomAttributes = "";

		// HireDate
		$this->HireDate->ViewValue = $this->HireDate->CurrentValue;
		$this->HireDate->ViewValue = ew_FormatDateTime($this->HireDate->ViewValue, 0);
		$this->HireDate->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// City
		$this->City->ViewValue = $this->City->CurrentValue;
		$this->City->ViewCustomAttributes = "";

		// Region
		$this->Region->ViewValue = $this->Region->CurrentValue;
		$this->Region->ViewCustomAttributes = "";

		// PostalCode
		$this->PostalCode->ViewValue = $this->PostalCode->CurrentValue;
		$this->PostalCode->ViewCustomAttributes = "";

		// Country
		$this->Country->ViewValue = $this->Country->CurrentValue;
		$this->Country->ViewCustomAttributes = "";

		// HomePhone
		$this->HomePhone->ViewValue = $this->HomePhone->CurrentValue;
		$this->HomePhone->ViewCustomAttributes = "";

		// Extension
		$this->Extension->ViewValue = $this->Extension->CurrentValue;
		$this->Extension->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Photo
		$this->Photo->ViewValue = $this->Photo->CurrentValue;
		$this->Photo->ViewCustomAttributes = "";

		// ReportsTo
		$this->ReportsTo->ViewValue = $this->ReportsTo->CurrentValue;
		$this->ReportsTo->ViewCustomAttributes = "";

		// UserLevel
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->UserLevel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t97_userlevels`";
		$sWhereWrk = "";
		$this->UserLevel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->UserLevel->ViewValue = $this->UserLevel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->UserLevel->ViewValue = $this->UserLevel->CurrentValue;
			}
		} else {
			$this->UserLevel->ViewValue = NULL;
		}
		} else {
			$this->UserLevel->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->UserLevel->ViewCustomAttributes = "";

		// Username
		$this->Username->ViewValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "Y";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "N";
		}
		$this->Activated->ViewCustomAttributes = "";

			// LastName
			$this->LastName->LinkCustomAttributes = "";
			$this->LastName->HrefValue = "";
			$this->LastName->TooltipValue = "";

			// FirstName
			$this->FirstName->LinkCustomAttributes = "";
			$this->FirstName->HrefValue = "";
			$this->FirstName->TooltipValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";
			$this->UserLevel->TooltipValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// LastName
			$this->LastName->EditAttrs["class"] = "form-control";
			$this->LastName->EditCustomAttributes = "";
			$this->LastName->EditValue = ew_HtmlEncode($this->LastName->CurrentValue);
			$this->LastName->PlaceHolder = ew_RemoveHtml($this->LastName->FldCaption());

			// FirstName
			$this->FirstName->EditAttrs["class"] = "form-control";
			$this->FirstName->EditCustomAttributes = "";
			$this->FirstName->EditValue = ew_HtmlEncode($this->FirstName->CurrentValue);
			$this->FirstName->PlaceHolder = ew_RemoveHtml($this->FirstName->FldCaption());

			// UserLevel
			$this->UserLevel->EditAttrs["class"] = "form-control";
			$this->UserLevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->UserLevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->UserLevel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t97_userlevels`";
			$sWhereWrk = "";
			$this->UserLevel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->UserLevel->EditValue = $arwrk;
			}

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

			// Password
			$this->Password->EditAttrs["class"] = "form-control";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// Edit refer script
			// LastName

			$this->LastName->LinkCustomAttributes = "";
			$this->LastName->HrefValue = "";

			// FirstName
			$this->FirstName->LinkCustomAttributes = "";
			$this->FirstName->HrefValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
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
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Username->FldCaption(), $this->Username->ReqErrMsg));
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Password->FldCaption(), $this->Password->ReqErrMsg));
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
		if ($this->Username->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Username` = '" . ew_AdjustSql($this->Username->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Username->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Username->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// LastName
			$this->LastName->SetDbValueDef($rsnew, $this->LastName->CurrentValue, NULL, $this->LastName->ReadOnly);

			// FirstName
			$this->FirstName->SetDbValueDef($rsnew, $this->FirstName->CurrentValue, NULL, $this->FirstName->ReadOnly);

			// UserLevel
			if ($Security->CanAdmin()) { // System admin
			$this->UserLevel->SetDbValueDef($rsnew, $this->UserLevel->CurrentValue, NULL, $this->UserLevel->ReadOnly);
			}

			// Username
			$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", $this->Username->ReadOnly);

			// Password
			$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", $this->Password->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('Password') == $this->Password->CurrentValue));

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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->EmployeeID->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t96_employeeslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_UserLevel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t97_userlevels`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($t96_employees_edit)) $t96_employees_edit = new ct96_employees_edit();

// Page init
$t96_employees_edit->Page_Init();

// Page main
$t96_employees_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t96_employees_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft96_employeesedit = new ew_Form("ft96_employeesedit", "edit");

// Validate form
ft96_employeesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t96_employees->Username->FldCaption(), $t96_employees->Username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t96_employees->Password->FldCaption(), $t96_employees->Password->ReqErrMsg)) ?>");

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
ft96_employeesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft96_employeesedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft96_employeesedit.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t97_userlevels"};
ft96_employeesedit.Lists["x_UserLevel"].Data = "<?php echo $t96_employees_edit->UserLevel->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t96_employees_edit->ShowPageHeader(); ?>
<?php
$t96_employees_edit->ShowMessage();
?>
<?php if (!$t96_employees_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t96_employees_edit->Pager)) $t96_employees_edit->Pager = new cPrevNextPager($t96_employees_edit->StartRec, $t96_employees_edit->DisplayRecs, $t96_employees_edit->TotalRecs, $t96_employees_edit->AutoHidePager) ?>
<?php if ($t96_employees_edit->Pager->RecordCount > 0 && $t96_employees_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ft96_employeesedit" id="ft96_employeesedit" class="<?php echo $t96_employees_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t96_employees_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t96_employees_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t96_employees">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($t96_employees_edit->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
	<div id="r_LastName" class="form-group">
		<label id="elh_t96_employees_LastName" for="x_LastName" class="<?php echo $t96_employees_edit->LeftColumnClass ?>"><?php echo $t96_employees->LastName->FldCaption() ?></label>
		<div class="<?php echo $t96_employees_edit->RightColumnClass ?>"><div<?php echo $t96_employees->LastName->CellAttributes() ?>>
<span id="el_t96_employees_LastName">
<input type="text" data-table="t96_employees" data-field="x_LastName" name="x_LastName" id="x_LastName" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($t96_employees->LastName->getPlaceHolder()) ?>" value="<?php echo $t96_employees->LastName->EditValue ?>"<?php echo $t96_employees->LastName->EditAttributes() ?>>
</span>
<?php echo $t96_employees->LastName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
	<div id="r_FirstName" class="form-group">
		<label id="elh_t96_employees_FirstName" for="x_FirstName" class="<?php echo $t96_employees_edit->LeftColumnClass ?>"><?php echo $t96_employees->FirstName->FldCaption() ?></label>
		<div class="<?php echo $t96_employees_edit->RightColumnClass ?>"><div<?php echo $t96_employees->FirstName->CellAttributes() ?>>
<span id="el_t96_employees_FirstName">
<input type="text" data-table="t96_employees" data-field="x_FirstName" name="x_FirstName" id="x_FirstName" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t96_employees->FirstName->getPlaceHolder()) ?>" value="<?php echo $t96_employees->FirstName->EditValue ?>"<?php echo $t96_employees->FirstName->EditAttributes() ?>>
</span>
<?php echo $t96_employees->FirstName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
	<div id="r_UserLevel" class="form-group">
		<label id="elh_t96_employees_UserLevel" for="x_UserLevel" class="<?php echo $t96_employees_edit->LeftColumnClass ?>"><?php echo $t96_employees->UserLevel->FldCaption() ?></label>
		<div class="<?php echo $t96_employees_edit->RightColumnClass ?>"><div<?php echo $t96_employees->UserLevel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_t96_employees_UserLevel">
<p class="form-control-static"><?php echo $t96_employees->UserLevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_t96_employees_UserLevel">
<select data-table="t96_employees" data-field="x_UserLevel" data-value-separator="<?php echo $t96_employees->UserLevel->DisplayValueSeparatorAttribute() ?>" id="x_UserLevel" name="x_UserLevel"<?php echo $t96_employees->UserLevel->EditAttributes() ?>>
<?php echo $t96_employees->UserLevel->SelectOptionListHtml("x_UserLevel") ?>
</select>
</span>
<?php } ?>
<?php echo $t96_employees->UserLevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Username->Visible) { // Username ?>
	<div id="r_Username" class="form-group">
		<label id="elh_t96_employees_Username" for="x_Username" class="<?php echo $t96_employees_edit->LeftColumnClass ?>"><?php echo $t96_employees->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t96_employees_edit->RightColumnClass ?>"><div<?php echo $t96_employees->Username->CellAttributes() ?>>
<span id="el_t96_employees_Username">
<input type="text" data-table="t96_employees" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($t96_employees->Username->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Username->EditValue ?>"<?php echo $t96_employees->Username->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t96_employees->Password->Visible) { // Password ?>
	<div id="r_Password" class="form-group">
		<label id="elh_t96_employees_Password" for="x_Password" class="<?php echo $t96_employees_edit->LeftColumnClass ?>"><?php echo $t96_employees->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $t96_employees_edit->RightColumnClass ?>"><div<?php echo $t96_employees->Password->CellAttributes() ?>>
<span id="el_t96_employees_Password">
<input type="text" data-table="t96_employees" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t96_employees->Password->getPlaceHolder()) ?>" value="<?php echo $t96_employees->Password->EditValue ?>"<?php echo $t96_employees->Password->EditAttributes() ?>>
</span>
<?php echo $t96_employees->Password->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<input type="hidden" data-table="t96_employees" data-field="x_EmployeeID" name="x_EmployeeID" id="x_EmployeeID" value="<?php echo ew_HtmlEncode($t96_employees->EmployeeID->CurrentValue) ?>">
<?php if (!$t96_employees_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $t96_employees_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t96_employees_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$t96_employees_edit->IsModal) { ?>
<?php if (!isset($t96_employees_edit->Pager)) $t96_employees_edit->Pager = new cPrevNextPager($t96_employees_edit->StartRec, $t96_employees_edit->DisplayRecs, $t96_employees_edit->TotalRecs, $t96_employees_edit->AutoHidePager) ?>
<?php if ($t96_employees_edit->Pager->RecordCount > 0 && $t96_employees_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_edit->PageUrl() ?>start=<?php echo $t96_employees_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ft96_employeesedit.Init();
</script>
<?php
$t96_employees_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t96_employees_edit->Page_Terminate();
?>
