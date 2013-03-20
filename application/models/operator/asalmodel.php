<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AsalModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function load_asal()
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$this->db->select('*');
		$this->db->from('asal_lokasi');
		$this->db->where('cabang_id',$cabang_id);
		$this->db->order_by('asal','asc');
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
		$this->db->select('*')->from('asal_lokasi')->where('asal_id',$id);
		return $this->db->get()->row();
	}
	
	function update_asal($asal,$asal_id)
	{
		$this->db->where('asal_id',$asal_id);
		$this->db->update('asal_lokasi',array('asal'=>$asal));
	}
	
	function delete_asal($asal_id)
	{
		$this->db->where('asal_id',$asal_id);
		$this->db->delete('asal_lokasi');
	}
	
}
?>