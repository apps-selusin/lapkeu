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

$t96_employees_list = NULL; // Initialize page object first

class ct96_employees_list extends ct96_employees {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't96_employees';

	// Page object name
	var $PageObjName = 't96_employees_list';

	// Grid form hidden field names
	var $FormName = 'ft96_employeeslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;
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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t96_employeesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t96_employeesdelete.php";
		$this->MultiUpdateUrl = "t96_employeesupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft96_employeeslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate();
			}
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->EmployeeID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->EmployeeID->Visible = FALSE;
		$this->LastName->SetVisibility();
		$this->FirstName->SetVisibility();
		$this->Title->SetVisibility();
		$this->TitleOfCourtesy->SetVisibility();
		$this->BirthDate->SetVisibility();
		$this->HireDate->SetVisibility();
		$this->Address->SetVisibility();
		$this->City->SetVisibility();
		$this->Region->SetVisibility();
		$this->PostalCode->SetVisibility();
		$this->Country->SetVisibility();
		$this->HomePhone->SetVisibility();
		$this->Extension->SetVisibility();
		$this->_Email->SetVisibility();
		$this->Photo->SetVisibility();
		$this->ReportsTo->SetVisibility();
		$this->Password->SetVisibility();
		$this->UserLevel->SetVisibility();
		$this->Username->SetVisibility();
		$this->Activated->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetupSortOrder();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->EmployeeID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->EmployeeID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->EmployeeID, $bCtrl); // EmployeeID
			$this->UpdateSort($this->LastName, $bCtrl); // LastName
			$this->UpdateSort($this->FirstName, $bCtrl); // FirstName
			$this->UpdateSort($this->Title, $bCtrl); // Title
			$this->UpdateSort($this->TitleOfCourtesy, $bCtrl); // TitleOfCourtesy
			$this->UpdateSort($this->BirthDate, $bCtrl); // BirthDate
			$this->UpdateSort($this->HireDate, $bCtrl); // HireDate
			$this->UpdateSort($this->Address, $bCtrl); // Address
			$this->UpdateSort($this->City, $bCtrl); // City
			$this->UpdateSort($this->Region, $bCtrl); // Region
			$this->UpdateSort($this->PostalCode, $bCtrl); // PostalCode
			$this->UpdateSort($this->Country, $bCtrl); // Country
			$this->UpdateSort($this->HomePhone, $bCtrl); // HomePhone
			$this->UpdateSort($this->Extension, $bCtrl); // Extension
			$this->UpdateSort($this->_Email, $bCtrl); // Email
			$this->UpdateSort($this->Photo, $bCtrl); // Photo
			$this->UpdateSort($this->ReportsTo, $bCtrl); // ReportsTo
			$this->UpdateSort($this->Password, $bCtrl); // Password
			$this->UpdateSort($this->UserLevel, $bCtrl); // UserLevel
			$this->UpdateSort($this->Username, $bCtrl); // Username
			$this->UpdateSort($this->Activated, $bCtrl); // Activated
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->EmployeeID->setSort("");
				$this->LastName->setSort("");
				$this->FirstName->setSort("");
				$this->Title->setSort("");
				$this->TitleOfCourtesy->setSort("");
				$this->BirthDate->setSort("");
				$this->HireDate->setSort("");
				$this->Address->setSort("");
				$this->City->setSort("");
				$this->Region->setSort("");
				$this->PostalCode->setSort("");
				$this->Country->setSort("");
				$this->HomePhone->setSort("");
				$this->Extension->setSort("");
				$this->_Email->setSort("");
				$this->Photo->setSort("");
				$this->ReportsTo->setSort("");
				$this->Password->setSort("");
				$this->UserLevel->setSort("");
				$this->Username->setSort("");
				$this->Activated->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView() && $this->ShowOptionLink('view')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd() && $this->ShowOptionLink('add')) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete() && $this->ShowOptionLink('delete'))
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->EmployeeID->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft96_employeeslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft96_employeeslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft96_employeeslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$user = $row['Username'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = FALSE;
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = FALSE;
					elseif ($UserAction == "resetloginretry")
						$Processed = FALSE;
					elseif ($UserAction == "setpasswordexpired")
						$Processed = FALSE;
					else
						$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
		$this->Password->setDbValue($row['Password']);
		$this->UserLevel->setDbValue($row['UserLevel']);
		$this->Username->setDbValue($row['Username']);
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
		$row['Password'] = NULL;
		$row['UserLevel'] = NULL;
		$row['Username'] = NULL;
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
		$this->Password->DbValue = $row['Password'];
		$this->UserLevel->DbValue = $row['UserLevel'];
		$this->Username->DbValue = $row['Username'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// Password
		// UserLevel
		// Username
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

		// Password
		$this->Password->ViewValue = $this->Password->CurrentValue;
		$this->Password->ViewCustomAttributes = "";

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

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "Y";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "N";
		}
		$this->Activated->ViewCustomAttributes = "";

			// EmployeeID
			$this->EmployeeID->LinkCustomAttributes = "";
			$this->EmployeeID->HrefValue = "";
			$this->EmployeeID->TooltipValue = "";

			// LastName
			$this->LastName->LinkCustomAttributes = "";
			$this->LastName->HrefValue = "";
			$this->LastName->TooltipValue = "";

			// FirstName
			$this->FirstName->LinkCustomAttributes = "";
			$this->FirstName->HrefValue = "";
			$this->FirstName->TooltipValue = "";

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";
			$this->Title->TooltipValue = "";

			// TitleOfCourtesy
			$this->TitleOfCourtesy->LinkCustomAttributes = "";
			$this->TitleOfCourtesy->HrefValue = "";
			$this->TitleOfCourtesy->TooltipValue = "";

			// BirthDate
			$this->BirthDate->LinkCustomAttributes = "";
			$this->BirthDate->HrefValue = "";
			$this->BirthDate->TooltipValue = "";

			// HireDate
			$this->HireDate->LinkCustomAttributes = "";
			$this->HireDate->HrefValue = "";
			$this->HireDate->TooltipValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

			// City
			$this->City->LinkCustomAttributes = "";
			$this->City->HrefValue = "";
			$this->City->TooltipValue = "";

			// Region
			$this->Region->LinkCustomAttributes = "";
			$this->Region->HrefValue = "";
			$this->Region->TooltipValue = "";

			// PostalCode
			$this->PostalCode->LinkCustomAttributes = "";
			$this->PostalCode->HrefValue = "";
			$this->PostalCode->TooltipValue = "";

			// Country
			$this->Country->LinkCustomAttributes = "";
			$this->Country->HrefValue = "";
			$this->Country->TooltipValue = "";

			// HomePhone
			$this->HomePhone->LinkCustomAttributes = "";
			$this->HomePhone->HrefValue = "";
			$this->HomePhone->TooltipValue = "";

			// Extension
			$this->Extension->LinkCustomAttributes = "";
			$this->Extension->HrefValue = "";
			$this->Extension->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Photo
			$this->Photo->LinkCustomAttributes = "";
			$this->Photo->HrefValue = "";
			$this->Photo->TooltipValue = "";

			// ReportsTo
			$this->ReportsTo->LinkCustomAttributes = "";
			$this->ReportsTo->HrefValue = "";
			$this->ReportsTo->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";
			$this->UserLevel->TooltipValue = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";
			$this->Activated->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t96_employees_list)) $t96_employees_list = new ct96_employees_list();

// Page init
$t96_employees_list->Page_Init();

// Page main
$t96_employees_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t96_employees_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft96_employeeslist = new ew_Form("ft96_employeeslist", "list");
ft96_employeeslist.FormKeyCountName = '<?php echo $t96_employees_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft96_employeeslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft96_employeeslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ft96_employeeslist.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t97_userlevels"};
ft96_employeeslist.Lists["x_UserLevel"].Data = "<?php echo $t96_employees_list->UserLevel->LookupFilterQuery(FALSE, "list") ?>";
ft96_employeeslist.Lists["x_Activated[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft96_employeeslist.Lists["x_Activated[]"].Options = <?php echo json_encode($t96_employees_list->Activated->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t96_employees_list->TotalRecs > 0 && $t96_employees_list->ExportOptions->Visible()) { ?>
<?php $t96_employees_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t96_employees_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t96_employees_list->TotalRecs <= 0)
			$t96_employees_list->TotalRecs = $t96_employees->ListRecordCount();
	} else {
		if (!$t96_employees_list->Recordset && ($t96_employees_list->Recordset = $t96_employees_list->LoadRecordset()))
			$t96_employees_list->TotalRecs = $t96_employees_list->Recordset->RecordCount();
	}
	$t96_employees_list->StartRec = 1;
	if ($t96_employees_list->DisplayRecs <= 0 || ($t96_employees->Export <> "" && $t96_employees->ExportAll)) // Display all records
		$t96_employees_list->DisplayRecs = $t96_employees_list->TotalRecs;
	if (!($t96_employees->Export <> "" && $t96_employees->ExportAll))
		$t96_employees_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t96_employees_list->Recordset = $t96_employees_list->LoadRecordset($t96_employees_list->StartRec-1, $t96_employees_list->DisplayRecs);

	// Set no record found message
	if ($t96_employees->CurrentAction == "" && $t96_employees_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t96_employees_list->setWarningMessage(ew_DeniedMsg());
		if ($t96_employees_list->SearchWhere == "0=101")
			$t96_employees_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t96_employees_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t96_employees_list->RenderOtherOptions();
?>
<?php $t96_employees_list->ShowPageHeader(); ?>
<?php
$t96_employees_list->ShowMessage();
?>
<?php if ($t96_employees_list->TotalRecs > 0 || $t96_employees->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t96_employees_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t96_employees">
<div class="box-header ewGridUpperPanel">
<?php if ($t96_employees->CurrentAction <> "gridadd" && $t96_employees->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t96_employees_list->Pager)) $t96_employees_list->Pager = new cPrevNextPager($t96_employees_list->StartRec, $t96_employees_list->DisplayRecs, $t96_employees_list->TotalRecs, $t96_employees_list->AutoHidePager) ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0 && $t96_employees_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t96_employees_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t96_employees_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t96_employees_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="ft96_employeeslist" id="ft96_employeeslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t96_employees_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t96_employees_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t96_employees">
<div id="gmp_t96_employees" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t96_employees_list->TotalRecs > 0 || $t96_employees->CurrentAction == "gridedit") { ?>
<table id="tbl_t96_employeeslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t96_employees_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t96_employees_list->RenderListOptions();

// Render list options (header, left)
$t96_employees_list->ListOptions->Render("header", "left");
?>
<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
	<?php if ($t96_employees->SortUrl($t96_employees->EmployeeID) == "") { ?>
		<th data-name="EmployeeID" class="<?php echo $t96_employees->EmployeeID->HeaderCellClass() ?>"><div id="elh_t96_employees_EmployeeID" class="t96_employees_EmployeeID"><div class="ewTableHeaderCaption"><?php echo $t96_employees->EmployeeID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="EmployeeID" class="<?php echo $t96_employees->EmployeeID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->EmployeeID) ?>',2);"><div id="elh_t96_employees_EmployeeID" class="t96_employees_EmployeeID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->EmployeeID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->EmployeeID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->EmployeeID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->LastName->Visible) { // LastName ?>
	<?php if ($t96_employees->SortUrl($t96_employees->LastName) == "") { ?>
		<th data-name="LastName" class="<?php echo $t96_employees->LastName->HeaderCellClass() ?>"><div id="elh_t96_employees_LastName" class="t96_employees_LastName"><div class="ewTableHeaderCaption"><?php echo $t96_employees->LastName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="LastName" class="<?php echo $t96_employees->LastName->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->LastName) ?>',2);"><div id="elh_t96_employees_LastName" class="t96_employees_LastName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->LastName->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->LastName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->LastName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
	<?php if ($t96_employees->SortUrl($t96_employees->FirstName) == "") { ?>
		<th data-name="FirstName" class="<?php echo $t96_employees->FirstName->HeaderCellClass() ?>"><div id="elh_t96_employees_FirstName" class="t96_employees_FirstName"><div class="ewTableHeaderCaption"><?php echo $t96_employees->FirstName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="FirstName" class="<?php echo $t96_employees->FirstName->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->FirstName) ?>',2);"><div id="elh_t96_employees_FirstName" class="t96_employees_FirstName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->FirstName->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->FirstName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->FirstName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Title->Visible) { // Title ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Title) == "") { ?>
		<th data-name="Title" class="<?php echo $t96_employees->Title->HeaderCellClass() ?>"><div id="elh_t96_employees_Title" class="t96_employees_Title"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Title" class="<?php echo $t96_employees->Title->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Title) ?>',2);"><div id="elh_t96_employees_Title" class="t96_employees_Title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
	<?php if ($t96_employees->SortUrl($t96_employees->TitleOfCourtesy) == "") { ?>
		<th data-name="TitleOfCourtesy" class="<?php echo $t96_employees->TitleOfCourtesy->HeaderCellClass() ?>"><div id="elh_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy"><div class="ewTableHeaderCaption"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TitleOfCourtesy" class="<?php echo $t96_employees->TitleOfCourtesy->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->TitleOfCourtesy) ?>',2);"><div id="elh_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->TitleOfCourtesy->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->TitleOfCourtesy->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->TitleOfCourtesy->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
	<?php if ($t96_employees->SortUrl($t96_employees->BirthDate) == "") { ?>
		<th data-name="BirthDate" class="<?php echo $t96_employees->BirthDate->HeaderCellClass() ?>"><div id="elh_t96_employees_BirthDate" class="t96_employees_BirthDate"><div class="ewTableHeaderCaption"><?php echo $t96_employees->BirthDate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="BirthDate" class="<?php echo $t96_employees->BirthDate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->BirthDate) ?>',2);"><div id="elh_t96_employees_BirthDate" class="t96_employees_BirthDate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->BirthDate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->BirthDate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->BirthDate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
	<?php if ($t96_employees->SortUrl($t96_employees->HireDate) == "") { ?>
		<th data-name="HireDate" class="<?php echo $t96_employees->HireDate->HeaderCellClass() ?>"><div id="elh_t96_employees_HireDate" class="t96_employees_HireDate"><div class="ewTableHeaderCaption"><?php echo $t96_employees->HireDate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HireDate" class="<?php echo $t96_employees->HireDate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->HireDate) ?>',2);"><div id="elh_t96_employees_HireDate" class="t96_employees_HireDate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->HireDate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->HireDate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->HireDate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Address->Visible) { // Address ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Address) == "") { ?>
		<th data-name="Address" class="<?php echo $t96_employees->Address->HeaderCellClass() ?>"><div id="elh_t96_employees_Address" class="t96_employees_Address"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Address->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Address" class="<?php echo $t96_employees->Address->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Address) ?>',2);"><div id="elh_t96_employees_Address" class="t96_employees_Address">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Address->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Address->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Address->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->City->Visible) { // City ?>
	<?php if ($t96_employees->SortUrl($t96_employees->City) == "") { ?>
		<th data-name="City" class="<?php echo $t96_employees->City->HeaderCellClass() ?>"><div id="elh_t96_employees_City" class="t96_employees_City"><div class="ewTableHeaderCaption"><?php echo $t96_employees->City->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="City" class="<?php echo $t96_employees->City->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->City) ?>',2);"><div id="elh_t96_employees_City" class="t96_employees_City">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->City->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->City->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->City->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Region->Visible) { // Region ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Region) == "") { ?>
		<th data-name="Region" class="<?php echo $t96_employees->Region->HeaderCellClass() ?>"><div id="elh_t96_employees_Region" class="t96_employees_Region"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Region->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Region" class="<?php echo $t96_employees->Region->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Region) ?>',2);"><div id="elh_t96_employees_Region" class="t96_employees_Region">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Region->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Region->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Region->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
	<?php if ($t96_employees->SortUrl($t96_employees->PostalCode) == "") { ?>
		<th data-name="PostalCode" class="<?php echo $t96_employees->PostalCode->HeaderCellClass() ?>"><div id="elh_t96_employees_PostalCode" class="t96_employees_PostalCode"><div class="ewTableHeaderCaption"><?php echo $t96_employees->PostalCode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PostalCode" class="<?php echo $t96_employees->PostalCode->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->PostalCode) ?>',2);"><div id="elh_t96_employees_PostalCode" class="t96_employees_PostalCode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->PostalCode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->PostalCode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->PostalCode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Country->Visible) { // Country ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Country) == "") { ?>
		<th data-name="Country" class="<?php echo $t96_employees->Country->HeaderCellClass() ?>"><div id="elh_t96_employees_Country" class="t96_employees_Country"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Country->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Country" class="<?php echo $t96_employees->Country->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Country) ?>',2);"><div id="elh_t96_employees_Country" class="t96_employees_Country">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Country->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Country->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Country->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
	<?php if ($t96_employees->SortUrl($t96_employees->HomePhone) == "") { ?>
		<th data-name="HomePhone" class="<?php echo $t96_employees->HomePhone->HeaderCellClass() ?>"><div id="elh_t96_employees_HomePhone" class="t96_employees_HomePhone"><div class="ewTableHeaderCaption"><?php echo $t96_employees->HomePhone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="HomePhone" class="<?php echo $t96_employees->HomePhone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->HomePhone) ?>',2);"><div id="elh_t96_employees_HomePhone" class="t96_employees_HomePhone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->HomePhone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->HomePhone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->HomePhone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Extension->Visible) { // Extension ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Extension) == "") { ?>
		<th data-name="Extension" class="<?php echo $t96_employees->Extension->HeaderCellClass() ?>"><div id="elh_t96_employees_Extension" class="t96_employees_Extension"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Extension->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Extension" class="<?php echo $t96_employees->Extension->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Extension) ?>',2);"><div id="elh_t96_employees_Extension" class="t96_employees_Extension">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Extension->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Extension->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Extension->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->_Email->Visible) { // Email ?>
	<?php if ($t96_employees->SortUrl($t96_employees->_Email) == "") { ?>
		<th data-name="_Email" class="<?php echo $t96_employees->_Email->HeaderCellClass() ?>"><div id="elh_t96_employees__Email" class="t96_employees__Email"><div class="ewTableHeaderCaption"><?php echo $t96_employees->_Email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_Email" class="<?php echo $t96_employees->_Email->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->_Email) ?>',2);"><div id="elh_t96_employees__Email" class="t96_employees__Email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->_Email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->_Email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->_Email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Photo->Visible) { // Photo ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Photo) == "") { ?>
		<th data-name="Photo" class="<?php echo $t96_employees->Photo->HeaderCellClass() ?>"><div id="elh_t96_employees_Photo" class="t96_employees_Photo"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Photo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Photo" class="<?php echo $t96_employees->Photo->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Photo) ?>',2);"><div id="elh_t96_employees_Photo" class="t96_employees_Photo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Photo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Photo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Photo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
	<?php if ($t96_employees->SortUrl($t96_employees->ReportsTo) == "") { ?>
		<th data-name="ReportsTo" class="<?php echo $t96_employees->ReportsTo->HeaderCellClass() ?>"><div id="elh_t96_employees_ReportsTo" class="t96_employees_ReportsTo"><div class="ewTableHeaderCaption"><?php echo $t96_employees->ReportsTo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ReportsTo" class="<?php echo $t96_employees->ReportsTo->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->ReportsTo) ?>',2);"><div id="elh_t96_employees_ReportsTo" class="t96_employees_ReportsTo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->ReportsTo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->ReportsTo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->ReportsTo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Password->Visible) { // Password ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Password) == "") { ?>
		<th data-name="Password" class="<?php echo $t96_employees->Password->HeaderCellClass() ?>"><div id="elh_t96_employees_Password" class="t96_employees_Password"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Password->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Password" class="<?php echo $t96_employees->Password->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Password) ?>',2);"><div id="elh_t96_employees_Password" class="t96_employees_Password">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Password->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Password->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Password->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
	<?php if ($t96_employees->SortUrl($t96_employees->UserLevel) == "") { ?>
		<th data-name="UserLevel" class="<?php echo $t96_employees->UserLevel->HeaderCellClass() ?>"><div id="elh_t96_employees_UserLevel" class="t96_employees_UserLevel"><div class="ewTableHeaderCaption"><?php echo $t96_employees->UserLevel->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="UserLevel" class="<?php echo $t96_employees->UserLevel->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->UserLevel) ?>',2);"><div id="elh_t96_employees_UserLevel" class="t96_employees_UserLevel">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->UserLevel->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->UserLevel->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->UserLevel->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Username->Visible) { // Username ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Username) == "") { ?>
		<th data-name="Username" class="<?php echo $t96_employees->Username->HeaderCellClass() ?>"><div id="elh_t96_employees_Username" class="t96_employees_Username"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Username->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Username" class="<?php echo $t96_employees->Username->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Username) ?>',2);"><div id="elh_t96_employees_Username" class="t96_employees_Username">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Username->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Username->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Username->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t96_employees->Activated->Visible) { // Activated ?>
	<?php if ($t96_employees->SortUrl($t96_employees->Activated) == "") { ?>
		<th data-name="Activated" class="<?php echo $t96_employees->Activated->HeaderCellClass() ?>"><div id="elh_t96_employees_Activated" class="t96_employees_Activated"><div class="ewTableHeaderCaption"><?php echo $t96_employees->Activated->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Activated" class="<?php echo $t96_employees->Activated->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t96_employees->SortUrl($t96_employees->Activated) ?>',2);"><div id="elh_t96_employees_Activated" class="t96_employees_Activated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t96_employees->Activated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t96_employees->Activated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t96_employees->Activated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t96_employees_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t96_employees->ExportAll && $t96_employees->Export <> "") {
	$t96_employees_list->StopRec = $t96_employees_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t96_employees_list->TotalRecs > $t96_employees_list->StartRec + $t96_employees_list->DisplayRecs - 1)
		$t96_employees_list->StopRec = $t96_employees_list->StartRec + $t96_employees_list->DisplayRecs - 1;
	else
		$t96_employees_list->StopRec = $t96_employees_list->TotalRecs;
}
$t96_employees_list->RecCnt = $t96_employees_list->StartRec - 1;
if ($t96_employees_list->Recordset && !$t96_employees_list->Recordset->EOF) {
	$t96_employees_list->Recordset->MoveFirst();
	$bSelectLimit = $t96_employees_list->UseSelectLimit;
	if (!$bSelectLimit && $t96_employees_list->StartRec > 1)
		$t96_employees_list->Recordset->Move($t96_employees_list->StartRec - 1);
} elseif (!$t96_employees->AllowAddDeleteRow && $t96_employees_list->StopRec == 0) {
	$t96_employees_list->StopRec = $t96_employees->GridAddRowCount;
}

// Initialize aggregate
$t96_employees->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t96_employees->ResetAttrs();
$t96_employees_list->RenderRow();
while ($t96_employees_list->RecCnt < $t96_employees_list->StopRec) {
	$t96_employees_list->RecCnt++;
	if (intval($t96_employees_list->RecCnt) >= intval($t96_employees_list->StartRec)) {
		$t96_employees_list->RowCnt++;

		// Set up key count
		$t96_employees_list->KeyCount = $t96_employees_list->RowIndex;

		// Init row class and style
		$t96_employees->ResetAttrs();
		$t96_employees->CssClass = "";
		if ($t96_employees->CurrentAction == "gridadd") {
		} else {
			$t96_employees_list->LoadRowValues($t96_employees_list->Recordset); // Load row values
		}
		$t96_employees->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t96_employees->RowAttrs = array_merge($t96_employees->RowAttrs, array('data-rowindex'=>$t96_employees_list->RowCnt, 'id'=>'r' . $t96_employees_list->RowCnt . '_t96_employees', 'data-rowtype'=>$t96_employees->RowType));

		// Render row
		$t96_employees_list->RenderRow();

		// Render list options
		$t96_employees_list->RenderListOptions();
?>
	<tr<?php echo $t96_employees->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t96_employees_list->ListOptions->Render("body", "left", $t96_employees_list->RowCnt);
?>
	<?php if ($t96_employees->EmployeeID->Visible) { // EmployeeID ?>
		<td data-name="EmployeeID"<?php echo $t96_employees->EmployeeID->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_EmployeeID" class="t96_employees_EmployeeID">
<span<?php echo $t96_employees->EmployeeID->ViewAttributes() ?>>
<?php echo $t96_employees->EmployeeID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->LastName->Visible) { // LastName ?>
		<td data-name="LastName"<?php echo $t96_employees->LastName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_LastName" class="t96_employees_LastName">
<span<?php echo $t96_employees->LastName->ViewAttributes() ?>>
<?php echo $t96_employees->LastName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->FirstName->Visible) { // FirstName ?>
		<td data-name="FirstName"<?php echo $t96_employees->FirstName->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_FirstName" class="t96_employees_FirstName">
<span<?php echo $t96_employees->FirstName->ViewAttributes() ?>>
<?php echo $t96_employees->FirstName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Title->Visible) { // Title ?>
		<td data-name="Title"<?php echo $t96_employees->Title->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Title" class="t96_employees_Title">
<span<?php echo $t96_employees->Title->ViewAttributes() ?>>
<?php echo $t96_employees->Title->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->TitleOfCourtesy->Visible) { // TitleOfCourtesy ?>
		<td data-name="TitleOfCourtesy"<?php echo $t96_employees->TitleOfCourtesy->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_TitleOfCourtesy" class="t96_employees_TitleOfCourtesy">
<span<?php echo $t96_employees->TitleOfCourtesy->ViewAttributes() ?>>
<?php echo $t96_employees->TitleOfCourtesy->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->BirthDate->Visible) { // BirthDate ?>
		<td data-name="BirthDate"<?php echo $t96_employees->BirthDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_BirthDate" class="t96_employees_BirthDate">
<span<?php echo $t96_employees->BirthDate->ViewAttributes() ?>>
<?php echo $t96_employees->BirthDate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->HireDate->Visible) { // HireDate ?>
		<td data-name="HireDate"<?php echo $t96_employees->HireDate->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_HireDate" class="t96_employees_HireDate">
<span<?php echo $t96_employees->HireDate->ViewAttributes() ?>>
<?php echo $t96_employees->HireDate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Address->Visible) { // Address ?>
		<td data-name="Address"<?php echo $t96_employees->Address->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Address" class="t96_employees_Address">
<span<?php echo $t96_employees->Address->ViewAttributes() ?>>
<?php echo $t96_employees->Address->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->City->Visible) { // City ?>
		<td data-name="City"<?php echo $t96_employees->City->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_City" class="t96_employees_City">
<span<?php echo $t96_employees->City->ViewAttributes() ?>>
<?php echo $t96_employees->City->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Region->Visible) { // Region ?>
		<td data-name="Region"<?php echo $t96_employees->Region->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Region" class="t96_employees_Region">
<span<?php echo $t96_employees->Region->ViewAttributes() ?>>
<?php echo $t96_employees->Region->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->PostalCode->Visible) { // PostalCode ?>
		<td data-name="PostalCode"<?php echo $t96_employees->PostalCode->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_PostalCode" class="t96_employees_PostalCode">
<span<?php echo $t96_employees->PostalCode->ViewAttributes() ?>>
<?php echo $t96_employees->PostalCode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Country->Visible) { // Country ?>
		<td data-name="Country"<?php echo $t96_employees->Country->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Country" class="t96_employees_Country">
<span<?php echo $t96_employees->Country->ViewAttributes() ?>>
<?php echo $t96_employees->Country->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->HomePhone->Visible) { // HomePhone ?>
		<td data-name="HomePhone"<?php echo $t96_employees->HomePhone->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_HomePhone" class="t96_employees_HomePhone">
<span<?php echo $t96_employees->HomePhone->ViewAttributes() ?>>
<?php echo $t96_employees->HomePhone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Extension->Visible) { // Extension ?>
		<td data-name="Extension"<?php echo $t96_employees->Extension->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Extension" class="t96_employees_Extension">
<span<?php echo $t96_employees->Extension->ViewAttributes() ?>>
<?php echo $t96_employees->Extension->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->_Email->Visible) { // Email ?>
		<td data-name="_Email"<?php echo $t96_employees->_Email->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees__Email" class="t96_employees__Email">
<span<?php echo $t96_employees->_Email->ViewAttributes() ?>>
<?php echo $t96_employees->_Email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Photo->Visible) { // Photo ?>
		<td data-name="Photo"<?php echo $t96_employees->Photo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Photo" class="t96_employees_Photo">
<span<?php echo $t96_employees->Photo->ViewAttributes() ?>>
<?php echo $t96_employees->Photo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->ReportsTo->Visible) { // ReportsTo ?>
		<td data-name="ReportsTo"<?php echo $t96_employees->ReportsTo->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_ReportsTo" class="t96_employees_ReportsTo">
<span<?php echo $t96_employees->ReportsTo->ViewAttributes() ?>>
<?php echo $t96_employees->ReportsTo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Password->Visible) { // Password ?>
		<td data-name="Password"<?php echo $t96_employees->Password->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Password" class="t96_employees_Password">
<span<?php echo $t96_employees->Password->ViewAttributes() ?>>
<?php echo $t96_employees->Password->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->UserLevel->Visible) { // UserLevel ?>
		<td data-name="UserLevel"<?php echo $t96_employees->UserLevel->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_UserLevel" class="t96_employees_UserLevel">
<span<?php echo $t96_employees->UserLevel->ViewAttributes() ?>>
<?php echo $t96_employees->UserLevel->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Username->Visible) { // Username ?>
		<td data-name="Username"<?php echo $t96_employees->Username->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Username" class="t96_employees_Username">
<span<?php echo $t96_employees->Username->ViewAttributes() ?>>
<?php echo $t96_employees->Username->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t96_employees->Activated->Visible) { // Activated ?>
		<td data-name="Activated"<?php echo $t96_employees->Activated->CellAttributes() ?>>
<span id="el<?php echo $t96_employees_list->RowCnt ?>_t96_employees_Activated" class="t96_employees_Activated">
<span<?php echo $t96_employees->Activated->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($t96_employees->Activated->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $t96_employees->Activated->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $t96_employees->Activated->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t96_employees_list->ListOptions->Render("body", "right", $t96_employees_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t96_employees->CurrentAction <> "gridadd")
		$t96_employees_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t96_employees->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t96_employees_list->Recordset)
	$t96_employees_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t96_employees->CurrentAction <> "gridadd" && $t96_employees->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t96_employees_list->Pager)) $t96_employees_list->Pager = new cPrevNextPager($t96_employees_list->StartRec, $t96_employees_list->DisplayRecs, $t96_employees_list->TotalRecs, $t96_employees_list->AutoHidePager) ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0 && $t96_employees_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t96_employees_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t96_employees_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t96_employees_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t96_employees_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t96_employees_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t96_employees_list->PageUrl() ?>start=<?php echo $t96_employees_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t96_employees_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t96_employees_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t96_employees_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t96_employees_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t96_employees_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t96_employees_list->TotalRecs == 0 && $t96_employees->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t96_employees_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft96_employeeslist.Init();
</script>
<?php
$t96_employees_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t96_employees_list->Page_Terminate();
?>
