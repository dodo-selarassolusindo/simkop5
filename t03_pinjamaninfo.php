<?php

// Global variable for table object
$t03_pinjaman = NULL;

//
// Table class for t03_pinjaman
//
class ct03_pinjaman extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $Kontrak_No;
	var $Kontrak_Tgl;
	var $nasabah_id;
	var $jaminan_id;
	var $Pinjaman;
	var $Angsuran_Lama;
	var $Angsuran_Bunga_Prosen;
	var $Angsuran_Denda;
	var $Dispensasi_Denda;
	var $Angsuran_Pokok;
	var $Angsuran_Bunga;
	var $Angsuran_Total;
	var $No_Ref;
	var $Biaya_Administrasi;
	var $Biaya_Materai;
	var $marketing_id;
	var $Periode;
	var $Macet;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't03_pinjaman';
		$this->TableName = 't03_pinjaman';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t03_pinjaman`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 2;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('t03_pinjaman', 't03_pinjaman', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// Kontrak_No
		$this->Kontrak_No = new cField('t03_pinjaman', 't03_pinjaman', 'x_Kontrak_No', 'Kontrak_No', '`Kontrak_No`', '`Kontrak_No`', 200, -1, FALSE, '`Kontrak_No`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Kontrak_No->Sortable = TRUE; // Allow sort
		$this->fields['Kontrak_No'] = &$this->Kontrak_No;

		// Kontrak_Tgl
		$this->Kontrak_Tgl = new cField('t03_pinjaman', 't03_pinjaman', 'x_Kontrak_Tgl', 'Kontrak_Tgl', '`Kontrak_Tgl`', ew_CastDateFieldForLike('`Kontrak_Tgl`', 7, "DB"), 133, 7, FALSE, '`Kontrak_Tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Kontrak_Tgl->Sortable = TRUE; // Allow sort
		$this->Kontrak_Tgl->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['Kontrak_Tgl'] = &$this->Kontrak_Tgl;

		// nasabah_id
		$this->nasabah_id = new cField('t03_pinjaman', 't03_pinjaman', 'x_nasabah_id', 'nasabah_id', '`nasabah_id`', '`nasabah_id`', 3, -1, FALSE, '`EV__nasabah_id`', TRUE, TRUE, TRUE, 'FORMATTED TEXT', 'SELECT');
		$this->nasabah_id->Sortable = TRUE; // Allow sort
		$this->nasabah_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nasabah_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->nasabah_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nasabah_id'] = &$this->nasabah_id;

		// jaminan_id
		$this->jaminan_id = new cField('t03_pinjaman', 't03_pinjaman', 'x_jaminan_id', 'jaminan_id', '`jaminan_id`', '`jaminan_id`', 200, -1, FALSE, '`jaminan_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->jaminan_id->Sortable = TRUE; // Allow sort
		$this->fields['jaminan_id'] = &$this->jaminan_id;

		// Pinjaman
		$this->Pinjaman = new cField('t03_pinjaman', 't03_pinjaman', 'x_Pinjaman', 'Pinjaman', '`Pinjaman`', '`Pinjaman`', 4, -1, FALSE, '`Pinjaman`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Pinjaman->Sortable = TRUE; // Allow sort
		$this->Pinjaman->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Pinjaman'] = &$this->Pinjaman;

		// Angsuran_Lama
		$this->Angsuran_Lama = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Lama', 'Angsuran_Lama', '`Angsuran_Lama`', '`Angsuran_Lama`', 16, -1, FALSE, '`Angsuran_Lama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Lama->Sortable = TRUE; // Allow sort
		$this->Angsuran_Lama->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Angsuran_Lama'] = &$this->Angsuran_Lama;

		// Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Bunga_Prosen', 'Angsuran_Bunga_Prosen', '`Angsuran_Bunga_Prosen`', '`Angsuran_Bunga_Prosen`', 131, -1, FALSE, '`Angsuran_Bunga_Prosen`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Bunga_Prosen->Sortable = TRUE; // Allow sort
		$this->Angsuran_Bunga_Prosen->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Bunga_Prosen'] = &$this->Angsuran_Bunga_Prosen;

		// Angsuran_Denda
		$this->Angsuran_Denda = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Denda', 'Angsuran_Denda', '`Angsuran_Denda`', '`Angsuran_Denda`', 131, -1, FALSE, '`Angsuran_Denda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Denda->Sortable = TRUE; // Allow sort
		$this->Angsuran_Denda->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Denda'] = &$this->Angsuran_Denda;

		// Dispensasi_Denda
		$this->Dispensasi_Denda = new cField('t03_pinjaman', 't03_pinjaman', 'x_Dispensasi_Denda', 'Dispensasi_Denda', '`Dispensasi_Denda`', '`Dispensasi_Denda`', 16, -1, FALSE, '`Dispensasi_Denda`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dispensasi_Denda->Sortable = TRUE; // Allow sort
		$this->Dispensasi_Denda->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dispensasi_Denda'] = &$this->Dispensasi_Denda;

		// Angsuran_Pokok
		$this->Angsuran_Pokok = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Pokok', 'Angsuran_Pokok', '`Angsuran_Pokok`', '`Angsuran_Pokok`', 4, -1, FALSE, '`Angsuran_Pokok`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Pokok->Sortable = TRUE; // Allow sort
		$this->Angsuran_Pokok->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Pokok'] = &$this->Angsuran_Pokok;

		// Angsuran_Bunga
		$this->Angsuran_Bunga = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Bunga', 'Angsuran_Bunga', '`Angsuran_Bunga`', '`Angsuran_Bunga`', 4, -1, FALSE, '`Angsuran_Bunga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Bunga->Sortable = TRUE; // Allow sort
		$this->Angsuran_Bunga->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Bunga'] = &$this->Angsuran_Bunga;

		// Angsuran_Total
		$this->Angsuran_Total = new cField('t03_pinjaman', 't03_pinjaman', 'x_Angsuran_Total', 'Angsuran_Total', '`Angsuran_Total`', '`Angsuran_Total`', 4, -1, FALSE, '`Angsuran_Total`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Angsuran_Total->Sortable = TRUE; // Allow sort
		$this->Angsuran_Total->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Angsuran_Total'] = &$this->Angsuran_Total;

		// No_Ref
		$this->No_Ref = new cField('t03_pinjaman', 't03_pinjaman', 'x_No_Ref', 'No_Ref', '`No_Ref`', '`No_Ref`', 200, -1, FALSE, '`No_Ref`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->No_Ref->Sortable = TRUE; // Allow sort
		$this->No_Ref->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->No_Ref->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['No_Ref'] = &$this->No_Ref;

		// Biaya_Administrasi
		$this->Biaya_Administrasi = new cField('t03_pinjaman', 't03_pinjaman', 'x_Biaya_Administrasi', 'Biaya_Administrasi', '`Biaya_Administrasi`', '`Biaya_Administrasi`', 4, -1, FALSE, '`Biaya_Administrasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Biaya_Administrasi->Sortable = TRUE; // Allow sort
		$this->Biaya_Administrasi->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Biaya_Administrasi'] = &$this->Biaya_Administrasi;

		// Biaya_Materai
		$this->Biaya_Materai = new cField('t03_pinjaman', 't03_pinjaman', 'x_Biaya_Materai', 'Biaya_Materai', '`Biaya_Materai`', '`Biaya_Materai`', 4, -1, FALSE, '`Biaya_Materai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Biaya_Materai->Sortable = TRUE; // Allow sort
		$this->Biaya_Materai->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Biaya_Materai'] = &$this->Biaya_Materai;

		// marketing_id
		$this->marketing_id = new cField('t03_pinjaman', 't03_pinjaman', 'x_marketing_id', 'marketing_id', '`marketing_id`', '`marketing_id`', 3, -1, FALSE, '`marketing_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->marketing_id->Sortable = TRUE; // Allow sort
		$this->marketing_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['marketing_id'] = &$this->marketing_id;

		// Periode
		$this->Periode = new cField('t03_pinjaman', 't03_pinjaman', 'x_Periode', 'Periode', '`Periode`', '`Periode`', 200, -1, FALSE, '`Periode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Periode->Sortable = TRUE; // Allow sort
		$this->fields['Periode'] = &$this->Periode;

		// Macet
		$this->Macet = new cField('t03_pinjaman', 't03_pinjaman', 'x_Macet', 'Macet', '`Macet`', '`Macet`', 202, -1, FALSE, '`Macet`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Macet->Sortable = TRUE; // Allow sort
		$this->Macet->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->Macet->TrueValue = 'Y';
		$this->Macet->FalseValue = 'N';
		$this->Macet->OptionCount = 2;
		$this->fields['Macet'] = &$this->Macet;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
			$sSortFieldList = ($ofld->FldVirtualExpression <> "") ? $ofld->FldVirtualExpression : $sSortField;
			if ($ctrl) {
				$sOrderByList = $this->getSessionOrderByList();
				if (strpos($sOrderByList, $sSortFieldList . " " . $sLastSort) !== FALSE) {
					$sOrderByList = str_replace($sSortFieldList . " " . $sLastSort, $sSortFieldList . " " . $sThisSort, $sOrderByList);
				} else {
					if ($sOrderByList <> "") $sOrderByList .= ", ";
					$sOrderByList .= $sSortFieldList . " " . $sThisSort;
				}
				$this->setSessionOrderByList($sOrderByList); // Save to Session
			} else {
				$this->setSessionOrderByList($sSortFieldList . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Session ORDER BY for List page
	function getSessionOrderByList() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST];
	}

	function setSessionOrderByList($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_ORDER_BY_LIST] = $v;
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "t04_pinjamanangsurantemp") {
			$sDetailUrl = $GLOBALS["t04_pinjamanangsurantemp"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "t06_pinjamantitipan") {
			$sDetailUrl = $GLOBALS["t06_pinjamantitipan"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "t08_pinjamanpotongan") {
			$sDetailUrl = $GLOBALS["t08_pinjamanpotongan"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "t03_pinjamanlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t03_pinjaman`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlSelectList = "";

	function getSqlSelectList() { // Select for List page
		$select = "";
		$select = "SELECT * FROM (" .
			"SELECT *, (SELECT `Nama` FROM `v02_nasabahjaminan` `EW_TMP_LOOKUPTABLE` WHERE `EW_TMP_LOOKUPTABLE`.`id` = `t03_pinjaman`.`nasabah_id` LIMIT 1) AS `EV__nasabah_id` FROM `t03_pinjaman`" .
			") `EW_TMP_TABLE`";
		return ($this->_SqlSelectList <> "") ? $this->_SqlSelectList : $select;
	}

	function SqlSelectList() { // For backward compatibility
		return $this->getSqlSelectList();
	}

	function setSqlSelectList($v) {
		$this->_SqlSelectList = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		if ($this->UseVirtualFields()) {
			$sSort = $this->getSessionOrderByList();
			return ew_BuildSelectSql($this->getSqlSelectList(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		} else {
			$sSort = $this->getSessionOrderBy();
			return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
				$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
		}
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = ($this->UseVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Check if virtual fields is used in SQL
	function UseVirtualFields() {
		$sWhere = $this->getSessionWhere();
		$sOrderBy = $this->getSessionOrderByList();
		if ($sWhere <> "")
			$sWhere = " " . str_replace(array("(",")"), array("",""), $sWhere) . " ";
		if ($sOrderBy <> "")
			$sOrderBy = " " . str_replace(array("(",")"), array("",""), $sOrderBy) . " ";
		if ($this->nasabah_id->AdvancedSearch->SearchValue <> "" ||
			$this->nasabah_id->AdvancedSearch->SearchValue2 <> "" ||
			strpos($sWhere, " " . $this->nasabah_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		if (strpos($sOrderBy, " " . $this->nasabah_id->FldVirtualExpression . " ") !== FALSE)
			return TRUE;
		return FALSE;
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();

		// Cascade Update detail table 't04_pinjamanangsurantemp'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'pinjaman_id'
			$bCascadeUpdate = TRUE;
			$rscascade['pinjaman_id'] = $rs['id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["t04_pinjamanangsurantemp"])) $GLOBALS["t04_pinjamanangsurantemp"] = new ct04_pinjamanangsurantemp();
			$rswrk = $GLOBALS["t04_pinjamanangsurantemp"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["t04_pinjamanangsurantemp"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 't06_pinjamantitipan'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'pinjaman_id'
			$bCascadeUpdate = TRUE;
			$rscascade['pinjaman_id'] = $rs['id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["t06_pinjamantitipan"])) $GLOBALS["t06_pinjamantitipan"] = new ct06_pinjamantitipan();
			$rswrk = $GLOBALS["t06_pinjamantitipan"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["t06_pinjamantitipan"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 't08_pinjamanpotongan'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'pinjaman_id'
			$bCascadeUpdate = TRUE;
			$rscascade['pinjaman_id'] = $rs['id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["t08_pinjamanpotongan"])) $GLOBALS["t08_pinjamanpotongan"] = new ct08_pinjamanpotongan();
			$rswrk = $GLOBALS["t08_pinjamanpotongan"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["t08_pinjamanpotongan"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;
				$rswrk->MoveNext();
			}
		}
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();

		// Cascade delete detail table 't04_pinjamanangsurantemp'
		if (!isset($GLOBALS["t04_pinjamanangsurantemp"])) $GLOBALS["t04_pinjamanangsurantemp"] = new ct04_pinjamanangsurantemp();
		$rscascade = $GLOBALS["t04_pinjamanangsurantemp"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["t04_pinjamanangsurantemp"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}

		// Cascade delete detail table 't06_pinjamantitipan'
		if (!isset($GLOBALS["t06_pinjamantitipan"])) $GLOBALS["t06_pinjamantitipan"] = new ct06_pinjamantitipan();
		$rscascade = $GLOBALS["t06_pinjamantitipan"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["t06_pinjamantitipan"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}

		// Cascade delete detail table 't08_pinjamanpotongan'
		if (!isset($GLOBALS["t08_pinjamanpotongan"])) $GLOBALS["t08_pinjamanpotongan"] = new ct08_pinjamanpotongan();
		$rscascade = $GLOBALS["t08_pinjamanpotongan"]->LoadRs("`pinjaman_id` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["t08_pinjamanpotongan"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "t03_pinjamanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t03_pinjamanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t03_pinjamanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t03_pinjamanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t03_pinjamanadd.php?" . $this->UrlParm($parm);
		else
			$url = "t03_pinjamanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t03_pinjamanedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t03_pinjamanedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t03_pinjamanadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t03_pinjamanadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t03_pinjamandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKeys[] = ew_StripSlashes($_GET["id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->Kontrak_No->setDbValue($rs->fields('Kontrak_No'));
		$this->Kontrak_Tgl->setDbValue($rs->fields('Kontrak_Tgl'));
		$this->nasabah_id->setDbValue($rs->fields('nasabah_id'));
		$this->jaminan_id->setDbValue($rs->fields('jaminan_id'));
		$this->Pinjaman->setDbValue($rs->fields('Pinjaman'));
		$this->Angsuran_Lama->setDbValue($rs->fields('Angsuran_Lama'));
		$this->Angsuran_Bunga_Prosen->setDbValue($rs->fields('Angsuran_Bunga_Prosen'));
		$this->Angsuran_Denda->setDbValue($rs->fields('Angsuran_Denda'));
		$this->Dispensasi_Denda->setDbValue($rs->fields('Dispensasi_Denda'));
		$this->Angsuran_Pokok->setDbValue($rs->fields('Angsuran_Pokok'));
		$this->Angsuran_Bunga->setDbValue($rs->fields('Angsuran_Bunga'));
		$this->Angsuran_Total->setDbValue($rs->fields('Angsuran_Total'));
		$this->No_Ref->setDbValue($rs->fields('No_Ref'));
		$this->Biaya_Administrasi->setDbValue($rs->fields('Biaya_Administrasi'));
		$this->Biaya_Materai->setDbValue($rs->fields('Biaya_Materai'));
		$this->marketing_id->setDbValue($rs->fields('marketing_id'));
		$this->Periode->setDbValue($rs->fields('Periode'));
		$this->Macet->setDbValue($rs->fields('Macet'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// Kontrak_No
		// Kontrak_Tgl
		// nasabah_id
		// jaminan_id
		// Pinjaman
		// Angsuran_Lama
		// Angsuran_Bunga_Prosen
		// Angsuran_Denda
		// Dispensasi_Denda
		// Angsuran_Pokok
		// Angsuran_Bunga
		// Angsuran_Total
		// No_Ref
		// Biaya_Administrasi
		// Biaya_Materai
		// marketing_id
		// Periode
		// Macet
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Kontrak_No
		$this->Kontrak_No->ViewValue = $this->Kontrak_No->CurrentValue;
		$this->Kontrak_No->ViewCustomAttributes = "";

		// Kontrak_Tgl
		$this->Kontrak_Tgl->ViewValue = $this->Kontrak_Tgl->CurrentValue;
		$this->Kontrak_Tgl->ViewValue = ew_FormatDateTime($this->Kontrak_Tgl->ViewValue, 7);
		$this->Kontrak_Tgl->ViewCustomAttributes = "";

		// nasabah_id
		if ($this->nasabah_id->VirtualValue <> "") {
			$this->nasabah_id->ViewValue = $this->nasabah_id->VirtualValue;
		} else {
		if (strval($this->nasabah_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->nasabah_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `v02_nasabahjaminan`";
		$sWhereWrk = "";
		$this->nasabah_id->LookupFilters = array("dx1" => '`Nama`');
		$lookuptblfilter = "`Status` <> 2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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
		}
		$this->nasabah_id->ViewCustomAttributes = "";

		// jaminan_id
		if (strval($this->jaminan_id->CurrentValue) <> "") {
			$arwrk = explode(",", $this->jaminan_id->CurrentValue);
			$sFilterWrk = "";
			foreach ($arwrk as $wrk) {
				if ($sFilterWrk <> "") $sFilterWrk .= " OR ";
				$sFilterWrk .= "`id`" . ew_SearchString("=", trim($wrk), EW_DATATYPE_NUMBER, "");
			}
		$sSqlWrk = "SELECT `id`, `Merk_Type` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t02_jaminan`";
		$sWhereWrk = "";
		$this->jaminan_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->jaminan_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->jaminan_id->ViewValue = "";
				$ari = 0;
				while (!$rswrk->EOF) {
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->jaminan_id->ViewValue .= $this->jaminan_id->DisplayValue($arwrk);
					$rswrk->MoveNext();
					if (!$rswrk->EOF) $this->jaminan_id->ViewValue .= ew_ViewOptionSeparator($ari); // Separate Options
					$ari++;
				}
				$rswrk->Close();
			} else {
				$this->jaminan_id->ViewValue = $this->jaminan_id->CurrentValue;
			}
		} else {
			$this->jaminan_id->ViewValue = NULL;
		}
		$this->jaminan_id->ViewCustomAttributes = "";

		// Pinjaman
		$this->Pinjaman->ViewValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->ViewValue = ew_FormatNumber($this->Pinjaman->ViewValue, 2, -2, -2, -2);
		$this->Pinjaman->CellCssStyle .= "text-align: right;";
		$this->Pinjaman->ViewCustomAttributes = "";

		// Angsuran_Lama
		$this->Angsuran_Lama->ViewValue = $this->Angsuran_Lama->CurrentValue;
		$this->Angsuran_Lama->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Lama->ViewCustomAttributes = "";

		// Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen->ViewValue = $this->Angsuran_Bunga_Prosen->CurrentValue;
		$this->Angsuran_Bunga_Prosen->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Bunga_Prosen->ViewCustomAttributes = "";

		// Angsuran_Denda
		$this->Angsuran_Denda->ViewValue = $this->Angsuran_Denda->CurrentValue;
		$this->Angsuran_Denda->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Denda->ViewCustomAttributes = "";

		// Dispensasi_Denda
		$this->Dispensasi_Denda->ViewValue = $this->Dispensasi_Denda->CurrentValue;
		$this->Dispensasi_Denda->CellCssStyle .= "text-align: right;";
		$this->Dispensasi_Denda->ViewCustomAttributes = "";

		// Angsuran_Pokok
		$this->Angsuran_Pokok->ViewValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->ViewValue = ew_FormatNumber($this->Angsuran_Pokok->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Pokok->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Pokok->ViewCustomAttributes = "";

		// Angsuran_Bunga
		$this->Angsuran_Bunga->ViewValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->ViewValue = ew_FormatNumber($this->Angsuran_Bunga->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Bunga->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Bunga->ViewCustomAttributes = "";

		// Angsuran_Total
		$this->Angsuran_Total->ViewValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->ViewValue = ew_FormatNumber($this->Angsuran_Total->ViewValue, 2, -2, -2, -2);
		$this->Angsuran_Total->CellCssStyle .= "text-align: right;";
		$this->Angsuran_Total->ViewCustomAttributes = "";

		// No_Ref
		$this->No_Ref->ViewCustomAttributes = "";

		// Biaya_Administrasi
		$this->Biaya_Administrasi->ViewValue = $this->Biaya_Administrasi->CurrentValue;
		$this->Biaya_Administrasi->ViewValue = ew_FormatNumber($this->Biaya_Administrasi->ViewValue, 2, -2, -2, -2);
		$this->Biaya_Administrasi->CellCssStyle .= "text-align: right;";
		$this->Biaya_Administrasi->ViewCustomAttributes = "";

		// Biaya_Materai
		$this->Biaya_Materai->ViewValue = $this->Biaya_Materai->CurrentValue;
		$this->Biaya_Materai->ViewValue = ew_FormatNumber($this->Biaya_Materai->ViewValue, 2, -2, -2, -2);
		$this->Biaya_Materai->CellCssStyle .= "text-align: right;";
		$this->Biaya_Materai->ViewCustomAttributes = "";

		// marketing_id
		$this->marketing_id->ViewValue = $this->marketing_id->CurrentValue;
		if (strval($this->marketing_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->marketing_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `Nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t07_marketing`";
		$sWhereWrk = "";
		$this->marketing_id->LookupFilters = array("dx1" => '`Nama`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->marketing_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->marketing_id->ViewValue = $this->marketing_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->marketing_id->ViewValue = $this->marketing_id->CurrentValue;
			}
		} else {
			$this->marketing_id->ViewValue = NULL;
		}
		$this->marketing_id->ViewCustomAttributes = "";

		// Periode
		$this->Periode->ViewValue = $this->Periode->CurrentValue;
		$this->Periode->ViewCustomAttributes = "";

		// Macet
		if (ew_ConvertToBool($this->Macet->CurrentValue)) {
			$this->Macet->ViewValue = $this->Macet->FldTagCaption(1) <> "" ? $this->Macet->FldTagCaption(1) : "Yes";
		} else {
			$this->Macet->ViewValue = $this->Macet->FldTagCaption(2) <> "" ? $this->Macet->FldTagCaption(2) : "No";
		}
		$this->Macet->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// Kontrak_No
		$this->Kontrak_No->LinkCustomAttributes = "";
		$this->Kontrak_No->HrefValue = "";
		$this->Kontrak_No->TooltipValue = "";

		// Kontrak_Tgl
		$this->Kontrak_Tgl->LinkCustomAttributes = "";
		$this->Kontrak_Tgl->HrefValue = "";
		$this->Kontrak_Tgl->TooltipValue = "";

		// nasabah_id
		$this->nasabah_id->LinkCustomAttributes = "";
		$this->nasabah_id->HrefValue = "";
		$this->nasabah_id->TooltipValue = "";

		// jaminan_id
		$this->jaminan_id->LinkCustomAttributes = "";
		$this->jaminan_id->HrefValue = "";
		$this->jaminan_id->TooltipValue = "";

		// Pinjaman
		$this->Pinjaman->LinkCustomAttributes = "";
		$this->Pinjaman->HrefValue = "";
		$this->Pinjaman->TooltipValue = "";

		// Angsuran_Lama
		$this->Angsuran_Lama->LinkCustomAttributes = "";
		$this->Angsuran_Lama->HrefValue = "";
		$this->Angsuran_Lama->TooltipValue = "";

		// Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen->LinkCustomAttributes = "";
		$this->Angsuran_Bunga_Prosen->HrefValue = "";
		$this->Angsuran_Bunga_Prosen->TooltipValue = "";

		// Angsuran_Denda
		$this->Angsuran_Denda->LinkCustomAttributes = "";
		$this->Angsuran_Denda->HrefValue = "";
		$this->Angsuran_Denda->TooltipValue = "";

		// Dispensasi_Denda
		$this->Dispensasi_Denda->LinkCustomAttributes = "";
		$this->Dispensasi_Denda->HrefValue = "";
		$this->Dispensasi_Denda->TooltipValue = "";

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

		// No_Ref
		$this->No_Ref->LinkCustomAttributes = "";
		$this->No_Ref->HrefValue = "";
		$this->No_Ref->TooltipValue = "";

		// Biaya_Administrasi
		$this->Biaya_Administrasi->LinkCustomAttributes = "";
		$this->Biaya_Administrasi->HrefValue = "";
		$this->Biaya_Administrasi->TooltipValue = "";

		// Biaya_Materai
		$this->Biaya_Materai->LinkCustomAttributes = "";
		$this->Biaya_Materai->HrefValue = "";
		$this->Biaya_Materai->TooltipValue = "";

		// marketing_id
		$this->marketing_id->LinkCustomAttributes = "";
		$this->marketing_id->HrefValue = "";
		$this->marketing_id->TooltipValue = "";

		// Periode
		$this->Periode->LinkCustomAttributes = "";
		$this->Periode->HrefValue = "";
		$this->Periode->TooltipValue = "";

		// Macet
		$this->Macet->LinkCustomAttributes = "";
		if (!ew_Empty($this->id->CurrentValue)) {
			$this->Macet->HrefValue = "cf09_nasabahmacet.php?id=" . ((!empty($this->id->ViewValue)) ? ew_RemoveHtml($this->id->ViewValue) : $this->id->CurrentValue); // Add prefix/suffix
			$this->Macet->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->Macet->HrefValue = ew_ConvertFullUrl($this->Macet->HrefValue);
		} else {
			$this->Macet->HrefValue = "";
		}
		$this->Macet->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// Kontrak_No
		$this->Kontrak_No->EditAttrs["class"] = "form-control";
		$this->Kontrak_No->EditCustomAttributes = "";
		$this->Kontrak_No->EditValue = $this->Kontrak_No->CurrentValue;
		$this->Kontrak_No->PlaceHolder = ew_RemoveHtml($this->Kontrak_No->FldCaption());

		// Kontrak_Tgl
		$this->Kontrak_Tgl->EditAttrs["class"] = "form-control";
		$this->Kontrak_Tgl->EditCustomAttributes = "style='width: 115px;'";
		$this->Kontrak_Tgl->EditValue = ew_FormatDateTime($this->Kontrak_Tgl->CurrentValue, 7);
		$this->Kontrak_Tgl->PlaceHolder = ew_RemoveHtml($this->Kontrak_Tgl->FldCaption());

		// nasabah_id
		$this->nasabah_id->EditAttrs["class"] = "form-control";
		$this->nasabah_id->EditCustomAttributes = "";

		// jaminan_id
		$this->jaminan_id->EditCustomAttributes = "";

		// Pinjaman
		$this->Pinjaman->EditAttrs["class"] = "form-control";
		$this->Pinjaman->EditCustomAttributes = "";
		$this->Pinjaman->EditValue = $this->Pinjaman->CurrentValue;
		$this->Pinjaman->PlaceHolder = ew_RemoveHtml($this->Pinjaman->FldCaption());
		if (strval($this->Pinjaman->EditValue) <> "" && is_numeric($this->Pinjaman->EditValue)) $this->Pinjaman->EditValue = ew_FormatNumber($this->Pinjaman->EditValue, -2, -2, -2, -2);

		// Angsuran_Lama
		$this->Angsuran_Lama->EditAttrs["class"] = "form-control";
		$this->Angsuran_Lama->EditCustomAttributes = "";
		$this->Angsuran_Lama->EditValue = $this->Angsuran_Lama->CurrentValue;
		$this->Angsuran_Lama->PlaceHolder = ew_RemoveHtml($this->Angsuran_Lama->FldCaption());

		// Angsuran_Bunga_Prosen
		$this->Angsuran_Bunga_Prosen->EditAttrs["class"] = "form-control";
		$this->Angsuran_Bunga_Prosen->EditCustomAttributes = "";
		$this->Angsuran_Bunga_Prosen->EditValue = $this->Angsuran_Bunga_Prosen->CurrentValue;
		$this->Angsuran_Bunga_Prosen->PlaceHolder = ew_RemoveHtml($this->Angsuran_Bunga_Prosen->FldCaption());
		if (strval($this->Angsuran_Bunga_Prosen->EditValue) <> "" && is_numeric($this->Angsuran_Bunga_Prosen->EditValue)) $this->Angsuran_Bunga_Prosen->EditValue = ew_FormatNumber($this->Angsuran_Bunga_Prosen->EditValue, -2, -1, -2, 0);

		// Angsuran_Denda
		$this->Angsuran_Denda->EditAttrs["class"] = "form-control";
		$this->Angsuran_Denda->EditCustomAttributes = "";
		$this->Angsuran_Denda->EditValue = $this->Angsuran_Denda->CurrentValue;
		$this->Angsuran_Denda->PlaceHolder = ew_RemoveHtml($this->Angsuran_Denda->FldCaption());
		if (strval($this->Angsuran_Denda->EditValue) <> "" && is_numeric($this->Angsuran_Denda->EditValue)) $this->Angsuran_Denda->EditValue = ew_FormatNumber($this->Angsuran_Denda->EditValue, -2, -1, -2, 0);

		// Dispensasi_Denda
		$this->Dispensasi_Denda->EditAttrs["class"] = "form-control";
		$this->Dispensasi_Denda->EditCustomAttributes = "";
		$this->Dispensasi_Denda->EditValue = $this->Dispensasi_Denda->CurrentValue;
		$this->Dispensasi_Denda->PlaceHolder = ew_RemoveHtml($this->Dispensasi_Denda->FldCaption());

		// Angsuran_Pokok
		$this->Angsuran_Pokok->EditAttrs["class"] = "form-control";
		$this->Angsuran_Pokok->EditCustomAttributes = "";
		$this->Angsuran_Pokok->EditValue = $this->Angsuran_Pokok->CurrentValue;
		$this->Angsuran_Pokok->PlaceHolder = ew_RemoveHtml($this->Angsuran_Pokok->FldCaption());
		if (strval($this->Angsuran_Pokok->EditValue) <> "" && is_numeric($this->Angsuran_Pokok->EditValue)) $this->Angsuran_Pokok->EditValue = ew_FormatNumber($this->Angsuran_Pokok->EditValue, -2, -2, -2, -2);

		// Angsuran_Bunga
		$this->Angsuran_Bunga->EditAttrs["class"] = "form-control";
		$this->Angsuran_Bunga->EditCustomAttributes = "";
		$this->Angsuran_Bunga->EditValue = $this->Angsuran_Bunga->CurrentValue;
		$this->Angsuran_Bunga->PlaceHolder = ew_RemoveHtml($this->Angsuran_Bunga->FldCaption());
		if (strval($this->Angsuran_Bunga->EditValue) <> "" && is_numeric($this->Angsuran_Bunga->EditValue)) $this->Angsuran_Bunga->EditValue = ew_FormatNumber($this->Angsuran_Bunga->EditValue, -2, -2, -2, -2);

		// Angsuran_Total
		$this->Angsuran_Total->EditAttrs["class"] = "form-control";
		$this->Angsuran_Total->EditCustomAttributes = "";
		$this->Angsuran_Total->EditValue = $this->Angsuran_Total->CurrentValue;
		$this->Angsuran_Total->PlaceHolder = ew_RemoveHtml($this->Angsuran_Total->FldCaption());
		if (strval($this->Angsuran_Total->EditValue) <> "" && is_numeric($this->Angsuran_Total->EditValue)) $this->Angsuran_Total->EditValue = ew_FormatNumber($this->Angsuran_Total->EditValue, -2, -2, -2, -2);

		// No_Ref
		$this->No_Ref->EditAttrs["class"] = "form-control";
		$this->No_Ref->EditCustomAttributes = "";

		// Biaya_Administrasi
		$this->Biaya_Administrasi->EditAttrs["class"] = "form-control";
		$this->Biaya_Administrasi->EditCustomAttributes = "";
		$this->Biaya_Administrasi->EditValue = $this->Biaya_Administrasi->CurrentValue;
		$this->Biaya_Administrasi->PlaceHolder = ew_RemoveHtml($this->Biaya_Administrasi->FldCaption());
		if (strval($this->Biaya_Administrasi->EditValue) <> "" && is_numeric($this->Biaya_Administrasi->EditValue)) $this->Biaya_Administrasi->EditValue = ew_FormatNumber($this->Biaya_Administrasi->EditValue, -2, -2, -2, -2);

		// Biaya_Materai
		$this->Biaya_Materai->EditAttrs["class"] = "form-control";
		$this->Biaya_Materai->EditCustomAttributes = "";
		$this->Biaya_Materai->EditValue = $this->Biaya_Materai->CurrentValue;
		$this->Biaya_Materai->PlaceHolder = ew_RemoveHtml($this->Biaya_Materai->FldCaption());
		if (strval($this->Biaya_Materai->EditValue) <> "" && is_numeric($this->Biaya_Materai->EditValue)) $this->Biaya_Materai->EditValue = ew_FormatNumber($this->Biaya_Materai->EditValue, -2, -2, -2, -2);

		// marketing_id
		$this->marketing_id->EditAttrs["class"] = "form-control";
		$this->marketing_id->EditCustomAttributes = "";
		$this->marketing_id->EditValue = $this->marketing_id->CurrentValue;
		$this->marketing_id->PlaceHolder = ew_RemoveHtml($this->marketing_id->FldCaption());

		// Periode
		$this->Periode->EditAttrs["class"] = "form-control";
		$this->Periode->EditCustomAttributes = "";
		$this->Periode->EditValue = $this->Periode->CurrentValue;
		$this->Periode->PlaceHolder = ew_RemoveHtml($this->Periode->FldCaption());

		// Macet
		$this->Macet->EditCustomAttributes = "";
		$this->Macet->EditValue = $this->Macet->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Kontrak_No->Exportable) $Doc->ExportCaption($this->Kontrak_No);
					if ($this->Kontrak_Tgl->Exportable) $Doc->ExportCaption($this->Kontrak_Tgl);
					if ($this->nasabah_id->Exportable) $Doc->ExportCaption($this->nasabah_id);
					if ($this->jaminan_id->Exportable) $Doc->ExportCaption($this->jaminan_id);
					if ($this->Pinjaman->Exportable) $Doc->ExportCaption($this->Pinjaman);
					if ($this->Angsuran_Lama->Exportable) $Doc->ExportCaption($this->Angsuran_Lama);
					if ($this->Angsuran_Bunga_Prosen->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga_Prosen);
					if ($this->Angsuran_Denda->Exportable) $Doc->ExportCaption($this->Angsuran_Denda);
					if ($this->Dispensasi_Denda->Exportable) $Doc->ExportCaption($this->Dispensasi_Denda);
					if ($this->Angsuran_Pokok->Exportable) $Doc->ExportCaption($this->Angsuran_Pokok);
					if ($this->Angsuran_Bunga->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga);
					if ($this->Angsuran_Total->Exportable) $Doc->ExportCaption($this->Angsuran_Total);
					if ($this->No_Ref->Exportable) $Doc->ExportCaption($this->No_Ref);
					if ($this->Biaya_Administrasi->Exportable) $Doc->ExportCaption($this->Biaya_Administrasi);
					if ($this->Biaya_Materai->Exportable) $Doc->ExportCaption($this->Biaya_Materai);
					if ($this->marketing_id->Exportable) $Doc->ExportCaption($this->marketing_id);
					if ($this->Macet->Exportable) $Doc->ExportCaption($this->Macet);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->Kontrak_No->Exportable) $Doc->ExportCaption($this->Kontrak_No);
					if ($this->Kontrak_Tgl->Exportable) $Doc->ExportCaption($this->Kontrak_Tgl);
					if ($this->nasabah_id->Exportable) $Doc->ExportCaption($this->nasabah_id);
					if ($this->jaminan_id->Exportable) $Doc->ExportCaption($this->jaminan_id);
					if ($this->Pinjaman->Exportable) $Doc->ExportCaption($this->Pinjaman);
					if ($this->Angsuran_Lama->Exportable) $Doc->ExportCaption($this->Angsuran_Lama);
					if ($this->Angsuran_Bunga_Prosen->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga_Prosen);
					if ($this->Angsuran_Denda->Exportable) $Doc->ExportCaption($this->Angsuran_Denda);
					if ($this->Dispensasi_Denda->Exportable) $Doc->ExportCaption($this->Dispensasi_Denda);
					if ($this->Angsuran_Pokok->Exportable) $Doc->ExportCaption($this->Angsuran_Pokok);
					if ($this->Angsuran_Bunga->Exportable) $Doc->ExportCaption($this->Angsuran_Bunga);
					if ($this->Angsuran_Total->Exportable) $Doc->ExportCaption($this->Angsuran_Total);
					if ($this->No_Ref->Exportable) $Doc->ExportCaption($this->No_Ref);
					if ($this->Biaya_Administrasi->Exportable) $Doc->ExportCaption($this->Biaya_Administrasi);
					if ($this->Biaya_Materai->Exportable) $Doc->ExportCaption($this->Biaya_Materai);
					if ($this->marketing_id->Exportable) $Doc->ExportCaption($this->marketing_id);
					if ($this->Periode->Exportable) $Doc->ExportCaption($this->Periode);
					if ($this->Macet->Exportable) $Doc->ExportCaption($this->Macet);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Kontrak_No->Exportable) $Doc->ExportField($this->Kontrak_No);
						if ($this->Kontrak_Tgl->Exportable) $Doc->ExportField($this->Kontrak_Tgl);
						if ($this->nasabah_id->Exportable) $Doc->ExportField($this->nasabah_id);
						if ($this->jaminan_id->Exportable) $Doc->ExportField($this->jaminan_id);
						if ($this->Pinjaman->Exportable) $Doc->ExportField($this->Pinjaman);
						if ($this->Angsuran_Lama->Exportable) $Doc->ExportField($this->Angsuran_Lama);
						if ($this->Angsuran_Bunga_Prosen->Exportable) $Doc->ExportField($this->Angsuran_Bunga_Prosen);
						if ($this->Angsuran_Denda->Exportable) $Doc->ExportField($this->Angsuran_Denda);
						if ($this->Dispensasi_Denda->Exportable) $Doc->ExportField($this->Dispensasi_Denda);
						if ($this->Angsuran_Pokok->Exportable) $Doc->ExportField($this->Angsuran_Pokok);
						if ($this->Angsuran_Bunga->Exportable) $Doc->ExportField($this->Angsuran_Bunga);
						if ($this->Angsuran_Total->Exportable) $Doc->ExportField($this->Angsuran_Total);
						if ($this->No_Ref->Exportable) $Doc->ExportField($this->No_Ref);
						if ($this->Biaya_Administrasi->Exportable) $Doc->ExportField($this->Biaya_Administrasi);
						if ($this->Biaya_Materai->Exportable) $Doc->ExportField($this->Biaya_Materai);
						if ($this->marketing_id->Exportable) $Doc->ExportField($this->marketing_id);
						if ($this->Macet->Exportable) $Doc->ExportField($this->Macet);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->Kontrak_No->Exportable) $Doc->ExportField($this->Kontrak_No);
						if ($this->Kontrak_Tgl->Exportable) $Doc->ExportField($this->Kontrak_Tgl);
						if ($this->nasabah_id->Exportable) $Doc->ExportField($this->nasabah_id);
						if ($this->jaminan_id->Exportable) $Doc->ExportField($this->jaminan_id);
						if ($this->Pinjaman->Exportable) $Doc->ExportField($this->Pinjaman);
						if ($this->Angsuran_Lama->Exportable) $Doc->ExportField($this->Angsuran_Lama);
						if ($this->Angsuran_Bunga_Prosen->Exportable) $Doc->ExportField($this->Angsuran_Bunga_Prosen);
						if ($this->Angsuran_Denda->Exportable) $Doc->ExportField($this->Angsuran_Denda);
						if ($this->Dispensasi_Denda->Exportable) $Doc->ExportField($this->Dispensasi_Denda);
						if ($this->Angsuran_Pokok->Exportable) $Doc->ExportField($this->Angsuran_Pokok);
						if ($this->Angsuran_Bunga->Exportable) $Doc->ExportField($this->Angsuran_Bunga);
						if ($this->Angsuran_Total->Exportable) $Doc->ExportField($this->Angsuran_Total);
						if ($this->No_Ref->Exportable) $Doc->ExportField($this->No_Ref);
						if ($this->Biaya_Administrasi->Exportable) $Doc->ExportField($this->Biaya_Administrasi);
						if ($this->Biaya_Materai->Exportable) $Doc->ExportField($this->Biaya_Materai);
						if ($this->marketing_id->Exportable) $Doc->ExportField($this->marketing_id);
						if ($this->Periode->Exportable) $Doc->ExportField($this->Periode);
						if ($this->Macet->Exportable) $Doc->ExportField($this->Macet);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;
		if (preg_match('/^x(\d)*_nasabah_id$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `jaminan_id` AS FIELD0, `marketing_id` AS FIELD1 FROM `v02_nasabahjaminan`";
			$sWhereWrk = "(`id` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->nasabah_id->LookupFilters = array("dx1" => '`Nama`');
			$lookuptblfilter = "`Status` <> 2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->nasabah_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->jaminan_id->setDbValue($rs->fields[0]);
					$this->marketing_id->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = $this->jaminan_id->CurrentValue;
					$ar[] = ($this->marketing_id->AutoFillOriginalValue) ? $this->marketing_id->CurrentValue : $this->marketing_id->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't03_pinjaman';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't03_pinjaman';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't03_pinjaman';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't03_pinjaman';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		if (
			(date_format(date_create($rsnew["Kontrak_Tgl"]),"Ym") <> $GLOBALS["Periode"])
			and
			(date_format(date_create($rsold["Kontrak_Tgl"]),"Ym") <> $GLOBALS["Periode"])
			) {
			$this->setFailureMessage("Tanggal Transaksi tidak sesuai dengan Periode saat ini");
			return false;
		}
		$rsnew["Periode"] = $GLOBALS["Periode"];

		//$rsnew["Kontrak_No"] = GetNextNoKontrak(); // mengantisipasi lebih satu user menginput data saat bersamaan
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		f_create_rincian_angsuran($rsnew);

		//f_simpan_jurnal_transaksi($rsnew);
		//f_buat_jurnal($rsnew);
		// kodetransaksi = 01

		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '01'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '01'");

		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekdebet, $rsnew["Pinjaman"], 0, "Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);
		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekkredit, 0, $rsnew["Pinjaman"], "Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);

		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".PINJ", $rekdebet, $rsnew["Pinjaman"], 0, "Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);
		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".PINJ", $rekkredit, 0, $rsnew["Pinjaman"], "Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);

		// kodetransaksi = 02
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '02'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '02'");

		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekdebet, $rsnew["Biaya_Administrasi"], 0, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);
		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekkredit, 0, $rsnew["Biaya_Administrasi"], "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);

		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".ADM", $rekdebet, $rsnew["Biaya_Administrasi"], 0, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);
		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".ADM", $rekkredit, 0, $rsnew["Biaya_Administrasi"], "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);

		// kodetransaksi = 03
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '03'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '03'");

		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekdebet, $rsnew["Biaya_Materai"], 0, "Pendapatan Materai Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);
		//f_buatjurnal($rsnew["Periode"], $rsnew["Kontrak_No"], $rekkredit, 0, $rsnew["Biaya_Materai"], "Pendapatan Materai Pinjaman No. Kontrak ".$rsnew["Kontrak_No"]);

		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".MAT", $rekdebet, $rsnew["Biaya_Materai"], 0, "Pendapatan Materai Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);
		f_buatjurnal($rsnew["Periode"], $rsnew["id"].".MAT", $rekkredit, 0, $rsnew["Biaya_Materai"], "Pendapatan Materai Pinjaman No. Kontrak ".$rsnew["Kontrak_No"], $rsnew["Kontrak_Tgl"]);
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		if (
			(date_format(date_create($rsnew["Kontrak_Tgl"]),"Ym") <> $GLOBALS["Periode"])
			and
			(date_format(date_create($rsold["Kontrak_Tgl"]),"Ym") <> $GLOBALS["Periode"])
			) {
			$this->setFailureMessage("Tanggal Transaksi tidak sesuai dengan Periode saat ini");
			return false;
		}
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		//echo $rsold["id"]." - ".$rsnew["id"]; exit;
		// hapus data rincian angsuran yang lama

		$q = "delete from t04_pinjamanangsurantemp where pinjaman_id = ".$rsold["id"]."";
		ew_Execute($q);

		//$rsupdate = array();
		$rsupdate["id"] = $rsold["id"];
		$rsupdate["Kontrak_Tgl"] = ($rsold["Kontrak_Tgl"] <> $rsnew["Kontrak_Tgl"]) ? $rsnew["Kontrak_Tgl"] : $rsold["Kontrak_Tgl"];
		$rsupdate["Angsuran_Pokok"] = ($rsold["Angsuran_Pokok"] <> $rsnew["Angsuran_Pokok"]) ? $rsnew["Angsuran_Pokok"] : $rsold["Angsuran_Pokok"];
		$rsupdate["Angsuran_Bunga"] = ($rsold["Angsuran_Bunga"] <> $rsnew["Angsuran_Bunga"]) ? $rsnew["Angsuran_Bunga"] : $rsold["Angsuran_Bunga"];
		$rsupdate["Pinjaman"] = ($rsold["Pinjaman"] <> $rsnew["Pinjaman"]) ? $rsnew["Pinjaman"] : $rsold["Pinjaman"];
		$rsupdate["Angsuran_Lama"] = ($rsold["Angsuran_Lama"] <> $rsnew["Angsuran_Lama"]) ? $rsnew["Angsuran_Lama"] : $rsold["Angsuran_Lama"];
		$rsupdate["Angsuran_Lama"] = ($rsold["Angsuran_Lama"] <> $rsnew["Angsuran_Lama"]) ? $rsnew["Angsuran_Lama"] : $rsold["Angsuran_Lama"];
		$rsupdate["Biaya_Administrasi"] = ($rsold["Biaya_Administrasi"] <> $rsnew["Biaya_Administrasi"]) ? $rsnew["Biaya_Administrasi"] : $rsold["Biaya_Administrasi"];
		$rsupdate["Biaya_Materai"] = ($rsold["Biaya_Materai"] <> $rsnew["Biaya_Materai"]) ? $rsnew["Biaya_Materai"] : $rsold["Biaya_Materai"];
		$rsupdate["Kontrak_No"] = ($rsold["Kontrak_No"] <> $rsnew["Kontrak_No"]) ? $rsnew["Kontrak_No"] : $rsold["Kontrak_No"];

		//$rsnew["Alamat"] = ($rsold["Alamat"] <> $rsnew["Alamat"]) ? $rsnew["Alamat"] : $rsold["Alamat"];
		//f_create_rincian_angsuran($rsnew);

		f_create_rincian_angsuran($rsupdate);

		// kodetransaksi = 01
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '01'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '01'");
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".PINJ", $rekdebet, "Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".PINJ", $rekdebet, $rsupdate["Pinjaman"], 0, "Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".PINJ", $rekkredit, "Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".PINJ", $rekkredit, 0, $rsupdate["Pinjaman"], "Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);

		// kodetransaksi = 02
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '02'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '02'");
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".ADM", $rekdebet, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".ADM", $rekdebet, $rsupdate["Biaya_Administrasi"], 0, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".ADM", $rekkredit, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".ADM", $rekkredit, 0, $rsupdate["Biaya_Administrasi"], "Pendapatan Administrasi Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);

		// kodetransaksi = 03
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '03'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '03'");
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".MAT", $rekdebet, "Pendapatan Materai Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".MAT", $rekdebet, $rsupdate["Biaya_Materai"], 0, "Pendapatan Materai Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);
		f_hapusjurnal($rsold["Periode"], $rsold["id"].".MAT", $rekkredit, "Pendapatan Materai Pinjaman No. Kontrak ".$rsold["Kontrak_No"]);
		f_buatjurnal($rsold["Periode"], $rsold["id"].".MAT", $rekkredit, 0, $rsupdate["Biaya_Materai"], "Pendapatan Materai Pinjaman No. Kontrak ".$rsupdate["Kontrak_No"], $rsupdate["Kontrak_Tgl"]);
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
		// kodetransaksi = 01

		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '01'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '01'");
		f_hapusjurnal($rs["Periode"], $rs["id"].".PINJ", $rekdebet, "Pinjaman No. Kontrak ".$rs["Kontrak_No"]);
		f_hapusjurnal($rs["Periode"], $rs["id"].".PINJ", $rekkredit, "Pinjaman No. Kontrak ".$rs["Kontrak_No"]);

		// kodetransaksi = 02
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '02'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '02'");
		f_hapusjurnal($rs["Periode"], $rs["id"].".ADM", $rekdebet, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rs["Kontrak_No"]);
		f_hapusjurnal($rs["Periode"], $rs["id"].".ADM", $rekkredit, "Pendapatan Administrasi Pinjaman No. Kontrak ".$rs["Kontrak_No"]);

		// kodetransaksi = 03
		$rekdebet  = ew_ExecuteScalar("select DebetRekening from t89_rektran where KodeTransaksi = '03'");
		$rekkredit = ew_ExecuteScalar("select KreditRekening from t89_rektran where KodeTransaksi = '03'");
		f_hapusjurnal($rs["Periode"], $rs["id"].".MAT", $rekdebet, "Pendapatan Materai Pinjaman No. Kontrak ".$rs["Kontrak_No"]);
		f_hapusjurnal($rs["Periode"], $rs["id"].".MAT", $rekkredit, "Pendapatan Materai Pinjaman No. Kontrak ".$rs["Kontrak_No"]);
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);
		//if ($this->PageID == "list") {

		if (CurrentPageID() == "list") {
			$q = "select * from t03_pinjaman order by Kontrak_No desc";
			$r = Conn()->Execute($q);
			$this->Kontrak_No->EditValue = $r->fields["Kontrak_No"];
			if (isset($_GET["x_Kontrak_No"])) {
				$this->Kontrak_No->EditValue = $_GET["x_Kontrak_No"];
			}
		}

		// Kondisi saat form Tambah sedang terbuka (tidak dalam mode konfirmasi)
		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {

			// users meng-klik icon COPY
			if (isset($_GET["id"])) {

				//echo "id ".$_GET["id"];
				// proses copy

				$this->Kontrak_No->CurrentValue = GetNextNoKontrakCopy($_GET["id"]); // trik
			}
			else {
				$this->Kontrak_No->CurrentValue = GetNextNoKontrak(); // trik
			}
			$this->Kontrak_No->EditValue = $this->Kontrak_No->CurrentValue; // tampilkan

			//$this->Kode->ReadOnly = TRUE; // supaya tidak bisa diubah
			if (isset($_GET["id"])) {

				//echo "id ".$_GET["id"];
				// proses copy

			}
		}

		// Kondisi saat form Tambah sedang dalam mode konfirmasi
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->Kontrak_No->ViewValue = $this->Kontrak_No->CurrentValue; // ambil dari mode sebelumnya
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
