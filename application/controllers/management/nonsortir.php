<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class NonSortir extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		
		$this->load->model('management/NonSortirModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['path']= 'Rekap > Paket';
			$data['nasabah']= $this->NonSortirModel->customer1();
			$data['contain']='content/management/form_nasabah';
			$data['navigation']= 'navigation/management';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function processcust()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			
			//Warning idnasabah as key for differ price
			
			$tanggal_a= $this->input->post('tgla');
			$tanggal_b= $this->input->post('tglb');
			$tanggal_surat= $this->input->post('tglsurat');
			$awal= strtotime($tanggal_a);
			$akhir= strtotime($tanggal_b);
			
			if($awal > $akhir)
			{
				$this->session->set_userdata('message_error','Tanggal Awal Harus Lebih Kecil');
				redirect('management/nonsortir');
			}
			
			$idnas= $this->input->post('nasabah');
			
			$session_nasabah= array(
			'tglawal'=>$awal,
			'tglakhir'=>$akhir,
			'tglsurat'=>$tanggal_surat,
			'idnasabah'=>$idnas
			);
			
			$this->session->set_userdata($session_nasabah);
			
			$nasabahview= $this->NonSortirModel->nonsortirview($awal,$akhir,$idnas);
			
			if(!empty($nasabahview))
			{
				$totaltrip= $this->NonSortirModel->totaljln($awal,$akhir,$idnas);
				
				$templatetable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
				);
				$this->table->set_template($templatetable);
				$this->table->set_empty("&nbsp;");
				$i= 0;
				
				$hno= array('data'=>'No','class'=>'headtable','width'=>40);
				$htgl= array('data'=>'Tanggal','class'=>'headtable','width'=>75);
				$hsppu= array('data'=>'SPPU','class'=>'headtable','width'=>70);
				$hdari= array('data'=>'Dari','class'=>'headtable');
				$htiba= array('data'=>'Tiba','class'=>'headtable','width'=>70);
				$hserahtrim= array('data'=>'Serah Terima','class'=>'headtable','width'=>70);
				$hke= array('data'=>'Ke','class'=>'headtable');
				$hnominal= array('data'=>'Nominal','class'=>'headtable');
				$hregular= array('data'=>'Regular','class'=>'headtable');
				$hadhoc= array('data'=>'ADHOC','class'=>'headtable','width'=>60);
				$hbatal= array('data'=>'Batal','class'=>'headtable');
				$hact= array('data'=>'Tindakan','class'=>'headtable');
				
				//$this->table->add_row($hno,$htgl,$hsppu,$hdari,$htiba,$hserahtrim,$hke,$htiba,$hserahtrim,$hnominal,$hregular,$hadhoc,$hbatal,$hact);
				$this->table->set_heading($hno,$htgl,$hsppu,$hdari,$htiba,$hserahtrim,$hke,$htiba,$hserahtrim,$hnominal,$hregular,$hadhoc,$hbatal,$hact);
				
				foreach($nasabahview as $nasview)
				{
					$act= anchor('management/nonsortir/remove_tag/'.$nasview->sppu,'Hapus',array('class'=>'delete','onclick'=>"return confirm('Apakah Anda yakin menghapus SPPU ini ?');"));
					$tanggal= date('d M',strtotime($nasview->tanggal));
					$nama= $nasview->nasabah;
					// separate time arrive+handover(from)
					$tdari= explode('-',$nasview->berangkat);
					$tibadari= trim($tdari[0]);
					$srhdari= trim($tdari[1]);
					
					//separate time arrive+handover(to)
					$tke= explode('-',$nasview->tiba);
					$tibake= trim($tke[0]);
					$srhke= trim($tke[1]);
					
					//print decimal with comma
					$nominal= $this->NonSortirModel->tri_desimal($nasview->nominal);
					$regular= $this->NonSortirModel->tri_desimal($nasview->hargapertrip);
					$pertrip= $nasview->hargapertrip;
					//adhoc flag
					if($nasview->adhoc == 0){$adhoc='none';}
					else{$adhoc= 'Adhoc';}
					
					if($nasview->status == 4){$batal='Cancel';}
					else{$batal='none';}
					//====================== Load to table ============================
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_tgl= array('data'=>$tanggal,'class'=>'isi tengah');
					$cell_sppu= array('data'=>$nasview->sppu,'class'=>'isi tengah');
					$cell_dari= array('data'=>$nasview->dari,'class'=>'isi tengah');
					$cell_tibadari= array('data'=>$tibadari,'class'=>'isi tengah');
					$cell_srhdari= array('data'=>$srhdari,'class'=>'isi tengah');
					
					$cell_ke= array('data'=>$nasview->ke,'class'=>'isi tengah');
					$cell_tibake= array('data'=>$tibake,'class'=>'isi tengah');
					$cell_srhke= array('data'=>$srhke,'class'=>'isi tengah');
					$cell_nom= array('data'=>$nominal,'class'=>'isi kanan');
					$cell_adhoc= array('data'=>$adhoc,'class'=>'isi tengah');
					$cell_regular= array('data'=>$regular,'class'=>'isi tengah');
					$cell_batal= array('data'=>$batal,'class'=>'isi tengah');
					
					$cell_act= array('data'=>$act,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_tgl,$cell_sppu,$cell_dari,$cell_tibadari,$cell_srhdari,$cell_ke,
					$cell_tibake,$cell_srhke,$cell_nom,$cell_regular,$cell_adhoc,$cell_batal,$cell_act);
				}
				
				//Total delivery cash
				$totuangdelivery= $this->NonSortirModel->totaluang($awal,$akhir,$idnas);
				$uangtot= $this->NonSortirModel->tri_desimal($totuangdelivery['nominal']);
				//$this->table->add_row('','','','','','','','','','','','','');
				$hangkut= array('data'=>'Total yang diangkut','class'=>'footertable kiri','colspan'=>9);
				$cell_angkut= array('data'=>$uangtot,'class'=>'footertable tengah');
				$this->table->add_row($hangkut,$cell_angkut,'','','','');
				
				//Total Tagihan
				$tottagih= $pertrip*$totaltrip;
				$tagihan= $this->NonSortirModel->tri_desimal($tottagih);
				$cell_tagihan= array('data'=>$tagihan,'class'=>'footertable tengah');
				$htagihan= array('data'=>'Total Tagihan','class'=>'footertable kiri','colspan'=>9);
				$this->table->add_row($htagihan,'',$cell_tagihan,'','','');
				
				// Total Trip
				$htrip= array('data'=>'Total Perjalanan','class'=>'footertable kiri','colspan'=>9);
				$cell_ttrip= array('data'=>$totaltrip,'class'=>'footertable tengah');
				$this->table->add_row($htrip,'',$cell_ttrip,'','','');
				
				$data['table']= $this->table->generate();
				$data['printer']= 1;
				$data['periode']='Periode '.date('d M Y',$awal).' - '.date('d M Y',$akhir).' Nasabah '.$nama;
				$data['scriptjava']= '<script type="text/javascript" src="'.base_url('js/management/nonsortir.js').'"></script>';
			}
			else
			{
				$this->session->set_userdata('message_error','Data Belum Ada !');
				redirect('management/nonsortir');
			}
			
			$data['path']= 'Rekap > Paket ';
			$data['contain']='content/management/tablepage';
			$data['navigation']= 'navigation/management';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function cetaktagihan()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['linkprocess']= anchor('management/nonsortir/tagihan','Proses',array('class'=>'print'));
			$this->load->view('content/management/confirm',$data);
		}
		else{ redirect('loginonline');}
	}
	
	function cetakrekap()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['linkprocess']= anchor('management/nonsortir/rekap','Proses',array('class'=>'print'));
			$this->load->view('content/management/confirm',$data);
		}
		else{ redirect('loginonline');}
	}
	
	function tagihan()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$awal= date('d M Y',$this->session->userdata('tglawal'));
			$akhir= date('d M Y',$this->session->userdata('tglakhir'));
			$idnasabah= $this->session->userdata('idnasabah');
			$nama= $this->NonSortirModel->namanasabah($idnasabah)->nasabah;
			$uangangkut= $this->NonSortirModel->totaluang($this->session->userdata('tglawal'),$this->session->userdata('tglakhir'),$idnasabah);
			$uang_strangkut= $this->NonSortirModel->tri_desimal($uangangkut['nominal']);
			$tottrip= $this->NonSortirModel->totaljln($this->session->userdata('tglawal'),$this->session->userdata('tglakhir'),$idnasabah);
			$nasabahview= $this->NonSortirModel->nonsortirview($this->session->userdata('tglawal'),$this->session->userdata('tglakhir'),$idnasabah);
			
			//format Cell= Cell(Width,Height,Text,Box,Ganti baris,Align,Border)
			$hcol= 0.5;
			$this->fpdf->FPDF('L','cm','A4');
			//$this->fpdf->Open();
			$this->fpdf->AddPage();
			$this->fpdf->Image('./images/rsz_11ssi_resize75.jpg',1,1);
			$this->fpdf->Image('./images/iso_resize25.jpg',25,1);
			
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(0,0.5 , 'CASH IN TRANSIT - '.$nama,0,1, 'C');
			$this->fpdf->Cell(0,1,'PERIODE '.$awal.' - '.$akhir,0,1,'C');
			$this->fpdf->Ln();
			
			$this->fpdf->SetFillColor(0,0,0);
			$this->fpdf->SetTextColor(255);
			$this->fpdf->SetFont('Arial','B',9);
			
			$this->fpdf->Cell(1,$hcol,'NO',0,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'TANGGAL',0,0,'C',1);
			$this->fpdf->Cell(1.5,$hcol,'SPPU',0,0,'C',1);
			$this->fpdf->Cell(4,$hcol,'DARI',0,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'TIBA',0,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,'SRH TERIMA',0,0,'C',1);
			$this->fpdf->Cell(4,$hcol,'KE',0,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'TIBA',0,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,'SRH TERIMA',0,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,'NOMINAL',0,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,'REGULAR',0,0,'C',1);
			$this->fpdf->Cell(1.5,$hcol,'ADHOC',0,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'BATAL',0,0,'C',1);
			
			$this->fpdf->Ln();
			$i=0;
			$flag_color=0;
			foreach($nasabahview as $viewnas)
			{
				if($flag_color == 0)
				{
					
					$this->fpdf->SetFillColor(224,235,255);
					$this->fpdf->SetTextColor(0);
					$flag_color=1;
				}
				else
				{					
					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->SetTextColor(0);
					$flag_color=0;
				}
				$tanggal= date('d M',strtotime($viewnas->tanggal));
				$nominal= $this->NonSortirModel->tri_desimal($viewnas->nominal);
				$regular= $this->NonSortirModel->tri_desimal($viewnas->hargapertrip);
				
				if($viewnas->adhoc == 0){$adhoc='none';}
				else{$adhoc= 'Adhoc';}
				
				$tdari= explode('-',$viewnas->berangkat);
				$tibadari= trim($tdari[0]);
				$srhdari= trim($tdari[1]);
				
				$tke= explode('-',$viewnas->tiba);
				$tibake= trim($tke[0]);
				$srhke= trim($tke[1]);
				
				//format Cell= Cell(Width,Height,Text,Box,0,Align,Border)
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(1,$hcol,++$i,1,0,'C',1);
				$this->fpdf->Cell(1.7,$hcol,$tanggal,1,0,'C',1);
				$this->fpdf->Cell(1.5,$hcol,$viewnas->sppu,1,0,'C',1);
				$this->fpdf->Cell(4,$hcol,$viewnas->dari,1,0,'C',1);
				$this->fpdf->Cell(1.7,$hcol,$tibadari,1,0,'C',1);
				$this->fpdf->Cell(2.1,$hcol,$srhdari,1,0,'C',1);
				$this->fpdf->Cell(4,$hcol,$viewnas->ke,1,0,'C',1);
				$this->fpdf->Cell(1.7,$hcol,$tibake,1,0,'C',1);
				$this->fpdf->Cell(2.1,$hcol,$srhke,1,0,'C',1);
				$this->fpdf->Cell(2.5,$hcol,$nominal,1,0,'C',1);
				$this->fpdf->Cell(2.1,$hcol,$regular,1,0,'C',1);
				$this->fpdf->Cell(1.5,$hcol,$adhoc,1,0,'C',1);
				$this->fpdf->Cell(1.7,$hcol,'none',1,0,'C',1);
				$this->fpdf->Ln();
				
				$pertrip= $viewnas->hargapertrip;
			}
			
			$this->fpdf->SetFillColor(255,255,255);
			$this->fpdf->SetTextColor(0);
			//Total uang angkut
			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->Cell(19.8,$hcol,'Total yang diangkut',1,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,$uang_strangkut,1,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(1.5,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'',1,0,'C',1);
			$this->fpdf->Ln();
			//Total Tagihan
			$tottagihan= $this->NonSortirModel->tri_desimal($pertrip*$tottrip);
			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->Cell(19.8,$hcol,'Total Tagihan',1,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,$tottagihan,1,0,'C',1);
			$this->fpdf->Cell(1.5,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'',1,0,'C',1);
			$this->fpdf->Ln();
			//Frekwensi trip
			//Total Tagihan
			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->Cell(19.8,$hcol,'Total Trip',1,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(2.1,$hcol,$tottrip,1,0,'C',1);
			$this->fpdf->Cell(1.5,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(1.7,$hcol,'',1,0,'C',1);
			$this->fpdf->Ln();
			
			$this->fpdf->Output();
		}
		else{redirect('loginonline');}
	}
	
	function rekap()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$awal= date('d M Y',$this->session->userdata('tglawal'));
			$akhir= date('d M Y',$this->session->userdata('tglakhir'));
			
			$awaldb= date('Y-m-d',$this->session->userdata('tglawal'));
			$akhirdb= date('Y-m-d',$this->session->userdata('tglakhir'));
			$tglsurat= date('d M Y',strtotime($this->session->userdata('tglsurat')));
			$idnasabah= $this->session->userdata('idnasabah');
			$nama= $this->NonSortirModel->namanasabah($idnasabah)->nasabah;
			$hargatripe = $this->NonSortirModel->tripharga($idnasabah)->hargapertrip;
			$frektotal= $this->NonSortirModel->totaljln($this->session->userdata('tglawal'),$this->session->userdata('tglakhir'),$idnasabah);
			
			
			$tottagihan= $frektotal*$hargatripe;
			$tottagihan= $this->NonSortirModel->tri_desimal($tottagihan);
			$hargatrip= $this->NonSortirModel->tri_desimal($hargatripe);
			$nasabahview= $this->NonSortirModel->nonsortirview($this->session->userdata('tglawal'),$this->session->userdata('tglakhir'),$idnasabah);
			
			$headername= $this->NonSortirModel->headername($idnasabah);
			$nama= $headername->singkatan.' DIVISI '.$headername->divisi.' - '.$headername->nasabah;
			$hcol=0.6;
			$this->fpdf->FPDF('P','cm','A4');
			$this->fpdf->Open();
			$this->fpdf->AddPage();
			$this->fpdf->Image('./images/rsz_11ssi_resize75.jpg',1,1);
			$this->fpdf->Image('./images/iso_resize25.jpg',17,1);
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Cell(0,0.5,'REKAP TAGIHAN CASH IN TRANSIT',0,1,'C');
			$this->fpdf->Cell(0,0.5,$nama,0,1,'C');
			$this->fpdf->Cell(0,0.5,'PERIODE  '.$awal.' - '.$akhir,0,1,'C');
			$this->fpdf->Ln(1.3);
			
			$this->fpdf->SetFillColor(0,0,0);
			$this->fpdf->SetTextColor(255);
			$this->fpdf->SetFont('Arial','B',9);
			
			//Header Table
			$this->fpdf->Cell(1,$hcol,'NO',0,0,'C',1);
			
			$this->fpdf->Cell(8,$hcol,'LOKASI',0,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,'FREKUENSI',0,0,'C',1);
			$this->fpdf->Cell(4,$hcol,'HARGA/TRIP',0,0,'C',1);
			$this->fpdf->Cell(4,$hcol,'TOTAL',0,0,'C',1);
			$this->fpdf->Ln();
			$i=0;
			
			//Search pengelolah
			$pengelolah= $this->NonSortirModel->cabangolah($idnasabah);
			
			$flag_color=0;
			foreach($pengelolah as $olah)
			{
				$frektripcab= $this->NonSortirModel->jlncab($awaldb,$akhirdb,$olah->idcabang,$idnasabah);
				$tothargacab= $this->NonSortirModel->tri_desimal($frektripcab*$hargatripe);
				if($flag_color == 0)
				{
					
					$this->fpdf->SetFillColor(224,235,255);
					$this->fpdf->SetTextColor(0);
					$flag_color=1;
				}
				else
				{					
					$this->fpdf->SetFillColor(255,255,255);
					$this->fpdf->SetTextColor(0);
					$flag_color=0;
				}
				
				$this->fpdf->SetFont('Arial','',8);
				$this->fpdf->Cell(1,$hcol,++$i,1,0,'C',1);
				$this->fpdf->Cell(8,$hcol,$olah->cabang,1,0,'C',1);
				$this->fpdf->Cell(2.5,$hcol,$frektripcab,1,0,'C',1);
				$this->fpdf->Cell(4,$hcol,$hargatrip,1,0,'C',1);
				$this->fpdf->Cell(4,$hcol,$tothargacab,1,0,'C',1);
				$this->fpdf->Ln();
			}
			//footer
			$this->fpdf->SetFillColor(255,255,255);
			$this->fpdf->SetTextColor(0);
			$this->fpdf->SetFont('Arial','B',9);
			$this->fpdf->Cell(1,$hcol,'',1,0,'C',1);
			$this->fpdf->Cell(8,$hcol,'JUMLAH TOTAL',1,0,'C',1);
			$this->fpdf->Cell(2.5,$hcol,$frektotal,1,0,'C',1);
			$this->fpdf->Cell(4,$hcol,'0',1,0,'C',1);
			$this->fpdf->Cell(4,$hcol,$tottagihan,1,0,'C',1);
			$this->fpdf->Ln(1.3);
			
			$this->fpdf->SetFont('Arial','',8);
			$this->fpdf->Cell(0,$hcol,'Jakarta, '.$tglsurat,0,0,'L');
			
			$this->fpdf->Ln();
			$this->fpdf->SetFont('Arial','B',9);
			$this->fpdf->Cell(0,$hcol,'PT. SWADHARMA SARANA INFORMATIKA',0,0,'L');
			
			$this->fpdf->Ln(2);
			$this->fpdf->SetFont('Arial','BU',9);
			$this->fpdf->Cell(0,$hcol,'BRATA ROBINTO',0,0,'L');
			
			$this->fpdf->Ln(0.3);
			$this->fpdf->SetFont('Arial','B',9);
			$this->fpdf->Cell(0,$hcol,'General Manager',0,0,'L');
			
			$this->fpdf->Output();
		}
		else{redirect('loginonline');}
	}
	
	function remove_tag($sppu)
	{
		if($this->NonSortirModel->removetag($sppu) == TRUE)
		{
			$this->session->set_userdata('message_error','Proses pemindahan data berhasil !');
		}
		else{$this->session->set_userdata('message_error','Proses pemindahan data gagal !');}
		redirect('management/nonsortir');
	}
}
?>