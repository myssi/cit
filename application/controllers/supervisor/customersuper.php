<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CustomerSuper extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/CustomerSuperModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$customer_all= $this->CustomerSuperModel->listbank();
			
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hnama= array('data'=>'Nama Lengkap','class'=>'headtable');
			$hcode= array('data'=>'Singkatan','class'=>'headtable');
			$hact= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			//$this->table->add_row($hno,$hnama,$hcode,$hact);
			$this->table->set_heading($hno,$hnama,$hcode,$hact);
			
			$innama= '<input type="text" name="nama" id="nama" size="30" maxlength="50" title="Input Nama Bank"/>';
			$insingkat= '<input type="text" name="singkat" id="singkat" size="20" maxlength="20" title="Input Singkatan Bank"/>';
			$sbmit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cinp_nama= array('data'=>$innama,'class'=>'isi tengah');
			$cinp_singkat= array('data'=>$insingkat,'class'=>'isi tengah');
			$csubmit= array('data'=>$sbmit,'class'=>'isi tengah','colspan'=>2,'id'=>'sbsave');
			
			$this->table->add_row('',$cinp_nama,$cinp_singkat,$csubmit);
			
			if(empty($customer_all)){$data['table']= '<div style="color:RED;">Bank/Pelanggan Masih Kosong </div>';}
			else
			{
				$i= 0;
				foreach($customer_all as $customer)
				{
					$act_edit= anchor('supervisor/customersuper/editbank/'.$customer->idbank,'Edit',array('class'=>'edit'));
					$act_delete= anchor('supervisor/customersuper/deletebank/'.$customer->idbank,'Hapus',array('class'=>'delete'));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nama= array('data'=>$customer->nama,'class'=>'isi kiri');
					$cell_singkat= array('data'=>$customer->singkatan,'class'=>'isi tengah');
					$cell_edit= array('data'=>$act_edit,'width'=>100,'class'=>'isi tengah');
					$cell_delete= array('data'=>$act_delete,'width'=>100,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nama,$cell_singkat,$cell_edit,$cell_delete);
				}
			}
			$data['table']= $this->table->generate();
			
			$data['path']= 'Parameter > Bank';
			$data['menu1']= 'active';
			$data['contain']='content/tableplusinput';
			$data['actionpage']= site_url('supervisor/customersuper/bankaddprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/form_add.js').'"></script>';
			$data['navigation']= 'navigation/supervisor_nav';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function bankaddprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nama= strtoupper($this->input->post('nama'));
			$singkat= strtoupper($this->input->post('singkat'));
			if($this->CustomerSuperModel->saveadd($nama,$singkat) == TRUE)
			{
				$this->session->set_userdata('message_error','Bank Berhasil Dibuat !');
			}
			else{ $this->session->set_userdata('message_error','Bank Sudah Ada !');}
			redirect('supervisor/customersuper');
		}
		else{redirect('loginonline');}
	}
	
	function editbank($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			
			$data['nasabah']= $this->CustomerSuperModel->nasabah($id);
			$data['path']= 'Parameter > '.anchor('supervisor/customersuper/','Bank').' > Edit';
			$data['contain']='content/supervisor/form_editbank';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
	
	function editbankprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nama= strtoupper($this->input->post('nama'));
			$singkat= strtoupper($this->input->post('singkatan'));
			$id= $this->input->post('idtable');
			
			$this->CustomerSuperModel->updatebank($nama,$singkat,$id);
			redirect('supervisor/customersuper');
		}
		else{redirect('loginonline');}
	}
	
	function divisiaddprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$idbank= $this->input->post('bank');
			$nama= strtoupper($this->input->post('divisi'));
			
			$this->CustomerSuperModel->divisiadd($idbank,$nama);
			
			redirect('supervisor/customersuper/divisilist');
			
		}
		else{redirect('loginonline');}
	}
	
	function divisilist()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$ldivisi= $this->CustomerSuperModel->loaddivisi();
			
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
				
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','width'=>'40','class'=>'headtable');
			$hbank= array('data'=>'Nama Bank','class'=>'headtable');
			$hdivisi= array('data'=>'Nama Divisi','class'=>'headtable','width'=>'350');
			$hact= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			//$this->table->add_row($hno,$hbank,$hdivisi,$hact);
			$this->table->set_heading($hno,$hbank,$hdivisi,$hact);
			
			$listbank='';
			
			$loadbank= $this->CustomerSuperModel->listbank();
			
			foreach($loadbank as $banks)
			{
				$listbank=$listbank.'<option value="'.$banks->idbank.'">'.$banks->nama.'</option>';
			}
			
			$pilbank= '<select name="bank" id="bank" style="width:100%" title="Pilih Bank">
				<option value="0" selected="selected">-- Pilih Salah Satu --</option>'.$listbank.'
			</select>';
			$indiv= '<input type="text" name="divisi" id="divisi" size="30" maxlength="30" title="Input Divisi"/>';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cpilbank= array('data'=>$pilbank,'class'=>'isi tengah');
			$cdivisi= array('data'=>$indiv,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cpilbank,$cdivisi,$csb);
			
			if(!empty($cdivisi))
			{
				
				$i= 0;
				foreach($ldivisi as $cdiv)
				{	
					$actedit= anchor('supervisor/customersuper/editdivisi/'.$cdiv->iddivisi,'Edit',array('class'=>'edit'));
					$actdel= anchor('supervisor/customersuper/deletedivisi/'.$cdiv->iddivisi,'Hapus',array('class'=>'delete'));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nama= array('data'=>$cdiv->nama,'class'=>'isi tengah');
					$cell_divisi= array('data'=>$cdiv->divisi,'class'=>'isi tengah');
					
					$cell_edit= array('data'=>$actedit,'class'=>'isi tengah','width'=>'70');
					$cell_del= array('data'=>$actdel,'class'=>'isi tengah','width'=>'70');
					
					$this->table->add_row($cell_no,$cell_nama,$cell_divisi,$cell_edit,$cell_del);
				}
			}
			
			$data['table']= $this->table->generate();
			$data['path']= 'Parameter > Divisi';
			$data['contain']='content/tableplusinput';
			$data['actionpage']= site_url('supervisor/customersuper/divisiaddprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/divisiadd.js').'"></script>';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function editdivisi($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$data['divisiload']= $this->CustomerSuperModel->divsingle($id);
			$data['banklist']= $this->CustomerSuperModel->listbank();
			$data['path']= 'Parameter > '.anchor('supervisor/customersuper/divisilist/','Divisi').' > Edit';
			$data['contain']='content/supervisor/form_editdivisi';
			$data['navigation']= 'navigation/supervisor_nav';
			$this->load->view('template_warkat',$data);
		}
		else{ redirect('loginonline');}
	}
	
	function divisieditprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$namadiv= strtoupper($this->input->post('nama'));
			$kodecustomer= $this->input->post('kodecustomer');
			$iddivisi= $this->input->post('iddivisi');
			
			$this->CustomerSuperModel->updatedivisi($namadiv,$kodecustomer,$iddivisi);
			
			$this->session->set_userdata('message_error','Nama '.$namadiv.' Berhasil diupdate !');
			redirect('supervisor/customersuper/divisilist');
		}
		else{ redirect('loginonline');}
	}
}
?>