<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t01_nasabahinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t01_nasabah_delete = NULL; // Initialize page object first

class ct01_nasabah_delete extends ct01_nasabah {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't01_nasabah';

	// Page object name
	var $PageObjName = 't01_nasabah_delete';

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

		// Table object (t01_nasabah)
		if (!isset($GLOBALS["t01_nasabah"]) || get_class($GLOBALS["t01_nasabah"]) == "ct01_nasabah") {
			$GLOBALS["t01_nasabah"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t01_nasabah"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't01_nasabah', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t01_nasabahlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Nama->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->No_Telp_Hp->SetVisibility();
		$this->Pekerjaan->SetVisibility();
		$this->Pekerjaan_Alamat->SetVisibility();
		$this->Pekerjaan_No_Telp_Hp->SetVisibility();
		$this->Status->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->marketing_id->SetVisibility();

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
		global $EW_EXPORT, $t01_nasabah;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t01_nasabah);
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t01_nasabahlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t01_nasabah class, t01_nasabahinfo.php

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
				$this->Page_Terminate("t01_nasabahlist.php"); // Return to list
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
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->No_Telp_Hp->setDbValue($rs->fields('No_Telp_Hp'));
		$this->Pekerjaan->setDbValue($rs->fields('Pekerjaan'));
		$this->Pekerjaan_Alamat->setDbValue($rs->fields('Pekerjaan_Alamat'));
		$this->Pekerjaan_No_Telp_Hp->setDbValue($rs->fields('Pekerjaan_No_Telp_Hp'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->marketing_id->setDbValue($rs->fields('marketing_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->No_Telp_Hp->DbValue = $row['No_Telp_Hp'];
		$this->Pekerjaan->DbValue = $row['Pekerjaan'];
		$this->Pekerjaan_Alamat->DbValue = $row['Pekerjaan_Alamat'];
		$this->Pekerjaan_No_Telp_Hp->DbValue = $row['Pekerjaan_No_Telp_Hp'];
		$this->Status->DbValue = $row['Status'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->marketing_id->DbValue = $row['marketing_id'];
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
		// No_Telp_Hp
		// Pekerjaan
		// Pekerjaan_Alamat
		// Pekerjaan_No_Telp_Hp
		// Status
		// Keterangan
		// marketing_id

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

		// No_Telp_Hp
		$this->No_Telp_Hp->ViewValue = $this->No_Telp_Hp->CurrentValue;
		$this->No_Telp_Hp->ViewCustomAttributes = "";

		// Pekerjaan
		$this->Pekerjaan->ViewValue = $this->Pekerjaan->CurrentValue;
		$this->Pekerjaan->ViewCustomAttributes = "";

		// Pekerjaan_Alamat
		$this->Pekerjaan_Alamat->ViewValue = $this->Pekerjaan_Alamat->CurrentValue;
		$this->Pekerjaan_Alamat->ViewCustomAttributes = "";

		// Pekerjaan_No_Telp_Hp
		$this->Pekerjaan_No_Telp_Hp->ViewValue = $this->Pekerjaan_No_Telp_Hp->CurrentValue;
		$this->Pekerjaan_No_Telp_Hp->ViewCustomAttributes = "";

		// Status
		if (strval($this->Status->CurrentValue) <> "") {
			$this->Status->ViewValue = $this->Status->OptionCaption($this->Status->CurrentValue);
		} else {
			$this->Status->ViewValue = NULL;
		}
		$this->Status->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// marketing_id
		if (strval($this->marketing_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->marketing_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, `NoHP` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_marketing`";
		$sWhereWrk = "";
		$this->marketing_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->marketing_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->marketing_id->ViewValue = $this->marketing_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->marketing_id->ViewValue = $this->marketing_id->CurrentValue;
			}
		} else {
			$this->marketing_id->ViewValue = NULL;
		}
		$this->marketing_id->ViewCustomAttributes = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";
			$this->Alamat->TooltipValue = "";

			// No_Telp_Hp
			$this->No_Telp_Hp->LinkCustomAttributes = "";
			$this->No_Telp_Hp->HrefValue = "";
			$this->No_Telp_Hp->TooltipValue = "";

			// Pekerjaan
			$this->Pekerjaan->LinkCustomAttributes = "";
			$this->Pekerjaan->HrefValue = "";
			$this->Pekerjaan->TooltipValue = "";

			// Pekerjaan_Alamat
			$this->Pekerjaan_Alamat->LinkCustomAttributes = "";
			$this->Pekerjaan_Alamat->HrefValue = "";
			$this->Pekerjaan_Alamat->TooltipValue = "";

			// Pekerjaan_No_Telp_Hp
			$this->Pekerjaan_No_Telp_Hp->LinkCustomAttributes = "";
			$this->Pekerjaan_No_Telp_Hp->HrefValue = "";
			$this->Pekerjaan_No_Telp_Hp->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// marketing_id
			$this->marketing_id->LinkCustomAttributes = "";
			$this->marketing_id->HrefValue = "";
			$this->marketing_id->TooltipValue = "";
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t01_nasabahlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t01_nasabah_delete)) $t01_nasabah_delete = new ct01_nasabah_delete();

// Page init
$t01_nasabah_delete->Page_Init();

// Page main
$t01_nasabah_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t01_nasabah_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft01_nasabahdelete = new ew_Form("ft01_nasabahdelete", "delete");

// Form_CustomValidate event
ft01_nasabahdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft01_nasabahdelete.ValidateRequired = true;
<?php } else { ?>
ft01_nasabahdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft01_nasabahdelete.Lists["x_Status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft01_nasabahdelete.Lists["x_Status"].Options = <?php echo json_encode($t01_nasabah->Status->Options()) ?>;
ft01_nasabahdelete.Lists["x_marketing_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_Nama","x_NoHP","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t07_marketing"};

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
<?php $t01_nasabah_delete->ShowPageHeader(); ?>
<?php
$t01_nasabah_delete->ShowMessage();
?>
<form name="ft01_nasabahdelete" id="ft01_nasabahdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t01_nasabah_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t01_nasabah_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t01_nasabah">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t01_nasabah_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t01_nasabah->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t01_nasabah->Nama->Visible) { // Nama ?>
		<th><span id="elh_t01_nasabah_Nama" class="t01_nasabah_Nama"><?php echo $t01_nasabah->Nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
		<th><span id="elh_t01_nasabah_Alamat" class="t01_nasabah_Alamat"><?php echo $t01_nasabah->Alamat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->No_Telp_Hp->Visible) { // No_Telp_Hp ?>
		<th><span id="elh_t01_nasabah_No_Telp_Hp" class="t01_nasabah_No_Telp_Hp"><?php echo $t01_nasabah->No_Telp_Hp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<th><span id="elh_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan"><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_Alamat->Visible) { // Pekerjaan_Alamat ?>
		<th><span id="elh_t01_nasabah_Pekerjaan_Alamat" class="t01_nasabah_Pekerjaan_Alamat"><?php echo $t01_nasabah->Pekerjaan_Alamat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_No_Telp_Hp->Visible) { // Pekerjaan_No_Telp_Hp ?>
		<th><span id="elh_t01_nasabah_Pekerjaan_No_Telp_Hp" class="t01_nasabah_Pekerjaan_No_Telp_Hp"><?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Status->Visible) { // Status ?>
		<th><span id="elh_t01_nasabah_Status" class="t01_nasabah_Status"><?php echo $t01_nasabah->Status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
		<th><span id="elh_t01_nasabah_Keterangan" class="t01_nasabah_Keterangan"><?php echo $t01_nasabah->Keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t01_nasabah->marketing_id->Visible) { // marketing_id ?>
		<th><span id="elh_t01_nasabah_marketing_id" class="t01_nasabah_marketing_id"><?php echo $t01_nasabah->marketing_id->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t01_nasabah_delete->RecCnt = 0;
$i = 0;
while (!$t01_nasabah_delete->Recordset->EOF) {
	$t01_nasabah_delete->RecCnt++;
	$t01_nasabah_delete->RowCnt++;

	// Set row properties
	$t01_nasabah->ResetAttrs();
	$t01_nasabah->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t01_nasabah_delete->LoadRowValues($t01_nasabah_delete->Recordset);

	// Render row
	$t01_nasabah_delete->RenderRow();
?>
	<tr<?php echo $t01_nasabah->RowAttributes() ?>>
<?php if ($t01_nasabah->Nama->Visible) { // Nama ?>
		<td<?php echo $t01_nasabah->Nama->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Nama" class="t01_nasabah_Nama">
<span<?php echo $t01_nasabah->Nama->ViewAttributes() ?>>
<?php echo $t01_nasabah->Nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
		<td<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Alamat" class="t01_nasabah_Alamat">
<span<?php echo $t01_nasabah->Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Alamat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->No_Telp_Hp->Visible) { // No_Telp_Hp ?>
		<td<?php echo $t01_nasabah->No_Telp_Hp->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_No_Telp_Hp" class="t01_nasabah_No_Telp_Hp">
<span<?php echo $t01_nasabah->No_Telp_Hp->ViewAttributes() ?>>
<?php echo $t01_nasabah->No_Telp_Hp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<td<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Pekerjaan" class="t01_nasabah_Pekerjaan">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_Alamat->Visible) { // Pekerjaan_Alamat ?>
		<td<?php echo $t01_nasabah->Pekerjaan_Alamat->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Pekerjaan_Alamat" class="t01_nasabah_Pekerjaan_Alamat">
<span<?php echo $t01_nasabah->Pekerjaan_Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan_Alamat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_No_Telp_Hp->Visible) { // Pekerjaan_No_Telp_Hp ?>
		<td<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Pekerjaan_No_Telp_Hp" class="t01_nasabah_Pekerjaan_No_Telp_Hp">
<span<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Status->Visible) { // Status ?>
		<td<?php echo $t01_nasabah->Status->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Status" class="t01_nasabah_Status">
<span<?php echo $t01_nasabah->Status->ViewAttributes() ?>>
<?php echo $t01_nasabah->Status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
		<td<?php echo $t01_nasabah->Keterangan->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_Keterangan" class="t01_nasabah_Keterangan">
<span<?php echo $t01_nasabah->Keterangan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t01_nasabah->marketing_id->Visible) { // marketing_id ?>
		<td<?php echo $t01_nasabah->marketing_id->CellAttributes() ?>>
<span id="el<?php echo $t01_nasabah_delete->RowCnt ?>_t01_nasabah_marketing_id" class="t01_nasabah_marketing_id">
<span<?php echo $t01_nasabah->marketing_id->ViewAttributes() ?>>
<?php echo $t01_nasabah->marketing_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t01_nasabah_delete->Recordset->MoveNext();
}
$t01_nasabah_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t01_nasabah_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft01_nasabahdelete.Init();
</script>
<?php
$t01_nasabah_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t01_nasabah_delete->Page_Terminate();
?>
