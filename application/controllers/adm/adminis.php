<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminis extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('adm/AdminisModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$user_loading= $this->AdminisModel->userload();
			
			if(!empty($user_loading))
			{
				$templatetable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
				);
				
				$this->table->set_template($templatetable);
				$this->table->set_empty("&nbsp;");
				
				$hno= array('data'=>'NO');
				$huser= array('data'=>'USERNAME');
				$hcabang= array('data'=>'CABANG');
				$hlevel= array('data'=>'LEVEL');
				$htanggal= array('data'=>'HARI/TANGGAL','width'=>140);
				$hjam= array('data'=>'JAM LOGIN');
				$hipaddr= array('data'=>'IP ADDRESS');
				$htindakan= array('data'=>'TINDAKAN','colspan'=>2);
				
				//Header Table
				$this->table->set_heading($hno,$huser,$hcabang,$hlevel,$htanggal,$hjam,$hipaddr,$htindakan);
				$i=0;
				foreach($user_loading as $userld)
				{
					$edit= anchor('adm/adminis/edit/'.$userld->user_id,'Edit',array('class'=>'edit','title'=>'Edit Pengguna'));
					$delete= anchor('adm/adminis/delete/'.$userld->user_id,'Hapus',array('class'=>'delete','title'=>'Hapus Pengguna','onclick'=>"return confirm('Anda Yakin Menghapus Data Ini ?')"));
					
					if($userld->id_cabang > 0 ){ $cabang_name= $this->AdminisModel->name_cabang($userld->id_cabang);}
					else{$cabang_name= 'none';}
					
					if($userld->grup_level == 1){$level= 'Administrator'; $delete='';}
					else if($userld->grup_level == 2){$level= 'Supervisor';}
					else  if($userld->grup_level == 3){$level= 'Operator';}
					else if($userld->grup_level == 5){$level= 'Manajemen';}
					else{$level= 'Level Tak Teridentifikasi';}
					
					if($userld->tanggal == '0000-00-00'){$hari_login= 'Belum Login';}
					else
					{
						$day_array= array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
						$hari= date('w',strtotime($userld->tanggal));
						$theday= $day_array[$hari];
						$tgl= date('d - M - Y',strtotime($userld->tanggal));
						$hari_login= "$theday/$tgl";
					}
					
					$c_no= array('data'=>++$i,'class'=>'isi tengah');
					$c_user= array('data'=> $userld->username,'class'=>'isi tengah');
					
					$c_cab= array('data'=>$cabang_name,'class'=>'isi tengah');
					$c_level= array('data'=>$level,'class'=>'isi tengah');
					$c_tgl= array('data'=>$hari_login,'class'=>'isi tengah');
					$c_jam= array('data'=>$userld->jam,'class'=>'isi tengah');
					$c_ipaddr= array('data'=>$userld->ipaddress,'class'=>'isi tengah');
					$c_edit= array('data'=>$edit,'class'=>'isi tengah');
					$c_delete= array('data'=>$delete,'class'=>'isi tengah');
					
					$this->table->add_row($c_no,$c_user,$c_cab,$c_level,$c_tgl,$c_jam,$c_ipaddr,$c_edit,$c_delete);
				}
				
				$data['table']= $this->table->generate();
				
			}
			else
			{
				$data['table']= 'Data Kosong !';
			}
			
			$data['path']= 'Pengguna > Daftar ';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/administrator';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function edit($userid)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$userld= $this->AdminisModel->user_db($userid);
			
			$templatetable= array(
				'table_open'=>'<table width="100%" border="0" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");
			
			$htitle= array('data'=>'FORM EDIT PENGGUNA','colspan'=>3);
			
			$this->table->set_heading($htitle);
			$this->table->add_row('','','');
			
			$input_username= '<input type="text" name="username" id="username" size="30" maxlength="40" value="'.$userld->username.'"/>
			<input type="hidden" name="userid" value="'.$userid.'"/>
			';
			$c_nol= array('data'=>'','width'=>285,'class'=>'isi tengah');
			$cin_user= array('data'=>$input_username,'isi kiri');
			$c_user= array('data'=>'USERNAME','class'=>'isi kiri','width'=>160);
			
			$this->table->add_row($c_nol,$c_user,$cin_user);
			$this->table->add_row('','','');
			
			$input_password= '<input type="password" name="password" id="password" size="30" maxlength="40" value="'.$userld->password.'"/>';
			$cin_pass= array('data'=>$input_password,'class'=>'isi');
			$c_pass= array('data'=>'PASSWORD','class'=>'isi kiri');
			
			$this->table->add_row($c_nol,$c_pass,$cin_pass);
			$this->table->add_row('','','');
			
			$input_conf= '<input type="password" name="konfirmasi" id="konfirmasi" size="30" maxlength="40" value="'.$userld->password.'"/>';
			$cin_conf= array('data'=>$input_conf,'class'=>'isi');
			$c_conf= array('data'=>'KONFIRMASI PASSWORD','class'=>'isi kiri');
			
			$this->table->add_row($c_nol,$c_conf,$cin_conf);
			$this->table->add_row('','','');
			
			$list_level[2]= 'Supervisor';
			$list_level[3]= 'Operator';
			$list_level[4]= 'Manajemen';
			
			$grup_level='';
			for($i=2; $i <= 4 ; $i++)
			{
				if($userld->grup_level == $i){ $grup_level .= '<option value="'.$i.'" selected="selected">'.$list_level[$i].'</option>';}
				else{$grup_level .= '<option value="'.$i.'">'.$list_level[$i].'</option>';}
			}
			$select_level='<select name="level" id="level" style="width:183px;">'.$grup_level.'</select>';
			$csel_level= array('data'=>$select_level,'class'=>'isi');
			$c_level= array('data'=>'LEVEL','class'=>'isi kiri');
			$this->table->add_row($c_nol,$c_level,$csel_level);
			$this->table->add_row('','','');
			
			$cabang_list= $this->AdminisModel->listcabang();
			$listcab='';
			foreach($cabang_list as $cabang)
			{
				if($userld->id_cabang == $cabang->id)
				{
					$listcab .= '<option value="'.$cabang->id.'" selected="selected">'.$cabang->cabang.'</option>';
				}
				else
				{
					$listcab .= '<option value="'.$cabang->id.'">'.$cabang->cabang.'</option>';
				}
			}
			
			$select_cabang= '<select name="cabang" id="cabang" style="width:183px;">'.$listcab.'</select>';
			$cell_cabang= array('data'=>$select_cabang,'class'=>'isi');
			$ctext_cab= array('data'=>'CABANG','class'=>'isi kiri');
			$this->table->add_row($c_nol,$ctext_cab,$cell_cabang);
			$this->table->add_row('','','');
			
			$button_save= '<input type="submit" value=" Edit " style="width:120px;height:30px" class="sbsubmit"/>';
			$this->table->add_row($c_nol,'',$button_save);
			
			$data= array(
			'table'=>$this->table->generate(),
			'path'=>'Pengguna > Daftar > Edit',
			'contain'=>'content/tableplusinput',
			'navigation'=>'navigation/administrator',
			'menu1'=>'active',
			'actionpage'=> site_url('adm/adminis/editprocess')
			);
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$username= strtolower($this->input->post('username'));
			$password= md5($this->input->post('password'));
			$userid= $this->input->post('userid');
			$grup_level= $this->input->post('level');
			$cabang= $this->input->post('cabang');
			
			$this->AdminisModel->update_user($username,$password,$userid,$grup_level,$cabang);
			
			$this->session->set_userdata('message_error','Username '.$username.' Berhasil Diedit !');
			redirect('adm/adminis');
		}
		else{redirect('loginonline');}
	}
	
	function delete($userid)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->AdminisModel->delete_user($userid);
			$this->session->set_userdata('message_error','Username Berhasil Dihapus !');
			redirect('adm/adminis');
		}
		else{redirect('loginonline');}
	}
	
	function add()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$templatetable= array(
				'table_open'=>'<table width="100%" border="0" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");
			
			$htitle= array('data'=>'FORM REGISTRASI PENGGUNA BARU','colspan'=>3);
			
			$this->table->set_heading($htitle);
			$this->table->add_row('','','');
			
			$input_username= '<input type="text" name="username" id="username" size="30" maxlength="40"/>';
			$c_nol= array('data'=>'','width'=>285,'class'=>'isi tengah');
			$cin_user= array('data'=>$input_username,'isi kiri');
			$c_user= array('data'=>'USERNAME','class'=>'isi kiri','width'=>160);
			
			$this->table->add_row($c_nol,$c_user,$cin_user);
			$this->table->add_row('','','');
			
			$input_password= '<input type="password" name="password" id="password" size="30" maxlength="40"/>';
			$cin_pass= array('data'=>$input_password,'class'=>'isi');
			$c_pass= array('data'=>'PASSWORD','class'=>'isi kiri');
			
			$this->table->add_row($c_nol,$c_pass,$cin_pass);
			$this->table->add_row('','','');
			
			$input_conf= '<input type="password" name="konfirmasi" id="konfirmasi" size="30" maxlength="40"/>';
			$cin_conf= array('data'=>$input_conf,'class'=>'isi');
			$c_conf= array('data'=>'KONFIRMASI PASSWORD','class'=>'isi kiri');
			
			$this->table->add_row($c_nol,$c_conf,$cin_conf);
			$this->table->add_row('','','');
			
			$select_level='<select name="level" id="level" style="width:183px;">
			<option value="0" selected="selected">-- Pilih Level --</option>
			<option value="2">Supervisor</option>
			<option value="3">Operator</option>
			<option value="5">Manajemen</option>
			</select>';
			$csel_level= array('data'=>$select_level,'class'=>'isi');
			$c_level= array('data'=>'LEVEL','class'=>'isi kiri');
			$this->table->add_row($c_nol,$c_level,$csel_level);
			$this->table->add_row('','','');
			
			$cabang_list= $this->AdminisModel->listcabang();
			
			$listcab='<option value="0" selected="selected">-- Pilih Satu Cabang --</option>';
			
			foreach($cabang_list as $cabang)
			{
				$listcab= $listcab .'<option value="'.$cabang->id.'">'.$cabang->cabang.'</option>';
			}
			
			$select_cabang= '<select name="cabang" id="cabang" style="width:183px;">'.$listcab.'</select>';
			$cell_cabang= array('data'=>$select_cabang,'class'=>'isi');
			$ctext_cab= array('data'=>'CABANG','class'=>'isi kiri');
			$this->table->add_row($c_nol,$ctext_cab,$cell_cabang);
			$this->table->add_row('','','');
			
			$button_save= '<input type="submit" value=" Simpan " style="width:120px;height:30px" class="sbsubmit"/>';
			$this->table->add_row($c_nol,'',$button_save);
			
			$data['table']= $this->table->generate();
			
			$data['path']= 'Pengguna > Tambah ';
			$data['actionpage']= site_url('adm/adminis/addprocess');
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/administrator';
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/adminis/adminis.js').'"></script>';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$username= strtolower($this->input->post('username'));
			$password= md5($this->input->post('password'));
			$level= $this->input->post('level');
			$cabang= $this->input->post('cabang');
			
			//check username
			
			if($this->AdminisModel->check_exist($username) == TRUE)
			{
				$this->session->set_userdata('message_error','Username '.$username.' Sudah Dipakai');
				redirect('adm/adminis/add');
			}
			else
			{
				$this->AdminisModel->insert_username($username,$password,$level,$cabang);
				$this->session->set_userdata('message_error','Username '.strtolower($username).' Berhasil Disimpan !');
				redirect('adm/adminis');
			}
			
			$this->session->set_userdata('message_error','This Menu Still Under Construction');
			redirect('adm/adminis');
		}
		else{redirect('loginonline');}
	}
}
?>