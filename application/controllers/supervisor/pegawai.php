<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pegawai extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/SenkasSuperModel','',TRUE);
		$this->load->model('supervisor/PegawaiModel','',TRUE);
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
			
			$hno= array('data'=>'NO','width'=>40);
			$hnama= array('data'=>'NAMA','width'=>280);
			$hnpp= array('data'=>'NPP','width'=>100);
			$hcabang= array('data'=>'CABANG');
			$hjab= array('data'=>'JABATAN','width'=>170);
			$hact= array('data'=>'TINDAKAN','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hnama,$hnpp,$hcabang,$hjab,$hact);
			
			//Form pegawai
			
			$input_nama= '<input type="text" name="pegawai" id="pegawai" size="30" maxlength="30" title="Input Nama Pegawai" />';
			$input_npp= '<input type="text" name="npp" id="npp" size="10" maxlength="15" title="Input NPP Pegawai" />';
			
			$cabang_load= $this->SenkasSuperModel->senkas();
			if(!empty($cabang_load))
			{
				$list_cabang= '<option value="0" selected="selected">-- Pilih Satu Cabang --</option>';
				foreach($cabang_load as $cabang)
				{
					$list_cabang= $list_cabang.'<option value="'.$cabang->id.'">'.$cabang->cabang.'</option>';
				}
			}
			$select_cabang= '<select name="cabang" id="cabang" style="width:100%">'.$list_cabang.'</select>';
			$select_jabatan='<select name="jabatan" id="jabatan" style="width:100%">
				<option value="0" selected="selected">-- Pilih Satu Jabatan--</option>
				<option value="1">Koordinator</option>
				<option value="2">Wakil Koordinator</option>
				<option value="3">Staf</option>
				<option value="4">Pengemudi</option>
			</select>';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Simpan"';
			
			$cinp_nama= array('data'=>$input_nama,'class'=>'isi tengah');
			$cinp_npp= array('data'=>$input_npp,'class'=>'isi tengah');
			$csel_cab= array('data'=>$select_cabang,'class'=>'isi tengah');
			$csel_jab= array('data'=>$select_jabatan,'class'=>'isi tengah');
			$csub= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cinp_nama,$cinp_npp,$csel_cab,$csel_jab,$csub);
			
			//Show Staf
			
			$staff_load= $this->PegawaiModel->peg_load();
			if(!empty($staff_load))
			{
				$i=0;
				foreach($staff_load as $staff)
				{
					$edit= anchor('supervisor/pegawai/edit/'.$staff->peg_id,'Edit',array('class'=>'edit'));
					$disabled= anchor('supervisor/pegawai/remove/'.$staff->peg_id,'Non Aktif',array('class'=>'delete','onclick'=>"return confirm('Anda Yakin Meng-Non Aktifkan Pegawai Ini !')"));
					
					if($staff->jabatan == 1){$jab='Koordinator';}
					else if($staff->jabatan == 2){$jab='Wakil Koordinator';}
					else if($staff->jabatan == 3){$jab='Staf';}
					else if($staff->jabatan == 4){$jab='Pengemudi';}
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nama= array('data'=>$staff->nama,'class'=>'isi tengah');
					$cell_npp= array('data'=>$staff->npp,'class'=>'isi tengah');
					$cell_cab= array('data'=>$staff->cabang,'class'=>'isi tengah');
					$cell_jab= array('data'=>$jab,'class'=>'isi tengah');
					$cell_edit= array('data'=>$edit,'class'=>'isi tengah');
					$cell_remove= array('data'=>$disabled,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nama,$cell_npp,$cell_cab,$cell_jab,$cell_edit,$cell_remove);
					
				}
			}
			$data['table']=$this->table->generate();
			
			$data['path']= 'Parameter > Pegawai > Daftar';
			$data['actionpage']= site_url('supervisor/pegawai/addprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/pegawai.js').'"></script>';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
	}
	
	function addprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nama= strtoupper($this->input->post('pegawai'));
			$npp= $this->input->post('npp');
			$cabang= $this->input->post('cabang');
			$jabatan= $this->input->post('jabatan');
			
			//check staf if already used the other person
			if($this->PegawaiModel->nama_check($nama,$cabang) == TRUE)
			{ $this->session->set_userdata('message_error','Nama Sudah Ada !');}
			else
			{
				$this->PegawaiModel->insert_baru_peg($nama,$npp,$cabang,$jabatan);
				$this->session->set_userdata('message_error','Nama Baru Berhasil Disimpan !');
			}
			
			redirect('supervisor/pegawai');
		}
		else{redirect('loginonline');}
	}
	
	function edit($peg_id)
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
			
			$hno= array('data'=>'NO','width'=>40);
			$hnama= array('data'=>'NAMA','width'=>280);
			$hnpp= array('data'=>'NPP','width'=>100);
			$hcabang= array('data'=>'CABANG');
			$hjab= array('data'=>'JABATAN','width'=>170);
			$hact= array('data'=>'TINDAKAN','class'=>'headtable','colspan'=>2);
			
			$this->table->set_heading($hno,$hnama,$hnpp,$hcabang,$hjab,$hact);
			
			$staf= $this->PegawaiModel->staf_db($peg_id);
			
			//Form pegawai
			
			$input_nama= '<input type="text" name="pegawai" id="pegawai" size="30" maxlength="30" title="Edit Nama Pegawai" value="'.$staf->nama.'"/>
			<input type="hidden" name="peg_id" value="'.$staf->peg_id.'"/>';
			$input_npp= '<input type="text" name="npp" id="npp" size="10" maxlength="15" title="Input NPP Pegawai" value="'.$staf->npp.'"/>';
			
			$cabang_load= $this->SenkasSuperModel->senkas();
			$list_cabang= '';
			if(!empty($cabang_load))
			{
				
				foreach($cabang_load as $cabang)
				{
					if($staf->cabang_id == $cabang->id)
					{
						$list_cabang.='<option value="'.$cabang->id.'" selected="selected">'.$cabang->cabang.'</option>';
					}
					{
					$list_cabang.='<option value="'.$cabang->id.'">'.$cabang->cabang.'</option>';
					}
				}
			}
			$select_cabang= '<select name="cabang" id="cabang" style="width:100%">'.$list_cabang.'</select>';
			
			$listjabatan='';
			
			$jab[1]= 'Koordinator';
			$jab[2]= 'Wakil Koordinator';
			$jab[3]= 'Staf';
			$jab[4]= 'Pengemudi';
			for($i=1; $i<=4 ;$i++)
			{
				if($staf->jabatan == $i){ $listjabatan .= '<option value="'.$i.'" selected="selected">'.$jab[$i].'</optio>';}
				else{$listjabatan .='<option value="'.$i.'">'.$jab[$i].'</option>';}
			}
			
			$select_jabatan='<select name="jabatan" id="jabatan" style="width:100%">'.$listjabatan.'</select>';
			$submit='<input type="image" src="'.base_url('images/icon_update.png').'" alt="submit" class="submit" title="Update"';
			
			$cinp_nama= array('data'=>$input_nama,'class'=>'isi tengah');
			$cinp_npp= array('data'=>$input_npp,'class'=>'isi tengah');
			$csel_cab= array('data'=>$select_cabang,'class'=>'isi tengah');
			$csel_jab= array('data'=>$select_jabatan,'class'=>'isi tengah');
			$csub= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$this->table->add_row('',$cinp_nama,$cinp_npp,$csel_cab,$csel_jab,$csub);
			
			
			
			$data= array(
				'table'=>$this->table->generate(),
				'path'=>'Parameter > Pegawai > Daftar > Edit',
				'actionpage'=>site_url('supervisor/pegawai/editprocess'),
				'contain'=>'content/tableplusinput',
				'navigation'=> 'navigation/supervisor_nav',
				'menu1'=>'active',
				'javacode'=>'<script type="text/javascript" src="'.base_url('js/supervisor/pegawai.js').'"></script>'
			);
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$nama_peg= strtoupper($this->input->post('pegawai'));
			$npp_peg= $this->input->post('npp');
			$peg_id= $this->input->post('peg_id');
			$cabang= $this->input->post('cabang');
			$jabatan= $this->input->post('jabatan');
			
			$this->PegawaiModel->update_pegawai($nama_peg,$npp_peg,$peg_id,$cabang,$jabatan);
			
			$this->session->set_userdata('message_error','Nama '.$nama_peg.' Berhasil Diupdate !');
			redirect('supervisor/pegawai');
		}
		else{redirect('loginonline');}
	}
	
	function remove($peg_id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->session->set_userdata('message_error','Still Under Construction !');
			redirect('supervisor/pegawai');
		}
		else{redirect('loginonline');}
	}
}
?>