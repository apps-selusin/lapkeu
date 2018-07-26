<?php include_once "t96_employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t05_subgroup_grid)) $t05_subgroup_grid = new ct05_subgroup_grid();

// Page init
$t05_subgroup_grid->Page_Init();

// Page main
$t05_subgroup_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t05_subgroup_grid->Page_Render();
?>
<?php if ($t05_subgroup->Export == "") { ?>
<script type="text/javascript">

// Form object
var ft05_subgroupgrid = new ew_Form("ft05_subgroupgrid", "grid");
ft05_subgroupgrid.FormKeyCountName = '<?php echo $t05_subgroup_grid->FormKeyCountName ?>';

// Validate form
ft05_subgroupgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t05_subgroup->Nama->FldCaption(), $t05_subgroup->Nama->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ft05_subgroupgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Nama", false)) return false;
	return true;
}

// Form_CustomValidate event
ft05_subgroupgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ft05_subgroupgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($t05_subgroup->CurrentAction == "gridadd") {
	if ($t05_subgroup->CurrentMode == "copy") {
		$bSelectLimit = $t05_subgroup_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$t05_subgroup_grid->TotalRecs = $t05_subgroup->ListRecordCount();
			$t05_subgroup_grid->Recordset = $t05_subgroup_grid->LoadRecordset($t05_subgroup_grid->StartRec-1, $t05_subgroup_grid->DisplayRecs);
		} else {
			if ($t05_subgroup_grid->Recordset = $t05_subgroup_grid->LoadRecordset())
				$t05_subgroup_grid->TotalRecs = $t05_subgroup_grid->Recordset->RecordCount();
		}
		$t05_subgroup_grid->StartRec = 1;
		$t05_subgroup_grid->DisplayRecs = $t05_subgroup_grid->TotalRecs;
	} else {
		$t05_subgroup->CurrentFilter = "0=1";
		$t05_subgroup_grid->StartRec = 1;
		$t05_subgroup_grid->DisplayRecs = $t05_subgroup->GridAddRowCount;
	}
	$t05_subgroup_grid->TotalRecs = $t05_subgroup_grid->DisplayRecs;
	$t05_subgroup_grid->StopRec = $t05_subgroup_grid->DisplayRecs;
} else {
	$bSelectLimit = $t05_subgroup_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t05_subgroup_grid->TotalRecs <= 0)
			$t05_subgroup_grid->TotalRecs = $t05_subgroup->ListRecordCount();
	} else {
		if (!$t05_subgroup_grid->Recordset && ($t05_subgroup_grid->Recordset = $t05_subgroup_grid->LoadRecordset()))
			$t05_subgroup_grid->TotalRecs = $t05_subgroup_grid->Recordset->RecordCount();
	}
	$t05_subgroup_grid->StartRec = 1;
	$t05_subgroup_grid->DisplayRecs = $t05_subgroup_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$t05_subgroup_grid->Recordset = $t05_subgroup_grid->LoadRecordset($t05_subgroup_grid->StartRec-1, $t05_subgroup_grid->DisplayRecs);

	// Set no record found message
	if ($t05_subgroup->CurrentAction == "" && $t05_subgroup_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$t05_subgroup_grid->setWarningMessage(ew_DeniedMsg());
		if ($t05_subgroup_grid->SearchWhere == "0=101")
			$t05_subgroup_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t05_subgroup_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$t05_subgroup_grid->RenderOtherOptions();
?>
<?php $t05_subgroup_grid->ShowPageHeader(); ?>
<?php
$t05_subgroup_grid->ShowMessage();
?>
<?php if ($t05_subgroup_grid->TotalRecs > 0 || $t05_subgroup->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($t05_subgroup_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> t05_subgroup">
<div id="ft05_subgroupgrid" class="ewForm ewListForm form-inline">
<?php if ($t05_subgroup_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($t05_subgroup_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_t05_subgroup" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_t05_subgroupgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$t05_subgroup_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t05_subgroup_grid->RenderListOptions();

// Render list options (header, left)
$t05_subgroup_grid->ListOptions->Render("header", "left");
?>
<?php if ($t05_subgroup->Nama->Visible) { // Nama ?>
	<?php if ($t05_subgroup->SortUrl($t05_subgroup->Nama) == "") { ?>
		<th data-name="Nama" class="<?php echo $t05_subgroup->Nama->HeaderCellClass() ?>"><div id="elh_t05_subgroup_Nama" class="t05_subgroup_Nama"><div class="ewTableHeaderCaption"><?php echo $t05_subgroup->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama" class="<?php echo $t05_subgroup->Nama->HeaderCellClass() ?>"><div><div id="elh_t05_subgroup_Nama" class="t05_subgroup_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t05_subgroup->Nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t05_subgroup->Nama->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($t05_subgroup->Nama->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$t05_subgroup_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$t05_subgroup_grid->StartRec = 1;
$t05_subgroup_grid->StopRec = $t05_subgroup_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($t05_subgroup_grid->FormKeyCountName) && ($t05_subgroup->CurrentAction == "gridadd" || $t05_subgroup->CurrentAction == "gridedit" || $t05_subgroup->CurrentAction == "F")) {
		$t05_subgroup_grid->KeyCount = $objForm->GetValue($t05_subgroup_grid->FormKeyCountName);
		$t05_subgroup_grid->StopRec = $t05_subgroup_grid->StartRec + $t05_subgroup_grid->KeyCount - 1;
	}
}
$t05_subgroup_grid->RecCnt = $t05_subgroup_grid->StartRec - 1;
if ($t05_subgroup_grid->Recordset && !$t05_subgroup_grid->Recordset->EOF) {
	$t05_subgroup_grid->Recordset->MoveFirst();
	$bSelectLimit = $t05_subgroup_grid->UseSelectLimit;
	if (!$bSelectLimit && $t05_subgroup_grid->StartRec > 1)
		$t05_subgroup_grid->Recordset->Move($t05_subgroup_grid->StartRec - 1);
} elseif (!$t05_subgroup->AllowAddDeleteRow && $t05_subgroup_grid->StopRec == 0) {
	$t05_subgroup_grid->StopRec = $t05_subgroup->GridAddRowCount;
}

// Initialize aggregate
$t05_subgroup->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t05_subgroup->ResetAttrs();
$t05_subgroup_grid->RenderRow();
if ($t05_subgroup->CurrentAction == "gridadd")
	$t05_subgroup_grid->RowIndex = 0;
if ($t05_subgroup->CurrentAction == "gridedit")
	$t05_subgroup_grid->RowIndex = 0;
while ($t05_subgroup_grid->RecCnt < $t05_subgroup_grid->StopRec) {
	$t05_subgroup_grid->RecCnt++;
	if (intval($t05_subgroup_grid->RecCnt) >= intval($t05_subgroup_grid->StartRec)) {
		$t05_subgroup_grid->RowCnt++;
		if ($t05_subgroup->CurrentAction == "gridadd" || $t05_subgroup->CurrentAction == "gridedit" || $t05_subgroup->CurrentAction == "F") {
			$t05_subgroup_grid->RowIndex++;
			$objForm->Index = $t05_subgroup_grid->RowIndex;
			if ($objForm->HasValue($t05_subgroup_grid->FormActionName))
				$t05_subgroup_grid->RowAction = strval($objForm->GetValue($t05_subgroup_grid->FormActionName));
			elseif ($t05_subgroup->CurrentAction == "gridadd")
				$t05_subgroup_grid->RowAction = "insert";
			else
				$t05_subgroup_grid->RowAction = "";
		}

		// Set up key count
		$t05_subgroup_grid->KeyCount = $t05_subgroup_grid->RowIndex;

		// Init row class and style
		$t05_subgroup->ResetAttrs();
		$t05_subgroup->CssClass = "";
		if ($t05_subgroup->CurrentAction == "gridadd") {
			if ($t05_subgroup->CurrentMode == "copy") {
				$t05_subgroup_grid->LoadRowValues($t05_subgroup_grid->Recordset); // Load row values
				$t05_subgroup_grid->SetRecordKey($t05_subgroup_grid->RowOldKey, $t05_subgroup_grid->Recordset); // Set old record key
			} else {
				$t05_subgroup_grid->LoadRowValues(); // Load default values
				$t05_subgroup_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$t05_subgroup_grid->LoadRowValues($t05_subgroup_grid->Recordset); // Load row values
		}
		$t05_subgroup->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($t05_subgroup->CurrentAction == "gridadd") // Grid add
			$t05_subgroup->RowType = EW_ROWTYPE_ADD; // Render add
		if ($t05_subgroup->CurrentAction == "gridadd" && $t05_subgroup->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$t05_subgroup_grid->RestoreCurrentRowFormValues($t05_subgroup_grid->RowIndex); // Restore form values
		if ($t05_subgroup->CurrentAction == "gridedit") { // Grid edit
			if ($t05_subgroup->EventCancelled) {
				$t05_subgroup_grid->RestoreCurrentRowFormValues($t05_subgroup_grid->RowIndex); // Restore form values
			}
			if ($t05_subgroup_grid->RowAction == "insert")
				$t05_subgroup->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$t05_subgroup->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($t05_subgroup->CurrentAction == "gridedit" && ($t05_subgroup->RowType == EW_ROWTYPE_EDIT || $t05_subgroup->RowType == EW_ROWTYPE_ADD) && $t05_subgroup->EventCancelled) // Update failed
			$t05_subgroup_grid->RestoreCurrentRowFormValues($t05_subgroup_grid->RowIndex); // Restore form values
		if ($t05_subgroup->RowType == EW_ROWTYPE_EDIT) // Edit row
			$t05_subgroup_grid->EditRowCnt++;
		if ($t05_subgroup->CurrentAction == "F") // Confirm row
			$t05_subgroup_grid->RestoreCurrentRowFormValues($t05_subgroup_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$t05_subgroup->RowAttrs = array_merge($t05_subgroup->RowAttrs, array('data-rowindex'=>$t05_subgroup_grid->RowCnt, 'id'=>'r' . $t05_subgroup_grid->RowCnt . '_t05_subgroup', 'data-rowtype'=>$t05_subgroup->RowType));

		// Render row
		$t05_subgroup_grid->RenderRow();

		// Render list options
		$t05_subgroup_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($t05_subgroup_grid->RowAction <> "delete" && $t05_subgroup_grid->RowAction <> "insertdelete" && !($t05_subgroup_grid->RowAction == "insert" && $t05_subgroup->CurrentAction == "F" && $t05_subgroup_grid->EmptyRow())) {
?>
	<tr<?php echo $t05_subgroup->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t05_subgroup_grid->ListOptions->Render("body", "left", $t05_subgroup_grid->RowCnt);
?>
	<?php if ($t05_subgroup->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $t05_subgroup->Nama->CellAttributes() ?>>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $t05_subgroup_grid->RowCnt ?>_t05_subgroup_Nama" class="form-group t05_subgroup_Nama">
<input type="text" data-table="t05_subgroup" data-field="x_Nama" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t05_subgroup->Nama->getPlaceHolder()) ?>" value="<?php echo $t05_subgroup->Nama->EditValue ?>"<?php echo $t05_subgroup->Nama->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->OldValue) ?>">
<?php } ?>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $t05_subgroup_grid->RowCnt ?>_t05_subgroup_Nama" class="form-group t05_subgroup_Nama">
<input type="text" data-table="t05_subgroup" data-field="x_Nama" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t05_subgroup->Nama->getPlaceHolder()) ?>" value="<?php echo $t05_subgroup->Nama->EditValue ?>"<?php echo $t05_subgroup->Nama->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $t05_subgroup_grid->RowCnt ?>_t05_subgroup_Nama" class="t05_subgroup_Nama">
<span<?php echo $t05_subgroup->Nama->ViewAttributes() ?>>
<?php echo $t05_subgroup->Nama->ListViewValue() ?></span>
</span>
<?php if ($t05_subgroup->CurrentAction <> "F") { ?>
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->FormValue) ?>">
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="ft05_subgroupgrid$x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="ft05_subgroupgrid$x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->FormValue) ?>">
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="ft05_subgroupgrid$o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="ft05_subgroupgrid$o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="t05_subgroup" data-field="x_id" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_id" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_subgroup->id->CurrentValue) ?>">
<input type="hidden" data-table="t05_subgroup" data-field="x_id" name="o<?php echo $t05_subgroup_grid->RowIndex ?>_id" id="o<?php echo $t05_subgroup_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_subgroup->id->OldValue) ?>">
<?php } ?>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_EDIT || $t05_subgroup->CurrentMode == "edit") { ?>
<input type="hidden" data-table="t05_subgroup" data-field="x_id" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_id" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($t05_subgroup->id->CurrentValue) ?>">
<?php } ?>
<?php

// Render list options (body, right)
$t05_subgroup_grid->ListOptions->Render("body", "right", $t05_subgroup_grid->RowCnt);
?>
	</tr>
<?php if ($t05_subgroup->RowType == EW_ROWTYPE_ADD || $t05_subgroup->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ft05_subgroupgrid.UpdateOpts(<?php echo $t05_subgroup_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($t05_subgroup->CurrentAction <> "gridadd" || $t05_subgroup->CurrentMode == "copy")
		if (!$t05_subgroup_grid->Recordset->EOF) $t05_subgroup_grid->Recordset->MoveNext();
}
?>
<?php
	if ($t05_subgroup->CurrentMode == "add" || $t05_subgroup->CurrentMode == "copy" || $t05_subgroup->CurrentMode == "edit") {
		$t05_subgroup_grid->RowIndex = '$rowindex$';
		$t05_subgroup_grid->LoadRowValues();

		// Set row properties
		$t05_subgroup->ResetAttrs();
		$t05_subgroup->RowAttrs = array_merge($t05_subgroup->RowAttrs, array('data-rowindex'=>$t05_subgroup_grid->RowIndex, 'id'=>'r0_t05_subgroup', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($t05_subgroup->RowAttrs["class"], "ewTemplate");
		$t05_subgroup->RowType = EW_ROWTYPE_ADD;

		// Render row
		$t05_subgroup_grid->RenderRow();

		// Render list options
		$t05_subgroup_grid->RenderListOptions();
		$t05_subgroup_grid->StartRowCnt = 0;
?>
	<tr<?php echo $t05_subgroup->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t05_subgroup_grid->ListOptions->Render("body", "left", $t05_subgroup_grid->RowIndex);
?>
	<?php if ($t05_subgroup->Nama->Visible) { // Nama ?>
		<td data-name="Nama">
<?php if ($t05_subgroup->CurrentAction <> "F") { ?>
<span id="el$rowindex$_t05_subgroup_Nama" class="form-group t05_subgroup_Nama">
<input type="text" data-table="t05_subgroup" data-field="x_Nama" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t05_subgroup->Nama->getPlaceHolder()) ?>" value="<?php echo $t05_subgroup->Nama->EditValue ?>"<?php echo $t05_subgroup->Nama->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_t05_subgroup_Nama" class="form-group t05_subgroup_Nama">
<span<?php echo $t05_subgroup->Nama->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t05_subgroup->Nama->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="x<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="t05_subgroup" data-field="x_Nama" name="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" id="o<?php echo $t05_subgroup_grid->RowIndex ?>_Nama" value="<?php echo ew_HtmlEncode($t05_subgroup->Nama->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t05_subgroup_grid->ListOptions->Render("body", "right", $t05_subgroup_grid->RowIndex);
?>
<script type="text/javascript">
ft05_subgroupgrid.UpdateOpts(<?php echo $t05_subgroup_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($t05_subgroup->CurrentMode == "add" || $t05_subgroup->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $t05_subgroup_grid->FormKeyCountName ?>" id="<?php echo $t05_subgroup_grid->FormKeyCountName ?>" value="<?php echo $t05_subgroup_grid->KeyCount ?>">
<?php echo $t05_subgroup_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t05_subgroup->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $t05_subgroup_grid->FormKeyCountName ?>" id="<?php echo $t05_subgroup_grid->FormKeyCountName ?>" value="<?php echo $t05_subgroup_grid->KeyCount ?>">
<?php echo $t05_subgroup_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($t05_subgroup->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ft05_subgroupgrid">
</div>
<?php

// Close recordset
if ($t05_subgroup_grid->Recordset)
	$t05_subgroup_grid->Recordset->Close();
?>
<?php if ($t05_subgroup_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($t05_subgroup_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($t05_subgroup_grid->TotalRecs == 0 && $t05_subgroup->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t05_subgroup_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($t05_subgroup->Export == "") { ?>
<script type="text/javascript">
ft05_subgroupgrid.Init();
</script>
<?php } ?>
<?php
$t05_subgroup_grid->Page_Terminate();
?>
