<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HargaTripModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function harga_perlokasi($idlokasi)
	{
		$query_harga= $this->db->get_where('hargalokasi',array('idlokasi'=>$idlokasi),1,0);
		
		if($query_harga->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
	
	function insert_harga($idlokasi,$harga,$tanggal)
	{
		$qharga= $this->db->get_where('hargalokasi',array('idlokasi'=>$idlokasi,'harga'=>$harga),1,0);
		
		if($qharga->num_rows() > 0)
		{
			$this->session->set_userdata('message_error','Lokasi Ini Sudah Ada Harganya !');
		}
		else
		{
			$laku_tgl= date('Y-m-d',strtotime($tanggal));
			$data= array(
			'idlokasi'=>$idlokasi,
			'harga'=>$harga,
			'tglberlaku'=>$laku_tgl
			);
			
			$this->db->insert('hargalokasi',$data);
			
			$this->session->set_userdata('message_error','Harga Lokasi Berhasil Disimpan !');
		}
	}
	
	function all_trip_harga()
	{
		$this->db->select('hargalokasi.*,lokasi.lokasi,lokasi.kota,nasabah.nasabah,tbcabang.cabang');
		$this->db->from('hargalokasi');
		$this->db->join('lokasi','hargalokasi.idlokasi = lokasi.idlokasi');
		$this->db->join('nasabah','lokasi.idnasabah = nasabah.idnasabah');
		$this->db->join('tbcabang','lokasi.idcabang = tbcabang.idcabang');
		return $this->db->get()->result();
	}
	
	function delete_lokasi_harga($id)
	{
		$this->db->where('idhargalokasi',$id);
		$this->db->delete('hargalokasi');
		
		$this->session->set_userdata('message_error','Data Berhasil Dihapus !');
	}
	
	function lokasi_harga($id)
	{
		$this->db->select('hargalokasi.*,lokasi.lokasi,lokasi.kota,nasabah.nasabah,tbcabang.cabang');
		$this->db->from('hargalokasi');
		$this->db->join('lokasi','hargalokasi.idlokasi = lokasi.idlokasi');
		$this->db->join('nasabah','lokasi.idnasabah = nasabah.idnasabah');
		$this->db->join('tbcabang','lokasi.idcabang = tbcabang.idcabang');
		$this->db->where('hargalokasi.idhargalokasi',$id);
		return $this->db->get()->row();
		
		/*$this->db->get();
		echo $this->db->last_query();
		exit();*/
	}
	
	function updateharga($idharga,$harga,$tanggal)
	{
		$tgl= date('Y-m-d',strtotime($tanggal));
		$qharga= $this->db->get_where('hargalokasi',array('idhargalokasi'=>$idharga,'harga'=>$harga,'tglberlaku'=>$tgl),1,0);
		
		if($qharga->num_rows() < 1)
		{
			$this->db->where('idhargalokasi',$idharga);
			$this->db->update('hargalokasi',array('harga'=>$harga,'tglberlaku'=>$tgl));
		
			$this->session->set_userdata('message_error','Harga Berhasil diupdate !');
		}
	}
}
?>