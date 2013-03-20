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
	width:5em;
}
</style>
<script type="text/javascript" src="<?php echo base_url('js/supervisor/form_add.js'); ?>"></script>
<?php echo form_open('supervisor/customersuper/editbankprocess'); ?>
<table width="70%" border="0" cellpadding="0" cellpadding="0">
  <tr>
  	<td width="170">Bank</td>
	<td><input type="text" name="nama" id="nama" size="30" maxlength="40" value="<?php echo isset($nasabah->nama) ? $nasabah->nama : ''; ?>"/></td>
  </tr>
  <tr>
  	<td width="170">Singkatan</td>
	<td><input type="text" name="singkatan" id="singkatan" size="30" maxlength="40" value="<?php echo isset($nasabah->singkatan) ? $nasabah->singkatan : ''; ?>"/></td>
  </tr>
  
  <tr>
  	<td><input type="hidden" value="<?php echo isset($nasabah->idbank) ? $nasabah->idbank : ''; ?>" name="idtable"/></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td><input type="submit" class="submit" value=" Edit " id="sbsave"</td>
  </tr>
</table>
</form>