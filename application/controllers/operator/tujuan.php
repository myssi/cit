<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tujuan extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('operator/TujuanModel');
		$this->load->model('adm/AdminisModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40');
			$hasal= array('data'=>'TUJUAN LOKASI');
			$hact= array('data'=>'TINDAKAN','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hasal,$hact);
			
			$inp_nasabah='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" title="Input Asal Lokasi" />';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$inp_nas= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nas,$csb);
			
			$tujuan_loading= $this->TujuanModel->load_tujuan();
			
			if(!empty($tujuan_loading))
			{
				$i=0;
				foreach($tujuan_loading as $tujuan)
				{
					$edit= anchor('operator/tujuan/edit/'.$tujuan->tujuan_id,'Edit',array('class'=>'edit'));
					$delete= anchor('operator/tujuan/delete/'.$tujuan->tujuan_id,'Hapus',array('class'=>'delete'));
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_asal= array('data'=>strtoupper($tujuan->tujuan),'class'=>'isi kiri');
					$cell_edit= array('data'=>$edit,'class'=>'isi tengah');
					$cell_delete= array('data'=>$delete,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_asal,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['cab']= $this->AdminisModel->name_cabang($this->session->userdata('cabang_id'));
			$data['path']= 'Lokasi > Tujuan';
			$data['actionpage']= site_url('operator/tujuan/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/operator/lokasi.js').'"></script>';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/operator';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$asal= strtoupper($this->input->post('lokasi'));
			
			//check if same the other
			if($this->TujuanModel->check_lokasi($asal,'tujuan_lokasi','tujuan') == TRUE)
			{
				$this->session->set_userdata('message_error','Lokasi Tujuan Sudah Ada !');
				redirect('operator/tujuan');
			}
			else
			{
				$this->TujuanModel->insert_lokasi($asal,'tujuan_lokasi','tujuan');
				$this->session->set_userdata('message_error','Lokasi Tujuan Berhasil Disimpan !');
				redirect('operator/tujuan');
			}
			
		}
		else{redirect('loginonline');}
	}
	
	function edit($asal_id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$asal_nm= $this->TujuanModel->asalnm($asal_id);
			
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40');
			$hasal= array('data'=>'ASAL LOKASI');
			$hact= array('data'=>'TINDAKAN','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hasal,$hact);
			
			$inp_nasabah='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" value="'.$asal_nm->tujuan.'" /><input type="hidden" name="id_lokasi" value="'.$asal_id.'" />';
			$submit='<input type="image" src="'.base_url('images/icon_update.png').'" alt="submit" class="submit" title="Edit"';
			
			$inp_nas= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nas,$csb);
			
			$data['table']=$this->table->generate();
			$data['cab']= $this->AdminisModel->name_cabang($this->session->userdata('cabang_id'));
			$data['path']= 'Lokasi > '.anchor('operator/tujuan','Tujuan').' > Edit';
			$data['actionpage']= site_url('operator/tujuan/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/operator/lokasi.js').'"></script>';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/operator';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
	}
	
	function editprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$tujuan= strtoupper($this->input->post('lokasi'));
			$tujuan_id= $this->input->post('id_lokasi');
			
			//check if same the other
			if($this->TujuanModel->check_lokasi($tujuan,'tujuan_lokasi','tujuan') == TRUE)
			{
				$this->session->set_userdata('message_error','Lokasi Tujuan Sudah Ada !');
				redirect('operator/tujuan');
			}
			else
			{
				$this->TujuanModel->update_tujuan($tujuan,$tujuan_id);
				$this->session->set_userdata('message_error','Lokasi Tujuan Berhasil Diupdate !');
				redirect('operator/tujuan');
			}
			
		}
		else{redirect('loginonline');}
	}
	
	function delete($asal_id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->TujuanModel->delete_tujuan($asal_id);
			$this->session->set_userdata('message_error','Lokasi Tujuan Berhasil Dihapus !');
			redirect('operator/tujuan');
		}
	}
}
?>