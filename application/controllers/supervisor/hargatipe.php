<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class HargaTipe extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('supervisor/HargaTipeModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$templatetable= array(
				'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
				'row_alt_start'=>'<tr class="zebra">',
				'row_alt_end'=>'</tr>',
				'table_close'=>'</table>'
			);
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");
			$i=0;
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>'200');
			$hharga= array('data'=>'Harga Per Trip','class'=>'headtable');
			$hadhoc= array('data'=>'Faktor Adhoc','class'=>'headtable');
			$hmulai= array('data'=>'Sejak Tanggal','class'=>'headtable','width'=>'210');
			$haction= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			
			$this->table->set_heading($hno,$hnasabah,$hharga,$hadhoc,$hmulai,$haction);
			$nasabah= $this->HargaTipeModel->nasabahlist();
			$listnas='';
			foreach($nasabah as $nas)
			{
				//check if nasabah on list hargatipe1
				if($this->HargaTipeModel->checknas($nas->idnasabah) == FALSE)
				{
					$listnas= $listnas.'<option value="'.$nas->idnasabah.'">'.$nas->nasabah.'</option>';
				}
			}
			$selectnasabah= '<select name="nasabah" id="nasabah" style="width:100%;" title="Pilih Salah Satu Nasabah">
				<option value="0" selected="selected">--Pilih Satu--</option>'.$listnas.'
			</select>';
			
			$selectadhoc= '<select name="adhoc" id="adhoc" style="width:100%" title="Pilih Faktor Adhoc">
				<option value="1.5" selected="selected">1.5</option>
				<option value="2">2</option>
			</select>';
			
			$inputharga='<input type="text" name="harga" id="harga" maxlength="30" size="30" title="Isi Harga Per Trip"/>';
			$inputsubmit='<input type="image" src="'.base_url('images/iconadd.gif').'" alt="submit" class="submit" title="Tambah Harga Trip"';
			$inputdate='<input type="text" name="tglharga" id="tglharga" size="30" title="Isi Tanggal Berlaku"/>';
			
			$cinp_select= array('data'=>$selectnasabah,'class'=>'isi tengah');
			$cinp_harga= array('data'=>$inputharga,'class'=>'isi tengah');
			$cinp_date= array('data'=>$inputdate,'class'=>'isi tengah');
			$cinp_adhoc= array('data'=>$selectadhoc,'class'=>'isi tengah');
			$cinp_submit= array('data'=>$inputsubmit,'colspan'=>2,'class'=>'isi tengah');
			
			$this->table->add_row('',$cinp_select,$cinp_harga,$cinp_adhoc,$cinp_date,$cinp_submit);
			
			$daftar_harga= $this->HargaTipeModel->listprice();
			if(!empty($daftar_harga))
			{
				foreach($daftar_harga as $harga)
				{
					$tanggal= date('d-m-Y',strtotime($harga->berlaku));
					$pricestr= $this->HargaTipeModel->tri_desimal($harga->hargapertrip);
					$act_edit= anchor('supervisor/hargatipe/edit/'.$harga->idht1,'Edit',array('class'=>'edit','title'=>'Edit Harga Nasabah'));
					$act_del= anchor('supervisor/hargatipe/delete/'.$harga->idht1,'Hapus',array('class'=>'delete','title'=>'Hapus Harga Nasabah'));
					
					$cell_no= array('data'=>++$i,'class'=>'isi tengah');
					$cell_nas= array('data'=>$harga->nasabah,'class'=>'isi kiri');
					$cell_price= array('data'=>$pricestr,'class'=>'isi tengah');
					$cell_tgl= array('data'=>$tanggal,'class'=>'isi tengah');
					$cell_edit= array('data'=>$act_edit,'class'=>'isi tengah');
					$cell_del= array('data'=>$act_del,'class'=>'isi tengah');
					$cell_adhoc= array('data'=>$harga->adhoc,'class'=>'isi tengah');
					
					$this->table->add_row($cell_no,$cell_nas,$cell_price,$cell_adhoc,$cell_tgl,$cell_edit,$cell_del);
				}
			}
			
			$data['path']= 'Harga > Paket';
			$data['table']= $this->table->generate();
			$data['actionpage']= site_url('supervisor/hargatipe/paketprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/hargatipe.js').'"></script>';
			
			$data['contain']='content/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function paketprocess()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->form_validation->set_rules('harga','price of trip','numeric');
			
			if($this->form_validation->run() == TRUE)
			{
				$nasabah= $this->input->post('nasabah');
				$harga= $this->input->post('harga');
				$adhoc= $this->input->post('adhoc');
				$tglberlaku= $this->input->post('tglharga');
				
				$this->HargaTipeModel->saveharga($nasabah,$harga,$tglberlaku,$adhoc);
				redirect('supervisor/hargatipe');
			}
			else
			{
				$this->session->set_userdata('message_error',form_error('harga'));
				redirect('supervisor/hargatipe');
			}
			
			
			
		}
		else{redirect('loginonline');}
	}
	
	function edit($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$templatetable= array(
			'table_open'=>'<table width="100%" border="1" cellpadding="0" cellspacing="0">',
			'table_close'=>'</table>'
			);
			
			$this->table->set_template($templatetable);
			$this->table->set_empty("&nbsp;");			
			
			$hno= array('data'=>'No','class'=>'headtable','width'=>40);
			$hnasabah= array('data'=>'Nasabah','class'=>'headtable','width'=>'200');
			$hharga= array('data'=>'Harga Per Trip','class'=>'headtable');
			$hadhoc= array('data'=>'Adhoc','class'=>'headtable');
			$hmulai= array('data'=>'Berlaku Sejak Tanggal','class'=>'headtable','width'=>'210');
			$haction= array('data'=>'Tindakan','colspan'=>2,'class'=>'headtable');
			
			//$this->table->add_row($hno,$hnasabah,$hharga,$hadhoc,$hmulai,$haction);
			$this->table->set_heading($hno,$hnasabah,$hharga,$hadhoc,$hmulai,$haction);
			
			$editharga= $this->HargaTipeModel->hargaedit($id);
			
			$tanggal= date('d-m-Y',strtotime($editharga->berlaku));
			
			if($editharga->adhoc == 1.5)
			{
				$listadhoc='
					<option value="'.$editharga->adhoc.'" selected="selected">'.$editharga->adhoc.'</option>
					<option value="2">2</option>
				';
			}
			else if($editharga->adhoc == 2)
			{
				$listadhoc='
					<option value="1.5">1.5</option>
					<option value="'.$editharga->adhoc.'" selected="selected">'.$editharga->adhoc.'</option>	
				';
			}
			else
			{
				$listadhoc='
					<option value="'.$editharga->adhoc.'" selected="selected">'.$editharga->adhoc.'</option>
					<option value="1.5">1.5</option>
					<option value="2">2</option>	
				';
			}
			
			$selectadhoc= '<select name="adhoc" id="adhoc" style="width:100%" title="Pilih Faktor Adhoc">'.$listadhoc.'</select>';
			
			$inputnasabah=$editharga->nasabah.'<input type="hidden" name="idharga" value="'.$editharga->idht1.'" />';
			$inputharga='<input type="text" name="harga" id="harga" maxlength="30" size="30" value="'.$editharga->hargapertrip.'" title="Isi Harga Per Trip"/>';
			$inputsubmit='<input type="image" src="'.base_url('images/sync.png').'" alt="submit" class="submit" title="Update Harga Trip"';
			$inputdate='<input type="text" name="tglharga" id="tglharga" size="30" title="Isi Tanggal Berlaku" value="'.$tanggal.'"/>';
			
			$cinp_nasabah= array('data'=>$inputnasabah,'class'=>'isi tengah');
			$cinp_harga= array('data'=>$inputharga,'class'=>'isi tengah');
			$cinp_date= array('data'=>$inputdate,'class'=>'isi tengah');
			$cinp_adhoc= array('data'=>$selectadhoc,'class'=>'isi tengah');
			$cinp_submit= array('data'=>$inputsubmit,'colspan'=>2,'class'=>'isi tengah');
			
			$this->table->add_row('',$cinp_nasabah,$cinp_harga,$cinp_adhoc,$cinp_date,$cinp_submit);
			
			$data['path']= 'Harga > '.anchor('supervisor/hargatipe','Paket').' > Edit';
			$data['table']= $this->table->generate();
			$data['actionpage']= site_url('supervisor/hargatipe/editprocess');
			$data['javacode']= '<script type="text/javascript" src="'.base_url('js/supervisor/hargatipe.js').'"></script>';
			
			$data['contain']='content/supervisor/tableplusinput';
			$data['navigation']= 'navigation/supervisor_nav';
			$data['menu2']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function delete($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			$this->session->set_userdata('message_error','This Page is Under Construction');
			redirect('supervisor/hargatipe');
		}
		else{redirect('loginonline');}
	}
	
	function editprocess()
	{
		$id= $this->input->post('idharga');
		$harga= $this->input->post('harga');
		$adhoc= $this->input->post('adhoc');
		$tanggal= $this->input->post('tglharga');
		
		$sharga= $this->HargaTipeModel->tri_desimal($harga);
		$stanggal= date('d M Y',strtotime($tanggal));
		$namenasabah= $this->HargaTipeModel->nasabahname($id);
		if($this->HargaTipeModel->update_price($id,$harga,$tanggal,$adhoc) == TRUE)
		{
			$this->session->set_userdata('message_error','Nasabah '.$namenasabah->nasabah.' berhasil diupdate dengan harga Rp '.$sharga.',-. Berlaku mulai tanggal '.$stanggal);
		}
		else
		{
			$this->session->set_userdata('message_error','Harga '.$namenasabah->nasabah.' gagal diupdate !');
		}
		
		redirect('supervisor/hargatipe');
	}
}
?>