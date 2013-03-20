<?php 
class SenkasSuperModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function simpansenkas($senkas,$kodesenkas)
	{
		$data= array(
		'idcabang'=>$kodesenkas,
		'cabang'=>$senkas
		);
		
		$this->db->insert('tbcabang',$data);
	}
	
	function senkas()
	{
		return $this->db->query('select * from tbcabang order by cabang')->result();
	}
	
	function loadsenkas($id)
	{
		return $this->db->select('*')->from('tbcabang')->where('id',$id)->get()->row();
	}
	
	function updatesenkas($nama,$kode,$id)
	{
		$data= array(
		'cabang'=>$nama,
		'idcabang'=>$kode
		);
		
		$this->db->where('id',$id)->update('tbcabang',$data);
	}
	
	function deletesenkas($id)
	{
		$this->db->where('id',$id)->delete('tbcabang');
	}
}
?>