<?php
class PriceOneModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function hargatipe1()
	{
		$this->db->select('hargatipe1.*,nasabah.nasabah');
		$this->db->from('hargatipe1');
		$this->db->join('nasabah','hargatipe1.idnasabah = nasabah.idnasabah');
		$this->db->order_by('nasabah.nasabah','asc');
		return $this->db->get()->result();
	}
}
?>