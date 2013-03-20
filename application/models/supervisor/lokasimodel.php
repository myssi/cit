<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LokasiModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function insert_lokasi($nasabah,$lokasi,$kota,$idcabang)
	{
		$kueri= $this->db->get_where('lokasi',array('idnasabah'=>$nasabah,'lokasi'=>$lokasi,'kota'=>$kota),1,0);
		
		if($kueri->num_rows() > 0)
		{
			$this->session->set_userdata('message_error','Lokasi '.$lokasi.' Sudah Ada Dikota '.$kota);
		}
		else
		{
			$qkelolah= $this->db->get_where('lokasi',array('idnasabah'=>$nasabah,'lokasi'=>$lokasi,'kota'=>$kota,'idcabang'=>$idcabang),1,0);
			$qcab= $this->db->get_where('tbcabang',array('idcabang'=>$idcabang),1,0)->row()->cabang;
			if($qkelolah->num_rows() > 0)
			{
				$this->session->set_userdata('message_error','Lokasi '.$lokasi.' Dikota '.$kota.' Sudah Ada Dikelola '.$qcab);
			}
			else
			{
				//saving
				$data= array('idnasabah'=>$nasabah,'lokasi'=>$lokasi,'kota'=>$kota,'idcabang'=>$idcabang);
				$this->db->insert('lokasi',$data);
			}
		}
	}
	
	function lokasi_all()
	{
		$this->db->select('lokasi.*,tbcabang.cabang,nasabah.nasabah');
		$this->db->from('lokasi');
		$this->db->join('tbcabang','lokasi.idcabang = tbcabang.idcabang');
		$this->db->join('nasabah','lokasi.idnasabah = nasabah.idnasabah');
		$this->db->order_by('lokasi','asc');
		return $this->db->get()->result();
	}
	
	function lokasi_ld($id)
	{
		$this->db->select('lokasi.*,tbcabang.*');
		$this->db->from('lokasi');
		$this->db->join('tbcabang','lokasi.idcabang = tbcabang.idcabang');
		$this->db->where('lokasi.idlokasi',$id);
		return $this->db->get()->row();
	}
	
	function lokasi_nasabah($id)
	{
		$this->db->select('lokasi.*,tbcabang.*,nasabah.*');
		$this->db->from('lokasi');
		$this->db->join('tbcabang','lokasi.idcabang = tbcabang.idcabang');
		$this->db->join('nasabah','lokasi.idnasabah = nasabah.idnasabah');
		$this->db->where('lokasi.idlokasi',$id);
		return $this->db->get()->row();
	}
	
	function update_lokasi($id,$nasabah,$lokasi,$kota,$cabang)
	{
		$this->db->select('*');
		$this->db->from('lokasi');
		$this->db->where('lokasi',$lokasi);
		$this->db->where('kota',$kota);
		$this->db->where('idnasabah',$nasabah);
		$this->db->where('idcabang',$cabang);
		$hit= $this->db->get();
		
		// Check Kota and Lokasi
		if($hit->num_rows() > 0 ){ return FALSE; }
		else
		{
			$data= array('lokasi'=>$lokasi,'kota'=>$kota,'idcabang'=>$cabang);
			$this->db->where('idlokasi',$id);
			$this->db->update('lokasi',$data);
			return TRUE;
		}
	}
	
	function delete_lokasi($id)
	{
		$this->db->where('idlokasi',$id);
		$this->db->delete('lokasi');
	}
}
?>