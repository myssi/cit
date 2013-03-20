<style type="text/css">
.isi{	
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 0.9em;
	height:1.2em;
	}
#message
{
	width:50%;
	margin-left:auto;
	margin-right:auto;
	font-family:Arial, Helvetica, sans-serif;
	color:RED;
}

.tengah{text-align:center;}
.submit
{
	width:4.5em;
	height:2.3em;
	cursor:hand;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#dasar").change(function(){
		var dasare= $("#dasar").serialize();
		var url= "<?php echo site_url('supervisor/nasabah/choosebase') ?>";
		
		$.post(url,dasare,function(response){
			$("#hasil").html(response);
		});
	});
});
</script>
<?php
	$message= $this->session->userdata('message_error');
	$this->session->unset_userdata('message_error');
	echo isset($message) ? '<div id="message" class="tengah">'.$message.'</div><br/>' : '';
	
	echo form_open('supervisor/nasabah/nasabahlist');
?>
<table width="80%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100" class="isi">Berdasarkan</td>
		<td class="isi">
			<select name="dasar" id="dasar" style="width:16.6em;">
				<option value="0" selected="selected">--Pilih Salah Satu--</option>
				<option value="1">Bank</option>
				<option value="2">Sentra Kas/Pengelolah</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div id="hasil"></div>

<table width="80%" border="0" cellpadding="0" cellspacing="0">
	
	<tr>
		<td width="100">&nbsp;</td>
		<td><input type="submit" value="Lihat" class="submit" /></td>
	</tr>
</table>