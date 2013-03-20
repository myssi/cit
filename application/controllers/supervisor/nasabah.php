<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Nasabah extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/NasabahModel','',TRUE);
		$this->load->model('supervisor/CustomerSuperModel','',TRUE);
		$this->load->model('supervisor/SenkasSuperModel','',TRUE);
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
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hnama= array('data'=>'Nasabah','class'=>'headtable');
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2);
			
			//$this->table->add_row($hno,$hnama,$hact);
			$this->table->set_heading($hno,$hnama,$hact);
			
			$inp_nasabah='<input type="text" name="nasabah" id="nasabah" size="30" maxlength="50" title="Input Nasabah" />';
			
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$inp_nasabah= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nasabah,$csb);
			$i=0;
			$loadnasabah= $this->NasabahModel->nasabahlist();
			if(!empty($loadnasabah))
			{
				foreach($loadnasabah as $eachnas)
				{
					$editnas= anchor('supervisor/nasabah/edit/'.$eachnas->idnasabah,'Edit',array('class'=>'edit'));
					$delnas= anchor('supervisor/nasabah/delete/'.$eachnas->idnasabah,'Hapus',array('class'=>'delete','onclick'=>"return confirm('Anda Yakin Menghapus Nasabah Ini ?')"));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nas= array('data'=>$eachnas->nasabah,'class'=>'isi kiri');
					$cell_edit= array('data'=>$editnas,'width'=>'70','class'=>'isi tengah');
					$cell_delete= array('data'=>$delnas,'width'=>'70','class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nas,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['path']= 'Parameter > Nasabah';
			$data['actionpage']= site_url('supervisor/nasabah/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/nasabahadd.js').'"></script>';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nasabah= strtoupper($this->input->post('nasabah'));
			
			if($divisi == ''){$divisi=0;}			
			
			if($this->NasabahModel->savenasabah($nasabah) == FALSE)
			{
				$this->session->set_userdata('message_error','Nasabah Berhasil Dibuat !');
				
			}
			else{$this->session->set_userdata('message_error','Nasabah Sudah Ada !');}
			
			redirect('supervisor/nasabah');
		}
		else{redirect('loginonline');}
	}
	
	function edit($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$choose= $this->NasabahModel->anasabah($id);
			
			$temptable= array(
				'table_open'=>'<table width="40%" border="1" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hnama= array('data'=>'Nasabah','class'=>'headtable');
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2);
			
			//$this->table->add_row($hno,$hnama,$hact);
			$this->table->set_heading($hno,$hnama,$hact);
			
			$inp_nasabah='<input type="text" name="nasabah" id="nasabah" size="30" maxlength="50" value="'.$choose->nasabah.'" title="Input Nasabah" />
			<input type="hidden" name="id" value="'.$choose->idnasabah.'"/>';
			
			$submit='<input type="image" src="'.base_url('images/edit.png').'" alt="submit" class="submit" title="Edit"';
			
			$inp_nasabah= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$inp_nasabah,$csb);
			
			$data['table']=$this->table->generate();
			
			$data['path']= 'Parameter > '.anchor('supervisor/nasabah','Nasabah').' > Edit';
			$data['actionpage']= site_url('supervisor/nasabah/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/nasabahadd.js').'"></script>';
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';			
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		if($this->session->userdata(loginlogic) == TRUE )
		{
			$id= $this->input->post('id');
			$nama= strtoupper($this->input->post('nasabah'));
			
			$this->NasabahModel->editnasabah($id,$nama);
			redirect('supervisor/nasabah');
		}
		else{redirect('loginonline');}
	}
	
	function delete($id)
	{
		$this->NasabahModel->delete($id,'idnasabah','nasabah');
		redirect('supervisor/nasabah/');
	}
}
?>