<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lokasi extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/LokasiModel','',TRUE);
		$this->load->model('supervisor/NasabahModel','',TRUE);
		$this->load->model('supervisor/SenkasSuperModel');
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$temptable= array(
				'table_open'=>'<table width="90%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			//============== Heading Table ==========================
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>210);
			$hlokasi= array('data'=>'Lokasi','class'=>'headtable');
			$hkota= array('data'=>'Kota','class'=>'headtable','width'=>250);
			$hcabang= array('data'=>'Pengelola','class'=>'headtable');
			
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hnasabah,$hkota,$hlokasi,$hcabang,$hact);
			
			//=================== Form Input Table ===================================
			
			$listnasabah= '<option value="" selected="selected"> --- Pilih Nasabah --- </option>';
			$nasabah_load= $this->NasabahModel->nasabahlist();
			
			if(!empty($nasabah_load))
			{
				foreach($nasabah_load as $anasabah)
				{
					$listnasabah= $listnasabah.'<option value="'.$anasabah->idnasabah.'">'.$anasabah->nasabah.'</option>';
				}
				$select_nasabah='<select name="nasabah" id="nasabah" style="width:100%;" title="Pilih Nasabah">'.$listnasabah.'</select>';
			}
			else{$select_nasabah='';}
			
			$listcabang='<option value="" selected="selected">-- Pilih Satu Cabang --</option>';
			$cabang_load= $this->SenkasSuperModel->senkas();
			
			if(!empty($cabang_load))
			{
				
				foreach($cabang_load as $cablist)
				{
					$listcabang= $listcabang.'<option value="'.$cablist->idcabang.'">'.$cablist->cabang.'</option>';
				}
				$select_cabang='<select name="cabang" id="cabang" style="width:100%" title="Pilih Cabang Pengelola">'.$listcabang.'</select>';
			}
			else{$select_cabang= '';}
			
			$input_lokasi='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" title="Input Lokasi"/>';
			$input_kota='<input type="kota" name="kota" id="kota" size="30" maxlength="40" title="Input Kota" />';
			
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cell_inp_lokasi= array('data'=>$input_lokasi,'class'=>'isi tengah');
			$cell_inp_kota= array('data'=>$input_kota,'class'=>'isi tengah');
			$cell_inp_nasabah= array('data'=>$select_nasabah,'class'=>'isi tengah');
			$cell_inp_submit= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cell_inp_nasabah,$cell_inp_kota,$cell_inp_lokasi,$select_cabang,$cell_inp_submit);
			//$this->table->set_subheading('',$cell_inp_nasabah,$cell_inp_kota,$cell_inp_lokasi,$select_cabang,$cell_inp_submit);
			
			//=================== Show Content ==============================
			
			$i=0;
			
			$all_lokasi= $this->LokasiModel->lokasi_all();
			
			if(!empty($all_lokasi))
			{
				foreach($all_lokasi as $alokasi)
				{
					$act_edit= anchor('supervisor/lokasi/edit/'.$alokasi->idlokasi,'Edit',array('class'=>'edit','title'=>'Edit Lokasi'));
					$act_delete= anchor('supervisor/lokasi/delete/'.$alokasi->idlokasi,'Hapus',array('class'=>'delete','title'=>'Delete Lokasi','onclick'=>"return confirm('Anda Yakin Meghapus Lokasi Ini ?')"));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nasabah= array('data'=>$alokasi->nasabah,'class'=>'isi tengah');
					$cell_lokasi= array('data'=>$alokasi->lokasi,'class'=>'isi tengah');
					$cell_kota= array('data'=>$alokasi->kota,'class'=>'isi tengah');
					$cell_cabang= array('data'=>$alokasi->cabang,'class'=>'isi tengah');
					$cell_edit= array('data'=>$act_edit,'class'=>'isi tengah');
					$cell_delete= array('data'=>$act_delete,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nasabah,$cell_kota,$cell_lokasi,$cell_cabang,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['path']= 'Nasabah > Perjalanan';
			$data['actionpage']= site_url('supervisor/lokasi/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/lokasi.js').'"></script>';
			//$data['url']= '<input type="hidden" id="urlolah" value="'.site_url('supervisor/olah/divisibank').'" />';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu4']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$lokasi= strtoupper($this->input->post('lokasi'));
			$kota= strtoupper($this->input->post('kota'));
			$nasabah= $this->input->post('nasabah');
			$idcabang= strtoupper($this->input->post('cabang'));
			$this->LokasiModel->insert_lokasi($nasabah,$lokasi,$kota,$idcabang);
			redirect('supervisor/lokasi');
		}
		else{redirect('loginonline');}
	}
	
	function edit($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$lokasi= $this->LokasiModel->lokasi_nasabah($id);
			
			$temptable= array(
				'table_open'=>'<table width="80%" border="1" cellpadding="0" cellspacing="0">',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($temptable);
			$this->table->set_empty("&nbsp;");
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>220);
			$hlokasi= array('data'=>'Lokasi','class'=>'headtable');
			$hkota= array('data'=>'Kota','class'=>'headtable');
			$hcabang= array('data'=>'Cabang','class'=>'headtable');
			
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hnasabah,$hlokasi,$hkota,$hcabang,$hact);
			
			//================ Form Edit ====================================
			
			/*$listnasabah='';
			$nasabah_lst= $this->NasabahModel->nasabahlist();
			
			if(!empty($nasabah_lst))
			{
				foreach($nasabah_lst as $anasab)
				{
					if($anasab->idnasabah == $lokasi->idnasabah)
					{
						$listnasabah= $listnasabah .'<option value="'.$anasab->idnasabah.'" selected="selected">'.$anasab->nasabah.'</option>';
					}
					else{$listnasabah= $listnasabah .'<option value="'.$anasab->idnasabah.'">'.$anasab->nasabah.'</option>';}
				}
				
				$select_nasabah='<select name="nasabah" id="nasabah" style="width:100%;" title="Pilih Nasabah">'.$listnasabah.'</select>';
			}
			else{$select_nasabah='';}*/
			
			$listcabang= '';
			$cabang_lst= $this->SenkasSuperModel->senkas();
			
			foreach($cabang_lst as $cab)
			{
				if($lokasi->idcabang == $cab->idcabang)
				{
					$listcabang= $listcabang.'<option value="'.$cab->idcabang.'" selected="selected">'.$cab->cabang.'</option>';
				}
				else
				{
					$listcabang= $listcabang.'<option value="'.$cab->idcabang.'">'.$cab->cabang.'</option>';
				}
			}
			
			$input_lokasi='<input type="text" name="lokasi" id="lokasi" size="30" maxlength="50" title="Input Lokasi" value="'.$lokasi->lokasi.'"/>
			<input type="hidden" name="idlokasi" value="'.$lokasi->idlokasi.'"/>';
			$input_kota='<input type="kota" name="kota" id="kota" size="30" maxlength="40" title="Input Kota" value="'.$lokasi->kota.'"/>';
			$select_cabang='<select name="cabang" id="cabang" style="width:100%" title="Pilih Cabang Pengelola">'.$listcabang.'</select>';
			
			$submit='<input type="image" src="'.base_url('images/sync.png').'" alt="submit" class="submit" title="Update"';
			$cell_inp_nasabah= array('data'=>$lokasi->nasabah,'class'=>'isi tengah');
			$cell_inp_lokasi= array('data'=>$input_lokasi,'class'=>'isi tengah');
			$cell_inp_kota= array('data'=>$input_kota,'class'=>'isi tengah');
			$cell_inp_submit= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cell_inp_nasabah,$cell_inp_lokasi,$cell_inp_kota,$select_cabang,$cell_inp_submit);
			
			$data['table']=$this->table->generate();
			$data['path']= 'Nasabah > '.anchor('supervisor/lokasi','Perjalanan').' > Edit';
			$data['actionpage']= site_url('supervisor/lokasi/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/lokasi.js').'"></script>';
			//$data['url']= '<input type="hidden" id="urlolah" value="'.site_url('supervisor/olah/divisibank').'" />';
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu4']= 'active';
			$this->load->view('template_warkat',$data);
			
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$id= $this->input->post('idlokasi');
			$nasabah= $this->input->post('nasabah');
			$lokasi= strtoupper($this->input->post('lokasi'));
			$kota= strtoupper($this->input->post('kota'));
			$cabang= $this->input->post('cabang');
			
			if($this->LokasiModel->update_lokasi($id,$nasabah,$lokasi,$kota,$cabang) == TRUE){ redirect('supervisor/lokasi');}
			else{redirect('supervisor/lokasi/edit/'.$id);}
		}
		else{redirect('loginonline');}
	}
	
	function delete($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->LokasiModel->delete_lokasi($id);
			$this->session->set_userdata('message_error','Lokasi Berhasil Dihapus ');
			redirect('supervisor/lokasi');
		}
		else{redirect('loginonline');}
	}
}
?>