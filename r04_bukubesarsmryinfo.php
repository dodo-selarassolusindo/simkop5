<?php

// Global variable for table object
$r04_bukubesar = NULL;

//
// Table class for r04_bukubesar
//
class crr04_bukubesar extends crTableBase {
	var $ShowGroupHeaderAsRow = TRUE;
	var $ShowCompactSummaryFooter = TRUE;
	var $id;
	var $Periode;
	var $Tanggal;
	var $Rekening;
	var $RekeningNama;
	var $Keterangan;
	var $Debet;
	var $Kredit;
	var $NomorTransaksi;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage, $gsLanguage;
		$this->TableVar = 'r04_bukubesar';
		$this->TableName = 'r04_bukubesar';
		$this->TableType = 'REPORT';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// id
		$this->id = new crField('r04_bukubesar', 'r04_bukubesar', 'x_id', 'id', '`id`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;
		$this->id->DateFilter = "";
		$this->id->SqlSelect = "";
		$this->id->SqlOrderBy = "";

		// Periode
		$this->Periode = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Periode', 'Periode', '`Periode`', 200, EWR_DATATYPE_STRING, -1);
		$this->Periode->Sortable = TRUE; // Allow sort
		$this->Periode->GroupingFieldId = 1;
		$this->Periode->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->Periode->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['Periode'] = &$this->Periode;
		$this->Periode->DateFilter = "";
		$this->Periode->SqlSelect = "";
		$this->Periode->SqlOrderBy = "";
		$this->Periode->FldGroupByType = "";
		$this->Periode->FldGroupInt = "0";
		$this->Periode->FldGroupSql = "";

		// Tanggal
		$this->Tanggal = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Tanggal', 'Tanggal', '`Tanggal`', 133, EWR_DATATYPE_DATE, 7);
		$this->Tanggal->Sortable = TRUE; // Allow sort
		$this->Tanggal->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectField");
		$this->fields['Tanggal'] = &$this->Tanggal;
		$this->Tanggal->DateFilter = "";
		$this->Tanggal->SqlSelect = "";
		$this->Tanggal->SqlOrderBy = "";

		// Rekening
		$this->Rekening = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Rekening', 'Rekening', '`Rekening`', 200, EWR_DATATYPE_STRING, -1);
		$this->Rekening->Sortable = TRUE; // Allow sort
		$this->fields['Rekening'] = &$this->Rekening;
		$this->Rekening->DateFilter = "";
		$this->Rekening->SqlSelect = "";
		$this->Rekening->SqlOrderBy = "";

		// RekeningNama
		$this->RekeningNama = new crField('r04_bukubesar', 'r04_bukubesar', 'x_RekeningNama', 'RekeningNama', '(select rekening from t91_rekening where t91_rekening.id = t10_jurnal.Rekening)', 200, EWR_DATATYPE_STRING, -1);
		$this->RekeningNama->FldIsCustom = TRUE; // Custom field
		$this->RekeningNama->Sortable = TRUE; // Allow sort
		$this->RekeningNama->GroupingFieldId = 2;
		$this->RekeningNama->ShowGroupHeaderAsRow = $this->ShowGroupHeaderAsRow;
		$this->RekeningNama->ShowCompactSummaryFooter = $this->ShowCompactSummaryFooter;
		$this->fields['RekeningNama'] = &$this->RekeningNama;
		$this->RekeningNama->DateFilter = "";
		$this->RekeningNama->SqlSelect = "";
		$this->RekeningNama->SqlOrderBy = "";
		$this->RekeningNama->FldGroupByType = "";
		$this->RekeningNama->FldGroupInt = "0";
		$this->RekeningNama->FldGroupSql = "";

		// Keterangan
		$this->Keterangan = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Keterangan', 'Keterangan', '`Keterangan`', 200, EWR_DATATYPE_STRING, -1);
		$this->Keterangan->Sortable = TRUE; // Allow sort
		$this->fields['Keterangan'] = &$this->Keterangan;
		$this->Keterangan->DateFilter = "";
		$this->Keterangan->SqlSelect = "";
		$this->Keterangan->SqlOrderBy = "";

		// Debet
		$this->Debet = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Debet', 'Debet', '`Debet`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Debet->Sortable = TRUE; // Allow sort
		$this->Debet->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Debet'] = &$this->Debet;
		$this->Debet->DateFilter = "";
		$this->Debet->SqlSelect = "";
		$this->Debet->SqlOrderBy = "";

		// Kredit
		$this->Kredit = new crField('r04_bukubesar', 'r04_bukubesar', 'x_Kredit', 'Kredit', '`Kredit`', 4, EWR_DATATYPE_NUMBER, -1);
		$this->Kredit->Sortable = TRUE; // Allow sort
		$this->Kredit->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Kredit'] = &$this->Kredit;
		$this->Kredit->DateFilter = "";
		$this->Kredit->SqlSelect = "";
		$this->Kredit->SqlOrderBy = "";

		// NomorTransaksi
		$this->NomorTransaksi = new crField('r04_bukubesar', 'r04_bukubesar', 'x_NomorTransaksi', 'NomorTransaksi', '`NomorTransaksi`', 200, EWR_DATATYPE_STRING, -1);
		$this->NomorTransaksi->Sortable = TRUE; // Allow sort
		$this->fields['NomorTransaksi'] = &$this->NomorTransaksi;
		$this->NomorTransaksi->DateFilter = "";
		$this->NomorTransaksi->SqlSelect = "";
		$this->NomorTransaksi->SqlOrderBy = "";
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
			if ($ofld->GroupingFieldId == 0) {
				if ($ctrl) {
					$sOrderBy = $this->getDetailOrderBy();
					if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
						$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
					} else {
						if ($sOrderBy <> "") $sOrderBy .= ", ";
						$sOrderBy .= $sSortField . " " . $sThisSort;
					}
					$this->setDetailOrderBy($sOrderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sSortField . " " . $sThisSort); // Save to Session
				}
			}
		} else {
			if ($ofld->GroupingFieldId == 0 && !$ctrl) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->FldExpression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t10_jurnal`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, (select rekening from t91_rekening where t91_rekening.id = t10_jurnal.Rekening) AS `RekeningNama` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Periode` ASC, (select rekening from t91_rekening where t91_rekening.id = t10_jurnal.Rekening) ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Table Level Group SQL
	// First Group Field

	var $_SqlFirstGroupField = "";

	function getSqlFirstGroupField() {
		return ($this->_SqlFirstGroupField <> "") ? $this->_SqlFirstGroupField : "`Periode`";
	}

	function SqlFirstGroupField() { // For backward compatibility
		return $this->getSqlFirstGroupField();
	}

	function setSqlFirstGroupField($v) {
		$this->_SqlFirstGroupField = $v;
	}

	// Select Group
	var $_SqlSelectGroup = "";

	function getSqlSelectGroup() {
		return ($this->_SqlSelectGroup <> "") ? $this->_SqlSelectGroup : "SELECT DISTINCT " . $this->getSqlFirstGroupField() . " FROM " . $this->getSqlFrom();
	}

	function SqlSelectGroup() { // For backward compatibility
		return $this->getSqlSelectGroup();
	}

	function setSqlSelectGroup($v) {
		$this->_SqlSelectGroup = $v;
	}

	// Order By Group
	var $_SqlOrderByGroup = "";

	function getSqlOrderByGroup() {
		return ($this->_SqlOrderByGroup <> "") ? $this->_SqlOrderByGroup : "`Periode` ASC";
	}

	function SqlOrderByGroup() { // For backward compatibility
		return $this->getSqlOrderByGroup();
	}

	function setSqlOrderByGroup($v) {
		$this->_SqlOrderByGroup = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT SUM(`Debet`) AS `sum_debet`, SUM(`Kredit`) AS `sum_kredit` FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {

			//$sUrlParm = "order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort();
			$sUrlParm = "order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort();
			return ewr_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		case "x_Periode":
			$sSqlWrk = "";
		$sSqlWrk = "SELECT DISTINCT `Periode`, `Periode` AS `DispFld`, '' AS `DispFld2`, '' AS `DispFld3`, '' AS `DispFld4` FROM `t10_jurnal`";
		$sWhereWrk = "";
		$this->Periode->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "DB", "f0" => '`Periode` = {filter_value}', "t0" => "200", "fn0" => "", "dlm" => ewr_Encrypt($fld->FldDelimiter));
			$sSqlWrk = "";
		$this->Lookup_Selecting($this->Periode, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Periode` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld) {
		global $gsLanguage;
		switch ($fld->FldVar) {
		}
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

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

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
