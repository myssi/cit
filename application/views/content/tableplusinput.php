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
.isi, .isi a
{
	font-family:Arial, Helvetica, sans-serif;
	color:#000000;
	font-size: 0.9em;
	height:1.8em;
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
.kanan{text-align:right;padding-right:5px;}
.kiri{text-align:left;padding-left:5px;}
</style>
<?php 
	echo isset($javacode) ? $javacode : '';
	
	echo isset($actionpage) ? form_open($actionpage) : '';
	echo isset($url) ? $url : '';
	echo isset($table) ? $table : '';
	echo isset($actionpage) ? form_close() : '';
?>

