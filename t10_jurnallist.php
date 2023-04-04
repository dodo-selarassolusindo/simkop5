<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t10_jurnalinfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t10_jurnal_list = NULL; // Initialize page object first

class ct10_jurnal_list extends ct10_jurnal {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't10_jurnal';

	// Page object name
	var $PageObjName = 't10_jurnal_list';

	// Grid form hidden field names
	var $FormName = 'ft10_jurnallist';
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

		// Table object (t10_jurnal)
		if (!isset($GLOBALS["t10_jurnal"]) || get_class($GLOBALS["t10_jurnal"]) == "ct10_jurnal") {
			$GLOBALS["t10_jurnal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t10_jurnal"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t10_jurnaladd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t10_jurnaldelete.php";
		$this->MultiUpdateUrl = "t10_jurnalupdate.php";

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't10_jurnal', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft10_jurnallistsrch";

		// List actions
		$this->ListActions = new cListActions();
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

		// Create form object
		$objForm = new cFormObj();

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->Tanggal->SetVisibility();
		$this->NomorTransaksi->SetVisibility();
		$this->Keterangan->SetVisibility();
		$this->Rekening->SetVisibility();
		$this->Debet->SetVisibility();
		$this->Kredit->SetVisibility();

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
		global $EW_EXPORT, $t10_jurnal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t10_jurnal);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
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

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 100; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);
		if ($sFilter == "") {
			$sFilter = "0=101";
			$this->SearchWhere = $sFilter;
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

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

		// Search options
		$this->SetupSearchOptions();
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
		$this->setKey("id", ""); // Clear inline edit key
		$this->Debet->FormValue = ""; // Clear form value
		$this->Kredit->FormValue = ""; // Clear form value
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

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("id", $this->id->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("id")) <> strval($this->id->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		if ($this->CurrentAction == "copy") {
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CurrentAction = "add";
			}
		}
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
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

		// Begin transaction
		$conn->BeginTrans();
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
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
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

		// Begin transaction
		$conn->BeginTrans();

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
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

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
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
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
		if ($objForm->HasValue("x_Tanggal") && $objForm->HasValue("o_Tanggal") && $this->Tanggal->CurrentValue <> $this->Tanggal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NomorTransaksi") && $objForm->HasValue("o_NomorTransaksi") && $this->NomorTransaksi->CurrentValue <> $this->NomorTransaksi->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Keterangan") && $objForm->HasValue("o_Keterangan") && $this->Keterangan->CurrentValue <> $this->Keterangan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Rekening") && $objForm->HasValue("o_Rekening") && $this->Rekening->CurrentValue <> $this->Rekening->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Debet") && $objForm->HasValue("o_Debet") && $this->Debet->CurrentValue <> $this->Debet->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Kredit") && $objForm->HasValue("o_Kredit") && $this->Kredit->CurrentValue <> $this->Kredit->OldValue)
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

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft10_jurnallistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->Periode->AdvancedSearch->ToJSON(), ","); // Field Periode
		$sFilterList = ew_Concat($sFilterList, $this->Tanggal->AdvancedSearch->ToJSON(), ","); // Field Tanggal
		$sFilterList = ew_Concat($sFilterList, $this->NomorTransaksi->AdvancedSearch->ToJSON(), ","); // Field NomorTransaksi
		$sFilterList = ew_Concat($sFilterList, $this->Keterangan->AdvancedSearch->ToJSON(), ","); // Field Keterangan
		$sFilterList = ew_Concat($sFilterList, $this->Rekening->AdvancedSearch->ToJSON(), ","); // Field Rekening
		$sFilterList = ew_Concat($sFilterList, $this->Debet->AdvancedSearch->ToJSON(), ","); // Field Debet
		$sFilterList = ew_Concat($sFilterList, $this->Kredit->AdvancedSearch->ToJSON(), ","); // Field Kredit
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft10_jurnallistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field Periode
		$this->Periode->AdvancedSearch->SearchValue = @$filter["x_Periode"];
		$this->Periode->AdvancedSearch->SearchOperator = @$filter["z_Periode"];
		$this->Periode->AdvancedSearch->SearchCondition = @$filter["v_Periode"];
		$this->Periode->AdvancedSearch->SearchValue2 = @$filter["y_Periode"];
		$this->Periode->AdvancedSearch->SearchOperator2 = @$filter["w_Periode"];
		$this->Periode->AdvancedSearch->Save();

		// Field Tanggal
		$this->Tanggal->AdvancedSearch->SearchValue = @$filter["x_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchOperator = @$filter["z_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchCondition = @$filter["v_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchValue2 = @$filter["y_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_Tanggal"];
		$this->Tanggal->AdvancedSearch->Save();

		// Field NomorTransaksi
		$this->NomorTransaksi->AdvancedSearch->SearchValue = @$filter["x_NomorTransaksi"];
		$this->NomorTransaksi->AdvancedSearch->SearchOperator = @$filter["z_NomorTransaksi"];
		$this->NomorTransaksi->AdvancedSearch->SearchCondition = @$filter["v_NomorTransaksi"];
		$this->NomorTransaksi->AdvancedSearch->SearchValue2 = @$filter["y_NomorTransaksi"];
		$this->NomorTransaksi->AdvancedSearch->SearchOperator2 = @$filter["w_NomorTransaksi"];
		$this->NomorTransaksi->AdvancedSearch->Save();

		// Field Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = @$filter["x_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator = @$filter["z_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchCondition = @$filter["v_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchValue2 = @$filter["y_Keterangan"];
		$this->Keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_Keterangan"];
		$this->Keterangan->AdvancedSearch->Save();

		// Field Rekening
		$this->Rekening->AdvancedSearch->SearchValue = @$filter["x_Rekening"];
		$this->Rekening->AdvancedSearch->SearchOperator = @$filter["z_Rekening"];
		$this->Rekening->AdvancedSearch->SearchCondition = @$filter["v_Rekening"];
		$this->Rekening->AdvancedSearch->SearchValue2 = @$filter["y_Rekening"];
		$this->Rekening->AdvancedSearch->SearchOperator2 = @$filter["w_Rekening"];
		$this->Rekening->AdvancedSearch->Save();

		// Field Debet
		$this->Debet->AdvancedSearch->SearchValue = @$filter["x_Debet"];
		$this->Debet->AdvancedSearch->SearchOperator = @$filter["z_Debet"];
		$this->Debet->AdvancedSearch->SearchCondition = @$filter["v_Debet"];
		$this->Debet->AdvancedSearch->SearchValue2 = @$filter["y_Debet"];
		$this->Debet->AdvancedSearch->SearchOperator2 = @$filter["w_Debet"];
		$this->Debet->AdvancedSearch->Save();

		// Field Kredit
		$this->Kredit->AdvancedSearch->SearchValue = @$filter["x_Kredit"];
		$this->Kredit->AdvancedSearch->SearchOperator = @$filter["z_Kredit"];
		$this->Kredit->AdvancedSearch->SearchCondition = @$filter["v_Kredit"];
		$this->Kredit->AdvancedSearch->SearchValue2 = @$filter["y_Kredit"];
		$this->Kredit->AdvancedSearch->SearchOperator2 = @$filter["w_Kredit"];
		$this->Kredit->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->id, $Default, FALSE); // id
		$this->BuildSearchSql($sWhere, $this->Periode, $Default, FALSE); // Periode
		$this->BuildSearchSql($sWhere, $this->Tanggal, $Default, FALSE); // Tanggal
		$this->BuildSearchSql($sWhere, $this->NomorTransaksi, $Default, FALSE); // NomorTransaksi
		$this->BuildSearchSql($sWhere, $this->Keterangan, $Default, FALSE); // Keterangan
		$this->BuildSearchSql($sWhere, $this->Rekening, $Default, FALSE); // Rekening
		$this->BuildSearchSql($sWhere, $this->Debet, $Default, FALSE); // Debet
		$this->BuildSearchSql($sWhere, $this->Kredit, $Default, FALSE); // Kredit

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id->AdvancedSearch->Save(); // id
			$this->Periode->AdvancedSearch->Save(); // Periode
			$this->Tanggal->AdvancedSearch->Save(); // Tanggal
			$this->NomorTransaksi->AdvancedSearch->Save(); // NomorTransaksi
			$this->Keterangan->AdvancedSearch->Save(); // Keterangan
			$this->Rekening->AdvancedSearch->Save(); // Rekening
			$this->Debet->AdvancedSearch->Save(); // Debet
			$this->Kredit->AdvancedSearch->Save(); // Kredit
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Periode->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Tanggal->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NomorTransaksi->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Keterangan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Rekening->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Debet->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Kredit->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id->AdvancedSearch->UnsetSession();
		$this->Periode->AdvancedSearch->UnsetSession();
		$this->Tanggal->AdvancedSearch->UnsetSession();
		$this->NomorTransaksi->AdvancedSearch->UnsetSession();
		$this->Keterangan->AdvancedSearch->UnsetSession();
		$this->Rekening->AdvancedSearch->UnsetSession();
		$this->Debet->AdvancedSearch->UnsetSession();
		$this->Kredit->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->id->AdvancedSearch->Load();
		$this->Periode->AdvancedSearch->Load();
		$this->Tanggal->AdvancedSearch->Load();
		$this->NomorTransaksi->AdvancedSearch->Load();
		$this->Keterangan->AdvancedSearch->Load();
		$this->Rekening->AdvancedSearch->Load();
		$this->Debet->AdvancedSearch->Load();
		$this->Kredit->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Tanggal, $bCtrl); // Tanggal
			$this->UpdateSort($this->NomorTransaksi, $bCtrl); // NomorTransaksi
			$this->UpdateSort($this->Keterangan, $bCtrl); // Keterangan
			$this->UpdateSort($this->Rekening, $bCtrl); // Rekening
			$this->UpdateSort($this->Debet, $bCtrl); // Debet
			$this->UpdateSort($this->Kredit, $bCtrl); // Kredit
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Tanggal->setSort("");
				$this->NomorTransaksi->setSort("");
				$this->Keterangan->setSort("");
				$this->Rekening->setSort("");
				$this->Debet->setSort("");
				$this->Kredit->setSort("");
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

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineCopyUrl) . "\">" . $Language->Phrase("InlineCopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft10_jurnallistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft10_jurnallistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft10_jurnallist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft10_jurnallistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ResetSearch") . "\" data-caption=\"" . $Language->Phrase("ResetSearch") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ResetSearchBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

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

	// Load default values
	function LoadDefaultValues() {
		$this->Tanggal->CurrentValue = NULL;
		$this->Tanggal->OldValue = $this->Tanggal->CurrentValue;
		$this->NomorTransaksi->CurrentValue = NULL;
		$this->NomorTransaksi->OldValue = $this->NomorTransaksi->CurrentValue;
		$this->Keterangan->CurrentValue = NULL;
		$this->Keterangan->OldValue = $this->Keterangan->CurrentValue;
		$this->Rekening->CurrentValue = NULL;
		$this->Rekening->OldValue = $this->Rekening->CurrentValue;
		$this->Debet->CurrentValue = NULL;
		$this->Debet->OldValue = $this->Debet->CurrentValue;
		$this->Kredit->CurrentValue = NULL;
		$this->Kredit->OldValue = $this->Kredit->CurrentValue;
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id

		$this->id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_id"]);
		if ($this->id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->id->AdvancedSearch->SearchOperator = @$_GET["z_id"];

		// Periode
		$this->Periode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Periode"]);
		if ($this->Periode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Periode->AdvancedSearch->SearchOperator = @$_GET["z_Periode"];

		// Tanggal
		$this->Tanggal->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Tanggal"]);
		if ($this->Tanggal->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Tanggal->AdvancedSearch->SearchOperator = @$_GET["z_Tanggal"];

		// NomorTransaksi
		$this->NomorTransaksi->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NomorTransaksi"]);
		if ($this->NomorTransaksi->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NomorTransaksi->AdvancedSearch->SearchOperator = @$_GET["z_NomorTransaksi"];

		// Keterangan
		$this->Keterangan->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Keterangan"]);
		if ($this->Keterangan->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Keterangan->AdvancedSearch->SearchOperator = @$_GET["z_Keterangan"];

		// Rekening
		$this->Rekening->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Rekening"]);
		if ($this->Rekening->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Rekening->AdvancedSearch->SearchOperator = @$_GET["z_Rekening"];

		// Debet
		$this->Debet->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Debet"]);
		if ($this->Debet->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Debet->AdvancedSearch->SearchOperator = @$_GET["z_Debet"];

		// Kredit
		$this->Kredit->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Kredit"]);
		if ($this->Kredit->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Kredit->AdvancedSearch->SearchOperator = @$_GET["z_Kredit"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Tanggal->FldIsDetailKey) {
			$this->Tanggal->setFormValue($objForm->GetValue("x_Tanggal"));
			$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		}
		$this->Tanggal->setOldValue($objForm->GetValue("o_Tanggal"));
		if (!$this->NomorTransaksi->FldIsDetailKey) {
			$this->NomorTransaksi->setFormValue($objForm->GetValue("x_NomorTransaksi"));
		}
		$this->NomorTransaksi->setOldValue($objForm->GetValue("o_NomorTransaksi"));
		if (!$this->Keterangan->FldIsDetailKey) {
			$this->Keterangan->setFormValue($objForm->GetValue("x_Keterangan"));
		}
		$this->Keterangan->setOldValue($objForm->GetValue("o_Keterangan"));
		if (!$this->Rekening->FldIsDetailKey) {
			$this->Rekening->setFormValue($objForm->GetValue("x_Rekening"));
		}
		$this->Rekening->setOldValue($objForm->GetValue("o_Rekening"));
		if (!$this->Debet->FldIsDetailKey) {
			$this->Debet->setFormValue($objForm->GetValue("x_Debet"));
		}
		$this->Debet->setOldValue($objForm->GetValue("o_Debet"));
		if (!$this->Kredit->FldIsDetailKey) {
			$this->Kredit->setFormValue($objForm->GetValue("x_Kredit"));
		}
		$this->Kredit->setOldValue($objForm->GetValue("o_Kredit"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
		$this->Tanggal->CurrentValue = ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7);
		$this->NomorTransaksi->CurrentValue = $this->NomorTransaksi->FormValue;
		$this->Keterangan->CurrentValue = $this->Keterangan->FormValue;
		$this->Rekening->CurrentValue = $this->Rekening->FormValue;
		$this->Debet->CurrentValue = $this->Debet->FormValue;
		$this->Kredit->CurrentValue = $this->Kredit->FormValue;
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
		$this->Periode->setDbValue($rs->fields('Periode'));
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->NomorTransaksi->setDbValue($rs->fields('NomorTransaksi'));
		$this->Keterangan->setDbValue($rs->fields('Keterangan'));
		$this->Rekening->setDbValue($rs->fields('Rekening'));
		$this->Debet->setDbValue($rs->fields('Debet'));
		$this->Kredit->setDbValue($rs->fields('Kredit'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->Periode->DbValue = $row['Periode'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->NomorTransaksi->DbValue = $row['NomorTransaksi'];
		$this->Keterangan->DbValue = $row['Keterangan'];
		$this->Rekening->DbValue = $row['Rekening'];
		$this->Debet->DbValue = $row['Debet'];
		$this->Kredit->DbValue = $row['Kredit'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->Debet->FormValue == $this->Debet->CurrentValue && is_numeric(ew_StrToFloat($this->Debet->CurrentValue)))
			$this->Debet->CurrentValue = ew_StrToFloat($this->Debet->CurrentValue);

		// Convert decimal values if posted back
		if ($this->Kredit->FormValue == $this->Kredit->CurrentValue && is_numeric(ew_StrToFloat($this->Kredit->CurrentValue)))
			$this->Kredit->CurrentValue = ew_StrToFloat($this->Kredit->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// Periode
		// Tanggal
		// NomorTransaksi
		// Keterangan
		// Rekening
		// Debet
		// Kredit

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 7);
		$this->Tanggal->ViewCustomAttributes = "";

		// NomorTransaksi
		$this->NomorTransaksi->ViewValue = $this->NomorTransaksi->CurrentValue;
		if (strval($this->NomorTransaksi->CurrentValue) <> "") {
			$sFilterWrk = "`NomorTransaksi`" . ew_SearchString("=", $this->NomorTransaksi->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
		$sWhereWrk = "";
		$this->NomorTransaksi->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NomorTransaksi->ViewValue = $this->NomorTransaksi->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NomorTransaksi->ViewValue = $this->NomorTransaksi->CurrentValue;
			}
		} else {
			$this->NomorTransaksi->ViewValue = NULL;
		}
		$this->NomorTransaksi->ViewCustomAttributes = "";

		// Keterangan
		$this->Keterangan->ViewValue = $this->Keterangan->CurrentValue;
		$this->Keterangan->ViewCustomAttributes = "";

		// Rekening
		if (strval($this->Rekening->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->Rekening->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
		$sWhereWrk = "";
		$this->Rekening->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Rekening, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Rekening->ViewValue = $this->Rekening->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Rekening->ViewValue = $this->Rekening->CurrentValue;
			}
		} else {
			$this->Rekening->ViewValue = NULL;
		}
		$this->Rekening->ViewCustomAttributes = "";

		// Debet
		$this->Debet->ViewValue = $this->Debet->CurrentValue;
		$this->Debet->ViewValue = ew_FormatNumber($this->Debet->ViewValue, 2, -2, -2, -2);
		$this->Debet->CellCssStyle .= "text-align: right;";
		$this->Debet->ViewCustomAttributes = "";

		// Kredit
		$this->Kredit->ViewValue = $this->Kredit->CurrentValue;
		$this->Kredit->ViewValue = ew_FormatNumber($this->Kredit->ViewValue, 2, -2, -2, -2);
		$this->Kredit->CellCssStyle .= "text-align: right;";
		$this->Kredit->ViewCustomAttributes = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// NomorTransaksi
			$this->NomorTransaksi->LinkCustomAttributes = "";
			$this->NomorTransaksi->HrefValue = "";
			$this->NomorTransaksi->TooltipValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";
			$this->Keterangan->TooltipValue = "";

			// Rekening
			$this->Rekening->LinkCustomAttributes = "";
			$this->Rekening->HrefValue = "";
			$this->Rekening->TooltipValue = "";

			// Debet
			$this->Debet->LinkCustomAttributes = "";
			$this->Debet->HrefValue = "";
			$this->Debet->TooltipValue = "";

			// Kredit
			$this->Kredit->LinkCustomAttributes = "";
			$this->Kredit->HrefValue = "";
			$this->Kredit->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "style='width: 115px;'";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 7));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// NomorTransaksi
			$this->NomorTransaksi->EditAttrs["class"] = "form-control";
			$this->NomorTransaksi->EditCustomAttributes = "";
			$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->CurrentValue);
			if (strval($this->NomorTransaksi->CurrentValue) <> "") {
				$sFilterWrk = "`NomorTransaksi`" . ew_SearchString("=", $this->NomorTransaksi->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
			$sWhereWrk = "";
			$this->NomorTransaksi->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NomorTransaksi->EditValue = $this->NomorTransaksi->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->CurrentValue);
				}
			} else {
				$this->NomorTransaksi->EditValue = NULL;
			}
			$this->NomorTransaksi->PlaceHolder = ew_RemoveHtml($this->NomorTransaksi->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Rekening
			$this->Rekening->EditAttrs["class"] = "form-control";
			$this->Rekening->EditCustomAttributes = "";
			if (trim(strval($this->Rekening->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->Rekening->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->Rekening->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Rekening, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Rekening->EditValue = $arwrk;

			// Debet
			$this->Debet->EditAttrs["class"] = "form-control";
			$this->Debet->EditCustomAttributes = "";
			$this->Debet->EditValue = ew_HtmlEncode($this->Debet->CurrentValue);
			$this->Debet->PlaceHolder = ew_RemoveHtml($this->Debet->FldCaption());
			if (strval($this->Debet->EditValue) <> "" && is_numeric($this->Debet->EditValue)) {
			$this->Debet->EditValue = ew_FormatNumber($this->Debet->EditValue, -2, -2, -2, -2);
			$this->Debet->OldValue = $this->Debet->EditValue;
			}

			// Kredit
			$this->Kredit->EditAttrs["class"] = "form-control";
			$this->Kredit->EditCustomAttributes = "";
			$this->Kredit->EditValue = ew_HtmlEncode($this->Kredit->CurrentValue);
			$this->Kredit->PlaceHolder = ew_RemoveHtml($this->Kredit->FldCaption());
			if (strval($this->Kredit->EditValue) <> "" && is_numeric($this->Kredit->EditValue)) {
			$this->Kredit->EditValue = ew_FormatNumber($this->Kredit->EditValue, -2, -2, -2, -2);
			$this->Kredit->OldValue = $this->Kredit->EditValue;
			}

			// Add refer script
			// Tanggal

			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// NomorTransaksi
			$this->NomorTransaksi->LinkCustomAttributes = "";
			$this->NomorTransaksi->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Rekening
			$this->Rekening->LinkCustomAttributes = "";
			$this->Rekening->HrefValue = "";

			// Debet
			$this->Debet->LinkCustomAttributes = "";
			$this->Debet->HrefValue = "";

			// Kredit
			$this->Kredit->LinkCustomAttributes = "";
			$this->Kredit->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "style='width: 115px;'";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Tanggal->CurrentValue, 7));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// NomorTransaksi
			$this->NomorTransaksi->EditAttrs["class"] = "form-control";
			$this->NomorTransaksi->EditCustomAttributes = "";
			$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->CurrentValue);
			if (strval($this->NomorTransaksi->CurrentValue) <> "") {
				$sFilterWrk = "`NomorTransaksi`" . ew_SearchString("=", $this->NomorTransaksi->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
			$sWhereWrk = "";
			$this->NomorTransaksi->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NomorTransaksi->EditValue = $this->NomorTransaksi->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->CurrentValue);
				}
			} else {
				$this->NomorTransaksi->EditValue = NULL;
			}
			$this->NomorTransaksi->PlaceHolder = ew_RemoveHtml($this->NomorTransaksi->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->CurrentValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Rekening
			$this->Rekening->EditAttrs["class"] = "form-control";
			$this->Rekening->EditCustomAttributes = "";
			if (trim(strval($this->Rekening->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->Rekening->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->Rekening->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Rekening, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Rekening->EditValue = $arwrk;

			// Debet
			$this->Debet->EditAttrs["class"] = "form-control";
			$this->Debet->EditCustomAttributes = "";
			$this->Debet->EditValue = ew_HtmlEncode($this->Debet->CurrentValue);
			$this->Debet->PlaceHolder = ew_RemoveHtml($this->Debet->FldCaption());
			if (strval($this->Debet->EditValue) <> "" && is_numeric($this->Debet->EditValue)) {
			$this->Debet->EditValue = ew_FormatNumber($this->Debet->EditValue, -2, -2, -2, -2);
			$this->Debet->OldValue = $this->Debet->EditValue;
			}

			// Kredit
			$this->Kredit->EditAttrs["class"] = "form-control";
			$this->Kredit->EditCustomAttributes = "";
			$this->Kredit->EditValue = ew_HtmlEncode($this->Kredit->CurrentValue);
			$this->Kredit->PlaceHolder = ew_RemoveHtml($this->Kredit->FldCaption());
			if (strval($this->Kredit->EditValue) <> "" && is_numeric($this->Kredit->EditValue)) {
			$this->Kredit->EditValue = ew_FormatNumber($this->Kredit->EditValue, -2, -2, -2, -2);
			$this->Kredit->OldValue = $this->Kredit->EditValue;
			}

			// Edit refer script
			// Tanggal

			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";

			// NomorTransaksi
			$this->NomorTransaksi->LinkCustomAttributes = "";
			$this->NomorTransaksi->HrefValue = "";

			// Keterangan
			$this->Keterangan->LinkCustomAttributes = "";
			$this->Keterangan->HrefValue = "";

			// Rekening
			$this->Rekening->LinkCustomAttributes = "";
			$this->Rekening->HrefValue = "";

			// Debet
			$this->Debet->LinkCustomAttributes = "";
			$this->Debet->HrefValue = "";

			// Kredit
			$this->Kredit->LinkCustomAttributes = "";
			$this->Kredit->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// Tanggal
			$this->Tanggal->EditAttrs["class"] = "form-control";
			$this->Tanggal->EditCustomAttributes = "style='width: 115px;'";
			$this->Tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->Tanggal->AdvancedSearch->SearchValue, 7), 7));
			$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

			// NomorTransaksi
			$this->NomorTransaksi->EditAttrs["class"] = "form-control";
			$this->NomorTransaksi->EditCustomAttributes = "";
			$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->AdvancedSearch->SearchValue);
			if (strval($this->NomorTransaksi->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NomorTransaksi`" . ew_SearchString("=", $this->NomorTransaksi->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
			$sWhereWrk = "";
			$this->NomorTransaksi->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NomorTransaksi->EditValue = $this->NomorTransaksi->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NomorTransaksi->EditValue = ew_HtmlEncode($this->NomorTransaksi->AdvancedSearch->SearchValue);
				}
			} else {
				$this->NomorTransaksi->EditValue = NULL;
			}
			$this->NomorTransaksi->PlaceHolder = ew_RemoveHtml($this->NomorTransaksi->FldCaption());

			// Keterangan
			$this->Keterangan->EditAttrs["class"] = "form-control";
			$this->Keterangan->EditCustomAttributes = "";
			$this->Keterangan->EditValue = ew_HtmlEncode($this->Keterangan->AdvancedSearch->SearchValue);
			$this->Keterangan->PlaceHolder = ew_RemoveHtml($this->Keterangan->FldCaption());

			// Rekening
			$this->Rekening->EditAttrs["class"] = "form-control";
			$this->Rekening->EditCustomAttributes = "";

			// Debet
			$this->Debet->EditAttrs["class"] = "form-control";
			$this->Debet->EditCustomAttributes = "";
			$this->Debet->EditValue = ew_HtmlEncode($this->Debet->AdvancedSearch->SearchValue);
			$this->Debet->PlaceHolder = ew_RemoveHtml($this->Debet->FldCaption());

			// Kredit
			$this->Kredit->EditAttrs["class"] = "form-control";
			$this->Kredit->EditCustomAttributes = "";
			$this->Kredit->EditValue = ew_HtmlEncode($this->Kredit->AdvancedSearch->SearchValue);
			$this->Kredit->PlaceHolder = ew_RemoveHtml($this->Kredit->FldCaption());
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->Tanggal->FldIsDetailKey && !is_null($this->Tanggal->FormValue) && $this->Tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Tanggal->FldCaption(), $this->Tanggal->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->Tanggal->FldErrMsg());
		}
		if (!$this->NomorTransaksi->FldIsDetailKey && !is_null($this->NomorTransaksi->FormValue) && $this->NomorTransaksi->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NomorTransaksi->FldCaption(), $this->NomorTransaksi->ReqErrMsg));
		}
		if (!$this->Keterangan->FldIsDetailKey && !is_null($this->Keterangan->FormValue) && $this->Keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Keterangan->FldCaption(), $this->Keterangan->ReqErrMsg));
		}
		if (!$this->Rekening->FldIsDetailKey && !is_null($this->Rekening->FormValue) && $this->Rekening->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Rekening->FldCaption(), $this->Rekening->ReqErrMsg));
		}
		if (!$this->Debet->FldIsDetailKey && !is_null($this->Debet->FormValue) && $this->Debet->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Debet->FldCaption(), $this->Debet->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Debet->FormValue)) {
			ew_AddMessage($gsFormError, $this->Debet->FldErrMsg());
		}
		if (!$this->Kredit->FldIsDetailKey && !is_null($this->Kredit->FormValue) && $this->Kredit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Kredit->FldCaption(), $this->Kredit->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Kredit->FormValue)) {
			ew_AddMessage($gsFormError, $this->Kredit->FldErrMsg());
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

			// Tanggal
			$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7), ew_CurrentDate(), $this->Tanggal->ReadOnly);

			// NomorTransaksi
			$this->NomorTransaksi->SetDbValueDef($rsnew, $this->NomorTransaksi->CurrentValue, "", $this->NomorTransaksi->ReadOnly);

			// Keterangan
			$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, "", $this->Keterangan->ReadOnly);

			// Rekening
			$this->Rekening->SetDbValueDef($rsnew, $this->Rekening->CurrentValue, "", $this->Rekening->ReadOnly);

			// Debet
			$this->Debet->SetDbValueDef($rsnew, $this->Debet->CurrentValue, 0, $this->Debet->ReadOnly);

			// Kredit
			$this->Kredit->SetDbValueDef($rsnew, $this->Kredit->CurrentValue, 0, $this->Kredit->ReadOnly);

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
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Tanggal
		$this->Tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Tanggal->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// NomorTransaksi
		$this->NomorTransaksi->SetDbValueDef($rsnew, $this->NomorTransaksi->CurrentValue, "", FALSE);

		// Keterangan
		$this->Keterangan->SetDbValueDef($rsnew, $this->Keterangan->CurrentValue, "", FALSE);

		// Rekening
		$this->Rekening->SetDbValueDef($rsnew, $this->Rekening->CurrentValue, "", FALSE);

		// Debet
		$this->Debet->SetDbValueDef($rsnew, $this->Debet->CurrentValue, 0, FALSE);

		// Kredit
		$this->Kredit->SetDbValueDef($rsnew, $this->Kredit->CurrentValue, 0, FALSE);

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

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->id->AdvancedSearch->Load();
		$this->Periode->AdvancedSearch->Load();
		$this->Tanggal->AdvancedSearch->Load();
		$this->NomorTransaksi->AdvancedSearch->Load();
		$this->Keterangan->AdvancedSearch->Load();
		$this->Rekening->AdvancedSearch->Load();
		$this->Debet->AdvancedSearch->Load();
		$this->Kredit->AdvancedSearch->Load();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_t10_jurnal\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t10_jurnal',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft10_jurnallist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
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
		if ($pageId == "list") {
			switch ($fld->FldVar) {
		case "x_NomorTransaksi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NomorTransaksi` AS `LinkFld`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
			$sWhereWrk = "{filter}";
			$this->NomorTransaksi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NomorTransaksi` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Rekening":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t91_rekening`";
			$sWhereWrk = "";
			$this->Rekening->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Rekening, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
		case "x_NomorTransaksi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NomorTransaksi` AS `LinkFld`, `NomorTransaksi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t10_jurnal`";
			$sWhereWrk = "{filter}";
			$this->NomorTransaksi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NomorTransaksi` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
		} 
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
		case "x_NomorTransaksi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld` FROM `t10_jurnal`";
			$sWhereWrk = "`NomorTransaksi` LIKE '{query_value}%'";
			$this->NomorTransaksi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
		case "x_NomorTransaksi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NomorTransaksi`, `NomorTransaksi` AS `DispFld` FROM `t10_jurnal`";
			$sWhereWrk = "`NomorTransaksi` LIKE '{query_value}%'";
			$this->NomorTransaksi->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NomorTransaksi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
			}
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
if (!isset($t10_jurnal_list)) $t10_jurnal_list = new ct10_jurnal_list();

// Page init
$t10_jurnal_list->Page_Init();

// Page main
$t10_jurnal_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t10_jurnal_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t10_jurnal->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft10_jurnallist = new ew_Form("ft10_jurnallist", "list");
ft10_jurnallist.FormKeyCountName = '<?php echo $t10_jurnal_list->FormKeyCountName ?>';

// Validate form
ft10_jurnallist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->Tanggal->FldCaption(), $t10_jurnal->Tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_jurnal->Tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NomorTransaksi");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->NomorTransaksi->FldCaption(), $t10_jurnal->NomorTransaksi->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->Keterangan->FldCaption(), $t10_jurnal->Keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Rekening");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->Rekening->FldCaption(), $t10_jurnal->Rekening->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->Debet->FldCaption(), $t10_jurnal->Debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_jurnal->Debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t10_jurnal->Kredit->FldCaption(), $t10_jurnal->Kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t10_jurnal->Kredit->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ft10_jurnallist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NomorTransaksi", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Keterangan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Rekening", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kredit", false)) return false;
	return true;
}

// Form_CustomValidate event
ft10_jurnallist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_jurnallist.ValidateRequired = true;
<?php } else { ?>
ft10_jurnallist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft10_jurnallist.Lists["x_NomorTransaksi"] = {"LinkField":"x_NomorTransaksi","Ajax":true,"AutoFill":false,"DisplayFields":["x_NomorTransaksi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t10_jurnal"};
ft10_jurnallist.Lists["x_Rekening"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_rekening","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t91_rekening"};

// Form object for search
var CurrentSearchForm = ft10_jurnallistsrch = new ew_Form("ft10_jurnallistsrch");

// Validate function for search
ft10_jurnallistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
ft10_jurnallistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft10_jurnallistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ft10_jurnallistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
ft10_jurnallistsrch.Lists["x_NomorTransaksi"] = {"LinkField":"x_NomorTransaksi","Ajax":true,"AutoFill":false,"DisplayFields":["x_NomorTransaksi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t10_jurnal"};
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t10_jurnal->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t10_jurnal->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t10_jurnal_list->TotalRecs > 0 && $t10_jurnal_list->ExportOptions->Visible()) { ?>
<?php $t10_jurnal_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t10_jurnal_list->SearchOptions->Visible()) { ?>
<?php $t10_jurnal_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t10_jurnal_list->FilterOptions->Visible()) { ?>
<?php $t10_jurnal_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($t10_jurnal->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
if ($t10_jurnal->CurrentAction == "gridadd") {
	$t10_jurnal->CurrentFilter = "0=1";
	$t10_jurnal_list->StartRec = 1;
	$t10_jurnal_list->DisplayRecs = $t10_jurnal->GridAddRowCount;
	$t10_jurnal_list->TotalRecs = $t10_jurnal_list->DisplayRecs;
	$t10_jurnal_list->StopRec = $t10_jurnal_list->DisplayRecs;
} else {
	$bSelectLimit = $t10_jurnal_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t10_jurnal_list->TotalRecs <= 0)
			$t10_jurnal_list->TotalRecs = $t10_jurnal->SelectRecordCount();
	} else {
		if (!$t10_jurnal_list->Recordset && ($t10_jurnal_list->Recordset = $t10_jurnal_list->LoadRecordset()))
			$t10_jurnal_list->TotalRecs = $t10_jurnal_list->Recordset->RecordCount();
	}
	$t10_jurnal_list->StartRec = 1;
	if ($t10_jurnal_list->DisplayRecs <= 0 || ($t10_jurnal->Export <> "" && $t10_jurnal->ExportAll)) // Display all records
		$t10_jurnal_list->DisplayRecs = $t10_jurnal_list->TotalRecs;
	if (!($t10_jurnal->Export <> "" && $t10_jurnal->ExportAll))
		$t10_jurnal_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t10_jurnal_list->Recordset = $t10_jurnal_list->LoadRecordset($t10_jurnal_list->StartRec-1, $t10_jurnal_list->DisplayRecs);

	// Set no record found message
	if ($t10_jurnal->CurrentAction == "" && $t10_jurnal_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t10_jurnal_list->setWarningMessage(ew_DeniedMsg());
		if ($t10_jurnal_list->SearchWhere == "0=101")
			$t10_jurnal_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t10_jurnal_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t10_jurnal_list->AuditTrailOnSearch && $t10_jurnal_list->Command == "search" && !$t10_jurnal_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t10_jurnal_list->getSessionWhere();
		$t10_jurnal_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t10_jurnal_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t10_jurnal->Export == "" && $t10_jurnal->CurrentAction == "") { ?>
<form name="ft10_jurnallistsrch" id="ft10_jurnallistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t10_jurnal_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft10_jurnallistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t10_jurnal">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$t10_jurnal_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$t10_jurnal->RowType = EW_ROWTYPE_SEARCH;

// Render row
$t10_jurnal->ResetAttrs();
$t10_jurnal_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($t10_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
	<div id="xsc_NomorTransaksi" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $t10_jurnal->NomorTransaksi->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NomorTransaksi" id="z_NomorTransaksi" value="LIKE"></span>
		<span class="ewSearchField">
<?php
$wrkonchange = trim(" " . @$t10_jurnal->NomorTransaksi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t10_jurnal->NomorTransaksi->EditAttrs["onchange"] = "";
?>
<span id="as_x_NomorTransaksi" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_NomorTransaksi" id="sv_x_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->EditValue ?>" size="10" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>"<?php echo $t10_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" data-value-separator="<?php echo $t10_jurnal->NomorTransaksi->DisplayValueSeparatorAttribute() ?>" name="x_NomorTransaksi" id="x_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NomorTransaksi" id="q_x_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->LookupFilterQuery(true, "extbs") ?>">
<script type="text/javascript">
ft10_jurnallistsrch.CreateAutoSuggest({"id":"x_NomorTransaksi","forceSelect":false});
</script>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t10_jurnal_list->ShowPageHeader(); ?>
<?php
$t10_jurnal_list->ShowMessage();
?>
<?php if ($t10_jurnal_list->TotalRecs > 0 || $t10_jurnal->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t10_jurnal">
<form name="ft10_jurnallist" id="ft10_jurnallist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t10_jurnal_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t10_jurnal_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t10_jurnal">
<div id="gmp_t10_jurnal" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t10_jurnal_list->TotalRecs > 0 || $t10_jurnal->CurrentAction == "add" || $t10_jurnal->CurrentAction == "copy" || $t10_jurnal->CurrentAction == "gridedit") { ?>
<table id="tbl_t10_jurnallist" class="table ewTable">
<?php echo $t10_jurnal->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t10_jurnal_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t10_jurnal_list->RenderListOptions();

// Render list options (header, left)
$t10_jurnal_list->ListOptions->Render("header", "left");
?>
<?php if ($t10_jurnal->Tanggal->Visible) { // Tanggal ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->Tanggal) == "") { ?>
		<th data-name="Tanggal"><div id="elh_t10_jurnal_Tanggal" class="t10_jurnal_Tanggal"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->Tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->Tanggal) ?>',2);"><div id="elh_t10_jurnal_Tanggal" class="t10_jurnal_Tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->Tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->Tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->Tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->NomorTransaksi) == "") { ?>
		<th data-name="NomorTransaksi"><div id="elh_t10_jurnal_NomorTransaksi" class="t10_jurnal_NomorTransaksi"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->NomorTransaksi->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NomorTransaksi"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->NomorTransaksi) ?>',2);"><div id="elh_t10_jurnal_NomorTransaksi" class="t10_jurnal_NomorTransaksi">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->NomorTransaksi->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->NomorTransaksi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->NomorTransaksi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_jurnal->Keterangan->Visible) { // Keterangan ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->Keterangan) == "") { ?>
		<th data-name="Keterangan"><div id="elh_t10_jurnal_Keterangan" class="t10_jurnal_Keterangan"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->Keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Keterangan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->Keterangan) ?>',2);"><div id="elh_t10_jurnal_Keterangan" class="t10_jurnal_Keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->Keterangan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->Keterangan->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->Keterangan->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_jurnal->Rekening->Visible) { // Rekening ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->Rekening) == "") { ?>
		<th data-name="Rekening"><div id="elh_t10_jurnal_Rekening" class="t10_jurnal_Rekening"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->Rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rekening"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->Rekening) ?>',2);"><div id="elh_t10_jurnal_Rekening" class="t10_jurnal_Rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->Rekening->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->Rekening->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->Rekening->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_jurnal->Debet->Visible) { // Debet ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->Debet) == "") { ?>
		<th data-name="Debet"><div id="elh_t10_jurnal_Debet" class="t10_jurnal_Debet"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->Debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Debet"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->Debet) ?>',2);"><div id="elh_t10_jurnal_Debet" class="t10_jurnal_Debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->Debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->Debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->Debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t10_jurnal->Kredit->Visible) { // Kredit ?>
	<?php if ($t10_jurnal->SortUrl($t10_jurnal->Kredit) == "") { ?>
		<th data-name="Kredit"><div id="elh_t10_jurnal_Kredit" class="t10_jurnal_Kredit"><div class="ewTableHeaderCaption"><?php echo $t10_jurnal->Kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kredit"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t10_jurnal->SortUrl($t10_jurnal->Kredit) ?>',2);"><div id="elh_t10_jurnal_Kredit" class="t10_jurnal_Kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t10_jurnal->Kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t10_jurnal->Kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t10_jurnal->Kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t10_jurnal_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t10_jurnal->CurrentAction == "add" || $t10_jurnal->CurrentAction == "copy") {
		$t10_jurnal_list->RowIndex = 0;
		$t10_jurnal_list->KeyCount = $t10_jurnal_list->RowIndex;
		if ($t10_jurnal->CurrentAction == "copy" && !$t10_jurnal_list->LoadRow())
				$t10_jurnal->CurrentAction = "add";
		if ($t10_jurnal->CurrentAction == "add")
			$t10_jurnal_list->LoadDefaultValues();
		if ($t10_jurnal->EventCancelled) // Insert failed
			$t10_jurnal_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t10_jurnal->ResetAttrs();
		$t10_jurnal->RowAttrs = array_merge($t10_jurnal->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t10_jurnal', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t10_jurnal->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t10_jurnal_list->RenderRow();

		// Render list options
		$t10_jurnal_list->RenderListOptions();
		$t10_jurnal_list->StartRowCnt = 0;
?>
	<tr<?php echo $t10_jurnal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_jurnal_list->ListOptions->Render("body", "left", $t10_jurnal_list->RowCnt);
?>
	<?php if ($t10_jurnal->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Tanggal" class="form-group t10_jurnal_Tanggal">
<input type="text" data-table="t10_jurnal" data-field="x_Tanggal" data-format="7" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Tanggal->EditValue ?>"<?php echo $t10_jurnal->Tanggal->EditAttributes() ?>>
<?php if (!$t10_jurnal->Tanggal->ReadOnly && !$t10_jurnal->Tanggal->Disabled && !isset($t10_jurnal->Tanggal->EditAttrs["readonly"]) && !isset($t10_jurnal->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft10_jurnallist", "x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Tanggal" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
		<td data-name="NomorTransaksi">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_NomorTransaksi" class="form-group t10_jurnal_NomorTransaksi">
<?php
$wrkonchange = trim(" " . @$t10_jurnal->NomorTransaksi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t10_jurnal->NomorTransaksi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" style="white-space: nowrap; z-index: <?php echo (9000 - $t10_jurnal_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->EditValue ?>" size="10" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>"<?php echo $t10_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" data-value-separator="<?php echo $t10_jurnal->NomorTransaksi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft10_jurnallist.CreateAutoSuggest({"id":"x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" name="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Keterangan" class="form-group t10_jurnal_Keterangan">
<input type="text" data-table="t10_jurnal" data-field="x_Keterangan" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Keterangan->EditValue ?>"<?php echo $t10_jurnal->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Keterangan" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Rekening->Visible) { // Rekening ?>
		<td data-name="Rekening">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Rekening" class="form-group t10_jurnal_Rekening">
<select data-table="t10_jurnal" data-field="x_Rekening" data-value-separator="<?php echo $t10_jurnal->Rekening->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening"<?php echo $t10_jurnal->Rekening->EditAttributes() ?>>
<?php echo $t10_jurnal->Rekening->SelectOptionListHtml("x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening") ?>
</select>
<input type="hidden" name="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo $t10_jurnal->Rekening->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Rekening" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t10_jurnal->Rekening->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Debet->Visible) { // Debet ?>
		<td data-name="Debet">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Debet" class="form-group t10_jurnal_Debet">
<input type="text" data-table="t10_jurnal" data-field="x_Debet" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Debet->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Debet->EditValue ?>"<?php echo $t10_jurnal->Debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Debet" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t10_jurnal->Debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Kredit->Visible) { // Kredit ?>
		<td data-name="Kredit">
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Kredit" class="form-group t10_jurnal_Kredit">
<input type="text" data-table="t10_jurnal" data-field="x_Kredit" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Kredit->EditValue ?>"<?php echo $t10_jurnal->Kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Kredit" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_jurnal_list->ListOptions->Render("body", "right", $t10_jurnal_list->RowCnt);
?>
<script type="text/javascript">
ft10_jurnallist.UpdateOpts(<?php echo $t10_jurnal_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t10_jurnal->ExportAll && $t10_jurnal->Export <> "") {
	$t10_jurnal_list->StopRec = $t10_jurnal_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t10_jurnal_list->TotalRecs > $t10_jurnal_list->StartRec + $t10_jurnal_list->DisplayRecs - 1)
		$t10_jurnal_list->StopRec = $t10_jurnal_list->StartRec + $t10_jurnal_list->DisplayRecs - 1;
	else
		$t10_jurnal_list->StopRec = $t10_jurnal_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t10_jurnal_list->FormKeyCountName) && ($t10_jurnal->CurrentAction == "gridadd" || $t10_jurnal->CurrentAction == "gridedit" || $t10_jurnal->CurrentAction == "F")) {
		$t10_jurnal_list->KeyCount = $objForm->GetValue($t10_jurnal_list->FormKeyCountName);
		$t10_jurnal_list->StopRec = $t10_jurnal_list->StartRec + $t10_jurnal_list->KeyCount - 1;
	}
}
$t10_jurnal_list->RecCnt = $t10_jurnal_list->StartRec - 1;
if ($t10_jurnal_list->Recordset && !$t10_jurnal_list->Recordset->EOF) {
	$t10_jurnal_list->Recordset->MoveFirst();
	$bSelectLimit = $t10_jurnal_list->UseSelectLimit;
	if (!$bSelectLimit && $t10_jurnal_list->StartRec > 1)
		$t10_jurnal_list->Recordset->Move($t10_jurnal_list->StartRec - 1);
} elseif (!$t10_jurnal->AllowAddDeleteRow && $t10_jurnal_list->StopRec == 0) {
	$t10_jurnal_list->StopRec = $t10_jurnal->GridAddRowCount;
}

// Initialize aggregate
$t10_jurnal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t10_jurnal->ResetAttrs();
$t10_jurnal_list->RenderRow();
$t10_jurnal_list->EditRowCnt = 0;
if ($t10_jurnal->CurrentAction == "edit")
	$t10_jurnal_list->RowIndex = 1;
if ($t10_jurnal->CurrentAction == "gridadd")
	$t10_jurnal_list->RowIndex = 0;
if ($t10_jurnal->CurrentAction == "gridedit")
	$t10_jurnal_list->RowIndex = 0;
while ($t10_jurnal_list->RecCnt < $t10_jurnal_list->StopRec) {
	$t10_jurnal_list->RecCnt++;
	if (intval($t10_jurnal_list->RecCnt) >= intval($t10_jurnal_list->StartRec)) {
		$t10_jurnal_list->RowCnt++;
		if ($t10_jurnal->CurrentAction == "gridadd" || $t10_jurnal->CurrentAction == "gridedit" || $t10_jurnal->CurrentAction == "F") {
			$t10_jurnal_list->RowIndex++;
			$objForm->Index = $t10_jurnal_list->RowIndex;
			if ($objForm->HasValue($t10_jurnal_list->FormActionName))
				$t10_jurnal_list->RowAction = strval($objForm->GetValue($t10_jurnal_list->FormActionName));
			elseif ($t10_jurnal->CurrentAction == "gridadd")
				$t10_jurnal_list->RowAction = "insert";
			else
				$t10_jurnal_list->RowAction = "";
		}

		// Set up key count
		$t10_jurnal_list->KeyCount = $t10_jurnal_list->RowIndex;

		// Init row class and style
		$t10_jurnal->ResetAttrs();
		$t10_jurnal->CssClass = "";
		if ($t10_jurnal->CurrentAction == "gridadd") {
			$t10_jurnal_list->LoadDefaultValues(); // Load default values
		} else {
			$t10_jurnal_list->LoadRowValues($t10_jurnal_list->Recordset); // Load row values
		}
		$t10_jurnal->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t10_jurnal->CurrentAction == "gridadd") // Grid add
			$t10_jurnal->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t10_jurnal->CurrentAction == "gridadd" && $t10_jurnal->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t10_jurnal_list->RestoreCurrentRowFormValues($t10_jurnal_list->RowIndex); // Restore form values
		if ($t10_jurnal->CurrentAction == "edit") {
			if ($t10_jurnal_list->CheckInlineEditKey() && $t10_jurnal_list->EditRowCnt == 0) { // Inline edit
				$t10_jurnal->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t10_jurnal->CurrentAction == "gridedit") { // Grid edit
			if ($t10_jurnal->EventCancelled) {
				$t10_jurnal_list->RestoreCurrentRowFormValues($t10_jurnal_list->RowIndex); // Restore form values
			}
			if ($t10_jurnal_list->RowAction == "insert")
				$t10_jurnal->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t10_jurnal->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t10_jurnal->CurrentAction == "edit" && $t10_jurnal->RowType == EW_ROWTYPE_EDIT && $t10_jurnal->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t10_jurnal_list->RestoreFormValues(); // Restore form values
		}
		if ($t10_jurnal->CurrentAction == "gridedit" && ($t10_jurnal->RowType == EW_ROWTYPE_EDIT || $t10_jurnal->RowType == EW_ROWTYPE_ADD) && $t10_jurnal->EventCancelled) // Update failed
			$t10_jurnal_list->RestoreCurrentRowFormValues($t10_jurnal_list->RowIndex); // Restore form values
		if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t10_jurnal_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t10_jurnal->RowAttrs = array_merge($t10_jurnal->RowAttrs, array('data-rowindex'=>$t10_jurnal_list->RowCnt, 'id'=>'r' . $t10_jurnal_list->RowCnt . '_t10_jurnal', 'data-rowtype'=>$t10_jurnal->RowType));

		// Render row
		$t10_jurnal_list->RenderRow();

		// Render list options
		$t10_jurnal_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t10_jurnal_list->RowAction <> "delete" && $t10_jurnal_list->RowAction <> "insertdelete" && !($t10_jurnal_list->RowAction == "insert" && $t10_jurnal->CurrentAction == "F" && $t10_jurnal_list->EmptyRow())) {
?>
	<tr<?php echo $t10_jurnal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_jurnal_list->ListOptions->Render("body", "left", $t10_jurnal_list->RowCnt);
?>
	<?php if ($t10_jurnal->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal"<?php echo $t10_jurnal->Tanggal->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Tanggal" class="form-group t10_jurnal_Tanggal">
<input type="text" data-table="t10_jurnal" data-field="x_Tanggal" data-format="7" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Tanggal->EditValue ?>"<?php echo $t10_jurnal->Tanggal->EditAttributes() ?>>
<?php if (!$t10_jurnal->Tanggal->ReadOnly && !$t10_jurnal->Tanggal->Disabled && !isset($t10_jurnal->Tanggal->EditAttrs["readonly"]) && !isset($t10_jurnal->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft10_jurnallist", "x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Tanggal" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Tanggal" class="form-group t10_jurnal_Tanggal">
<input type="text" data-table="t10_jurnal" data-field="x_Tanggal" data-format="7" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Tanggal->EditValue ?>"<?php echo $t10_jurnal->Tanggal->EditAttributes() ?>>
<?php if (!$t10_jurnal->Tanggal->ReadOnly && !$t10_jurnal->Tanggal->Disabled && !isset($t10_jurnal->Tanggal->EditAttrs["readonly"]) && !isset($t10_jurnal->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft10_jurnallist", "x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Tanggal" class="t10_jurnal_Tanggal">
<span<?php echo $t10_jurnal->Tanggal->ViewAttributes() ?>>
<?php echo $t10_jurnal->Tanggal->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t10_jurnal_list->PageObjName . "_row_" . $t10_jurnal_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t10_jurnal" data-field="x_id" name="x<?php echo $t10_jurnal_list->RowIndex ?>_id" id="x<?php echo $t10_jurnal_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_jurnal->id->CurrentValue) ?>">
<input type="hidden" data-table="t10_jurnal" data-field="x_id" name="o<?php echo $t10_jurnal_list->RowIndex ?>_id" id="o<?php echo $t10_jurnal_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_jurnal->id->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT || $t10_jurnal->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t10_jurnal" data-field="x_id" name="x<?php echo $t10_jurnal_list->RowIndex ?>_id" id="x<?php echo $t10_jurnal_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t10_jurnal->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t10_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
		<td data-name="NomorTransaksi"<?php echo $t10_jurnal->NomorTransaksi->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_NomorTransaksi" class="form-group t10_jurnal_NomorTransaksi">
<?php
$wrkonchange = trim(" " . @$t10_jurnal->NomorTransaksi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t10_jurnal->NomorTransaksi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" style="white-space: nowrap; z-index: <?php echo (9000 - $t10_jurnal_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->EditValue ?>" size="10" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>"<?php echo $t10_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" data-value-separator="<?php echo $t10_jurnal->NomorTransaksi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft10_jurnallist.CreateAutoSuggest({"id":"x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" name="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_NomorTransaksi" class="form-group t10_jurnal_NomorTransaksi">
<?php
$wrkonchange = trim(" " . @$t10_jurnal->NomorTransaksi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t10_jurnal->NomorTransaksi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" style="white-space: nowrap; z-index: <?php echo (9000 - $t10_jurnal_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->EditValue ?>" size="10" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>"<?php echo $t10_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" data-value-separator="<?php echo $t10_jurnal->NomorTransaksi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft10_jurnallist.CreateAutoSuggest({"id":"x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi","forceSelect":false});
</script>
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_NomorTransaksi" class="t10_jurnal_NomorTransaksi">
<span<?php echo $t10_jurnal->NomorTransaksi->ViewAttributes() ?>>
<?php echo $t10_jurnal->NomorTransaksi->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan"<?php echo $t10_jurnal->Keterangan->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Keterangan" class="form-group t10_jurnal_Keterangan">
<input type="text" data-table="t10_jurnal" data-field="x_Keterangan" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Keterangan->EditValue ?>"<?php echo $t10_jurnal->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Keterangan" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Keterangan" class="form-group t10_jurnal_Keterangan">
<input type="text" data-table="t10_jurnal" data-field="x_Keterangan" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Keterangan->EditValue ?>"<?php echo $t10_jurnal->Keterangan->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Keterangan" class="t10_jurnal_Keterangan">
<span<?php echo $t10_jurnal->Keterangan->ViewAttributes() ?>>
<?php echo $t10_jurnal->Keterangan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Rekening->Visible) { // Rekening ?>
		<td data-name="Rekening"<?php echo $t10_jurnal->Rekening->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Rekening" class="form-group t10_jurnal_Rekening">
<select data-table="t10_jurnal" data-field="x_Rekening" data-value-separator="<?php echo $t10_jurnal->Rekening->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening"<?php echo $t10_jurnal->Rekening->EditAttributes() ?>>
<?php echo $t10_jurnal->Rekening->SelectOptionListHtml("x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening") ?>
</select>
<input type="hidden" name="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo $t10_jurnal->Rekening->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Rekening" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t10_jurnal->Rekening->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Rekening" class="form-group t10_jurnal_Rekening">
<select data-table="t10_jurnal" data-field="x_Rekening" data-value-separator="<?php echo $t10_jurnal->Rekening->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening"<?php echo $t10_jurnal->Rekening->EditAttributes() ?>>
<?php echo $t10_jurnal->Rekening->SelectOptionListHtml("x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening") ?>
</select>
<input type="hidden" name="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo $t10_jurnal->Rekening->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Rekening" class="t10_jurnal_Rekening">
<span<?php echo $t10_jurnal->Rekening->ViewAttributes() ?>>
<?php echo $t10_jurnal->Rekening->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Debet->Visible) { // Debet ?>
		<td data-name="Debet"<?php echo $t10_jurnal->Debet->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Debet" class="form-group t10_jurnal_Debet">
<input type="text" data-table="t10_jurnal" data-field="x_Debet" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Debet->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Debet->EditValue ?>"<?php echo $t10_jurnal->Debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Debet" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t10_jurnal->Debet->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Debet" class="form-group t10_jurnal_Debet">
<input type="text" data-table="t10_jurnal" data-field="x_Debet" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Debet->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Debet->EditValue ?>"<?php echo $t10_jurnal->Debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Debet" class="t10_jurnal_Debet">
<span<?php echo $t10_jurnal->Debet->ViewAttributes() ?>>
<?php echo $t10_jurnal->Debet->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Kredit->Visible) { // Kredit ?>
		<td data-name="Kredit"<?php echo $t10_jurnal->Kredit->CellAttributes() ?>>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Kredit" class="form-group t10_jurnal_Kredit">
<input type="text" data-table="t10_jurnal" data-field="x_Kredit" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Kredit->EditValue ?>"<?php echo $t10_jurnal->Kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Kredit" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->OldValue) ?>">
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Kredit" class="form-group t10_jurnal_Kredit">
<input type="text" data-table="t10_jurnal" data-field="x_Kredit" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Kredit->EditValue ?>"<?php echo $t10_jurnal->Kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t10_jurnal_list->RowCnt ?>_t10_jurnal_Kredit" class="t10_jurnal_Kredit">
<span<?php echo $t10_jurnal->Kredit->ViewAttributes() ?>>
<?php echo $t10_jurnal->Kredit->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_jurnal_list->ListOptions->Render("body", "right", $t10_jurnal_list->RowCnt);
?>
	</tr>
<?php if ($t10_jurnal->RowType == EW_ROWTYPE_ADD || $t10_jurnal->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft10_jurnallist.UpdateOpts(<?php echo $t10_jurnal_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t10_jurnal->CurrentAction <> "gridadd")
		if (!$t10_jurnal_list->Recordset->EOF) $t10_jurnal_list->Recordset->MoveNext();
}
?>
<?php
	if ($t10_jurnal->CurrentAction == "gridadd" || $t10_jurnal->CurrentAction == "gridedit") {
		$t10_jurnal_list->RowIndex = '$rowindex$';
		$t10_jurnal_list->LoadDefaultValues();

		// Set row properties
		$t10_jurnal->ResetAttrs();
		$t10_jurnal->RowAttrs = array_merge($t10_jurnal->RowAttrs, array('data-rowindex'=>$t10_jurnal_list->RowIndex, 'id'=>'r0_t10_jurnal', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t10_jurnal->RowAttrs["class"], "ewTemplate");
		$t10_jurnal->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t10_jurnal_list->RenderRow();

		// Render list options
		$t10_jurnal_list->RenderListOptions();
		$t10_jurnal_list->StartRowCnt = 0;
?>
	<tr<?php echo $t10_jurnal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t10_jurnal_list->ListOptions->Render("body", "left", $t10_jurnal_list->RowIndex);
?>
	<?php if ($t10_jurnal->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal">
<span id="el$rowindex$_t10_jurnal_Tanggal" class="form-group t10_jurnal_Tanggal">
<input type="text" data-table="t10_jurnal" data-field="x_Tanggal" data-format="7" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Tanggal->EditValue ?>"<?php echo $t10_jurnal->Tanggal->EditAttributes() ?>>
<?php if (!$t10_jurnal->Tanggal->ReadOnly && !$t10_jurnal->Tanggal->Disabled && !isset($t10_jurnal->Tanggal->EditAttrs["readonly"]) && !isset($t10_jurnal->Tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft10_jurnallist", "x<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Tanggal" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Tanggal" value="<?php echo ew_HtmlEncode($t10_jurnal->Tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->NomorTransaksi->Visible) { // NomorTransaksi ?>
		<td data-name="NomorTransaksi">
<span id="el$rowindex$_t10_jurnal_NomorTransaksi" class="form-group t10_jurnal_NomorTransaksi">
<?php
$wrkonchange = trim(" " . @$t10_jurnal->NomorTransaksi->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t10_jurnal->NomorTransaksi->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" style="white-space: nowrap; z-index: <?php echo (9000 - $t10_jurnal_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="sv_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->EditValue ?>" size="10" maxlength="25" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->getPlaceHolder()) ?>"<?php echo $t10_jurnal->NomorTransaksi->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" data-value-separator="<?php echo $t10_jurnal->NomorTransaksi->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="q_x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo $t10_jurnal->NomorTransaksi->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft10_jurnallist.CreateAutoSuggest({"id":"x<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi","forceSelect":false});
</script>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_NomorTransaksi" name="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" id="o<?php echo $t10_jurnal_list->RowIndex ?>_NomorTransaksi" value="<?php echo ew_HtmlEncode($t10_jurnal->NomorTransaksi->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Keterangan->Visible) { // Keterangan ?>
		<td data-name="Keterangan">
<span id="el$rowindex$_t10_jurnal_Keterangan" class="form-group t10_jurnal_Keterangan">
<input type="text" data-table="t10_jurnal" data-field="x_Keterangan" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Keterangan->EditValue ?>"<?php echo $t10_jurnal->Keterangan->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Keterangan" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Keterangan" value="<?php echo ew_HtmlEncode($t10_jurnal->Keterangan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Rekening->Visible) { // Rekening ?>
		<td data-name="Rekening">
<span id="el$rowindex$_t10_jurnal_Rekening" class="form-group t10_jurnal_Rekening">
<select data-table="t10_jurnal" data-field="x_Rekening" data-value-separator="<?php echo $t10_jurnal->Rekening->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening"<?php echo $t10_jurnal->Rekening->EditAttributes() ?>>
<?php echo $t10_jurnal->Rekening->SelectOptionListHtml("x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening") ?>
</select>
<input type="hidden" name="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="s_x<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo $t10_jurnal->Rekening->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Rekening" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t10_jurnal->Rekening->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Debet->Visible) { // Debet ?>
		<td data-name="Debet">
<span id="el$rowindex$_t10_jurnal_Debet" class="form-group t10_jurnal_Debet">
<input type="text" data-table="t10_jurnal" data-field="x_Debet" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Debet->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Debet->EditValue ?>"<?php echo $t10_jurnal->Debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Debet" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t10_jurnal->Debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t10_jurnal->Kredit->Visible) { // Kredit ?>
		<td data-name="Kredit">
<span id="el$rowindex$_t10_jurnal_Kredit" class="form-group t10_jurnal_Kredit">
<input type="text" data-table="t10_jurnal" data-field="x_Kredit" name="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="x<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->getPlaceHolder()) ?>" value="<?php echo $t10_jurnal->Kredit->EditValue ?>"<?php echo $t10_jurnal->Kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t10_jurnal" data-field="x_Kredit" name="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" id="o<?php echo $t10_jurnal_list->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t10_jurnal->Kredit->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t10_jurnal_list->ListOptions->Render("body", "right", $t10_jurnal_list->RowCnt);
?>
<script type="text/javascript">
ft10_jurnallist.UpdateOpts(<?php echo $t10_jurnal_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t10_jurnal->CurrentAction == "add" || $t10_jurnal->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t10_jurnal_list->FormKeyCountName ?>" id="<?php echo $t10_jurnal_list->FormKeyCountName ?>" value="<?php echo $t10_jurnal_list->KeyCount ?>">
<?php } ?>
<?php if ($t10_jurnal->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t10_jurnal_list->FormKeyCountName ?>" id="<?php echo $t10_jurnal_list->FormKeyCountName ?>" value="<?php echo $t10_jurnal_list->KeyCount ?>">
<?php echo $t10_jurnal_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t10_jurnal->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t10_jurnal_list->FormKeyCountName ?>" id="<?php echo $t10_jurnal_list->FormKeyCountName ?>" value="<?php echo $t10_jurnal_list->KeyCount ?>">
<?php } ?>
<?php if ($t10_jurnal->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t10_jurnal_list->FormKeyCountName ?>" id="<?php echo $t10_jurnal_list->FormKeyCountName ?>" value="<?php echo $t10_jurnal_list->KeyCount ?>">
<?php echo $t10_jurnal_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t10_jurnal->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t10_jurnal_list->Recordset)
	$t10_jurnal_list->Recordset->Close();
?>
<?php if ($t10_jurnal->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t10_jurnal->CurrentAction <> "gridadd" && $t10_jurnal->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t10_jurnal_list->Pager)) $t10_jurnal_list->Pager = new cPrevNextPager($t10_jurnal_list->StartRec, $t10_jurnal_list->DisplayRecs, $t10_jurnal_list->TotalRecs) ?>
<?php if ($t10_jurnal_list->Pager->RecordCount > 0 && $t10_jurnal_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t10_jurnal_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t10_jurnal_list->PageUrl() ?>start=<?php echo $t10_jurnal_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t10_jurnal_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t10_jurnal_list->PageUrl() ?>start=<?php echo $t10_jurnal_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t10_jurnal_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t10_jurnal_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t10_jurnal_list->PageUrl() ?>start=<?php echo $t10_jurnal_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t10_jurnal_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t10_jurnal_list->PageUrl() ?>start=<?php echo $t10_jurnal_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t10_jurnal_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t10_jurnal_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t10_jurnal_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t10_jurnal_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t10_jurnal_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t10_jurnal_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t10_jurnal">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="50"<?php if ($t10_jurnal_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t10_jurnal_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t10_jurnal->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t10_jurnal_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t10_jurnal_list->TotalRecs == 0 && $t10_jurnal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t10_jurnal_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t10_jurnal->Export == "") { ?>
<script type="text/javascript">
ft10_jurnallistsrch.FilterList = <?php echo $t10_jurnal_list->GetFilterList() ?>;
ft10_jurnallistsrch.Init();
ft10_jurnallist.Init();
</script>
<?php } ?>
<?php
$t10_jurnal_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t10_jurnal->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t10_jurnal_list->Page_Terminate();
?>
