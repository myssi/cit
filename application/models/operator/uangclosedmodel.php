<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UangClosedModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function code_cab($id)
	{
		$this->db->select('idcabang');
		$this->db->from('tbcabang');
		$this->db->where('id',$id);
		return $this->db->get()->row()->idcabang;
	}
	
	function customerld($code)
	{
		$this->db->select('nasabah.*');
		$this->db->from('olahnasabah');
		$this->db->join('nasabah','olahnasabah.idnasabah = nasabah.idnasabah');
		$this->db->where('idcabang',$code);
		$this->db->order_by('nasabah.nasabah','asc');
		return $this->db->get()->result();
	}
	
	function load_staf()
	{
		$cabang_id= $this->session->userdata('cabang_id');
		$this->db->select('*');
		$this->db->from('pegawai');
		$this->db->where('cabang_id',$cabang_id);
		$this->db->where('jabatan',3);
		$this->db->order_by('nama','asc');
		return $this->db->get()->result();
	}
	
/*==================== record process ===============*/

	function check_sppu($sppu,$cabang_id,$tablename)
	{
		$kuery= $this->db->get_where($tablename,array('sppu'=>$sppu,'cabang_id'=>$cabang_id),1,0);
		
		if($kuery->num_rows() > 0){return TRUE;}
		else{return FALSE;}
	}
/*================== Sortir Process =====================*/	
	function insert_sortir_good($sppu,$nasabah_id,$cabang_id,$de_100rb,$de_50rb,$de_20rb,$de_10rb,$de_5rb,$de_2rb,$de_1rb,$dcoin_1000,$dcoin_500,$dcoin_200,$dcoin_100,$dcoin_50,$dcoin_25)
	{
		$data= array(
		'sppu'=>$sppu,
		'nasabah_id'=>$nasabah_id,
		'cabang_id'=>$cabang_id,
		'g100rb'=>$de_100rb,
		'g50rb'=>$de_50rb,
		'g20rb'=>$de_20rb,
		'g10rb'=>$de_10rb,
		'g5rb'=>$de_5rb,
		'g2rb'=>$de_2rb,
		'g1rb'=>$de_1rb,
		'gc1000'=>$dcoin_1000,
		'gc500'=>$dcoin_500,
		'gc200'=>$dcoin_200,
		'gc100'=>$dcoin_100,
		'gc50'=>$dcoin_50,
		'gc25'=>$dcoin_25
		);
		
		$this->db->insert('sortir_good',$data);
	}
	
	function insert_sortir_bad($sppu,$nasabah_id,$cabang_id,$ng_100rb,$ng_50rb,$ng_20rb,$ng_10rb,$ng_5rb,$ng_2rb,$ng_1rb,$ngc_1rb,$ngc_500,$ngc_200,$ngc_100,$ngc_50,$ngc_25)
	{
		$data= array(
		'sppu'=>$sppu,
		'nasabah_id'=>$nasabah_id,
		'cabang_id'=>$cabang_id,
		'b100rb'=>$ng_100rb,
		'b50rb'=>$ng_50rb,
		'b20rb'=>$ng_20rb,
		'b10rb'=>$ng_10rb,
		'b5rb'=>$ng_5rb,
		'b2rb'=>$ng_2rb,
		'b1rb'=>$ng_1rb,
		'bc1000'=>$ngc_1rb,
		'bc500'=>$ngc_500,
		'bc200'=>$ngc_200,
		'bc100'=>$ngc_100,
		'bc50'=>$ngc_50,
		'bc25'=>$ngc_25
		);
		
		$this->db->insert('sortir_bad',$data);
	}
	
/*==================== Brangkas Sum ===========================*/	
	function in_brangkas($nasabah_id,$cabang_id,$total)
	{
		$kueri= $this->db->get_where('brangkas_uang',array('nasabah_id'=>$nasabah_id,'cabang_id'=>$cabang_id),1,0);
		
		if($kueri->num_rows() > 0)
		{
			//sum brangkas
			$brangkas_id= $kueri->row()->brangkas_id;
			$total_brangkas= $kueri->row()->total_brangkas;
			$total=$total_brangkas+$total;
			
			$this->db->where('brangkas_id',$brangkas_id);
			$this->db->update('brangkas_uang',array('total_brangkas'=>$total));
		}
		else
		{
			$data= array(
			'nasabah_id'=>$nasabah_id,
			'cabang_id'=>$cabang_id,
			'total_brangkas'=>$total
			);
			
			$this->db->insert('brangkas_uang',$data);
		}
	}
	
/*==================== Brangkas Sub ===========================*/
	function out_brangkas($nasabah_id,$cabang_id,$total)
	{
		$kueri= $this->db->get_where('brangkas_uang',array('nasabah_id'=>$nasabah_id,'cabang_id'=>$cabang_id),1,0);
		
		if($kueri->num_rows() > 0)
		{
			$brangkas_id= $kueri->row()->brangkas_id;
			$total_brangkas= $kueri->row()->total_brangkas;
			
			if($total > $total_brangkas) // If withdrawn more in Brangkas
			{
				$this->session->set_userdata('message_error','Total Penarikan Lebih Besar Dari Total Brangkas');
				return FALSE;
			}
			else
			{
				$total= $total_brangkas-$total;
			
				$this->db->where('brangkas_id',$brangkas_id);
				$this->db->update('brangkas_uang',array('total_brangkas'=>$total));
				return TRUE;
			}
		}
		else
		{
			$this->session->set_userdata('message_error','Pengambilan Tidak Dapat Lakukan Bila Brangkas Kosong !');
			return FALSE;
		}
	}

/*=================== Histori Transaction Brangkas ==============*/
	function histori($sppu,$nasabah_id,$cabang_id,$total,$alur)
	{
		$sql= "insert into histori_brangkas(sppu,nasabah_id,cabang_id,jumlah,in_out,tanggal) values(?,?,?,?,?,now())";
		$this->db->query($sql,array($sppu,$nasabah_id,$cabang_id,$total,$alur));
	}
	
/*=================== SPPU Save ==============*/
	function sppu_uang_save($sppu,$nasabah_id,$cabang_id,$asal,$tujuan,$staff,$status_adhoc,$ambil,$status_sppu,$status_brangkas,$status_sortir,$tanggal_closed,$brkt,$brkt_serah,$tiba,$tiba_serah,$remis)
	{
		$berangkat= $brkt.' - '.$brkt_serah;
		$ttiba= $tiba.' - '.$tiba_serah;
		$tanggal= date('Y-m-d',strtotime($tanggal_closed));
		$sql="insert into sppu_uang(sppu,nasabah_id,cabang_id,staff_npp,status_sppu,status_brangkas,status_sortir,status_ambil,tanggal_input,tanggal_closed,berangkat,tiba,asal_id,tujuan_id,status_adhoc,remis)
		 values(?,?,?,?,?,?,?,?,now(),?,?,?,?,?,?,?)";
		$this->db->query($sql,array($sppu,$nasabah_id,$cabang_id,$staff,$status_sppu,$status_brangkas,$status_sortir,$ambil,$tanggal,$berangkat,$ttiba,$asal,$tujuan,$status_adhoc,$remis));
	}

/*=================== Direct Closed SPPU ==============*/	
	function direct_closed_sortir($sppu,$nasabah_id,$cabang_id,$de_100rb,$de_50rb,$de_20rb,$de_10rb,$de_5rb,$de_2rb,$de_1rb,$dcoin_1000,$dcoin_500,$dcoin_200,$dcoin_100,$dcoin_50,$dcoin_25,$total)
	{
		$data= array(
		'sppu'=>$sppu,
		'nasabah_id'=>$nasabah_id,
		'cabang_id'=>$cabang_id,
		'd100rb'=>$de_100rb,
		'd50rb'=>$de_50rb,
		'd20rb'=>$de_20rb,
		'd10rb'=>$de_10rb,
		'd5rb'=>$de_5rb,
		'd2rb'=>$de_2rb,
		'd1rb'=>$de_1rb,
		'dc1000'=>$dcoin_1000,
		'dc500'=>$dcoin_500,
		'dc200'=>$dcoin_200,
		'dc100'=>$dcoin_100,
		'dc50'=>$dcoin_50,
		'dc25'=>$dcoin_25,
		'total'=>$total
		);
		
		$this->db->insert('direct_closed',$data);
	}
}
?>