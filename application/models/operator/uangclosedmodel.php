<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UangClosedModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function code_cab($id)
	{
		$this->db->select('idcabang');
		$this->db->from('tbcabang');
		$this->db->where('id',$id);
		return $this->db->get()->row()->idcabang;
	}
	
	function customerld($code)
	{
		$this->db->select('nasabah.*');
		$this->db->from('olahnasabah');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->where('idcabang',$code);
		$this->db->order_by('nasabah.nasabah','asc');
		return $this->db->get()->result();
	}
	
	function load_staf()
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$this->db->select('*');
		$this->db->from('pegawai');
		$this->db->where('cabang_id',$cabang_id);
		$this->db->where('jabatan',3);
		$this->db->order_by('nama','asc');
		return $this->db->get()->result();
	}
}
?>