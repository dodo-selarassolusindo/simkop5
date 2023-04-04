<?php

// Global variable for table object
$t91_rekening = NULL;

//
// Table class for t91_rekening
//
class ct91_rekening extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $group;
	var $id;
	var $id1;
	var $id2;
	var $parent;
	var $id3;
	var $rekening;
	var $posisi;
	var $laporan;
	var $keterangan;
	var $tipe;
	var $status;
	var $active;
	var $group2;
	var $Saldo;
	var $Periode;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't91_rekening';
		$this->TableName = 't91_rekening';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t91_rekening`";
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
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 2;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// group
		$this->group = new cField('t91_rekening', 't91_rekening', 'x_group', 'group', '`group`', '`group`', 20, -1, FALSE, '`group`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->group->Sortable = TRUE; // Allow sort
		$this->group->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->group->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->group->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['group'] = &$this->group;

		// id
		$this->id = new cField('t91_rekening', 't91_rekening', 'x_id', 'id', '`id`', '`id`', 200, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id->Sortable = TRUE; // Allow sort
		$this->fields['id'] = &$this->id;

		// id1
		$this->id1 = new cField('t91_rekening', 't91_rekening', 'x_id1', 'id1', 'case when length(parent) = 1 then id else \'\' end', 'case when length(parent) = 1 then id else \'\' end', 200, -1, FALSE, 'case when length(parent) = 1 then id else \'\' end', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id1->FldIsCustom = TRUE; // Custom field
		$this->id1->Sortable = TRUE; // Allow sort
		$this->fields['id1'] = &$this->id1;

		// id2
		$this->id2 = new cField('t91_rekening', 't91_rekening', 'x_id2', 'id2', 'case when length(parent) > 1 then id else \'\' end', 'case when length(parent) > 1 then id else \'\' end', 200, -1, FALSE, 'case when length(parent) > 1 then id else \'\' end', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id2->FldIsCustom = TRUE; // Custom field
		$this->id2->Sortable = TRUE; // Allow sort
		$this->fields['id2'] = &$this->id2;

		// parent
		$this->parent = new cField('t91_rekening', 't91_rekening', 'x_parent', 'parent', '`parent`', '`parent`', 200, -1, FALSE, '`parent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->parent->Sortable = TRUE; // Allow sort
		$this->parent->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->parent->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['parent'] = &$this->parent;

		// id3
		$this->id3 = new cField('t91_rekening', 't91_rekening', 'x_id3', 'id3', 'id', 'id', 200, -1, FALSE, 'id', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id3->FldIsCustom = TRUE; // Custom field
		$this->id3->Sortable = TRUE; // Allow sort
		$this->fields['id3'] = &$this->id3;

		// rekening
		$this->rekening = new cField('t91_rekening', 't91_rekening', 'x_rekening', 'rekening', '`rekening`', '`rekening`', 200, -1, FALSE, '`rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rekening->Sortable = TRUE; // Allow sort
		$this->fields['rekening'] = &$this->rekening;

		// posisi
		$this->posisi = new cField('t91_rekening', 't91_rekening', 'x_posisi', 'posisi', '`posisi`', '`posisi`', 200, -1, FALSE, '`posisi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->posisi->Sortable = TRUE; // Allow sort
		$this->fields['posisi'] = &$this->posisi;

		// laporan
		$this->laporan = new cField('t91_rekening', 't91_rekening', 'x_laporan', 'laporan', '`laporan`', '`laporan`', 200, -1, FALSE, '`laporan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->laporan->Sortable = TRUE; // Allow sort
		$this->fields['laporan'] = &$this->laporan;

		// keterangan
		$this->keterangan = new cField('t91_rekening', 't91_rekening', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// tipe
		$this->tipe = new cField('t91_rekening', 't91_rekening', 'x_tipe', 'tipe', '`tipe`', '`tipe`', 200, -1, FALSE, '`tipe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->tipe->Sortable = TRUE; // Allow sort
		$this->tipe->OptionCount = 2;
		$this->fields['tipe'] = &$this->tipe;

		// status
		$this->status = new cField('t91_rekening', 't91_rekening', 'x_status', 'status', '`status`', '`status`', 200, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->OptionCount = 1;
		$this->fields['status'] = &$this->status;

		// active
		$this->active = new cField('t91_rekening', 't91_rekening', 'x_active', 'active', '`active`', '`active`', 202, -1, FALSE, '`active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->active->Sortable = TRUE; // Allow sort
		$this->active->OptionCount = 2;
		$this->fields['active'] = &$this->active;

		// group2
		$this->group2 = new cField('t91_rekening', 't91_rekening', 'x_group2', 'group2', 'substring(id,1,1)', 'substring(id,1,1)', 200, -1, FALSE, 'substring(id,1,1)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->group2->FldIsCustom = TRUE; // Custom field
		$this->group2->Sortable = TRUE; // Allow sort
		$this->fields['group2'] = &$this->group2;

		// Saldo
		$this->Saldo = new cField('t91_rekening', 't91_rekening', 'x_Saldo', 'Saldo', '`Saldo`', '`Saldo`', 4, -1, FALSE, '`Saldo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Saldo->Sortable = TRUE; // Allow sort
		$this->Saldo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Saldo'] = &$this->Saldo;

		// Periode
		$this->Periode = new cField('t91_rekening', 't91_rekening', 'x_Periode', 'Periode', '`Periode`', '`Periode`', 200, -1, FALSE, '`Periode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Periode->Sortable = TRUE; // Allow sort
		$this->fields['Periode'] = &$this->Periode;
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
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t91_rekening`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, case when length(parent) = 1 then id else '' end AS `id1`, case when length(parent) > 1 then id else '' end AS `id2`, id AS `id3`, substring(id,1,1) AS `group2` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "`tipe` <> 'GROUP'";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`id` ASC";
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
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
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
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = '@id@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "t91_rekeninglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t91_rekeninglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t91_rekeningview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t91_rekeningview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t91_rekeningadd.php?" . $this->UrlParm($parm);
		else
			$url = "t91_rekeningadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t91_rekeningedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t91_rekeningadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t91_rekeningdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "string", "'");
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id1
		$this->id1->LinkCustomAttributes = "";
		$this->id1->HrefValue = "";
		$this->id1->TooltipValue = "";

		// id2
		$this->id2->LinkCustomAttributes = "";
		$this->id2->HrefValue = "";
		$this->id2->TooltipValue = "";

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

		// posisi
		$this->posisi->LinkCustomAttributes = "";
		$this->posisi->HrefValue = "";
		$this->posisi->TooltipValue = "";

		// laporan
		$this->laporan->LinkCustomAttributes = "";
		$this->laporan->HrefValue = "";
		$this->laporan->TooltipValue = "";

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

		// active
		$this->active->LinkCustomAttributes = "";
		$this->active->HrefValue = "";
		$this->active->TooltipValue = "";

		// group2
		$this->group2->LinkCustomAttributes = "";
		$this->group2->HrefValue = "";
		$this->group2->TooltipValue = "";

		// Saldo
		$this->Saldo->LinkCustomAttributes = "";
		$this->Saldo->HrefValue = "";
		$this->Saldo->TooltipValue = "";

		// Periode
		$this->Periode->LinkCustomAttributes = "";
		$this->Periode->HrefValue = "";
		$this->Periode->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// group
		$this->group->EditAttrs["class"] = "form-control";
		$this->group->EditCustomAttributes = "";
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
				$this->group->EditValue = $this->group->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->group->EditValue = $this->group->CurrentValue;
			}
		} else {
			$this->group->EditValue = NULL;
		}
		$this->group->ViewCustomAttributes = "";

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id1
		$this->id1->EditAttrs["class"] = "form-control";
		$this->id1->EditCustomAttributes = "";
		$this->id1->EditValue = $this->id1->CurrentValue;
		$this->id1->PlaceHolder = ew_RemoveHtml($this->id1->FldCaption());

		// id2
		$this->id2->EditAttrs["class"] = "form-control";
		$this->id2->EditCustomAttributes = "";
		$this->id2->EditValue = $this->id2->CurrentValue;
		$this->id2->PlaceHolder = ew_RemoveHtml($this->id2->FldCaption());

		// parent
		$this->parent->EditAttrs["class"] = "form-control";
		$this->parent->EditCustomAttributes = "";

		// id3
		$this->id3->EditAttrs["class"] = "form-control";
		$this->id3->EditCustomAttributes = "";
		$this->id3->EditValue = $this->id3->CurrentValue;
		$this->id3->PlaceHolder = ew_RemoveHtml($this->id3->FldCaption());

		// rekening
		$this->rekening->EditAttrs["class"] = "form-control";
		$this->rekening->EditCustomAttributes = "";
		$this->rekening->EditValue = $this->rekening->CurrentValue;
		$this->rekening->PlaceHolder = ew_RemoveHtml($this->rekening->FldCaption());

		// posisi
		$this->posisi->EditAttrs["class"] = "form-control";
		$this->posisi->EditCustomAttributes = "";
		$this->posisi->EditValue = $this->posisi->CurrentValue;
		$this->posisi->PlaceHolder = ew_RemoveHtml($this->posisi->FldCaption());

		// laporan
		$this->laporan->EditAttrs["class"] = "form-control";
		$this->laporan->EditCustomAttributes = "";
		$this->laporan->EditValue = $this->laporan->CurrentValue;
		$this->laporan->PlaceHolder = ew_RemoveHtml($this->laporan->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// tipe
		$this->tipe->EditCustomAttributes = "";
		$this->tipe->EditValue = $this->tipe->Options(FALSE);

		// status
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(FALSE);

		// active
		$this->active->EditCustomAttributes = "";
		$this->active->EditValue = $this->active->Options(FALSE);

		// group2
		$this->group2->EditAttrs["class"] = "form-control";
		$this->group2->EditCustomAttributes = "";
		$this->group2->EditValue = $this->group2->CurrentValue;
		$this->group2->PlaceHolder = ew_RemoveHtml($this->group2->FldCaption());

		// Saldo
		$this->Saldo->EditAttrs["class"] = "form-control";
		$this->Saldo->EditCustomAttributes = "";
		$this->Saldo->EditValue = $this->Saldo->CurrentValue;
		$this->Saldo->PlaceHolder = ew_RemoveHtml($this->Saldo->FldCaption());
		if (strval($this->Saldo->EditValue) <> "" && is_numeric($this->Saldo->EditValue)) $this->Saldo->EditValue = ew_FormatNumber($this->Saldo->EditValue, -2, -2, -2, -2);

		// Periode
		$this->Periode->EditAttrs["class"] = "form-control";
		$this->Periode->EditCustomAttributes = "";
		$this->Periode->EditValue = $this->Periode->CurrentValue;
		$this->Periode->PlaceHolder = ew_RemoveHtml($this->Periode->FldCaption());

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
					if ($this->group->Exportable) $Doc->ExportCaption($this->group);
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id1->Exportable) $Doc->ExportCaption($this->id1);
					if ($this->id2->Exportable) $Doc->ExportCaption($this->id2);
					if ($this->parent->Exportable) $Doc->ExportCaption($this->parent);
					if ($this->id3->Exportable) $Doc->ExportCaption($this->id3);
					if ($this->rekening->Exportable) $Doc->ExportCaption($this->rekening);
					if ($this->posisi->Exportable) $Doc->ExportCaption($this->posisi);
					if ($this->laporan->Exportable) $Doc->ExportCaption($this->laporan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->tipe->Exportable) $Doc->ExportCaption($this->tipe);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->active->Exportable) $Doc->ExportCaption($this->active);
					if ($this->group2->Exportable) $Doc->ExportCaption($this->group2);
					if ($this->Saldo->Exportable) $Doc->ExportCaption($this->Saldo);
					if ($this->Periode->Exportable) $Doc->ExportCaption($this->Periode);
				} else {
					if ($this->group->Exportable) $Doc->ExportCaption($this->group);
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id1->Exportable) $Doc->ExportCaption($this->id1);
					if ($this->id2->Exportable) $Doc->ExportCaption($this->id2);
					if ($this->parent->Exportable) $Doc->ExportCaption($this->parent);
					if ($this->id3->Exportable) $Doc->ExportCaption($this->id3);
					if ($this->rekening->Exportable) $Doc->ExportCaption($this->rekening);
					if ($this->posisi->Exportable) $Doc->ExportCaption($this->posisi);
					if ($this->laporan->Exportable) $Doc->ExportCaption($this->laporan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->tipe->Exportable) $Doc->ExportCaption($this->tipe);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->active->Exportable) $Doc->ExportCaption($this->active);
					if ($this->group2->Exportable) $Doc->ExportCaption($this->group2);
					if ($this->Saldo->Exportable) $Doc->ExportCaption($this->Saldo);
					if ($this->Periode->Exportable) $Doc->ExportCaption($this->Periode);
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
						if ($this->group->Exportable) $Doc->ExportField($this->group);
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id1->Exportable) $Doc->ExportField($this->id1);
						if ($this->id2->Exportable) $Doc->ExportField($this->id2);
						if ($this->parent->Exportable) $Doc->ExportField($this->parent);
						if ($this->id3->Exportable) $Doc->ExportField($this->id3);
						if ($this->rekening->Exportable) $Doc->ExportField($this->rekening);
						if ($this->posisi->Exportable) $Doc->ExportField($this->posisi);
						if ($this->laporan->Exportable) $Doc->ExportField($this->laporan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->tipe->Exportable) $Doc->ExportField($this->tipe);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->active->Exportable) $Doc->ExportField($this->active);
						if ($this->group2->Exportable) $Doc->ExportField($this->group2);
						if ($this->Saldo->Exportable) $Doc->ExportField($this->Saldo);
						if ($this->Periode->Exportable) $Doc->ExportField($this->Periode);
					} else {
						if ($this->group->Exportable) $Doc->ExportField($this->group);
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id1->Exportable) $Doc->ExportField($this->id1);
						if ($this->id2->Exportable) $Doc->ExportField($this->id2);
						if ($this->parent->Exportable) $Doc->ExportField($this->parent);
						if ($this->id3->Exportable) $Doc->ExportField($this->id3);
						if ($this->rekening->Exportable) $Doc->ExportField($this->rekening);
						if ($this->posisi->Exportable) $Doc->ExportField($this->posisi);
						if ($this->laporan->Exportable) $Doc->ExportField($this->laporan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->tipe->Exportable) $Doc->ExportField($this->tipe);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->active->Exportable) $Doc->ExportField($this->active);
						if ($this->group2->Exportable) $Doc->ExportField($this->group2);
						if ($this->Saldo->Exportable) $Doc->ExportField($this->Saldo);
						if ($this->Periode->Exportable) $Doc->ExportField($this->Periode);
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
		$table = 't91_rekening';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't91_rekening';

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
		$table = 't91_rekening';

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
		$table = 't91_rekening';

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
		// ambil nilai KODE REKENING

		if ($rsnew["id3"] <> "") {
			$rsnew["id"] = $rsnew["id3"];
		}

		// ambil nilai POSISI
		$q = "select posisi from t91_rekening where `group` = ".$rsnew["group"]."";
		$rsnew["posisi"] = ew_ExecuteScalar($q);

		// ambil nilai LAPORAN
		$q = "select laporan from t91_rekening where `group` = ".$rsnew["group"]."";
		$rsnew["laporan"] = ew_ExecuteScalar($q);
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE
		// ambil nilai KODE REKENING

		if ($rsnew["id3"] <> "") {
			$rsnew["id"] = $rsnew["id3"];
		}
		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
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

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
