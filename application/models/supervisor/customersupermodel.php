<?php 
class CustomerSuperModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	function saveadd($nama,$singkat)
	{
		$query= $this->db->get_where('bank',array('nama'=>$nama),1,0);
		if($query->num_rows > 0){return TRUE;}
		{
			$que= $this->db->get_where('bank',array('singkatan'=>$singkat),1,0);
			if($que->num_rows > 0 ){return TRUE;}
			else
			{
				$this->db->insert('bank',array('nama'=>$nama,'singkatan'=>$singkat));
				return FALSE;
			}
		}
	}
	
	function nasabah($id)
	{
		$query= $this->db->get_where('bank',array('idbank'=>$id),1,0);
		return $query->row();
	}
	
	function updatebank($nama,$singkat,$id)
	{
		$this->db->where('idbank',$id);
		$this->db->update('bank',array('nama'=>$nama,'singkatan'=>$singkat));
	}
	
	function listbank()
	{
		return $this->db->query('select * from bank order by nama')->result();
	}
	
	function loaddivisi()
	{
		return $this->db->query('select tbdivisi.iddivisi,tbdivisi.divisi,bank.nama from tbdivisi join bank on tbdivisi.idbank = bank.idbank order by divisi')->result();
		
	}
	
	function divsingle($id)
	{
		$this->db->select('*');
		$this->db->from('tbdivisi');
		$this->db->where('iddivisi',$id);
		return $this->db->get()->row();
	}
	
	function divisiadd($id,$nama)
	{
		$data= array(
		'idbank'=>$id,
		'divisi'=>$nama
		);
		
		$this->db->insert('tbdivisi',$data);
		return TRUE;
	}
	
	function updatedivisi($divisi,$customer,$id)
	{
		$data= array(
		'divisi'=>$divisi,
		'idbank'=>$customer
		);
		
		$this->db->where('iddivisi',$id);
		$this->db->update('tbdivisi',$data);
	}
	
}
?>