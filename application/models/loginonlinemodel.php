<?php 
class LoginOnlineModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function checkuser($username,$password,$ipaddress)
	{
		$query= $this->db->get_where('tbuser',array('username'=>$username,'password'=>$password),1,0);
		
		if($query->num_rows() > 0)
		{
			$sql="update tbuser set ipaddress= ?,jam= now(), tanggal= now() where username= ? and password= ?";
			$this->db->query($sql,array($ipaddress,$username,$password));
			
			return TRUE;
		}
		else{ return FALSE;}
	}
	
	function levelgrup($username,$password)
	{
		$query= $this->db->get_where('tbuser',array('username'=>$username,'password'=>$password),1,0);
		
		if($query->num_rows() > 0){ $level= $query->row()->grup_level;}
		else{$level= 0;}
		
		return $level;
	}
	
	function cabang($username,$password)
	{
		$kueri= $this->db->get_where('tbuser',array('username'=>$username,'password'=>$password),1,0);
		if($kueri->num_rows() > 0){ return $kueri->row()->id_cabang;}
		else{ return 1000;}
	}
}
?>