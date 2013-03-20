<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/timepicker.css'); ?>" />

<link rel="stylesheet" href="<?php echo base_url('development-bundle/themes/ui-lightness/jquery.ui.all.css'); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url('development-bundle/themes/base/jquery.ui.theme.css'); ?>" type="text/css" media="all" />
<script src="<?php echo base_url('js/jquery-ui-1.8.16.custom.min.js');?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui-timepicker-addon.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui-sliderAccess.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/management/form_nasabah.js'); ?>"></script>
<style type="text/css">
table td
{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 0.9em;
	height:1.2em;
}

table
{
	margin-left: auto;
	margin-right:auto;
}
#sbproses
{
	width:5em;
	height:2em;
}
</style>
<?php echo form_open('management/nonsortir/processcust'); ?>
<table border="0" cellpadding="0" cellspacing="0" width="45%">
	<tr>
		<td>Periode Tanggal</td>
		<td><input type="text" name="tgla" id="tgla" size="30" maxlength="30"/> - </td>
		<td><input type="text" name="tglb" id="tglb" size="30" maxlength="30"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Nasabah</td>
		<td colspan="2">
		<?php 
			if(!empty($nasabah))
			{
				echo'<select name="nasabah" id="nasabah" style="width:15.4em;">';
				echo'<option value="0" selected="selected">-- Pilih Salah Satu --</option>';
				foreach($nasabah as $nas)
				{
					echo'<option value="'.$nas->idnasabah.'">'.$nas->nasabah.'</option>';
				}
				echo'</select>';
			}
		?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal Surat</td>
		<td colspan="2"><input type="text" name="tglsurat" id="tglsurat" size="30" maxlength="30"/></td>
		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Proses" id="sbproses"/></td>
		<td>&nbsp;</td>
	</tr>
</table>
</form>
<script type="text/javascript">
<?php 
	$message= $this->session->userdata('message_error');
	$this->session->unset_userdata('message_error');
	
	if(!empty($message))
	{
		echo'
			alert("'.$message.'");
			parent.$("#tgla").focus();
		';
	}
?>
</script>