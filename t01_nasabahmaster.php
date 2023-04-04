<?php

// Nama
// Alamat
// No_Telp_Hp
// Pekerjaan
// Pekerjaan_Alamat
// Pekerjaan_No_Telp_Hp
// Status
// Keterangan
// marketing_id

?>
<?php if ($t01_nasabah->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $t01_nasabah->TableCaption() ?></h4> -->
<table id="tbl_t01_nasabahmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $t01_nasabah->TableCustomInnerHtml ?>
	<tbody>
<?php if ($t01_nasabah->Nama->Visible) { // Nama ?>
		<tr id="r_Nama">
			<td><?php echo $t01_nasabah->Nama->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Nama->CellAttributes() ?>>
<span id="el_t01_nasabah_Nama">
<span<?php echo $t01_nasabah->Nama->ViewAttributes() ?>>
<?php echo $t01_nasabah->Nama->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Alamat->Visible) { // Alamat ?>
		<tr id="r_Alamat">
			<td><?php echo $t01_nasabah->Alamat->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Alamat">
<span<?php echo $t01_nasabah->Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Alamat->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->No_Telp_Hp->Visible) { // No_Telp_Hp ?>
		<tr id="r_No_Telp_Hp">
			<td><?php echo $t01_nasabah->No_Telp_Hp->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->No_Telp_Hp->CellAttributes() ?>>
<span id="el_t01_nasabah_No_Telp_Hp">
<span<?php echo $t01_nasabah->No_Telp_Hp->ViewAttributes() ?>>
<?php echo $t01_nasabah->No_Telp_Hp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan->Visible) { // Pekerjaan ?>
		<tr id="r_Pekerjaan">
			<td><?php echo $t01_nasabah->Pekerjaan->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Pekerjaan->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan">
<span<?php echo $t01_nasabah->Pekerjaan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_Alamat->Visible) { // Pekerjaan_Alamat ?>
		<tr id="r_Pekerjaan_Alamat">
			<td><?php echo $t01_nasabah->Pekerjaan_Alamat->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Pekerjaan_Alamat->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan_Alamat">
<span<?php echo $t01_nasabah->Pekerjaan_Alamat->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan_Alamat->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Pekerjaan_No_Telp_Hp->Visible) { // Pekerjaan_No_Telp_Hp ?>
		<tr id="r_Pekerjaan_No_Telp_Hp">
			<td><?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->CellAttributes() ?>>
<span id="el_t01_nasabah_Pekerjaan_No_Telp_Hp">
<span<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->ViewAttributes() ?>>
<?php echo $t01_nasabah->Pekerjaan_No_Telp_Hp->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Status->Visible) { // Status ?>
		<tr id="r_Status">
			<td><?php echo $t01_nasabah->Status->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Status->CellAttributes() ?>>
<span id="el_t01_nasabah_Status">
<span<?php echo $t01_nasabah->Status->ViewAttributes() ?>>
<?php echo $t01_nasabah->Status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->Keterangan->Visible) { // Keterangan ?>
		<tr id="r_Keterangan">
			<td><?php echo $t01_nasabah->Keterangan->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->Keterangan->CellAttributes() ?>>
<span id="el_t01_nasabah_Keterangan">
<span<?php echo $t01_nasabah->Keterangan->ViewAttributes() ?>>
<?php echo $t01_nasabah->Keterangan->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($t01_nasabah->marketing_id->Visible) { // marketing_id ?>
		<tr id="r_marketing_id">
			<td><?php echo $t01_nasabah->marketing_id->FldCaption() ?></td>
			<td<?php echo $t01_nasabah->marketing_id->CellAttributes() ?>>
<span id="el_t01_nasabah_marketing_id">
<span<?php echo $t01_nasabah->marketing_id->ViewAttributes() ?>>
<?php echo $t01_nasabah->marketing_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
