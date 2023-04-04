<?php include_once "t96_employeesinfo.php" ?>
<?php

// Create page object
if (!isset($t12_jurnaldetail_grid)) $t12_jurnaldetail_grid = new ct12_jurnaldetail_grid();

// Page init
$t12_jurnaldetail_grid->Page_Init();

// Page main
$t12_jurnaldetail_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t12_jurnaldetail_grid->Page_Render();
?>
<?php if ($t12_jurnaldetail->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft12_jurnaldetailgrid = new ew_Form("ft12_jurnaldetailgrid", "grid");
ft12_jurnaldetailgrid.FormKeyCountName = '<?php echo $t12_jurnaldetail_grid->FormKeyCountName ?>';

// Validate form
ft12_jurnaldetailgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Rekening");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t12_jurnaldetail->Rekening->FldCaption(), $t12_jurnaldetail->Rekening->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t12_jurnaldetail->Debet->FldCaption(), $t12_jurnaldetail->Debet->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Debet");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t12_jurnaldetail->Debet->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t12_jurnaldetail->Kredit->FldCaption(), $t12_jurnaldetail->Kredit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Kredit");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t12_jurnaldetail->Kredit->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft12_jurnaldetailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Rekening", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Debet", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Kredit", false)) return false;
	return true;
}

// Form_CustomValidate event
ft12_jurnaldetailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft12_jurnaldetailgrid.ValidateRequired = true;
<?php } else { ?>
ft12_jurnaldetailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft12_jurnaldetailgrid.Lists["x_Rekening"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_rekening","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t91_rekening"};

// Form object for search
</script>
<?php } ?>
<?php
if ($t12_jurnaldetail->CurrentAction == "gridadd") {
	if ($t12_jurnaldetail->CurrentMode == "copy") {
		$bSelectLimit = $t12_jurnaldetail_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t12_jurnaldetail_grid->TotalRecs = $t12_jurnaldetail->SelectRecordCount();
			$t12_jurnaldetail_grid->Recordset = $t12_jurnaldetail_grid->LoadRecordset($t12_jurnaldetail_grid->StartRec-1, $t12_jurnaldetail_grid->DisplayRecs);
		} else {
			if ($t12_jurnaldetail_grid->Recordset = $t12_jurnaldetail_grid->LoadRecordset())
				$t12_jurnaldetail_grid->TotalRecs = $t12_jurnaldetail_grid->Recordset->RecordCount();
		}
		$t12_jurnaldetail_grid->StartRec = 1;
		$t12_jurnaldetail_grid->DisplayRecs = $t12_jurnaldetail_grid->TotalRecs;
	} else {
		$t12_jurnaldetail->CurrentFilter = "0=1";
		$t12_jurnaldetail_grid->StartRec = 1;
		$t12_jurnaldetail_grid->DisplayRecs = $t12_jurnaldetail->GridAddRowCount;
	}
	$t12_jurnaldetail_grid->TotalRecs = $t12_jurnaldetail_grid->DisplayRecs;
	$t12_jurnaldetail_grid->StopRec = $t12_jurnaldetail_grid->DisplayRecs;
} else {
	$bSelectLimit = $t12_jurnaldetail_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t12_jurnaldetail_grid->TotalRecs <= 0)
			$t12_jurnaldetail_grid->TotalRecs = $t12_jurnaldetail->SelectRecordCount();
	} else {
		if (!$t12_jurnaldetail_grid->Recordset && ($t12_jurnaldetail_grid->Recordset = $t12_jurnaldetail_grid->LoadRecordset()))
			$t12_jurnaldetail_grid->TotalRecs = $t12_jurnaldetail_grid->Recordset->RecordCount();
	}
	$t12_jurnaldetail_grid->StartRec = 1;
	$t12_jurnaldetail_grid->DisplayRecs = $t12_jurnaldetail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t12_jurnaldetail_grid->Recordset = $t12_jurnaldetail_grid->LoadRecordset($t12_jurnaldetail_grid->StartRec-1, $t12_jurnaldetail_grid->DisplayRecs);

	// Set no record found message
	if ($t12_jurnaldetail->CurrentAction == "" && $t12_jurnaldetail_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t12_jurnaldetail_grid->setWarningMessage(ew_DeniedMsg());
		if ($t12_jurnaldetail_grid->SearchWhere == "0=101")
			$t12_jurnaldetail_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t12_jurnaldetail_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t12_jurnaldetail_grid->RenderOtherOptions();
?>
<?php $t12_jurnaldetail_grid->ShowPageHeader(); ?>
<?php
$t12_jurnaldetail_grid->ShowMessage();
?>
<?php if ($t12_jurnaldetail_grid->TotalRecs > 0 || $t12_jurnaldetail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t12_jurnaldetail">
<div id="ft12_jurnaldetailgrid" class="ewForm form-inline">
<div id="gmp_t12_jurnaldetail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_t12_jurnaldetailgrid" class="table ewTable">
<?php echo $t12_jurnaldetail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t12_jurnaldetail_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t12_jurnaldetail_grid->RenderListOptions();

// Render list options (header, left)
$t12_jurnaldetail_grid->ListOptions->Render("header", "left");
?>
<?php if ($t12_jurnaldetail->Rekening->Visible) { // Rekening ?>
	<?php if ($t12_jurnaldetail->SortUrl($t12_jurnaldetail->Rekening) == "") { ?>
		<th data-name="Rekening"><div id="elh_t12_jurnaldetail_Rekening" class="t12_jurnaldetail_Rekening"><div class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Rekening"><div><div id="elh_t12_jurnaldetail_Rekening" class="t12_jurnaldetail_Rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Rekening->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t12_jurnaldetail->Rekening->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t12_jurnaldetail->Rekening->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t12_jurnaldetail->Debet->Visible) { // Debet ?>
	<?php if ($t12_jurnaldetail->SortUrl($t12_jurnaldetail->Debet) == "") { ?>
		<th data-name="Debet"><div id="elh_t12_jurnaldetail_Debet" class="t12_jurnaldetail_Debet"><div class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Debet->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Debet"><div><div id="elh_t12_jurnaldetail_Debet" class="t12_jurnaldetail_Debet">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Debet->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t12_jurnaldetail->Debet->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t12_jurnaldetail->Debet->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t12_jurnaldetail->Kredit->Visible) { // Kredit ?>
	<?php if ($t12_jurnaldetail->SortUrl($t12_jurnaldetail->Kredit) == "") { ?>
		<th data-name="Kredit"><div id="elh_t12_jurnaldetail_Kredit" class="t12_jurnaldetail_Kredit"><div class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Kredit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Kredit"><div><div id="elh_t12_jurnaldetail_Kredit" class="t12_jurnaldetail_Kredit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t12_jurnaldetail->Kredit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t12_jurnaldetail->Kredit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t12_jurnaldetail->Kredit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t12_jurnaldetail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t12_jurnaldetail_grid->StartRec = 1;
$t12_jurnaldetail_grid->StopRec = $t12_jurnaldetail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t12_jurnaldetail_grid->FormKeyCountName) && ($t12_jurnaldetail->CurrentAction == "gridadd" || $t12_jurnaldetail->CurrentAction == "gridedit" || $t12_jurnaldetail->CurrentAction == "F")) {
		$t12_jurnaldetail_grid->KeyCount = $objForm->GetValue($t12_jurnaldetail_grid->FormKeyCountName);
		$t12_jurnaldetail_grid->StopRec = $t12_jurnaldetail_grid->StartRec + $t12_jurnaldetail_grid->KeyCount - 1;
	}
}
$t12_jurnaldetail_grid->RecCnt = $t12_jurnaldetail_grid->StartRec - 1;
if ($t12_jurnaldetail_grid->Recordset && !$t12_jurnaldetail_grid->Recordset->EOF) {
	$t12_jurnaldetail_grid->Recordset->MoveFirst();
	$bSelectLimit = $t12_jurnaldetail_grid->UseSelectLimit;
	if (!$bSelectLimit && $t12_jurnaldetail_grid->StartRec > 1)
		$t12_jurnaldetail_grid->Recordset->Move($t12_jurnaldetail_grid->StartRec - 1);
} elseif (!$t12_jurnaldetail->AllowAddDeleteRow && $t12_jurnaldetail_grid->StopRec == 0) {
	$t12_jurnaldetail_grid->StopRec = $t12_jurnaldetail->GridAddRowCount;
}

// Initialize aggregate
$t12_jurnaldetail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t12_jurnaldetail->ResetAttrs();
$t12_jurnaldetail_grid->RenderRow();
if ($t12_jurnaldetail->CurrentAction == "gridadd")
	$t12_jurnaldetail_grid->RowIndex = 0;
if ($t12_jurnaldetail->CurrentAction == "gridedit")
	$t12_jurnaldetail_grid->RowIndex = 0;
while ($t12_jurnaldetail_grid->RecCnt < $t12_jurnaldetail_grid->StopRec) {
	$t12_jurnaldetail_grid->RecCnt++;
	if (intval($t12_jurnaldetail_grid->RecCnt) >= intval($t12_jurnaldetail_grid->StartRec)) {
		$t12_jurnaldetail_grid->RowCnt++;
		if ($t12_jurnaldetail->CurrentAction == "gridadd" || $t12_jurnaldetail->CurrentAction == "gridedit" || $t12_jurnaldetail->CurrentAction == "F") {
			$t12_jurnaldetail_grid->RowIndex++;
			$objForm->Index = $t12_jurnaldetail_grid->RowIndex;
			if ($objForm->HasValue($t12_jurnaldetail_grid->FormActionName))
				$t12_jurnaldetail_grid->RowAction = strval($objForm->GetValue($t12_jurnaldetail_grid->FormActionName));
			elseif ($t12_jurnaldetail->CurrentAction == "gridadd")
				$t12_jurnaldetail_grid->RowAction = "insert";
			else
				$t12_jurnaldetail_grid->RowAction = "";
		}

		// Set up key count
		$t12_jurnaldetail_grid->KeyCount = $t12_jurnaldetail_grid->RowIndex;

		// Init row class and style
		$t12_jurnaldetail->ResetAttrs();
		$t12_jurnaldetail->CssClass = "";
		if ($t12_jurnaldetail->CurrentAction == "gridadd") {
			if ($t12_jurnaldetail->CurrentMode == "copy") {
				$t12_jurnaldetail_grid->LoadRowValues($t12_jurnaldetail_grid->Recordset); // Load row values
				$t12_jurnaldetail_grid->SetRecordKey($t12_jurnaldetail_grid->RowOldKey, $t12_jurnaldetail_grid->Recordset); // Set old record key
			} else {
				$t12_jurnaldetail_grid->LoadDefaultValues(); // Load default values
				$t12_jurnaldetail_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t12_jurnaldetail_grid->LoadRowValues($t12_jurnaldetail_grid->Recordset); // Load row values
		}
		$t12_jurnaldetail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t12_jurnaldetail->CurrentAction == "gridadd") // Grid add
			$t12_jurnaldetail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t12_jurnaldetail->CurrentAction == "gridadd" && $t12_jurnaldetail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t12_jurnaldetail_grid->RestoreCurrentRowFormValues($t12_jurnaldetail_grid->RowIndex); // Restore form values
		if ($t12_jurnaldetail->CurrentAction == "gridedit") { // Grid edit
			if ($t12_jurnaldetail->EventCancelled) {
				$t12_jurnaldetail_grid->RestoreCurrentRowFormValues($t12_jurnaldetail_grid->RowIndex); // Restore form values
			}
			if ($t12_jurnaldetail_grid->RowAction == "insert")
				$t12_jurnaldetail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t12_jurnaldetail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t12_jurnaldetail->CurrentAction == "gridedit" && ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT || $t12_jurnaldetail->RowType == EW_ROWTYPE_ADD) && $t12_jurnaldetail->EventCancelled) // Update failed
			$t12_jurnaldetail_grid->RestoreCurrentRowFormValues($t12_jurnaldetail_grid->RowIndex); // Restore form values
		if ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t12_jurnaldetail_grid->EditRowCnt++;
		if ($t12_jurnaldetail->CurrentAction == "F") // Confirm row
			$t12_jurnaldetail_grid->RestoreCurrentRowFormValues($t12_jurnaldetail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t12_jurnaldetail->RowAttrs = array_merge($t12_jurnaldetail->RowAttrs, array('data-rowindex'=>$t12_jurnaldetail_grid->RowCnt, 'id'=>'r' . $t12_jurnaldetail_grid->RowCnt . '_t12_jurnaldetail', 'data-rowtype'=>$t12_jurnaldetail->RowType));

		// Render row
		$t12_jurnaldetail_grid->RenderRow();

		// Render list options
		$t12_jurnaldetail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t12_jurnaldetail_grid->RowAction <> "delete" && $t12_jurnaldetail_grid->RowAction <> "insertdelete" && !($t12_jurnaldetail_grid->RowAction == "insert" && $t12_jurnaldetail->CurrentAction == "F" && $t12_jurnaldetail_grid->EmptyRow())) {
?>
	<tr<?php echo $t12_jurnaldetail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t12_jurnaldetail_grid->ListOptions->Render("body", "left", $t12_jurnaldetail_grid->RowCnt);
?>
	<?php if ($t12_jurnaldetail->Rekening->Visible) { // Rekening ?>
		<td data-name="Rekening"<?php echo $t12_jurnaldetail->Rekening->CellAttributes() ?>>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Rekening" class="form-group t12_jurnaldetail_Rekening">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening"><?php echo (strval($t12_jurnaldetail->Rekening->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t12_jurnaldetail->Rekening->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t12_jurnaldetail->Rekening->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t12_jurnaldetail->Rekening->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->CurrentValue ?>"<?php echo $t12_jurnaldetail->Rekening->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->OldValue) ?>">
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Rekening" class="form-group t12_jurnaldetail_Rekening">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening"><?php echo (strval($t12_jurnaldetail->Rekening->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t12_jurnaldetail->Rekening->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t12_jurnaldetail->Rekening->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t12_jurnaldetail->Rekening->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->CurrentValue ?>"<?php echo $t12_jurnaldetail->Rekening->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Rekening" class="t12_jurnaldetail_Rekening">
<span<?php echo $t12_jurnaldetail->Rekening->ViewAttributes() ?>>
<?php echo $t12_jurnaldetail->Rekening->ListViewValue() ?></span>
</span>
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->OldValue) ?>">
<?php } ?>
<?php } ?>
<a id="<?php echo $t12_jurnaldetail_grid->PageObjName . "_row_" . $t12_jurnaldetail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_id" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->id->CurrentValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_id" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->id->OldValue) ?>">
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT || $t12_jurnaldetail->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_id" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($t12_jurnaldetail->Debet->Visible) { // Debet ?>
		<td data-name="Debet"<?php echo $t12_jurnaldetail->Debet->CellAttributes() ?>>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Debet" class="form-group t12_jurnaldetail_Debet">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Debet" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Debet->EditValue ?>"<?php echo $t12_jurnaldetail->Debet->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->OldValue) ?>">
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Debet" class="form-group t12_jurnaldetail_Debet">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Debet" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Debet->EditValue ?>"<?php echo $t12_jurnaldetail->Debet->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Debet" class="t12_jurnaldetail_Debet">
<span<?php echo $t12_jurnaldetail->Debet->ViewAttributes() ?>>
<?php echo $t12_jurnaldetail->Debet->ListViewValue() ?></span>
</span>
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($t12_jurnaldetail->Kredit->Visible) { // Kredit ?>
		<td data-name="Kredit"<?php echo $t12_jurnaldetail->Kredit->CellAttributes() ?>>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Kredit" class="form-group t12_jurnaldetail_Kredit">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Kredit" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Kredit->EditValue ?>"<?php echo $t12_jurnaldetail->Kredit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->OldValue) ?>">
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Kredit" class="form-group t12_jurnaldetail_Kredit">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Kredit" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Kredit->EditValue ?>"<?php echo $t12_jurnaldetail->Kredit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t12_jurnaldetail_grid->RowCnt ?>_t12_jurnaldetail_Kredit" class="t12_jurnaldetail_Kredit">
<span<?php echo $t12_jurnaldetail->Kredit->ViewAttributes() ?>>
<?php echo $t12_jurnaldetail->Kredit->ListViewValue() ?></span>
</span>
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="ft12_jurnaldetailgrid$x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->FormValue) ?>">
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="ft12_jurnaldetailgrid$o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t12_jurnaldetail_grid->ListOptions->Render("body", "right", $t12_jurnaldetail_grid->RowCnt);
?>
	</tr>
<?php if ($t12_jurnaldetail->RowType == EW_ROWTYPE_ADD || $t12_jurnaldetail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft12_jurnaldetailgrid.UpdateOpts(<?php echo $t12_jurnaldetail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t12_jurnaldetail->CurrentAction <> "gridadd" || $t12_jurnaldetail->CurrentMode == "copy")
		if (!$t12_jurnaldetail_grid->Recordset->EOF) $t12_jurnaldetail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t12_jurnaldetail->CurrentMode == "add" || $t12_jurnaldetail->CurrentMode == "copy" || $t12_jurnaldetail->CurrentMode == "edit") {
		$t12_jurnaldetail_grid->RowIndex = '$rowindex$';
		$t12_jurnaldetail_grid->LoadDefaultValues();

		// Set row properties
		$t12_jurnaldetail->ResetAttrs();
		$t12_jurnaldetail->RowAttrs = array_merge($t12_jurnaldetail->RowAttrs, array('data-rowindex'=>$t12_jurnaldetail_grid->RowIndex, 'id'=>'r0_t12_jurnaldetail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t12_jurnaldetail->RowAttrs["class"], "ewTemplate");
		$t12_jurnaldetail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t12_jurnaldetail_grid->RenderRow();

		// Render list options
		$t12_jurnaldetail_grid->RenderListOptions();
		$t12_jurnaldetail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t12_jurnaldetail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t12_jurnaldetail_grid->ListOptions->Render("body", "left", $t12_jurnaldetail_grid->RowIndex);
?>
	<?php if ($t12_jurnaldetail->Rekening->Visible) { // Rekening ?>
		<td data-name="Rekening">
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t12_jurnaldetail_Rekening" class="form-group t12_jurnaldetail_Rekening">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening"><?php echo (strval($t12_jurnaldetail->Rekening->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $t12_jurnaldetail->Rekening->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t12_jurnaldetail->Rekening->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t12_jurnaldetail->Rekening->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->CurrentValue ?>"<?php echo $t12_jurnaldetail->Rekening->EditAttributes() ?>>
<input type="hidden" name="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="s_x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo $t12_jurnaldetail->Rekening->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_t12_jurnaldetail_Rekening" class="form-group t12_jurnaldetail_Rekening">
<span<?php echo $t12_jurnaldetail->Rekening->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t12_jurnaldetail->Rekening->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Rekening" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Rekening" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Rekening->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t12_jurnaldetail->Debet->Visible) { // Debet ?>
		<td data-name="Debet">
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t12_jurnaldetail_Debet" class="form-group t12_jurnaldetail_Debet">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Debet" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Debet->EditValue ?>"<?php echo $t12_jurnaldetail->Debet->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t12_jurnaldetail_Debet" class="form-group t12_jurnaldetail_Debet">
<span<?php echo $t12_jurnaldetail->Debet->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t12_jurnaldetail->Debet->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Debet" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Debet" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Debet->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($t12_jurnaldetail->Kredit->Visible) { // Kredit ?>
		<td data-name="Kredit">
<?php if ($t12_jurnaldetail->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t12_jurnaldetail_Kredit" class="form-group t12_jurnaldetail_Kredit">
<input type="text" data-table="t12_jurnaldetail" data-field="x_Kredit" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" size="10" placeholder="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->getPlaceHolder()) ?>" value="<?php echo $t12_jurnaldetail->Kredit->EditValue ?>"<?php echo $t12_jurnaldetail->Kredit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t12_jurnaldetail_Kredit" class="form-group t12_jurnaldetail_Kredit">
<span<?php echo $t12_jurnaldetail->Kredit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t12_jurnaldetail->Kredit->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="x<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t12_jurnaldetail" data-field="x_Kredit" name="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" id="o<?php echo $t12_jurnaldetail_grid->RowIndex ?>_Kredit" value="<?php echo ew_HtmlEncode($t12_jurnaldetail->Kredit->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t12_jurnaldetail_grid->ListOptions->Render("body", "right", $t12_jurnaldetail_grid->RowCnt);
?>
<script type="text/javascript">
ft12_jurnaldetailgrid.UpdateOpts(<?php echo $t12_jurnaldetail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t12_jurnaldetail->CurrentMode == "add" || $t12_jurnaldetail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t12_jurnaldetail_grid->FormKeyCountName ?>" id="<?php echo $t12_jurnaldetail_grid->FormKeyCountName ?>" value="<?php echo $t12_jurnaldetail_grid->KeyCount ?>">
<?php echo $t12_jurnaldetail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t12_jurnaldetail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t12_jurnaldetail_grid->FormKeyCountName ?>" id="<?php echo $t12_jurnaldetail_grid->FormKeyCountName ?>" value="<?php echo $t12_jurnaldetail_grid->KeyCount ?>">
<?php echo $t12_jurnaldetail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t12_jurnaldetail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft12_jurnaldetailgrid">
</div>
<?php

// Close recordset
if ($t12_jurnaldetail_grid->Recordset)
	$t12_jurnaldetail_grid->Recordset->Close();
?>
<?php if ($t12_jurnaldetail_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($t12_jurnaldetail_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t12_jurnaldetail_grid->TotalRecs == 0 && $t12_jurnaldetail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t12_jurnaldetail_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t12_jurnaldetail->Export == "") { ?>
<script type="text/javascript">
ft12_jurnaldetailgrid.Init();
</script>
<?php } ?>
<?php
$t12_jurnaldetail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$t12_jurnaldetail_grid->Page_Terminate();
?>
