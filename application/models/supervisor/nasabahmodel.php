<?php 
class NasabahModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function nasabahlist()
	{
		return $this->db->query('select * from nasabah order by nasabah')->result();
	}
	
	function savenasabah($nas)
	{
		//check if exist
		$query= $this->db->get_where('nasabah',array('nasabah'=>$nas),1,0);
		
		if($query->num_rows > 0){ return TRUE;}
		else
		{
			$data= array('nasabah'=>$nas);
			
			$this->db->insert('nasabah',$data);
			return FALSE;
		}
	}
	
	function anasabah($id)
	{
		$this->db->select('*');
		$this->db->from('nasabah');
		$this->db->where('idnasabah',$id);
		return $this->db->get()->row();
	}
	
	function editnasabah($id,$nama)
	{
		$this->db->where('idnasabah',$id);
		$this->db->update('nasabah',array('nasabah'=>$nama));
		$this->session->set_userdata('message_error','Data nasabah berhasil diupdate !');
	}
	
	function delete($id,$colomnm,$tablenm)
	{
		$this->db->where($colomnm,$id);
		$this->db->delete($tablenm);
		$this->session->set_userdata('message_error','Data Berhasil Dihapus !');
	}
}
?>