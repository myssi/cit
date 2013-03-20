<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PegawaiModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function nama_check($nama,$cab)
	{
		$kueri= $this->db->get_where('pegawai',array('nama'=>$nama,'cabang_id'=>$cab),1,0);
		
		if($kueri->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
	
	function insert_baru_peg($nama,$npp,$cabang,$jabatan)
	{
		$data= array(
		'nama'=>$nama,
		'npp'=>$npp,
		'jabatan'=>$jabatan,
		'cabang_id'=>$cabang,
		'aktif'=>1
		);
		
		$this->db->insert('pegawai',$data);
	}
	
	function peg_load()
	{
		$this->db->select('pegawai.*,tbcabang.cabang');
		$this->db->from('pegawai');
		$this->db->join('tbcabang','pegawai.cabang_id = tbcabang.id');
		$this->db->order_by('tbcabang.cabang','asc');
		return $this->db->get()->result();
	}
}
?>