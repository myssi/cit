$(document).ready(function(){
	$(".submit").click(function(){
		var nasabah= $("#nasabah").val();
		var kode= $("#kode").val();
		
		if(nasabah == '')
		{
			alert("Nasabah Harus diisi !");
			$("#nasabah").focus();
			return false;
		}
		if(kode == '')
		{
			alert("Kode Harus Diisi !");
			$("#kode").focus();
			return false;
		}
		
	});
});