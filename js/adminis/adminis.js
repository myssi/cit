$(document).ready(function(){
	$(".sbsubmit").click(function(){
		var username= $("#username").val();
		var password= $("#password").val();
		var konfirmasi= $("#konfirmasi").val();
		var level= $("#level").val();
		var cabang= $("#cabang").val();
		
		if(username == '')
		{
			alert("Username Harus Diisi !");
			$("#username").focus();
			return false;
		}
		if(password == '')
		{
			alert("Password Harus Diisi !");
			$("#password").focus();
			return false;
		}
		if(konfirmasi == '')
		{
			alert("Konfirmasi Harus Diisi !");
			$("#konfirmasi").focus();
			return false;
		}
		if(konfirmasi != password)
		{
			alert("Password Tidak Sama Dengan Konfirmasi !");
			$("#konfirmasi").val('');
			$("#password").val('');
			$("#password").focus();
			return false;
		}
		if(level == 0)
		{
			alert("Level Harus Dipilih !");
			$("#level").focus();
			return false;
		}
		if(level != 5 && level != 2)
		{
			if(cabang == 0)
			{
				alert("Cabang Harus Dipilih !");
				$("#cabang").focus();
				return false;
			}
		}
		
	});
});