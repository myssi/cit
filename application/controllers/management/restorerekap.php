<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RestoreRekap extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		
		$this->load->model('management/NonSortirModel','',TRUE);
		$this->load->model('management/RestoreRekapModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			
			$data['path']= 'Restore > Paket';
			$data['nasabah']= $this->NonSortirModel->customer1();
			$data['contain']='content/management/form_restore';
			$data['navigation']= 'navigation/management';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function process_restore()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$tanggal_a= $this->input->post('tgla');
			$tanggal_b= $this->input->post('tglb');
			$tanggal_surat= $this->input->post('tglsurat');
			$awal= strtotime($tanggal_a);
			$akhir= strtotime($tanggal_b);
			
			if($awal > $akhir)
			{
				$this->session->set_userdata('message_error','Tanggal Awal Harus Lebih Kecil');
				redirect('management/restorerekap');
			}
			
			$idnas= $this->input->post('nasabah');
			
			$resrekap= $this->RestoreRekapModel->rekapandump($awal,$akhir,$idnas);
			
			if(!empty($resrekap))
			{
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
				
				$this->table->add_row($hno,$htgl,$hsppu,$hdari,$htiba,$hserahtrim,$hke,$htiba,$hserahtrim,$hnominal,$hregular,$hadhoc,$hbatal,$hact);
				
				foreach($resrekap as $nasview)
				{
					$act= anchor('management/restorerekap/restore_tag/'.$nasview->sppu,'Restore',array('class'=>'update','onclick'=>"return confirm('Apakah Anda yakin meng-restore SPPU ini ?');"));
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
					$cell_nom= array('data'=>$nominal,'class'=>'isi tengah');
					$cell_adhoc= array('data'=>$adhoc,'class'=>'isi tengah');
					$cell_regular= array('data'=>$regular,'class'=>'isi tengah');
					$cell_batal= array('data'=>$batal,'class'=>'isi tengah');
					
					$cell_act= array('data'=>$act,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_tgl,$cell_sppu,$cell_dari,$cell_tibadari,$cell_srhdari,$cell_ke,
					$cell_tibake,$cell_srhke,$cell_nom,$cell_regular,$cell_adhoc,$cell_batal,$cell_act);
				}
				$data['table']= $this->table->generate();
				$data['periode']='Periode '.date('d M Y',$awal).' - '.date('d M Y',$akhir).' Nasabah '.$nama;
			}
			else
			{
				$this->session->set_userdata('message_error','Tidak Ada Data yang akan di restore !');
				redirect('management/restorerekap');
			}
			
			
			$data['path']= 'Restore > Paket ';
			$data['contain']='content/management/tablepage';
			$data['navigation']= 'navigation/management';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function restore_tag($sppu)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			if($this->RestoreRekapModel->restoredump($sppu) == TRUE)
			{
				$this->session->set_userdata('message_error','SPPU '.$sppu.' berhasil di restore !');
			}
			else{ $this->session->set_userdata('message_error','SPPU '.$sppu.' gagal di restore !');}
			
			redirect('management/restorerekap');
		}
		else{redirect('loginonline');}
	}
}
?>