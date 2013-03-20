<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Senkas extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/SenkasSuperModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$senkas_all= $this->SenkasSuperModel->senkas();
			
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hnama= array('data'=>'Cabang CIT','class'=>'headtable');
			$hcode= array('data'=>'Kode','class'=>'headtable');
			$hact= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			//$this->table->add_row($hno,$hnama,$hcode,$hact);
			$this->table->set_heading($hno,$hnama,$hcode,$hact);
			
			$inp_senkas= '<input type="text" name="senkas" id="senkas" size="30" maxlength="50" title="Input Cabang"/>';
			$inp_code= '<input type="text" name="kode" id="kode" size="30" maxlength="3" title="Input Kode"/>';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cinp_senkas= array('data'=>$inp_senkas,'class'=>'isi tengah');
			$cinp_code= array('data'=>$inp_code,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cinp_senkas,$cinp_code,$csb);
		
			if(!empty($senkas_all))
			{
				$i= 0;
				foreach($senkas_all as $senkas)
				{
					$actedit= anchor('supervisor/senkas/editsenkas/'.$senkas->id,'Edit',array('class'=>'edit'));
					$actdel= anchor('supervisor/senkas/deletesenkas/'.$senkas->id,'Hapus',array('class'=>'delete'));
					
					$cellno= array('data'=>++$i,'class'=>'isi tengah');
					$cellsenkas= array('data'=>$senkas->cabang,'class'=>'isi tengah');
					$cellcode= array('data'=>$senkas->idcabang,'class'=>'isi tengah');
					$celledit= array('data'=>$actedit,'class'=>'isi tengah','width'=>100);
					$celldel= array('data'=>$actdel,'class'=>'isi tengah','width'=>100);
					
					$this->table->add_row($cellno,$cellsenkas,$cellcode,$celledit,$celldel);
				}
			}
			
			$data['table']= $this->table->generate();
			
			$data['path']= 'Parameter > Cabang';
			
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['actionpage']= site_url('supervisor/senkas/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/senkasadd.js').'"></script>';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nama= strtoupper($this->input->post('senkas'));
			$kode= strtoupper($this->input->post('kode'));
			$this->SenkasSuperModel->simpansenkas($nama,$kode);
			redirect('supervisor/senkas');
		}
		else{redirect('loginonline');}
	}
	
	function editsenkas($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hnama= array('data'=>'Cabang CIT','class'=>'headtable');
			$hcode= array('data'=>'Kode','class'=>'headtable');
			$hact= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			//$this->table->add_row($hno,$hnama,$hcode,$hact);
			$this->table->set_heading($hno,$hnama,$hcode,$hact);
			$senkasload= $this->SenkasSuperModel->loadsenkas($id);
			
			$inp_senkas= '<input type="text" name="senkas" id="senkas" size="30" maxlength="50" value="'.$senkasload->cabang.'" title="Edit Cabang"/><input type="hidden" name="id" value="'.$id.'" />';
			$inp_code= '<input type="text" name="kode" id="kode" size="30" maxlength="3" title="Edit Kode" value="'.$senkasload->idcabang.'"/>';
			$submit='<input type="image" src="'.base_url('images/edit.png').'" alt="submit" class="submit" title="Update"';
			
			$cinp_senkas= array('data'=>$inp_senkas,'class'=>'isi tengah');
			$cinp_code= array('data'=>$inp_code,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cinp_senkas,$cinp_code,$csb);
			
			$data['table']= $this->table->generate();
			
			
			$data['path']= 'Parameter > '.anchor('supervisor/senkas/','Cabang').' > Edit';
			$data['actionpage']= site_url('supervisor/senkas/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/senkasadd.js').'"></script>';
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$cabang= strtoupper($this->input->post('senkas'));
			$kode= strtoupper($this->input->post('kode'));
			$id= $this->input->post('id');
			
			$this->SenkasSuperModel->updatesenkas($cabang,$kode,$id);
			
			$this->session->set_userdata('message_error','Sentra Kas '.$cabang.' Berhasil diupdate !');
			redirect('supervisor/senkas');
		}
		else{redirect('loginonline');}
	}
	
	function deletesenkas($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$senkas= $this->SenkasSuperModel->loadsenkas($id);
			$nama= $senkas->cabang;
			$this->SenkasSuperModel->deletesenkas($id);
			$this->session->set_userdata('message_error','Senkas '.$nama.' berhasil dihapus !');
			
			redirect('supervisor/senkas');
		}
		else{redirect('loginonline');}
	}
}
?>