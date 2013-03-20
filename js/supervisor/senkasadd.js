$(document).ready(function(){
	$(".submit").click(function(){
		var senkas= $("#senkas").val();
		var kode= $("#kode").val();
		
		if(senkas == '')
		{
			alert("Senkas Harus diisi !");
			$("#senkas").focus();
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