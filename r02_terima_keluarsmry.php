<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "rcfg11.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "rphpfn11.php" ?>
<?php include_once "rusrfn11.php" ?>
<?php include_once "r02_terima_keluarsmryinfo.php" ?>
<?php

//
// Page class
//

$r02_terima_keluar_summary = NULL; // Initialize page object first

class crr02_terima_keluar_summary extends crr02_terima_keluar {

	// Page ID
	var $PageID = 'summary';

	// Project ID
	var $ProjectID = "{3CDC6268-D928-4495-B72A-CA5D35EAE344}";

	// Page object name
	var $PageObjName = 'r02_terima_keluar_summary';

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

		// Table object (r02_terima_keluar)
		if (!isset($GLOBALS["r02_terima_keluar"])) {
			$GLOBALS["r02_terima_keluar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["r02_terima_keluar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'r02_terima_keluar', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fr02_terima_keluarsummary";

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
		$Security->LoadCurrentUserLevel($this->ProjectID . 'r02_terima_keluar');
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
		$item->Body = "<a class=\"ewrExportLink ewEmail\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_r02_terima_keluar\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_r02_terima_keluar',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fr02_terima_keluarsummary\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fr02_terima_keluarsummary\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fr02_terima_keluarsummary\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = FALSE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = FALSE && $this->FilterApplied;

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
		$this->tanggal->SetVisibility();
		$this->ket3->SetVisibility();
		$this->ket4->SetVisibility();
		$this->ket5->SetVisibility();
		$this->nilai1->SetVisibility();
		$this->ket6->SetVisibility();
		$this->nilai2->SetVisibility();
		$this->terima_jumlah->SetVisibility();
		$this->keluar_jumlah->SetVisibility();

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 10;
		$nGrps = 3;
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
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,TRUE), array(FALSE,TRUE), array(FALSE,TRUE), array(FALSE,TRUE), array(FALSE,TRUE), array(FALSE,TRUE), array(TRUE,TRUE), array(TRUE,TRUE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

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

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// No filter
		$this->FilterApplied = FALSE;
		$this->FilterOptions->GetItem("savecurrentfilter")->Visible = FALSE;
		$this->FilterOptions->GetItem("deletefilter")->Visible = FALSE;

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);

		// Search options
		$this->SetupSearchOptions();

		// Get sort
		$this->Sort = $this->GetSort($this->GenOptions);

		// Get total group count
		$sGrpSort = ewr_UpdateSortFields($this->getSqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewr_BuildReportSql($this->getSqlSelectGroup(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
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

		// Get current page groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;
		$this->SetupFieldCount();
	}

	// Get summary count
	function GetSummaryCount($lvl, $curValue = TRUE) {
		$cnt = 0;
		foreach ($this->DetailRows as $row) {
			$wrkket1 = $row["ket1"];
			$wrkket2 = $row["ket2"];
			if ($lvl >= 1) {
				$val = $curValue ? $this->ket1->CurrentValue : $this->ket1->OldValue;
				$grpval = $curValue ? $this->ket1->GroupValue() : $this->ket1->GroupOldValue();
				if (is_null($val) && !is_null($wrkket1) || !is_null($val) && is_null($wrkket1) ||
					$grpval <> $this->ket1->getGroupValueBase($wrkket1))
				continue;
			}
			if ($lvl >= 2) {
				$val = $curValue ? $this->ket2->CurrentValue : $this->ket2->OldValue;
				$grpval = $curValue ? $this->ket2->GroupValue() : $this->ket2->GroupOldValue();
				if (is_null($val) && !is_null($wrkket2) || !is_null($val) && is_null($wrkket2) ||
					$grpval <> $this->ket2->getGroupValueBase($wrkket2))
				continue;
			}
			$cnt++;
		}
		return $cnt;
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		switch ($lvl) {
			case 1:
				return (is_null($this->ket1->CurrentValue) && !is_null($this->ket1->OldValue)) ||
					(!is_null($this->ket1->CurrentValue) && is_null($this->ket1->OldValue)) ||
					($this->ket1->GroupValue() <> $this->ket1->GroupOldValue());
			case 2:
				return (is_null($this->ket2->CurrentValue) && !is_null($this->ket2->OldValue)) ||
					(!is_null($this->ket2->CurrentValue) && is_null($this->ket2->OldValue)) ||
					($this->ket2->GroupValue() <> $this->ket2->GroupOldValue()) || $this->ChkLvlBreak(1); // Recurse upper level
		}
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

	// Get group count
	function GetGrpCnt($sql) {
		return $this->getRecordCount($sql);
	}

	// Get group recordset
	function GetGrpRs($wrksql, $start = -1, $grps = -1) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

			//$rsgrp->MoveFirst(); // NOTE: no need to move position
			$this->ket1->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF)
			$this->ket1->setDbValue($rsgrp->fields[0]);
		if ($rsgrp->EOF) {
			$this->ket1->setDbValue("");
		}
	}

	// Get detail recordset
	function GetDetailRs($wrksql) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->Execute($wrksql);
		$dbtype = ewr_GetConnectionType($this->DBID);
		if ($dbtype == "MYSQL" || $dbtype == "POSTGRESQL") {
			$this->DetailRows = ($rswrk) ? $rswrk->GetRows() : array();
		} else { // Cannot MoveFirst, use another recordset
			$rstmp = $conn->Execute($wrksql);
			$this->DetailRows = ($rstmp) ? $rstmp->GetRows() : array();
			$rstmp->Close();
		}
		$conn->raiseErrorFn = "";
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row
			$rs->MoveFirst(); // Move first
			if ($this->GrpCount == 1) {
				$this->FirstRowData = array();
				$this->FirstRowData['tanggal'] = ewr_Conv($rs->fields('tanggal'), 133);
				$this->FirstRowData['ket1'] = ewr_Conv($rs->fields('ket1'), 200);
				$this->FirstRowData['ket2'] = ewr_Conv($rs->fields('ket2'), 200);
				$this->FirstRowData['ket3'] = ewr_Conv($rs->fields('ket3'), 200);
				$this->FirstRowData['ket4'] = ewr_Conv($rs->fields('ket4'), 200);
				$this->FirstRowData['ket5'] = ewr_Conv($rs->fields('ket5'), 200);
				$this->FirstRowData['nilai1'] = ewr_Conv($rs->fields('nilai1'), 5);
				$this->FirstRowData['ket6'] = ewr_Conv($rs->fields('ket6'), 200);
				$this->FirstRowData['nilai2'] = ewr_Conv($rs->fields('nilai2'), 5);
				$this->FirstRowData['terima_jumlah'] = ewr_Conv($rs->fields('terima_jumlah'), 4);
				$this->FirstRowData['keluar_jumlah'] = ewr_Conv($rs->fields('keluar_jumlah'), 5);
			}
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->tanggal->setDbValue($rs->fields('tanggal'));
			if ($opt <> 1) {
				if (is_array($this->ket1->GroupDbValues))
					$this->ket1->setDbValue(@$this->ket1->GroupDbValues[$rs->fields('ket1')]);
				else
					$this->ket1->setDbValue(ewr_GroupValue($this->ket1, $rs->fields('ket1')));
			}
			$this->ket2->setDbValue($rs->fields('ket2'));
			$this->ket3->setDbValue($rs->fields('ket3'));
			$this->ket4->setDbValue($rs->fields('ket4'));
			$this->ket5->setDbValue($rs->fields('ket5'));
			$this->nilai1->setDbValue($rs->fields('nilai1'));
			$this->ket6->setDbValue($rs->fields('ket6'));
			$this->nilai2->setDbValue($rs->fields('nilai2'));
			$this->terima_jumlah->setDbValue($rs->fields('terima_jumlah'));
			$this->keluar_jumlah->setDbValue($rs->fields('keluar_jumlah'));
			$this->Val[1] = $this->tanggal->CurrentValue;
			$this->Val[2] = $this->ket3->CurrentValue;
			$this->Val[3] = $this->ket4->CurrentValue;
			$this->Val[4] = $this->ket5->CurrentValue;
			$this->Val[5] = $this->nilai1->CurrentValue;
			$this->Val[6] = $this->ket6->CurrentValue;
			$this->Val[7] = $this->nilai2->CurrentValue;
			$this->Val[8] = $this->terima_jumlah->CurrentValue;
			$this->Val[9] = $this->keluar_jumlah->CurrentValue;
		} else {
			$this->tanggal->setDbValue("");
			$this->ket1->setDbValue("");
			$this->ket2->setDbValue("");
			$this->ket3->setDbValue("");
			$this->ket4->setDbValue("");
			$this->ket5->setDbValue("");
			$this->nilai1->setDbValue("");
			$this->ket6->setDbValue("");
			$this->nilai2->setDbValue("");
			$this->terima_jumlah->setDbValue("");
			$this->keluar_jumlah->setDbValue("");
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
				$this->GrandSmry[8] = $rsagg->fields("sum_terima_jumlah");
				$this->GrandCnt[9] = $this->TotCount;
				$this->GrandSmry[9] = $rsagg->fields("sum_keluar_jumlah");
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
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP) $this->RowAttrs["data-group"] = $this->ket1->GroupOldValue(); // Set up group attribute
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowGroupLevel >= 2) $this->RowAttrs["data-group-2"] = $this->ket2->GroupOldValue(); // Set up group attribute 2

			// ket1
			$this->ket1->GroupViewValue = $this->ket1->GroupOldValue();
			$this->ket1->CellAttrs["class"] = ($this->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";
			$this->ket1->GroupViewValue = ewr_DisplayGroupValue($this->ket1, $this->ket1->GroupViewValue);
			$this->ket1->GroupSummaryOldValue = $this->ket1->GroupSummaryValue;
			$this->ket1->GroupSummaryValue = $this->ket1->GroupViewValue;
			$this->ket1->GroupSummaryViewValue = ($this->ket1->GroupSummaryOldValue <> $this->ket1->GroupSummaryValue) ? $this->ket1->GroupSummaryValue : "&nbsp;";

			// ket2
			$this->ket2->GroupViewValue = $this->ket2->GroupOldValue();
			$this->ket2->CellAttrs["class"] = ($this->RowGroupLevel == 2) ? "ewRptGrpSummary2" : "ewRptGrpField2";
			$this->ket2->GroupViewValue = ewr_DisplayGroupValue($this->ket2, $this->ket2->GroupViewValue);
			$this->ket2->GroupSummaryOldValue = $this->ket2->GroupSummaryValue;
			$this->ket2->GroupSummaryValue = $this->ket2->GroupViewValue;
			$this->ket2->GroupSummaryViewValue = ($this->ket2->GroupSummaryOldValue <> $this->ket2->GroupSummaryValue) ? $this->ket2->GroupSummaryValue : "&nbsp;";

			// terima_jumlah
			$this->terima_jumlah->SumViewValue = $this->terima_jumlah->SumValue;
			$this->terima_jumlah->SumViewValue = ewr_FormatNumber($this->terima_jumlah->SumViewValue, 2, -2, -2, -2);
			$this->terima_jumlah->CellAttrs["style"] = "text-align:right;";
			$this->terima_jumlah->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// keluar_jumlah
			$this->keluar_jumlah->SumViewValue = $this->keluar_jumlah->SumValue;
			$this->keluar_jumlah->SumViewValue = ewr_FormatNumber($this->keluar_jumlah->SumViewValue, 2, -2, -2, -2);
			$this->keluar_jumlah->CellAttrs["style"] = "text-align:right;";
			$this->keluar_jumlah->CellAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel;

			// ket1
			$this->ket1->HrefValue = "";

			// ket2
			$this->ket2->HrefValue = "";

			// tanggal
			$this->tanggal->HrefValue = "";

			// ket3
			$this->ket3->HrefValue = "";

			// ket4
			$this->ket4->HrefValue = "";

			// ket5
			$this->ket5->HrefValue = "";

			// nilai1
			$this->nilai1->HrefValue = "";

			// ket6
			$this->ket6->HrefValue = "";

			// nilai2
			$this->nilai2->HrefValue = "";

			// terima_jumlah
			$this->terima_jumlah->HrefValue = "";

			// keluar_jumlah
			$this->keluar_jumlah->HrefValue = "";
		} else {
			if ($this->RowTotalType == EWR_ROWTOTAL_GROUP && $this->RowTotalSubType == EWR_ROWTOTAL_HEADER) {
			$this->RowAttrs["data-group"] = $this->ket1->GroupValue(); // Set up group attribute
			if ($this->RowGroupLevel >= 2) $this->RowAttrs["data-group-2"] = $this->ket2->GroupValue(); // Set up group attribute 2
			} else {
			$this->RowAttrs["data-group"] = $this->ket1->GroupValue(); // Set up group attribute
			$this->RowAttrs["data-group-2"] = $this->ket2->GroupValue(); // Set up group attribute 2
			}

			// ket1
			$this->ket1->GroupViewValue = $this->ket1->GroupValue();
			$this->ket1->CellAttrs["class"] = "ewRptGrpField1";
			$this->ket1->GroupViewValue = ewr_DisplayGroupValue($this->ket1, $this->ket1->GroupViewValue);
			if ($this->ket1->GroupValue() == $this->ket1->GroupOldValue() && !$this->ChkLvlBreak(1))
				$this->ket1->GroupViewValue = "&nbsp;";

			// ket2
			$this->ket2->GroupViewValue = $this->ket2->GroupValue();
			$this->ket2->CellAttrs["class"] = "ewRptGrpField2";
			$this->ket2->GroupViewValue = ewr_DisplayGroupValue($this->ket2, $this->ket2->GroupViewValue);
			if ($this->ket2->GroupValue() == $this->ket2->GroupOldValue() && !$this->ChkLvlBreak(2))
				$this->ket2->GroupViewValue = "&nbsp;";

			// tanggal
			$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
			$this->tanggal->ViewValue = ewr_FormatDateTime($this->tanggal->ViewValue, 7);
			$this->tanggal->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ket3
			$this->ket3->ViewValue = $this->ket3->CurrentValue;
			$this->ket3->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ket4
			$this->ket4->ViewValue = $this->ket4->CurrentValue;
			$this->ket4->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ket5
			$this->ket5->ViewValue = $this->ket5->CurrentValue;
			$this->ket5->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// nilai1
			$this->nilai1->ViewValue = $this->nilai1->CurrentValue;
			$this->nilai1->ViewValue = ewr_FormatNumber($this->nilai1->ViewValue, 2, -2, -2, -2);
			$this->nilai1->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->nilai1->CellAttrs["style"] = "text-align:right;";

			// ket6
			$this->ket6->ViewValue = $this->ket6->CurrentValue;
			$this->ket6->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// nilai2
			$this->nilai2->ViewValue = $this->nilai2->CurrentValue;
			$this->nilai2->ViewValue = ewr_FormatNumber($this->nilai2->ViewValue, 2, -2, -2, -2);
			$this->nilai2->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->nilai2->CellAttrs["style"] = "text-align:right;";

			// terima_jumlah
			$this->terima_jumlah->ViewValue = $this->terima_jumlah->CurrentValue;
			$this->terima_jumlah->ViewValue = ewr_FormatNumber($this->terima_jumlah->ViewValue, 2, -2, -2, -2);
			$this->terima_jumlah->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->terima_jumlah->CellAttrs["style"] = "text-align:right;";

			// keluar_jumlah
			$this->keluar_jumlah->ViewValue = $this->keluar_jumlah->CurrentValue;
			$this->keluar_jumlah->ViewValue = ewr_FormatNumber($this->keluar_jumlah->ViewValue, 2, -2, -2, -2);
			$this->keluar_jumlah->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$this->keluar_jumlah->CellAttrs["style"] = "text-align:right;";

			// ket1
			$this->ket1->HrefValue = "";

			// ket2
			$this->ket2->HrefValue = "";

			// tanggal
			$this->tanggal->HrefValue = "";

			// ket3
			$this->ket3->HrefValue = "";

			// ket4
			$this->ket4->HrefValue = "";

			// ket5
			$this->ket5->HrefValue = "";

			// nilai1
			$this->nilai1->HrefValue = "";

			// ket6
			$this->ket6->HrefValue = "";

			// nilai2
			$this->nilai2->HrefValue = "";

			// terima_jumlah
			$this->terima_jumlah->HrefValue = "";

			// keluar_jumlah
			$this->keluar_jumlah->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row

			// ket1
			$CurrentValue = $this->ket1->GroupViewValue;
			$ViewValue = &$this->ket1->GroupViewValue;
			$ViewAttrs = &$this->ket1->ViewAttrs;
			$CellAttrs = &$this->ket1->CellAttrs;
			$HrefValue = &$this->ket1->HrefValue;
			$LinkAttrs = &$this->ket1->LinkAttrs;
			$this->Cell_Rendered($this->ket1, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket2
			$CurrentValue = $this->ket2->GroupViewValue;
			$ViewValue = &$this->ket2->GroupViewValue;
			$ViewAttrs = &$this->ket2->ViewAttrs;
			$CellAttrs = &$this->ket2->CellAttrs;
			$HrefValue = &$this->ket2->HrefValue;
			$LinkAttrs = &$this->ket2->LinkAttrs;
			$this->Cell_Rendered($this->ket2, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// terima_jumlah
			$CurrentValue = $this->terima_jumlah->SumValue;
			$ViewValue = &$this->terima_jumlah->SumViewValue;
			$ViewAttrs = &$this->terima_jumlah->ViewAttrs;
			$CellAttrs = &$this->terima_jumlah->CellAttrs;
			$HrefValue = &$this->terima_jumlah->HrefValue;
			$LinkAttrs = &$this->terima_jumlah->LinkAttrs;
			$this->Cell_Rendered($this->terima_jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// keluar_jumlah
			$CurrentValue = $this->keluar_jumlah->SumValue;
			$ViewValue = &$this->keluar_jumlah->SumViewValue;
			$ViewAttrs = &$this->keluar_jumlah->ViewAttrs;
			$CellAttrs = &$this->keluar_jumlah->CellAttrs;
			$HrefValue = &$this->keluar_jumlah->HrefValue;
			$LinkAttrs = &$this->keluar_jumlah->LinkAttrs;
			$this->Cell_Rendered($this->keluar_jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		} else {

			// ket1
			$CurrentValue = $this->ket1->GroupValue();
			$ViewValue = &$this->ket1->GroupViewValue;
			$ViewAttrs = &$this->ket1->ViewAttrs;
			$CellAttrs = &$this->ket1->CellAttrs;
			$HrefValue = &$this->ket1->HrefValue;
			$LinkAttrs = &$this->ket1->LinkAttrs;
			$this->Cell_Rendered($this->ket1, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket2
			$CurrentValue = $this->ket2->GroupValue();
			$ViewValue = &$this->ket2->GroupViewValue;
			$ViewAttrs = &$this->ket2->ViewAttrs;
			$CellAttrs = &$this->ket2->CellAttrs;
			$HrefValue = &$this->ket2->HrefValue;
			$LinkAttrs = &$this->ket2->LinkAttrs;
			$this->Cell_Rendered($this->ket2, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// tanggal
			$CurrentValue = $this->tanggal->CurrentValue;
			$ViewValue = &$this->tanggal->ViewValue;
			$ViewAttrs = &$this->tanggal->ViewAttrs;
			$CellAttrs = &$this->tanggal->CellAttrs;
			$HrefValue = &$this->tanggal->HrefValue;
			$LinkAttrs = &$this->tanggal->LinkAttrs;
			$this->Cell_Rendered($this->tanggal, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket3
			$CurrentValue = $this->ket3->CurrentValue;
			$ViewValue = &$this->ket3->ViewValue;
			$ViewAttrs = &$this->ket3->ViewAttrs;
			$CellAttrs = &$this->ket3->CellAttrs;
			$HrefValue = &$this->ket3->HrefValue;
			$LinkAttrs = &$this->ket3->LinkAttrs;
			$this->Cell_Rendered($this->ket3, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket4
			$CurrentValue = $this->ket4->CurrentValue;
			$ViewValue = &$this->ket4->ViewValue;
			$ViewAttrs = &$this->ket4->ViewAttrs;
			$CellAttrs = &$this->ket4->CellAttrs;
			$HrefValue = &$this->ket4->HrefValue;
			$LinkAttrs = &$this->ket4->LinkAttrs;
			$this->Cell_Rendered($this->ket4, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket5
			$CurrentValue = $this->ket5->CurrentValue;
			$ViewValue = &$this->ket5->ViewValue;
			$ViewAttrs = &$this->ket5->ViewAttrs;
			$CellAttrs = &$this->ket5->CellAttrs;
			$HrefValue = &$this->ket5->HrefValue;
			$LinkAttrs = &$this->ket5->LinkAttrs;
			$this->Cell_Rendered($this->ket5, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// nilai1
			$CurrentValue = $this->nilai1->CurrentValue;
			$ViewValue = &$this->nilai1->ViewValue;
			$ViewAttrs = &$this->nilai1->ViewAttrs;
			$CellAttrs = &$this->nilai1->CellAttrs;
			$HrefValue = &$this->nilai1->HrefValue;
			$LinkAttrs = &$this->nilai1->LinkAttrs;
			$this->Cell_Rendered($this->nilai1, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ket6
			$CurrentValue = $this->ket6->CurrentValue;
			$ViewValue = &$this->ket6->ViewValue;
			$ViewAttrs = &$this->ket6->ViewAttrs;
			$CellAttrs = &$this->ket6->CellAttrs;
			$HrefValue = &$this->ket6->HrefValue;
			$LinkAttrs = &$this->ket6->LinkAttrs;
			$this->Cell_Rendered($this->ket6, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// nilai2
			$CurrentValue = $this->nilai2->CurrentValue;
			$ViewValue = &$this->nilai2->ViewValue;
			$ViewAttrs = &$this->nilai2->ViewAttrs;
			$CellAttrs = &$this->nilai2->CellAttrs;
			$HrefValue = &$this->nilai2->HrefValue;
			$LinkAttrs = &$this->nilai2->LinkAttrs;
			$this->Cell_Rendered($this->nilai2, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// terima_jumlah
			$CurrentValue = $this->terima_jumlah->CurrentValue;
			$ViewValue = &$this->terima_jumlah->ViewValue;
			$ViewAttrs = &$this->terima_jumlah->ViewAttrs;
			$CellAttrs = &$this->terima_jumlah->CellAttrs;
			$HrefValue = &$this->terima_jumlah->HrefValue;
			$LinkAttrs = &$this->terima_jumlah->LinkAttrs;
			$this->Cell_Rendered($this->terima_jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// keluar_jumlah
			$CurrentValue = $this->keluar_jumlah->CurrentValue;
			$ViewValue = &$this->keluar_jumlah->ViewValue;
			$ViewAttrs = &$this->keluar_jumlah->ViewAttrs;
			$CellAttrs = &$this->keluar_jumlah->CellAttrs;
			$HrefValue = &$this->keluar_jumlah->HrefValue;
			$LinkAttrs = &$this->keluar_jumlah->LinkAttrs;
			$this->Cell_Rendered($this->keluar_jumlah, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
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
		if ($this->ket1->Visible) $this->GrpColumnCount += 1;
		if ($this->ket2->Visible) { $this->GrpColumnCount += 1; $this->SubGrpColumnCount += 1; }
		if ($this->tanggal->Visible) $this->DtlColumnCount += 1;
		if ($this->ket3->Visible) $this->DtlColumnCount += 1;
		if ($this->ket4->Visible) $this->DtlColumnCount += 1;
		if ($this->ket5->Visible) $this->DtlColumnCount += 1;
		if ($this->nilai1->Visible) $this->DtlColumnCount += 1;
		if ($this->ket6->Visible) $this->DtlColumnCount += 1;
		if ($this->nilai2->Visible) $this->DtlColumnCount += 1;
		if ($this->terima_jumlah->Visible) $this->DtlColumnCount += 1;
		if ($this->keluar_jumlah->Visible) $this->DtlColumnCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("summary", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
			$this->ket1->setSort("");
			$this->ket2->setSort("");
			$this->tanggal->setSort("");
			$this->ket3->setSort("");
			$this->ket4->setSort("");
			$this->ket5->setSort("");
			$this->nilai1->setSort("");
			$this->ket6->setSort("");
			$this->nilai2->setSort("");
			$this->terima_jumlah->setSort("");
			$this->keluar_jumlah->setSort("");

		// Check for an Order parameter
		} elseif ($orderBy <> "") {
			$this->CurrentOrder = $orderBy;
			$this->CurrentOrderType = $orderType;
			$this->UpdateSort($this->ket1, $bCtrl); // ket1
			$this->UpdateSort($this->ket2, $bCtrl); // ket2
			$this->UpdateSort($this->tanggal, $bCtrl); // tanggal
			$this->UpdateSort($this->ket3, $bCtrl); // ket3
			$this->UpdateSort($this->ket4, $bCtrl); // ket4
			$this->UpdateSort($this->ket5, $bCtrl); // ket5
			$this->UpdateSort($this->nilai1, $bCtrl); // nilai1
			$this->UpdateSort($this->ket6, $bCtrl); // ket6
			$this->UpdateSort($this->nilai2, $bCtrl); // nilai2
			$this->UpdateSort($this->terima_jumlah, $bCtrl); // terima_jumlah
			$this->UpdateSort($this->keluar_jumlah, $bCtrl); // keluar_jumlah
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
if (!isset($r02_terima_keluar_summary)) $r02_terima_keluar_summary = new crr02_terima_keluar_summary();
if (isset($Page)) $OldPage = $Page;
$Page = &$r02_terima_keluar_summary;

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
var r02_terima_keluar_summary = new ewr_Page("r02_terima_keluar_summary");

// Page properties
r02_terima_keluar_summary.PageID = "summary"; // Page ID
var EWR_PAGE_ID = r02_terima_keluar_summary.PageID;
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$grDashboardReport) { ?>
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
	$Page->GetGrpRow(1);
	$Page->GrpCounter[0] = 1;
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray($Page->StopGrp - $Page->StartGrp + 1, -1);
while ($rsgrp && !$rsgrp->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->GrpCount > 1) { ?>
</tbody>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="box-footer ewGridLowerPanel">
<?php include "r02_terima_keluarsmrypager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<span data-class="tpb<?php echo $Page->GrpCount-1 ?>_r02_terima_keluar"><?php echo $Page->PageBreakContent ?></span>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="box ewBox ewGrid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_r02_terima_keluar" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->ket1->Visible) { ?>
	<?php if ($Page->ket1->ShowGroupHeaderAsRow) { ?>
	<td data-field="ket1">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket1"><div class="r02_terima_keluar_ket1"><span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket1">
<?php if ($Page->SortUrl($Page->ket1) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket1">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket1" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket1) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->ket2->Visible) { ?>
	<?php if ($Page->ket2->ShowGroupHeaderAsRow) { ?>
	<td data-field="ket2">&nbsp;</td>
	<?php } else { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket2"><div class="r02_terima_keluar_ket2"><span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket2">
<?php if ($Page->SortUrl($Page->ket2) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket2">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket2" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket2) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($Page->tanggal->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="tanggal"><div class="r02_terima_keluar_tanggal"><span class="ewTableHeaderCaption"><?php echo $Page->tanggal->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="tanggal">
<?php if ($Page->SortUrl($Page->tanggal) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_tanggal">
			<span class="ewTableHeaderCaption"><?php echo $Page->tanggal->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_tanggal" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->tanggal) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->tanggal->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ket3->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket3"><div class="r02_terima_keluar_ket3"><span class="ewTableHeaderCaption"><?php echo $Page->ket3->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket3">
<?php if ($Page->SortUrl($Page->ket3) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket3">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket3->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket3" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket3) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket3->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket3->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket3->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ket4->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket4"><div class="r02_terima_keluar_ket4"><span class="ewTableHeaderCaption"><?php echo $Page->ket4->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket4">
<?php if ($Page->SortUrl($Page->ket4) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket4">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket4->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket4" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket4) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket4->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket4->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket4->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ket5->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket5"><div class="r02_terima_keluar_ket5"><span class="ewTableHeaderCaption"><?php echo $Page->ket5->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket5">
<?php if ($Page->SortUrl($Page->ket5) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket5">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket5->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket5" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket5) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket5->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket5->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket5->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->nilai1->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="nilai1"><div class="r02_terima_keluar_nilai1" style="text-align: right;"><span class="ewTableHeaderCaption"><?php echo $Page->nilai1->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="nilai1">
<?php if ($Page->SortUrl($Page->nilai1) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_nilai1" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->nilai1->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_nilai1" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->nilai1) ?>',2);" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->nilai1->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->nilai1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->nilai1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ket6->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ket6"><div class="r02_terima_keluar_ket6"><span class="ewTableHeaderCaption"><?php echo $Page->ket6->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ket6">
<?php if ($Page->SortUrl($Page->ket6) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_ket6">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket6->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_ket6" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket6) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket6->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket6->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket6->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->nilai2->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="nilai2"><div class="r02_terima_keluar_nilai2" style="text-align: right;"><span class="ewTableHeaderCaption"><?php echo $Page->nilai2->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="nilai2">
<?php if ($Page->SortUrl($Page->nilai2) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_nilai2" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->nilai2->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_nilai2" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->nilai2) ?>',2);" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->nilai2->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->nilai2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->nilai2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->terima_jumlah->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="terima_jumlah"><div class="r02_terima_keluar_terima_jumlah" style="text-align: right;"><span class="ewTableHeaderCaption"><?php echo $Page->terima_jumlah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="terima_jumlah">
<?php if ($Page->SortUrl($Page->terima_jumlah) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_terima_jumlah" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->terima_jumlah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_terima_jumlah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->terima_jumlah) ?>',2);" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->terima_jumlah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->terima_jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->terima_jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->keluar_jumlah->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="keluar_jumlah"><div class="r02_terima_keluar_keluar_jumlah" style="text-align: right;"><span class="ewTableHeaderCaption"><?php echo $Page->keluar_jumlah->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="keluar_jumlah">
<?php if ($Page->SortUrl($Page->keluar_jumlah) == "") { ?>
		<div class="ewTableHeaderBtn r02_terima_keluar_keluar_jumlah" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->keluar_jumlah->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer r02_terima_keluar_keluar_jumlah" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->keluar_jumlah) ?>',2);" style="text-align: right;">
			<span class="ewTableHeaderCaption"><?php echo $Page->keluar_jumlah->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->keluar_jumlah->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->keluar_jumlah->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
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

	// Build detail SQL
	$sWhere = ewr_DetailFilterSql($Page->ket1, $Page->getSqlFirstGroupField(), $Page->ket1->GroupValue(), $Page->DBID);
	if ($Page->PageFirstGroupFilter <> "") $Page->PageFirstGroupFilter .= " OR ";
	$Page->PageFirstGroupFilter .= $sWhere;
	if ($Page->Filter != "")
		$sWhere = "($Page->Filter) AND ($sWhere)";
	$sSql = ewr_BuildReportSql($Page->getSqlSelect(), $Page->getSqlWhere(), $Page->getSqlGroupBy(), $Page->getSqlHaving(), $Page->getSqlOrderBy(), $sWhere, $Page->Sort);
	$rs = $Page->GetDetailRs($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Page->GetRow(1);
	$Page->GrpIdx[$Page->GrpCount] = array(-1);
	while ($rs && !$rs->EOF) { // Loop detail records
		$Page->RecCount++;
		$Page->RecIndex++;
?>
<?php if ($Page->ket1->Visible && $Page->ChkLvlBreak(1) && $Page->ket1->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 1;
		$Page->ket1->Count = $Page->GetSummaryCount(1);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->ket1->Visible) { ?>
		<td data-field="ket1"<?php echo $Page->ket1->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="ket1" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 1) ?>"<?php echo $Page->ket1->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r02_terima_keluar_ket1"><span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->ket1) == "") { ?>
		<span class="ewSummaryCaption r02_terima_keluar_ket1">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r02_terima_keluar_ket1" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket1) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket1->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_r02_terima_keluar_ket1"<?php echo $Page->ket1->ViewAttributes() ?>><?php echo $Page->ket1->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->ket1->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php if ($Page->ket2->Visible && $Page->ChkLvlBreak(2) && $Page->ket2->ShowGroupHeaderAsRow) { ?>
<?php

		// Render header row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_TOTAL;
		$Page->RowTotalType = EWR_ROWTOTAL_GROUP;
		$Page->RowTotalSubType = EWR_ROWTOTAL_HEADER;
		$Page->RowGroupLevel = 2;
		$Page->ket2->Count = $Page->GetSummaryCount(2);
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->ket1->Visible) { ?>
		<td data-field="ket1"<?php echo $Page->ket1->CellAttributes(); ?>></td>
<?php } ?>
<?php if ($Page->ket2->Visible) { ?>
		<td data-field="ket2"<?php echo $Page->ket2->CellAttributes(); ?>><span class="ewGroupToggle icon-collapse"></span></td>
<?php } ?>
		<td data-field="ket2" colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount - 2) ?>"<?php echo $Page->ket2->CellAttributes() ?>>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
		<span class="ewSummaryCaption r02_terima_keluar_ket2"><span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span></span>
<?php } else { ?>
	<?php if ($Page->SortUrl($Page->ket2) == "") { ?>
		<span class="ewSummaryCaption r02_terima_keluar_ket2">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span>
		</span>
	<?php } else { ?>
		<span class="ewTableHeaderBtn ewPointer ewSummaryCaption r02_terima_keluar_ket2" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ket2) ?>',2);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ket2->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ket2->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ket2->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</span>
	<?php } ?>
<?php } ?>
		<?php echo $ReportLanguage->Phrase("SummaryColon") ?>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_r02_terima_keluar_ket2"<?php echo $Page->ket2->ViewAttributes() ?>><?php echo $Page->ket2->GroupViewValue ?></span>
		<span class="ewSummaryCount">(<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->ket2->Count,0,-2,-2,-2) ?></span>)</span>
		</td>
	</tr>
<?php } ?>
<?php

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->ket1->Visible) { ?>
	<?php if ($Page->ket1->ShowGroupHeaderAsRow) { ?>
		<td data-field="ket1"<?php echo $Page->ket1->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="ket1"<?php echo $Page->ket1->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_r02_terima_keluar_ket1"<?php echo $Page->ket1->ViewAttributes() ?>><?php echo $Page->ket1->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->ket2->Visible) { ?>
	<?php if ($Page->ket2->ShowGroupHeaderAsRow) { ?>
		<td data-field="ket2"<?php echo $Page->ket2->CellAttributes(); ?>>&nbsp;</td>
	<?php } else { ?>
		<td data-field="ket2"<?php echo $Page->ket2->CellAttributes(); ?>>
<span data-class="tpx<?php echo $Page->GrpCount ?>_<?php echo $Page->GrpCounter[0] ?>_r02_terima_keluar_ket2"<?php echo $Page->ket2->ViewAttributes() ?>><?php echo $Page->ket2->GroupViewValue ?></span></td>
	<?php } ?>
<?php } ?>
<?php if ($Page->tanggal->Visible) { ?>
		<td data-field="tanggal"<?php echo $Page->tanggal->CellAttributes() ?>>
<span<?php echo $Page->tanggal->ViewAttributes() ?>><?php echo $Page->tanggal->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ket3->Visible) { ?>
		<td data-field="ket3"<?php echo $Page->ket3->CellAttributes() ?>>
<span<?php echo $Page->ket3->ViewAttributes() ?>><?php echo $Page->ket3->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ket4->Visible) { ?>
		<td data-field="ket4"<?php echo $Page->ket4->CellAttributes() ?>>
<span<?php echo $Page->ket4->ViewAttributes() ?>><?php echo $Page->ket4->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ket5->Visible) { ?>
		<td data-field="ket5"<?php echo $Page->ket5->CellAttributes() ?>>
<span<?php echo $Page->ket5->ViewAttributes() ?>><?php echo $Page->ket5->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->nilai1->Visible) { ?>
		<td data-field="nilai1"<?php echo $Page->nilai1->CellAttributes() ?>>
<span<?php echo $Page->nilai1->ViewAttributes() ?>><?php echo $Page->nilai1->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ket6->Visible) { ?>
		<td data-field="ket6"<?php echo $Page->ket6->CellAttributes() ?>>
<span<?php echo $Page->ket6->ViewAttributes() ?>><?php echo $Page->ket6->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->nilai2->Visible) { ?>
		<td data-field="nilai2"<?php echo $Page->nilai2->CellAttributes() ?>>
<span<?php echo $Page->nilai2->ViewAttributes() ?>><?php echo $Page->nilai2->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->terima_jumlah->Visible) { ?>
		<td data-field="terima_jumlah"<?php echo $Page->terima_jumlah->CellAttributes() ?>>
<span<?php echo $Page->terima_jumlah->ViewAttributes() ?>><?php echo $Page->terima_jumlah->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->keluar_jumlah->Visible) { ?>
		<td data-field="keluar_jumlah"<?php echo $Page->keluar_jumlah->CellAttributes() ?>>
<span<?php echo $Page->keluar_jumlah->ViewAttributes() ?>><?php echo $Page->keluar_jumlah->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$Page->GetGrpRow(2);

	// Show header if page break
	if ($Page->Export <> "")
		$Page->ShowHeader = ($Page->ExportPageBreakCount == 0) ? FALSE : ($Page->GrpCount % $Page->ExportPageBreakCount == 0);

	// Page_Breaking server event
	if ($Page->ShowHeader)
		$Page->Page_Breaking($Page->ShowHeader, $Page->PageBreakContent);
	$Page->GrpCount++;
	$Page->GrpCounter[0] = 1;

	// Handle EOF
	if (!$rsgrp || $rsgrp->EOF)
		$Page->ShowHeader = FALSE;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
<?php
	$Page->terima_jumlah->Count = $Page->GrandCnt[8];
	$Page->terima_jumlah->SumValue = $Page->GrandSmry[8]; // Load SUM
	$Page->keluar_jumlah->Count = $Page->GrandCnt[9];
	$Page->keluar_jumlah->SumValue = $Page->GrandSmry[9]; // Load SUM
	$Page->ResetAttrs();
	$Page->RowType = EWR_ROWTYPE_TOTAL;
	$Page->RowTotalType = EWR_ROWTOTAL_GRAND;
	$Page->RowTotalSubType = EWR_ROWTOTAL_FOOTER;
	$Page->RowAttrs["class"] = "ewRptGrandSummary";
	$Page->RenderRow();
?>
<?php if ($Page->ket2->ShowCompactSummaryFooter) { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> (<span class="ewAggregateCaption"><?php echo $ReportLanguage->Phrase("RptCnt") ?></span><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span class="ewAggregateValue"><?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2) ?></span>)</td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td colspan="<?php echo $Page->GrpColumnCount ?>" class="ewRptGrpAggregate">&nbsp;</td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { ?>
		<td data-field="tanggal"<?php echo $Page->tanggal->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ket3->Visible) { ?>
		<td data-field="ket3"<?php echo $Page->ket3->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ket4->Visible) { ?>
		<td data-field="ket4"<?php echo $Page->ket4->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ket5->Visible) { ?>
		<td data-field="ket5"<?php echo $Page->ket5->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->nilai1->Visible) { ?>
		<td data-field="nilai1"<?php echo $Page->nilai1->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->ket6->Visible) { ?>
		<td data-field="ket6"<?php echo $Page->ket6->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->nilai2->Visible) { ?>
		<td data-field="nilai2"<?php echo $Page->nilai2->CellAttributes() ?>></td>
<?php } ?>
<?php if ($Page->terima_jumlah->Visible) { ?>
		<td data-field="terima_jumlah"<?php echo $Page->terima_jumlah->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSum") ?><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span<?php echo $Page->terima_jumlah->ViewAttributes() ?>><?php echo $Page->terima_jumlah->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->keluar_jumlah->Visible) { ?>
		<td data-field="keluar_jumlah"<?php echo $Page->keluar_jumlah->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSum") ?><?php echo $ReportLanguage->Phrase("AggregateEqual") ?><span<?php echo $Page->keluar_jumlah->ViewAttributes() ?>><?php echo $Page->keluar_jumlah->SumViewValue ?></span></td>
<?php } ?>
	</tr>
<?php } else { ?>
	<tr<?php echo $Page->RowAttributes() ?>><td colspan="<?php echo ($Page->GrpColumnCount + $Page->DtlColumnCount) ?>"><?php echo $ReportLanguage->Phrase("RptGrandSummary") ?> <span class="ewDirLtr">(<?php echo ewr_FormatNumber($Page->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</span></td></tr>
	<tr<?php echo $Page->RowAttributes() ?>>
<?php if ($Page->GrpColumnCount > 0) { ?>
		<td colspan="<?php echo $Page->GrpColumnCount ?>" class="ewRptGrpAggregate"><?php echo $ReportLanguage->Phrase("RptSum") ?></td>
<?php } ?>
<?php if ($Page->tanggal->Visible) { ?>
		<td data-field="tanggal"<?php echo $Page->tanggal->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ket3->Visible) { ?>
		<td data-field="ket3"<?php echo $Page->ket3->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ket4->Visible) { ?>
		<td data-field="ket4"<?php echo $Page->ket4->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ket5->Visible) { ?>
		<td data-field="ket5"<?php echo $Page->ket5->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->nilai1->Visible) { ?>
		<td data-field="nilai1"<?php echo $Page->nilai1->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->ket6->Visible) { ?>
		<td data-field="ket6"<?php echo $Page->ket6->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->nilai2->Visible) { ?>
		<td data-field="nilai2"<?php echo $Page->nilai2->CellAttributes() ?>>&nbsp;</td>
<?php } ?>
<?php if ($Page->terima_jumlah->Visible) { ?>
		<td data-field="terima_jumlah"<?php echo $Page->terima_jumlah->CellAttributes() ?>>
<span<?php echo $Page->terima_jumlah->ViewAttributes() ?>><?php echo $Page->terima_jumlah->SumViewValue ?></span></td>
<?php } ?>
<?php if ($Page->keluar_jumlah->Visible) { ?>
		<td data-field="keluar_jumlah"<?php echo $Page->keluar_jumlah->CellAttributes() ?>>
<span<?php echo $Page->keluar_jumlah->ViewAttributes() ?>><?php echo $Page->keluar_jumlah->SumViewValue ?></span></td>
<?php } ?>
	</tr>
<?php } ?>
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
<div id="gmp_r02_terima_keluar" class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
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
<?php include "r02_terima_keluarsmrypager.php" ?>
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
