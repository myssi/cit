<table width="80%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100" class="isi">Bank</td>
		<td>
		<select name="bank" id="bank">
		<option value="0" selected="selected">-- Pilih Satu --</option>
		<?php 
		if(!empty($bank))
			foreach($bank as $banks)
			{
				echo'<option value="'.$banks->idcustomer.'">'.$banks->nama.'</option>';
			}
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>