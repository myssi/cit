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
			if(!empty($staff_load))
			{
				$list_staff='<option value="0" selected="selected">-- Pilih Satu Staf --</option>';
				foreach($staff_load as $staff)
				{
					$list_staff= $list_staff.'<option value="'.$staff->npp.'">'.$staff->nama.'</option>';
				}
				$select_staff='<select name="staff" id="staff" style="width:183px;">'.$list_staff.'</select>';
			}
			
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
			$sppu= strtoupper($this->input->post('sppu'));
			$customer= $this->input->post('customer');
			$asal= $this->input->post('asal');
			$tujuan= $this->input->post('tujuan');
			$staff= $this->input->post('staff');
			$brangkas= $this->input->post('brangkas');
			$status= $this->input->post('status');
			$tipe_hitung= $this->input->post('tipe_hitung');
			
			//if select sortir option
			if($tipe_hitung == 1)
			{
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
				
			}
			else if($tipe_hitung == 2) //if select non sortir option
			{ 
				$total_uang= $this->input->post('total_duit');
				
				if($total_uang == ''){ $total_uang= 0;}
			}
			
			$this->session->set_userdata('message_error','Sorry Still Under Construction');
			redirect('operator/uangclosed');
		}
		else{redirect('loginonline');}
	}
}
?>