<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t02_jaminaninfo.php" ?>
<?php include_once "t01_nasabahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t02_jaminan_delete = NULL; // Initialize page object first

class ct02_jaminan_delete extends ct02_jaminan {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't02_jaminan';

	// Page object name
	var $PageObjName = 't02_jaminan_delete';

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
		if (!$this->CheckToken || !ew_IsHttpPost())
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

		// Table object (t02_jaminan)
		if (!isset($GLOBALS["t02_jaminan"]) || get_class($GLOBALS["t02_jaminan"]) == "ct02_jaminan") {
			$GLOBALS["t02_jaminan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t02_jaminan"];
		}

		// Table object (t01_nasabah)
		if (!isset($GLOBALS['t01_nasabah'])) $GLOBALS['t01_nasabah'] = new ct01_nasabah();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't02_jaminan', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

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
				$this->Page_Terminate(ew_GetUrl("t02_jaminanlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nasabah_id->SetVisibility();
		$this->Merk_Type->SetVisibility();
		$this->No_Rangka->SetVisibility();
		$this->No_Mesin->SetVisibility();
		$this->Warna->SetVisibility();
		$this->No_Pol->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Atas_Nama->SetVisibility();

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
		global $EW_EXPORT, $t02_jaminan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t02_jaminan);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t02_jaminanlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t02_jaminan class, t02_jaminaninfo.php

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
				$this->Page_Terminate("t02_jaminanlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
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
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->nasabah_id->setDbValue($rs->fields('nasabah_id'));
		$this->Merk_Type->setDbValue($rs->fields('Merk_Type'));
		$this->No_Rangka->setDbValue($rs->fields('No_Rangka'));
		$this->No_Mesin->setDbValue($rs->fields('No_Mesin'));
		$this->Warna->setDbValue($rs->fields('Warna'));
		$this->No_Pol->setDbValue($rs->fields('No_Pol'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Atas_Nama->setDbValue($rs->fields('Atas_Nama'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nasabah_id->DbValue = $row['nasabah_id'];
		$this->Merk_Type->DbValue = $row['Merk_Type'];
		$this->No_Rangka->DbValue = $row['No_Rangka'];
		$this->No_Mesin->DbValue = $row['No_Mesin'];
		$this->Warna->DbValue = $row['Warna'];
		$this->No_Pol->DbValue = $row['No_Pol'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Atas_Nama->DbValue = $row['Atas_Nama'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nasabah_id
		// Merk_Type
		// No_Rangka
		// No_Mesin
		// Warna
		// No_Pol
		// Keterangan
		// Atas_Nama

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nasabah_id
		$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
		if (strval($this->nasabah_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->nasabah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t01_nasabah`";
		$sWhereWrk = "";
		$this->nasabah_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nasabah_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nasabah_id->ViewValue = $this->nasabah_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nasabah_id->ViewValue = $this->nasabah_id->CurrentValue;
			}
		} else {
			$this->nasabah_id->ViewValue = NULL;
		}
		$this->nasabah_id->ViewCustomAttributes = "";

		// Merk_Type
		$this->Merk_Type->ViewValue = $this->Merk_Type->CurrentValue;
		$this->Merk_Type->ViewCustomAttributes = "";

		// No_Rangka
		$this->No_Rangka->ViewValue = $this->No_Rangka->CurrentValue;
		$this->No_Rangka->ViewCustomAttributes = "";

		// No_Mesin
		$this->No_Mesin->ViewValue = $this->No_Mesin->CurrentValue;
		$this->No_Mesin->ViewCustomAttributes = "";

		// Warna
		$this->Warna->ViewValue = $this->Warna->CurrentValue;
		$this->Warna->ViewCustomAttributes = "";

		// No_Pol
		$this->No_Pol->ViewValue = $this->No_Pol->CurrentValue;
		$this->No_Pol->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Atas_Nama
		$this->Atas_Nama->ViewValue = $this->Atas_Nama->CurrentValue;
		$this->Atas_Nama->ViewCustomAttributes = "";

			// nasabah_id
			$this->nasabah_id->LinkCustomAttributes = "";
			$this->nasabah_id->HrefValue = "";
			$this->nasabah_id->TooltipValue = "";

			// Merk_Type
			$this->Merk_Type->LinkCustomAttributes = "";
			$this->Merk_Type->HrefValue = "";
			$this->Merk_Type->TooltipValue = "";

			// No_Rangka
			$this->No_Rangka->LinkCustomAttributes = "";
			$this->No_Rangka->HrefValue = "";
			$this->No_Rangka->TooltipValue = "";

			// No_Mesin
			$this->No_Mesin->LinkCustomAttributes = "";
			$this->No_Mesin->HrefValue = "";
			$this->No_Mesin->TooltipValue = "";

			// Warna
			$this->Warna->LinkCustomAttributes = "";
			$this->Warna->HrefValue = "";
			$this->Warna->TooltipValue = "";

			// No_Pol
			$this->No_Pol->LinkCustomAttributes = "";
			$this->No_Pol->HrefValue = "";
			$this->No_Pol->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Atas_Nama
			$this->Atas_Nama->LinkCustomAttributes = "";
			$this->Atas_Nama->HrefValue = "";
			$this->Atas_Nama->TooltipValue = "";
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

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

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
		} else {

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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_nasabah") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t01_nasabah"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->nasabah_id->setQueryStringValue($GLOBALS["t01_nasabah"]->id->QueryStringValue);
					$this->nasabah_id->setSessionValue($this->nasabah_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t01_nasabah"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t01_nasabah") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t01_nasabah"]->id->setFormValue($_POST["fk_id"]);
					$this->nasabah_id->setFormValue($GLOBALS["t01_nasabah"]->id->FormValue);
					$this->nasabah_id->setSessionValue($this->nasabah_id->FormValue);
					if (!is_numeric($GLOBALS["t01_nasabah"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t01_nasabah") {
				if ($this->nasabah_id->CurrentValue == "") $this->nasabah_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t02_jaminanlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t02_jaminan_delete)) $t02_jaminan_delete = new ct02_jaminan_delete();

// Page init
$t02_jaminan_delete->Page_Init();

// Page main
$t02_jaminan_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t02_jaminan_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft02_jaminandelete = new ew_Form("ft02_jaminandelete", "delete");

// Form_CustomValidate event
ft02_jaminandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft02_jaminandelete.ValidateRequired = true;
<?php } else { ?>
ft02_jaminandelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft02_jaminandelete.Lists["x_nasabah_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t01_nasabah"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $t02_jaminan_delete->ShowPageHeader(); ?>
<?php
$t02_jaminan_delete->ShowMessage();
?>
<form name="ft02_jaminandelete" id="ft02_jaminandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t02_jaminan_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t02_jaminan_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t02_jaminan">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t02_jaminan_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t02_jaminan->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t02_jaminan->nasabah_id->Visible) { // nasabah_id ?>
		<th><span id="elh_t02_jaminan_nasabah_id" class="t02_jaminan_nasabah_id"><?php echo $t02_jaminan->nasabah_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->Merk_Type->Visible) { // Merk_Type ?>
		<th><span id="elh_t02_jaminan_Merk_Type" class="t02_jaminan_Merk_Type"><?php echo $t02_jaminan->Merk_Type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->No_Rangka->Visible) { // No_Rangka ?>
		<th><span id="elh_t02_jaminan_No_Rangka" class="t02_jaminan_No_Rangka"><?php echo $t02_jaminan->No_Rangka->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->No_Mesin->Visible) { // No_Mesin ?>
		<th><span id="elh_t02_jaminan_No_Mesin" class="t02_jaminan_No_Mesin"><?php echo $t02_jaminan->No_Mesin->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
		<th><span id="elh_t02_jaminan_Warna" class="t02_jaminan_Warna"><?php echo $t02_jaminan->Warna->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->No_Pol->Visible) { // No_Pol ?>
		<th><span id="elh_t02_jaminan_No_Pol" class="t02_jaminan_No_Pol"><?php echo $t02_jaminan->No_Pol->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
		<th><span id="elh_t02_jaminan_Keterangan" class="t02_jaminan_Keterangan"><?php echo $t02_jaminan->Keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t02_jaminan->Atas_Nama->Visible) { // Atas_Nama ?>
		<th><span id="elh_t02_jaminan_Atas_Nama" class="t02_jaminan_Atas_Nama"><?php echo $t02_jaminan->Atas_Nama->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t02_jaminan_delete->RecCnt = 0;
$i = 0;
while (!$t02_jaminan_delete->Recordset->EOF) {
	$t02_jaminan_delete->RecCnt++;
	$t02_jaminan_delete->RowCnt++;

	// Set row properties
	$t02_jaminan->ResetAttrs();
	$t02_jaminan->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t02_jaminan_delete->LoadRowValues($t02_jaminan_delete->Recordset);

	// Render row
	$t02_jaminan_delete->RenderRow();
?>
	<tr<?php echo $t02_jaminan->RowAttributes() ?>>
<?php if ($t02_jaminan->nasabah_id->Visible) { // nasabah_id ?>
		<td<?php echo $t02_jaminan->nasabah_id->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_nasabah_id" class="t02_jaminan_nasabah_id">
<span<?php echo $t02_jaminan->nasabah_id->ViewAttributes() ?>>
<?php echo $t02_jaminan->nasabah_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->Merk_Type->Visible) { // Merk_Type ?>
		<td<?php echo $t02_jaminan->Merk_Type->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_Merk_Type" class="t02_jaminan_Merk_Type">
<span<?php echo $t02_jaminan->Merk_Type->ViewAttributes() ?>>
<?php echo $t02_jaminan->Merk_Type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->No_Rangka->Visible) { // No_Rangka ?>
		<td<?php echo $t02_jaminan->No_Rangka->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_No_Rangka" class="t02_jaminan_No_Rangka">
<span<?php echo $t02_jaminan->No_Rangka->ViewAttributes() ?>>
<?php echo $t02_jaminan->No_Rangka->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->No_Mesin->Visible) { // No_Mesin ?>
		<td<?php echo $t02_jaminan->No_Mesin->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_No_Mesin" class="t02_jaminan_No_Mesin">
<span<?php echo $t02_jaminan->No_Mesin->ViewAttributes() ?>>
<?php echo $t02_jaminan->No_Mesin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->Warna->Visible) { // Warna ?>
		<td<?php echo $t02_jaminan->Warna->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_Warna" class="t02_jaminan_Warna">
<span<?php echo $t02_jaminan->Warna->ViewAttributes() ?>>
<?php echo $t02_jaminan->Warna->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->No_Pol->Visible) { // No_Pol ?>
		<td<?php echo $t02_jaminan->No_Pol->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_No_Pol" class="t02_jaminan_No_Pol">
<span<?php echo $t02_jaminan->No_Pol->ViewAttributes() ?>>
<?php echo $t02_jaminan->No_Pol->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->Keterangan->Visible) { // Keterangan ?>
		<td<?php echo $t02_jaminan->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_Keterangan" class="t02_jaminan_Keterangan">
<span<?php echo $t02_jaminan->Keterangan->ViewAttributes() ?>>
<?php echo $t02_jaminan->Keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t02_jaminan->Atas_Nama->Visible) { // Atas_Nama ?>
		<td<?php echo $t02_jaminan->Atas_Nama->CellAttributes() ?>>
<span id="el<?php echo $t02_jaminan_delete->RowCnt ?>_t02_jaminan_Atas_Nama" class="t02_jaminan_Atas_Nama">
<span<?php echo $t02_jaminan->Atas_Nama->ViewAttributes() ?>>
<?php echo $t02_jaminan->Atas_Nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t02_jaminan_delete->Recordset->MoveNext();
}
$t02_jaminan_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t02_jaminan_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft02_jaminandelete.Init();
</script>
<?php
$t02_jaminan_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t02_jaminan_delete->Page_Terminate();
?>
