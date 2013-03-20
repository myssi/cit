<?php 
class SettinganModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function level()
	{
		$username= $this->session->userdata('username');
		
		$level_que= $this->db->get_where('tbuser',array('username'=>$username),1,0)->row();
		
		return $level_que;
	}
	
	function checkpass($passold)
	{
		$password= md5($passold);
		$username= $this->session->userdata('username');
		$querypass= $this->db->get_where('tbuser',array('username'=>$username,'password'=>$password),1,0);
		
		if($querypass->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
	
	function updatepass($newpass)
	{
		$username= $this->session->userdata('username');
		$password= md5($newpass);
		$this->db->where('username',$username);
		$this->db->update('tbuser',array('password'=>$password));
	}
}
?>