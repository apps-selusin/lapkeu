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

$t07_sekolah_list = NULL; // Initialize page object first

class ct07_sekolah_list extends ct07_sekolah {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 't07_sekolah';

	// Page object name
	var $PageObjName = 't07_sekolah_list';

	// Grid form hidden field names
	var $FormName = 'ft07_sekolahlist';
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

		// Table object (t07_sekolah)
		if (!isset($GLOBALS["t07_sekolah"]) || get_class($GLOBALS["t07_sekolah"]) == "ct07_sekolah") {
			$GLOBALS["t07_sekolah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t07_sekolah"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t07_sekolahadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t07_sekolahdelete.php";
		$this->MultiUpdateUrl = "t07_sekolahupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft07_sekolahlistsrch";

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
		$this->Nama->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->NoTelpHp->SetVisibility();
		$this->TTD1Nama->SetVisibility();
		$this->TTD1Jabatan->SetVisibility();
		$this->TTD2Nama->SetVisibility();
		$this->TTD2Jabatan->SetVisibility();

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
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
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
			$this->UpdateSort($this->Nama, $bCtrl); // Nama
			$this->UpdateSort($this->Alamat, $bCtrl); // Alamat
			$this->UpdateSort($this->NoTelpHp, $bCtrl); // NoTelpHp
			$this->UpdateSort($this->TTD1Nama, $bCtrl); // TTD1Nama
			$this->UpdateSort($this->TTD1Jabatan, $bCtrl); // TTD1Jabatan
			$this->UpdateSort($this->TTD2Nama, $bCtrl); // TTD2Nama
			$this->UpdateSort($this->TTD2Jabatan, $bCtrl); // TTD2Jabatan
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
				$this->Nama->setSort("");
				$this->Alamat->setSort("");
				$this->NoTelpHp->setSort("");
				$this->TTD1Nama->setSort("");
				$this->TTD1Jabatan->setSort("");
				$this->TTD2Nama->setSort("");
				$this->TTD2Jabatan->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
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

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft07_sekolahlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft07_sekolahlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft07_sekolahlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
if (!isset($t07_sekolah_list)) $t07_sekolah_list = new ct07_sekolah_list();

// Page init
$t07_sekolah_list->Page_Init();

// Page main
$t07_sekolah_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t07_sekolah_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft07_sekolahlist = new ew_Form("ft07_sekolahlist", "list");
ft07_sekolahlist.FormKeyCountName = '<?php echo $t07_sekolah_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft07_sekolahlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft07_sekolahlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($t07_sekolah_list->TotalRecs > 0 && $t07_sekolah_list->ExportOptions->Visible()) { ?>
<?php $t07_sekolah_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $t07_sekolah_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t07_sekolah_list->TotalRecs <= 0)
			$t07_sekolah_list->TotalRecs = $t07_sekolah->ListRecordCount();
	} else {
		if (!$t07_sekolah_list->Recordset && ($t07_sekolah_list->Recordset = $t07_sekolah_list->LoadRecordset()))
			$t07_sekolah_list->TotalRecs = $t07_sekolah_list->Recordset->RecordCount();
	}
	$t07_sekolah_list->StartRec = 1;
	if ($t07_sekolah_list->DisplayRecs <= 0 || ($t07_sekolah->Export <> "" && $t07_sekolah->ExportAll)) // Display all records
		$t07_sekolah_list->DisplayRecs = $t07_sekolah_list->TotalRecs;
	if (!($t07_sekolah->Export <> "" && $t07_sekolah->ExportAll))
		$t07_sekolah_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t07_sekolah_list->Recordset = $t07_sekolah_list->LoadRecordset($t07_sekolah_list->StartRec-1, $t07_sekolah_list->DisplayRecs);

	// Set no record found message
	if ($t07_sekolah->CurrentAction == "" && $t07_sekolah_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t07_sekolah_list->setWarningMessage(ew_DeniedMsg());
		if ($t07_sekolah_list->SearchWhere == "0=101")
			$t07_sekolah_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t07_sekolah_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t07_sekolah_list->RenderOtherOptions();
?>
<?php $t07_sekolah_list->ShowPageHeader(); ?>
<?php
$t07_sekolah_list->ShowMessage();
?>
<?php if ($t07_sekolah_list->TotalRecs > 0 || $t07_sekolah->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t07_sekolah_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t07_sekolah">
<div class="box-header ewGridUpperPanel">
<?php if ($t07_sekolah->CurrentAction <> "gridadd" && $t07_sekolah->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t07_sekolah_list->Pager)) $t07_sekolah_list->Pager = new cPrevNextPager($t07_sekolah_list->StartRec, $t07_sekolah_list->DisplayRecs, $t07_sekolah_list->TotalRecs, $t07_sekolah_list->AutoHidePager) ?>
<?php if ($t07_sekolah_list->Pager->RecordCount > 0 && $t07_sekolah_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t07_sekolah_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t07_sekolah_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t07_sekolah_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t07_sekolah_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t07_sekolah_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t07_sekolah_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_sekolah_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="ft07_sekolahlist" id="ft07_sekolahlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t07_sekolah_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t07_sekolah_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t07_sekolah">
<div id="gmp_t07_sekolah" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($t07_sekolah_list->TotalRecs > 0 || $t07_sekolah->CurrentAction == "gridedit") { ?>
<table id="tbl_t07_sekolahlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t07_sekolah_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t07_sekolah_list->RenderListOptions();

// Render list options (header, left)
$t07_sekolah_list->ListOptions->Render("header", "left");
?>
<?php if ($t07_sekolah->Nama->Visible) { // Nama ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->Nama) == "") { ?>
		<th data-name="Nama" class="<?php echo $t07_sekolah->Nama->HeaderCellClass() ?>"><div id="elh_t07_sekolah_Nama" class="t07_sekolah_Nama"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama" class="<?php echo $t07_sekolah->Nama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->Nama) ?>',2);"><div id="elh_t07_sekolah_Nama" class="t07_sekolah_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->Alamat->Visible) { // Alamat ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->Alamat) == "") { ?>
		<th data-name="Alamat" class="<?php echo $t07_sekolah->Alamat->HeaderCellClass() ?>"><div id="elh_t07_sekolah_Alamat" class="t07_sekolah_Alamat"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->Alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alamat" class="<?php echo $t07_sekolah->Alamat->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->Alamat) ?>',2);"><div id="elh_t07_sekolah_Alamat" class="t07_sekolah_Alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->Alamat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->Alamat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->Alamat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->NoTelpHp->Visible) { // NoTelpHp ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->NoTelpHp) == "") { ?>
		<th data-name="NoTelpHp" class="<?php echo $t07_sekolah->NoTelpHp->HeaderCellClass() ?>"><div id="elh_t07_sekolah_NoTelpHp" class="t07_sekolah_NoTelpHp"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->NoTelpHp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NoTelpHp" class="<?php echo $t07_sekolah->NoTelpHp->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->NoTelpHp) ?>',2);"><div id="elh_t07_sekolah_NoTelpHp" class="t07_sekolah_NoTelpHp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->NoTelpHp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->NoTelpHp->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->NoTelpHp->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->TTD1Nama->Visible) { // TTD1Nama ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->TTD1Nama) == "") { ?>
		<th data-name="TTD1Nama" class="<?php echo $t07_sekolah->TTD1Nama->HeaderCellClass() ?>"><div id="elh_t07_sekolah_TTD1Nama" class="t07_sekolah_TTD1Nama"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD1Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TTD1Nama" class="<?php echo $t07_sekolah->TTD1Nama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->TTD1Nama) ?>',2);"><div id="elh_t07_sekolah_TTD1Nama" class="t07_sekolah_TTD1Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD1Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->TTD1Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->TTD1Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->TTD1Jabatan->Visible) { // TTD1Jabatan ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->TTD1Jabatan) == "") { ?>
		<th data-name="TTD1Jabatan" class="<?php echo $t07_sekolah->TTD1Jabatan->HeaderCellClass() ?>"><div id="elh_t07_sekolah_TTD1Jabatan" class="t07_sekolah_TTD1Jabatan"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD1Jabatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TTD1Jabatan" class="<?php echo $t07_sekolah->TTD1Jabatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->TTD1Jabatan) ?>',2);"><div id="elh_t07_sekolah_TTD1Jabatan" class="t07_sekolah_TTD1Jabatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD1Jabatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->TTD1Jabatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->TTD1Jabatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->TTD2Nama->Visible) { // TTD2Nama ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->TTD2Nama) == "") { ?>
		<th data-name="TTD2Nama" class="<?php echo $t07_sekolah->TTD2Nama->HeaderCellClass() ?>"><div id="elh_t07_sekolah_TTD2Nama" class="t07_sekolah_TTD2Nama"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD2Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TTD2Nama" class="<?php echo $t07_sekolah->TTD2Nama->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->TTD2Nama) ?>',2);"><div id="elh_t07_sekolah_TTD2Nama" class="t07_sekolah_TTD2Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD2Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->TTD2Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->TTD2Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($t07_sekolah->TTD2Jabatan->Visible) { // TTD2Jabatan ?>
	<?php if ($t07_sekolah->SortUrl($t07_sekolah->TTD2Jabatan) == "") { ?>
		<th data-name="TTD2Jabatan" class="<?php echo $t07_sekolah->TTD2Jabatan->HeaderCellClass() ?>"><div id="elh_t07_sekolah_TTD2Jabatan" class="t07_sekolah_TTD2Jabatan"><div class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD2Jabatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TTD2Jabatan" class="<?php echo $t07_sekolah->TTD2Jabatan->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t07_sekolah->SortUrl($t07_sekolah->TTD2Jabatan) ?>',2);"><div id="elh_t07_sekolah_TTD2Jabatan" class="t07_sekolah_TTD2Jabatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t07_sekolah->TTD2Jabatan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t07_sekolah->TTD2Jabatan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t07_sekolah->TTD2Jabatan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t07_sekolah_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t07_sekolah->ExportAll && $t07_sekolah->Export <> "") {
	$t07_sekolah_list->StopRec = $t07_sekolah_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t07_sekolah_list->TotalRecs > $t07_sekolah_list->StartRec + $t07_sekolah_list->DisplayRecs - 1)
		$t07_sekolah_list->StopRec = $t07_sekolah_list->StartRec + $t07_sekolah_list->DisplayRecs - 1;
	else
		$t07_sekolah_list->StopRec = $t07_sekolah_list->TotalRecs;
}
$t07_sekolah_list->RecCnt = $t07_sekolah_list->StartRec - 1;
if ($t07_sekolah_list->Recordset && !$t07_sekolah_list->Recordset->EOF) {
	$t07_sekolah_list->Recordset->MoveFirst();
	$bSelectLimit = $t07_sekolah_list->UseSelectLimit;
	if (!$bSelectLimit && $t07_sekolah_list->StartRec > 1)
		$t07_sekolah_list->Recordset->Move($t07_sekolah_list->StartRec - 1);
} elseif (!$t07_sekolah->AllowAddDeleteRow && $t07_sekolah_list->StopRec == 0) {
	$t07_sekolah_list->StopRec = $t07_sekolah->GridAddRowCount;
}

// Initialize aggregate
$t07_sekolah->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t07_sekolah->ResetAttrs();
$t07_sekolah_list->RenderRow();
while ($t07_sekolah_list->RecCnt < $t07_sekolah_list->StopRec) {
	$t07_sekolah_list->RecCnt++;
	if (intval($t07_sekolah_list->RecCnt) >= intval($t07_sekolah_list->StartRec)) {
		$t07_sekolah_list->RowCnt++;

		// Set up key count
		$t07_sekolah_list->KeyCount = $t07_sekolah_list->RowIndex;

		// Init row class and style
		$t07_sekolah->ResetAttrs();
		$t07_sekolah->CssClass = "";
		if ($t07_sekolah->CurrentAction == "gridadd") {
		} else {
			$t07_sekolah_list->LoadRowValues($t07_sekolah_list->Recordset); // Load row values
		}
		$t07_sekolah->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t07_sekolah->RowAttrs = array_merge($t07_sekolah->RowAttrs, array('data-rowindex'=>$t07_sekolah_list->RowCnt, 'id'=>'r' . $t07_sekolah_list->RowCnt . '_t07_sekolah', 'data-rowtype'=>$t07_sekolah->RowType));

		// Render row
		$t07_sekolah_list->RenderRow();

		// Render list options
		$t07_sekolah_list->RenderListOptions();
?>
	<tr<?php echo $t07_sekolah->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t07_sekolah_list->ListOptions->Render("body", "left", $t07_sekolah_list->RowCnt);
?>
	<?php if ($t07_sekolah->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $t07_sekolah->Nama->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_Nama" class="t07_sekolah_Nama">
<span<?php echo $t07_sekolah->Nama->ViewAttributes() ?>>
<?php echo $t07_sekolah->Nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->Alamat->Visible) { // Alamat ?>
		<td data-name="Alamat"<?php echo $t07_sekolah->Alamat->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_Alamat" class="t07_sekolah_Alamat">
<span<?php echo $t07_sekolah->Alamat->ViewAttributes() ?>>
<?php echo $t07_sekolah->Alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->NoTelpHp->Visible) { // NoTelpHp ?>
		<td data-name="NoTelpHp"<?php echo $t07_sekolah->NoTelpHp->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_NoTelpHp" class="t07_sekolah_NoTelpHp">
<span<?php echo $t07_sekolah->NoTelpHp->ViewAttributes() ?>>
<?php echo $t07_sekolah->NoTelpHp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->TTD1Nama->Visible) { // TTD1Nama ?>
		<td data-name="TTD1Nama"<?php echo $t07_sekolah->TTD1Nama->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_TTD1Nama" class="t07_sekolah_TTD1Nama">
<span<?php echo $t07_sekolah->TTD1Nama->ViewAttributes() ?>>
<?php echo $t07_sekolah->TTD1Nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->TTD1Jabatan->Visible) { // TTD1Jabatan ?>
		<td data-name="TTD1Jabatan"<?php echo $t07_sekolah->TTD1Jabatan->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_TTD1Jabatan" class="t07_sekolah_TTD1Jabatan">
<span<?php echo $t07_sekolah->TTD1Jabatan->ViewAttributes() ?>>
<?php echo $t07_sekolah->TTD1Jabatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->TTD2Nama->Visible) { // TTD2Nama ?>
		<td data-name="TTD2Nama"<?php echo $t07_sekolah->TTD2Nama->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_TTD2Nama" class="t07_sekolah_TTD2Nama">
<span<?php echo $t07_sekolah->TTD2Nama->ViewAttributes() ?>>
<?php echo $t07_sekolah->TTD2Nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t07_sekolah->TTD2Jabatan->Visible) { // TTD2Jabatan ?>
		<td data-name="TTD2Jabatan"<?php echo $t07_sekolah->TTD2Jabatan->CellAttributes() ?>>
<span id="el<?php echo $t07_sekolah_list->RowCnt ?>_t07_sekolah_TTD2Jabatan" class="t07_sekolah_TTD2Jabatan">
<span<?php echo $t07_sekolah->TTD2Jabatan->ViewAttributes() ?>>
<?php echo $t07_sekolah->TTD2Jabatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t07_sekolah_list->ListOptions->Render("body", "right", $t07_sekolah_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t07_sekolah->CurrentAction <> "gridadd")
		$t07_sekolah_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t07_sekolah->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t07_sekolah_list->Recordset)
	$t07_sekolah_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($t07_sekolah->CurrentAction <> "gridadd" && $t07_sekolah->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t07_sekolah_list->Pager)) $t07_sekolah_list->Pager = new cPrevNextPager($t07_sekolah_list->StartRec, $t07_sekolah_list->DisplayRecs, $t07_sekolah_list->TotalRecs, $t07_sekolah_list->AutoHidePager) ?>
<?php if ($t07_sekolah_list->Pager->RecordCount > 0 && $t07_sekolah_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t07_sekolah_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t07_sekolah_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t07_sekolah_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t07_sekolah_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t07_sekolah_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t07_sekolah_list->PageUrl() ?>start=<?php echo $t07_sekolah_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($t07_sekolah_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t07_sekolah_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_sekolah_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t07_sekolah_list->TotalRecs == 0 && $t07_sekolah->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t07_sekolah_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft07_sekolahlist.Init();
</script>
<?php
$t07_sekolah_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t07_sekolah_list->Page_Terminate();
?>
