$(document).ready(function(){
	$("#tanggalberlaku").datepicker({dateFormat:"dd-mm-yy"});
	$("#lokasi").focus();
	$(".submit").click(function(){
		var lokasi= $("#lokasi").val();
		var harga= $("#harga").val();
		var tanggal= $("#tanggalberlaku").val();
		
		if(lokasi == '0')
		{
			alert("Lokasi Harus Dipilih !");
			$("#lokasi").focus();
			return false;
		}
		if(harga == null || harga == '')
		{
			alert("Harga Harus Diisi !");
			$("#harga").focus();
			return false;
		}
		if(tanggal == null || tanggal == '')
		{
			alert("Tanggal Berlaku Harus Diisi !");
			$("#tanggalberlaku").focus();
			return false;
		}
	});
	
	$("#lokasi").change(function(){
		var urlkota= $("#urlkota").val();
		var urlcabang= $("#urlcabang").val();
		var urlnasabah= $("#urlnasabah").val();
		var idlokasi= $("#lokasi").serialize();
		
		$.post(urlkota,idlokasi,function(response){
			$("#kota").fadeIn(function(){
				$("#kota").html(response);
			});
		});
		
		$.post(urlcabang,idlokasi,function(response){
			$("#cabang").fadeIn(function(){
				$("#cabang").html(response);
			});
		});
		
		$.post(urlnasabah,idlokasi,function(response){
			$("#nasabah").fadeIn(function(){
				$("#nasabah").html(response);
			});
		});
	
	});
	
	
});