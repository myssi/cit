<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asal extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('operator/AsalModel');
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
			$hasal= array('data'=>'ASAL LOKASI');
			$hact= array('data'=>'TINDAKAN','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hasal,$hact);
			
			$inp_nasabah='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" title="Input Asal Lokasi" />';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$inp_nas= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nas,$csb);
			
			$asal_loading= $this->AsalModel->load_asal();
			
			if(!empty($asal_loading))
			{
				$i=0;
				foreach($asal_loading as $asal)
				{
					$edit= anchor('operator/asal/edit/'.$asal->asal_id,'Edit',array('class'=>'edit'));
					$delete= anchor('operator/asal/delete/'.$asal->asal_id,'Hapus',array('class'=>'delete'));
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_asal= array('data'=>strtoupper($asal->asal),'class'=>'isi tengah');
					$cell_edit= array('data'=>$edit,'class'=>'isi tengah');
					$cell_delete= array('data'=>$delete,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_asal,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['cab']= $this->AdminisModel->name_cabang($this->session->userdata('cabang_id'));
			$data['path']= 'Lokasi > Asal';
			$data['actionpage']= site_url('operator/asal/addprocess');
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
			if($this->AsalModel->check_lokasi($asal,'asal_lokasi','asal') == TRUE)
			{
				$this->session->set_userdata('message_error','Lokasi Asal Sudah Ada !');
				redirect('operator/asal');
			}
			else
			{
				$this->AsalModel->insert_lokasi($asal,'asal_lokasi','asal');
				$this->session->set_userdata('message_error','Lokasi Asal Berhasil Disimpan !');
				redirect('operator/asal');
			}
			
		}
		else{redirect('loginonline');}
	}
	
	function edit($asal_id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$asal_nm= $this->AsalModel->asalnm($asal_id);
			
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
			
			$inp_nasabah='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" value="'.$asal_nm->asal.'" /><input type="hidden" name="id_lokasi" value="'.$asal_id.'" />';
			$submit='<input type="image" src="'.base_url('images/icon_update.png').'" alt="submit" class="submit" title="Edit"';
			
			$inp_nas= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nas,$csb);
			
			$data['table']=$this->table->generate();
			$data['cab']= $this->AdminisModel->name_cabang($this->session->userdata('cabang_id'));
			$data['path']= 'Lokasi > '.anchor('operator/asal','Asal').' > Edit';
			$data['actionpage']= site_url('operator/asal/editprocess');
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
			$asal= strtoupper($this->input->post('lokasi'));
			$asal_id= $this->input->post('id_lokasi');
			
			//check if same the other
			if($this->AsalModel->check_lokasi($asal,'asal_lokasi','asal') == TRUE)
			{
				$this->session->set_userdata('message_error','Lokasi Asal Sudah Ada !');
				redirect('operator/asal');
			}
			else
			{
				$this->AsalModel->update_asal($asal,$asal_id);
				$this->session->set_userdata('message_error','Lokasi Asal Berhasil Diupdate !');
				redirect('operator/asal');
			}
			
		}
		else{redirect('loginonline');}
	}
	
	function delete($asal_id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->AsalModel->delete_asal($asal_id);
			$this->session->set_userdata('message_error','Lokasi Asal Berhasil Dihapus !');
			redirect('operator/asal');
		}
	}
}
?>