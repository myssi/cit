$(document).ready(function(){
$("#nasabah").focus();
$("#tglharga").datepicker({dateFormat:"dd-mm-yy"});

$(".submit").click(function(){
	var nasabah= $("#nasabah").val();
	var harga= $("#harga").val();
	var tgl= $("#tglharga").val();
	
	if(nasabah == 0)
	{
		alert("Nasabah Harus Dipilih !");
		$("#nasabah").focus();
		return false;
	}
	if(harga == '')
	{
		alert("Harga Harus Diisi !");
		$("#harga").focus();
		return false;
	}
	if(tgl == '')
	{
		alert("Tanggal Harus Diisi !");
		$("#tglharga").focus();
		return false;
	}
});
});