$(document).ready(function(){
	$("#pegawai").focus();
	$(".submit").click(function(){
		var pegawai= $("#pegawai").val();
		var npp= $("#npp").val();
		var cabang= $("#cabang").val();
		var jabatan= $("#jabatan").val();
		
		if(pegawai == '')
		{
			alert("Nama Pegawai Harus Diisi !");
			$("#pegawai").focus();
			return false;
		}
		if(npp == '')
		{
			alert("NPP Pegawai Harus Diisi !");
			$("#npp").focus();
			return false;
		}
		if(cabang == 0)
		{
			alert("Cabang Pegawai Harus Dipilih !");
			$("#cabang").focus();
			return false;
		}
		if(jabatan == 0)
		{
			alert("Jabatan Pegawai Harus Dipilih !");
			$("#jabatan").focus();
			return false;
		}
	});
});