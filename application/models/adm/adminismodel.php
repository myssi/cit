<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AdminisModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function userload()
	{
		$this->db->select('*');
		$this->db->from('tbuser');
		$this->db->order_by('grup_level','asc');
		return $this->db->get()->result();
	}
	
	function name_cabang($idcabang)
	{
		$this->db->select('tbcabang.cabang');
		$this->db->from('tbcabang');
		$this->db->where('id',$idcabang);
		return $this->db->get()->row()->cabang;
	}
	
	function listcabang()
	{
		$this->db->select('*');
		$this->db->from('tbcabang');
		$this->db->order_by('cabang','asc');
		return $this->db->get()->result();
	}
	
	function check_exist($username)
	{
		$kueri= $this->db->get_where('tbuser',array('username'=>$username),1,0);
		
		if($kueri->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
	
	function insert_username($username,$password,$level,$cabang)
	{
		$data= array(
		'username'=>$username,
		'password'=>$password,
		'grup_level'=>$level,
		'id_cabang'=>$cabang
		);
		
		$this->db->insert('tbuser',$data);
	}
	
	function delete_user($id)
	{
		$this->db->where('user_id',$id);
		$this->db->delete('tbuser');
	}
}
?>