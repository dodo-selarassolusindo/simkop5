<?php include_once "t04_pinjamanangsurantempinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php

//
// Page class
//

$t04_pinjamanangsurantemp_grid = NULL; // Initialize page object first

class ct04_pinjamanangsurantemp_grid extends ct04_pinjamanangsurantemp {

	// Page ID
	var $PageID = 'grid';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't04_pinjamanangsurantemp';

	// Page object name
	var $PageObjName = 't04_pinjamanangsurantemp_grid';

	// Grid form hidden field names
	var $FormName = 'ft04_pinjamanangsurantempgrid';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t04_pinjamanangsurantemp)
		if (!isset($GLOBALS["t04_pinjamanangsurantemp"]) || get_class($GLOBALS["t04_pinjamanangsurantemp"]) == "ct04_pinjamanangsurantemp") {
			$GLOBALS["t04_pinjamanangsurantemp"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["t04_pinjamanangsurantemp"];

		}
		$this->AddUrl = "t04_pinjamanangsurantempadd.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't04_pinjamanangsurantemp', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (t96_employees)
		if (!isset($UserTable)) {
			$UserTable = new ct96_employees();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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
		$this->Keterangan->SetVisibility();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
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
	var $ShowOtherOptions = FALSE;
	var $DisplayRecs = 100;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
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
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 100; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t03_pinjaman") {
			global $t03_pinjaman;
			$rsmaster = $t03_pinjaman->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t03_pinjamanlist.php"); // Return to master page
			} else {
				$t03_pinjaman->LoadListRowValues($rsmaster);
				$t03_pinjaman->RowType = EW_ROWTYPE_MASTER; // Master row
				$t03_pinjaman->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 100; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->Angsuran_Pokok->FormValue = ""; // Clear form value
		$this->Angsuran_Bunga->FormValue = ""; // Clear form value
		$this->Angsuran_Total->FormValue = ""; // Clear form value
		$this->Sisa_Hutang->FormValue = ""; // Clear form value
		$this->Total_Denda->FormValue = ""; // Clear form value
		$this->Bayar_Titipan->FormValue = ""; // Clear form value
		$this->Bayar_Non_Titipan->FormValue = ""; // Clear form value
		$this->Bayar_Total->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old recordset
			}
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Angsuran_Ke") && $objForm->HasValue("o_Angsuran_Ke") && $this->Angsuran_Ke->CurrentValue <> $this->Angsuran_Ke->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Angsuran_Tanggal") && $objForm->HasValue("o_Angsuran_Tanggal") && $this->Angsuran_Tanggal->CurrentValue <> $this->Angsuran_Tanggal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Angsuran_Pokok") && $objForm->HasValue("o_Angsuran_Pokok") && $this->Angsuran_Pokok->CurrentValue <> $this->Angsuran_Pokok->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Angsuran_Bunga") && $objForm->HasValue("o_Angsuran_Bunga") && $this->Angsuran_Bunga->CurrentValue <> $this->Angsuran_Bunga->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Angsuran_Total") && $objForm->HasValue("o_Angsuran_Total") && $this->Angsuran_Total->CurrentValue <> $this->Angsuran_Total->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Sisa_Hutang") && $objForm->HasValue("o_Sisa_Hutang") && $this->Sisa_Hutang->CurrentValue <> $this->Sisa_Hutang->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Tanggal_Bayar") && $objForm->HasValue("o_Tanggal_Bayar") && $this->Tanggal_Bayar->CurrentValue <> $this->Tanggal_Bayar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Terlambat") && $objForm->HasValue("o_Terlambat") && $this->Terlambat->CurrentValue <> $this->Terlambat->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Total_Denda") && $objForm->HasValue("o_Total_Denda") && $this->Total_Denda->CurrentValue <> $this->Total_Denda->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bayar_Titipan") && $objForm->HasValue("o_Bayar_Titipan") && $this->Bayar_Titipan->CurrentValue <> $this->Bayar_Titipan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bayar_Non_Titipan") && $objForm->HasValue("o_Bayar_Non_Titipan") && $this->Bayar_Non_Titipan->CurrentValue <> $this->Bayar_Non_Titipan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bayar_Total") && $objForm->HasValue("o_Bayar_Total") && $this->Bayar_Total->CurrentValue <> $this->Bayar_Total->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Keterangan") && $objForm->HasValue("o_Keterangan") && $this->Keterangan->CurrentValue <> $this->Keterangan->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->pinjaman_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}
		if ($this->CurrentMode == "view") { // View mode

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-sm"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = FALSE;
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Angsuran_Ke->CurrentValue = NULL;
		$this->Angsuran_Ke->OldValue = $this->Angsuran_Ke->CurrentValue;
		$this->Angsuran_Tanggal->CurrentValue = NULL;
		$this->Angsuran_Tanggal->OldValue = $this->Angsuran_Tanggal->CurrentValue;
		$this->Angsuran_Pokok->CurrentValue = NULL;
		$this->Angsuran_Pokok->OldValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Bunga->CurrentValue = NULL;
		$this->Angsuran_Bunga->OldValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Total->CurrentValue = NULL;
		$this->Angsuran_Total->OldValue = $this->Angsuran_Total->CurrentValue;
		$this->Sisa_Hutang->CurrentValue = NULL;
		$this->Sisa_Hutang->OldValue = $this->Sisa_Hutang->CurrentValue;
		$this->Tanggal_Bayar->CurrentValue = NULL;
		$this->Tanggal_Bayar->OldValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Terlambat->CurrentValue = NULL;
		$this->Terlambat->OldValue = $this->Terlambat->CurrentValue;
		$this->Total_Denda->CurrentValue = NULL;
		$this->Total_Denda->OldValue = $this->Total_Denda->CurrentValue;
		$this->Bayar_Titipan->CurrentValue = NULL;
		$this->Bayar_Titipan->OldValue = $this->Bayar_Titipan->CurrentValue;
		$this->Bayar_Non_Titipan->CurrentValue = NULL;
		$this->Bayar_Non_Titipan->OldValue = $this->Bayar_Non_Titipan->CurrentValue;
		$this->Bayar_Total->CurrentValue = NULL;
		$this->Bayar_Total->OldValue = $this->Bayar_Total->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$objForm->FormName = $this->FormName;
		if (!$this->Angsuran_Ke->FldIsDetailKey) {
			$this->Angsuran_Ke->setFormValue($objForm->GetValue("x_Angsuran_Ke"));
		}
		$this->Angsuran_Ke->setOldValue($objForm->GetValue("o_Angsuran_Ke"));
		if (!$this->Angsuran_Tanggal->FldIsDetailKey) {
			$this->Angsuran_Tanggal->setFormValue($objForm->GetValue("x_Angsuran_Tanggal"));
			$this->Angsuran_Tanggal->CurrentValue = ew_UnFormatDateTime($this->Angsuran_Tanggal->CurrentValue, 7);
		}
		$this->Angsuran_Tanggal->setOldValue($objForm->GetValue("o_Angsuran_Tanggal"));
		if (!$this->Angsuran_Pokok->FldIsDetailKey) {
			$this->Angsuran_Pokok->setFormValue($objForm->GetValue("x_Angsuran_Pokok"));
		}
		$this->Angsuran_Pokok->setOldValue($objForm->GetValue("o_Angsuran_Pokok"));
		if (!$this->Angsuran_Bunga->FldIsDetailKey) {
			$this->Angsuran_Bunga->setFormValue($objForm->GetValue("x_Angsuran_Bunga"));
		}
		$this->Angsuran_Bunga->setOldValue($objForm->GetValue("o_Angsuran_Bunga"));
		if (!$this->Angsuran_Total->FldIsDetailKey) {
			$this->Angsuran_Total->setFormValue($objForm->GetValue("x_Angsuran_Total"));
		}
		$this->Angsuran_Total->setOldValue($objForm->GetValue("o_Angsuran_Total"));
		if (!$this->Sisa_Hutang->FldIsDetailKey) {
			$this->Sisa_Hutang->setFormValue($objForm->GetValue("x_Sisa_Hutang"));
		}
		$this->Sisa_Hutang->setOldValue($objForm->GetValue("o_Sisa_Hutang"));
		if (!$this->Tanggal_Bayar->FldIsDetailKey) {
			$this->Tanggal_Bayar->setFormValue($objForm->GetValue("x_Tanggal_Bayar"));
			$this->Tanggal_Bayar->CurrentValue = ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 7);
		}
		$this->Tanggal_Bayar->setOldValue($objForm->GetValue("o_Tanggal_Bayar"));
		if (!$this->Terlambat->FldIsDetailKey) {
			$this->Terlambat->setFormValue($objForm->GetValue("x_Terlambat"));
		}
		$this->Terlambat->setOldValue($objForm->GetValue("o_Terlambat"));
		if (!$this->Total_Denda->FldIsDetailKey) {
			$this->Total_Denda->setFormValue($objForm->GetValue("x_Total_Denda"));
		}
		$this->Total_Denda->setOldValue($objForm->GetValue("o_Total_Denda"));
		if (!$this->Bayar_Titipan->FldIsDetailKey) {
			$this->Bayar_Titipan->setFormValue($objForm->GetValue("x_Bayar_Titipan"));
		}
		$this->Bayar_Titipan->setOldValue($objForm->GetValue("o_Bayar_Titipan"));
		if (!$this->Bayar_Non_Titipan->FldIsDetailKey) {
			$this->Bayar_Non_Titipan->setFormValue($objForm->GetValue("x_Bayar_Non_Titipan"));
		}
		$this->Bayar_Non_Titipan->setOldValue($objForm->GetValue("o_Bayar_Non_Titipan"));
		if (!$this->Bayar_Total->FldIsDetailKey) {
			$this->Bayar_Total->setFormValue($objForm->GetValue("x_Bayar_Total"));
		}
		$this->Bayar_Total->setOldValue($objForm->GetValue("o_Bayar_Total"));
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		$this->Keterangan->setOldValue($objForm->GetValue("o_Keterangan"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->Angsuran_Ke->CurrentValue = $this->Angsuran_Ke->FormValue;
		$this->Angsuran_Tanggal->CurrentValue = $this->Angsuran_Tanggal->FormValue;
		$this->Angsuran_Tanggal->CurrentValue = ew_UnFormatDateTime($this->Angsuran_Tanggal->CurrentValue, 7);
		$this->Angsuran_Pokok->CurrentValue = $this->Angsuran_Pokok->FormValue;
		$this->Angsuran_Bunga->CurrentValue = $this->Angsuran_Bunga->FormValue;
		$this->Angsuran_Total->CurrentValue = $this->Angsuran_Total->FormValue;
		$this->Sisa_Hutang->CurrentValue = $this->Sisa_Hutang->FormValue;
		$this->Tanggal_Bayar->CurrentValue = $this->Tanggal_Bayar->FormValue;
		$this->Tanggal_Bayar->CurrentValue = ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 7);
		$this->Terlambat->CurrentValue = $this->Terlambat->FormValue;
		$this->Total_Denda->CurrentValue = $this->Total_Denda->FormValue;
		$this->Bayar_Titipan->CurrentValue = $this->Bayar_Titipan->FormValue;
		$this->Bayar_Non_Titipan->CurrentValue = $this->Bayar_Non_Titipan->FormValue;
		$this->Bayar_Total->CurrentValue = $this->Bayar_Total->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
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
		$this->Periode->setDbValue($rs->fields('Periode'));
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
		$this->Periode->DbValue = $row['Periode'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->id->CurrentValue = strval($arKeys[0]); // id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// Periode

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
		$this->Angsuran_Tanggal->ViewValue = ew_FormatDateTime($this->Angsuran_Tanggal->ViewValue, 7);
		$this->Angsuran_Tanggal->ViewCustomAttributes = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->ViewValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->ViewValue = ew_FormatNumber($this->Angsuran_Pokok->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Pokok->CellCssStyle .= "text-align: left;";
		$this->Angsuran_Pokok->ViewCustomAttributes = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->ViewValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->ViewValue = ew_FormatNumber($this->Angsuran_Bunga->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Bunga->CellCssStyle .= "text-align: left;";
		$this->Angsuran_Bunga->ViewCustomAttributes = "";

		// Angsuran_Total
		$this->Angsuran_Total->ViewValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->ViewValue = ew_FormatNumber($this->Angsuran_Total->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Total->CellCssStyle .= "text-align: left;";
		$this->Angsuran_Total->ViewCustomAttributes = "";

		// Sisa_Hutang
		$this->Sisa_Hutang->ViewValue = $this->Sisa_Hutang->CurrentValue;
		$this->Sisa_Hutang->ViewValue = ew_FormatNumber($this->Sisa_Hutang->ViewValue, 2, -2, -2, -2);
		$this->Sisa_Hutang->CellCssStyle .= "text-align: left;";
		$this->Sisa_Hutang->ViewCustomAttributes = "";

		// Tanggal_Bayar
		$this->Tanggal_Bayar->ViewValue = $this->Tanggal_Bayar->CurrentValue;
		$this->Tanggal_Bayar->ViewValue = ew_FormatDateTime($this->Tanggal_Bayar->ViewValue, 7);
		$this->Tanggal_Bayar->ViewCustomAttributes = "";

		// Terlambat
		$this->Terlambat->ViewValue = $this->Terlambat->CurrentValue;
		$this->Terlambat->ViewValue = ew_FormatNumber($this->Terlambat->ViewValue, 0, -2, -2, -2);
		$this->Terlambat->CellCssStyle .= "text-align: right;";
		$this->Terlambat->ViewCustomAttributes = "";

		// Total_Denda
		$this->Total_Denda->ViewValue = $this->Total_Denda->CurrentValue;
		$this->Total_Denda->ViewValue = ew_FormatNumber($this->Total_Denda->ViewValue, 2, -2, -2, -2);
		$this->Total_Denda->CellCssStyle .= "text-align: right;";
		$this->Total_Denda->ViewCustomAttributes = "";

		// Bayar_Titipan
		$this->Bayar_Titipan->ViewValue = $this->Bayar_Titipan->CurrentValue;
		$this->Bayar_Titipan->ViewValue = ew_FormatNumber($this->Bayar_Titipan->ViewValue, 2, -2, -2, -2);
		$this->Bayar_Titipan->CellCssStyle .= "text-align: right;";
		$this->Bayar_Titipan->ViewCustomAttributes = "";

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->ViewValue = $this->Bayar_Non_Titipan->CurrentValue;
		$this->Bayar_Non_Titipan->ViewValue = ew_FormatNumber($this->Bayar_Non_Titipan->ViewValue, 2, -2, -2, -2);
		$this->Bayar_Non_Titipan->CellCssStyle .= "text-align: right;";
		$this->Bayar_Non_Titipan->ViewCustomAttributes = "";

		// Bayar_Total
		$this->Bayar_Total->ViewValue = $this->Bayar_Total->CurrentValue;
		$this->Bayar_Total->ViewValue = ew_FormatNumber($this->Bayar_Total->ViewValue, 2, -2, -2, -2);
		$this->Bayar_Total->CellCssStyle .= "text-align: right;";
		$this->Bayar_Total->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

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

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Angsuran_Ke
			$this->Angsuran_Ke->EditAttrs["class"] = "form-control";
			$this->Angsuran_Ke->EditCustomAttributes = "";
			$this->Angsuran_Ke->EditValue = ew_HtmlEncode($this->Angsuran_Ke->CurrentValue);
			$this->Angsuran_Ke->PlaceHolder = ew_RemoveHtml($this->Angsuran_Ke->FldCaption());

			// Angsuran_Tanggal
			$this->Angsuran_Tanggal->EditAttrs["class"] = "form-control";
			$this->Angsuran_Tanggal->EditCustomAttributes = "style='width: 115px;'";
			$this->Angsuran_Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Angsuran_Tanggal->CurrentValue, 7));
			$this->Angsuran_Tanggal->PlaceHolder = ew_RemoveHtml($this->Angsuran_Tanggal->FldCaption());

			// Angsuran_Pokok
			$this->Angsuran_Pokok->EditAttrs["class"] = "form-control";
			$this->Angsuran_Pokok->EditCustomAttributes = "";
			$this->Angsuran_Pokok->EditValue = ew_HtmlEncode($this->Angsuran_Pokok->CurrentValue);
			$this->Angsuran_Pokok->PlaceHolder = ew_RemoveHtml($this->Angsuran_Pokok->FldCaption());
			if (strval($this->Angsuran_Pokok->EditValue) <> "" && is_numeric($this->Angsuran_Pokok->EditValue)) {
			$this->Angsuran_Pokok->EditValue = ew_FormatNumber($this->Angsuran_Pokok->EditValue, -2, -2, -2, -2);
			$this->Angsuran_Pokok->OldValue = $this->Angsuran_Pokok->EditValue;
			}

			// Angsuran_Bunga
			$this->Angsuran_Bunga->EditAttrs["class"] = "form-control";
			$this->Angsuran_Bunga->EditCustomAttributes = "";
			$this->Angsuran_Bunga->EditValue = ew_HtmlEncode($this->Angsuran_Bunga->CurrentValue);
			$this->Angsuran_Bunga->PlaceHolder = ew_RemoveHtml($this->Angsuran_Bunga->FldCaption());
			if (strval($this->Angsuran_Bunga->EditValue) <> "" && is_numeric($this->Angsuran_Bunga->EditValue)) {
			$this->Angsuran_Bunga->EditValue = ew_FormatNumber($this->Angsuran_Bunga->EditValue, -2, -2, -2, -2);
			$this->Angsuran_Bunga->OldValue = $this->Angsuran_Bunga->EditValue;
			}

			// Angsuran_Total
			$this->Angsuran_Total->EditAttrs["class"] = "form-control";
			$this->Angsuran_Total->EditCustomAttributes = "";
			$this->Angsuran_Total->EditValue = ew_HtmlEncode($this->Angsuran_Total->CurrentValue);
			$this->Angsuran_Total->PlaceHolder = ew_RemoveHtml($this->Angsuran_Total->FldCaption());
			if (strval($this->Angsuran_Total->EditValue) <> "" && is_numeric($this->Angsuran_Total->EditValue)) {
			$this->Angsuran_Total->EditValue = ew_FormatNumber($this->Angsuran_Total->EditValue, -2, -2, -2, -2);
			$this->Angsuran_Total->OldValue = $this->Angsuran_Total->EditValue;
			}

			// Sisa_Hutang
			$this->Sisa_Hutang->EditAttrs["class"] = "form-control";
			$this->Sisa_Hutang->EditCustomAttributes = "";
			$this->Sisa_Hutang->EditValue = ew_HtmlEncode($this->Sisa_Hutang->CurrentValue);
			$this->Sisa_Hutang->PlaceHolder = ew_RemoveHtml($this->Sisa_Hutang->FldCaption());
			if (strval($this->Sisa_Hutang->EditValue) <> "" && is_numeric($this->Sisa_Hutang->EditValue)) {
			$this->Sisa_Hutang->EditValue = ew_FormatNumber($this->Sisa_Hutang->EditValue, -2, -2, -2, -2);
			$this->Sisa_Hutang->OldValue = $this->Sisa_Hutang->EditValue;
			}

			// Tanggal_Bayar
			$this->Tanggal_Bayar->EditAttrs["class"] = "form-control";
			$this->Tanggal_Bayar->EditCustomAttributes = "style='width: 115px;'";
			$this->Tanggal_Bayar->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal_Bayar->CurrentValue, 7));
			$this->Tanggal_Bayar->PlaceHolder = ew_RemoveHtml($this->Tanggal_Bayar->FldCaption());

			// Terlambat
			$this->Terlambat->EditAttrs["class"] = "form-control";
			$this->Terlambat->EditCustomAttributes = "";
			$this->Terlambat->EditValue = ew_HtmlEncode($this->Terlambat->CurrentValue);
			$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

			// Total_Denda
			$this->Total_Denda->EditAttrs["class"] = "form-control";
			$this->Total_Denda->EditCustomAttributes = "";
			$this->Total_Denda->EditValue = ew_HtmlEncode($this->Total_Denda->CurrentValue);
			$this->Total_Denda->PlaceHolder = ew_RemoveHtml($this->Total_Denda->FldCaption());
			if (strval($this->Total_Denda->EditValue) <> "" && is_numeric($this->Total_Denda->EditValue)) {
			$this->Total_Denda->EditValue = ew_FormatNumber($this->Total_Denda->EditValue, -2, -2, -2, -2);
			$this->Total_Denda->OldValue = $this->Total_Denda->EditValue;
			}

			// Bayar_Titipan
			$this->Bayar_Titipan->EditAttrs["class"] = "form-control";
			$this->Bayar_Titipan->EditCustomAttributes = "";
			$this->Bayar_Titipan->EditValue = ew_HtmlEncode($this->Bayar_Titipan->CurrentValue);
			$this->Bayar_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Titipan->FldCaption());
			if (strval($this->Bayar_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Titipan->EditValue)) {
			$this->Bayar_Titipan->EditValue = ew_FormatNumber($this->Bayar_Titipan->EditValue, -2, -2, -2, -2);
			$this->Bayar_Titipan->OldValue = $this->Bayar_Titipan->EditValue;
			}

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->EditAttrs["class"] = "form-control";
			$this->Bayar_Non_Titipan->EditCustomAttributes = "";
			$this->Bayar_Non_Titipan->EditValue = ew_HtmlEncode($this->Bayar_Non_Titipan->CurrentValue);
			$this->Bayar_Non_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Non_Titipan->FldCaption());
			if (strval($this->Bayar_Non_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Non_Titipan->EditValue)) {
			$this->Bayar_Non_Titipan->EditValue = ew_FormatNumber($this->Bayar_Non_Titipan->EditValue, -2, -2, -2, -2);
			$this->Bayar_Non_Titipan->OldValue = $this->Bayar_Non_Titipan->EditValue;
			}

			// Bayar_Total
			$this->Bayar_Total->EditAttrs["class"] = "form-control";
			$this->Bayar_Total->EditCustomAttributes = "";
			$this->Bayar_Total->EditValue = ew_HtmlEncode($this->Bayar_Total->CurrentValue);
			$this->Bayar_Total->PlaceHolder = ew_RemoveHtml($this->Bayar_Total->FldCaption());
			if (strval($this->Bayar_Total->EditValue) <> "" && is_numeric($this->Bayar_Total->EditValue)) {
			$this->Bayar_Total->EditValue = ew_FormatNumber($this->Bayar_Total->EditValue, -2, -2, -2, -2);
			$this->Bayar_Total->OldValue = $this->Bayar_Total->EditValue;
			}

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Add refer script
			// Angsuran_Ke

			$this->Angsuran_Ke->LinkCustomAttributes = "";
			$this->Angsuran_Ke->HrefValue = "";

			// Angsuran_Tanggal
			$this->Angsuran_Tanggal->LinkCustomAttributes = "";
			$this->Angsuran_Tanggal->HrefValue = "";

			// Angsuran_Pokok
			$this->Angsuran_Pokok->LinkCustomAttributes = "";
			$this->Angsuran_Pokok->HrefValue = "";

			// Angsuran_Bunga
			$this->Angsuran_Bunga->LinkCustomAttributes = "";
			$this->Angsuran_Bunga->HrefValue = "";

			// Angsuran_Total
			$this->Angsuran_Total->LinkCustomAttributes = "";
			$this->Angsuran_Total->HrefValue = "";

			// Sisa_Hutang
			$this->Sisa_Hutang->LinkCustomAttributes = "";
			$this->Sisa_Hutang->HrefValue = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->LinkCustomAttributes = "";
			$this->Tanggal_Bayar->HrefValue = "";

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";

			// Total_Denda
			$this->Total_Denda->LinkCustomAttributes = "";
			$this->Total_Denda->HrefValue = "";

			// Bayar_Titipan
			$this->Bayar_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Titipan->HrefValue = "";

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Non_Titipan->HrefValue = "";

			// Bayar_Total
			$this->Bayar_Total->LinkCustomAttributes = "";
			$this->Bayar_Total->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Angsuran_Ke
			$this->Angsuran_Ke->EditAttrs["class"] = "form-control";
			$this->Angsuran_Ke->EditCustomAttributes = "";
			$this->Angsuran_Ke->EditValue = $this->Angsuran_Ke->CurrentValue;
			$this->Angsuran_Ke->ViewCustomAttributes = "";

			// Angsuran_Tanggal
			$this->Angsuran_Tanggal->EditAttrs["class"] = "form-control";
			$this->Angsuran_Tanggal->EditCustomAttributes = "style='width: 115px;'";
			$this->Angsuran_Tanggal->EditValue = $this->Angsuran_Tanggal->CurrentValue;
			$this->Angsuran_Tanggal->EditValue = ew_FormatDateTime($this->Angsuran_Tanggal->EditValue, 7);
			$this->Angsuran_Tanggal->ViewCustomAttributes = "";

			// Angsuran_Pokok
			$this->Angsuran_Pokok->EditAttrs["class"] = "form-control";
			$this->Angsuran_Pokok->EditCustomAttributes = "";
			$this->Angsuran_Pokok->EditValue = $this->Angsuran_Pokok->CurrentValue;
			$this->Angsuran_Pokok->EditValue = ew_FormatNumber($this->Angsuran_Pokok->EditValue, 2, -2, -2, -2);
			$this->Angsuran_Pokok->CellCssStyle .= "text-align: left;";
			$this->Angsuran_Pokok->ViewCustomAttributes = "";

			// Angsuran_Bunga
			$this->Angsuran_Bunga->EditAttrs["class"] = "form-control";
			$this->Angsuran_Bunga->EditCustomAttributes = "";
			$this->Angsuran_Bunga->EditValue = $this->Angsuran_Bunga->CurrentValue;
			$this->Angsuran_Bunga->EditValue = ew_FormatNumber($this->Angsuran_Bunga->EditValue, 2, -2, -2, -2);
			$this->Angsuran_Bunga->CellCssStyle .= "text-align: left;";
			$this->Angsuran_Bunga->ViewCustomAttributes = "";

			// Angsuran_Total
			$this->Angsuran_Total->EditAttrs["class"] = "form-control";
			$this->Angsuran_Total->EditCustomAttributes = "";
			$this->Angsuran_Total->EditValue = $this->Angsuran_Total->CurrentValue;
			$this->Angsuran_Total->EditValue = ew_FormatNumber($this->Angsuran_Total->EditValue, 2, -2, -2, -2);
			$this->Angsuran_Total->CellCssStyle .= "text-align: left;";
			$this->Angsuran_Total->ViewCustomAttributes = "";

			// Sisa_Hutang
			$this->Sisa_Hutang->EditAttrs["class"] = "form-control";
			$this->Sisa_Hutang->EditCustomAttributes = "";
			$this->Sisa_Hutang->EditValue = $this->Sisa_Hutang->CurrentValue;
			$this->Sisa_Hutang->EditValue = ew_FormatNumber($this->Sisa_Hutang->EditValue, 2, -2, -2, -2);
			$this->Sisa_Hutang->CellCssStyle .= "text-align: left;";
			$this->Sisa_Hutang->ViewCustomAttributes = "";

			// Tanggal_Bayar
			$this->Tanggal_Bayar->EditAttrs["class"] = "form-control";
			$this->Tanggal_Bayar->EditCustomAttributes = "style='width: 115px;'";
			$this->Tanggal_Bayar->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal_Bayar->CurrentValue, 7));
			$this->Tanggal_Bayar->PlaceHolder = ew_RemoveHtml($this->Tanggal_Bayar->FldCaption());

			// Terlambat
			$this->Terlambat->EditAttrs["class"] = "form-control";
			$this->Terlambat->EditCustomAttributes = "";
			$this->Terlambat->EditValue = ew_HtmlEncode($this->Terlambat->CurrentValue);
			$this->Terlambat->PlaceHolder = ew_RemoveHtml($this->Terlambat->FldCaption());

			// Total_Denda
			$this->Total_Denda->EditAttrs["class"] = "form-control";
			$this->Total_Denda->EditCustomAttributes = "";
			$this->Total_Denda->EditValue = ew_HtmlEncode($this->Total_Denda->CurrentValue);
			$this->Total_Denda->PlaceHolder = ew_RemoveHtml($this->Total_Denda->FldCaption());
			if (strval($this->Total_Denda->EditValue) <> "" && is_numeric($this->Total_Denda->EditValue)) {
			$this->Total_Denda->EditValue = ew_FormatNumber($this->Total_Denda->EditValue, -2, -2, -2, -2);
			$this->Total_Denda->OldValue = $this->Total_Denda->EditValue;
			}

			// Bayar_Titipan
			$this->Bayar_Titipan->EditAttrs["class"] = "form-control";
			$this->Bayar_Titipan->EditCustomAttributes = "";
			$this->Bayar_Titipan->EditValue = ew_HtmlEncode($this->Bayar_Titipan->CurrentValue);
			$this->Bayar_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Titipan->FldCaption());
			if (strval($this->Bayar_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Titipan->EditValue)) {
			$this->Bayar_Titipan->EditValue = ew_FormatNumber($this->Bayar_Titipan->EditValue, -2, -2, -2, -2);
			$this->Bayar_Titipan->OldValue = $this->Bayar_Titipan->EditValue;
			}

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->EditAttrs["class"] = "form-control";
			$this->Bayar_Non_Titipan->EditCustomAttributes = "";
			$this->Bayar_Non_Titipan->EditValue = ew_HtmlEncode($this->Bayar_Non_Titipan->CurrentValue);
			$this->Bayar_Non_Titipan->PlaceHolder = ew_RemoveHtml($this->Bayar_Non_Titipan->FldCaption());
			if (strval($this->Bayar_Non_Titipan->EditValue) <> "" && is_numeric($this->Bayar_Non_Titipan->EditValue)) {
			$this->Bayar_Non_Titipan->EditValue = ew_FormatNumber($this->Bayar_Non_Titipan->EditValue, -2, -2, -2, -2);
			$this->Bayar_Non_Titipan->OldValue = $this->Bayar_Non_Titipan->EditValue;
			}

			// Bayar_Total
			$this->Bayar_Total->EditAttrs["class"] = "form-control";
			$this->Bayar_Total->EditCustomAttributes = "";
			$this->Bayar_Total->EditValue = ew_HtmlEncode($this->Bayar_Total->CurrentValue);
			$this->Bayar_Total->PlaceHolder = ew_RemoveHtml($this->Bayar_Total->FldCaption());
			if (strval($this->Bayar_Total->EditValue) <> "" && is_numeric($this->Bayar_Total->EditValue)) {
			$this->Bayar_Total->EditValue = ew_FormatNumber($this->Bayar_Total->EditValue, -2, -2, -2, -2);
			$this->Bayar_Total->OldValue = $this->Bayar_Total->EditValue;
			}

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Edit refer script
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

			// Terlambat
			$this->Terlambat->LinkCustomAttributes = "";
			$this->Terlambat->HrefValue = "";

			// Total_Denda
			$this->Total_Denda->LinkCustomAttributes = "";
			$this->Total_Denda->HrefValue = "";

			// Bayar_Titipan
			$this->Bayar_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Titipan->HrefValue = "";

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->LinkCustomAttributes = "";
			$this->Bayar_Non_Titipan->HrefValue = "";

			// Bayar_Total
			$this->Bayar_Total->LinkCustomAttributes = "";
			$this->Bayar_Total->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Angsuran_Ke->FldIsDetailKey && !is_null($this->Angsuran_Ke->FormValue) && $this->Angsuran_Ke->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Ke->FldCaption(), $this->Angsuran_Ke->ReqErrMsg));
		}
		if (!$this->Angsuran_Tanggal->FldIsDetailKey && !is_null($this->Angsuran_Tanggal->FormValue) && $this->Angsuran_Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Tanggal->FldCaption(), $this->Angsuran_Tanggal->ReqErrMsg));
		}
		if (!$this->Angsuran_Pokok->FldIsDetailKey && !is_null($this->Angsuran_Pokok->FormValue) && $this->Angsuran_Pokok->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Pokok->FldCaption(), $this->Angsuran_Pokok->ReqErrMsg));
		}
		if (!$this->Angsuran_Bunga->FldIsDetailKey && !is_null($this->Angsuran_Bunga->FormValue) && $this->Angsuran_Bunga->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Bunga->FldCaption(), $this->Angsuran_Bunga->ReqErrMsg));
		}
		if (!$this->Angsuran_Total->FldIsDetailKey && !is_null($this->Angsuran_Total->FormValue) && $this->Angsuran_Total->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Angsuran_Total->FldCaption(), $this->Angsuran_Total->ReqErrMsg));
		}
		if (!$this->Sisa_Hutang->FldIsDetailKey && !is_null($this->Sisa_Hutang->FormValue) && $this->Sisa_Hutang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Sisa_Hutang->FldCaption(), $this->Sisa_Hutang->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Tanggal_Bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal_Bayar->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Terlambat->FormValue)) {
			ew_AddMessage($gsFormError, $this->Terlambat->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Total_Denda->FormValue)) {
			ew_AddMessage($gsFormError, $this->Total_Denda->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Bayar_Titipan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bayar_Titipan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Bayar_Non_Titipan->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bayar_Non_Titipan->FldErrMsg());
		}
		if (!ew_CheckNumber($this->Bayar_Total->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bayar_Total->FldErrMsg());
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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Tanggal_Bayar
			$this->Tanggal_Bayar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 7), NULL, $this->Tanggal_Bayar->ReadOnly);

			// Terlambat
			$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, $this->Terlambat->ReadOnly);

			// Total_Denda
			$this->Total_Denda->SetDbValueDef($rsnew, $this->Total_Denda->CurrentValue, NULL, $this->Total_Denda->ReadOnly);

			// Bayar_Titipan
			$this->Bayar_Titipan->SetDbValueDef($rsnew, $this->Bayar_Titipan->CurrentValue, NULL, $this->Bayar_Titipan->ReadOnly);

			// Bayar_Non_Titipan
			$this->Bayar_Non_Titipan->SetDbValueDef($rsnew, $this->Bayar_Non_Titipan->CurrentValue, NULL, $this->Bayar_Non_Titipan->ReadOnly);

			// Bayar_Total
			$this->Bayar_Total->SetDbValueDef($rsnew, $this->Bayar_Total->CurrentValue, NULL, $this->Bayar_Total->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, $this->Keterangan->ReadOnly);

			// Check referential integrity for master table 't03_pinjaman'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_t03_pinjaman();
			$KeyValue = isset($rsnew['pinjaman_id']) ? $rsnew['pinjaman_id'] : $rsold['pinjaman_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["t03_pinjaman"])) $GLOBALS["t03_pinjaman"] = new ct03_pinjaman();
				$rsmaster = $GLOBALS["t03_pinjaman"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "t03_pinjaman", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "t03_pinjaman") {
				$this->pinjaman_id->CurrentValue = $this->pinjaman_id->getSessionValue();
			}

		// Check referential integrity for master table 't03_pinjaman'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_t03_pinjaman();
		if ($this->pinjaman_id->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->pinjaman_id->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["t03_pinjaman"])) $GLOBALS["t03_pinjaman"] = new ct03_pinjaman();
			$rsmaster = $GLOBALS["t03_pinjaman"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "t03_pinjaman", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Angsuran_Ke
		$this->Angsuran_Ke->SetDbValueDef($rsnew, $this->Angsuran_Ke->CurrentValue, 0, FALSE);

		// Angsuran_Tanggal
		$this->Angsuran_Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Angsuran_Tanggal->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// Angsuran_Pokok
		$this->Angsuran_Pokok->SetDbValueDef($rsnew, $this->Angsuran_Pokok->CurrentValue, 0, FALSE);

		// Angsuran_Bunga
		$this->Angsuran_Bunga->SetDbValueDef($rsnew, $this->Angsuran_Bunga->CurrentValue, 0, FALSE);

		// Angsuran_Total
		$this->Angsuran_Total->SetDbValueDef($rsnew, $this->Angsuran_Total->CurrentValue, 0, FALSE);

		// Sisa_Hutang
		$this->Sisa_Hutang->SetDbValueDef($rsnew, $this->Sisa_Hutang->CurrentValue, 0, FALSE);

		// Tanggal_Bayar
		$this->Tanggal_Bayar->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal_Bayar->CurrentValue, 7), NULL, FALSE);

		// Terlambat
		$this->Terlambat->SetDbValueDef($rsnew, $this->Terlambat->CurrentValue, NULL, FALSE);

		// Total_Denda
		$this->Total_Denda->SetDbValueDef($rsnew, $this->Total_Denda->CurrentValue, NULL, FALSE);

		// Bayar_Titipan
		$this->Bayar_Titipan->SetDbValueDef($rsnew, $this->Bayar_Titipan->CurrentValue, NULL, FALSE);

		// Bayar_Non_Titipan
		$this->Bayar_Non_Titipan->SetDbValueDef($rsnew, $this->Bayar_Non_Titipan->CurrentValue, NULL, FALSE);

		// Bayar_Total
		$this->Bayar_Total->SetDbValueDef($rsnew, $this->Bayar_Total->CurrentValue, NULL, FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, NULL, FALSE);

		// pinjaman_id
		if ($this->pinjaman_id->getSessionValue() <> "") {
			$rsnew['pinjaman_id'] = $this->pinjaman_id->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "t03_pinjaman") {
			$this->pinjaman_id->Visible = FALSE;
			if ($GLOBALS["t03_pinjaman"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
}
?>
