<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php $EW_ROOT_RELATIVE_PATH = ""; ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$cf01_home_php = NULL; // Initialize page object first

class ccf01_home_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 'cf01_home.php';

	// Page object name
	var $PageObjName = 'cf01_home_php';

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
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'custom', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cf01_home.php', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect();

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
		if (!$Security->CanReport()) {
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

		if (@$_GET["export"] <> "")
			$gsExport = $_GET["export"]; // Get export parameter, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

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

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
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

	//
	// Page main
	//
	function Page_Main() {

		// Set up Breadcrumb
		$this->SetupBreadcrumb();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("custom", "cf01_home_php", $url, "", "cf01_home_php", TRUE);
		$this->Heading = $Language->TablePhrase("cf01_home_php", "TblCaption"); 
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cf01_home_php)) $cf01_home_php = new ccf01_home_php();

// Page init
$cf01_home_php->Page_Init();

// Page main
$cf01_home_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<style>
.panel-heading a{
  display:block;
}

.panel-heading a.collapsed {
  background: url(http://upload.wikimedia.org/wikipedia/commons/3/36/Vector_skin_right_arrow.png) center right no-repeat;
}

.panel-heading a {
  background: url(http://www.useragentman.com/blog/wp-content/themes/useragentman/images/widgets/downArrow.png) center right no-repeat;
}
</style>

<?php
	$db =& DbHelper(); // Create instance of the database helper class by DbHelper() (for main database) or DbHelper("<dbname>") (for linked databases) where <dbname> is database variable name
?>


<!-- periode -->
<!-- <div class="panel panel-default">
	<div class="panel-heading">Periode</div>
	<?php
	$q = "select concat(NamaBulan, ' ', Tahun) as Periode from t09_periode";
	echo $db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t09_periode"]]); // Execute a SQL and show as HTML table
	?>
</div> -->


<!-- saldo awal -->
<!-- <div class="panel panel-default">
	<div class="panel-heading">Saldo Awal</div>
	<?php
	$q = "select jumlah from t10_saldo";
	$jumlah = ew_ExecuteScalar($q);
	$saldo_akhir = $jumlah;
	$q = "select format(jumlah, 2) as Jumlah from t10_saldo";
	echo $db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t10_saldo"]]); // Execute a SQL and show as HTML table
	?>
</div> -->


<!-- penerimaan -->
<!-- <div class="panel panel-default">
	<div class="panel-heading">Penerimaan</div>
	<?php
	$q = "select sum(jumlah) as jumlah from t08_penerimaan";
	$jumlah = ew_ExecuteScalar($q);
	$saldo_akhir += $jumlah;
	$q = "select format(sum(jumlah), 2) as Jumlah from t08_penerimaan";
	echo $db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t08_penerimaan"]]); // Execute a SQL and show as HTML table
	?>
</div> -->


<!-- pengeluaran -->
<!-- <div class="panel panel-default">
	<div class="panel-heading">Pengeluaran</div>
	<?php
	$q = "select sum(jumlah) as jumlah from t06_pengeluaran";
	$jumlah = ew_ExecuteScalar($q);
	$saldo_akhir -= $jumlah;
	$q = "select format(sum(jumlah), 2) as Jumlah from t06_pengeluaran";
	echo $db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t06_pengeluaran"]]); // Execute a SQL and show as HTML table
	?>
</div> -->


<!-- saldo akhir -->
<!-- <div class="panel panel-default">
	<div class="panel-heading">Saldo Akhir</div>
	<div class="panel-body">
		<table class='table table-striped table-bordered table-hover table-condensed'>
			<tr>
				<td>Jumlah</td>
				<td><?php echo number_format($saldo_akhir, 2); //$db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t06_pengeluaran"]]); // Execute a SQL and show as HTML table ?></td>
			</tr>
		</table>
	</div>
</div> -->


<!-- summary -->
<div class="panel panel-default">
	<div class="panel-heading">Summary</div>
	<div class="panel-body">
		<table class='table table-striped table-bordered table-hover table-condensed'>
			<tr>
				<td>Periode</td>
				<?php
				$q = "select concat(NamaBulan, ' ', Tahun) as Periode from t09_periode";
				$periode = ew_ExecuteScalar($q);
				?>
				<td><?php echo $periode;?></td>
			</tr>
			<tr>
				<td>Saldo Awal</td>
				<?php
				$q = "select jumlah from t10_saldo";
				$jumlah = ew_ExecuteScalar($q);
				$saldo_akhir = $jumlah;
				?>
				<td align="right"><?php echo number_format($jumlah, 2);?></td>
			</tr>
			<tr>
				<td>Penerimaan</td>
				<?php
				$q = "select sum(jumlah) as jumlah from t08_penerimaan";
				$jumlah = ew_ExecuteScalar($q);
				$saldo_akhir += $jumlah;
				?>
				<td align="right"><?php echo number_format($jumlah, 2);?></td>
			</tr>
			<tr>
				<td>Pengeluaran</td>
				<?php
				$q = "select sum(jumlah) as jumlah from t06_pengeluaran";
				$jumlah = ew_ExecuteScalar($q);
				$saldo_akhir -= $jumlah;
				?>
				<td align="right"><?php echo number_format($jumlah, 2);?></td>
			</tr>
			<tr>
				<td>Saldo Akhir</td>
				<td align="right"><?php echo number_format($saldo_akhir, 2); //$db->ExecuteHtml($q, ["fieldcaption" => TRUE, "tablename" => ["t06_pengeluaran"]]); // Execute a SQL and show as HTML table ?></td>
			</tr>
		</table>
	</div>
</div>


<!-- log -->
<div class="panel panel-default">
	<div class="panel-heading"><strong><a class='collapsed' data-toggle="collapse" href="#log">Log</a></strong></div>
	<div id="log" class="panel-collapse collapse out">
		<div class="panel-body">
			<div>
<p>to do:<br/>
1. informasi identitas sekolah; -> noted;<br/>
2. logo sekolah; -> noted;<br/>
3. setup halaman excel F4 -> noted;<br/>
5. pembedaan hak akses tiap2 user -> noted;<br/>
6. field user dikurangi, hanya yang dibutuhkan saja -> noted;<br/>
			</div>
		</div>
	</div>
</div>
<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$cf01_home_php->Page_Terminate();
?>
