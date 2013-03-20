$(document).ready(function(){
	$("#lokasi").focus();
	
	$(".submit").click(function(){
		var lokasi= $("#lokasi").val();
		
		if(lokasi == '')
		{
			alert("Lokasi Harus Diisi !");
			$("#lokasi").focus();
			return false;
		}
	});
});