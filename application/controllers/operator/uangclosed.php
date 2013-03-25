<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UangClosed extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('operator/UangClosedModel','',TRUE);
		$this->load->model('operator/AsalModel','',TRUE);
		$this->load->model('operator/TujuanModel','',TRUE);
		$this->load->model('adm/AdminisModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			// Form Closing
			$cabang_id= $this->session->userdata('cabang_id');
			$templatetable= array(
				'table_open'=>'<table width="100%" border="0" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");
			
			$htitle= array('data'=>'FORM CLOSING SPPU DENGAN OBYEK UANG','colspan'=>3);
			$this->table->set_heading($htitle);
			$this->table->add_row('','','');
			
			$input_sppu= '<input type="text" name="sppu" id="sppu" size="30" maxlength="40"/>';
			$c_nol= array('data'=>'','width'=>285,'class'=>'isi tengah');
			$cin_sppu= array('data'=>$input_sppu,'isi');
			$ctext_sppu= array('data'=>'SPPU','class'=>'isi kiri','width'=>160);
			
			$this->table->add_row($c_nol,$ctext_sppu,$cin_sppu);
			$this->table->add_row('','','');
			
			$code_cabang= $this->UangClosedModel->code_cab($cabang_id);
			$customer_load= $this->UangClosedModel->customerld($code_cabang);
			
			$cablist='<option value="0" selected="selected">-- Pilih Satu Pelanggan --</option>';
			if(!empty($customer_load))
			{
				foreach($customer_load as $customer)
				{
					$cablist= $cablist.'<option value="'.$customer->idnasabah.'">'.$customer->nasabah.'</option>';
				}
			}
			else{$cablist='';}
			$select_customer='<select name="customer" id="customer" style="width:183px;">'.$cablist.'</select>';
			
			// Origin Location Select
			$asal_load= $this->AsalModel->load_asal();
			$list_asal='<option value="0" selected="selected">-- Pilih Satu Lokasi Asal --</option>';
			if(!empty($asal_load))
			{
				foreach($asal_load as $asal)
				{
					$list_asal= $list_asal.'<option value="'.$asal->asal_id.'">'.$asal->asal.'</option>';
				}
			}
			else{$list_asal='';}
			
			$select_asal= '<select name="asal" id="asal" style="width:183px">'.$list_asal.'</select>';
			
			
			// Destination Location Select
			$tujuan_load= $this->TujuanModel->load_tujuan();
			$list_tujuan='<option value="0" selected="selected">-- Pilih Satu Lokasi Tujuan --</option>';
			if(!empty($tujuan_load))
			{
				foreach($tujuan_load as $tujuan)
				{
					$list_tujuan= $list_tujuan.'<option value="'.$tujuan->tujuan_id.'">'.$tujuan->tujuan.'</option>';
				}
			}
			else{$list_tujuan='';}
			
			$select_tujuan= '<select name="tujuan" id="tujuan" style="width:183px">'.$list_tujuan.'</select>';
			
			
			//Staff Select
			$staff_load= $this->UangClosedModel->load_staf();
			$list_staff='';
			if(!empty($staff_load))
			{
				$list_staff='<option value="0" selected="selected">-- Pilih Satu Staf --</option>';
				foreach($staff_load as $staff)
				{
					$list_staff= $list_staff.'<option value="'.$staff->npp.'">'.$staff->nama.'</option>';
				}
				
			}
			$select_staff='<select name="staff" id="staff" style="width:183px;">'.$list_staff.'</select>';
			//Status Select
			$select_status= '<select name="status" id="status" style="width:183px;">
			<option value="0" selected="selected">-- Pilih Satu Status --</option>
			<option value="1">Tutup</option>
			<option value="2">Inap</option>
			<option value="3">Inap Tutup</option>
			<option value="4">Batal</option>
			</select>';
			
			$data= array(
				'cab'=>$this->AdminisModel->name_cabang($cabang_id),
				'path'=>'SPPU > Uang',
				'actionpage'=>site_url('operator/uangclosed/record_process'),
				'contain'=>'content/operator/form_sppu',
				'navigation'=>'navigation/operator',
				'javacode'=>'<script type="text/javascript" src="'.base_url('js/operator/uangclosed.js').'"></script>',
				'menu1'=>'active',
				'select_customer'=>$select_customer,
				'select_asal'=>$select_asal,
				'select_tujuan'=>$select_tujuan,
				'select_staff'=>$select_staff
			);
			
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
	
	function record_process()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$cabang_id= $this->session->userdata('cabang_id');
			$sppu= trim(strtoupper($this->input->post('sppu')));
			
			$nasabah_id= $this->input->post('customer');
			$asal= $this->input->post('asal');
			$tujuan= $this->input->post('tujuan');
			$staff= $this->input->post('staff');
			
			$status_adhoc= $this->input->post('status_adhoc');
			$ambil= $this->input->post('ambil');
			$status_sppu= $this->input->post('status_sppu');
			$status_brangkas= $this->input->post('status_brangkas');
			$status_sortir= $this->input->post('status_sortir');
			$status_remis= $this->input->post('remis');
			
			$tanggal_closed= $this->input->post('tanggal');
			$brkt= $this->input->post('berangkat');
			$brkt_serah= $this->input->post('serah_brkt');
			$tiba= $this->input->post('tiba');
			$tiba_serah= $this->input->post('serah_tiba');
			
			// Status Remis Cancel all Journey
			if($status_remis == 1)
			{				
				$this->UangClosedModel->sppu_uang_save($sppu,$nasabah_id,$cabang_id,$asal,0,$staff,0,0,
				$status_sppu,0,0,$tanggal_closed,$brkt,$brkt_serah,'00:00','00:00',$status_remis);
				
				$this->session->set_userdata('message_error','SPPU '.$sppu.' Remis Berhasil Disimpan !');
				redirect('operator/uangclosed');
			}
			
			$total_uang= $this->input->post('total_duit');
			
			$de_100rb= $this->input->post('de_100rb');
			$de_50rb= $this->input->post('de_50rb');
			$de_20rb= $this->input->post('de_20rb');
			$de_10rb= $this->input->post('de_10rb');
			$de_5rb= $this->input->post('de_5rb');
			$de_2rb= $this->input->post('de_2rb');
			$de_1rb= $this->input->post('de_1rb');
			$dcoin_1000= $this->input->post('dcoin_1000');
			$dcoin_500= $this->input->post('dcoin_500');
			$dcoin_200= $this->input->post('dcoin_200');
			$dcoin_100= $this->input->post('dcoin_100');
			$dcoin_50= $this->input->post('dcoin_50');
			$dcoin_25= $this->input->post('dcoin_25');
			
			$ng_100rb= $this->input->post('ng100');
			$ng_50rb= $this->input->post('ng50');
			$ng_20rb= $this->input->post('ng20');
			$ng_10rb= $this->input->post('ng10');
			$ng_5rb= $this->input->post('ng5');
			$ng_2rb= $this->input->post('ng2');
			$ng_1rb= $this->input->post('ng1');
			$ngc_1rb= $this->input->post('ngl1000');
			$ngc_500= $this->input->post('ngl500');
			$ngc_200= $this->input->post('ngl200');
			$ngc_100= $this->input->post('ngl100');
			$ngc_50= $this->input->post('ngl50');
			$ngc_25= $this->input->post('ngl25');
			
			if($de_100rb == ''){$de_100rb= 0;}
			if($de_50rb == ''){$de_50rb= 0;}
			if($de_20rb == ''){$de_20rb= 0;}
			if($de_10rb == ''){$de_10rb= 0;}
			if($de_5rb == ''){$de_5rb= 0;}
			if($de_2rb == ''){$de_2rb= 0;}
			if($de_1rb == ''){$de_1rb= 0;}
			if($dcoin_1000 == ''){$dcoin_1000= 0;}
			if($dcoin_500 == ''){$dcoin_500= 0;}
			if($dcoin_200 == ''){$dcoin_200= 0;}
			if($dcoin_100 == ''){$dcoin_100= 0;}
			if($dcoin_50 == ''){$dcoin_50= 0;}
			if($dcoin_25 == ''){$dcoin_25= 0;}
			
			if($ng_100rb == ''){$ng_100rb= 0;}
			if($ng_50rb == ''){$ng_50rb= 0;}
			if($ng_20rb == ''){$ng_20rb= 0;}
			if($ng_10rb == ''){$ng_10rb= 0;}
			if($ng_5rb == ''){$ng_5rb= 0;}
			if($ng_2rb == ''){$ng_2rb= 0;}
			if($ng_1rb == ''){$ng_1rb= 0;}
			if($ngc_1rb == ''){$ngc_1rb= 0;}
			if($ngc_500 == ''){$ngc_500= 0;}
			if($ngc_200 == ''){$ngc_200= 0;}
			if($ngc_100 == ''){$ngc_100= 0;}
			if($ngc_50 == ''){$ngc_50= 0;}
			if($ngc_25 == ''){$ngc_25= 0;}
			if($total_uang == ''){ $total_uang= 0;}
			
			
				if($status_brangkas == 1)
				{
					if($status_sortir == 1)
					{
						//check if double sppu on table sortir good
						if($this->UangClosedModel->check_sppu($sppu,$cabang_id,'sortir_good') == TRUE)
						{
							$this->session->set_userdata('message_error','No SPPU '.$sppu.' Sudah Ada !');
							redirect('operator/uangclosed/');
						}
						else
						{
							if($this->UangClosedModel->check_sppu($sppu,$cabang_id,'sortir_bad') == TRUE)
							{
								$this->session->set_userdata('message_error','No SPPU '.$sppu.' Sudah Ada !');
								redirect('operator/uangclosed/');
							}
							else
							{
								$this->UangClosedModel->insert_sortir_good($sppu,$nasabah_id,$cabang_id,$de_100rb,$de_50rb,$de_20rb,$de_10rb,$de_5rb,$de_2rb,$de_1rb,$dcoin_1000,$dcoin_500,$dcoin_200,$dcoin_100,$dcoin_50,$dcoin_25);	
								$this->UangClosedModel->insert_sortir_bad($sppu,$nasabah_id,$cabang_id,$ng_100rb,$ng_50rb,$ng_20rb,$ng_10rb,$ng_5rb,$ng_2rb,$ng_1rb,$ngc_1rb,$ngc_500,$ngc_200,$ngc_100,$ngc_50,$ngc_25);
							}
						}
						
						
						$layak= ($de_100rb*100000)+($de_50rb*50000)+($de_20rb*20000)+($de_10rb*10000)+($de_5rb*5000)+($de_2rb*2000)+($de_1rb*1000)+($dcoin_1000*1000)+($dcoin_500*500)+($dcoin_200*200)+($dcoin_100*100)+($dcoin_50*50)+($dcoin_25*25);
						$tak_layak= ($ng_100rb*100000)+($ng_50rb*50000)+($ng_20rb*20000)+($ng_10rb*10000)+($ng_5rb*5000)+($ng_2rb*2000)+($ng_1rb*1000)+($ngc_1rb*1000)+($ngc_500*500)+($ngc_200*200)+($ngc_100*100)+($ngc_50*50)+($ngc_25*25);
						$total_in= $layak+$tak_layak;
					}
					else // not sortir
					{
						$total_in= $total_uang;
					}
					
					/*========================= Save Brangkas,Histori,SPPU ========================================*/
					
					$this->UangClosedModel->in_brangkas($nasabah_id,$cabang_id,$total_in);
					$this->UangClosedModel->histori($sppu,$nasabah_id,$cabang_id,$total_in,1);
				}
				else	// ============ Not Save In Brangkas ==================
				{
					if($status_sortir == 1)
					{
						if($ambil == 1)
						{
							$this->session->set_userdata('message_error','Status Pengambilan dari Brangkas Tidak Perlu Sortir !');
							redirect('operator/uangclosed');
						}
						else
						{
							$total_closed= ($de_100rb*100000)+($de_50rb*50000)+($de_20rb*20000)+($de_10rb*10000)+($de_5rb*5000)+($de_2rb*2000)+($de_1rb*1000)+($dcoin_1000*1000)+($dcoin_500*500)+($dcoin_200*200)+($dcoin_100*100)+($dcoin_50*50)+($dcoin_25*25);
							$this->UangClosedModel->direct_closed_sortir($sppu,$nasabah_id,$cabang_id,$de_100rb,$de_50rb,$de_20rb,$de_10rb,$de_5rb,$de_2rb,$de_1rb,$dcoin_1000,$dcoin_500,$dcoin_200,$dcoin_100,$dcoin_50,$dcoin_25,$total_closed);	
						}
					}
					else // ============= Not Sortir =============
					{
						if($ambil == 1)
						{
							
							if($this->UangClosedModel->out_brangkas($nasabah_id,$cabang_id,$total_uang) == FALSE){redirect('operator/uangclosed');}
							else
							{
								$this->UangClosedModel->histori($sppu,$nasabah_id,$cabang_id,$total_uang,0);
								
							}
						}
						else
						{
							$this->UangClosedModel->direct_closed_sortir($sppu,$nasabah_id,$cabang_id,0,0,0,0,0,0,0,0,0,0,0,0,0,$total_uang);	
						}
					}
				}
			
			$this->UangClosedModel->sppu_uang_save($sppu,$nasabah_id,$cabang_id,$asal,$tujuan,$staff,$status_adhoc,$ambil,
				$status_sppu,$status_brangkas,$status_sortir,$tanggal_closed,$brkt,$brkt_serah,$tiba,$tiba_serah,$status_remis);
			
			$this->session->set_userdata('message_error','SPPU '.$sppu.' Berhasil Disimpan !');
			redirect('operator/uangclosed');
		}
		else{redirect('loginonline');}
	}
}
?>