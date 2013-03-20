<style type="text/css">
.headtable
{
	background: #000000;
	color:#ffffff;
	font-family: Arial, Helvetica, sans-serif;
	font-size:0.9em;
	text-align: center;
	height:2em;
	
}

.footertable
{
	font-family: Arial, Helvetica, sans-serif;
	font-size:0.9em;
	text-align: center;
	font-weight:bold;
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
.isi, .isi a,a
{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 12px;
	height:1.7em;
}

#kop
{
	width:40%;
	margin-left:auto;
	margin-right:auto;
	font-family:Arial, Helvetica, sans-serif;

}

.tengah{text-align:center;}
.kanan{text-align:right;padding-right:5px;}
.kiri{text-align:left;padding-left:5px;}
</style>
<?php 
	echo isset($scriptjava) ? $scriptjava : '';
	echo isset($periode) ? '<div id="kop">'.$periode.'</div><br/>' : '';
	echo isset($printer) ? '<a href="#" class="print" onclick="openprinter(\''.site_url('management/nonsortir/cetaktagihan').'\')">Detil Tagihan</a> '
	.'<a href="#" class="print" onclick="openprinter(\''.site_url('management/nonsortir/cetakrekap').'\')">Rekap Tagihan</a>' : '';
	echo isset($table) ? $table : '';
	
?>