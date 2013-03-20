<style type="text/css">
.form td
{
	font: normal 110% 'century gothic', arial, sans-serif;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$(".submit_small").click(function(){
		var cab= $("#cabang").val();
		
		if(cab == '')
		{
			alert("Cabang Harus Dipilih !");
			return false;
		}
	});
});
</script>
<div class="form">

<form name="form_cabang" method="post" action="<?php echo $actionpage; ?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="150">Pilih Cabang</td>
		<td><?php
			if(isset($cabang))
			{
				echo'<select name="cabang" id="cabang" style="width: 205px;">';
				echo'<option value="" selected="selected">-- Pilih Salah Satu -- </option>';
				foreach($cabang as $cab)
				{
					echo'<option value="'.$cab->idcabang.'">'.$cab->nama.'</option>';
				}
				echo'</select>';
			}
		?> <input type="submit" value="OK" class="submit_small"/></td>
	</tr>
</table>
</form>
</div>