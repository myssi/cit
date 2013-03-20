$(document).ready(function(){
	$("#nasabah").focus();
	
	$(".submit").click(function(){
		var lokasi= $("#lokasi").val();
		var nasabah= $("#cabang").val();
		var kota= $("#kota").val()
		var cabang= $("#cabang").val();
		
		if(cabang)
		if(lokasi == '')
		{
			alert("Lokasi Harus Diisi !");
			$("#lokasi").focus();
			return false;
		}
		if(kota == '')
		{
			alert("Kota Harus Diisi !");
			$("#kota").focus();
			return false;
		}
		if(cabang == '')
		{
			alert("Cabang Harus Diisi !");
			$("#cabang").focus();
			return false;
		}
	});
});