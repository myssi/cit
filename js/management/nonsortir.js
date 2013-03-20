function openprinter(urlprint)
{
	/*alert(urlprint);
	return false;*/
	
	var lebar= 1200;
	var tinggi= 1024;
	var kiri= (screen.width/2)-(lebar/2);
	var atas= (screen.height/2)-(tinggi/2);
	window.open(urlprint,'','width='+lebar+', height='+tinggi+',scrollbars=yes,left='+kiri+',top='+atas+'');
}