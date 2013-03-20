<style type="text/css">
table td{	
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 0.9em;
	height:1.2em;
	}
table
{
	margin-left:auto;
	margin-right:auto;
}

#bank, #divisi, #senkas
{
	width:18em;
}
.submit
{
	height:2.4em;
	width:7em;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#bank").change(function(){
		var banks = $("#bank").serialize();
		var url= "<?php echo site_url('supervisor/nasabah/getdivisilist') ?>";
		
		
		$.post(url,banks,function(response){
			$("#hasil").html(response);
		});
		
		
		
	});
});
</script>
<?php echo form_open('supervisor/nasabah/addprocess'); ?>
<table width="60%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="isi">Sentra Kas</td>
		<td>
			<?php
			if(!empty($senkas))
			{
				echo'<select name="senkas" id="senkas">';
				echo'<option value="" selected="selected">--Pilih Salah Satu--</option>';
				
					foreach($senkas as $sentra)
					{
						echo'<option value="'.$sentra->idcabang.'">'.$sentra->cabang.'</option>';
					}
				
				echo'</select>';
			}
			
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="100" class="isi">Bank</td>
		<td class="isi">
			<select name="bank" id="bank">
				<option value="0" selected="selected">--Pilih Salah Satu--</option>
				<?php 
				if(!empty($bank))
				{
					foreach($bank as $banks)
					{
						echo'<option value="'.$banks->idcustomer.'">'.$banks->nama.'</option>';
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
</table>
<div id="hasil"></div>

<table width="60%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>Nama Nasabah</td>
		<td><input type="text" name="nasabah" size="36" maxlength="36" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="100">&nbsp;</td>
		<td><input type="submit" value="Simpan" class="submit" id="sbsave" /></td>
	</tr>
</table>
</form>