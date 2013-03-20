<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class TujuanModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function load_tujuan()
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$this->db->select('*');
		$this->db->from('tujuan_lokasi');
		$this->db->where('cabang_id',$cabang_id);
		$this->db->order_by('tujuan','asc');
		return $this->db->get()->result();
	}
	
	function check_lokasi($lokasi,$tblokasi,$name_colom)
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$query= $this->db->get_where($tblokasi,array($name_colom=>$lokasi,'cabang_id'=>$cabang_id),1,0);
		
		if($query->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
	
	function insert_lokasi($lokasi,$tblokasi,$name_colom)
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$data= array(
			$name_colom => $lokasi,
			'cabang_id'=>$cabang_id
		);
		
		$this->db->insert($tblokasi,$data);
	}
	
	function asalnm($id)
	{
		$this->db->select('*')->from('tujuan_lokasi')->where('tujuan_id',$id);
		return $this->db->get()->row();
	}
	
	function update_tujuan($asal,$asal_id)
	{
		$this->db->where('tujuan_id',$asal_id);
		$this->db->update('tujuan_lokasi',array('tujuan'=>$asal));
	}
	
	function delete_tujuan($asal_id)
	{
		$this->db->where('tujuan_id',$asal_id);
		$this->db->delete('tujuan_lokasi');
	}
	
}
?>