<table width="80%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100" class="isi">Senkas</td>
		<td>
		<select name="senkas" id="senkas" style="width:16.6em;">
		<option value="0" selected="selected">-- Pilih Satu --</option>
		<?php 
		if(!empty($senkas))
			foreach($senkas as $sentra)
			{
				echo'<option value="'.$sentra->idcabang.'">'.$sentra->cabang.'</option>';
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