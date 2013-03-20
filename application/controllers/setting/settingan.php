<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settingan extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		
		$this->load->model('setting/SettinganModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$templatetable= array(
			'table_open'=>'<table width="70%" border="0" cellpadding="0" cellspacing="0">',
			'table_close'=>'</table>'
			);
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");
			
			$input_oldpass='<input type="password" name="oldpassword" id="oldpassword" size="30" maxlength="30" title="Masukkan Password Lama"/>';
			$input_newpass='<input type="password" name="newpassword" id="newpassword" size="30" maxlength="30" title="Masukkan Password Baru"/>';
			$input_confirm='<input type="password" name="confirm" id="confirm" size="30" maxlength="30" title="Masukkan Konfirmasi Password Baru"/>';
			$input_submit= '<input type="submit" class="submit" style="width:100px;height:30px;" value="Update" title="Update Password"/>';
			
			//cell oldpass
			$cell_old= array('data'=>'Password Lama','class'=>'isi kiri','width'=>150);
			$cellf_old= array('data'=>$input_oldpass,'class'=>'isi kiri');
			
			//cell newpass
			$cell_new= array('data'=>'Password Baru','class'=>'isi kiri');
			$cellf_new= array('data'=>$input_newpass);
			
			//cell confirm
			$cell_confirm= array('data'=>'Konfirmasi Password','class'=>'isi kiri');
			$cellf_confirm= array('data'=>$input_confirm);
			
			//cell submit
			$cellf_submit= array('data'=>$input_submit,'class'=>'kiri');
			
			//show cell
			$this->table->add_row($cell_old,$cellf_old);
			$this->table->add_row('','');
			$this->table->add_row($cell_new,$cellf_new);
			$this->table->add_row('','');
			$this->table->add_row($cell_confirm,$cellf_confirm);
			$this->table->add_row('','');
			$this->table->add_row('','');
			$this->table->add_row('',$cellf_submit);
			
			//Check level user
			$level_user= $this->SettinganModel->level();
			
			if($level_user->grup_level == 1){$data['navigation']='navigation/administrator';}
			else if($level_user->grup_level == 2){$data['navigation']= 'navigation/supervisor_nav';}
			else if($level_user->grup_level == 5){$data['navigation']= 'navigation/management';}
			
			$data['table']= $this->table->generate();
			$data['actionpage']= site_url('setting/settingan/update_process');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/setting/settingan.js').'"></script>';
			$data['path']= 'Setting';
			$data['contain']='content/tableplusinput';
			$data['menu3']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function update_process()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$oldpass= $this->input->post('oldpassword');
			$newpass= $this->input->post('newpassword');
			
			//check oldpass guys 
			if($this->SettinganModel->checkpass($oldpass) == TRUE)
			{
				$this->SettinganModel->updatepass($newpass);
				$this->session->set_userdata('message_error','Password Berhasil Diupdate !');
			}
			else{ $this->session->set_userdata('message_error','Password Salah');}
			redirect('setting/settingan');
		}
		else{redirect('loginonline');}
	}

}
?>