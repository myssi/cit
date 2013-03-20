$(document).ready(function(){
	$(".submit").click(function(){
		var nasabah= $("#nasabah").val();
		var bank= $("#bank").val();
		var cabang= $("#cabang").val();
		
		if(nasabah == 0)
		{
			alert("Nasabah Harus Dipilih !");
			$("#nasabah").focus();
			return false;
		}
		
		if(bank == 0)
		{
			alert("Bank Harus Dipilih !");
			$("#bank").focus();
			return false;
		}
		
		if(cabang == 0)
		{
			alert("Cabang Harus Dipilih !");
			$("#cabang").focus();
			return false;
		}
	});
	
	$("#bank").change(function(){
		var url= $("#urlolah").val();
		var bank= $("#bank").serialize();
		
		$.post(url,bank,function(response){
			$("#divisi").fadeIn(function(){
				$("#divisi").html(response);
			});
		});
	});
	
});