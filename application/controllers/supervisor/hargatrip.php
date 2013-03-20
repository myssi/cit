<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HargaTrip extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/LokasiModel','',TRUE);
		$this->load->model('supervisor/HargaTripModel','',TRUE);
		$this->load->model('supervisor/HargaTipeModel','',TRUE);
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
			
			//==================== Heading Table ==================================
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hlokasi= array('data'=>'Lokasi','class'=>'headtable');
			$hkota= array('data'=>'Kota','class'=>'headtable','width'=>175);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>175);
			$hcabang= array('data'=>'Pengelola','class'=>'headtable','width'=>165);
			$hharga= array('data'=>'Harga','class'=>'headtable','width'=>120);
			$htgl= array('data'=>'Berlaku Tanggal','class'=>'headtable','width'=>120);
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2,'width'=>110);
			
			$this->table->set_heading($hno,$hlokasi,$hkota,$hnasabah,$hcabang,$hharga,$htgl,$hact);
			
			//======================== Form Input Table ============================
			
			$load_lokasi= $this->LokasiModel->lokasi_all();
			
			$listlokasi= '<option value="0" selected="selected"> --- Pilih Lokasi --- </option>';
			if(!empty($load_lokasi))
			{
				foreach($load_lokasi as $lokasia)
				{
					if($this->HargaTripModel->harga_perlokasi($lokasia->idlokasi) == FALSE)
					{
						$listlokasi= $listlokasi.'<option value="'.$lokasia->idlokasi.'">'.$lokasia->lokasi.'</option>';
					}
				}
				$select_lokasi='<select name="lokasi" id="lokasi" title="Pilih Lokasi" style="width:100%;">'.$listlokasi.'</select>';
			}
			else
			{
				$select_lokasi='Data Lokasi Kosong !';
			}
			
			$input_harga='<input type="text" name="harga" id="harga" size="15" maxlength="10" title="Harga Per Trip"/>';
			$input_tgl= '<input type="text" name="tanggalberlaku" id="tanggalberlaku" size="15" maxlength="10" title="Tanggal Mulai Berlaku"/>';
			$submit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" id="sbsave" title="Simpan"';
			$cell_inp_submit= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			
			$cell_inp_lokasi= array('data'=>$select_lokasi,'class'=>'isi tengah');
			$cell_ajax_kota= array('data'=>'','class'=>'isi tengah','id'=>'kota');
			$cell_ajax_cabang= array('data'=>'','class'=>'isi tengah','id'=>'cabang');
			$cell_ajax_nasabah= array('data'=>'','class'=>'isi tengah','id'=>'nasabah');
			$cell_inp_harga= array('data'=>$input_harga,'class'=>'isi tengah');
			$cell_inp_tanggal= array('data'=>$input_tgl,'class'=>'isi tengah');
			
			$this->table->add_row('',$cell_inp_lokasi,$cell_ajax_kota,$cell_ajax_nasabah,$cell_ajax_cabang,$cell_inp_harga,$cell_inp_tanggal,$cell_inp_submit);
			
			//======================= Show Harga ===============================
			
			$lokhar_que= $this->HargaTripModel->all_trip_harga();
			
			if(!empty($lokhar_que))
			{
				$i= 0;
				
				foreach($lokhar_que as $lokhar)
				{
					$harga= $this->HargaTipeModel->tri_desimal($lokhar->harga);
					$tanggal= date('d-m-Y',strtotime($lokhar->tglberlaku));
					$edit_lok= anchor('supervisor/hargatrip/edit/'.$lokhar->idhargalokasi,'Edit',array('class'=>'edit'));
					$delete_lok= anchor('supervisor/hargatrip/delete/'.$lokhar->idhargalokasi,'Hapus',array('class'=>'delete','onclick'=>"return confirm('Anda Yakin Menghapus Lokasi ini ?')"));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_lokasi= array('data'=>$lokhar->lokasi,'class'=>'isi tengah');
					$cell_kota= array('data'=>$lokhar->kota,'class'=>'isi tengah');
					$cell_nasabah= array('data'=>$lokhar->nasabah,'class'=>'isi tengah');
					$cell_cabang= array('data'=>$lokhar->cabang,'class'=>'isi tengah');
					$cell_harga= array('data'=>$harga,'class'=>'isi tengah');
					$cell_tgl= array('data'=>$tanggal,'class'=>'isi tengah');
					$cell_edit= array('data'=>$edit_lok,'class'=>'isi tengah');
					$cell_delete= array('data'=>$delete_lok,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_lokasi,$cell_kota,$cell_nasabah,$cell_cabang,$cell_harga,$cell_tgl,$cell_edit,$cell_delete);
				}
			}
			
			$data['table']=$this->table->generate();
			$data['path']= 'Harga > Perjalanan';
			$data['actionpage']= site_url('supervisor/hargatrip/harga_process');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/hargatrip.js').'"></script>';
			$data['url']= '<input type="hidden" id="urlkota" value="'.site_url('supervisor/hargatrip/kota_ajax').'" /><input type="hidden" id="urlcabang" value="'.site_url('supervisor/hargatrip/cabang_ajax').'" />
			<input type="hidden" id="urlnasabah" value="'.site_url('supervisor/hargatrip/nasabah_ajax').'" />';
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function kota_ajax()
	{
		$idlokasi= $this->input->post('lokasi');
		
		$kota_load= $this->LokasiModel->lokasi_ld($idlokasi);
		if(!empty($kota_load))
		{
			$kota= $kota_load->kota;
		}
		else{$kota='';}
		
		echo $kota;
	}
	
	function cabang_ajax()
	{
		$idlokasi= $this->input->post('lokasi');
		
		$kota_load= $this->LokasiModel->lokasi_ld($idlokasi);
		if(!empty($kota_load))
		{
			$kota= $kota_load->cabang;
		}
		else{$kota='';}
		
		echo $kota;
	}
	
	function nasabah_ajax()
	{
		$idlokasi= $this->input->post('lokasi');
		
		$nas_load= $this->LokasiModel->lokasi_nasabah($idlokasi);
		if(!empty($nas_load))
		{
			$kota= $nas_load->nasabah;
		}
		else{$kota='';}
		
		echo $kota;
	}
	
	function harga_process()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$idlokasi= $this->input->post('lokasi');
			$harga= $this->input->post('harga');
			$tanggal= $this->input->post('tanggalberlaku');
			
			$this->HargaTripModel->insert_harga($idlokasi,$harga,$tanggal);
			redirect('supervisor/hargatrip');
			
		}
		else{redirect('loginonline');}
	}
	
	function delete($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->HargaTripModel->delete_lokasi_harga($id);
			redirect('supervisor/hargatrip');
		}
		else{redirect('loginonline');}
	}
	
	function edit($id)
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
			
			//==================== Heading Table ==================================
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hlokasi= array('data'=>'Lokasi','class'=>'headtable');
			$hkota= array('data'=>'Kota','class'=>'headtable','width'=>175);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>175);
			$hcabang= array('data'=>'Pengelola','class'=>'headtable','width'=>165);
			$hharga= array('data'=>'Harga','class'=>'headtable','width'=>120);
			$htgl= array('data'=>'Berlaku Tanggal','class'=>'headtable','width'=>120);
			$hact= array('data'=>'Tindakan','class'=>'headtable','colspan'=>2,'width'=>110);
			
			$this->table->set_heading($hno,$hlokasi,$hkota,$hnasabah,$hcabang,$hharga,$htgl,$hact);
			
			//========================= Form Edit ===========================================
			
			$harga_lokasi= $this->HargaTripModel->lokasi_harga($id);
			$tanggal= date('d-m-Y',strtotime($harga_lokasi->tglberlaku));
			$input_harga='<input type="text" name="harga" id="harga" size="15" maxlength="10" title="Harga Per Trip" value="'.$harga_lokasi->harga.'"/>
			<input type="hidden" name="idharga" id="idharga" value="'.$harga_lokasi->idhargalokasi.'"/>';
			$input_tgl= '<input type="text" name="tanggalberlaku" id="tanggalberlaku" size="15" maxlength="10" title="Tanggal Mulai Berlaku" value="'.$tanggal.'"/>';
			$submit='<input type="image" src="'.base_url('images/sync.png').'" alt="submit" class="submit" id="sbsave" title="Update"';
			
			$cell_inp_submit= array('data'=>$submit,'class'=>'isi tengah','colspan'=>2);
			$cell_inp_lokasi= array('data'=>$harga_lokasi->lokasi,'class'=>'isi tengah');
			$cell_ajax_kota= array('data'=>$harga_lokasi->kota,'class'=>'isi tengah');
			$cell_ajax_cabang= array('data'=>$harga_lokasi->cabang,'class'=>'isi tengah');
			$cell_ajax_nasabah= array('data'=>$harga_lokasi->nasabah,'class'=>'isi tengah');
			$cell_inp_harga= array('data'=>$input_harga,'class'=>'isi tengah');
			$cell_inp_tanggal= array('data'=>$input_tgl,'class'=>'isi tengah');
			
			$this->table->add_row('',$cell_inp_lokasi,$cell_ajax_kota,$cell_ajax_nasabah,$cell_ajax_cabang,$cell_inp_harga,$cell_inp_tanggal,$cell_inp_submit);
			
			$data['table']=$this->table->generate();
			$data['path']= 'Harga > '.anchor('supervisor/hargatrip','Perjalanan').' > Edit';
			$data['actionpage']= site_url('supervisor/hargatrip/edit_process');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/hargatrip.js').'"></script>';
			//$data['url']= '<input type="hidden" id="urlkota" value="'.site_url('supervisor/hargatrip/kota_ajax').'" /><input type="hidden" id="urlcabang" value="'.site_url('supervisor/hargatrip/cabang_ajax').'" />
			//<input type="hidden" id="urlnasabah" value="'.site_url('supervisor/hargatrip/nasabah_ajax').'" />';
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function edit_process()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$idhargalokasi= $this->input->post('idharga');
			$harga= $this->input->post('harga');
			$tanggal= $this->input->post('tanggalberlaku');
			
			$this->HargaTripModel->updateharga($idhargalokasi,$harga,$tanggal);
			redirect('supervisor/hargatrip');
		}
		else{ redirect('');}
	}
}
?>