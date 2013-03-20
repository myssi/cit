<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Olah extends CI_Controller{
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
		$this->load->model('supervisor/OlahModel','',TRUE);
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
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>220);
			$hbank= array('data'=>'Bank','class'=>'headtable','width'=>140);
			$hdivisi= array('data'=>'Divisi','class'=>'headtable');
			$hsenkas= array('data'=>'Cabang Pengelola','class'=>'headtable','width'=>200);
			$hstatus = array('data'=>'Status','class'=>'headtable');
			$hact= array('data'=>'Tindakan','class'=>'headtable','width'=>140,'colspan'=>2);
			
			//$this->table->add_row($hno,$hnasabah,$hbank,$hdivisi,$hsenkas,$hstatus,$hact);
			$this->table->set_heading($hno,$hnasabah,$hbank,$hdivisi,$hsenkas,$hstatus,$hact);
			
			$nasabah= $this->NasabahModel->nasabahlist();
			$listnasabah='';
			foreach($nasabah as $nas)
			{
				$listnasabah= $listnasabah.'<option value="'.$nas->idnasabah.'">'.$nas->nasabah.'</option>';
			}
			
			$listbank='';
			$banks= $this->CustomerSuperModel->listbank();
			foreach($banks as $bank)
			{
				$listbank= $listbank.'<option value="'.$bank->idbank.'">'.$bank->singkatan.'</option>';
			}
			
			$listsenkas='';
			$senkass= $this->SenkasSuperModel->senkas();
			foreach($senkass as $senkas)
			{
				$listsenkas= $listsenkas.'<option value="'.$senkas->idcabang.'">'.$senkas->cabang.'</option>';
			}
			//======================= Field Input ================================
			$inp_nasabah='<select name="nasabah" id="nasabah" style="width:100%;" title="Pilih Nasabah">
			<option selected="selected" value="0">-- Pilih Satu Nasabah --</option>'.$listnasabah.'
			</select>';
			
			$inp_bank='<select name="bank" id="bank" style="width:100%;" title="Pilih Bank">
			<option selected="selected" value="0">-- Pilih Satu Bank--</option>'.$listbank.'
			</select>';
			
			$inp_senkas='<select name="cabang" id="cabang" style="width:100%" title="Pilih Cabang">
			<option selected="selected" value="0">-- Pilih Satu Cabang--</option>'.$listsenkas.'
			</select>';
			
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cellnasabah= array('data'=>$inp_nasabah,'class'=>'isi tengah');
			$cellbank= array('data'=>$inp_bank,'class'=>'isi tengah');
			$celldivisi= array('data'=>'','class'=>'isi tengah','id'=>'divisi');
			$cellsenkas= array('data'=>$inp_senkas,'class'=>'isi tengah');
			$csb= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			$this->table->add_row('',$cellnasabah,$cellbank,$celldivisi,$cellsenkas,'',$csb);
			
			//========================== content table ===================================
			
			$dataolah= $this->OlahModel->allviewdata();
			$i= 0;
			if(!empty($dataolah))
			{
				foreach($dataolah as $olah)
				{
					$edit_act= anchor('supervisor/olah/edit/'.$olah->id,'Edit',array('class'=>'edit'));
					$delete_act= anchor('supervisor/olah/delete/'.$olah->id,'Hapus',array('class'=>'delete'));
					
					if($olah->upflag == 1){$status='terunduh';}
					else{$status= 'belum';}
					
					$cell_nasabah= array('data'=>$olah->nasabah,'class'=>'isi kiri');
					$cell_bank= array('data'=>$olah->singkatan,'class'=>'isi tengah');
					$cell_divisi= array('data'=>$olah->divisi,'class'=>'isi tengah');
					$cell_cabang= array('data'=>$olah->cabang,'class'=>'isi tengah');
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_edit= array('data'=>$edit_act,'class'=>'isi tengah','width'=>50);
					$cell_delete= array('data'=>$delete_act,'class'=>'isi tengah','width'=>70);
					$cell_status= array('data'=>$status,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nasabah,$cell_bank,$cell_divisi,$cell_cabang,$cell_status,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['path']= 'Nasabah > Paket';
			$data['actionpage']= site_url('supervisor/olah/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/olahnasabah.js').'"></script>';
			$data['url']= '<input type="hidden" id="urlolah" value="'.site_url('supervisor/olah/divisibank').'" />';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu4']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function divisibank()
	{
		$bank = $this->input->post('bank');
		if(!empty($bank))
		{
			$divisi= $this->OlahModel->divisi($bank);
			$listdivisi= '';
			foreach($divisi as $adiv)
			{
				$listdivisi= $listdivisi.'<option value="'.$adiv->iddivisi.'">'.$adiv->divisi.'</option>';
			}
			$data['outputselect']= '<select name="divisi" id="divisi" style="width:100%;" title="Pilih Divisi">'.$listdivisi.'</select>';
		
			$this->load->view('content/supervisor/outputselect',$data);
		}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nasabah= $this->input->post('nasabah');
			$bank= $this->input->post('bank');
			$divisi= $this->input->post('divisi');
			$cabang= $this->input->post('cabang');
			
			if($this->OlahModel->simpanolah($nasabah,$bank,$divisi,$cabang) == TRUE)
			{
				$this->session->set_userdata('message_error','Data berhasil disimpan !');
			}
			else{$this->session->set_userdata('message_error','Data sudah ada !');}
			
			redirect('supervisor/olah');
		}
		else{ redirect('loginonline');}
		
	}
	
	function edit($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$olahedit= $this->OlahModel->edit_olah($id);
			$bank_list= $this->CustomerSuperModel->listbank();
			$temptable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			//====================== Nasabah =======================================
			
			$input_id= '<input type="hidden" name="id" value="'.$id.'"/>';
			
			$text_nasabah= array('data'=>'Nasabah','class'=>'isi kiri','width'=>150);
			$field_nasabah= array('data'=>$olahedit->nasabah.$input_id,'class'=>'isi kiri','width'=>230);
			
			$this->table->add_row($text_nasabah,$field_nasabah,'');
			$this->table->add_row('','','');
			
			//======================= Bank ============================================
			
			$listbank='';
			foreach($bank_list as $banks)
			{
				//$listbank= $listbank.'<option value="0" selected="selected">pilih bank</option>';
				if($olahedit->idbank == $banks->idbank)
				{
					$listbank= $listbank.'<option value="'.$banks->idbank.'" selected="selected">'.$banks->singkatan.'</option>';
				}
				else
				{
					$listbank= $listbank.'<option value="'.$banks->idbank.'">'.$banks->singkatan.'</option>';
				}
				
			}
			
			$selectbank= '<select name="bank" id="bank" style="width:100%;">'.$listbank.'</select>';
			$text_bank= array('data'=>'Bank','class'=>'isi kiri');
			$field_bank= array('data'=>$selectbank,'class'=>'isi kiri');
			
			$this->table->add_row($text_bank,$field_bank,'');
			$this->table->add_row('','','');
			
			//==============Divisi======================================================
			$listdivisi='';
			$divisilist= $this->OlahModel->divisi($olahedit->idbank);
			
			foreach($divisilist as $divs)
			{
				if($olahedit->iddivisi == $divs->iddivisi)
				{
					$listdivisi= $listdivisi.'<option value="'.$divs->iddivisi.'" selected="selected">'.$divs->divisi.'</option>';
				}
				else
				{
					$listdivisi= $listdivisi.'<option value="'.$divs->iddivisi.'">'.$divs->divisi.'</option>';
				}
				
			}
			
			$selectdivisi= '<select name="divisi" style="width:100%;">'.$listdivisi.'</select>';
			
			$text_divisi= array('data'=>'Divisi','class'=>'isi kiri');
			$field_divisi= array('data'=>$selectdivisi,'class'=>'isi kiri','id'=>'divisi');
			
			$this->table->add_row($text_divisi,$field_divisi,'');
			$this->table->add_row('','','');
			
			//============ Pengelola=========================
			
			$listcab='';
			$cabangload= $this->SenkasSuperModel->senkas();
			
			foreach($cabangload as $cabcit)
			{
				if($olahedit->idcabang == $cabcit->idcabang)
				{
					$listcab= $listcab.'<option value="'.$cabcit->idcabang.'" selected="selected">'.$cabcit->cabang.'</option>';
				}
				else
				{
					$listcab= $listcab.'<option value="'.$cabcit->idcabang.'">'.$cabcit->cabang.'</option>';
				}
			}
			
			$selectcab= '<select name="cabang" style="width:233px;">'.$listcab.'</select>';
			
			$text_cabang= array('data'=>'Pengelola','class'=>'isi kiri');
			$field_cabang= array('data'=>$selectcab,'class'=>'isi kiri','id'=>'divisi');
			
			$this->table->add_row($text_cabang,$field_cabang,'');
			$this->table->add_row('','','');
			
			//============== clear status ===========================
			
			$input_check= '<input type="checkbox" name="status" value="1"/>';
			$text_status= array('data'=>'Clear Status','class'=>'isi kiri');
			$field_status= array('data'=>$input_check);
			$this->table->add_row($text_status,$field_status,'');
			$this->table->add_row('','','');
			//================== Submit =============================
			
			$input_submit= '<input type="submit" value="Update" style="width:5em;height:2em;"  />';
			$this->table->add_row('',$input_submit,'');
			
			
			$data['table']=$this->table->generate();
			$data['path']= 'Nasabah > '.anchor('supervisor/olah','Paket').' > Edit';
			$data['actionpage']= site_url('supervisor/olah/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/olahnasabah.js').'"></script>';
			$data['url']= '<input type="hidden" id="urlolah" value="'.site_url('supervisor/olah/divisibank').'" />';
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu4']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{ redirect('loginonline');}
	}
	
	function delete($id)
	{
		$this->NasabahModel->delete($id,'id','olahnasabah');
		redirect('supervisor/olah/');
	}
	
	function editprocess()
	{
		$id= $this->input->post('id');
		$bank= $this->input->post('bank');
		$divisi= $this->input->post('divisi');
		$cabang= $this->input->post('cabang');
		$status= $this->input->post('status');
		$this->OlahModel->update_olah($id,$bank,$divisi,$cabang,$status);
		redirect('supervisor/olah');
		
	}
}
?>