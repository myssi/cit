$(document).ready(function(){
	$("#tgla").datepicker({dateFormat:"dd-mm-yy"});
	$("#tglb").datepicker({dateFormat:"dd-mm-yy"});


	$("#sbproses").click(function(){
		var tanggala= $("#tgla").val();
		var tanggalb= $("#tglb").val();
		var nasabah= $("#nasabah").val();
		
		if(tanggala == '')
		{
			alert("Tanggal Periode Harus Diisi !");
			$("#tgla").focus();
			return false;
		}
		if(tanggalb == '')
		{
			alert("Tanggal Periode Harus Diisi !");
			$("#tglb").focus();
			return false;
		}
		
		if(nasabah == 0)
		{
			alert("Nasabah harus Dipilih !");
			$("#nasabah").focus();
			return false;
		}
	});
});