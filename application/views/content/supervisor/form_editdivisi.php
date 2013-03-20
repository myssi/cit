<style type="text/css">
table
{ 
	font: normal 80% 'century gothic', arial, sans-serif;
	font-weight:bold;
	margin-left:auto;
	margin-rigth:auto;
}

.submit
{
	height:2.4em;
	width:7em;
}

#kodecustomer
{
	width: 17em;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#sbsave").click(function(){
		var nama= $("#nama").val();
		
		if(nama == '')
		{
			alert("Nama Divisi Harus Diisi !");
			$("#nama").focus();
			return false;
		}
		
	});
});
</script>

<?php echo form_open('supervisor/customersuper/divisieditprocess'); ?>
<table width="70%" border="0" cellpadding="0" cellpadding="0">
  <tr>
  	<td width="170">Nama Divisi</td>
	<td><input type="text" name="nama" id="nama" size="33" maxlength="40" value="<?php echo isset($divisiload->divisi) ? $divisiload->divisi : ''; ?>"/></td>
  </tr>
  <tr>
  	<td><input type="hidden" name="iddivisi" value="<?php echo isset($divisiload->iddivisi) ? $divisiload->iddivisi : ''; ?>" /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>Bank/Instansi</td>
	<td>
		<select name="kodecustomer" id="kodecustomer">  
		<?php 
			foreach($banklist as $banks)
			{
				if($banks->idcustomer == $divisiload->idcustomer)
				{
					echo'<option value="'.$banks->idbank.'" selected="selected">'.$banks->nama.'</option>';
				}
				else
				{
					echo'<option value="'.$banks->idbank.'">'.$banks->nama.'</option>';
				}
			}
		?>
		</select>
	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td><input type="submit" class="submit" value=" Edit " id="sbsave"</td>
  </tr>
</table>
</form>