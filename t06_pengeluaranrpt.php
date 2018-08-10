<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "rcfg11.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "rphpfn11.php" ?>
<?php include_once "rusrfn11.php" ?>
<?php include_once "t06_pengeluaranrptinfo.php" ?>
<?php

//
// Page class
//

$t06_pengeluaran_rpt = NULL; // Initialize page object first

class crt06_pengeluaran_rpt extends crt06_pengeluaran {

	// Page ID
	var $PageID = 'rpt';

	// Project ID
	var $ProjectID = "{3CDC6268-D928-4495-B72A-CA5D35EAE344}";

	// Page object name
	var $PageObjName = 't06_pengeluaran_rpt';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $ReportLanguage;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $ReportLanguage;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $grToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$grToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;
		global $UserTable, $UserTableConn;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t06_pengeluaran)
		if (!isset($GLOBALS["t06_pengeluaran"])) {
			$GLOBALS["t06_pengeluaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t06_pengeluaran"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 't06_pengeluaran', TRUE);

		// Start timer
		if (!isset($GLOBALS["grTimer"]))
			$GLOBALS["grTimer"] = new crTimer();

		// Debug message
		ewr_LoadDebugMsg();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new crt96_employees();
			$UserTableConn = ReportConn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ft06_pengeluaranrpt";

		// Generate report options
		$this->GenerateOptions = new crListOptions();
		$this->GenerateOptions->Tag = "div";
		$this->GenerateOptions->TagClassName = "ewGenerateOption";
	}

	//
	// Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security, $UserProfile;
		global $gsCustomExport;

		// User profile
		$UserProfile = new crUserProfile();

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . 't06_pengeluaran');
		$Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ewr_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ewr_GetUrl("index.php"));
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		if ($Security->IsLoggedIn() && strval($Security->CurrentUserID()) == "") {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ewr_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ewr_GetUrl("login.php"));
		}

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		$this->subgroup_id->PlaceHolder = $this->subgroup_id->FldCaption();
		$this->maingroup_id->PlaceHolder = $this->maingroup_id->FldCaption();

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Security, $ReportLanguage, $ReportOptions;
		$exportid = session_id();
		$ReportTypes = array();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a class=\"ewrExportLink ewPrint\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["print"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPrint") : "";

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a class=\"ewrExportLink ewExcel\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["excel"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormExcel") : "";

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a class=\"ewrExportLink ewWord\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["word"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormWord") : "";

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a class=\"ewrExportLink ewPdf\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = TRUE;

		$ReportTypes["pdf"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormPdf") : "";

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a class=\"ewrExportLink ewEmail\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_t06_pengeluaran\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_t06_pengeluaran',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = TRUE;
		$ReportTypes["email"] = $item->Visible ? $ReportLanguage->Phrase("ReportFormEmail") : "";
		$ReportOptions["ReportTypes"] = $ReportTypes;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft06_pengeluaranrpt\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft06_pengeluaranrpt\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	// Set up search options
	function SetupSearchOptions() {
		global $ReportLanguage;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = $this->FilterApplied ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"ft06_pengeluaranrpt\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = TRUE && $this->FilterApplied;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide options for export
		if ($this->Export <> "")
			$this->SearchOptions->HideAllOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;
		global $grDashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();
			if (ob_get_length())
				ob_end_clean();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				if (@$this->GenOptions["reporttype"] == "email") {
					$saveResponse = $this->$fn($sContent, $this->GenOptions);
					$this->WriteGenResponse($saveResponse);
				} else {
					echo $this->$fn($sContent, array());
				}
				$url = ""; // Avoid redirect
			} else {
				$saveToFile = $this->$fn($sContent, $this->GenOptions);
				if (@$this->GenOptions["reporttype"] <> "") {
					$saveUrl = ($saveToFile <> "") ? ewr_FullUrl($saveToFile, "genurl") : $ReportLanguage->Phrase("GenerateSuccess");
					$this->WriteGenResponse($saveUrl);
					$url = ""; // Avoid redirect
				}
			}
		}

		// Close connection if not in dashboard
		if (!$grDashboardReport)
			ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ewr_SaveDebugMsg();
			header("Location: " . $url);
		}
		if (!$grDashboardReport)
			exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 10; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpColumnCount = 0;
	var $SubGrpColumnCount = 0;
	var $DtlColumnCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;
	var $DetailRows = array();
	var $TopContentClass = "col-sm-12 ewTop";
	var $LeftContentClass = "ewLeft";
	var $CenterContentClass = "col-sm-12 ewCenter";
	var $RightContentClass = "ewRight";
	var $BottomContentClass = "col-sm-12 ewBottom";

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $grFormError;
		global $grDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;
		global $grDashboardReport;

		// Set field visibility for detail fields
		$this->id->SetVisibility();
		$this->supplier_id->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->NoNota->SetVisibility();
		$this->barang_id->SetVisibility();
		$this->Banyaknya->SetVisibility();
		$this->Harga->SetVisibility();
		$this->Jumlah->SetVisibility();
		$this->subgroup_id->SetVisibility();
		$this->maingroup_id->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 11;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(TRUE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Check if search command
		$this->SearchCommand = (@$_GET["cmd"] == "search");

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Restore filter list
		$this->RestoreFilterList();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		ewr_AddFilter($this->Filter, $sExtendedFilter);

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown || $grDashboardReport) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup($this->GenOptions);

		// Set no record found message
		if ($this->TotalGrps == 0) {
			if ($Security->CanList()) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
			} else {
				$this->setWarningMessage(ewr_DeniedMsg());
			}
		}

		// Hide export options if export/dashboard report
		if ($this->Export <> "" || $grDashboardReport)
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown/dashboard report
		if ($this->Export <> "" || $this->DrillDown || $grDashboardReport) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
			$this->GenerateOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		return $this->getRecordCount($sql);
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
				$this->FirstRowData = array();
				$this->FirstRowData['id'] = ewr_Conv($rs->fields('id'), 3);
				$this->FirstRowData['supplier_id'] = ewr_Conv($rs->fields('supplier_id'), 3);
				$this->FirstRowData['Tanggal'] = ewr_Conv($rs->fields('Tanggal'), 133);
				$this->FirstRowData['NoNota'] = ewr_Conv($rs->fields('NoNota'), 200);
				$this->FirstRowData['barang_id'] = ewr_Conv($rs->fields('barang_id'), 3);
				$this->FirstRowData['Banyaknya'] = ewr_Conv($rs->fields('Banyaknya'), 4);
				$this->FirstRowData['Harga'] = ewr_Conv($rs->fields('Harga'), 4);
				$this->FirstRowData['Jumlah'] = ewr_Conv($rs->fields('Jumlah'), 4);
				$this->FirstRowData['subgroup_id'] = ewr_Conv($rs->fields('subgroup_id'), 3);
				$this->FirstRowData['maingroup_id'] = ewr_Conv($rs->fields('maingroup_id'), 3);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->id->setDbValue($rs->fields('id'));
			$this->supplier_id->setDbValue($rs->fields('supplier_id'));
			$this->Tanggal->setDbValue($rs->fields('Tanggal'));
			$this->NoNota->setDbValue($rs->fields('NoNota'));
			$this->barang_id->setDbValue($rs->fields('barang_id'));
			$this->Banyaknya->setDbValue($rs->fields('Banyaknya'));
			$this->Harga->setDbValue($rs->fields('Harga'));
			$this->Jumlah->setDbValue($rs->fields('Jumlah'));
			$this->subgroup_id->setDbValue($rs->fields('subgroup_id'));
			$this->maingroup_id->setDbValue($rs->fields('maingroup_id'));
			$this->Val[1] = $this->id->CurrentValue;
			$this->Val[2] = $this->supplier_id->CurrentValue;
			$this->Val[3] = $this->Tanggal->CurrentValue;
			$this->Val[4] = $this->NoNota->CurrentValue;
			$this->Val[5] = $this->barang_id->CurrentValue;
			$this->Val[6] = $this->Banyaknya->CurrentValue;
			$this->Val[7] = $this->Harga->CurrentValue;
			$this->Val[8] = $this->Jumlah->CurrentValue;
			$this->Val[9] = $this->subgroup_id->CurrentValue;
			$this->Val[10] = $this->maingroup_id->CurrentValue;
		} else {
			$this->id->setDbValue("");
			$this->supplier_id->setDbValue("");
			$this->Tanggal->setDbValue("");
			$this->NoNota->setDbValue("");
			$this->barang_id->setDbValue("");
			$this->Banyaknya->setDbValue("");
			$this->Harga->setDbValue("");
			$this->Jumlah->setDbValue("");
			$this->subgroup_id->setDbValue("");
			$this->maingroup_id->setDbValue("");
		}
	}

	// Set up starting group
	function SetUpStartGroup($options = array()) {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;
		$startGrp = (@$options["start"] <> "") ? $options["start"] : @$_GET[EWR_TABLE_START_GROUP];
		$pageNo = (@$options["pageno"] <> "") ? $options["pageno"] : @$_GET["pageno"];

		// Check for a 'start' parameter
		if ($startGrp != "") {
			$this->StartGrp = $startGrp;
			$this->setStartGroup($this->StartGrp);
		} elseif ($pageNo != "") {
			$nPageNo = $pageNo;
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				if (ob_get_length())
					ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = $_POST["sel_$sName"];
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$this->PopupName = $sName;
					if (ewr_IsAdvancedFilterValue($arValues) || $arValues == EWR_INIT_VALUE)
						$this->PopupValue = $arValues;
					if (!ewr_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = @$_POST["rf_$sName"];
					$_SESSION["rt_$sName"] = @$_POST["rt_$sName"];
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 10; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 10; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if (!$this->GrandSummarySetup) { // Get Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}

			// Get total from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectAgg(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$sSql = $this->getSqlAggPfx() . $sSql . $this->getSqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandCnt[1] = $this->TotCount;
				$this->GrandCnt[2] = $this->TotCount;
				$this->GrandCnt[3] = $this->TotCount;
				$this->GrandCnt[4] = $this->TotCount;
				$this->GrandCnt[5] = $this->TotCount;
				$this->GrandCnt[6] = $this->TotCount;
				$this->GrandCnt[7] = $this->TotCount;
				$this->GrandCnt[8] = $this->TotCount;
				$this->GrandSmry[8] = $rsagg->fields("sum_jumlah");
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandCnt[10] = $this->TotCount;
				$rsagg->Close();
				$bGotSummary = TRUE;
			}

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL && !($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER)) { // Summary row
			ewr_PrependClass($this->RowAttrs["class"], ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : ""); // Set up row class

			// Jumlah
			$this->Jumlah->SumViewValue = $this->Jumlah->SumValue;
			$this->Jumlah->SumViewValue = ewr_FormatNumber($this->Jumlah->SumViewValue, $this->Jumlah->DefaultDecimalPrecision, -1, 0, 0);
			$this->Jumlah->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// id
			$this->id->HrefValue = "";

			// supplier_id
			$this->supplier_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->HrefValue = "";

			// NoNota
			$this->NoNota->HrefValue = "";

			// barang_id
			$this->barang_id->HrefValue = "";

			// Banyaknya
			$this->Banyaknya->HrefValue = "";

			// Harga
			$this->Harga->HrefValue = "";

			// Jumlah
			$this->Jumlah->HrefValue = "";

			// subgroup_id
			$this->subgroup_id->HrefValue = "";

			// maingroup_id
			$this->maingroup_id->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			} else {
			}

			// id
			$this->id->ViewValue = $this->id->CurrentValue;
			$this->id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// supplier_id
			$this->supplier_id->ViewValue = $this->supplier_id->CurrentValue;
			$this->supplier_id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Tanggal
			$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
			$this->Tanggal->ViewValue = ewr_FormatDateTime($this->Tanggal->ViewValue, 0);
			$this->Tanggal->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NoNota
			$this->NoNota->ViewValue = $this->NoNota->CurrentValue;
			$this->NoNota->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// barang_id
			$this->barang_id->ViewValue = $this->barang_id->CurrentValue;
			$this->barang_id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Banyaknya
			$this->Banyaknya->ViewValue = $this->Banyaknya->CurrentValue;
			$this->Banyaknya->ViewValue = ewr_FormatNumber($this->Banyaknya->ViewValue, $this->Banyaknya->DefaultDecimalPrecision, -1, 0, 0);
			$this->Banyaknya->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Harga
			$this->Harga->ViewValue = $this->Harga->CurrentValue;
			$this->Harga->ViewValue = ewr_FormatNumber($this->Harga->ViewValue, $this->Harga->DefaultDecimalPrecision, -1, 0, 0);
			$this->Harga->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Jumlah
			$this->Jumlah->ViewValue = $this->Jumlah->CurrentValue;
			$this->Jumlah->ViewValue = ewr_FormatNumber($this->Jumlah->ViewValue, $this->Jumlah->DefaultDecimalPrecision, -1, 0, 0);
			$this->Jumlah->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// subgroup_id
			$this->subgroup_id->ViewValue = $this->subgroup_id->CurrentValue;
			$this->subgroup_id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// maingroup_id
			$this->maingroup_id->ViewValue = $this->maingroup_id->CurrentValue;
			$this->maingroup_id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// id
			$this->id->HrefValue = "";

			// supplier_id
			$this->supplier_id->HrefValue = "";

			// Tanggal
			$this->Tanggal->HrefValue = "";

			// NoNota
			$this->NoNota->HrefValue = "";

			// barang_id
			$this->barang_id->HrefValue = "";

			// Banyaknya
			$this->Banyaknya->HrefValue = "";

			// Harga
			$this->Harga->HrefValue = "";

			// Jumlah
			$this->Jumlah->HrefValue = "";

			// subgroup_id
			$this->subgroup_id->HrefValue = "";

			// maingroup_id
			$this->maingroup_id->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// Jumlah
			$CurrentValue = $this->Jumlah->SumValue;
			$ViewValue = &$this->Jumlah->SumViewValue;
			$ViewAttrs = &$this->Jumlah->ViewAttrs;
			$CellAttrs = &$this->Jumlah->CellAttrs;
			$HrefValue = &$this->Jumlah->HrefValue;
			$LinkAttrs = &$this->Jumlah->LinkAttrs;
			$this->Cell_Rendered($this->Jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// id
			$CurrentValue = $this->id->CurrentValue;
			$ViewValue = &$this->id->ViewValue;
			$ViewAttrs = &$this->id->ViewAttrs;
			$CellAttrs = &$this->id->CellAttrs;
			$HrefValue = &$this->id->HrefValue;
			$LinkAttrs = &$this->id->LinkAttrs;
			$this->Cell_Rendered($this->id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// supplier_id
			$CurrentValue = $this->supplier_id->CurrentValue;
			$ViewValue = &$this->supplier_id->ViewValue;
			$ViewAttrs = &$this->supplier_id->ViewAttrs;
			$CellAttrs = &$this->supplier_id->CellAttrs;
			$HrefValue = &$this->supplier_id->HrefValue;
			$LinkAttrs = &$this->supplier_id->LinkAttrs;
			$this->Cell_Rendered($this->supplier_id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Tanggal
			$CurrentValue = $this->Tanggal->CurrentValue;
			$ViewValue = &$this->Tanggal->ViewValue;
			$ViewAttrs = &$this->Tanggal->ViewAttrs;
			$CellAttrs = &$this->Tanggal->CellAttrs;
			$HrefValue = &$this->Tanggal->HrefValue;
			$LinkAttrs = &$this->Tanggal->LinkAttrs;
			$this->Cell_Rendered($this->Tanggal, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// NoNota
			$CurrentValue = $this->NoNota->CurrentValue;
			$ViewValue = &$this->NoNota->ViewValue;
			$ViewAttrs = &$this->NoNota->ViewAttrs;
			$CellAttrs = &$this->NoNota->CellAttrs;
			$HrefValue = &$this->NoNota->HrefValue;
			$LinkAttrs = &$this->NoNota->LinkAttrs;
			$this->Cell_Rendered($this->NoNota, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// barang_id
			$CurrentValue = $this->barang_id->CurrentValue;
			$ViewValue = &$this->barang_id->ViewValue;
			$ViewAttrs = &$this->barang_id->ViewAttrs;
			$CellAttrs = &$this->barang_id->CellAttrs;
			$HrefValue = &$this->barang_id->HrefValue;
			$LinkAttrs = &$this->barang_id->LinkAttrs;
			$this->Cell_Rendered($this->barang_id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Banyaknya
			$CurrentValue = $this->Banyaknya->CurrentValue;
			$ViewValue = &$this->Banyaknya->ViewValue;
			$ViewAttrs = &$this->Banyaknya->ViewAttrs;
			$CellAttrs = &$this->Banyaknya->CellAttrs;
			$HrefValue = &$this->Banyaknya->HrefValue;
			$LinkAttrs = &$this->Banyaknya->LinkAttrs;
			$this->Cell_Rendered($this->Banyaknya, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Harga
			$CurrentValue = $this->Harga->CurrentValue;
			$ViewValue = &$this->Harga->ViewValue;
			$ViewAttrs = &$this->Harga->ViewAttrs;
			$CellAttrs = &$this->Harga->CellAttrs;
			$HrefValue = &$this->Harga->HrefValue;
			$LinkAttrs = &$this->Harga->LinkAttrs;
			$this->Cell_Rendered($this->Harga, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// Jumlah
			$CurrentValue = $this->Jumlah->CurrentValue;
			$ViewValue = &$this->Jumlah->ViewValue;
			$ViewAttrs = &$this->Jumlah->ViewAttrs;
			$CellAttrs = &$this->Jumlah->CellAttrs;
			$HrefValue = &$this->Jumlah->HrefValue;
			$LinkAttrs = &$this->Jumlah->LinkAttrs;
			$this->Cell_Rendered($this->Jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// subgroup_id
			$CurrentValue = $this->subgroup_id->CurrentValue;
			$ViewValue = &$this->subgroup_id->ViewValue;
			$ViewAttrs = &$this->subgroup_id->ViewAttrs;
			$CellAttrs = &$this->subgroup_id->CellAttrs;
			$HrefValue = &$this->subgroup_id->HrefValue;
			$LinkAttrs = &$this->subgroup_id->LinkAttrs;
			$this->Cell_Rendered($this->subgroup_id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// maingroup_id
			$CurrentValue = $this->maingroup_id->CurrentValue;
			$ViewValue = &$this->maingroup_id->ViewValue;
			$ViewAttrs = &$this->maingroup_id->ViewAttrs;
			$CellAttrs = &$this->maingroup_id->CellAttrs;
			$HrefValue = &$this->maingroup_id->HrefValue;
			$LinkAttrs = &$this->maingroup_id->LinkAttrs;
			$this->Cell_Rendered($this->maingroup_id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpColumnCount = 0;
		$this->SubGrpColumnCount = 0;
		$this->DtlColumnCount = 0;
		if ($this->id->Visible) $this->DtlColumnCount += 1;
		if ($this->supplier_id->Visible) $this->DtlColumnCount += 1;
		if ($this->Tanggal->Visible) $this->DtlColumnCount += 1;
		if ($this->NoNota->Visible) $this->DtlColumnCount += 1;
		if ($this->barang_id->Visible) $this->DtlColumnCount += 1;
		if ($this->Banyaknya->Visible) $this->DtlColumnCount += 1;
		if ($this->Harga->Visible) $this->DtlColumnCount += 1;
		if ($this->Jumlah->Visible) $this->DtlColumnCount += 1;
		if ($this->subgroup_id->Visible) $this->DtlColumnCount += 1;
		if ($this->maingroup_id->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("rpt", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $ReportOptions;
		$ReportTypes = $ReportOptions["ReportTypes"];
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = TRUE;
		if ($item->Visible)
			$ReportTypes["pdf"] = $ReportLanguage->Phrase("ReportFormPdf");
		$exportid = session_id();
		$url = $this->ExportPdfUrl;
		$item->Body = "<a class=\"ewrExportLink ewPdf\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"javascript:void(0);\" onclick=\"ewr_ExportCharts(this, '" . $url . "', '" . $exportid . "');\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$ReportOptions["ReportTypes"] = $ReportTypes;
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $grFormError;
		$sFilter = "";
		if ($this->DrillDown)
			return "";
		$bPostBack = ewr_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			$this->SetSessionFilterValues($this->subgroup_id->SearchValue, $this->subgroup_id->SearchOperator, $this->subgroup_id->SearchCondition, $this->subgroup_id->SearchValue2, $this->subgroup_id->SearchOperator2, 'subgroup_id'); // Field subgroup_id
			$this->SetSessionFilterValues($this->maingroup_id->SearchValue, $this->maingroup_id->SearchOperator, $this->maingroup_id->SearchCondition, $this->maingroup_id->SearchValue2, $this->maingroup_id->SearchOperator2, 'maingroup_id'); // Field maingroup_id

			//$bSetupFilter = TRUE; // No need to set up, just use default
		} else {
			$bRestoreSession = !$this->SearchCommand;

			// Field subgroup_id
			if ($this->GetFilterValues($this->subgroup_id)) {
				$bSetupFilter = TRUE;
			}

			// Field maingroup_id
			if ($this->GetFilterValues($this->maingroup_id)) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setFailureMessage($grFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {
			$this->GetSessionFilterValues($this->subgroup_id); // Field subgroup_id
			$this->GetSessionFilterValues($this->maingroup_id); // Field maingroup_id
		}

		// Call page filter validated event
		$this->Page_FilterValidated();

		// Build SQL
		$this->BuildExtendedFilter($this->subgroup_id, $sFilter, FALSE, TRUE); // Field subgroup_id
		$this->BuildExtendedFilter($this->maingroup_id, $sFilter, FALSE, TRUE); // Field maingroup_id

		// Save parms to session
		$this->SetSessionFilterValues($this->subgroup_id->SearchValue, $this->subgroup_id->SearchOperator, $this->subgroup_id->SearchCondition, $this->subgroup_id->SearchValue2, $this->subgroup_id->SearchOperator2, 'subgroup_id'); // Field subgroup_id
		$this->SetSessionFilterValues($this->maingroup_id->SearchValue, $this->maingroup_id->SearchOperator, $this->maingroup_id->SearchCondition, $this->maingroup_id->SearchValue2, $this->maingroup_id->SearchOperator2, 'maingroup_id'); // Field maingroup_id

		// Setup filter
		if ($bSetupFilter) {
		}
		return $sFilter;
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr, $Default = FALSE, $SaveFilter = FALSE) {
		$FldVal = ($Default) ? $fld->DefaultDropDownValue : $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownFilter($fld, $val, $FldOpr);

				// Call Page Filtering event
				if (substr($val, 0, 2) <> "@@")
					$this->Page_Filtering($fld, $sWrk, "dropdown", $FldOpr, $val);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownFilter($fld, $FldVal, $FldOpr);

			// Call Page Filtering event
			if (substr($FldVal, 0, 2) <> "@@")
				$this->Page_Filtering($fld, $sSql, "dropdown", $FldOpr, $FldVal);
		}
		if ($sSql <> "") {
			ewr_AddFilter($FilterClause, $sSql);
			if ($SaveFilter) $fld->CurrentFilter = $sSql;
		}
	}

	function GetDropDownFilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDelimiter = $fld->FldDelimiter;
		$FldVal = strval($FldVal);
		if ($FldOpr == "") $FldOpr = "=";
		$sWrk = "";
		if (ewr_SameStr($FldVal, EWR_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif (ewr_SameStr($FldVal, EWR_NOT_NULL_VALUE)) {
			$sWrk = $FldExpression . " IS NOT NULL";
		} elseif (ewr_SameStr($FldVal, EWR_EMPTY_VALUE)) {
			$sWrk = $FldExpression . " = ''";
		} elseif (ewr_SameStr($FldVal, EWR_ALL_VALUE)) {
			$sWrk = "1 = 1";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = $this->GetCustomFilter($fld, $FldVal, $this->DBID);
			} elseif ($FldDelimiter <> "" && trim($FldVal) <> "" && ($FldDataType == EWR_DATATYPE_STRING || $FldDataType == EWR_DATATYPE_MEMO)) {
				$sWrk = ewr_GetMultiSearchSql($FldExpression, trim($FldVal), $this->DBID);
			} else {
				if ($FldVal <> "" && $FldVal <> EWR_INIT_VALUE) {
					if ($FldDataType == EWR_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = ewr_DateFilterString($FldExpression, $FldOpr, $FldVal, $FldDataType, $this->DBID);
					} else {
						$sWrk = ewr_FilterString($FldOpr, $FldVal, $FldDataType, $this->DBID);
						if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
					}
				}
			}
		}
		return $sWrk;
	}

	// Get custom filter
	function GetCustomFilter(&$fld, $FldVal, $dbid = 0) {
		$sWrk = "";
		if (is_array($fld->AdvancedFilters)) {
			foreach ($fld->AdvancedFilters as $filter) {
				if ($filter->ID == $FldVal && $filter->Enabled) {
					$sFld = $fld->FldExpression;
					$sFn = $filter->FunctionName;
					$wrkid = (substr($filter->ID, 0, 2) == "@@") ? substr($filter->ID,2) : $filter->ID;
					if ($sFn <> "")
						$sWrk = $sFn($sFld, $dbid);
					else
						$sWrk = "";
					$this->Page_Filtering($fld, $sWrk, "custom", $wrkid);
					break;
				}
			}
		}
		return $sWrk;
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause, $Default = FALSE, $SaveFilter = FALSE) {
		$sWrk = ewr_GetExtendedFilter($fld, $Default, $this->DBID);
		if (!$Default)
			$this->Page_Filtering($fld, $sWrk, "extended", $fld->SearchOperator, $fld->SearchValue, $fld->SearchCondition, $fld->SearchOperator2, $fld->SearchValue2);
		if ($sWrk <> "") {
			ewr_AddFilter($FilterClause, $sWrk);
			if ($SaveFilter) $fld->CurrentFilter = $sWrk;
		}
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["so_$parm"]))
			$fld->SearchOperator = @$_GET["so_$parm"];
		if (isset($_GET["sv_$parm"])) {
			$fld->DropDownValue = @$_GET["sv_$parm"];
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewr_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv_$parm"])) {
			$fld->SearchValue = @$_GET["sv_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so_$parm"])) {
			$fld->SearchOperator = @$_GET["so_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = @$_GET["sc_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = @$_GET["sv2_$parm"];
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = $_GET["so2_$parm"];
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DropDownValue)) {
			if (is_array($fld->DefaultDropDownValue)) {
				if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
					return TRUE;
				else
					return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
			} else {
				return TRUE;
			}
		} else {
			if (is_array($fld->DefaultDropDownValue))
				return TRUE;
			else
				$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWR_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWR_INIT_VALUE || $v2 == EWR_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_t06_pengeluaran_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_t06_pengeluaran_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv_t06_pengeluaran_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so_t06_pengeluaran_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_t06_pengeluaran_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_t06_pengeluaran_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_t06_pengeluaran_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (array_key_exists($sn, $_SESSION))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $so, $parm) {
		$_SESSION['sv_t06_pengeluaran_' . $parm] = $sv;
		$_SESSION['so_t06_pengeluaran_' . $parm] = $so;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv_t06_pengeluaran_' . $parm] = $sv1;
		$_SESSION['so_t06_pengeluaran_' . $parm] = $so1;
		$_SESSION['sc_t06_pengeluaran_' . $parm] = $sc;
		$_SESSION['sv2_t06_pengeluaran_' . $parm] = $sv2;
		$_SESSION['so2_t06_pengeluaran_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWR_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWR_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $grFormError;

		// Initialize form error message
		$grFormError = "";

		// Check if validation required
		if (!EWR_SERVER_VALIDATE)
			return ($grFormError == "");
		if (!ewr_CheckInteger($this->subgroup_id->SearchValue)) {
			if ($grFormError <> "") $grFormError .= "<br>";
			$grFormError .= $this->subgroup_id->FldErrMsg();
		}
		if (!ewr_CheckInteger($this->maingroup_id->SearchValue)) {
			if ($grFormError <> "") $grFormError .= "<br>";
			$grFormError .= $this->maingroup_id->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($grFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$grFormError .= ($grFormError <> "") ? "<p>&nbsp;</p>" : "";
			$grFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_t06_pengeluaran_$parm"] = "";
		$_SESSION["rf_t06_pengeluaran_$parm"] = "";
		$_SESSION["rt_t06_pengeluaran_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		$fld = &$this->FieldByParm($parm);
		$fld->SelectionList = @$_SESSION["sel_t06_pengeluaran_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_t06_pengeluaran_$parm"];
		$fld->RangeTo = @$_SESSION["rt_t06_pengeluaran_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		/**
		* Set up default values for non Text filters
		*/
		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		// Field subgroup_id
		$this->SetDefaultExtFilter($this->subgroup_id, "=", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->subgroup_id);

		// Field maingroup_id
		$this->SetDefaultExtFilter($this->maingroup_id, "=", NULL, 'AND', "=", NULL);
		if (!$this->SearchCommand) $this->ApplyDefaultExtFilter($this->maingroup_id);
		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {

		// Check subgroup_id text filter
		if ($this->TextFilterApplied($this->subgroup_id))
			return TRUE;

		// Check maingroup_id text filter
		if ($this->TextFilterApplied($this->maingroup_id))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList($showDate = FALSE) {
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field subgroup_id
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->subgroup_id, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->subgroup_id->FldCaption() . "</span>" . $sFilter . "</div>";

		// Field maingroup_id
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($this->maingroup_id, $sExtWrk);
		$sFilter = "";
		if ($sExtWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sExtWrk</span>";
		elseif ($sWrk <> "")
			$sFilter .= "<span class=\"ewFilterValue\">$sWrk</span>";
		if ($sFilter <> "")
			$sFilterList .= "<div><span class=\"ewFilterCaption\">" . $this->maingroup_id->FldCaption() . "</span>" . $sFilter . "</div>";
		$divstyle = "";
		$divdataclass = "";

		// Show Filters
		if ($sFilterList <> "" || $showDate) {
			$sMessage = "<div" . $divstyle . $divdataclass . "><div id=\"ewrFilterList\" class=\"alert alert-info\">";
			if ($showDate)
				$sMessage .= "<div id=\"ewrCurrentDate\">" . $ReportLanguage->Phrase("ReportGeneratedDate") . ewr_FormatDateTime(date("Y-m-d H:i:s"), 1) . "</div>";
			if ($sFilterList <> "")
				$sMessage .= "<div id=\"ewrCurrentFilters\">" . $ReportLanguage->Phrase("CurrentFilters") . "</div>" . $sFilterList;
			$sMessage .= "</div></div>";
			$this->Message_Showing($sMessage, "");
			echo $sMessage;
		}
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";

		// Field subgroup_id
		$sWrk = "";
		if ($this->subgroup_id->SearchValue <> "" || $this->subgroup_id->SearchValue2 <> "") {
			$sWrk = "\"sv_subgroup_id\":\"" . ewr_JsEncode2($this->subgroup_id->SearchValue) . "\"," .
				"\"so_subgroup_id\":\"" . ewr_JsEncode2($this->subgroup_id->SearchOperator) . "\"," .
				"\"sc_subgroup_id\":\"" . ewr_JsEncode2($this->subgroup_id->SearchCondition) . "\"," .
				"\"sv2_subgroup_id\":\"" . ewr_JsEncode2($this->subgroup_id->SearchValue2) . "\"," .
				"\"so2_subgroup_id\":\"" . ewr_JsEncode2($this->subgroup_id->SearchOperator2) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Field maingroup_id
		$sWrk = "";
		if ($this->maingroup_id->SearchValue <> "" || $this->maingroup_id->SearchValue2 <> "") {
			$sWrk = "\"sv_maingroup_id\":\"" . ewr_JsEncode2($this->maingroup_id->SearchValue) . "\"," .
				"\"so_maingroup_id\":\"" . ewr_JsEncode2($this->maingroup_id->SearchOperator) . "\"," .
				"\"sc_maingroup_id\":\"" . ewr_JsEncode2($this->maingroup_id->SearchCondition) . "\"," .
				"\"sv2_maingroup_id\":\"" . ewr_JsEncode2($this->maingroup_id->SearchValue2) . "\"," .
				"\"so2_maingroup_id\":\"" . ewr_JsEncode2($this->maingroup_id->SearchOperator2) . "\"";
		}
		if ($sWrk <> "") {
			if ($sFilterList <> "") $sFilterList .= ",";
			$sFilterList .= $sWrk;
		}

		// Return filter list in json
		if ($sFilterList <> "")
			return "{" . $sFilterList . "}";
		else
			return "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		return $this->SetupFilterList($filter);
	}

	// Setup list of filters
	function SetupFilterList($filter) {
		if (!is_array($filter))
			return FALSE;

		// Field subgroup_id
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_subgroup_id", $filter) || array_key_exists("so_subgroup_id", $filter) ||
			array_key_exists("sc_subgroup_id", $filter) ||
			array_key_exists("sv2_subgroup_id", $filter) || array_key_exists("so2_subgroup_id", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_subgroup_id"], @$filter["so_subgroup_id"], @$filter["sc_subgroup_id"], @$filter["sv2_subgroup_id"], @$filter["so2_subgroup_id"], "subgroup_id");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "subgroup_id");
		}

		// Field maingroup_id
		$bRestoreFilter = FALSE;
		if (array_key_exists("sv_maingroup_id", $filter) || array_key_exists("so_maingroup_id", $filter) ||
			array_key_exists("sc_maingroup_id", $filter) ||
			array_key_exists("sv2_maingroup_id", $filter) || array_key_exists("so2_maingroup_id", $filter)) {
			$this->SetSessionFilterValues(@$filter["sv_maingroup_id"], @$filter["so_maingroup_id"], @$filter["sc_maingroup_id"], @$filter["sv2_maingroup_id"], @$filter["so2_maingroup_id"], "maingroup_id");
			$bRestoreFilter = TRUE;
		}
		if (!$bRestoreFilter) { // Clear filter
			$this->SetSessionFilterValues("", "=", "AND", "", "=", "maingroup_id");
		}
		return TRUE;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	// Get sort parameters based on sort links clicked
	function GetSort($options = array()) {
		if ($this->DrillDown)
			return "";
		$bResetSort = @$options["resetsort"] == "1" || @$_GET["cmd"] == "resetsort";
		$orderBy = (@$options["order"] <> "") ? @$options["order"] : @$_GET["order"];
		$orderType = (@$options["ordertype"] <> "") ? @$options["ordertype"] : @$_GET["ordertype"];

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for a resetsort command
		if ($bResetSort) {
			$this->setOrderBy("");
			$this->setStartGroup(1);
			$this->id->setSort("");
			$this->supplier_id->setSort("");
			$this->Tanggal->setSort("");
			$this->NoNota->setSort("");
			$this->barang_id->setSort("");
			$this->Banyaknya->setSort("");
			$this->Harga->setSort("");
			$this->Jumlah->setSort("");
			$this->subgroup_id->setSort("");
			$this->maingroup_id->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->supplier_id, $bCtrl); // supplier_id
			$this->UpdateSort($this->Tanggal, $bCtrl); // Tanggal
			$this->UpdateSort($this->NoNota, $bCtrl); // NoNota
			$this->UpdateSort($this->barang_id, $bCtrl); // barang_id
			$this->UpdateSort($this->Banyaknya, $bCtrl); // Banyaknya
			$this->UpdateSort($this->Harga, $bCtrl); // Harga
			$this->UpdateSort($this->Jumlah, $bCtrl); // Jumlah
			$this->UpdateSort($this->subgroup_id, $bCtrl); // subgroup_id
			$this->UpdateSort($this->maingroup_id, $bCtrl); // maingroup_id
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Export email
	function ExportEmail($EmailContent, $options = array()) {
		global $grTmpImages, $ReportLanguage;
		$bGenRequest = @$options["reporttype"] == "email";
		$sFailRespPfx = $bGenRequest ? "" : "<p class=\"text-error\">";
		$sSuccessRespPfx = $bGenRequest ? "" : "<p class=\"text-success\">";
		$sRespPfx = $bGenRequest ? "" : "</p>";
		$sContentType = (@$options["contenttype"] <> "") ? $options["contenttype"] : @$_POST["contenttype"];
		$sSender = (@$options["sender"] <> "") ? $options["sender"] : @$_POST["sender"];
		$sRecipient = (@$options["recipient"] <> "") ? $options["recipient"] : @$_POST["recipient"];
		$sCc = (@$options["cc"] <> "") ? $options["cc"] : @$_POST["cc"];
		$sBcc = (@$options["bcc"] <> "") ? $options["bcc"] : @$_POST["bcc"];

		// Subject
		$sEmailSubject = (@$options["subject"] <> "") ? $options["subject"] : @$_POST["subject"];

		// Message
		$sEmailMessage = (@$options["message"] <> "") ? $options["message"] : @$_POST["message"];

		// Check sender
		if ($sSender == "")
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterSenderEmail") . $sRespPfx;
		if (!ewr_CheckEmail($sSender))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperSenderEmail") . $sRespPfx;

		// Check recipient
		if (!ewr_CheckEmailList($sRecipient, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperRecipientEmail") . $sRespPfx;

		// Check cc
		if (!ewr_CheckEmailList($sCc, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperCcEmail") . $sRespPfx;

		// Check bcc
		if (!ewr_CheckEmailList($sBcc, EWR_MAX_EMAIL_RECIPIENT))
			return $sFailRespPfx . $ReportLanguage->Phrase("EnterProperBccEmail") . $sRespPfx;

		// Check email sent count
		$emailcount = $bGenRequest ? 0 : ewr_LoadEmailCount();
		if (intval($emailcount) >= EWR_MAX_EMAIL_SENT_COUNT)
			return $sFailRespPfx . $ReportLanguage->Phrase("ExceedMaxEmailExport") . $sRespPfx;
		if ($sEmailMessage <> "") {
			if (EWR_REMOVE_XSS) $sEmailMessage = ewr_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		$sAttachmentContent = ewr_AdjustEmailContent($EmailContent);
		$sAppPath = ewr_FullUrl();
		$sAppPath = substr($sAppPath, 0, strrpos($sAppPath, "/")+1);
		if (strpos($sAttachmentContent, "<head>") !== FALSE)
			$sAttachmentContent = str_replace("<head>", "<head><base href=\"" . $sAppPath . "\">", $sAttachmentContent); // Add <base href> statement inside the header
		else
			$sAttachmentContent = "<base href=\"" . $sAppPath . "\">" . $sAttachmentContent; // Add <base href> statement as the first statement

		//$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . ".html";
		$sAttachmentFile = $this->TableVar . "_" . Date("YmdHis") . "_" . ewr_Random() . ".html";
		if ($sContentType == "url") {
			ewr_SaveFile(EWR_UPLOAD_DEST_PATH, $sAttachmentFile, $sAttachmentContent);
			$sAttachmentFile = EWR_UPLOAD_DEST_PATH . $sAttachmentFile;
			$sUrl = $sAppPath . $sAttachmentFile;
			$sEmailMessage .= $sUrl; // Send URL only
			$sAttachmentFile = "";
			$sAttachmentContent = "";
		} else {
			$sEmailMessage .= $sAttachmentContent;
			$sAttachmentFile = "";
			$sAttachmentContent = "";
		}

		// Send email
		$Email = new crEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Content = $sEmailMessage; // Content
		if ($sAttachmentFile <> "")
			$Email->AddAttachment($sAttachmentFile, $sAttachmentContent);
		if ($sContentType <> "url") {
			foreach ($grTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
		}
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EWR_EMAIL_CHARSET;
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();
		ewr_DeleteTmpImages($EmailContent);

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count and write log
			ewr_AddEmailLog($sSender, $sRecipient, $sEmailSubject, $sEmailMessage);

			// Sent email success
			return $sSuccessRespPfx . $ReportLanguage->Phrase("SendEmailSuccess") . $sRespPfx; // Set up success message
		} else {

			// Sent email failure
			return $sFailRespPfx . $Email->SendErrDescription . $sRespPfx;
		}
	}

	// Export to HTML
	function ExportHtml($html, $options = array()) {

		//global $gsExportFile;
		//header('Content-Type: text/html' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
		//header('Content-Disposition: attachment; filename=' . $gsExportFile . '.html');

		$folder = @$this->GenOptions["folder"];
		$fileName = @$this->GenOptions["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";

		// Save generate file for print
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			$baseTag = "<base href=\"" . ewr_BaseUrl() . "\">";
			$html = preg_replace('/<head>/', '<head>' . $baseTag, $html);
			ewr_SaveFile($folder, $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file")
			echo $html;
		return $saveToFile;
	}

	// Export to WORD
	function ExportWord($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Set-Cookie: fileDownload=true; path=/');
			header('Content-Type: application/vnd.ms-word' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.doc');
			echo $html;
		}
		return $saveToFile;
	}

	// Export to EXCEL
	function ExportExcel($html, $options = array()) {
		global $gsExportFile;
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
		 	ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $html);
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Set-Cookie: fileDownload=true; path=/');
			header('Content-Type: application/vnd.ms-excel' . (EWR_CHARSET <> '' ? ';charset=' . EWR_CHARSET : ''));
			header('Content-Disposition: attachment; filename=' . $gsExportFile . '.xls');
			echo $html;
		}
		return $saveToFile;
	}

	// Export PDF
	function ExportPdf($html, $options = array()) {
		global $gsExportFile;
		@ini_set("memory_limit", EWR_PDF_MEMORY_LIMIT);
		set_time_limit(EWR_PDF_TIME_LIMIT);
		if (EWR_DEBUG_ENABLED) // Add debug message
			$html = str_replace("</body>", ewr_DebugMsg() . "</body>", $html);
		$dompdf = new \Dompdf\Dompdf(array("pdf_backend" => "Cpdf"));
		$doc = new DOMDocument();
		@$doc->loadHTML('<?xml encoding="uft-8">' . ewr_ConvertToUtf8($html)); // Convert to utf-8
		$spans = $doc->getElementsByTagName("span");
		foreach ($spans as $span) {
			if ($span->getAttribute("class") == "ewFilterCaption")
				$span->parentNode->insertBefore($doc->createElement("span", ":&nbsp;"), $span->nextSibling);
		}
		$images = $doc->getElementsByTagName("img");
		$pageSize = "a4";
		$pageOrientation = "portrait";
		foreach ($images as $image) {
			$imagefn = $image->getAttribute("src");
			if (file_exists($imagefn)) {
				$imagefn = realpath($imagefn);
				$size = getimagesize($imagefn); // Get image size
				if ($size[0] <> 0) {
					if (ewr_SameText($pageSize, "letter")) { // Letter paper (8.5 in. by 11 in.)
						$w = ewr_SameText($pageOrientation, "portrait") ? 216 : 279;
					} elseif (ewr_SameText($pageSize, "legal")) { // Legal paper (8.5 in. by 14 in.)
						$w = ewr_SameText($pageOrientation, "portrait") ? 216 : 356;
					} else {
						$w = ewr_SameText($pageOrientation, "portrait") ? 210 : 297; // A4 paper (210 mm by 297 mm)
					}
					$w = min($size[0], ($w - 20 * 2) / 25.4 * 72); // Resize image, adjust the multiplying factor if necessary
					$h = $w / $size[0] * $size[1];
					$image->setAttribute("width", $w);
					$image->setAttribute("height", $h);
				}
			}
		}
		$html = $doc->saveHTML();
		$html = ewr_ConvertFromUtf8($html);
		$dompdf->load_html($html);
		$dompdf->set_paper($pageSize, $pageOrientation);
		$dompdf->render();
		$folder = @$options["folder"];
		$fileName = @$options["filename"];
		$responseType = @$options["responsetype"];
		$saveToFile = "";
		if ($folder <> "" && $fileName <> "" && ($responseType == "json" || $responseType == "file" && EWR_REPORT_SAVE_OUTPUT_ON_SERVER)) {
			ewr_SaveFile(ewr_PathCombine(ewr_AppRoot(), $folder, TRUE), $fileName, $dompdf->output());
			$saveToFile = ewr_UploadPathEx(FALSE, $folder) . $fileName;
		}
		if ($saveToFile == "" || $responseType == "file") {
			header('Set-Cookie: fileDownload=true; path=/');
			$sExportFile = strtolower(substr($gsExportFile, -4)) == ".pdf" ? $gsExportFile : $gsExportFile . ".pdf";
			$dompdf->stream($sExportFile, array("Attachment" => 1)); // 0 to open in browser, 1 to download
		}
		ewr_DeleteTmpImages($html);
		return $saveToFile;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
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
<?php

// Create page object
if (!isset($t06_pengeluaran_rpt)) $t06_pengeluaran_rpt = new crt06_pengeluaran_rpt();
if (isset($Page)) $OldPage = $Page;
$Page = &$t06_pengeluaran_rpt;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();
if (!$grDashboardReport)
	ewr_Header(FALSE);

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$grDashboardReport) { ?>
<?php include_once "header.php" ?>
<?php include_once "phprptinc/header.php" ?>
<?php } ?>
<?php if ($Page->Export == "" || $Page->Export == "print" || $Page->Export == "email" && @$gsEmailContentType == "url") { ?>
<script type="text/javascript">

// Create page object
var t06_pengeluaran_rpt = new ewr_Page("t06_pengeluaran_rpt");

// Page properties
t06_pengeluaran_rpt.PageID = "rpt"; // Page ID
var EWR_PAGE_ID = t06_pengeluaran_rpt.PageID;
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Form object
var CurrentForm = ft06_pengeluaranrpt = new ewr_Form("ft06_pengeluaranrpt");

// Validate method
ft06_pengeluaranrpt.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	var elm = fobj.sv_subgroup_id;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->subgroup_id->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv_maingroup_id;
	if (elm && !ewr_CheckInteger(elm.value)) {
		if (!this.OnError(elm, "<?php echo ewr_JsEncode2($Page->maingroup_id->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
ft06_pengeluaranrpt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }
<?php if (EWR_CLIENT_VALIDATE) { ?>
ft06_pengeluaranrpt.ValidateRequired = true; // Uses JavaScript validation
<?php } else { ?>
ft06_pengeluaranrpt.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<!-- Content Container -->
<div id="ewContainer" class="container-fluid ewContainer">
<?php } ?>
<?php if (@$Page->GenOptions["showfilter"] == "1") { ?>
<?php $Page->ShowFilterList(TRUE) ?>
<?php } ?>
<div class="ewToolbar">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
	$Page->GenerateOptions->Render("body");
}
?>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
<!-- Center Container - Report -->
<div id="ewCenter" class="col-sm-12 ewCenter">
<?php } ?>
<!-- Summary Report begins -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$grDashboardReport) { ?>
<!-- Search form (begin) -->
<form name="ft06_pengeluaranrpt" id="ft06_pengeluaranrpt" class="form-inline ewForm ewExtFilterForm" action="<?php echo ewr_CurrentPage() ?>">
<?php $SearchPanelClass = ($Page->Filter <> "") ? " in" : " in"; ?>
<div id="ft06_pengeluaranrpt_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ewRow">
<div id="c_subgroup_id" class="ewCell form-group">
	<label for="sv_subgroup_id" class="ewSearchCaption ewLabel"><?php echo $Page->subgroup_id->FldCaption() ?></label>
	<span class="ewSearchOperator"><?php echo $ReportLanguage->Phrase("="); ?><input type="hidden" name="so_subgroup_id" id="so_subgroup_id" value="="></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->subgroup_id->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="t06_pengeluaran" data-field="x_subgroup_id" id="sv_subgroup_id" name="sv_subgroup_id" size="30" placeholder="<?php echo $Page->subgroup_id->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->subgroup_id->SearchValue) ?>"<?php echo $Page->subgroup_id->EditAttributes() ?>>
</span>
</div>
</div>
<div id="r_2" class="ewRow">
<div id="c_maingroup_id" class="ewCell form-group">
	<label for="sv_maingroup_id" class="ewSearchCaption ewLabel"><?php echo $Page->maingroup_id->FldCaption() ?></label>
	<span class="ewSearchOperator"><?php echo $ReportLanguage->Phrase("="); ?><input type="hidden" name="so_maingroup_id" id="so_maingroup_id" value="="></span>
	<span class="control-group ewSearchField">
<?php ewr_PrependClass($Page->maingroup_id->EditAttrs["class"], "form-control"); // PR8 ?>
<input type="text" data-table="t06_pengeluaran" data-field="x_maingroup_id" id="sv_maingroup_id" name="sv_maingroup_id" size="30" placeholder="<?php echo $Page->maingroup_id->PlaceHolder ?>" value="<?php echo ewr_HtmlEncode($Page->maingroup_id->SearchValue) ?>"<?php echo $Page->maingroup_id->EditAttributes() ?>>
</span>
</div>
</div>
<div class="ewRow"><input type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-primary" value="<?php echo $ReportLanguage->Phrase("Search") ?>">
<input type="reset" name="btnreset" id="btnreset" class="btn hide" value="<?php echo $ReportLanguage->Phrase("Reset") ?>"></div>
</div>
</form>
<script type="text/javascript">
ft06_pengeluaranrpt.Init();
ft06_pengeluaranrpt.FilterList = <?php echo $Page->GetFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->ShowFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_t06_pengeluaran" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="id"><div class="t06_pengeluaran_id"><span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="id">
<?php if ($Page->SortUrl($Page->id) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->id) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="supplier_id"><div class="t06_pengeluaran_supplier_id"><span class="ewTableHeaderCaption"><?php echo $Page->supplier_id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="supplier_id">
<?php if ($Page->SortUrl($Page->supplier_id) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_supplier_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->supplier_id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_supplier_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->supplier_id) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->supplier_id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->supplier_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->supplier_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Tanggal"><div class="t06_pengeluaran_Tanggal"><span class="ewTableHeaderCaption"><?php echo $Page->Tanggal->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Tanggal">
<?php if ($Page->SortUrl($Page->Tanggal) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_Tanggal">
			<span class="ewTableHeaderCaption"><?php echo $Page->Tanggal->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_Tanggal" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Tanggal) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Tanggal->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->NoNota->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="NoNota"><div class="t06_pengeluaran_NoNota"><span class="ewTableHeaderCaption"><?php echo $Page->NoNota->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="NoNota">
<?php if ($Page->SortUrl($Page->NoNota) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_NoNota">
			<span class="ewTableHeaderCaption"><?php echo $Page->NoNota->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_NoNota" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->NoNota) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->NoNota->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->NoNota->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->NoNota->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->barang_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="barang_id"><div class="t06_pengeluaran_barang_id"><span class="ewTableHeaderCaption"><?php echo $Page->barang_id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="barang_id">
<?php if ($Page->SortUrl($Page->barang_id) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_barang_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->barang_id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_barang_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->barang_id) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->barang_id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->barang_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->barang_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Banyaknya->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Banyaknya"><div class="t06_pengeluaran_Banyaknya"><span class="ewTableHeaderCaption"><?php echo $Page->Banyaknya->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Banyaknya">
<?php if ($Page->SortUrl($Page->Banyaknya) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_Banyaknya">
			<span class="ewTableHeaderCaption"><?php echo $Page->Banyaknya->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_Banyaknya" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Banyaknya) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Banyaknya->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Banyaknya->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Banyaknya->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Harga->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Harga"><div class="t06_pengeluaran_Harga"><span class="ewTableHeaderCaption"><?php echo $Page->Harga->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Harga">
<?php if ($Page->SortUrl($Page->Harga) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_Harga">
			<span class="ewTableHeaderCaption"><?php echo $Page->Harga->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_Harga" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Harga) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Harga->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Harga->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Harga->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Jumlah->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Jumlah"><div class="t06_pengeluaran_Jumlah"><span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Jumlah">
<?php if ($Page->SortUrl($Page->Jumlah) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_Jumlah">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_Jumlah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->Jumlah) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->Jumlah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->Jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->Jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->subgroup_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="subgroup_id"><div class="t06_pengeluaran_subgroup_id"><span class="ewTableHeaderCaption"><?php echo $Page->subgroup_id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="subgroup_id">
<?php if ($Page->SortUrl($Page->subgroup_id) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_subgroup_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->subgroup_id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_subgroup_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->subgroup_id) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->subgroup_id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->subgroup_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->subgroup_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->maingroup_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="maingroup_id"><div class="t06_pengeluaran_maingroup_id"><span class="ewTableHeaderCaption"><?php echo $Page->maingroup_id->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="maingroup_id">
<?php if ($Page->SortUrl($Page->maingroup_id) == "") { ?>
		<div class="ewTableHeaderBtn t06_pengeluaran_maingroup_id">
			<span class="ewTableHeaderCaption"><?php echo $Page->maingroup_id->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer t06_pengeluaran_maingroup_id" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->maingroup_id) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->maingroup_id->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->maingroup_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->maingroup_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;
?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->id->Visible) { ?>
		<td data-field="id"<?php echo $Page->id->CellAttributes() ?>>
<span<?php echo $Page->id->ViewAttributes() ?>><?php echo $Page->id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->supplier_id->Visible) { ?>
		<td data-field="supplier_id"<?php echo $Page->supplier_id->CellAttributes() ?>>
<span<?php echo $Page->supplier_id->ViewAttributes() ?>><?php echo $Page->supplier_id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { ?>
		<td data-field="Tanggal"<?php echo $Page->Tanggal->CellAttributes() ?>>
<span<?php echo $Page->Tanggal->ViewAttributes() ?>><?php echo $Page->Tanggal->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->NoNota->Visible) { ?>
		<td data-field="NoNota"<?php echo $Page->NoNota->CellAttributes() ?>>
<span<?php echo $Page->NoNota->ViewAttributes() ?>><?php echo $Page->NoNota->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->barang_id->Visible) { ?>
		<td data-field="barang_id"<?php echo $Page->barang_id->CellAttributes() ?>>
<span<?php echo $Page->barang_id->ViewAttributes() ?>><?php echo $Page->barang_id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Banyaknya->Visible) { ?>
		<td data-field="Banyaknya"<?php echo $Page->Banyaknya->CellAttributes() ?>>
<span<?php echo $Page->Banyaknya->ViewAttributes() ?>><?php echo $Page->Banyaknya->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Harga->Visible) { ?>
		<td data-field="Harga"<?php echo $Page->Harga->CellAttributes() ?>>
<span<?php echo $Page->Harga->ViewAttributes() ?>><?php echo $Page->Harga->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Jumlah->Visible) { ?>
		<td data-field="Jumlah"<?php echo $Page->Jumlah->CellAttributes() ?>>
<span<?php echo $Page->Jumlah->ViewAttributes() ?>><?php echo $Page->Jumlah->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->subgroup_id->Visible) { ?>
		<td data-field="subgroup_id"<?php echo $Page->subgroup_id->CellAttributes() ?>>
<span<?php echo $Page->subgroup_id->ViewAttributes() ?>><?php echo $Page->subgroup_id->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->maingroup_id->Visible) { ?>
		<td data-field="maingroup_id"<?php echo $Page->maingroup_id->CellAttributes() ?>>
<span<?php echo $Page->maingroup_id->ViewAttributes() ?>><?php echo $Page->maingroup_id->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_t06_pengeluaran" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="box-footer ewGridLowerPanel">
<?php include "t06_pengeluaranrptpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /#ewCenter -->
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ($Page->Export == "" && !$grDashboardReport) { ?>
</div>
<!-- /.ewContainer -->
<?php } ?>
<?php
$Page->ShowPageFooter();
if (EWR_DEBUG_ENABLED)
	echo ewr_DebugMsg();
?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$grDashboardReport) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// console.log("page loaded");

</script>
<?php } ?>
<?php if (!$grDashboardReport) { ?>
<?php include_once "phprptinc/footer.php" ?>
<?php include_once "footer.php" ?>
<?php } ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
