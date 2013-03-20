<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitoring extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('monitor/MonitoringModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['cabang']= $this->MonitoringModel->selectcabang();
			
			$data['path']= 'Laporan > '.anchor('monitor/monitoring/index','SPPU');
			$data['actionpage']= site_url('monitor/monitoring/area_show');
			$data['contain']='content/monitoring/form_cabang';
			$data['navigation']= 'navigation/monitoring';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function warkat()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['cabang']= $this->MonitoringModel->selectcabang();
			
			$data['path']= 'Laporan > '.anchor('monitor/monitoring/warkat','Warkat');
			$data['actionpage']= site_url('monitor/monitoring/warkat_show');
			$data['contain']='content/monitoring/form_cabang';
			$data['navigation']= 'navigation/monitoring';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function area_show()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$cabang_kode= $this->input->post('cabang');
			$nama_cabang= $this->MonitoringModel->namacab($cabang_kode);
			
			$count_cabang= $this->MonitoringModel->pilih_sppu_cabang($cabang_kode);
			if(!empty($count_cabang))
			{
			
				$template= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'heading_cell_start'=>'<th class="headtable">',
				'heading_cell_end'=>'</th>',
				'row_start'=>'<tr class="zebra">',
				'row_end'=>'</tr>',
				'table_close'=>'</table>'
				);
				$this->table->set_template($template);
				$this->table->set_heading('No','Tanggal','SPPU','Dari','Berangkat','Ke','Tiba','Total Nominal','Adhoc','Pelanggan','Tanggal Update');
				$this->table->set_empty("&nbsp;");
				$i= 0;
			
				foreach($count_cabang as $count)
				{
					$tanggal= date("d-m-Y",strtotime($count->tanggal));
					if(empty($count->datekirim)){$tgl_kirim= '00-00-0000';}
					else{ $tgl_kirim= date("d-m-Y",strtotime($count->datekirim));}
					
					$nominal= $this->MonitoringModel->tri_desimal($count->nominal);
					if($count->adhoc == TRUE){$adhoc='Adhoc';}
					else{$adhoc='none';}
					$cell_no= array('data'=>++$i,'class'=>'tengah','width'=>'35');
					$cell_tanggal= array('data'=>$tanggal,'width'=>'70','class'=>'tengah');
					$cell_kirim= array('data'=>$tgl_kirim,'width'=>'70','class'=>'tengah');
					$cell_sppu= array('data'=>$count->sppu,'width'=>'60','class'=>'tengah');
					$cell_brkt= array('data'=>$count->berangkat,'width'=>'75');
					$cell_dari= array('data'=>$count->dari,'class'=>'tengah');
					$cell_ke= array('data'=>$count->ke,'class'=>'tengah');
					$cell_tiba= array('data'=>$count->tiba,'width'=>'75');
					$cell_cust= array('data'=>$count->customer,'class'=>'tengah');
					$cell_nominal= array('data'=>$nominal,'class'=>'kanan','width'=>'100');
					$cell_adhoc= array('data'=>$adhoc,'class'=>'tengah','width'=>'75');
					
					$this->table->add_row($cell_no,$cell_tanggal,$cell_sppu,$cell_dari,$cell_brkt,$cell_ke,$cell_tiba,$cell_nominal,$cell_adhoc,$cell_cust,$cell_kirim);
				}
				
				$data['table']= $this->table->generate();
			}
			else{ $data['table']= 'Tabel kosong !';}
			
			$data['path']= 'Laporan > '.anchor('monitor/monitoring/index','SPPU').' > '.$nama_cabang->nama;
			$data['contain']='content/pagemain';
			$data['navigation']= 'navigation/monitoring';
			
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function warkat_show()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$cabang_kode= $this->input->post('cabang');
			$nama_cabang= $this->MonitoringModel->namacab($cabang_kode);
			
			$count_warkat= $this->MonitoringModel->pilih_warkat_cabang($cabang_kode);
			if(!empty($count_warkat))
			{
				$template= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'heading_cell_start'=>'<th class="headtable">',
				'heading_cell_end'=>'</th>',
				'row_start'=>'<tr class="zebra">',
				'row_end'=>'</tr>',
				'table_close'=>'</table>'
				);
				$this->table->set_template($template);
				$this->table->set_heading('No','Pelanggan','Ambil','Jatuh Tempo','Kirim','Warkat','Bank','Rekening','Nominal','Staf','Tanggal Update');
				$this->table->set_empty("&nbsp;");
				$i= 0;
				
				foreach($count_warkat as $warkat){
					if(empty($warkat->tanggal_ambil)){$tgl_ambil='00-00-0000';}
					else{$tgl_ambil= date('d-m-Y',strtotime($warkat->tanggal_ambil));}
					
					if(empty($warkat->tanggal_tempo)){$tgl_tempo= '00-00-0000';}
					else{ $tgl_tempo= date('d-m-Y',strtotime($warkat->tanggal_tempo));}
					
					if(empty($warkat->tanggal_kirim)){ $tgl_kirim='00-00-0000'; }
					else {$tgl_kirim= date('d-m-Y',strtotime($warkat->tanggal_kirim));}
					
					
					$tgl_update= date('d-m-Y',strtotime($warkat->datekirim));
					
					$cell_no= array('data'=>++$i,'width'=>'30','class'=>'tengah');
					$cell_ambil= array('data'=>$tgl_ambil,'width'=>'70','class'=>'tengah');
					$cell_tempo= array('data'=>$tgl_tempo,'width'=>'70','class'=>'tengah');
					$cell_kirim= array('data'=>$tgl_kirim,'width'=>'70','class'=>'tengah');
					$cell_update= array('data'=>$tgl_update,'width'=>'70','class'=>'tengah');
					$cell_warkat= array('data'=>$warkat->warkat,'class'=>'tengah');
					$cell_bank= array('data'=>$warkat->bank,'class'=>'tengah');
					$cell_rekening= array('data'=>$warkat->rekening,'class'=>'tengah','width'=>'120');
					$cell_customer= array('data'=>$warkat->customer,'class'=>'tengah');
					
					$nominal= $this->MonitoringModel->tri_desimal($warkat->nominal);
					$cell_nominal= array('data'=>$nominal,'class'=>'tengah');
					$cell_staf= array('data'=>$warkat->staf,'class'=>'tengah');
					
					$this->table->add_row($cell_no,$cell_customer,$cell_ambil,$cell_tempo,$cell_kirim,$cell_warkat,$cell_bank,$cell_rekening,$cell_nominal,$cell_staf,$cell_update);
				}
				
				$data['table']= $this->table->generate();
				
			}
			else{$data['table']='Table Kosong !';}
			
			$data['path']= 'Laporan > '.anchor('monitor/monitoring/warkat','Warkat').' > '.$nama_cabang->nama;
			$data['contain']='content/pagemain';
			$data['navigation']= 'navigation/monitoring';
			
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
}
?>