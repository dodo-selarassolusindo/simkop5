<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t95_logdescinfo.php" ?>
<?php include_once "t94_loginfo.php" ?>
<?php include_once "t96_employeesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t95_logdesc_list = NULL; // Initialize page object first

class ct95_logdesc_list extends ct95_logdesc {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C5FF1E3B-3DAB-4591-8A48-EB66171DE031}";

	// Table name
	var $TableName = 't95_logdesc';

	// Page object name
	var $PageObjName = 't95_logdesc_list';

	// Grid form hidden field names
	var $FormName = 'ft95_logdesclist';
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

		// Table object (t95_logdesc)
		if (!isset($GLOBALS["t95_logdesc"]) || get_class($GLOBALS["t95_logdesc"]) == "ct95_logdesc") {
			$GLOBALS["t95_logdesc"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t95_logdesc"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t95_logdescadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t95_logdescdelete.php";
		$this->MultiUpdateUrl = "t95_logdescupdate.php";

		// Table object (t94_log)
		if (!isset($GLOBALS['t94_log'])) $GLOBALS['t94_log'] = new ct94_log();

		// Table object (t96_employees)
		if (!isset($GLOBALS['t96_employees'])) $GLOBALS['t96_employees'] = new ct96_employees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't95_logdesc', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft95_logdesclistsrch";

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
		$this->log_id->SetVisibility();
		$this->date_issued->SetVisibility();
		$this->desc_->SetVisibility();
		$this->date_solved->SetVisibility();

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
		global $EW_EXPORT, $t95_logdesc;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t95_logdesc);
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
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
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

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t94_log") {
			global $t94_log;
			$rsmaster = $t94_log->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("t94_loglist.php"); // Return to master page
			} else {
				$t94_log->LoadListRowValues($rsmaster);
				$t94_log->RowType = EW_ROWTYPE_MASTER; // Master row
				$t94_log->RenderListRow();
				$rsmaster->Close();
			}
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
		if ($objForm->HasValue("x_log_id") && $objForm->HasValue("o_log_id") && $this->log_id->CurrentValue <> $this->log_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_date_issued") && $objForm->HasValue("o_date_issued") && $this->date_issued->CurrentValue <> $this->date_issued->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_desc_") && $objForm->HasValue("o_desc_") && $this->desc_->CurrentValue <> $this->desc_->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_date_solved") && $objForm->HasValue("o_date_solved") && $this->date_solved->CurrentValue <> $this->date_solved->OldValue)
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft95_logdesclistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->log_id->AdvancedSearch->ToJSON(), ","); // Field log_id
		$sFilterList = ew_Concat($sFilterList, $this->date_issued->AdvancedSearch->ToJSON(), ","); // Field date_issued
		$sFilterList = ew_Concat($sFilterList, $this->desc_->AdvancedSearch->ToJSON(), ","); // Field desc_
		$sFilterList = ew_Concat($sFilterList, $this->date_solved->AdvancedSearch->ToJSON(), ","); // Field date_solved
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft95_logdesclistsrch", $filters);

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

		// Field log_id
		$this->log_id->AdvancedSearch->SearchValue = @$filter["x_log_id"];
		$this->log_id->AdvancedSearch->SearchOperator = @$filter["z_log_id"];
		$this->log_id->AdvancedSearch->SearchCondition = @$filter["v_log_id"];
		$this->log_id->AdvancedSearch->SearchValue2 = @$filter["y_log_id"];
		$this->log_id->AdvancedSearch->SearchOperator2 = @$filter["w_log_id"];
		$this->log_id->AdvancedSearch->Save();

		// Field date_issued
		$this->date_issued->AdvancedSearch->SearchValue = @$filter["x_date_issued"];
		$this->date_issued->AdvancedSearch->SearchOperator = @$filter["z_date_issued"];
		$this->date_issued->AdvancedSearch->SearchCondition = @$filter["v_date_issued"];
		$this->date_issued->AdvancedSearch->SearchValue2 = @$filter["y_date_issued"];
		$this->date_issued->AdvancedSearch->SearchOperator2 = @$filter["w_date_issued"];
		$this->date_issued->AdvancedSearch->Save();

		// Field desc_
		$this->desc_->AdvancedSearch->SearchValue = @$filter["x_desc_"];
		$this->desc_->AdvancedSearch->SearchOperator = @$filter["z_desc_"];
		$this->desc_->AdvancedSearch->SearchCondition = @$filter["v_desc_"];
		$this->desc_->AdvancedSearch->SearchValue2 = @$filter["y_desc_"];
		$this->desc_->AdvancedSearch->SearchOperator2 = @$filter["w_desc_"];
		$this->desc_->AdvancedSearch->Save();

		// Field date_solved
		$this->date_solved->AdvancedSearch->SearchValue = @$filter["x_date_solved"];
		$this->date_solved->AdvancedSearch->SearchOperator = @$filter["z_date_solved"];
		$this->date_solved->AdvancedSearch->SearchCondition = @$filter["v_date_solved"];
		$this->date_solved->AdvancedSearch->SearchValue2 = @$filter["y_date_solved"];
		$this->date_solved->AdvancedSearch->SearchOperator2 = @$filter["w_date_solved"];
		$this->date_solved->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->desc_, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->log_id, $bCtrl); // log_id
			$this->UpdateSort($this->date_issued, $bCtrl); // date_issued
			$this->UpdateSort($this->desc_, $bCtrl); // desc_
			$this->UpdateSort($this->date_solved, $bCtrl); // date_solved
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->log_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->log_id->setSort("");
				$this->date_issued->setSort("");
				$this->desc_->setSort("");
				$this->date_solved->setSort("");
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
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft95_logdesclistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft95_logdesclistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft95_logdesclist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft95_logdesclistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
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
		$this->log_id->CurrentValue = NULL;
		$this->log_id->OldValue = $this->log_id->CurrentValue;
		$this->date_issued->CurrentValue = NULL;
		$this->date_issued->OldValue = $this->date_issued->CurrentValue;
		$this->desc_->CurrentValue = NULL;
		$this->desc_->OldValue = $this->desc_->CurrentValue;
		$this->date_solved->CurrentValue = NULL;
		$this->date_solved->OldValue = $this->date_solved->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->log_id->FldIsDetailKey) {
			$this->log_id->setFormValue($objForm->GetValue("x_log_id"));
		}
		$this->log_id->setOldValue($objForm->GetValue("o_log_id"));
		if (!$this->date_issued->FldIsDetailKey) {
			$this->date_issued->setFormValue($objForm->GetValue("x_date_issued"));
			$this->date_issued->CurrentValue = ew_UnFormatDateTime($this->date_issued->CurrentValue, 0);
		}
		$this->date_issued->setOldValue($objForm->GetValue("o_date_issued"));
		if (!$this->desc_->FldIsDetailKey) {
			$this->desc_->setFormValue($objForm->GetValue("x_desc_"));
		}
		$this->desc_->setOldValue($objForm->GetValue("o_desc_"));
		if (!$this->date_solved->FldIsDetailKey) {
			$this->date_solved->setFormValue($objForm->GetValue("x_date_solved"));
			$this->date_solved->CurrentValue = ew_UnFormatDateTime($this->date_solved->CurrentValue, 0);
		}
		$this->date_solved->setOldValue($objForm->GetValue("o_date_solved"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->log_id->CurrentValue = $this->log_id->FormValue;
		$this->date_issued->CurrentValue = $this->date_issued->FormValue;
		$this->date_issued->CurrentValue = ew_UnFormatDateTime($this->date_issued->CurrentValue, 0);
		$this->desc_->CurrentValue = $this->desc_->FormValue;
		$this->date_solved->CurrentValue = $this->date_solved->FormValue;
		$this->date_solved->CurrentValue = ew_UnFormatDateTime($this->date_solved->CurrentValue, 0);
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
		$this->log_id->setDbValue($rs->fields('log_id'));
		$this->date_issued->setDbValue($rs->fields('date_issued'));
		$this->desc_->setDbValue($rs->fields('desc_'));
		$this->date_solved->setDbValue($rs->fields('date_solved'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->log_id->DbValue = $row['log_id'];
		$this->date_issued->DbValue = $row['date_issued'];
		$this->desc_->DbValue = $row['desc_'];
		$this->date_solved->DbValue = $row['date_solved'];
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// log_id
		// date_issued
		// desc_
		// date_solved

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// log_id
		$this->log_id->ViewValue = $this->log_id->CurrentValue;
		if (strval($this->log_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
		$sWhereWrk = "";
		$this->log_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->log_id->ViewValue = $this->log_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->log_id->ViewValue = $this->log_id->CurrentValue;
			}
		} else {
			$this->log_id->ViewValue = NULL;
		}
		$this->log_id->ViewCustomAttributes = "";

		// date_issued
		$this->date_issued->ViewValue = $this->date_issued->CurrentValue;
		$this->date_issued->ViewValue = ew_FormatDateTime($this->date_issued->ViewValue, 0);
		$this->date_issued->ViewCustomAttributes = "";

		// desc_
		$this->desc_->ViewValue = $this->desc_->CurrentValue;
		$this->desc_->ViewCustomAttributes = "";

		// date_solved
		$this->date_solved->ViewValue = $this->date_solved->CurrentValue;
		$this->date_solved->ViewValue = ew_FormatDateTime($this->date_solved->ViewValue, 0);
		$this->date_solved->ViewCustomAttributes = "";

			// log_id
			$this->log_id->LinkCustomAttributes = "";
			$this->log_id->HrefValue = "";
			$this->log_id->TooltipValue = "";

			// date_issued
			$this->date_issued->LinkCustomAttributes = "";
			$this->date_issued->HrefValue = "";
			$this->date_issued->TooltipValue = "";

			// desc_
			$this->desc_->LinkCustomAttributes = "";
			$this->desc_->HrefValue = "";
			$this->desc_->TooltipValue = "";

			// date_solved
			$this->date_solved->LinkCustomAttributes = "";
			$this->date_solved->HrefValue = "";
			$this->date_solved->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// log_id
			$this->log_id->EditAttrs["class"] = "form-control";
			$this->log_id->EditCustomAttributes = "";
			if ($this->log_id->getSessionValue() <> "") {
				$this->log_id->CurrentValue = $this->log_id->getSessionValue();
				$this->log_id->OldValue = $this->log_id->CurrentValue;
			$this->log_id->ViewValue = $this->log_id->CurrentValue;
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->log_id->ViewValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->ViewValue = $this->log_id->CurrentValue;
				}
			} else {
				$this->log_id->ViewValue = NULL;
			}
			$this->log_id->ViewCustomAttributes = "";
			} else {
			$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->log_id->EditValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
				}
			} else {
				$this->log_id->EditValue = NULL;
			}
			$this->log_id->PlaceHolder = ew_RemoveHtml($this->log_id->FldCaption());
			}

			// date_issued
			$this->date_issued->EditAttrs["class"] = "form-control";
			$this->date_issued->EditCustomAttributes = "";
			$this->date_issued->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_issued->CurrentValue, 8));
			$this->date_issued->PlaceHolder = ew_RemoveHtml($this->date_issued->FldCaption());

			// desc_
			$this->desc_->EditAttrs["class"] = "form-control";
			$this->desc_->EditCustomAttributes = "";
			$this->desc_->EditValue = ew_HtmlEncode($this->desc_->CurrentValue);
			$this->desc_->PlaceHolder = ew_RemoveHtml($this->desc_->FldCaption());

			// date_solved
			$this->date_solved->EditAttrs["class"] = "form-control";
			$this->date_solved->EditCustomAttributes = "";
			$this->date_solved->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_solved->CurrentValue, 8));
			$this->date_solved->PlaceHolder = ew_RemoveHtml($this->date_solved->FldCaption());

			// Add refer script
			// log_id

			$this->log_id->LinkCustomAttributes = "";
			$this->log_id->HrefValue = "";

			// date_issued
			$this->date_issued->LinkCustomAttributes = "";
			$this->date_issued->HrefValue = "";

			// desc_
			$this->desc_->LinkCustomAttributes = "";
			$this->desc_->HrefValue = "";

			// date_solved
			$this->date_solved->LinkCustomAttributes = "";
			$this->date_solved->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// log_id
			$this->log_id->EditAttrs["class"] = "form-control";
			$this->log_id->EditCustomAttributes = "";
			if ($this->log_id->getSessionValue() <> "") {
				$this->log_id->CurrentValue = $this->log_id->getSessionValue();
				$this->log_id->OldValue = $this->log_id->CurrentValue;
			$this->log_id->ViewValue = $this->log_id->CurrentValue;
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->log_id->ViewValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->ViewValue = $this->log_id->CurrentValue;
				}
			} else {
				$this->log_id->ViewValue = NULL;
			}
			$this->log_id->ViewCustomAttributes = "";
			} else {
			$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
			if (strval($this->log_id->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->log_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "";
			$this->log_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->log_id->EditValue = $this->log_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->log_id->EditValue = ew_HtmlEncode($this->log_id->CurrentValue);
				}
			} else {
				$this->log_id->EditValue = NULL;
			}
			$this->log_id->PlaceHolder = ew_RemoveHtml($this->log_id->FldCaption());
			}

			// date_issued
			$this->date_issued->EditAttrs["class"] = "form-control";
			$this->date_issued->EditCustomAttributes = "";
			$this->date_issued->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_issued->CurrentValue, 8));
			$this->date_issued->PlaceHolder = ew_RemoveHtml($this->date_issued->FldCaption());

			// desc_
			$this->desc_->EditAttrs["class"] = "form-control";
			$this->desc_->EditCustomAttributes = "";
			$this->desc_->EditValue = ew_HtmlEncode($this->desc_->CurrentValue);
			$this->desc_->PlaceHolder = ew_RemoveHtml($this->desc_->FldCaption());

			// date_solved
			$this->date_solved->EditAttrs["class"] = "form-control";
			$this->date_solved->EditCustomAttributes = "";
			$this->date_solved->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date_solved->CurrentValue, 8));
			$this->date_solved->PlaceHolder = ew_RemoveHtml($this->date_solved->FldCaption());

			// Edit refer script
			// log_id

			$this->log_id->LinkCustomAttributes = "";
			$this->log_id->HrefValue = "";

			// date_issued
			$this->date_issued->LinkCustomAttributes = "";
			$this->date_issued->HrefValue = "";

			// desc_
			$this->desc_->LinkCustomAttributes = "";
			$this->desc_->HrefValue = "";

			// date_solved
			$this->date_solved->LinkCustomAttributes = "";
			$this->date_solved->HrefValue = "";
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
		if (!$this->log_id->FldIsDetailKey && !is_null($this->log_id->FormValue) && $this->log_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->log_id->FldCaption(), $this->log_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->log_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->log_id->FldErrMsg());
		}
		if (!$this->date_issued->FldIsDetailKey && !is_null($this->date_issued->FormValue) && $this->date_issued->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->date_issued->FldCaption(), $this->date_issued->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->date_issued->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_issued->FldErrMsg());
		}
		if (!$this->desc_->FldIsDetailKey && !is_null($this->desc_->FormValue) && $this->desc_->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->desc_->FldCaption(), $this->desc_->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->date_solved->FormValue)) {
			ew_AddMessage($gsFormError, $this->date_solved->FldErrMsg());
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

			// log_id
			$this->log_id->SetDbValueDef($rsnew, $this->log_id->CurrentValue, 0, $this->log_id->ReadOnly);

			// date_issued
			$this->date_issued->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_issued->CurrentValue, 0), ew_CurrentDate(), $this->date_issued->ReadOnly);

			// desc_
			$this->desc_->SetDbValueDef($rsnew, $this->desc_->CurrentValue, "", $this->desc_->ReadOnly);

			// date_solved
			$this->date_solved->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_solved->CurrentValue, 0), NULL, $this->date_solved->ReadOnly);

			// Check referential integrity for master table 't94_log'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_t94_log();
			$KeyValue = isset($rsnew['log_id']) ? $rsnew['log_id'] : $rsold['log_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["t94_log"])) $GLOBALS["t94_log"] = new ct94_log();
				$rsmaster = $GLOBALS["t94_log"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "t94_log", $Language->Phrase("RelatedRecordRequired"));
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

		// Check referential integrity for master table 't94_log'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_t94_log();
		if (strval($this->log_id->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->log_id->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["t94_log"])) $GLOBALS["t94_log"] = new ct94_log();
			$rsmaster = $GLOBALS["t94_log"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "t94_log", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// log_id
		$this->log_id->SetDbValueDef($rsnew, $this->log_id->CurrentValue, 0, FALSE);

		// date_issued
		$this->date_issued->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_issued->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// desc_
		$this->desc_->SetDbValueDef($rsnew, $this->desc_->CurrentValue, "", FALSE);

		// date_solved
		$this->date_solved->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date_solved->CurrentValue, 0), NULL, FALSE);

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
		$item->Body = "<button id=\"emf_t95_logdesc\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_t95_logdesc',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ft95_logdesclist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "t94_log") {
			global $t94_log;
			if (!isset($t94_log)) $t94_log = new ct94_log;
			$rsmaster = $t94_log->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$t94_log;
					$t94_log->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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
			if ($sMasterTblVar == "t94_log") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t94_log"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->log_id->setQueryStringValue($GLOBALS["t94_log"]->id->QueryStringValue);
					$this->log_id->setSessionValue($this->log_id->QueryStringValue);
					if (!is_numeric($GLOBALS["t94_log"]->id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t94_log") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t94_log"]->id->setFormValue($_POST["fk_id"]);
					$this->log_id->setFormValue($GLOBALS["t94_log"]->id->FormValue);
					$this->log_id->setSessionValue($this->log_id->FormValue);
					if (!is_numeric($GLOBALS["t94_log"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t94_log") {
				if ($this->log_id->CurrentValue == "") $this->log_id->setSessionValue("");
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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_log_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `subj_` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t94_log`";
			$sWhereWrk = "{filter}";
			$this->log_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
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
		case "x_log_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `subj_` AS `DispFld` FROM `t94_log`";
			$sWhereWrk = "`subj_` LIKE '{query_value}%'";
			$this->log_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->log_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t95_logdesc_list)) $t95_logdesc_list = new ct95_logdesc_list();

// Page init
$t95_logdesc_list->Page_Init();

// Page main
$t95_logdesc_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t95_logdesc_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($t95_logdesc->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft95_logdesclist = new ew_Form("ft95_logdesclist", "list");
ft95_logdesclist.FormKeyCountName = '<?php echo $t95_logdesc_list->FormKeyCountName ?>';

// Validate form
ft95_logdesclist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->log_id->FldCaption(), $t95_logdesc->log_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_log_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->log_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_date_issued");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->date_issued->FldCaption(), $t95_logdesc->date_issued->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_issued");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->date_issued->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_desc_");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t95_logdesc->desc_->FldCaption(), $t95_logdesc->desc_->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_date_solved");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t95_logdesc->date_solved->FldErrMsg()) ?>");

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
ft95_logdesclist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "log_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_issued", false)) return false;
	if (ew_ValueChanged(fobj, infix, "desc_", false)) return false;
	if (ew_ValueChanged(fobj, infix, "date_solved", false)) return false;
	return true;
}

// Form_CustomValidate event
ft95_logdesclist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft95_logdesclist.ValidateRequired = true;
<?php } else { ?>
ft95_logdesclist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft95_logdesclist.Lists["x_log_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subj_","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t94_log"};

// Form object for search
var CurrentSearchForm = ft95_logdesclistsrch = new ew_Form("ft95_logdesclistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($t95_logdesc->Export == "") { ?>
<div class="ewToolbar">
<?php if ($t95_logdesc->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($t95_logdesc_list->TotalRecs > 0 && $t95_logdesc_list->ExportOptions->Visible()) { ?>
<?php $t95_logdesc_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t95_logdesc_list->SearchOptions->Visible()) { ?>
<?php $t95_logdesc_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t95_logdesc_list->FilterOptions->Visible()) { ?>
<?php $t95_logdesc_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($t95_logdesc->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($t95_logdesc->Export == "") || (EW_EXPORT_MASTER_RECORD && $t95_logdesc->Export == "print")) { ?>
<?php
if ($t95_logdesc_list->DbMasterFilter <> "" && $t95_logdesc->getCurrentMasterTable() == "t94_log") {
	if ($t95_logdesc_list->MasterRecordExists) {
?>
<?php include_once "t94_logmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($t95_logdesc->CurrentAction == "gridadd") {
	$t95_logdesc->CurrentFilter = "0=1";
	$t95_logdesc_list->StartRec = 1;
	$t95_logdesc_list->DisplayRecs = $t95_logdesc->GridAddRowCount;
	$t95_logdesc_list->TotalRecs = $t95_logdesc_list->DisplayRecs;
	$t95_logdesc_list->StopRec = $t95_logdesc_list->DisplayRecs;
} else {
	$bSelectLimit = $t95_logdesc_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t95_logdesc_list->TotalRecs <= 0)
			$t95_logdesc_list->TotalRecs = $t95_logdesc->SelectRecordCount();
	} else {
		if (!$t95_logdesc_list->Recordset && ($t95_logdesc_list->Recordset = $t95_logdesc_list->LoadRecordset()))
			$t95_logdesc_list->TotalRecs = $t95_logdesc_list->Recordset->RecordCount();
	}
	$t95_logdesc_list->StartRec = 1;
	if ($t95_logdesc_list->DisplayRecs <= 0 || ($t95_logdesc->Export <> "" && $t95_logdesc->ExportAll)) // Display all records
		$t95_logdesc_list->DisplayRecs = $t95_logdesc_list->TotalRecs;
	if (!($t95_logdesc->Export <> "" && $t95_logdesc->ExportAll))
		$t95_logdesc_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t95_logdesc_list->Recordset = $t95_logdesc_list->LoadRecordset($t95_logdesc_list->StartRec-1, $t95_logdesc_list->DisplayRecs);

	// Set no record found message
	if ($t95_logdesc->CurrentAction == "" && $t95_logdesc_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t95_logdesc_list->setWarningMessage(ew_DeniedMsg());
		if ($t95_logdesc_list->SearchWhere == "0=101")
			$t95_logdesc_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t95_logdesc_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t95_logdesc_list->AuditTrailOnSearch && $t95_logdesc_list->Command == "search" && !$t95_logdesc_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t95_logdesc_list->getSessionWhere();
		$t95_logdesc_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$t95_logdesc_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t95_logdesc->Export == "" && $t95_logdesc->CurrentAction == "") { ?>
<form name="ft95_logdesclistsrch" id="ft95_logdesclistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t95_logdesc_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft95_logdesclistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t95_logdesc">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t95_logdesc_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t95_logdesc_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t95_logdesc_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t95_logdesc_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t95_logdesc_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t95_logdesc_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t95_logdesc_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $t95_logdesc_list->ShowPageHeader(); ?>
<?php
$t95_logdesc_list->ShowMessage();
?>
<?php if ($t95_logdesc_list->TotalRecs > 0 || $t95_logdesc->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t95_logdesc">
<form name="ft95_logdesclist" id="ft95_logdesclist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t95_logdesc_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t95_logdesc_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t95_logdesc">
<?php if ($t95_logdesc->getCurrentMasterTable() == "t94_log" && $t95_logdesc->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t94_log">
<input type="hidden" name="fk_id" value="<?php echo $t95_logdesc->log_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_t95_logdesc" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($t95_logdesc_list->TotalRecs > 0 || $t95_logdesc->CurrentAction == "add" || $t95_logdesc->CurrentAction == "copy" || $t95_logdesc->CurrentAction == "gridedit") { ?>
<table id="tbl_t95_logdesclist" class="table ewTable">
<?php echo $t95_logdesc->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t95_logdesc_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t95_logdesc_list->RenderListOptions();

// Render list options (header, left)
$t95_logdesc_list->ListOptions->Render("header", "left");
?>
<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->log_id) == "") { ?>
		<th data-name="log_id"><div id="elh_t95_logdesc_log_id" class="t95_logdesc_log_id"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->log_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="log_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t95_logdesc->SortUrl($t95_logdesc->log_id) ?>',2);"><div id="elh_t95_logdesc_log_id" class="t95_logdesc_log_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->log_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->log_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->log_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->date_issued) == "") { ?>
		<th data-name="date_issued"><div id="elh_t95_logdesc_date_issued" class="t95_logdesc_date_issued"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_issued->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date_issued"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t95_logdesc->SortUrl($t95_logdesc->date_issued) ?>',2);"><div id="elh_t95_logdesc_date_issued" class="t95_logdesc_date_issued">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_issued->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->date_issued->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->date_issued->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->desc_->Visible) { // desc_ ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->desc_) == "") { ?>
		<th data-name="desc_"><div id="elh_t95_logdesc_desc_" class="t95_logdesc_desc_"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->desc_->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="desc_"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t95_logdesc->SortUrl($t95_logdesc->desc_) ?>',2);"><div id="elh_t95_logdesc_desc_" class="t95_logdesc_desc_">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->desc_->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->desc_->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->desc_->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
	<?php if ($t95_logdesc->SortUrl($t95_logdesc->date_solved) == "") { ?>
		<th data-name="date_solved"><div id="elh_t95_logdesc_date_solved" class="t95_logdesc_date_solved"><div class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_solved->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="date_solved"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t95_logdesc->SortUrl($t95_logdesc->date_solved) ?>',2);"><div id="elh_t95_logdesc_date_solved" class="t95_logdesc_date_solved">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t95_logdesc->date_solved->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t95_logdesc->date_solved->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t95_logdesc->date_solved->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t95_logdesc_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($t95_logdesc->CurrentAction == "add" || $t95_logdesc->CurrentAction == "copy") {
		$t95_logdesc_list->RowIndex = 0;
		$t95_logdesc_list->KeyCount = $t95_logdesc_list->RowIndex;
		if ($t95_logdesc->CurrentAction == "copy" && !$t95_logdesc_list->LoadRow())
				$t95_logdesc->CurrentAction = "add";
		if ($t95_logdesc->CurrentAction == "add")
			$t95_logdesc_list->LoadDefaultValues();
		if ($t95_logdesc->EventCancelled) // Insert failed
			$t95_logdesc_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$t95_logdesc->ResetAttrs();
		$t95_logdesc->RowAttrs = array_merge($t95_logdesc->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_t95_logdesc', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$t95_logdesc->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t95_logdesc_list->RenderRow();

		// Render list options
		$t95_logdesc_list->RenderListOptions();
		$t95_logdesc_list->StartRowCnt = 0;
?>
	<tr<?php echo $t95_logdesc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t95_logdesc_list->ListOptions->Render("body", "left", $t95_logdesc_list->RowCnt);
?>
	<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
		<td data-name="log_id">
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<?php
$wrkonchange = trim(" " . @$t95_logdesc->log_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t95_logdesc->log_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t95_logdesc_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" data-value-separator="<?php echo $t95_logdesc->log_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft95_logdesclist.CreateAutoSuggest({"id":"x<?php echo $t95_logdesc_list->RowIndex ?>_log_id","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
		<td data-name="date_issued">
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_issued->ReadOnly && !$t95_logdesc->date_issued->Disabled && !isset($t95_logdesc->date_issued->EditAttrs["readonly"]) && !isset($t95_logdesc->date_issued->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->desc_->Visible) { // desc_ ?>
		<td data-name="desc_">
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_desc_" class="form-group t95_logdesc_desc_">
<textarea data-table="t95_logdesc" data-field="x_desc_" name="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->desc_->getPlaceHolder()) ?>"<?php echo $t95_logdesc->desc_->EditAttributes() ?>><?php echo $t95_logdesc->desc_->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_desc_" name="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" value="<?php echo ew_HtmlEncode($t95_logdesc->desc_->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
		<td data-name="date_solved">
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_solved->ReadOnly && !$t95_logdesc->date_solved->Disabled && !isset($t95_logdesc->date_solved->EditAttrs["readonly"]) && !isset($t95_logdesc->date_solved->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t95_logdesc_list->ListOptions->Render("body", "right", $t95_logdesc_list->RowCnt);
?>
<script type="text/javascript">
ft95_logdesclist.UpdateOpts(<?php echo $t95_logdesc_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($t95_logdesc->ExportAll && $t95_logdesc->Export <> "") {
	$t95_logdesc_list->StopRec = $t95_logdesc_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t95_logdesc_list->TotalRecs > $t95_logdesc_list->StartRec + $t95_logdesc_list->DisplayRecs - 1)
		$t95_logdesc_list->StopRec = $t95_logdesc_list->StartRec + $t95_logdesc_list->DisplayRecs - 1;
	else
		$t95_logdesc_list->StopRec = $t95_logdesc_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t95_logdesc_list->FormKeyCountName) && ($t95_logdesc->CurrentAction == "gridadd" || $t95_logdesc->CurrentAction == "gridedit" || $t95_logdesc->CurrentAction == "F")) {
		$t95_logdesc_list->KeyCount = $objForm->GetValue($t95_logdesc_list->FormKeyCountName);
		$t95_logdesc_list->StopRec = $t95_logdesc_list->StartRec + $t95_logdesc_list->KeyCount - 1;
	}
}
$t95_logdesc_list->RecCnt = $t95_logdesc_list->StartRec - 1;
if ($t95_logdesc_list->Recordset && !$t95_logdesc_list->Recordset->EOF) {
	$t95_logdesc_list->Recordset->MoveFirst();
	$bSelectLimit = $t95_logdesc_list->UseSelectLimit;
	if (!$bSelectLimit && $t95_logdesc_list->StartRec > 1)
		$t95_logdesc_list->Recordset->Move($t95_logdesc_list->StartRec - 1);
} elseif (!$t95_logdesc->AllowAddDeleteRow && $t95_logdesc_list->StopRec == 0) {
	$t95_logdesc_list->StopRec = $t95_logdesc->GridAddRowCount;
}

// Initialize aggregate
$t95_logdesc->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t95_logdesc->ResetAttrs();
$t95_logdesc_list->RenderRow();
$t95_logdesc_list->EditRowCnt = 0;
if ($t95_logdesc->CurrentAction == "edit")
	$t95_logdesc_list->RowIndex = 1;
if ($t95_logdesc->CurrentAction == "gridadd")
	$t95_logdesc_list->RowIndex = 0;
if ($t95_logdesc->CurrentAction == "gridedit")
	$t95_logdesc_list->RowIndex = 0;
while ($t95_logdesc_list->RecCnt < $t95_logdesc_list->StopRec) {
	$t95_logdesc_list->RecCnt++;
	if (intval($t95_logdesc_list->RecCnt) >= intval($t95_logdesc_list->StartRec)) {
		$t95_logdesc_list->RowCnt++;
		if ($t95_logdesc->CurrentAction == "gridadd" || $t95_logdesc->CurrentAction == "gridedit" || $t95_logdesc->CurrentAction == "F") {
			$t95_logdesc_list->RowIndex++;
			$objForm->Index = $t95_logdesc_list->RowIndex;
			if ($objForm->HasValue($t95_logdesc_list->FormActionName))
				$t95_logdesc_list->RowAction = strval($objForm->GetValue($t95_logdesc_list->FormActionName));
			elseif ($t95_logdesc->CurrentAction == "gridadd")
				$t95_logdesc_list->RowAction = "insert";
			else
				$t95_logdesc_list->RowAction = "";
		}

		// Set up key count
		$t95_logdesc_list->KeyCount = $t95_logdesc_list->RowIndex;

		// Init row class and style
		$t95_logdesc->ResetAttrs();
		$t95_logdesc->CssClass = "";
		if ($t95_logdesc->CurrentAction == "gridadd") {
			$t95_logdesc_list->LoadDefaultValues(); // Load default values
		} else {
			$t95_logdesc_list->LoadRowValues($t95_logdesc_list->Recordset); // Load row values
		}
		$t95_logdesc->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t95_logdesc->CurrentAction == "gridadd") // Grid add
			$t95_logdesc->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t95_logdesc->CurrentAction == "gridadd" && $t95_logdesc->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t95_logdesc_list->RestoreCurrentRowFormValues($t95_logdesc_list->RowIndex); // Restore form values
		if ($t95_logdesc->CurrentAction == "edit") {
			if ($t95_logdesc_list->CheckInlineEditKey() && $t95_logdesc_list->EditRowCnt == 0) { // Inline edit
				$t95_logdesc->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($t95_logdesc->CurrentAction == "gridedit") { // Grid edit
			if ($t95_logdesc->EventCancelled) {
				$t95_logdesc_list->RestoreCurrentRowFormValues($t95_logdesc_list->RowIndex); // Restore form values
			}
			if ($t95_logdesc_list->RowAction == "insert")
				$t95_logdesc->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t95_logdesc->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t95_logdesc->CurrentAction == "edit" && $t95_logdesc->RowType == EW_ROWTYPE_EDIT && $t95_logdesc->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$t95_logdesc_list->RestoreFormValues(); // Restore form values
		}
		if ($t95_logdesc->CurrentAction == "gridedit" && ($t95_logdesc->RowType == EW_ROWTYPE_EDIT || $t95_logdesc->RowType == EW_ROWTYPE_ADD) && $t95_logdesc->EventCancelled) // Update failed
			$t95_logdesc_list->RestoreCurrentRowFormValues($t95_logdesc_list->RowIndex); // Restore form values
		if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t95_logdesc_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$t95_logdesc->RowAttrs = array_merge($t95_logdesc->RowAttrs, array('data-rowindex'=>$t95_logdesc_list->RowCnt, 'id'=>'r' . $t95_logdesc_list->RowCnt . '_t95_logdesc', 'data-rowtype'=>$t95_logdesc->RowType));

		// Render row
		$t95_logdesc_list->RenderRow();

		// Render list options
		$t95_logdesc_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t95_logdesc_list->RowAction <> "delete" && $t95_logdesc_list->RowAction <> "insertdelete" && !($t95_logdesc_list->RowAction == "insert" && $t95_logdesc->CurrentAction == "F" && $t95_logdesc_list->EmptyRow())) {
?>
	<tr<?php echo $t95_logdesc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t95_logdesc_list->ListOptions->Render("body", "left", $t95_logdesc_list->RowCnt);
?>
	<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
		<td data-name="log_id"<?php echo $t95_logdesc->log_id->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<?php
$wrkonchange = trim(" " . @$t95_logdesc->log_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t95_logdesc->log_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t95_logdesc_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" data-value-separator="<?php echo $t95_logdesc->log_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft95_logdesclist.CreateAutoSuggest({"id":"x<?php echo $t95_logdesc_list->RowIndex ?>_log_id","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<?php
$wrkonchange = trim(" " . @$t95_logdesc->log_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t95_logdesc->log_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t95_logdesc_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" data-value-separator="<?php echo $t95_logdesc->log_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft95_logdesclist.CreateAutoSuggest({"id":"x<?php echo $t95_logdesc_list->RowIndex ?>_log_id","forceSelect":false});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_log_id" class="t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<?php echo $t95_logdesc->log_id->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $t95_logdesc_list->PageObjName . "_row_" . $t95_logdesc_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->CurrentValue) ?>">
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="o<?php echo $t95_logdesc_list->RowIndex ?>_id" id="o<?php echo $t95_logdesc_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT || $t95_logdesc->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t95_logdesc->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
		<td data-name="date_issued"<?php echo $t95_logdesc->date_issued->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_issued->ReadOnly && !$t95_logdesc->date_issued->Disabled && !isset($t95_logdesc->date_issued->EditAttrs["readonly"]) && !isset($t95_logdesc->date_issued->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_issued->ReadOnly && !$t95_logdesc->date_issued->Disabled && !isset($t95_logdesc->date_issued->EditAttrs["readonly"]) && !isset($t95_logdesc->date_issued->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued", 0);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_issued" class="t95_logdesc_date_issued">
<span<?php echo $t95_logdesc->date_issued->ViewAttributes() ?>>
<?php echo $t95_logdesc->date_issued->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t95_logdesc->desc_->Visible) { // desc_ ?>
		<td data-name="desc_"<?php echo $t95_logdesc->desc_->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_desc_" class="form-group t95_logdesc_desc_">
<textarea data-table="t95_logdesc" data-field="x_desc_" name="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->desc_->getPlaceHolder()) ?>"<?php echo $t95_logdesc->desc_->EditAttributes() ?>><?php echo $t95_logdesc->desc_->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_desc_" name="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" value="<?php echo ew_HtmlEncode($t95_logdesc->desc_->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_desc_" class="form-group t95_logdesc_desc_">
<textarea data-table="t95_logdesc" data-field="x_desc_" name="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->desc_->getPlaceHolder()) ?>"<?php echo $t95_logdesc->desc_->EditAttributes() ?>><?php echo $t95_logdesc->desc_->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_desc_" class="t95_logdesc_desc_">
<span<?php echo $t95_logdesc->desc_->ViewAttributes() ?>>
<?php echo $t95_logdesc->desc_->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
		<td data-name="date_solved"<?php echo $t95_logdesc->date_solved->CellAttributes() ?>>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_solved->ReadOnly && !$t95_logdesc->date_solved->Disabled && !isset($t95_logdesc->date_solved->EditAttrs["readonly"]) && !isset($t95_logdesc->date_solved->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_solved->ReadOnly && !$t95_logdesc->date_solved->Disabled && !isset($t95_logdesc->date_solved->EditAttrs["readonly"]) && !isset($t95_logdesc->date_solved->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved", 0);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t95_logdesc_list->RowCnt ?>_t95_logdesc_date_solved" class="t95_logdesc_date_solved">
<span<?php echo $t95_logdesc->date_solved->ViewAttributes() ?>>
<?php echo $t95_logdesc->date_solved->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t95_logdesc_list->ListOptions->Render("body", "right", $t95_logdesc_list->RowCnt);
?>
	</tr>
<?php if ($t95_logdesc->RowType == EW_ROWTYPE_ADD || $t95_logdesc->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft95_logdesclist.UpdateOpts(<?php echo $t95_logdesc_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t95_logdesc->CurrentAction <> "gridadd")
		if (!$t95_logdesc_list->Recordset->EOF) $t95_logdesc_list->Recordset->MoveNext();
}
?>
<?php
	if ($t95_logdesc->CurrentAction == "gridadd" || $t95_logdesc->CurrentAction == "gridedit") {
		$t95_logdesc_list->RowIndex = '$rowindex$';
		$t95_logdesc_list->LoadDefaultValues();

		// Set row properties
		$t95_logdesc->ResetAttrs();
		$t95_logdesc->RowAttrs = array_merge($t95_logdesc->RowAttrs, array('data-rowindex'=>$t95_logdesc_list->RowIndex, 'id'=>'r0_t95_logdesc', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t95_logdesc->RowAttrs["class"], "ewTemplate");
		$t95_logdesc->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t95_logdesc_list->RenderRow();

		// Render list options
		$t95_logdesc_list->RenderListOptions();
		$t95_logdesc_list->StartRowCnt = 0;
?>
	<tr<?php echo $t95_logdesc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t95_logdesc_list->ListOptions->Render("body", "left", $t95_logdesc_list->RowIndex);
?>
	<?php if ($t95_logdesc->log_id->Visible) { // log_id ?>
		<td data-name="log_id">
<?php if ($t95_logdesc->log_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<span<?php echo $t95_logdesc->log_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t95_logdesc->log_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_t95_logdesc_log_id" class="form-group t95_logdesc_log_id">
<?php
$wrkonchange = trim(" " . @$t95_logdesc->log_id->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t95_logdesc->log_id->EditAttrs["onchange"] = "";
?>
<span id="as_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" style="white-space: nowrap; z-index: <?php echo (9000 - $t95_logdesc_list->RowCnt * 10) ?>">
	<input type="text" name="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="sv_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t95_logdesc->log_id->getPlaceHolder()) ?>"<?php echo $t95_logdesc->log_id->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" data-value-separator="<?php echo $t95_logdesc->log_id->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="q_x<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo $t95_logdesc->log_id->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft95_logdesclist.CreateAutoSuggest({"id":"x<?php echo $t95_logdesc_list->RowIndex ?>_log_id","forceSelect":false});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="t95_logdesc" data-field="x_log_id" name="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" id="o<?php echo $t95_logdesc_list->RowIndex ?>_log_id" value="<?php echo ew_HtmlEncode($t95_logdesc->log_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_issued->Visible) { // date_issued ?>
		<td data-name="date_issued">
<span id="el$rowindex$_t95_logdesc_date_issued" class="form-group t95_logdesc_date_issued">
<input type="text" data-table="t95_logdesc" data-field="x_date_issued" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_issued->EditValue ?>"<?php echo $t95_logdesc->date_issued->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_issued->ReadOnly && !$t95_logdesc->date_issued->Disabled && !isset($t95_logdesc->date_issued->EditAttrs["readonly"]) && !isset($t95_logdesc->date_issued->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_issued", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_issued" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_issued" value="<?php echo ew_HtmlEncode($t95_logdesc->date_issued->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->desc_->Visible) { // desc_ ?>
		<td data-name="desc_">
<span id="el$rowindex$_t95_logdesc_desc_" class="form-group t95_logdesc_desc_">
<textarea data-table="t95_logdesc" data-field="x_desc_" name="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="x<?php echo $t95_logdesc_list->RowIndex ?>_desc_" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->desc_->getPlaceHolder()) ?>"<?php echo $t95_logdesc->desc_->EditAttributes() ?>><?php echo $t95_logdesc->desc_->EditValue ?></textarea>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_desc_" name="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" id="o<?php echo $t95_logdesc_list->RowIndex ?>_desc_" value="<?php echo ew_HtmlEncode($t95_logdesc->desc_->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t95_logdesc->date_solved->Visible) { // date_solved ?>
		<td data-name="date_solved">
<span id="el$rowindex$_t95_logdesc_date_solved" class="form-group t95_logdesc_date_solved">
<input type="text" data-table="t95_logdesc" data-field="x_date_solved" name="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" placeholder="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->getPlaceHolder()) ?>" value="<?php echo $t95_logdesc->date_solved->EditValue ?>"<?php echo $t95_logdesc->date_solved->EditAttributes() ?>>
<?php if (!$t95_logdesc->date_solved->ReadOnly && !$t95_logdesc->date_solved->Disabled && !isset($t95_logdesc->date_solved->EditAttrs["readonly"]) && !isset($t95_logdesc->date_solved->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft95_logdesclist", "x<?php echo $t95_logdesc_list->RowIndex ?>_date_solved", 0);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="t95_logdesc" data-field="x_date_solved" name="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" id="o<?php echo $t95_logdesc_list->RowIndex ?>_date_solved" value="<?php echo ew_HtmlEncode($t95_logdesc->date_solved->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t95_logdesc_list->ListOptions->Render("body", "right", $t95_logdesc_list->RowCnt);
?>
<script type="text/javascript">
ft95_logdesclist.UpdateOpts(<?php echo $t95_logdesc_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t95_logdesc->CurrentAction == "add" || $t95_logdesc->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $t95_logdesc_list->FormKeyCountName ?>" id="<?php echo $t95_logdesc_list->FormKeyCountName ?>" value="<?php echo $t95_logdesc_list->KeyCount ?>">
<?php } ?>
<?php if ($t95_logdesc->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t95_logdesc_list->FormKeyCountName ?>" id="<?php echo $t95_logdesc_list->FormKeyCountName ?>" value="<?php echo $t95_logdesc_list->KeyCount ?>">
<?php echo $t95_logdesc_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t95_logdesc->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $t95_logdesc_list->FormKeyCountName ?>" id="<?php echo $t95_logdesc_list->FormKeyCountName ?>" value="<?php echo $t95_logdesc_list->KeyCount ?>">
<?php } ?>
<?php if ($t95_logdesc->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t95_logdesc_list->FormKeyCountName ?>" id="<?php echo $t95_logdesc_list->FormKeyCountName ?>" value="<?php echo $t95_logdesc_list->KeyCount ?>">
<?php echo $t95_logdesc_list->MultiSelectKey ?>
<?php } ?>
<?php if ($t95_logdesc->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t95_logdesc_list->Recordset)
	$t95_logdesc_list->Recordset->Close();
?>
<?php if ($t95_logdesc->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t95_logdesc->CurrentAction <> "gridadd" && $t95_logdesc->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t95_logdesc_list->Pager)) $t95_logdesc_list->Pager = new cPrevNextPager($t95_logdesc_list->StartRec, $t95_logdesc_list->DisplayRecs, $t95_logdesc_list->TotalRecs) ?>
<?php if ($t95_logdesc_list->Pager->RecordCount > 0 && $t95_logdesc_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t95_logdesc_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t95_logdesc_list->PageUrl() ?>start=<?php echo $t95_logdesc_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t95_logdesc_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t95_logdesc_list->PageUrl() ?>start=<?php echo $t95_logdesc_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t95_logdesc_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t95_logdesc_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t95_logdesc_list->PageUrl() ?>start=<?php echo $t95_logdesc_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t95_logdesc_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t95_logdesc_list->PageUrl() ?>start=<?php echo $t95_logdesc_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t95_logdesc_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t95_logdesc_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t95_logdesc_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t95_logdesc_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t95_logdesc_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t95_logdesc_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="t95_logdesc">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="50"<?php if ($t95_logdesc_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t95_logdesc_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($t95_logdesc->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t95_logdesc_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($t95_logdesc_list->TotalRecs == 0 && $t95_logdesc->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t95_logdesc_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t95_logdesc->Export == "") { ?>
<script type="text/javascript">
ft95_logdesclistsrch.FilterList = <?php echo $t95_logdesc_list->GetFilterList() ?>;
ft95_logdesclistsrch.Init();
ft95_logdesclist.Init();
</script>
<?php } ?>
<?php
$t95_logdesc_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($t95_logdesc->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$t95_logdesc_list->Page_Terminate();
?>
