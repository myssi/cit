<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class OlahModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function divisi($bank)
	{
		$this->db->select('iddivisi,divisi');
		$this->db->from('tbdivisi');
		$this->db->where('idbank',$bank);
		
		return $this->db->get()->result();
	}
	
	function allviewdata()
	{
		$sql="select olahnasabah.*,bank.singkatan,tbdivisi.divisi,nasabah.nasabah,tbcabang.cabang from olahnasabah join bank on olahnasabah.idbank = bank.idbank join tbdivisi 
		on olahnasabah.iddivisi = tbdivisi.iddivisi join nasabah on olahnasabah.idnasabah = nasabah.idnasabah join tbcabang on olahnasabah.idcabang = tbcabang.idcabang";
		
		return $this->db->query($sql)->result();
	}
	
	function simpanolah($nasabah,$bank,$divisi,$cabang)
	{
		$query= $this->db->get_where('olahnasabah',array('idnasabah'=>$nasabah,'idcabang'=>$cabang),1,0);
		
		if($query->num_rows > 0)
		{
			return FALSE;
		}
		else
		{
			$data= array(
			'idnasabah'=>$nasabah,
			'idbank'=>$bank,
			'iddivisi'=>$divisi,
			'idcabang'=>$cabang,
			'upflag'=>0
			);
			
			$this->db->insert('olahnasabah',$data);
			return TRUE;
		}
	}
	
	function edit_olah($id)
	{
		$this->db->select('olahnasabah.*,bank.*,tbdivisi.*,nasabah.*,tbcabang.*');
		$this->db->from('olahnasabah');
		$this->db->join('bank','olahnasabah.idbank = bank.idbank');
		$this->db->join('tbdivisi','olahnasabah.iddivisi = tbdivisi.iddivisi');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->join('tbcabang','olahnasabah.idcabang = tbcabang.idcabang');
		$this->db->where('olahnasabah.id',$id);
		return $this->db->get()->row();
		
	}
	
	function namenasabah($id)
	{
		$this->db->select('nasabah.nasabah');
		$this->db->from('olahnasabah');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->where('olahnasabah.id',$id);
		return $this->db->get()->row();
	}
	
	function update_olah($id,$bank,$divisi,$cabang,$status)
	{
		
		$que= $this->db->get_where('olahnasabah',array('id'=>$id),1,0)->row();
		
		$idcustomer= $que->idnasabah;
		
		if($status == 1)
		{
			$this->db->where('id',$id);
			$this->db->update('olahnasabah',array('upflag'=>0));
		}
		
		$this->db->select('*');
		$this->db->from('olahnasabah');
		$this->db->where('idnasabah',$idcustomer);
		$this->db->where('idcabang',$cabang);
		$check= $this->db->get()->num_rows();
		$getname_nasabah= $this->namenasabah($id);
		
		if($check > 1)
		{
			
			$this->session->set_userdata('message_error',$getname_nasabah->nasabah.' Gagal Diupdate !');
		}
		else
		{
			$data= array(
			'idbank'=>$bank,
			'iddivisi'=>$divisi,
			'idcabang'=>$cabang
			);
			
			$this->db->where('id',$id);
			$this->db->update('olahnasabah',$data);
			
			$this->session->set_userdata('message_error',$getname_nasabah->nasabah.' Berhasil Diupdate !');
		}
		
	}
}
?>