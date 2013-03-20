<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LoginOnline extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		//$this->db= $this->load->database('default',TRUE);
		$this->load->model('LoginOnlineModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			redirect('loginonline/level_decision');
		}
		else{ $this->load->view('loginform');}
	}
	
	function level_decision()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$level= $this->session->userdata('userlevel');
			
			if($level == 1) { redirect('adm/adminis');}
			else if($level == 2) { redirect('supervisor/customersuper');}
			else if($level == 3) { redirect('operator/uangclosed');}
			else if($level == 4) { redirect('monitor/monitoring');}
			else if($level == 5) { redirect('management/nonsortir');}
			else if ($level == 6){ redirect('userguest');}
		}
		else{ redirect('loginonline');}
	}
	
	function process_login()
	{
		$username= strtolower($this->input->post('username'));
		$password= md5($this->input->post('password'));
		$ipaddr= $this->input->ip_address();
		
		if($this->LoginOnlineModel->checkuser($username,$password,$ipaddr) == TRUE)
		{
			// save level and logic
			
			$level= $this->LoginOnlineModel->levelgrup($username,$password);
			
			if($level == 1){$cabang= 0;}
			else
			{
				$cabang= $this->LoginOnlineModel->cabang($username,$password);
			}
			
			if($level == 1){$leveltxt='Administrator';}
			else if($level == 2){$leveltxt='Supervisor';}
			else if($level == 3){$leveltxt='Operator';}
			else if($level == 4){$leveltxt='Monitor';}
			else if($level == 5){$leveltxt='Management';}
			
			
			$data= array('username'=>$username,'userlevel'=>$level,'loginlogic'=>TRUE,'cabang_id'=>$cabang,'leveltxt'=>$leveltxt);
			$this->session->set_userdata($data);
			redirect('loginonline/level_decision');
		}
		else
		{
			$this->session->set_userdata('message_error','Username atau Password Anda Salah !');
			redirect('loginonline');
		}
		
	}
	
	function logout()
	{
		$this->session->unset_userdata('loginlogic');
		$this->session->unset_userdata('userlevel');
		$this->session->unset_userdata('leveltxt');
		$this->session->unset_userdata('cabang_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('tglawal');
		$this->session->unset_userdata('tglakhir');
		$this->session->unset_userdata('tglsurat');
		$this->session->unset_userdata('idnasabah');
		$this->session->set_userdata('message_error','Anda Berhasil Logout !');
		redirect('loginonline');
	}
}
?>