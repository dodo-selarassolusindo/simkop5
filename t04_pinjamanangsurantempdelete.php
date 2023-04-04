<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t04_pinjamanangsurantempinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t04_pinjamanangsurantemp_delete = NULL; // Initialize page object first

class ct04_pinjamanangsurantemp_delete extends ct04_pinjamanangsurantemp {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't04_pinjamanangsurantemp';

	// Page object name
	var $PageObjName = 't04_pinjamanangsurantemp_delete';

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t04_pinjamanangsurantemp)
		if (!isset($GLOBALS["t04_pinjamanangsurantemp"]) || get_class($GLOBALS["t04_pinjamanangsurantemp"]) == "ct04_pinjamanangsurantemp") {
			$GLOBALS["t04_pinjamanangsurantemp"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t04_pinjamanangsurantemp"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't04_pinjamanangsurantemp', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->pinjaman_id->SetVisibility();
		$this->Angsuran_Ke->SetVisibility();
		$this->Angsuran_Tanggal->SetVisibility();
		$this->Angsuran_Pokok->SetVisibility();
		$this->Angsuran_Bunga->SetVisibility();
		$this->Angsuran_Total->SetVisibility();
		$this->Sisa_Hutang->SetVisibility();
		$this->Tanggal_Bayar->SetVisibility();
		$this->Terlambat->SetVisibility();
		$this->Total_Denda->SetVisibility();
		$this->Bayar_Titipan->SetVisibility();
		$this->Bayar_Non_Titipan->SetVisibility();
		$this->Bayar_Total->SetVisibility();
		$this->Flag_Edit->SetVisibility();

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
		global $EW_EXPORT, $t04_pinjamanangsurantemp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t04_pinjamanangsurantemp);
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
			$this->Page_Terminate("t04_pinjamanangsurantemplist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t04_pinjamanangsurantemp class, t04_pinjamanangsurantempinfo.php

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
				$this->Page_Terminate("t04_pinjamanangsurantemplist.php"); // Return to list
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
		$this->pinjaman_id->setDbValue($rs->fields('pinjaman_id'));
		$this->Angsuran_Ke->setDbValue($rs->fields('Angsuran_Ke'));
		$this->Angsuran_Tanggal->setDbValue($rs->fields('Angsuran_Tanggal'));
		$this->Angsuran_Pokok->setDbValue($rs->fields('Angsuran_Pokok'));
		$this->Angsuran_Bunga->setDbValue($rs->fields('Angsuran_Bunga'));
		$this->Angsuran_Total->setDbValue($rs->fields('Angsuran_Total'));
		$this->Sisa_Hutang->setDbValue($rs->fields('Sisa_Hutang'));
		$this->Tanggal_Bayar->setDbValue($rs->fields('Tanggal_Bayar'));
		$this->Terlambat->setDbValue($rs->fields('Terlambat'));
		$this->Total_Denda->setDbValue($rs->fields('Total_Denda'));
		$this->Bayar_Titipan->setDbValue($rs->fields('Bayar_Titipan'));
		$this->Bayar_Non_Titipan->setDbValue($rs->fields('Bayar_Non_Titipan'));
		$this->Bayar_Total->setDbValue($rs->fields('Bayar_Total'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Flag_Edit->setDbValue($rs->fields('Flag_Edit'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->pinjaman_id->DbValue = $row['pinjaman_id'];
		$this->Angsuran_Ke->DbValue = $row['Angsuran_Ke'];
		$this->Angsuran_Tanggal->DbValue = $row['Angsuran_Tanggal'];
		$this->Angsuran_Pokok->DbValue = $row['Angsuran_Pokok'];
		$this->Angsuran_Bunga->DbValue = $row['Angsuran_Bunga'];
		$this->Angsuran_Total->DbValue = $row['Angsuran_Total'];
		$this->Sisa_Hutang->DbValue = $row['Sisa_Hutang'];
		$this->Tanggal_Bayar->DbValue = $row['Tanggal_Bayar'];
		$this->Terlambat->DbValue = $row['Terlambat'];
		$this->Total_Denda->DbValue = $row['Total_Denda'];
		$this->Bayar_Titipan->DbValue = $row['Bayar_Titipan'];
		$this->Bayar_Non_Titipan->DbValue = $row['Bayar_Non_Titipan'];
		$this->Bayar_Total->DbValue = $row['Bayar_Total'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Flag_Edit->DbValue = $row['Flag_Edit'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Angsuran_Pokok->FormValue == $this->Angsuran_Pokok->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Pokok->CurrentValue)))
			$this->Angsuran_Pokok->CurrentValue = ew_StrToFloat($this->Angsuran_Pokok->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Bunga->FormValue == $this->Angsuran_Bunga->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Bunga->CurrentValue)))
			$this->Angsuran_Bunga->CurrentValue = ew_StrToFloat($this->Angsuran_Bunga->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Angsuran_Total->FormValue == $this->Angsuran_Total->CurrentValue && is_numeric(ew_StrToFloat($this->Angsuran_Total->CurrentValue)))
			$this->Angsuran_Total->CurrentValue = ew_StrToFloat($this->Angsuran_Total->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Sisa_Hutang->FormValue == $this->Sisa_Hutang->CurrentValue && is_numeric(ew_StrToFloat($this->Sisa_Hutang->CurrentValue)))
			$this->Sisa_Hutang->CurrentValue = ew_StrToFloat($this->Sisa_Hutang->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Total_Denda->FormValue == $this->Total_Denda->CurrentValue && is_numeric(ew_StrToFloat($this->Total_Denda->CurrentValue)))
			$this->Total_Denda->CurrentValue = ew_StrToFloat($this->Total_Denda->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Titipan->FormValue == $this->Bayar_Titipan->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Titipan->CurrentValue)))
			$this->Bayar_Titipan->CurrentValue = ew_StrToFloat($this->Bayar_Titipan->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Non_Titipan->FormValue == $this->Bayar_Non_Titipan->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Non_Titipan->CurrentValue)))
			$this->Bayar_Non_Titipan->CurrentValue = ew_StrToFloat($this->Bayar_Non_Titipan->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Bayar_Total->FormValue == $this->Bayar_Total->CurrentValue && is_numeric(ew_StrToFloat($this->Bayar_Total->CurrentValue)))
			$this->Bayar_Total->CurrentValue = ew_StrToFloat($this->Bayar_Total->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// pinjaman_id
		// Angsuran_Ke
		// Angsuran_Tanggal
		// Angsuran_Pokok
		// Angsuran_Bunga
		// Angsuran_Total
		// Sisa_Hutang
		// Tanggal_Bayar
		// Terlambat
		// Total_Denda
		// Bayar_Titipan
		// Bayar_Non_Titipan
		// Bayar_Total
		// Keterangan
		// Flag_Edit

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pinjaman_id
		$this->pinjaman_id->ViewValue = $this->pinjaman_id->CurrentValue;
		$this->pinjaman_id->ViewCustomAttributes = "";

		// Angsuran_Ke
		$this->Angsuran_Ke->ViewValue = $this->Angsuran_Ke->CurrentValue;
		$this->Angsuran_Ke->ViewCustomAttributes = "";

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal->ViewValue = $this->Angsuran_Tanggal->CurrentValue;
		$this->Angsuran_Tanggal->ViewValue = ew_FormatDateTime($this->Angsuran_Tanggal->ViewValue, 0);
		$this->Angsuran_Tanggal->ViewCustomAttributes = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->ViewValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->ViewCustomAttributes = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->ViewValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->ViewCustomAttributes = "";

		// Angsuran_Total
		$this->Angsuran_Total->ViewValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->ViewCustomAttributes = "";

		// Sisa_Hutang
		$this->Sisa_Hutang->ViewValue = $this->Sisa_Hutang->CurrentValue;
		$this->Sisa_Hutang->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 0);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Terlambat
		$this->Terlambat->ViewValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->ViewCustomAttributes = "";

		// Total_Denda
		$this->Total_Denda->ViewValue = $this->Total_Denda->CurrentValue;
		$this->Total_Denda->ViewCustomAttributes = "";

		// Bayar_Titipan
		$this->Bayar_Titipan->ViewValue = $this->Bayar_Titipan->CurrentValue;
		$this->Bayar_Titipan->ViewCustomAttributes = "";

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->ViewValue = $this->Bayar_Non_Titipan->CurrentValue;
		$this->Bayar_Non_Titipan->ViewCustomAttributes = "";

		// Bayar_Total
		$this->Bayar_Total->ViewValue = $this->Bayar_Total->CurrentValue;
		$this->Bayar_Total->ViewCustomAttributes = "";

		// Flag_Edit
		$this->Flag_Edit->ViewValue = $this->Flag_Edit->CurrentValue;
		$this->Flag_Edit->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// pinjaman_id
			$this->pinjaman_id->LinkCustomAttributes = "";
			$this->pinjaman_id->HrefValue = "";
			$this->pinjaman_id->TooltipValue = "";

			// Angsuran_Ke
			$this->Angsuran_Ke->LinkCustomAttributes = "";
			$this->Angsuran_Ke->HrefValue = "";
			$this->Angsuran_Ke->TooltipValue = "";

			// Angsuran_Tanggal
			$this->Angsuran_Tanggal->LinkCustomAttributes = "";
			$this->Angsuran_Tanggal->HrefValue = "";
			$this->Angsuran_Tanggal->TooltipValue = "";

			// Angsuran_Pokok
			$this->Angsuran_Pokok->LinkCustomAttributes = "";
			$this->Angsuran_Pokok->HrefValue = "";
			$this->Angsuran_Pokok->TooltipValue = "";

			// Angsuran_Bunga
			$this->Angsuran_Bunga->LinkCustomAttributes = "";
			$this->Angsuran_Bunga->HrefValue = "";
			$this->Angsuran_Bunga->TooltipValue = "";

			// Angsuran_Total
			$this->Angsuran_Total->LinkCustomAttributes = "";
			$this->Angsuran_Total->HrefValue = "";
			$this->Angsuran_Total->TooltipValue = "";

			// Sisa_Hutang
			$this->Sisa_Hutang->LinkCustomAttributes = "";
			$this->Sisa_Hutang->HrefValue = "";
			$this->Sisa_Hutang->TooltipValue = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->LinkCustomAttributes = "";
			$this->Tanggal_Bayar->HrefValue = "";
			$this->Tanggal_Bayar->TooltipValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";
			$this->Terlambat->TooltipValue = "";

			// Total_Denda
			$this->Total_Denda->LinkCustomAttributes = "";
			$this->Total_Denda->HrefValue = "";
			$this->Total_Denda->TooltipValue = "";

			// Bayar_Titipan
			$this->Bayar_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Titipan->HrefValue = "";
			$this->Bayar_Titipan->TooltipValue = "";

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Non_Titipan->HrefValue = "";
			$this->Bayar_Non_Titipan->TooltipValue = "";

			// Bayar_Total
			$this->Bayar_Total->LinkCustomAttributes = "";
			$this->Bayar_Total->HrefValue = "";
			$this->Bayar_Total->TooltipValue = "";

			// Flag_Edit
			$this->Flag_Edit->LinkCustomAttributes = "";
			$this->Flag_Edit->HrefValue = "";
			$this->Flag_Edit->TooltipValue = "";
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
		} else {
			$conn->RollbackTrans(); // Rollback changes
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t04_pinjamanangsurantemplist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t04_pinjamanangsurantemp_delete)) $t04_pinjamanangsurantemp_delete = new ct04_pinjamanangsurantemp_delete();

// Page init
$t04_pinjamanangsurantemp_delete->Page_Init();

// Page main
$t04_pinjamanangsurantemp_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t04_pinjamanangsurantemp_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft04_pinjamanangsurantempdelete = new ew_Form("ft04_pinjamanangsurantempdelete", "delete");

// Form_CustomValidate event
ft04_pinjamanangsurantempdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft04_pinjamanangsurantempdelete.ValidateRequired = true;
<?php } else { ?>
ft04_pinjamanangsurantempdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $t04_pinjamanangsurantemp_delete->ShowPageHeader(); ?>
<?php
$t04_pinjamanangsurantemp_delete->ShowMessage();
?>
<form name="ft04_pinjamanangsurantempdelete" id="ft04_pinjamanangsurantempdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t04_pinjamanangsurantemp_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t04_pinjamanangsurantemp_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t04_pinjamanangsurantemp">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t04_pinjamanangsurantemp_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $t04_pinjamanangsurantemp->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t04_pinjamanangsurantemp->id->Visible) { // id ?>
		<th><span id="elh_t04_pinjamanangsurantemp_id" class="t04_pinjamanangsurantemp_id"><?php echo $t04_pinjamanangsurantemp->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->pinjaman_id->Visible) { // pinjaman_id ?>
		<th><span id="elh_t04_pinjamanangsurantemp_pinjaman_id" class="t04_pinjamanangsurantemp_pinjaman_id"><?php echo $t04_pinjamanangsurantemp->pinjaman_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Ke->Visible) { // Angsuran_Ke ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Angsuran_Ke" class="t04_pinjamanangsurantemp_Angsuran_Ke"><?php echo $t04_pinjamanangsurantemp->Angsuran_Ke->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Tanggal->Visible) { // Angsuran_Tanggal ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Angsuran_Tanggal" class="t04_pinjamanangsurantemp_Angsuran_Tanggal"><?php echo $t04_pinjamanangsurantemp->Angsuran_Tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Angsuran_Pokok" class="t04_pinjamanangsurantemp_Angsuran_Pokok"><?php echo $t04_pinjamanangsurantemp->Angsuran_Pokok->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Angsuran_Bunga" class="t04_pinjamanangsurantemp_Angsuran_Bunga"><?php echo $t04_pinjamanangsurantemp->Angsuran_Bunga->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Total->Visible) { // Angsuran_Total ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Angsuran_Total" class="t04_pinjamanangsurantemp_Angsuran_Total"><?php echo $t04_pinjamanangsurantemp->Angsuran_Total->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Sisa_Hutang->Visible) { // Sisa_Hutang ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Sisa_Hutang" class="t04_pinjamanangsurantemp_Sisa_Hutang"><?php echo $t04_pinjamanangsurantemp->Sisa_Hutang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Tanggal_Bayar" class="t04_pinjamanangsurantemp_Tanggal_Bayar"><?php echo $t04_pinjamanangsurantemp->Tanggal_Bayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Terlambat->Visible) { // Terlambat ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Terlambat" class="t04_pinjamanangsurantemp_Terlambat"><?php echo $t04_pinjamanangsurantemp->Terlambat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Total_Denda->Visible) { // Total_Denda ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Total_Denda" class="t04_pinjamanangsurantemp_Total_Denda"><?php echo $t04_pinjamanangsurantemp->Total_Denda->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Titipan->Visible) { // Bayar_Titipan ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Bayar_Titipan" class="t04_pinjamanangsurantemp_Bayar_Titipan"><?php echo $t04_pinjamanangsurantemp->Bayar_Titipan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Non_Titipan->Visible) { // Bayar_Non_Titipan ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Bayar_Non_Titipan" class="t04_pinjamanangsurantemp_Bayar_Non_Titipan"><?php echo $t04_pinjamanangsurantemp->Bayar_Non_Titipan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Total->Visible) { // Bayar_Total ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Bayar_Total" class="t04_pinjamanangsurantemp_Bayar_Total"><?php echo $t04_pinjamanangsurantemp->Bayar_Total->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Flag_Edit->Visible) { // Flag_Edit ?>
		<th><span id="elh_t04_pinjamanangsurantemp_Flag_Edit" class="t04_pinjamanangsurantemp_Flag_Edit"><?php echo $t04_pinjamanangsurantemp->Flag_Edit->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t04_pinjamanangsurantemp_delete->RecCnt = 0;
$i = 0;
while (!$t04_pinjamanangsurantemp_delete->Recordset->EOF) {
	$t04_pinjamanangsurantemp_delete->RecCnt++;
	$t04_pinjamanangsurantemp_delete->RowCnt++;

	// Set row properties
	$t04_pinjamanangsurantemp->ResetAttrs();
	$t04_pinjamanangsurantemp->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t04_pinjamanangsurantemp_delete->LoadRowValues($t04_pinjamanangsurantemp_delete->Recordset);

	// Render row
	$t04_pinjamanangsurantemp_delete->RenderRow();
?>
	<tr<?php echo $t04_pinjamanangsurantemp->RowAttributes() ?>>
<?php if ($t04_pinjamanangsurantemp->id->Visible) { // id ?>
		<td<?php echo $t04_pinjamanangsurantemp->id->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_id" class="t04_pinjamanangsurantemp_id">
<span<?php echo $t04_pinjamanangsurantemp->id->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->pinjaman_id->Visible) { // pinjaman_id ?>
		<td<?php echo $t04_pinjamanangsurantemp->pinjaman_id->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_pinjaman_id" class="t04_pinjamanangsurantemp_pinjaman_id">
<span<?php echo $t04_pinjamanangsurantemp->pinjaman_id->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->pinjaman_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Ke->Visible) { // Angsuran_Ke ?>
		<td<?php echo $t04_pinjamanangsurantemp->Angsuran_Ke->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Angsuran_Ke" class="t04_pinjamanangsurantemp_Angsuran_Ke">
<span<?php echo $t04_pinjamanangsurantemp->Angsuran_Ke->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Angsuran_Ke->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Tanggal->Visible) { // Angsuran_Tanggal ?>
		<td<?php echo $t04_pinjamanangsurantemp->Angsuran_Tanggal->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Angsuran_Tanggal" class="t04_pinjamanangsurantemp_Angsuran_Tanggal">
<span<?php echo $t04_pinjamanangsurantemp->Angsuran_Tanggal->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Angsuran_Tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Pokok->Visible) { // Angsuran_Pokok ?>
		<td<?php echo $t04_pinjamanangsurantemp->Angsuran_Pokok->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Angsuran_Pokok" class="t04_pinjamanangsurantemp_Angsuran_Pokok">
<span<?php echo $t04_pinjamanangsurantemp->Angsuran_Pokok->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Angsuran_Pokok->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Bunga->Visible) { // Angsuran_Bunga ?>
		<td<?php echo $t04_pinjamanangsurantemp->Angsuran_Bunga->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Angsuran_Bunga" class="t04_pinjamanangsurantemp_Angsuran_Bunga">
<span<?php echo $t04_pinjamanangsurantemp->Angsuran_Bunga->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Angsuran_Bunga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Angsuran_Total->Visible) { // Angsuran_Total ?>
		<td<?php echo $t04_pinjamanangsurantemp->Angsuran_Total->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Angsuran_Total" class="t04_pinjamanangsurantemp_Angsuran_Total">
<span<?php echo $t04_pinjamanangsurantemp->Angsuran_Total->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Angsuran_Total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Sisa_Hutang->Visible) { // Sisa_Hutang ?>
		<td<?php echo $t04_pinjamanangsurantemp->Sisa_Hutang->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Sisa_Hutang" class="t04_pinjamanangsurantemp_Sisa_Hutang">
<span<?php echo $t04_pinjamanangsurantemp->Sisa_Hutang->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Sisa_Hutang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Tanggal_Bayar->Visible) { // Tanggal_Bayar ?>
		<td<?php echo $t04_pinjamanangsurantemp->Tanggal_Bayar->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Tanggal_Bayar" class="t04_pinjamanangsurantemp_Tanggal_Bayar">
<span<?php echo $t04_pinjamanangsurantemp->Tanggal_Bayar->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Tanggal_Bayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Terlambat->Visible) { // Terlambat ?>
		<td<?php echo $t04_pinjamanangsurantemp->Terlambat->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Terlambat" class="t04_pinjamanangsurantemp_Terlambat">
<span<?php echo $t04_pinjamanangsurantemp->Terlambat->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Terlambat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Total_Denda->Visible) { // Total_Denda ?>
		<td<?php echo $t04_pinjamanangsurantemp->Total_Denda->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Total_Denda" class="t04_pinjamanangsurantemp_Total_Denda">
<span<?php echo $t04_pinjamanangsurantemp->Total_Denda->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Total_Denda->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Titipan->Visible) { // Bayar_Titipan ?>
		<td<?php echo $t04_pinjamanangsurantemp->Bayar_Titipan->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Bayar_Titipan" class="t04_pinjamanangsurantemp_Bayar_Titipan">
<span<?php echo $t04_pinjamanangsurantemp->Bayar_Titipan->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Bayar_Titipan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Non_Titipan->Visible) { // Bayar_Non_Titipan ?>
		<td<?php echo $t04_pinjamanangsurantemp->Bayar_Non_Titipan->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Bayar_Non_Titipan" class="t04_pinjamanangsurantemp_Bayar_Non_Titipan">
<span<?php echo $t04_pinjamanangsurantemp->Bayar_Non_Titipan->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Bayar_Non_Titipan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Bayar_Total->Visible) { // Bayar_Total ?>
		<td<?php echo $t04_pinjamanangsurantemp->Bayar_Total->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Bayar_Total" class="t04_pinjamanangsurantemp_Bayar_Total">
<span<?php echo $t04_pinjamanangsurantemp->Bayar_Total->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Bayar_Total->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t04_pinjamanangsurantemp->Flag_Edit->Visible) { // Flag_Edit ?>
		<td<?php echo $t04_pinjamanangsurantemp->Flag_Edit->CellAttributes() ?>>
<span id="el<?php echo $t04_pinjamanangsurantemp_delete->RowCnt ?>_t04_pinjamanangsurantemp_Flag_Edit" class="t04_pinjamanangsurantemp_Flag_Edit">
<span<?php echo $t04_pinjamanangsurantemp->Flag_Edit->ViewAttributes() ?>>
<?php echo $t04_pinjamanangsurantemp->Flag_Edit->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t04_pinjamanangsurantemp_delete->Recordset->MoveNext();
}
$t04_pinjamanangsurantemp_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t04_pinjamanangsurantemp_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft04_pinjamanangsurantempdelete.Init();
</script>
<?php
$t04_pinjamanangsurantemp_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t04_pinjamanangsurantemp_delete->Page_Terminate();
?>
