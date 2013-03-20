$(document).ready(function(){
	$("#sppu").focus();
	$("#tipe_status").hide();
	$("#layak").hide();
	$("#tak_layak").hide();
	$("#non_sortir").hide();
	$("#status").change(function(){
		var status= $("#status").val();
		
		if(status != 4 && status !=0)
		{
			$("#tipe_status").show();
			$("#tipe_hitung").val('0');
			$("#layak").hide();
			$("#tak_layak").hide();
			$("#non_sortir").hide();
			
			clearfield();
		}
		else
		{
			$("#tipe_status").hide();
			$("#layak").hide();
			$("#tak_layak").hide();
			$("#non_sortir").hide();
		}
	});
	
	$("#tipe_hitung").change(function(){
		var status= $("#status").val();
		var tipe= $("#tipe_hitung").val();
		clearfield();
		
		if(tipe == 1)
		{
			if(status == 1)
			{
				$("#layak").show();
				$("#de_100rb").focus();
				$("#tak_layak").hide();
				$("#non_sortir").hide();
			}
			else
			{
				$("#layak").show();
				$("#tak_layak").show();
				$("#de_100rb").focus();
				$("#non_sortir").hide();
			}
		}
		else if(tipe == 2)
		{
			$("#layak").hide();
			$("#tak_layak").hide();
			$("#non_sortir").show();
			$("#total_duit").focus();
		}
		else
		{
			$("#layak").hide();
			$("#tak_layak").hide();
			$("#non_sortir").hide();
		}
	});

/*=========================== ACCEPTED MONEY ==========================*/
	
	$("#de_100rb").keyup(function(){
		var vdenom100rb= $("#de_100rb").val();
		
		if(isNaN(vdenom100rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom100rb= vdenom100rb*100000;
			desimal= tiga_angka(vdenom100rb);
			$("#denom_100rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#de_50rb").keyup(function(){
		var vdenom50rb= $("#de_50rb").val();
		
		if(isNaN(vdenom50rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom50rb= vdenom50rb*50000;
			desimal= tiga_angka(vdenom50rb);
			$("#denom_50rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
			
		}
	});
	
	$("#de_20rb").keyup(function(){
		var vdenom20rb= $("#de_20rb").val();
		
		if(isNaN(vdenom20rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom20rb= vdenom20rb*20000;
			desimal= tiga_angka(vdenom20rb);
			$("#denom_20rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#de_10rb").keyup(function(){
		var vdenom10rb= $("#de_10rb").val();
		
		if(isNaN(vdenom10rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom10rb= vdenom10rb*10000;
			desimal= tiga_angka(vdenom10rb);
			$("#denom_10rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#de_5rb").keyup(function(){
		var vdenom5rb= $("#de_5rb").val();
		
		if(isNaN(vdenom5rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom5rb= vdenom5rb*5000;
			desimal= tiga_angka(vdenom5rb);
			$("#denom_5rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#de_2rb").keyup(function(){
		var vdenom2rb= $("#de_2rb").val();
		
		if(isNaN(vdenom2rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom2rb= vdenom2rb*2000;
			desimal= tiga_angka(vdenom2rb);
			$("#denom_2rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#de_1rb").keyup(function(){
		var vdenom1rb= $("#de_1rb").val();
		if(isNaN(vdenom1rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom1rb= vdenom1rb*1000;
			desimal= tiga_angka(vdenom1rb);
			$("#denom_1rb").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_1000").keyup(function(){
		var vdenom1000logam= $("#dcoin_1000").val();
		
		if(isNaN(vdenom1000logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom1000logam= vdenom1000logam*1000;
			desimal= tiga_angka(vdenom1000logam);
			$("#denom_1000_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_500").keyup(function(){
		var vdenom500logam= $("#dcoin_500").val();
		
		if(isNaN(vdenom500logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom500logam= vdenom500logam*500;
			desimal= tiga_angka(vdenom500logam);
			$("#denom_500_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_200").keyup(function(){
		var vdenom200logam= $("#dcoin_200").val();
		
		if(isNaN(vdenom200logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom200logam= vdenom200logam*200;
			desimal= tiga_angka(vdenom200logam);
			$("#denom_200_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_100").keyup(function(){
		var vdenom100logam= $("#dcoin_100").val();
		
		if(isNaN(vdenom100logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom100logam= vdenom100logam*100;
			desimal= tiga_angka(vdenom100logam);
			$("#denom_100_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_50").keyup(function(){
		var vdenom50logam= $("#dcoin_50").val();
		
		if(isNaN(vdenom50logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom50logam= vdenom50logam*50;
			desimal= tiga_angka(vdenom50logam);
			$("#denom_50_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	$("#dcoin_25").keyup(function(){
		var vdenom25logam= $("#dcoin_25").val();
		
		if(isNaN(vdenom25logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			vdenom25logam= vdenom25logam*25;
			desimal= tiga_angka(vdenom25logam);
			$("#denom_25_logam").html(desimal);
			
			total= total_layak();
			$("#totalnya").html(total);
		}
	});
	
	
/*============================ REJECTED MONEY ================================================*/
$("#ng100").keyup(function(){
		var ng100rb= $("#ng100").val();
		
		if(isNaN(ng100rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng100rb= ng100rb*100000;
			desimal= tiga_angka(ng100rb);
			$("#nogood_100rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng50").keyup(function(){
		var ng50rb= $("#ng50").val();
		
		if(isNaN(ng50rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng50rb= ng50rb*50000;
			desimal= tiga_angka(ng50rb);
			$("#nogood_50rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng20").keyup(function(){
		var ng20rb= $("#ng20").val();
		
		if(isNaN(ng20rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng20rb= ng20rb*20000;
			desimal= tiga_angka(ng20rb);
			$("#nogood_20rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng10").keyup(function(){
		var ng10rb= $("#ng10").val();
		
		if(isNaN(ng10rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng10rb= ng10rb*10000;
			desimal= tiga_angka(ng10rb);
			$("#nogood_10rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng5").keyup(function(){
		var ng5rb= $("#ng5").val();
		
		if(isNaN(ng5rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng5rb= ng5rb*5000;
			desimal= tiga_angka(ng5rb);
			$("#nogood_5rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng2").keyup(function(){
		var ng2rb= $("#ng2").val();
		
		if(isNaN(ng2rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng2rb= ng2rb*2000;
			desimal= tiga_angka(ng2rb);
			$("#nogood_2rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ng1").keyup(function(){
		var ng1rb= $("#ng1").val();
		
		if(isNaN(ng1rb) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng1rb= ng1rb*1000;
			desimal= tiga_angka(ng1rb);
			$("#nogood_1rb").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl1000").keyup(function(){
		var ng1000logam = $("#ngl1000").val();
		
		if(isNaN(ng1000logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng1000logam= ng1000logam*1000;
			desimal= tiga_angka(ng1000logam);
			$("#nogood_1000").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl500").keyup(function(){
		var ng500logam = $("#ngl500").val();
		
		if(isNaN(ng500logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng500logam= ng500logam*500;
			desimal= tiga_angka(ng500logam);
			$("#nogood_500").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl200").keyup(function(){
		var ng200logam = $("#ngl200").val();
		
		if(isNaN(ng200logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng200logam= ng200logam*200;
			desimal= tiga_angka(ng200logam);
			$("#nogood_200").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl100").keyup(function(){
		var ng100logam = $("#ngl100").val();
		
		if(isNaN(ng100logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng100logam= ng100logam*100;
			desimal= tiga_angka(ng100logam);
			$("#nogood_100").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl50").keyup(function(){
		var ng50logam = $("#ngl50").val();
		
		if(isNaN(ng50logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng50logam= ng50logam*50;
			desimal= tiga_angka(ng50logam);
			$("#nogood_50").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#ngl25").keyup(function(){
		var ng25logam = $("#ngl25").val();
		
		if(isNaN(ng25logam) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
		else
		{
			ng25logam= ng25logam*25;
			desimal= tiga_angka(ng25logam);
			$("#nogood_25").html(desimal);
			
			total= total_taklayak();
			$("#total_reject").html(total);
		}
	});
	
	$("#total_duit").keyup(function(){
		var totalduit= $("#total_duit").val();
		
		if(isNaN(totalduit) == true)
		{
			alert("Anda Harus Memasukkan Nilai Numerik !");
			return false;
		}
	});
	
/*================= Submit Check =================================*/
	$(".sbsubmit").click(function(){
		var sppu= $("#sppu").val();
		var customer= $("#customer").val();
		var asal= $("#asal").val();
		var tujuan= $("#tujuan").val();
		var staff= $("#staff").val();
		var status= $("#status").val();
		var tipe_hitung= $("#tipe_hitung").val();
		var total_duit= $("#total_duit").val();
		
		if(sppu == '')
		{
			alert("SPPU Harus Diisi !");
			$("#sppu").focus();
			return false;
		}
		if(customer == 0)
		{
			alert("Pelanggan Harus Dipilih !");
			$("#customer").focus();
			return false;
		}
		if(asal == 0)
		{
			alert("Lokasi Asal Harus Dipilih !");
			$("#asal").focus();
			return false;
		}
		if(tujuan == 0)
		{
			alert("Lokasi Tujuan Harus Dipilih !");
			$("#tujuan").focus();
			return false;
		}
		if(staff == 0)
		{
			alert("Staf Harus Dipilih !");
			$("#staff").focus();
			return false;
		}
		if(status == 0)
		{
			alert("Status Harus Dipilih !");
			$("#status").focus();
			return false;
		}
		if(status != 4 && status != 0)
		{
			if(tipe_hitung == 0)
			{
				alert("Tipe Hitung Uang Harus Dipilih !");
				$("#tipe_hitung").focus();
				return false;
			}
			else if(tipe_hitung == 2)
			{
				if(total_duit == '')
				{
					alert("Total Uang Harus Dipilih !");
					$("#total_duit").focus();
					return false;
				}
			}
		}
		
	});
	
});

function clearfield()
{
	$("#de_100rb").val('');
	$("#de_50rb").val('');
	$("#de_20rb").val('');
	$("#de_10rb").val('');
	$("#de_5rb").val('');
	$("#de_2rb").val('');
	$("#de_1rb").val('');
	$("#dcoin_1000").val('');
	$("#dcoin_500").val('');
	$("#dcoin_200").val('');
	$("#dcoin_100").val('');
	$("#dcoin_50").val('');
	$("#dcoin_25").val('');
	
	$("#denom_100rb").html('');
	$("#denom_50rb").html('');
	$("#denom_20rb").html('');
	$("#denom_10rb").html('');
	$("#denom_5rb").html('');
	$("#denom_2rb").html('');
	$("#denom_1rb").html('');
	$("#denom_1000_logam").html('');
	$("#denom_500_logam").html('');
	$("#denom_200_logam").html('');
	$("#denom_100_logam").html('');
	$("#denom_50_logam").html('');
	$("#denom_25_logam").html('');
	$("#totalnya").html('');
	
	$("#ng100").val('');
	$("#ng50").val('');
	$("#ng20").val('');
	$("#ng10").val('');
	$("#ng5").val('');
	$("#ng2").val('');
	$("#ng1").val('');
	$("#ngl1000").val('');
	$("#ngl500").val('');
	$("#ngl200").val('');
	$("#ngl100").val('');
	$("#ngl50").val('');
	$("#ngl25").val('');
	
	$("#nogood_100rb").html('');
	$("#nogood_50rb").html('');
	$("#nogood_20rb").html('');
	$("#nogood_10rb").html('');
	$("#nogood_5rb").html('');
	$("#nogood_2rb").html('');
	$("#nogood_1rb").html('');
	$("#nogood_1000").html('');
	$("#nogood_500").html('');
	$("#nogood_200").html('');
	$("#nogood_100").html('');
	$("#nogood_50").html('');
	$("#nogood_25").html('');
	$("#total_reject").html('');
	
	$("#total_duit").val('');
}
function total_layak()
{
	var ribu100= $("#de_100rb").val();
	var ribu50 = $("#de_50rb").val();
	var ribu20 = $("#de_20rb").val();
	var ribu10 = $("#de_10rb").val();
	var ribu5 = $("#de_5rb").val();
	var ribu2 = $("#de_2rb").val();
	var ribu1 = $("#de_1rb").val();
	var logam1000 = $("#dcoin_1000").val();
	var logam500 = $("#dcoin_500").val();
	var logam200 = $("#dcoin_200").val();
	var logam100 = $("#dcoin_100").val();
	var logam50 = $("#dcoin_50").val();
	var logam25 = $("#dcoin_25").val();
	
	if(ribu100 == ''){ribu100= 0;}
	if(ribu50 == ''){ribu50= 0;}
	if(ribu20 == ''){ribu20= 0;}
	if(ribu10 == ''){ribu10= 0;}
	if(ribu5 == ''){ribu5= 0;}
	if(ribu2 == ''){ribu2= 0;}
	if(ribu1 == ''){ribu1= 0;}
	if(logam1000 == ''){logam1000=0;}
	if(logam500 == ''){logam500= 0;}
	if(logam200 == ''){logam200= 0;}
	if(logam100 == ''){logam100= 0;}
	if(logam50 == ''){logam50= 0;}
	if(logam25 == ''){logam25= 0;}
	
	total= (ribu100*100000)+(ribu50*50000)+(ribu20*20000)+(ribu10*10000)+(ribu5*5000)+(ribu2*2000)+(ribu1*1000)+(logam1000*1000)+(logam500*500)+(logam200*200)+(logam100*100)+(logam50*50)+(logam25*25);
	total= tiga_angka(total);
	return total;
}

function total_taklayak()
{
	var ribu100= $("#ng100").val();
	var ribu50 = $("#ng50").val();
	var ribu20 = $("#ng20").val();
	var ribu10 = $("#ng10").val();
	var ribu5 = $("#ng5").val();
	var ribu2 = $("#ng2").val();
	var ribu1 = $("#ng1").val();
	var logam1000 = $("#ngl1000").val();
	var logam500 = $("#ngl500").val();
	var logam200 = $("#ngl200").val();
	var logam100 = $("#ngl100").val();
	var logam50 = $("#ngl50").val();
	var logam25 = $("#ngl25").val();
	
	if(ribu100 == ''){ribu100= 0;}
	if(ribu50 == ''){ribu50= 0;}
	if(ribu20 == ''){ribu20= 0;}
	if(ribu10 == ''){ribu10= 0;}
	if(ribu5 == ''){ribu5= 0;}
	if(ribu2 == ''){ribu2= 0;}
	if(ribu1 == ''){ribu1= 0;}
	if(logam1000 == ''){logam1000=0;}
	if(logam500 == ''){logam500= 0;}
	if(logam200 == ''){logam200= 0;}
	if(logam100 == ''){logam100= 0;}
	if(logam50 == ''){logam50= 0;}
	if(logam25 == ''){logam25= 0;}
	
	total= (ribu100*100000)+(ribu50*50000)+(ribu20*20000)+(ribu10*10000)+(ribu5*5000)+(ribu2*2000)+(ribu1*1000)+(logam1000*1000)+(logam500*500)+(logam200*200)+(logam100*100)+(logam50*50)+(logam25*25);
	total= tiga_angka(total);
	return total; 
}

function tiga_angka(d)
{
	var pkarakter= d+''; // harus diconvert dari numeric ke String;
	panj= pkarakter.length;
	if(panj > 3)
	{
		walik= strrev(pkarakter);
		sisa= panj%3;
		
		if(sisa > 0)
		{
			hsl= Math.ceil(panj/3);
			hsl= hsl-1;
		}
		else{ hsl= panj/3;}
		
		var hasil= "";
		var k= 0;
		
		for(j=1;j <= hsl; ++j)
		{
			o= walik.substr(k,3);
			k=k+3;
			if(j == hsl)
			{
				hasil= hasil+o;
			}
			else if(hsl == 1) {hasil= hasil+o;}
			else{ hasil= hasil+o+".";}
		}
		
		if(sisa > 0)
		{
			g= walik.substr(k,sisa);
			hasil= hasil+"."+g;
		}
		hasil= strrev(hasil);
	}
	else{ hasil= pkarakter;}
	return hasil;
}

function strrev (string) {
    // Reverse a string  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/strrev    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: strrev('Kevin van Zonneveld');
    // *     returns 1: 'dlevennoZ nav niveK'    // *     example 2: strrev('a\u0301haB') === 'Baha\u0301'; // combining
    // *     returns 2: true
    // *     example 3: strrev('A\uD87E\uDC04Z') === 'Z\uD87E\uDC04A'; // surrogates
    // *     returns 2: true
    string = string + ''; 
    // Performance will be enhanced with the next two lines of code commented
    //      out if you don't care about combining characters
    // Keep Unicode combining characters together with the character preceding
    //      them and which they are modifying (as in PHP 6)    // See http://unicode.org/reports/tr44/#Property_Table (Me+Mn)
    // We also add the low surrogate range at the beginning here so it will be
    //      maintained with its preceding high surrogate
    var grapheme_extend = /(.)([\uDC00-\uDFFF\u0300-\u036F\u0483-\u0489\u0591-\u05BD\u05BF\u05C1\u05C2\u05C4\u05C5\u05C7\u0610-\u061A\u064B-\u065E\u0670\u06D6-\u06DC\u06DE-\u06E4\u06E7\u06E8\u06EA-\u06ED\u0711\u0730-\u074A\u07A6-\u07B0\u07EB-\u07F3\u0901-\u0903\u093C\u093E-\u094D\u0951-\u0954\u0962\u0963\u0981-\u0983\u09BC\u09BE-\u09C4\u09C7\u09C8\u09CB-\u09CD\u09D7\u09E2\u09E3\u0A01-\u0A03\u0A3C\u0A3E-\u0A42\u0A47\u0A48\u0A4B-\u0A4D\u0A51\u0A70\u0A71\u0A75\u0A81-\u0A83\u0ABC\u0ABE-\u0AC5\u0AC7-\u0AC9\u0ACB-\u0ACD\u0AE2\u0AE3\u0B01-\u0B03\u0B3C\u0B3E-\u0B44\u0B47\u0B48\u0B4B-\u0B4D\u0B56\u0B57\u0B62\u0B63\u0B82\u0BBE-\u0BC2\u0BC6-\u0BC8\u0BCA-\u0BCD\u0BD7\u0C01-\u0C03\u0C3E-\u0C44\u0C46-\u0C48\u0C4A-\u0C4D\u0C55\u0C56\u0C62\u0C63\u0C82\u0C83\u0CBC\u0CBE-\u0CC4\u0CC6-\u0CC8\u0CCA-\u0CCD\u0CD5\u0CD6\u0CE2\u0CE3\u0D02\u0D03\u0D3E-\u0D44\u0D46-\u0D48\u0D4A-\u0D4D\u0D57\u0D62\u0D63\u0D82\u0D83\u0DCA\u0DCF-\u0DD4\u0DD6\u0DD8-\u0DDF\u0DF2\u0DF3\u0E31\u0E34-\u0E3A\u0E47-\u0E4E\u0EB1\u0EB4-\u0EB9\u0EBB\u0EBC\u0EC8-\u0ECD\u0F18\u0F19\u0F35\u0F37\u0F39\u0F3E\u0F3F\u0F71-\u0F84\u0F86\u0F87\u0F90-\u0F97\u0F99-\u0FBC\u0FC6\u102B-\u103E\u1056-\u1059\u105E-\u1060\u1062-\u1064\u1067-\u106D\u1071-\u1074\u1082-\u108D\u108F\u135F\u1712-\u1714\u1732-\u1734\u1752\u1753\u1772\u1773\u17B6-\u17D3\u17DD\u180B-\u180D\u18A9\u1920-\u192B\u1930-\u193B\u19B0-\u19C0\u19C8\u19C9\u1A17-\u1A1B\u1B00-\u1B04\u1B34-\u1B44\u1B6B-\u1B73\u1B80-\u1B82\u1BA1-\u1BAA\u1C24-\u1C37\u1DC0-\u1DE6\u1DFE\u1DFF\u20D0-\u20F0\u2DE0-\u2DFF\u302A-\u302F\u3099\u309A\uA66F-\uA672\uA67C\uA67D\uA802\uA806\uA80B\uA823-\uA827\uA880\uA881\uA8B4-\uA8C4\uA926-\uA92D\uA947-\uA953\uAA29-\uAA36\uAA43\uAA4C\uAA4D\uFB1E\uFE00-\uFE0F\uFE20-\uFE26]+)/g;
    string = string.replace(grapheme_extend, '$2$1'); // Temporarily reverse    
	return string.split('').reverse().join('');
}