<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t91_rekeninginfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t91_rekening_add = NULL; // Initialize page object first

class ct91_rekening_add extends ct91_rekening {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't91_rekening';

	// Page object name
	var $PageObjName = 't91_rekening_add';

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

		// Table object (t91_rekening)
		if (!isset($GLOBALS["t91_rekening"]) || get_class($GLOBALS["t91_rekening"]) == "ct91_rekening") {
			$GLOBALS["t91_rekening"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t91_rekening"];
		}

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't91_rekening', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t91_rekeninglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->group->SetVisibility();
		$this->parent->SetVisibility();
		$this->id3->SetVisibility();
		$this->rekening->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->tipe->SetVisibility();
		$this->status->SetVisibility();
		$this->Saldo->SetVisibility();
		$this->Periode->SetVisibility();

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
		global $EW_EXPORT, $t91_rekening;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t91_rekening);
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
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t91_rekeninglist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t91_rekeninglist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t91_rekeningview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->group->CurrentValue = 0;
		$this->parent->CurrentValue = NULL;
		$this->parent->OldValue = $this->parent->CurrentValue;
		$this->id3->CurrentValue = NULL;
		$this->id3->OldValue = $this->id3->CurrentValue;
		$this->rekening->CurrentValue = NULL;
		$this->rekening->OldValue = $this->rekening->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->tipe->CurrentValue = NULL;
		$this->tipe->OldValue = $this->tipe->CurrentValue;
		$this->status->CurrentValue = NULL;
		$this->status->OldValue = $this->status->CurrentValue;
		$this->Saldo->CurrentValue = 0.00;
		$this->Periode->CurrentValue = NULL;
		$this->Periode->OldValue = $this->Periode->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->group->FldIsDetailKey) {
			$this->group->setFormValue($objForm->GetValue("x_group"));
		}
		if (!$this->parent->FldIsDetailKey) {
			$this->parent->setFormValue($objForm->GetValue("x_parent"));
		}
		if (!$this->id3->FldIsDetailKey) {
			$this->id3->setFormValue($objForm->GetValue("x_id3"));
		}
		if (!$this->rekening->FldIsDetailKey) {
			$this->rekening->setFormValue($objForm->GetValue("x_rekening"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->tipe->FldIsDetailKey) {
			$this->tipe->setFormValue($objForm->GetValue("x_tipe"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->Saldo->FldIsDetailKey) {
			$this->Saldo->setFormValue($objForm->GetValue("x_Saldo"));
		}
		if (!$this->Periode->FldIsDetailKey) {
			$this->Periode->setFormValue($objForm->GetValue("x_Periode"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->group->CurrentValue = $this->group->FormValue;
		$this->parent->CurrentValue = $this->parent->FormValue;
		$this->id3->CurrentValue = $this->id3->FormValue;
		$this->rekening->CurrentValue = $this->rekening->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->tipe->CurrentValue = $this->tipe->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->Saldo->CurrentValue = $this->Saldo->FormValue;
		$this->Periode->CurrentValue = $this->Periode->FormValue;
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
		$this->group->setDbValue($rs->fields('group'));
		$this->id->setDbValue($rs->fields('id'));
		$this->id1->setDbValue($rs->fields('id1'));
		$this->id2->setDbValue($rs->fields('id2'));
		$this->parent->setDbValue($rs->fields('parent'));
		$this->id3->setDbValue($rs->fields('id3'));
		$this->rekening->setDbValue($rs->fields('rekening'));
		$this->posisi->setDbValue($rs->fields('posisi'));
		$this->laporan->setDbValue($rs->fields('laporan'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->status->setDbValue($rs->fields('status'));
		$this->active->setDbValue($rs->fields('active'));
		$this->group2->setDbValue($rs->fields('group2'));
		$this->Saldo->setDbValue($rs->fields('Saldo'));
		$this->Periode->setDbValue($rs->fields('Periode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->group->DbValue = $row['group'];
		$this->id->DbValue = $row['id'];
		$this->id1->DbValue = $row['id1'];
		$this->id2->DbValue = $row['id2'];
		$this->parent->DbValue = $row['parent'];
		$this->id3->DbValue = $row['id3'];
		$this->rekening->DbValue = $row['rekening'];
		$this->posisi->DbValue = $row['posisi'];
		$this->laporan->DbValue = $row['laporan'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->tipe->DbValue = $row['tipe'];
		$this->status->DbValue = $row['status'];
		$this->active->DbValue = $row['active'];
		$this->group2->DbValue = $row['group2'];
		$this->Saldo->DbValue = $row['Saldo'];
		$this->Periode->DbValue = $row['Periode'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Saldo->FormValue == $this->Saldo->CurrentValue && is_numeric(ew_StrToFloat($this->Saldo->CurrentValue)))
			$this->Saldo->CurrentValue = ew_StrToFloat($this->Saldo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// group
		// id
		// id1
		// id2
		// parent
		// id3
		// rekening
		// posisi
		// laporan
		// keterangan
		// tipe
		// status
		// active
		// group2
		// Saldo
		// Periode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// group
		if (strval($this->group->CurrentValue) <> "") {
			$sFilterWrk = "`group`" . ew_SearchString("=", $this->group->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `group`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
		$sWhereWrk = "";
		$this->group->LookupFilters = array();
		$lookuptblfilter = "`tipe` = 'GROUP'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->group, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->group->ViewValue = $this->group->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->group->ViewValue = $this->group->CurrentValue;
			}
		} else {
			$this->group->ViewValue = NULL;
		}
		$this->group->ViewCustomAttributes = "";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id1
		$this->id1->ViewValue = $this->id1->CurrentValue;
		$this->id1->ViewCustomAttributes = "";

		// id2
		$this->id2->ViewValue = $this->id2->CurrentValue;
		$this->id2->ViewCustomAttributes = "";

		// parent
		if (strval($this->parent->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->parent->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
		$sWhereWrk = "";
		$this->parent->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->parent, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->parent->ViewValue = $this->parent->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->parent->ViewValue = $this->parent->CurrentValue;
			}
		} else {
			$this->parent->ViewValue = NULL;
		}
		$this->parent->ViewCustomAttributes = "";

		// id3
		$this->id3->ViewValue = $this->id3->CurrentValue;
		$this->id3->ViewCustomAttributes = "";

		// rekening
		$this->rekening->ViewValue = $this->rekening->CurrentValue;
		$this->rekening->ViewCustomAttributes = "";

		// posisi
		$this->posisi->ViewValue = $this->posisi->CurrentValue;
		$this->posisi->ViewCustomAttributes = "";

		// laporan
		$this->laporan->ViewValue = $this->laporan->CurrentValue;
		$this->laporan->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// tipe
		if (strval($this->tipe->CurrentValue) <> "") {
			$this->tipe->ViewValue = $this->tipe->OptionCaption($this->tipe->CurrentValue);
		} else {
			$this->tipe->ViewValue = NULL;
		}
		$this->tipe->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = "";
			$arwrk = explode(",", strval($this->status->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->status->ViewValue .= $this->status->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->status->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// active
		if (strval($this->active->CurrentValue) <> "") {
			$this->active->ViewValue = $this->active->OptionCaption($this->active->CurrentValue);
		} else {
			$this->active->ViewValue = NULL;
		}
		$this->active->ViewCustomAttributes = "";

		// group2
		$this->group2->ViewValue = $this->group2->CurrentValue;
		$this->group2->ViewCustomAttributes = "";

		// Saldo
		$this->Saldo->ViewValue = $this->Saldo->CurrentValue;
		$this->Saldo->ViewValue = ew_FormatNumber($this->Saldo->ViewValue, 2, -2, -2, -2);
		$this->Saldo->CellCssStyle .= "text-align: right;";
		$this->Saldo->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

			// group
			$this->group->LinkCustomAttributes = "";
			$this->group->HrefValue = "";
			$this->group->TooltipValue = "";

			// parent
			$this->parent->LinkCustomAttributes = "";
			$this->parent->HrefValue = "";
			$this->parent->TooltipValue = "";

			// id3
			$this->id3->LinkCustomAttributes = "";
			$this->id3->HrefValue = "";
			$this->id3->TooltipValue = "";

			// rekening
			$this->rekening->LinkCustomAttributes = "";
			$this->rekening->HrefValue = "";
			$this->rekening->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// tipe
			$this->tipe->LinkCustomAttributes = "";
			$this->tipe->HrefValue = "";
			$this->tipe->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// Saldo
			$this->Saldo->LinkCustomAttributes = "";
			$this->Saldo->HrefValue = "";
			$this->Saldo->TooltipValue = "";

			// Periode
			$this->Periode->LinkCustomAttributes = "";
			$this->Periode->HrefValue = "";
			$this->Periode->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// group
			$this->group->EditAttrs["class"] = "form-control";
			$this->group->EditCustomAttributes = "";
			if (trim(strval($this->group->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`group`" . ew_SearchString("=", $this->group->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `group`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->group->LookupFilters = array();
			$lookuptblfilter = "`tipe` = 'GROUP'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->group, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->group->EditValue = $arwrk;

			// parent
			$this->parent->EditAttrs["class"] = "form-control";
			$this->parent->EditCustomAttributes = "";
			if (trim(strval($this->parent->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->parent->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, substring(id,1,1) AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->parent->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->parent, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->parent->EditValue = $arwrk;

			// id3
			$this->id3->EditAttrs["class"] = "form-control";
			$this->id3->EditCustomAttributes = "";
			$this->id3->EditValue = ew_HtmlEncode($this->id3->CurrentValue);
			$this->id3->PlaceHolder = ew_RemoveHtml($this->id3->FldCaption());

			// rekening
			$this->rekening->EditAttrs["class"] = "form-control";
			$this->rekening->EditCustomAttributes = "";
			$this->rekening->EditValue = ew_HtmlEncode($this->rekening->CurrentValue);
			$this->rekening->PlaceHolder = ew_RemoveHtml($this->rekening->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// tipe
			$this->tipe->EditCustomAttributes = "";
			$this->tipe->EditValue = $this->tipe->Options(FALSE);

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// Saldo
			$this->Saldo->EditAttrs["class"] = "form-control";
			$this->Saldo->EditCustomAttributes = "";
			$this->Saldo->EditValue = ew_HtmlEncode($this->Saldo->CurrentValue);
			$this->Saldo->PlaceHolder = ew_RemoveHtml($this->Saldo->FldCaption());
			if (strval($this->Saldo->EditValue) <> "" && is_numeric($this->Saldo->EditValue)) $this->Saldo->EditValue = ew_FormatNumber($this->Saldo->EditValue, -2, -2, -2, -2);

			// Periode
			$this->Periode->EditAttrs["class"] = "form-control";
			$this->Periode->EditCustomAttributes = "";
			$this->Periode->EditValue = ew_HtmlEncode($this->Periode->CurrentValue);
			$this->Periode->PlaceHolder = ew_RemoveHtml($this->Periode->FldCaption());

			// Add refer script
			// group

			$this->group->LinkCustomAttributes = "";
			$this->group->HrefValue = "";

			// parent
			$this->parent->LinkCustomAttributes = "";
			$this->parent->HrefValue = "";

			// id3
			$this->id3->LinkCustomAttributes = "";
			$this->id3->HrefValue = "";

			// rekening
			$this->rekening->LinkCustomAttributes = "";
			$this->rekening->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// tipe
			$this->tipe->LinkCustomAttributes = "";
			$this->tipe->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// Saldo
			$this->Saldo->LinkCustomAttributes = "";
			$this->Saldo->HrefValue = "";

			// Periode
			$this->Periode->LinkCustomAttributes = "";
			$this->Periode->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

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
		if (!$this->Saldo->FldIsDetailKey && !is_null($this->Saldo->FormValue) && $this->Saldo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Saldo->FldCaption(), $this->Saldo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Saldo->FormValue)) {
			ew_AddMessage($gsFormError, $this->Saldo->FldErrMsg());
		}
		if (!$this->Periode->FldIsDetailKey && !is_null($this->Periode->FormValue) && $this->Periode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Periode->FldCaption(), $this->Periode->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// group
		$this->group->SetDbValueDef($rsnew, $this->group->CurrentValue, NULL, strval($this->group->CurrentValue) == "");

		// parent
		$this->parent->SetDbValueDef($rsnew, $this->parent->CurrentValue, NULL, FALSE);

		// id3
		$this->id3->SetDbValueDef($rsnew, $this->id3->CurrentValue, "", FALSE);

		// rekening
		$this->rekening->SetDbValueDef($rsnew, $this->rekening->CurrentValue, NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// tipe
		$this->tipe->SetDbValueDef($rsnew, $this->tipe->CurrentValue, NULL, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, FALSE);

		// Saldo
		$this->Saldo->SetDbValueDef($rsnew, $this->Saldo->CurrentValue, 0, strval($this->Saldo->CurrentValue) == "");

		// Periode
		$this->Periode->SetDbValueDef($rsnew, $this->Periode->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t91_rekeninglist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_group":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `group` AS `LinkFld`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->group->LookupFilters = array();
			$lookuptblfilter = "`tipe` = 'GROUP'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`group` = {filter_value}', "t0" => "20", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->group, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_parent":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
			$sWhereWrk = "{filter}";
			$this->parent->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => 'substring(id,1,1) IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->parent, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t91_rekening_add)) $t91_rekening_add = new ct91_rekening_add();

// Page init
$t91_rekening_add->Page_Init();

// Page main
$t91_rekening_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t91_rekening_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft91_rekeningadd = new ew_Form("ft91_rekeningadd", "add");

// Validate form
ft91_rekeningadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Saldo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t91_rekening->Saldo->FldCaption(), $t91_rekening->Saldo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Saldo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t91_rekening->Saldo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Periode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t91_rekening->Periode->FldCaption(), $t91_rekening->Periode->ReqErrMsg)) ?>");

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
ft91_rekeningadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft91_rekeningadd.ValidateRequired = true;
<?php } else { ?>
ft91_rekeningadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft91_rekeningadd.Lists["x_group"] = {"LinkField":"x_group","Ajax":true,"AutoFill":false,"DisplayFields":["x_rekening","","",""],"ParentFields":[],"ChildFields":["x_parent"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t91_rekening"};
ft91_rekeningadd.Lists["x_parent"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_rekening","","",""],"ParentFields":["x_group"],"ChildFields":[],"FilterFields":["x_group2"],"Options":[],"Template":"","LinkTable":"t91_rekening"};
ft91_rekeningadd.Lists["x_tipe"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft91_rekeningadd.Lists["x_tipe"].Options = <?php echo json_encode($t91_rekening->tipe->Options()) ?>;
ft91_rekeningadd.Lists["x_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft91_rekeningadd.Lists["x_status[]"].Options = <?php echo json_encode($t91_rekening->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t91_rekening_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $t91_rekening_add->ShowPageHeader(); ?>
<?php
$t91_rekening_add->ShowMessage();
?>
<form name="ft91_rekeningadd" id="ft91_rekeningadd" class="<?php echo $t91_rekening_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t91_rekening_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t91_rekening_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t91_rekening">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t91_rekening_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t91_rekening->group->Visible) { // group ?>
	<div id="r_group" class="form-group">
		<label id="elh_t91_rekening_group" for="x_group" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->group->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->group->CellAttributes() ?>>
<span id="el_t91_rekening_group">
<?php $t91_rekening->group->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t91_rekening->group->EditAttrs["onchange"]; ?>
<select data-table="t91_rekening" data-field="x_group" data-value-separator="<?php echo $t91_rekening->group->DisplayValueSeparatorAttribute() ?>" id="x_group" name="x_group"<?php echo $t91_rekening->group->EditAttributes() ?>>
<?php echo $t91_rekening->group->SelectOptionListHtml("x_group") ?>
</select>
<input type="hidden" name="s_x_group" id="s_x_group" value="<?php echo $t91_rekening->group->LookupFilterQuery() ?>">
</span>
<?php echo $t91_rekening->group->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->parent->Visible) { // parent ?>
	<div id="r_parent" class="form-group">
		<label id="elh_t91_rekening_parent" for="x_parent" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->parent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->parent->CellAttributes() ?>>
<span id="el_t91_rekening_parent">
<select data-table="t91_rekening" data-field="x_parent" data-value-separator="<?php echo $t91_rekening->parent->DisplayValueSeparatorAttribute() ?>" id="x_parent" name="x_parent"<?php echo $t91_rekening->parent->EditAttributes() ?>>
<?php echo $t91_rekening->parent->SelectOptionListHtml("x_parent") ?>
</select>
<input type="hidden" name="s_x_parent" id="s_x_parent" value="<?php echo $t91_rekening->parent->LookupFilterQuery() ?>">
</span>
<?php echo $t91_rekening->parent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->id3->Visible) { // id3 ?>
	<div id="r_id3" class="form-group">
		<label id="elh_t91_rekening_id3" for="x_id3" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->id3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->id3->CellAttributes() ?>>
<span id="el_t91_rekening_id3">
<input type="text" data-table="t91_rekening" data-field="x_id3" name="x_id3" id="x_id3" size="30" maxlength="35" placeholder="<?php echo ew_HtmlEncode($t91_rekening->id3->getPlaceHolder()) ?>" value="<?php echo $t91_rekening->id3->EditValue ?>"<?php echo $t91_rekening->id3->EditAttributes() ?>>
</span>
<?php echo $t91_rekening->id3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->rekening->Visible) { // rekening ?>
	<div id="r_rekening" class="form-group">
		<label id="elh_t91_rekening_rekening" for="x_rekening" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->rekening->CellAttributes() ?>>
<span id="el_t91_rekening_rekening">
<input type="text" data-table="t91_rekening" data-field="x_rekening" name="x_rekening" id="x_rekening" size="30" maxlength="90" placeholder="<?php echo ew_HtmlEncode($t91_rekening->rekening->getPlaceHolder()) ?>" value="<?php echo $t91_rekening->rekening->EditValue ?>"<?php echo $t91_rekening->rekening->EditAttributes() ?>>
</span>
<?php echo $t91_rekening->rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_t91_rekening_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->keterangan->CellAttributes() ?>>
<span id="el_t91_rekening_keterangan">
<input type="text" data-table="t91_rekening" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t91_rekening->keterangan->getPlaceHolder()) ?>" value="<?php echo $t91_rekening->keterangan->EditValue ?>"<?php echo $t91_rekening->keterangan->EditAttributes() ?>>
</span>
<?php echo $t91_rekening->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->tipe->Visible) { // tipe ?>
	<div id="r_tipe" class="form-group">
		<label id="elh_t91_rekening_tipe" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->tipe->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->tipe->CellAttributes() ?>>
<span id="el_t91_rekening_tipe">
<div id="tp_x_tipe" class="ewTemplate"><input type="radio" data-table="t91_rekening" data-field="x_tipe" data-value-separator="<?php echo $t91_rekening->tipe->DisplayValueSeparatorAttribute() ?>" name="x_tipe" id="x_tipe" value="{value}"<?php echo $t91_rekening->tipe->EditAttributes() ?>></div>
<div id="dsl_x_tipe" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t91_rekening->tipe->RadioButtonListHtml(FALSE, "x_tipe") ?>
</div></div>
</span>
<?php echo $t91_rekening->tipe->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_t91_rekening_status" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->status->CellAttributes() ?>>
<span id="el_t91_rekening_status">
<div id="tp_x_status" class="ewTemplate"><input type="checkbox" data-table="t91_rekening" data-field="x_status" data-value-separator="<?php echo $t91_rekening->status->DisplayValueSeparatorAttribute() ?>" name="x_status[]" id="x_status[]" value="{value}"<?php echo $t91_rekening->status->EditAttributes() ?>></div>
<div id="dsl_x_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t91_rekening->status->CheckBoxListHtml(FALSE, "x_status[]") ?>
</div></div>
</span>
<?php echo $t91_rekening->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->Saldo->Visible) { // Saldo ?>
	<div id="r_Saldo" class="form-group">
		<label id="elh_t91_rekening_Saldo" for="x_Saldo" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->Saldo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->Saldo->CellAttributes() ?>>
<span id="el_t91_rekening_Saldo">
<input type="text" data-table="t91_rekening" data-field="x_Saldo" name="x_Saldo" id="x_Saldo" size="15" placeholder="<?php echo ew_HtmlEncode($t91_rekening->Saldo->getPlaceHolder()) ?>" value="<?php echo $t91_rekening->Saldo->EditValue ?>"<?php echo $t91_rekening->Saldo->EditAttributes() ?>>
</span>
<?php echo $t91_rekening->Saldo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t91_rekening->Periode->Visible) { // Periode ?>
	<div id="r_Periode" class="form-group">
		<label id="elh_t91_rekening_Periode" for="x_Periode" class="col-sm-2 control-label ewLabel"><?php echo $t91_rekening->Periode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t91_rekening->Periode->CellAttributes() ?>>
<span id="el_t91_rekening_Periode">
<input type="text" data-table="t91_rekening" data-field="x_Periode" name="x_Periode" id="x_Periode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($t91_rekening->Periode->getPlaceHolder()) ?>" value="<?php echo $t91_rekening->Periode->EditValue ?>"<?php echo $t91_rekening->Periode->EditAttributes() ?>>
</span>
<?php echo $t91_rekening->Periode->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t91_rekening_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t91_rekening_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft91_rekeningadd.Init();
</script>
<?php
$t91_rekening_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t91_rekening_add->Page_Terminate();
?>
