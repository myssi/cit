$(document).ready(function(){
	$("#oldpassword").focus();
	
	$(".submit").click(function(){
		var oldpass= $("#oldpassword").val();
		var newpass= $("#newpassword").val();
		var confirm= $("#confirm").val();
		
		if(oldpass == '')
		{
			alert("Password Lama Harus Diisi !");
			$("#oldpassword").focus();
			return false;
		}
		if(newpass == '')
		{
			alert("Password Baru Harus Diisi !");
			$("#newpassword").focus();
			return false;
		}
		if(confirm == '')
		{
			alert("Konfirmasi Password Baru Harus Diisi !");
			$("#confirm").focus();
			return false;
		}
		
		if(confirm != newpass)
		{
			alert("Konfirmasi Password Baru Harus Sama Dengan Password Baru !");
			$("#confirm").val('');
			$("#newpassword").val('');
			$("#newpassword").focus();
			return false;
		}
		
	});
});