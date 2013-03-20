$(document).ready(function(){
	$(".submit").click(function(){
		var bank= $("#bank").val();
		var divisi= $("#divisi").val();
		
		if(bank == 0)
		{
			alert("Bank Harus dipilih !");
			$("#bank").focus();
			return false;
		}
		if(divisi == '')
		{
			alert("Divisi Harus Diisi !");
			$("#divisi").focus();
			return false;
		}
		
	});
});