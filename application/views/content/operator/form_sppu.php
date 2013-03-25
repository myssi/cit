<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/timepicker.css'); ?>" />

<link rel="stylesheet" href="<?php echo base_url('development-bundle/themes/ui-lightness/jquery.ui.all.css'); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url('development-bundle/themes/base/jquery.ui.theme.css'); ?>" type="text/css" media="all" />
<script src="<?php echo base_url('js/jquery-ui-1.8.16.custom.min.js');?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui-timepicker-addon.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery-ui-sliderAccess.js'); ?>"></script>
<style type="text/css">
th, .headtable
{
	background: #000000;
	color:#ffffff;
	font-family: Arial, Helvetica, sans-serif;
	font-weight:500;
	font-size:12px;
	text-align: center;
	height:1.0em;
	
}

.zebra
{
	background: #B5A7BA;
}

table
{
	margin-left: auto;
	margin-right:auto;
	
}
.isi, .isi a,tbody td
{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 0.9em;
	height:1.8em;
}

.tengah{text-align:center;}
.kanan{text-align:right;padding-right:5px;}
.kiri{text-align:left;padding-left:5px;}
</style>
<?php 
	echo isset($javacode) ? $javacode : '';
	echo isset($url) ? $url : '';
	echo isset($actionpage) ? form_open($actionpage) : '';
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="3">FORM CLOSING SPPU DENGAN OBYEK UANG</th>
	</tr>
<tbody>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">SPPU</td>
		<td><input type="text" name="sppu" id="sppu" size="30" maxlength="15"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status SPPU</td>
		<td>Closed <input type="radio" name="status_sppu" value="1" checked="checked"/> Opened <input type="radio" name="status_sppu" value="0" /></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status Adhoc</td>
		<td>Ya <input type="radio" name="status_adhoc" value="1" /> Tidak <input type="radio" name="status_adhoc" value="0" checked="checked"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status Remis</td>
		<td>Ya <input type="radio" name="remis" value="1" /> Tidak <input type="radio" name="remis" value="0" checked="checked"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Tanggal</td>
		<td><input type="text" name="tanggal" id="tanggal" size="30" /></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Pelanggan</td>
		<td><?php echo isset($select_customer) ? $select_customer : ''; ?></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Asal</td>
		<td><?php echo isset($select_asal) ? $select_asal : ''; ?></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Berangkat / Serah Terima</td>
		<td><input type="text" name="berangkat" id="berangkat" size="30" /> / <input type="text" name="serah_brkt" id="serah_brkt" size="30" /></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Tujuan</td>
		<td><?php echo isset($select_tujuan) ? $select_tujuan : ''; ?></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Tiba / Serah Terima</td>
		<td><input type="text" name="tiba" id="tiba" size="30" /> / <input type="text" name="serah_tiba" id="serah_tiba" size="30" /></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Staf</td>
		<td><?php echo isset($select_staff) ? $select_staff : ''; ?></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status Pengambilan</td>
		<td>Brangkas <input type="radio" name="ambil" value="1"/> Pelanggan <input type="radio" name="ambil" value="0" checked="checked"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status Brangkas</td>
		<td>Simpan <input type="radio" name="status_brangkas" value="1"/> Tidak <input type="radio" name="status_brangkas" value="0" checked="checked"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Status Sortir</td>
		<td><select name="status_sortir" id="status_sortir" style="width:183px;">
			<option value="0" selected="selected">-- Pilih Status Sortir --</option>
			<option value="1">Sortir</option>
			<option value="2">Tidak Sortir</option>
		</select></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</tbody>
</table>
<div id="layak">
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="5">UANG LAYAK</th>	
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th width="140">Nominal</th>
		<th width="200">Lembar/Keping</th>
		<th width="100">Jumlah</th>
		<th>&nbsp;</th>
	</tr>
<tbody>
	<tr>
		<td>&nbsp;</td>
		<td>100.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_100rb" id="de_100rb"/></td>
		<td align="right"><div id="denom_100rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>50.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_50rb" id="de_50rb"/></td>
		<td align="right"><div id="denom_50rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>20.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_20rb" id="de_20rb"/></td>
		<td align="right"><div id="denom_20rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>10.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_10rb" id="de_10rb"/></td>
		<td align="right"><div id="denom_10rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>5.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_5rb" id="de_5rb"/></td>
		<td align="right"><div id="denom_5rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>2.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_2rb" id="de_2rb"/></td>
		<td align="right"><div id="denom_2rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>1.000</td>
		<td><input type="text" size="30" maxlength="5" name="de_1rb" id="de_1rb"/></td>
		<td align="right"><div id="denom_1rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>1000 logam</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_1000" id="dcoin_1000"/></td>
		<td align="right"><div id="denom_1000_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>500</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_500" id="dcoin_500"/></td>
		<td align="right"><div id="denom_500_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>200</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_200" id="dcoin_200"/></td>
		<td align="right"><div id="denom_200_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>100</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_100" id="dcoin_100"/></td>
		<td align="right"><div id="denom_100_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>50</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_50" id="dcoin_50"/></td>
		<td align="right"><div id="denom_50_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>25</td>
		<td><input type="text" size="30" maxlength="5" name="dcoin_25" id="dcoin_25"/></td>
		<td align="right"><div id="denom_25_logam"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</tbody>
	<tr>
		<th>&nbsp;</th>
		<th>Total</th>
		<th>&nbsp;</th>
		<th><div id="totalnya"></div></th>
		<th>&nbsp;</th>
	</tr>

</table><br/>
</div>

<div id="tak_layak">
<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr>
		<th colspan="5">UANG TAK LAYAK</th>	
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th width="140">Nominal</th>
		<th width="200">Lembar/Keping</th>
		<th width="100">Jumlah</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>100.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng100" id="ng100"/></td>
		<td align="right"><div id="nogood_100rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>50.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng50" id="ng50"/></td>
		<td align="right"><div id="nogood_50rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>20.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng20" id="ng20"/></td>
		<td align="right"><div id="nogood_20rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>10.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng10" id="ng10"/></td>
		<td align="right"><div id="nogood_10rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>5.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng5" id="ng5"/></td>
		<td align="right"><div id="nogood_5rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>2.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng2" id="ng2"/></td>
		<td align="right"><div id="nogood_2rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>1.000</td>
		<td><input type="text" size="30" maxlength="10" name="ng1" id="ng1"/></td>
		<td align="right"><div id="nogood_1rb"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>1000 logam</td>
		<td><input type="text" size="30" maxlength="10" name="ngl1000" id="ngl1000"/></td>
		<td align="right"><div id="nogood_1000"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>500</td>
		<td><input type="text" size="30" maxlength="10" name="ngl500" id="ngl500"/></td>
		<td align="right"><div id="nogood_500"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>200</td>
		<td><input type="text" size="30" maxlength="10" name="ngl200" id="ngl200"/></td>
		<td align="right"><div id="nogood_200"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>100</td>
		<td><input type="text" size="30" maxlength="10" name="ngl100" id="ngl100"/></td>
		<td align="right"><div id="nogood_100"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>50</td>
		<td><input type="text" size="30" maxlength="10" name="ngl50" id="ngl50"/></td>
		<td align="right"><div id="nogood_50"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>25</td>
		<td><input type="text" size="30" maxlength="10" name="ngl25" id="ngl25"/></td>
		<td align="right"><div id="nogood_25"></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<th align="left">Total</th>
		<th align="left">&nbsp;</th>
		<th align="right"><div id="total_reject"></div></th>
		<th>&nbsp;</th>
	</tr>
	
</table><br/>
</div>
<div id="non_sortir">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">Total Uang</td>
		<td><input type="text" name="total_duit" id="total_duit" size="30" maxlength="15"/></td>
	</tr>
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>	
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	
	<tr>
		<td width="285">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td><input type="submit" value=" Kirim " style="width:120px;height:30px" class="sbsubmit"/></td>
	</tr>
</table>
<?php echo isset($actionpage) ? form_close() : ''; ?>