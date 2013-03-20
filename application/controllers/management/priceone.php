<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PriceOne extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		
		
		$this->load->model('management/PriceOneModel','',TRUE);
	}
	
	function index()
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			//for menu show customer
			$data['tipe1']= $this->PriceOneModel->hargatipe1();
			
			$data['path']= 'Index';
			
			$data['contain']='content/pagemain';
			$data['navigation']= 'navigation/management';
			//$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
	
	function report($id)
	{
		if($this->session->userdata('loginlogic') == TRUE)
		{
			//
			
			//for menu show customer
			$data['tipe1']= $this->PriceOneModel->hargatipe1();
			
			$data['path']= 'Non Sortir > ';
			
			$data['contain']='content/pagemain';
			$data['navigation']= 'navigation/management';
			$data['menu1']= 'active';
			$this->load->view('template_warkat',$data);
		}
		else{redirect('loginonline');}
	}
}
?>