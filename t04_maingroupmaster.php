<?php

// Nama
?>
<?php if ($t04_maingroup->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_t04_maingroupmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($t04_maingroup->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td class="col-sm-2"><?php echo $t04_maingroup->Nama->FldCaption() ?></td>
			<td<?php echo $t04_maingroup->Nama->CellAttributes() ?>>
<span id="el_t04_maingroup_Nama">
<span<?php echo $t04_maingroup->Nama->ViewAttributes() ?>>
<?php echo $t04_maingroup->Nama->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
