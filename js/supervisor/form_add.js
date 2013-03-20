$(document).ready(function(){
	$("#sbsave").click(function(){
		var nama= $("#nama").val();
		var singkat= $("#singkat").val();
		if(nama == '')
		{
			alert("Nama Bank Harus Diisi !");
			$("#nama").focus();
			return false;
		}
		if(singkat == '')
		{
			alert("Singkatan Bank Harus Diisi !");
			$("#singkat").focus();
			return false;
		}
		
	});
});