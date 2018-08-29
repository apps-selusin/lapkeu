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

$cf05_backupproses_php = NULL; // Initialize page object first

class ccf05_backupproses_php {

	// Page ID
	var $PageID = 'custom';

	// Project ID
	var $ProjectID = '{239A2A32-109A-412F-A3CB-FF6290C167FC}';

	// Table name
	var $TableName = 'cf05_backupproses.php';

	// Page object name
	var $PageObjName = 'cf05_backupproses_php';

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
			define("EW_TABLE_NAME", 'cf05_backupproses.php', TRUE);

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
		$Breadcrumb->Add("custom", "cf05_backupproses_php", $url, "", "cf05_backupproses_php", TRUE);
		$this->Heading = $Language->TablePhrase("cf05_backupproses_php", "TblCaption"); 
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cf05_backupproses_php)) $cf05_backupproses_php = new ccf05_backupproses_php();

// Page init
$cf05_backupproses_php->Page_Init();

// Page main
$cf05_backupproses_php->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();
?>
<?php include_once "header.php" ?>
<?php
$info = array();
if (ew_CurrentUserIP () == "127.0.0.1"  || ew_CurrentUserIP () == ":: 1"  || ew_CurrentHost () == "localhost" ) { // testing on local PC
	$info["host"] = "localhost";
	$info["user"] = "root"; // sesuaikan dengan username database di komputer localhost
	$info["pass"] = "admin"; // sesuaikan dengan password database di komputer localhost
	$info["db"] = "db_lapkeu"; // sesuaikan dengan nama database di komputer localhost
} elseif (ew_CurrentHost () == "lapkeu.selusin.net") { // setting koneksi database untuk komputer server
	$info["host"] = "mysql.hostinger.co.id";  // sesuaikan dengan ip address atau hostname komputer server
	$info["user"] = "u433254588_lapke"; // sesuaikan dengan username database di komputer server
	$info["pass"] = "M457r1P 81"; // sesuaikan deengan password database di komputer server
	$info["db"] = "u433254588_lapke"; // sesuaikan dengan nama database di komputer server
}
?>

<?php
 
#####################
//CONFIGURATIONS
#####################
// Define the name of the backup directory
define('BACKUP_DIR', './myBackups' ) ;
// Define  Database Credentials
define('HOST', $info["host"] ) ;
define('USER', $info["user"] ) ;
define('PASSWORD', $info["pass"] ) ;
define('DB_NAME', $info["db"] ) ;
/*
Define the filename for the Archive
If you plan to upload the  file to Amazon's S3 service , use only lower-case letters .
Watever follows the "&" character should be kept as is , it designates a timestamp , which will be used by the script .
*/
$archiveName = 'mysqlbackup--' . date('d-m-Y') . '@'.date('h.i.s').'&'.microtime(true) . '.sql' ;
// Set execution time limit
if(function_exists('max_execution_time')) {
if( ini_get('max_execution_time') > 0 )  set_time_limit(0) ;
}
 
//END  OF  CONFIGURATIONS
 
/*
 Create backupDir (if it's not yet created ) , with proper permissions .
 Create a ".htaccess" file to restrict web-access
*/
if (!file_exists(BACKUP_DIR)) mkdir(BACKUP_DIR , 0700) ;
if (!is_writable(BACKUP_DIR)) chmod(BACKUP_DIR , 0700) ;
// Create an ".htaccess" file , it will restrict direct access to the backup-directory .
$content = 'deny from all' ;
$file = new SplFileObject(BACKUP_DIR . '/.htaccess', "w") ;
$written = $file->fwrite($content) ;
// Verify that ".htaccess" is written , if not , die the script
if($written <13) die("Could not create a \".htaccess\" file , Backup task canceled")  ;
// Check timestamp of the latest Archive . If older than 24Hour , Create a new Archive
$lastArchive = getNameOfLastArchieve(BACKUP_DIR)  ;
$timestampOfLatestArchive =  substr(ltrim((stristr($lastArchive , '&')) , '&') , 0 , -8)  ;
if (allowCreateNewArchive($timestampOfLatestArchive)) {
// Create a new Archive
createNewArchive($archiveName) ;
} else {
//echo 'Sorry the latest Archive is not older than 24Hours , try a few hours later '  ;
?>
		<div class="panel panel-default">
			<div class="panel-heading">Backup Database</div>
			<div class="panel-body">
				<table class='table table-striped table-bordered table-hover table-condensed'>
					<tr>
						<td><?php echo 'Sorry the latest Archive is not older than 24Hours , try a few hours later '  ;?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><a href='.'><button>Selesai</button></a></td>
					</tr>
				</table>
			</div>
		</div>
<?php
}
 
###########################
// DEFINING  THE FOUR  FUNCTIONS
// 1) createNewArchive : Creates an archive of a Mysql database
// 2) getFileSizeUnit  : gets an integer value and returns a proper Unit (Bytes , KB , MB)
// 3) getNameOfLastArchieve : Scans the "BackupDir" and returns the name of last created Archive
// 4) allowCreateNewArchive : Compares two timestamps (Yesterday , lastArchive) . Returns "TRUE" , If the latest Archive is onlder than 24Hours .
###########################
// Function createNewArchive
function createNewArchive($archiveName){
$mysqli = new mysqli(HOST , USER , PASSWORD , DB_NAME) ;
if (mysqli_connect_errno())
{
   printf("Connect failed: %s", mysqli_connect_error());
   exit();
}
 // Introduction information
 
$return = "--\n";
$return .= "-- A Mysql Backup System \n";
$return .= "--\n";
$return .= '-- Export created: ' . date("Y/m/d") . ' on ' . date("h:i") . "\n\n\n";
$return .= "--\n";
$return .= "-- Database : " . DB_NAME . "\n";
$return .= "--\n";
$return .= "-- --------------------------------------------------\n";
$return .= "-- ---------------------------------------------------\n";
$return .= 'SET AUTOCOMMIT = 0 ;' ."\n" ;
$return .= 'SET FOREIGN_KEY_CHECKS=0 ;' ."\n" ;
$tables = array() ;
// Exploring what tables this database has
$result = $mysqli->query('SHOW TABLES' ) ;
// Cycle through "$result" and put content into an array
while ($row = $result->fetch_row())
{
$tables[] = $row[0] ;
}
// Cycle through each  table
 foreach($tables as $table)
 {
// Get content of each table
$result = $mysqli->query('SELECT * FROM '. $table) ;
// Get number of fields (columns) of each table
$num_fields = $mysqli->field_count  ;
// Add table information
$return .= "--\n" ;
$return .= '-- Tabel structure for table `' . $table . '`' . "\n" ;
$return .= "--\n" ;
$return.= 'DROP TABLE  IF EXISTS `'.$table.'`;' . "\n" ;
// Get the table-shema
$shema = $mysqli->query('SHOW CREATE TABLE '.$table) ;
// Extract table shema
$tableshema = $shema->fetch_row() ;
// Append table-shema into code
$return.= $tableshema[1].";" . "\n\n" ;
// Cycle through each table-row
while($rowdata = $result->fetch_row())
{
// Prepare code that will insert data into table
$return .= 'INSERT INTO `'.$table .'`  VALUES ( '  ;
// Extract data of each row
for($i=0; $i<$num_fields; $i++)
{
$return .= '"'.$rowdata[$i] . "\"," ;
 }
 // Let's remove the last comma
 $return = substr("$return", 0, -1) ;
 $return .= ");" ."\n" ;
 }
 $return .= "\n\n" ;
}
// Close the connection
$mysqli->close() ;
$return .= 'SET FOREIGN_KEY_CHECKS = 1 ; '  . "\n" ;
$return .= 'COMMIT ; '  . "\n" ;
$return .= 'SET AUTOCOMMIT = 1 ; ' . "\n"  ;
//$file = file_put_contents($archiveName , $return) ;
$zip = new ZipArchive() ;
$resOpen = $zip->open(BACKUP_DIR . '/' .$archiveName.".zip" , ZIPARCHIVE::CREATE) ;
if( $resOpen ){
$zip->addFromString( $archiveName , "$return" ) ;
	}
$zip->close() ;
$fileSize = getFileSizeUnit(filesize(BACKUP_DIR . "/". $archiveName . '.zip')) ;
$message = <<<msg
  <h2>BACKUP  completed ,</h2><br>
  the archive has the name of  : <b>  $archiveName  </b> and it's file-size is :   $fileSize  .
 
 This zip archive can't be accessed via a web browser , as it's stored into a protected directory .
 
  It's highly recomended to transfer this backup to another filesystem , use your favorite FTP client to download the archieve .
msg;
?>
		<div class="panel panel-default">
			<div class="panel-heading">Backup Database</div>
			<div class="panel-body">
				<table class='table table-striped table-bordered table-hover table-condensed'>
					<tr>
						<td><?php echo $message;?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><a href='.'><button>Selesai</button></a></td>
					</tr>
				</table>
			</div>
		</div>
<?php
//echo $message ;
} // End of function creatNewArchive
 
// Function to append proper Unit after a file-size .
function getFileSizeUnit($file_size){
switch (true) {
	case ($file_size/1024 < 1) :
		return intval($file_size ) ." Bytes" ;
		break;
	case ($file_size/1024 >= 1 && $file_size/(1024*1024) < 1)  :
		return round(($file_size/1024) , 2) ." KB" ;
		break;
	default:
	return round($file_size/(1024*1024) , 2) ." MB" ;
}
} // End of Function getFileSizeUnit
 
// Funciton getNameOfLastArchieve
function getNameOfLastArchieve($backupDir) {
$allArchieves = array()  ;
$iterator = new DirectoryIterator($backupDir) ;
foreach ($iterator as $fileInfo) {
   if (!$fileInfo->isDir() && $fileInfo->getExtension() === 'zip') {
		$allArchieves[] = $fileInfo->getFilename() ;
 
	}
}
	return  end($allArchieves) ;
} // End of Function getNameOfLastArchieve
 
// Function allowCreateNewArchive
function allowCreateNewArchive($timestampOfLatestArchive , $timestamp = 24) {
	$yesterday =  mktime() - $timestamp*3600 ;
	return ($yesterday >= $timestampOfLatestArchive) ? true : false ;
} // End of Function allowCreateNewArchive
?>
<?php if (EW_DEBUG_ENABLED) echo ew_DebugMsg(); ?>
<?php include_once "footer.php" ?>
<?php
$cf05_backupproses_php->Page_Terminate();
?>
